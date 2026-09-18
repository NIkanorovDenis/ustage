<?php

declare(strict_types=1);

use Bitrix\Main\DB\Connection;
use Bitrix\Main\Loader;

return static function (Connection $connection): void {
    if (!Loader::includeModule('iblock')) {
        throw new RuntimeException('Cannot load iblock module.');
    }

    $iblockId = 32;
    $fields = [
        8652 => ['TIP_VG', 'Тип вращающейся головы', 'L'],
        8655 => ['TIP_TEATRALNOGO_PROJEKTORA', 'Тип театрального прожектора', 'L'],
        8656 => ['KOLICHESTVO_IS', 'Количество источников света', 'N'],
        8657 => ['CVET_LAZERA', 'Цвет лазера', 'L'],
        8658 => ['TIP_PRIBORA_', 'Тип прибора', 'L'],
    ];
    $enumUpdates = [
        1991 => [8652, 'PROFILE'],
        2011 => [8658, 'Строб'],
        2012 => [8658, 'BLINDER'],
    ];
    $instrumentTypeValues = [
        75343 => 2011, // old text: светодиодный световой эффект стробоскоп
        76394 => 2012, // old text: светодиодный RGB блиндер
    ];

    foreach ($fields as $propertyId => [$code, $title, $type]) {
        $property = $connection->query(
            'SELECT ID, CODE, PROPERTY_TYPE, ACTIVE FROM b_iblock_property '
            . 'WHERE ID = ' . $propertyId . ' AND IBLOCK_ID = ' . $iblockId
        )->fetch();
        if (!$property
            || (string) $property['CODE'] !== $code
            || (string) $property['PROPERTY_TYPE'] !== $type
            || (string) $property['ACTIVE'] !== 'Y'
        ) {
            throw new RuntimeException('Unexpected product property configuration: ' . $propertyId);
        }
    }

    foreach ($enumUpdates as $enumId => [$propertyId, $label]) {
        $enum = $connection->query(
            'SELECT ID FROM b_iblock_property_enum WHERE ID = ' . $enumId
            . ' AND PROPERTY_ID = ' . $propertyId
        )->fetch();
        if (!$enum) {
            throw new RuntimeException('Expected property enum is missing: ' . $enumId);
        }
    }

    $connection->startTransaction();
    try {
        $propertyApi = new CIBlockProperty();
        if (!$propertyApi->Update(8657, ['NAME' => 'Цвет лазера'])) {
            throw new RuntimeException('Cannot rename laser colour property.');
        }

        $enumApi = new CIBlockPropertyEnum();
        foreach ($enumUpdates as $enumId => [$propertyId, $label]) {
            if (!$enumApi->Update($enumId, ['VALUE' => $label])) {
                throw new RuntimeException('Cannot normalize property enum: ' . $enumId);
            }
        }

        // Root links make the fields available before a new product has a final section.
        foreach ($fields as $propertyId => $configuration) {
            $displayType = $configuration[2] === 'L' ? 'F' : 'A';
            $connection->queryExecute(
                'INSERT INTO b_iblock_section_property '
                . '(IBLOCK_ID, SECTION_ID, PROPERTY_ID, SMART_FILTER, DISPLAY_TYPE) VALUES ('
                . $iblockId . ', 0, ' . $propertyId . ", 'N', '" . $displayType . "') "
                . 'ON DUPLICATE KEY UPDATE PROPERTY_ID = VALUES(PROPERTY_ID)'
            );
        }

        // Preserve the old generic text property and migrate only unambiguous products.
        $migratedProducts = 0;
        foreach ($instrumentTypeValues as $productId => $enumId) {
            $exists = (int) $connection->queryScalar(
                'SELECT COUNT(*) FROM b_iblock_element WHERE ID = ' . $productId
                . ' AND IBLOCK_ID = ' . $iblockId
            );
            if ($exists === 0) {
                continue;
            }
            CIBlockElement::SetPropertyValuesEx($productId, $iblockId, [8658 => $enumId]);
            $migratedProducts++;
        }

        // Append the properties to every saved product form layout without resetting it.
        $options = $connection->query(
            "SELECT USER_ID, VALUE FROM b_user_option "
            . "WHERE CATEGORY = 'form' AND NAME = 'form_element_32'"
        );
        $updatedLayouts = 0;
        while ($row = $options->fetch()) {
            $value = @unserialize((string) $row['VALUE'], ['allowed_classes' => false]);
            if (!is_array($value) || !isset($value['tabs']) || !is_string($value['tabs'])) {
                throw new RuntimeException('Invalid product form layout for user ' . (int) $row['USER_ID']);
            }

            $tabs = $value['tabs'];
            $addition = '';
            foreach ($fields as $propertyId => $configuration) {
                if (strpos($tabs, 'PROPERTY_' . $propertyId . '--#--') !== false) {
                    continue;
                }
                $addition .= ',--PROPERTY_' . $propertyId . '--#--' . $configuration[1] . '--';
            }
            if ($addition === '') {
                continue;
            }

            $firstTabEnd = strpos($tabs, ';--');
            if ($firstTabEnd === false) {
                throw new RuntimeException('Cannot locate first product form tab for user ' . (int) $row['USER_ID']);
            }
            $value['tabs'] = substr($tabs, 0, $firstTabEnd)
                . $addition
                . substr($tabs, $firstTabEnd);

            $userId = (int) $row['USER_ID'];
            $saved = $userId === 0
                ? CUserOptions::SetOption('form', 'form_element_32', $value, true)
                : CUserOptions::SetOption('form', 'form_element_32', $value, false, $userId);
            if ($saved === false) {
                throw new RuntimeException('Cannot update product form layout for user ' . $userId);
            }
            $updatedLayouts++;
        }

        $connection->commitTransaction();
        echo 'Special light properties linked at catalogue root: ' . count($fields) . "\n";
        echo 'Product form layouts updated: ' . $updatedLayouts . "\n";
        echo 'Unambiguous instrument types migrated: ' . $migratedProducts . "\n";
    } catch (Throwable $error) {
        $connection->rollbackTransaction();
        throw $error;
    }
};

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
        8653 => ['ISTOCHNIK_SVETA', 'Источник света', 'L'],
        8656 => ['KOLICHESTVO_IS', 'Количество источников света', 'N'],
        8654 => ['STEPEN_ZASHITY', 'Степень защиты', 'L'],
        2353 => ['MOSNOST_ISTOCNIKA_SVETA', 'Мощность источника света, Вт', 'N'],
        8555 => ['Mosnost_W', 'Максимальная потребляемая мощность, Вт', 'N'],
        8608 => ['TIP_CVETOSMESENIA_PRIBORA', 'Тип цветосмешения прибора', 'L'],
    ];

    foreach ($fields as $propertyId => [$code, $title, $type]) {
        $property = $connection->query(
            'SELECT ID, CODE, NAME, PROPERTY_TYPE, ACTIVE FROM b_iblock_property '
            . 'WHERE ID = ' . $propertyId . ' AND IBLOCK_ID = ' . $iblockId
        )->fetch();
        if (!$property
            || (string) $property['CODE'] !== $code
            || (string) $property['NAME'] !== $title
            || (string) $property['PROPERTY_TYPE'] !== $type
            || (string) $property['ACTIVE'] !== 'Y'
        ) {
            throw new RuntimeException('Unexpected product property configuration: ' . $propertyId);
        }
    }

    $connection->startTransaction();
    try {
        // Section 0 links are inherited by every catalogue and supplier section,
        // including the *_новое folders where newly imported products appear.
        foreach ($fields as $propertyId => $configuration) {
            $displayType = $configuration[2] === 'L' ? 'F' : 'A';
            $connection->queryExecute(
                'INSERT INTO b_iblock_section_property '
                . '(IBLOCK_ID, SECTION_ID, PROPERTY_ID, SMART_FILTER, DISPLAY_TYPE) VALUES ('
                . $iblockId . ', 0, ' . $propertyId . ", 'N', '" . $displayType . "') "
                . 'ON DUPLICATE KEY UPDATE PROPERTY_ID = VALUES(PROPERTY_ID)'
            );
        }

        // Bitrix stores custom element edit layouts per user. New properties are not
        // added to an already saved layout automatically, so append only missing fields.
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
        echo 'Product form layouts updated: ' . $updatedLayouts . "\n";
        echo 'Core light properties linked at catalogue root: ' . count($fields) . "\n";
    } catch (Throwable $error) {
        $connection->rollbackTransaction();
        throw $error;
    }
};

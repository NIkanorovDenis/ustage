<?php

declare(strict_types=1);

use Bitrix\Main\DB\Connection;
use Bitrix\Main\Loader;

return static function (Connection $connection): void {
    if (!Loader::includeModule('iblock')) {
        throw new RuntimeException('Cannot load iblock module.');
    }

    $iblockId = 32;
    $property = $connection->query(
        "SELECT ID FROM b_iblock_property WHERE IBLOCK_ID = {$iblockId} AND CODE = 'GISP'"
    )->fetch();

    if ($property) {
        $propertyId = (int) $property['ID'];
        $propertyApi = new CIBlockProperty();
        if (!$propertyApi->Update($propertyId, [
            'NAME' => 'ГИСП',
            'ACTIVE' => 'Y',
            'SORT' => 10,
            'PROPERTY_TYPE' => 'L',
            'MULTIPLE' => 'N',
            'LIST_TYPE' => 'C',
            'FILTRABLE' => 'Y',
            'SMART_FILTER' => 'Y',
        ])) {
            throw new RuntimeException('Cannot update GISP property: ' . $propertyApi->LAST_ERROR);
        }
    } else {
        $propertyApi = new CIBlockProperty();
        $propertyId = (int) $propertyApi->Add([
            'IBLOCK_ID' => $iblockId,
            'NAME' => 'ГИСП',
            'ACTIVE' => 'Y',
            'SORT' => 10,
            'CODE' => 'GISP',
            'PROPERTY_TYPE' => 'L',
            'MULTIPLE' => 'N',
            'LIST_TYPE' => 'C',
            'FILTRABLE' => 'Y',
            'SMART_FILTER' => 'Y',
            'VALUES' => [
                ['VALUE' => 'да', 'XML_ID' => 'Y', 'SORT' => 500, 'DEF' => 'N'],
            ],
        ]);
        if ($propertyId <= 0) {
            throw new RuntimeException('Cannot create GISP property: ' . $propertyApi->LAST_ERROR);
        }
    }

    $enumExists = (int) $connection->queryScalar(
        'SELECT COUNT(*) FROM b_iblock_property_enum WHERE PROPERTY_ID = ' . $propertyId . " AND XML_ID = 'Y'"
    );
    if ($enumExists === 0) {
        $enumApi = new CIBlockPropertyEnum();
        if (!$enumApi->Add([
            'PROPERTY_ID' => $propertyId,
            'VALUE' => 'да',
            'XML_ID' => 'Y',
            'SORT' => 500,
            'DEF' => 'N',
        ])) {
            throw new RuntimeException('Cannot create GISP enum value.');
        }
    }

    $connection->queryExecute(
        'INSERT INTO b_iblock_section_property '
        . '(IBLOCK_ID, SECTION_ID, PROPERTY_ID, SMART_FILTER, DISPLAY_TYPE) VALUES ('
        . $iblockId . ', 0, ' . $propertyId . ", 'Y', 'F') "
        . "ON DUPLICATE KEY UPDATE SMART_FILTER = 'Y', DISPLAY_TYPE = 'F'"
    );

    $options = $connection->query(
        "SELECT USER_ID, VALUE FROM b_user_option WHERE CATEGORY = 'form' AND NAME = 'form_element_32'"
    );
    $updatedLayouts = 0;
    while ($row = $options->fetch()) {
        $value = @unserialize((string) $row['VALUE'], ['allowed_classes' => false]);
        if (!is_array($value) || !isset($value['tabs']) || !is_string($value['tabs'])) {
            continue;
        }
        if (strpos($value['tabs'], 'PROPERTY_' . $propertyId . '--#--') !== false) {
            continue;
        }
        $firstTabEnd = strpos($value['tabs'], ';--');
        if ($firstTabEnd === false) {
            continue;
        }
        $value['tabs'] = substr($value['tabs'], 0, $firstTabEnd)
            . ',--PROPERTY_' . $propertyId . '--#--ГИСП--'
            . substr($value['tabs'], $firstTabEnd);

        $userId = (int) $row['USER_ID'];
        $saved = $userId === 0
            ? CUserOptions::SetOption('form', 'form_element_32', $value, true)
            : CUserOptions::SetOption('form', 'form_element_32', $value, false, $userId);
        if ($saved !== false) {
            $updatedLayouts++;
        }
    }

    echo 'GISP product property ready: ' . $propertyId . "\n";
    echo 'Product form layouts updated: ' . $updatedLayouts . "\n";
};

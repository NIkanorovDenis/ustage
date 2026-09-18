<?php

declare(strict_types=1);

use Bitrix\Main\DB\Connection;
use Bitrix\Main\Loader;

return static function (Connection $connection): void {
    if (!Loader::includeModule('iblock')) {
        throw new RuntimeException('Cannot load iblock module.');
    }

    $iblockId = 32;
    $legacyPropertyId = 2019;
    $targetPropertyId = 8654;
    $values = [
        216479 => 'IP 20',
        261006 => 'IP 65',
        261007 => 'IP 65',
        261009 => 'IP 65',
        261010 => 'IP 65',
        261011 => 'IP 65',
    ];
    $ignoredProducts = [257179, 260917]; // Class AB and D8+ are not IP ratings.

    $enums = [];
    $enumResult = CIBlockPropertyEnum::GetList(
        ['SORT' => 'ASC', 'ID' => 'ASC'],
        ['PROPERTY_ID' => $targetPropertyId]
    );
    while ($enum = $enumResult->Fetch()) {
        $enums[(string) $enum['VALUE']] = (int) $enum['ID'];
    }
    foreach (array_unique($values) as $label) {
        if (!isset($enums[$label])) {
            throw new RuntimeException('Required IP rating enum is missing: ' . $label);
        }
    }

    $connection->startTransaction();
    try {
        $applied = 0;
        foreach ($values as $productId => $label) {
            $exists = (int) $connection->queryScalar(
                'SELECT COUNT(*) FROM b_iblock_element WHERE ID = ' . $productId
                . ' AND IBLOCK_ID = ' . $iblockId
            );
            if ($exists === 0) {
                continue;
            }
            CIBlockElement::SetPropertyValuesEx(
                $productId,
                $iblockId,
                [$targetPropertyId => $enums[$label]]
            );
            $applied++;
        }

        $missing = (int) $connection->queryScalar(
            'SELECT COUNT(DISTINCT legacy.IBLOCK_ELEMENT_ID) '
            . 'FROM b_iblock_element_property legacy '
            . 'INNER JOIN b_iblock_element e ON e.ID = legacy.IBLOCK_ELEMENT_ID AND e.IBLOCK_ID = ' . $iblockId . ' '
            . 'LEFT JOIN b_iblock_element_property current '
            . 'ON current.IBLOCK_ELEMENT_ID = legacy.IBLOCK_ELEMENT_ID '
            . 'AND current.IBLOCK_PROPERTY_ID = ' . $targetPropertyId . ' '
            . 'WHERE legacy.IBLOCK_PROPERTY_ID = ' . $legacyPropertyId
            . ' AND current.ID IS NULL AND legacy.IBLOCK_ELEMENT_ID NOT IN ('
            . implode(',', $ignoredProducts) . ')'
        );

        if ($missing === 0) {
            $propertyApi = new CIBlockProperty();
            if (!$propertyApi->Update($legacyPropertyId, ['ACTIVE' => 'N'])) {
                throw new RuntimeException('Cannot deactivate legacy IP rating property.');
            }
            CIBlockSectionPropertyLink::DeleteByProperty($legacyPropertyId);
        }

        $connection->commitTransaction();
        echo 'Applied final IP ratings: ' . $applied . "\n";
        echo $missing === 0
            ? "Legacy IP rating property deactivated; values were preserved.\n"
            : 'Legacy IP rating retained; unmigrated products in this environment: ' . $missing . "\n";
    } catch (Throwable $error) {
        $connection->rollbackTransaction();
        throw $error;
    }
};

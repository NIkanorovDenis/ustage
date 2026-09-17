<?php

declare(strict_types=1);

use Bitrix\Main\DB\Connection;
use Bitrix\Main\Loader;

return static function (Connection $connection): void {
    if (!Loader::includeModule('iblock')) {
        throw new RuntimeException('Cannot load iblock module.');
    }

    $iblockId = 32;
    $oldPropertyId = 2337;
    $listPropertyId = 8653;
    $csv = __DIR__ . '/data/light_source_choices_20260917.csv';
    $expectedChecksum = '7067f98f5bb6bb39d217a1370bf1d27b4dd0462f19da1d38577e85665ca2a473';
    $allowedEnums = [1994 => 'LED', 1995 => 'Ламповый', 1996 => 'Лазерный'];

    if (!is_file($csv) || !hash_equals($expectedChecksum, hash_file('sha256', $csv))) {
        throw new RuntimeException('Light source import file is missing or has an invalid checksum.');
    }

    foreach ($allowedEnums as $enumId => $value) {
        $actual = $connection->queryScalar(
            'SELECT VALUE FROM b_iblock_property_enum WHERE ID = ' . $enumId
            . ' AND PROPERTY_ID = ' . $listPropertyId
        );
        if ((string) $actual !== $value) {
            throw new RuntimeException('Unexpected light source enum: ' . $enumId);
        }
    }

    $handle = fopen($csv, 'rb');
    if ($handle === false || fgetcsv($handle) !== ['product_id', 'enum_id', 'choice']) {
        throw new RuntimeException('Invalid light source CSV header.');
    }

    $choices = [];
    while (($row = fgetcsv($handle)) !== false) {
        $productId = (int) ($row[0] ?? 0);
        $enumId = (int) ($row[1] ?? 0);
        $label = (string) ($row[2] ?? '');
        if ($productId <= 0 || !isset($allowedEnums[$enumId]) || $allowedEnums[$enumId] !== $label) {
            throw new RuntimeException('Invalid light source CSV row for product ' . $productId);
        }
        if (isset($choices[$productId])) {
            throw new RuntimeException('Duplicate product in light source CSV: ' . $productId);
        }
        $choices[$productId] = $enumId;
    }
    fclose($handle);

    if (count($choices) !== 94) {
        throw new RuntimeException('Expected 94 light source choices, got ' . count($choices));
    }

    $connection->startTransaction();
    try {
        $imported = 0;
        foreach ($choices as $productId => $enumId) {
            $product = $connection->query(
                'SELECT e.ID, current.VALUE_ENUM '
                . 'FROM b_iblock_element e '
                . 'INNER JOIN b_iblock_element_property legacy '
                . 'ON legacy.IBLOCK_ELEMENT_ID = e.ID AND legacy.IBLOCK_PROPERTY_ID = ' . $oldPropertyId . ' '
                . 'LEFT JOIN b_iblock_element_property current '
                . 'ON current.IBLOCK_ELEMENT_ID = e.ID AND current.IBLOCK_PROPERTY_ID = ' . $listPropertyId . ' '
                . 'WHERE e.ID = ' . $productId . ' AND e.IBLOCK_ID = ' . $iblockId
            )->fetch();
            if (!$product) {
                // Development and local databases can lag behind production imports.
                continue;
            }
            if ((int) $product['VALUE_ENUM'] > 0 && (int) $product['VALUE_ENUM'] !== $enumId) {
                throw new RuntimeException('Product already has a different light source: ' . $productId);
            }
            if ((int) $product['VALUE_ENUM'] === 0) {
                CIBlockElement::SetPropertyValuesEx(
                    $productId,
                    $iblockId,
                    [$listPropertyId => $enumId]
                );
                $imported++;
            }
        }

        $missing = (int) $connection->queryScalar(
            'SELECT COUNT(DISTINCT legacy.IBLOCK_ELEMENT_ID) '
            . 'FROM b_iblock_element_property legacy '
            . 'INNER JOIN b_iblock_element e ON e.ID = legacy.IBLOCK_ELEMENT_ID AND e.IBLOCK_ID = ' . $iblockId . ' '
            . 'LEFT JOIN b_iblock_element_property current '
            . 'ON current.IBLOCK_ELEMENT_ID = legacy.IBLOCK_ELEMENT_ID '
            . 'AND current.IBLOCK_PROPERTY_ID = ' . $listPropertyId . ' '
            . 'WHERE legacy.IBLOCK_PROPERTY_ID = ' . $oldPropertyId . ' AND current.ID IS NULL'
        );
        if ($missing === 0) {
            $property = new CIBlockProperty();
            if (!$property->Update($oldPropertyId, ['ACTIVE' => 'N'])) {
                throw new RuntimeException('Cannot deactivate legacy light source property.');
            }
            CIBlockSectionPropertyLink::DeleteByProperty($oldPropertyId);
        }

        $connection->commitTransaction();
        echo 'Imported light source choices: ' . $imported . "\n";
        echo 'Already selected or absent in this environment: ' . (count($choices) - $imported) . "\n";
        if ($missing === 0) {
            echo "Legacy light source property deactivated; its values were preserved.\n";
        } else {
            echo 'Legacy property retained in this environment; products without a choice: ' . $missing . "\n";
        }
    } catch (Throwable $error) {
        $connection->rollbackTransaction();
        throw $error;
    }
};

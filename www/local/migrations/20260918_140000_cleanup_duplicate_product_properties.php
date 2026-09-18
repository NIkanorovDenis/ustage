<?php

declare(strict_types=1);

use Bitrix\Main\DB\Connection;
use Bitrix\Main\Loader;

return static function (Connection $connection): void {
    if (!Loader::includeModule('iblock')) {
        throw new RuntimeException('Cannot load iblock module.');
    }

    $iblockId = 32;
    $csv = __DIR__ . '/data/property_cleanup_20260918.csv';
    $expectedChecksum = '74df7f89597619f6088152edcb35cd328955efa433b16cdedc3ca7a8042f0f37';
    $properties = [
        'ip_rating' => ['target' => 8654, 'legacy' => 2019, 'type' => 'list'],
        'source_power' => ['target' => 2353, 'legacy' => 2365, 'type' => 'number'],
        'max_power' => ['target' => 8555, 'legacy' => 2351, 'type' => 'number'],
        'light_count' => ['target' => 8656, 'legacy' => null, 'type' => 'number'],
    ];
    $expectedCounts = [
        'ip_rating' => 409,
        'source_power' => 2,
        'max_power' => 6,
        'light_count' => 1625,
    ];
    $allowedIpValues = [
        'IP 20', 'IP 21', 'IP 30', 'IP 31', 'IP 34', 'IP 35', 'IP 40', 'IP 43',
        'IP 44', 'IP 54', 'IP 55', 'IP 56', 'IP 64', 'IP 65', 'IP 66', 'IP 67', 'IP 68',
    ];
    $ignoredLegacyIpProducts = [257179, 260917]; // Class AB and D8+ are not IP ratings.

    if (!is_file($csv) || !hash_equals($expectedChecksum, hash_file('sha256', $csv))) {
        throw new RuntimeException('Property cleanup CSV is missing or has an invalid checksum.');
    }

    foreach ($properties as $key => $config) {
        $property = CIBlockProperty::GetByID($config['target'], $iblockId)->Fetch();
        if (!$property) {
            throw new RuntimeException('Target property is missing: ' . $key);
        }
        $actualType = $property['PROPERTY_TYPE'] === 'L' ? 'list' : ($property['PROPERTY_TYPE'] === 'N' ? 'number' : 'other');
        if ($actualType !== $config['type']) {
            throw new RuntimeException('Unexpected target property type: ' . $key);
        }
    }

    $handle = fopen($csv, 'rb');
    if ($handle === false || fgetcsv($handle) !== ['property', 'product_id', 'value']) {
        throw new RuntimeException('Invalid property cleanup CSV header.');
    }

    $updates = [];
    $counts = array_fill_keys(array_keys($properties), 0);
    while (($row = fgetcsv($handle)) !== false) {
        $key = (string) ($row[0] ?? '');
        $productId = (int) ($row[1] ?? 0);
        $value = trim((string) ($row[2] ?? ''));
        if (!isset($properties[$key]) || $productId <= 0 || $value === '') {
            throw new RuntimeException('Invalid property cleanup CSV row.');
        }
        if ($properties[$key]['type'] === 'number' && (!is_numeric($value) || (float) $value <= 0)) {
            throw new RuntimeException('Invalid numeric value for product ' . $productId . ': ' . $value);
        }
        if ($key === 'ip_rating' && !in_array($value, $allowedIpValues, true)) {
            throw new RuntimeException('Unexpected IP rating for product ' . $productId . ': ' . $value);
        }
        if (isset($updates[$key][$productId])) {
            throw new RuntimeException('Duplicate update for ' . $key . ', product ' . $productId);
        }
        $updates[$key][$productId] = $value;
        $counts[$key]++;
    }
    fclose($handle);
    if ($counts !== $expectedCounts) {
        throw new RuntimeException('Unexpected property cleanup record counts.');
    }

    $connection->startTransaction();
    try {
        $ipEnums = [];
        $enumResult = CIBlockPropertyEnum::GetList(
            ['SORT' => 'ASC', 'ID' => 'ASC'],
            ['PROPERTY_ID' => $properties['ip_rating']['target']]
        );
        while ($enum = $enumResult->Fetch()) {
            $ipEnums[(string) $enum['VALUE']] = (int) $enum['ID'];
        }
        $enumApi = new CIBlockPropertyEnum();
        foreach ($allowedIpValues as $index => $label) {
            if (isset($ipEnums[$label])) {
                continue;
            }
            $enumId = $enumApi->Add([
                'PROPERTY_ID' => $properties['ip_rating']['target'],
                'VALUE' => $label,
                'DEF' => 'N',
                'SORT' => 500 + $index,
            ]);
            if (!$enumId) {
                throw new RuntimeException('Cannot add IP rating enum: ' . $label);
            }
            $ipEnums[$label] = (int) $enumId;
        }

        $applied = array_fill_keys(array_keys($properties), 0);
        foreach ($updates as $key => $productUpdates) {
            $config = $properties[$key];
            foreach ($productUpdates as $productId => $value) {
                $exists = (int) $connection->queryScalar(
                    'SELECT COUNT(*) FROM b_iblock_element WHERE ID = ' . $productId
                    . ' AND IBLOCK_ID = ' . $iblockId
                );
                if ($exists === 0) {
                    // Development/local catalogues can lag behind production.
                    continue;
                }
                $storedValue = $config['type'] === 'list' ? $ipEnums[$value] : $value;
                CIBlockElement::SetPropertyValuesEx(
                    $productId,
                    $iblockId,
                    [$config['target'] => $storedValue]
                );
                $applied[$key]++;
            }
        }

        $legacyStatus = [];
        foreach (['ip_rating', 'source_power', 'max_power'] as $key) {
            $config = $properties[$key];
            $extraCondition = '';
            if ($key === 'ip_rating') {
                $extraCondition = ' AND legacy.IBLOCK_ELEMENT_ID NOT IN ('
                    . implode(',', $ignoredLegacyIpProducts) . ')';
            }
            $missing = (int) $connection->queryScalar(
                'SELECT COUNT(DISTINCT legacy.IBLOCK_ELEMENT_ID) '
                . 'FROM b_iblock_element_property legacy '
                . 'INNER JOIN b_iblock_element e ON e.ID = legacy.IBLOCK_ELEMENT_ID AND e.IBLOCK_ID = ' . $iblockId . ' '
                . 'LEFT JOIN b_iblock_element_property current '
                . 'ON current.IBLOCK_ELEMENT_ID = legacy.IBLOCK_ELEMENT_ID '
                . 'AND current.IBLOCK_PROPERTY_ID = ' . $config['target'] . ' '
                . 'WHERE legacy.IBLOCK_PROPERTY_ID = ' . $config['legacy']
                . ' AND current.ID IS NULL' . $extraCondition
            );
            if ($missing === 0) {
                $propertyApi = new CIBlockProperty();
                if (!$propertyApi->Update($config['legacy'], ['ACTIVE' => 'N'])) {
                    throw new RuntimeException('Cannot deactivate legacy property: ' . $key);
                }
                CIBlockSectionPropertyLink::DeleteByProperty($config['legacy']);
                $legacyStatus[$key] = 'deactivated';
            } else {
                // Development/local catalogues can contain a different historical snapshot.
                $legacyStatus[$key] = 'retained; unmigrated products in this environment: ' . $missing;
            }
        }

        $connection->commitTransaction();
        foreach ($applied as $key => $count) {
            echo 'Applied ' . $key . ': ' . $count . "\n";
        }
        foreach ($legacyStatus as $key => $status) {
            echo 'Legacy ' . $key . ': ' . $status . "\n";
        }
    } catch (Throwable $error) {
        $connection->rollbackTransaction();
        throw $error;
    }
};

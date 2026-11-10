<?php

declare(strict_types=1);

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\DB\Connection;
use Bitrix\Main\Loader;

return static function (Connection $connection): void {
    if (!Loader::includeModule('highloadblock')) {
        throw new RuntimeException('Cannot load highloadblock module.');
    }

    $highloadBlock = HighloadBlockTable::getById(2)->fetch();
    if (!$highloadBlock || $highloadBlock['TABLE_NAME'] !== 'bxready_manufacturer') {
        throw new RuntimeException('Manufacturer highload block 2 was not found or does not match.');
    }

    $entity = HighloadBlockTable::compileEntity($highloadBlock);
    $dataClass = $entity->getDataClass();

    $manufacturer = $dataClass::getList([
        'select' => ['ID', 'UF_FILE'],
        'filter' => ['=UF_XML_ID' => 'ds_proaudio'],
        'limit' => 1,
    ])->fetch();

    if (!$manufacturer) {
        $manufacturer = $dataClass::getList([
            'select' => ['ID', 'UF_FILE'],
            'filter' => ['=UF_NAME' => 'DS PROAUDIO'],
            'limit' => 1,
        ])->fetch();
    }

    $fields = [
        'UF_NAME' => 'DS PROAUDIO',
        'UF_LINK' => '/brands/ds_proaudio/',
        'UF_SORT' => 591,
        'UF_XML_ID' => 'ds_proaudio',
        'UF_DEF' => 0,
    ];

    if (!$manufacturer || empty($manufacturer['UF_FILE'])) {
        $logoPath = $_SERVER['DOCUMENT_ROOT'] . '/local/assets/brands/ds-proaudio.png';
        if (!is_file($logoPath)) {
            throw new RuntimeException('DS PROAUDIO logo file was not found.');
        }

        $logo = CFile::MakeFileArray($logoPath);
        if (!$logo) {
            throw new RuntimeException('Cannot prepare the DS PROAUDIO logo for upload.');
        }
        $fields['UF_FILE'] = $logo;
    }

    if ($manufacturer) {
        $result = $dataClass::update((int) $manufacturer['ID'], $fields);
        $manufacturerId = (int) $manufacturer['ID'];
    } else {
        $result = $dataClass::add($fields);
        $manufacturerId = (int) $result->getId();
    }

    if (!$result->isSuccess()) {
        throw new RuntimeException(
            'Cannot save DS PROAUDIO manufacturer: ' . implode('; ', $result->getErrorMessages())
        );
    }

    BXClearCache(true);

    echo "DS PROAUDIO manufacturer {$manufacturerId} is available in the catalog.\n";
};

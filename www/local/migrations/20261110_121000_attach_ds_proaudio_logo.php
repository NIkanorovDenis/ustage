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
        throw new RuntimeException('Manufacturer highload block was not found.');
    }

    $entity = HighloadBlockTable::compileEntity($highloadBlock);
    $dataClass = $entity->getDataClass();
    $manufacturer = $dataClass::getList([
        'select' => ['ID', 'UF_FILE'],
        'filter' => ['=UF_XML_ID' => 'ds_proaudio'],
        'limit' => 1,
    ])->fetch();

    if (!$manufacturer) {
        throw new RuntimeException('DS PROAUDIO manufacturer was not found.');
    }

    if ((int) $manufacturer['UF_FILE'] > 0) {
        echo "DS PROAUDIO logo is already attached.\n";
        return;
    }

    $logoPath = $_SERVER['DOCUMENT_ROOT'] . '/local/assets/brands/ds-proaudio.png';
    $logo = CFile::MakeFileArray($logoPath);
    if (!$logo) {
        throw new RuntimeException('Cannot prepare the DS PROAUDIO logo for upload.');
    }

    $fileId = (int) CFile::SaveFile($logo, 'highloadblock');
    if ($fileId <= 0) {
        throw new RuntimeException('Cannot save the DS PROAUDIO logo in Bitrix file storage.');
    }

    $result = $dataClass::update((int) $manufacturer['ID'], ['UF_FILE' => $fileId]);
    if (!$result->isSuccess()) {
        CFile::Delete($fileId);
        throw new RuntimeException(
            'Cannot attach the DS PROAUDIO logo: ' . implode('; ', $result->getErrorMessages())
        );
    }

    BXClearCache(true);

    echo "DS PROAUDIO logo file {$fileId} is attached.\n";
};

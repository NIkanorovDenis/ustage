<?php

declare(strict_types=1);

use Bitrix\Main\DB\Connection;

return static function (Connection $connection): void {
    $manufacturer = $connection->query(
        "SELECT ID, UF_FILE FROM bxready_manufacturer WHERE UF_XML_ID = 'ds_proaudio' LIMIT 1"
    )->fetch();

    if (!$manufacturer) {
        throw new RuntimeException('DS PROAUDIO manufacturer was not found.');
    }

    if ((int) $manufacturer['UF_FILE'] > 0) {
        echo "DS PROAUDIO logo is already linked.\n";
        return;
    }

    $fileId = (int) $connection->queryScalar(
        "SELECT ID FROM b_file WHERE ORIGINAL_NAME = 'ds-proaudio.png' "
        . "AND CONTENT_TYPE = 'image/png' ORDER BY ID DESC"
    );

    if ($fileId <= 0) {
        $logoPath = $_SERVER['DOCUMENT_ROOT'] . '/local/assets/brands/ds-proaudio.png';
        $logo = CFile::MakeFileArray($logoPath);
        $fileId = $logo ? (int) CFile::SaveFile($logo, 'highloadblock') : 0;
    }

    if ($fileId <= 0) {
        throw new RuntimeException('DS PROAUDIO logo is missing from Bitrix file storage.');
    }

    $connection->queryExecute(
        'UPDATE bxready_manufacturer SET UF_FILE = ' . $fileId
        . ' WHERE ID = ' . (int) $manufacturer['ID']
    );

    BXClearCache(true);

    echo "DS PROAUDIO logo file {$fileId} is linked.\n";
};

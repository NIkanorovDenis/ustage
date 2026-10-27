<?php

declare(strict_types=1);

use Bitrix\Main\DB\Connection;
use Bitrix\Main\Loader;

return static function (Connection $connection): void {
    if (!Loader::includeModule('iblock')) {
        throw new RuntimeException('Cannot load iblock module.');
    }

    $iblockId = 32;
    $sectionId = 3146;
    $section = CIBlockSection::GetList(
        [],
        [
            'IBLOCK_ID' => $iblockId,
            'ID' => $sectionId,
        ],
        false,
        ['ID', 'NAME', 'CODE', 'ACTIVE']
    )->Fetch();

    if (!$section || $section['NAME'] !== 'Пена' || $section['CODE'] !== 'ge-pena') {
        throw new RuntimeException('Foam catalog section 3146 was not found or does not match.');
    }

    if ($section['ACTIVE'] !== 'Y') {
        $sectionApi = new CIBlockSection();
        if (!$sectionApi->Update($sectionId, ['ACTIVE' => 'Y'])) {
            throw new RuntimeException(
                'Cannot activate foam catalog section 3146: ' . $sectionApi->LAST_ERROR
            );
        }
    }

    if (defined('BX_COMP_MANAGED_CACHE')) {
        $GLOBALS['CACHE_MANAGER']->ClearByTag('iblock_id_' . $iblockId);
    }

    echo "Foam catalog section 3146 is active.\n";
};

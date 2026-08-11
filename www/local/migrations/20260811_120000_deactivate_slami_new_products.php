<?php

declare(strict_types=1);

use Bitrix\Main\DB\Connection;
use Bitrix\Main\Loader;

return static function (Connection $connection): void {
    if (!Loader::includeModule('iblock')) {
        throw new RuntimeException('Cannot load iblock module.');
    }

    $iblockId = 32;
    $sectionId = 3724;
    $section = CIBlockSection::GetList(
        [],
        [
            'IBLOCK_ID' => $iblockId,
            'ID' => $sectionId,
            'NAME' => 'SLAMI_новое',
        ],
        false,
        ['ID', 'NAME']
    )->Fetch();

    if (!$section) {
        throw new RuntimeException('SLAMI_новое section 3724 was not found.');
    }

    $elements = CIBlockElement::GetList(
        ['ID' => 'ASC'],
        [
            'IBLOCK_ID' => $iblockId,
            'SECTION_ID' => $sectionId,
            'INCLUDE_SUBSECTIONS' => 'N',
            'ACTIVE' => 'Y',
        ],
        false,
        false,
        ['ID']
    );

    $element = new CIBlockElement();
    $deactivated = 0;
    while ($row = $elements->Fetch()) {
        if (!$element->Update((int) $row['ID'], ['ACTIVE' => 'N'])) {
            throw new RuntimeException(
                'Cannot deactivate SLAMI product ' . $row['ID'] . ': ' . $element->LAST_ERROR
            );
        }
        $deactivated++;
    }

    echo "Deactivated SLAMI_новое products: {$deactivated}\n";
};

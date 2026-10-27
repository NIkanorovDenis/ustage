<?php

declare(strict_types=1);

use Bitrix\Main\DB\Connection;
use Bitrix\Main\Loader;

return static function (Connection $connection): void {
    if (!Loader::includeModule('iblock')) {
        throw new RuntimeException('Cannot load iblock module.');
    }

    $iblockId = 32;

    // Undo the broad heuristic from the previous dev-only migration. The
    // supplier API does not expose one universally correct article field.
    $backupExists = (int) $connection->queryScalar(
        "SELECT COUNT(*) FROM information_schema.tables "
        . "WHERE table_schema = DATABASE() "
        . "AND table_name = 'ustage_imlight_article_backup_20261026'"
    ) === 1;

    $restored = 0;
    if ($backupExists) {
        $rows = $connection->query(
            'SELECT element_id, old_article '
            . 'FROM ustage_imlight_article_backup_20261026 '
            . 'ORDER BY element_id'
        );
        while ($row = $rows->fetch()) {
            CIBlockElement::SetPropertyValuesEx(
                (int) $row['element_id'],
                $iblockId,
                ['CML2_ARTICLE' => (string) $row['old_article']]
            );
            $restored++;
        }
    }

    // Values explicitly verified by the customer in "Товары имлайт (1).xlsx".
    $verifiedArticles = [
        271392 => '00-15644',
        271289 => '00-47771',
        273042 => '00-79067',
        273043 => '00-79797',
        273050 => '00-77866',
        271600 => '00-56430',
        273849 => '00-58756',
        273047 => '00-79802',
        272076 => '001-20374',
        270780 => '001-20375',
        271904 => 'WP-150001-**A',
        271903 => 'WP-132501-**A',
        273163 => '00-83165',
        273161 => '00-82980',
        273165 => '00-83171',
        273166 => '00-83172',
        273167 => '00-83173',
        273168 => '00-83174',
        273164 => '00-83168',
    ];

    foreach ($verifiedArticles as $elementId => $article) {
        CIBlockElement::SetPropertyValuesEx(
            $elementId,
            $iblockId,
            ['CML2_ARTICLE' => $article]
        );
    }

    // These accessories do not have dedicated public pages at Imlight. Their
    // current URLs point to parent products and must not be shown as sources.
    $productsWithoutOwnPage = [271017, 270844, 271280];
    foreach ($productsWithoutOwnPage as $elementId) {
        CIBlockElement::SetPropertyValuesEx(
            $elementId,
            $iblockId,
            ['UPLOADED_FROM_PAGE' => false]
        );
    }

    if (defined('BX_COMP_MANAGED_CACHE')) {
        $GLOBALS['CACHE_MANAGER']->ClearByTag('iblock_id_' . $iblockId);
    }

    echo "Restored heuristic article changes: {$restored}\n";
    echo 'Applied verified Imlight articles: ' . count($verifiedArticles) . "\n";
    echo 'Removed invalid Imlight source links: ' . count($productsWithoutOwnPage) . "\n";
};

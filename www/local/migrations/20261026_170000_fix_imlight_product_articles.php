<?php

declare(strict_types=1);

use Bitrix\Main\DB\Connection;
use Bitrix\Main\Loader;

return static function (Connection $connection): void {
    if (!Loader::includeModule('iblock')) {
        throw new RuntimeException('Cannot load iblock module.');
    }

    $iblockId = 32;
    $articlePropertyId = 1553;
    $sourcePagePropertyId = 1940;
    $supplierCodePropertyId = 8662;

    $connection->queryExecute(
        'CREATE TABLE IF NOT EXISTS ustage_imlight_article_backup_20261026 ('
        . 'element_id INT NOT NULL PRIMARY KEY,'
        . 'old_article VARCHAR(255) NULL,'
        . 'supplier_code VARCHAR(255) NOT NULL,'
        . 'backed_up_at DATETIME NOT NULL'
        . ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );

    $connection->queryExecute(
        'INSERT IGNORE INTO ustage_imlight_article_backup_20261026 '
        . '(element_id, old_article, supplier_code, backed_up_at) '
        . 'SELECT e.ID, article.VALUE, supplier.VALUE, NOW() '
        . 'FROM b_iblock_element e '
        . 'INNER JOIN b_iblock_element_property source '
        . 'ON source.IBLOCK_ELEMENT_ID = e.ID '
        . 'AND source.IBLOCK_PROPERTY_ID = ' . $sourcePagePropertyId . ' '
        . 'INNER JOIN b_iblock_element_property article '
        . 'ON article.IBLOCK_ELEMENT_ID = e.ID '
        . 'AND article.IBLOCK_PROPERTY_ID = ' . $articlePropertyId . ' '
        . 'INNER JOIN b_iblock_element_property supplier '
        . 'ON supplier.IBLOCK_ELEMENT_ID = e.ID '
        . 'AND supplier.IBLOCK_PROPERTY_ID = ' . $supplierCodePropertyId . ' '
        . 'WHERE e.IBLOCK_ID = ' . $iblockId . ' '
        . "AND source.VALUE LIKE '%imlight.ru%' "
        . "AND supplier.VALUE <> '' "
        . 'AND (article.VALUE IS NULL OR article.VALUE <> supplier.VALUE)'
    );

    $rows = $connection->query(
        'SELECT element_id, supplier_code '
        . 'FROM ustage_imlight_article_backup_20261026 '
        . 'ORDER BY element_id'
    );

    $updated = 0;
    while ($row = $rows->fetch()) {
        CIBlockElement::SetPropertyValuesEx(
            (int) $row['element_id'],
            $iblockId,
            ['CML2_ARTICLE' => (string) $row['supplier_code']]
        );
        $updated++;
    }

    if (defined('BX_COMP_MANAGED_CACHE')) {
        $GLOBALS['CACHE_MANAGER']->ClearByTag('iblock_id_' . $iblockId);
    }

    echo "Corrected Imlight articles: {$updated}\n";
};

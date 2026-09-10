<?php

declare(strict_types=1);

use Bitrix\Main\DB\Connection;

return static function (Connection $connection): void {
    $connection->queryExecute(
        'CREATE TABLE IF NOT EXISTS ustage_marketing_consents ('
        . 'id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,'
        . 'user_id INT NULL,'
        . 'order_id INT NULL,'
        . 'email VARCHAR(255) NOT NULL DEFAULT \'\','
        . 'source VARCHAR(32) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,'
        . 'page VARCHAR(255) NOT NULL DEFAULT \'/\','
        . 'ip VARCHAR(45) CHARACTER SET ascii COLLATE ascii_bin NOT NULL DEFAULT \'\','
        . 'consent_text_hash CHAR(64) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,'
        . 'created_at DATETIME NOT NULL,'
        . 'UNIQUE KEY ux_ustage_marketing_source_order (source, order_id),'
        . 'UNIQUE KEY ux_ustage_marketing_source_user (source, user_id),'
        . 'KEY ix_ustage_marketing_created (created_at)'
        . ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );
};

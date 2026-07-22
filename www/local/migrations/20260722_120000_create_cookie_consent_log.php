<?php

declare(strict_types=1);

use Bitrix\Main\DB\Connection;

return static function (Connection $connection): void {
    $connection->queryExecute(
        'CREATE TABLE IF NOT EXISTS ustage_cookie_consents ('
        . 'id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,'
        . 'consent_id CHAR(36) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,'
        . 'decision VARCHAR(8) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,'
        . 'page VARCHAR(255) NOT NULL DEFAULT \'/\','
        . 'user_id INT NULL,'
        . 'created_at DATETIME NOT NULL,'
        . 'updated_at DATETIME NOT NULL,'
        . 'UNIQUE KEY ux_ustage_cookie_consent_id (consent_id),'
        . 'KEY ix_ustage_cookie_decision_updated (decision, updated_at),'
        . 'KEY ix_ustage_cookie_updated (updated_at)'
        . ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );
};

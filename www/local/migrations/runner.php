<?php

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

set_time_limit(0);

define('NO_KEEP_STATISTIC', true);
define('NO_AGENT_CHECK', true);
define('NOT_CHECK_PERMISSIONS', true);
define('BX_CRONTAB_SUPPORT', true);

$_SERVER['DOCUMENT_ROOT'] = dirname(__DIR__, 2);

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

use Bitrix\Main\Application;
use Bitrix\Main\DB\Connection;

const MIGRATION_TABLE = 'ustage_migrations';
const MIGRATION_LOCK = 'ustage_database_migrations';

$connection = Application::getConnection();
$helper = $connection->getSqlHelper();

try {
    $connection->queryExecute(
        'CREATE TABLE IF NOT EXISTS ' . MIGRATION_TABLE . ' ('
        . 'migration VARCHAR(190) NOT NULL PRIMARY KEY,'
        . 'checksum CHAR(64) NOT NULL,'
        . 'executed_at DATETIME NOT NULL'
        . ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );

    if ((int) $connection->queryScalar("SELECT GET_LOCK('" . MIGRATION_LOCK . "', 10)") !== 1) {
        throw new RuntimeException('Another migration process is already running.');
    }

    $executed = [];
    $result = $connection->query('SELECT migration, checksum FROM ' . MIGRATION_TABLE);
    while ($row = $result->fetch()) {
        $executed[$row['migration']] = $row['checksum'];
    }

    $files = glob(__DIR__ . '/*.php') ?: [];
    sort($files, SORT_STRING);
    $applied = 0;

    foreach ($files as $file) {
        $name = basename($file);
        if (!preg_match('/^\d{8}_\d{6}_[a-z0-9_]+\.php$/', $name)) {
            continue;
        }

        $checksum = hash_file('sha256', $file);
        if (isset($executed[$name])) {
            if (!hash_equals($executed[$name], $checksum)) {
                throw new RuntimeException("Executed migration was modified: {$name}");
            }

            echo "SKIP {$name}\n";
            continue;
        }

        echo "RUN  {$name}\n";
        $migration = require $file;
        if (!is_callable($migration)) {
            throw new RuntimeException("Migration must return a callable: {$name}");
        }

        $migration($connection);

        $connection->queryExecute(
            'INSERT INTO ' . MIGRATION_TABLE . ' (migration, checksum, executed_at) VALUES ('
            . "'" . $helper->forSql($name) . "',"
            . "'" . $helper->forSql($checksum) . "',"
            . 'NOW())'
        );

        echo "DONE {$name}\n";
        $applied++;
    }

    echo "Migrations applied: {$applied}\n";
} catch (Throwable $error) {
    fwrite(STDERR, 'Migration failed: ' . $error->getMessage() . PHP_EOL);
    exit(1);
} finally {
    try {
        $connection->queryScalar("SELECT RELEASE_LOCK('" . MIGRATION_LOCK . "')");
    } catch (Throwable $ignored) {
    }
}

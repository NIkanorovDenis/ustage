<?php

declare(strict_types=1);

use Bitrix\Main\DB\Connection;

return static function (Connection $connection): void {
    $payload = stream_get_contents(STDIN);
    if ($payload === false || trim($payload) === '') {
        return;
    }

    $credentials = json_decode($payload, true);
    $login = trim((string) ($credentials['imlight']['login'] ?? ''));
    $password = (string) ($credentials['imlight']['password'] ?? '');
    if ($login === '' || $password === '') {
        throw new RuntimeException('Imlight deployment credentials are missing.');
    }

    $target = dirname($_SERVER['DOCUMENT_ROOT']) . '/.imlight_credentials.php';
    $temporary = tempnam(dirname($target), '.imlight_credentials_');
    if ($temporary === false) {
        throw new RuntimeException('Cannot create temporary Imlight credentials file.');
    }

    $contents = "<?php\nreturn " . var_export([
        'imlight' => [
            'login' => $login,
            'password' => $password,
        ],
    ], true) . ";\n";

    try {
        if (file_put_contents($temporary, $contents, LOCK_EX) === false) {
            throw new RuntimeException('Cannot write Imlight credentials file.');
        }
        if (!chmod($temporary, 0600)) {
            throw new RuntimeException('Cannot protect Imlight credentials file.');
        }
        if (!rename($temporary, $target)) {
            throw new RuntimeException('Cannot install Imlight credentials file.');
        }
    } finally {
        if (is_file($temporary)) {
            @unlink($temporary);
        }
    }
};

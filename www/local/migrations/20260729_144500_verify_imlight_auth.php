<?php

declare(strict_types=1);

use Bitrix\Main\DB\Connection;

return static function (Connection $connection): void {
    $credentialsFiles = [
        dirname($_SERVER['DOCUMENT_ROOT']) . '/.imlight_credentials.php',
        dirname($_SERVER['DOCUMENT_ROOT']) . '/.parser_credentials.php',
    ];

    $credentials = [];
    foreach ($credentialsFiles as $credentialsFile) {
        if (!is_file($credentialsFile) || !is_readable($credentialsFile)) {
            continue;
        }

        $loaded = include $credentialsFile;
        if (is_array($loaded)) {
            $credentials = array_replace_recursive($credentials, $loaded);
        }
    }

    $login = trim((string) ($credentials['imlight']['login'] ?? ''));
    $password = (string) ($credentials['imlight']['password'] ?? '');
    if ($login === '' || $password === '') {
        throw new RuntimeException('Imlight credentials are unavailable.');
    }

    $curl = curl_init('https://b2b.imlight.ru/api/v1.0/auth/');
    if ($curl === false) {
        throw new RuntimeException('Cannot initialize Imlight API request.');
    }

    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS => json_encode([
            'login' => $login,
            'password' => $password,
        ], JSON_UNESCAPED_UNICODE),
        CURLOPT_CONNECTTIMEOUT => 20,
        CURLOPT_TIMEOUT => 60,
    ]);

    $rawResponse = curl_exec($curl);
    $httpCode = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $transportError = curl_error($curl);
    curl_close($curl);

    if ($rawResponse === false) {
        throw new RuntimeException(
            'Imlight API transport error: ' . ($transportError !== '' ? $transportError : 'unknown')
        );
    }

    $response = json_decode($rawResponse, true);
    if (
        $httpCode !== 200
        || !is_array($response)
        || !empty($response['error'])
        || empty($response['token'])
    ) {
        $errorCode = is_array($response) ? (int) ($response['error_code'] ?? 0) : 0;
        throw new RuntimeException(
            'Imlight API authentication failed; HTTP ' . $httpCode . '; code ' . $errorCode
        );
    }
};

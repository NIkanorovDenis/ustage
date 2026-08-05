<?php

use Bitrix\Main\Application;
use Bitrix\Main\Data\Cache;

AddEventHandler('main', 'OnEpilog', ['UstageLastModified', 'send']);

final class UstageLastModified
{
    private const CACHE_TTL = 900;
    private const CACHE_ID = 'public_content_last_modified_v1';
    private const CACHE_DIR = '/ustage/last_modified';

    public static function send(): void
    {
        if (!self::isPublicHtmlRequest()) {
            return;
        }

        $timestamp = max(self::getFilesTimestamp(), self::getDatabaseTimestamp());
        $timestamp = min($timestamp, time());

        if ($timestamp <= 0 || headers_sent()) {
            return;
        }

        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $timestamp) . ' GMT', true);
    }

    private static function isPublicHtmlRequest(): bool
    {
        if (PHP_SAPI === 'cli') {
            return false;
        }

        $method = strtoupper((string)($_SERVER['REQUEST_METHOD'] ?? 'GET'));
        if ($method !== 'GET' && $method !== 'HEAD') {
            return false;
        }

        if (http_response_code() !== 200) {
            return false;
        }

        if (defined('ADMIN_SECTION') && ADMIN_SECTION === true) {
            return false;
        }

        if (
            isset($_REQUEST['BX_AJAX'])
            || isset($_REQUEST['AJAX_CALL'])
            || strtolower((string)($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '')) === 'xmlhttprequest'
        ) {
            return false;
        }

        $path = (string)(parse_url((string)($_SERVER['REQUEST_URI'] ?? '/'), PHP_URL_PATH) ?: '/');
        if (preg_match('~^/(?:bitrix|local|upload|import)/~i', $path)) {
            return false;
        }

        foreach (headers_list() as $header) {
            if (stripos($header, 'Content-Type:') === 0 && stripos($header, 'text/html') === false) {
                return false;
            }
        }

        return true;
    }

    private static function getFilesTimestamp(): int
    {
        $documentRoot = rtrim((string)($_SERVER['DOCUMENT_ROOT'] ?? ''), '/');
        $timestamp = 0;

        foreach (get_included_files() as $file) {
            $realFile = realpath($file);
            if ($realFile === false || $documentRoot === '' || strpos($realFile, $documentRoot . '/') !== 0) {
                continue;
            }

            if (strpos($realFile, '/bitrix/cache/') !== false || strpos($realFile, '/bitrix/managed_cache/') !== false) {
                continue;
            }

            $modifiedAt = @filemtime($realFile);
            if ($modifiedAt !== false) {
                $timestamp = max($timestamp, $modifiedAt);
            }
        }

        return $timestamp;
    }

    private static function getDatabaseTimestamp(): int
    {
        $cache = Cache::createInstance();

        if ($cache->initCache(self::CACHE_TTL, self::CACHE_ID, self::CACHE_DIR)) {
            return (int)$cache->getVars();
        }

        $timestamp = 0;
        if ($cache->startDataCache()) {
            try {
                $sql = <<<'SQL'
SELECT UNIX_TIMESTAMP(GREATEST(
    COALESCE((SELECT MAX(TIMESTAMP_X) FROM b_iblock_element), '1970-01-01 00:00:01'),
    COALESCE((SELECT MAX(TIMESTAMP_X) FROM b_iblock_section), '1970-01-01 00:00:01'),
    COALESCE((SELECT MAX(TIMESTAMP_X) FROM b_catalog_price), '1970-01-01 00:00:01'),
    COALESCE((SELECT MAX(TIMESTAMP_X) FROM b_catalog_product), '1970-01-01 00:00:01')
))
SQL;
                $timestamp = (int)Application::getConnection()->queryScalar($sql);
                $cache->endDataCache($timestamp);
            } catch (Throwable $exception) {
                $cache->abortDataCache();
            }
        }

        return $timestamp;
    }
}

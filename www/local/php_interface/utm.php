<?php
/**
 * Сбор UTM-меток и передача их в CRM.
 *
 * Метки приходят только в URL первого захода (например,
 * /?utm_source=yandex&utm_medium=cpc&utm_campaign=...). К моменту отправки
 * формы или оформления заказа этих параметров в URL уже нет, поэтому при
 * первом заходе они сохраняются в cookie и далее добавляются к данным,
 * которые сайт отправляет в Битрикс24.
 */

if (!defined('USTAGE_UTM_COOKIE')) {
    define('USTAGE_UTM_COOKIE', 'USTAGE_UTM');
}

if (!defined('USTAGE_UTM_TTL')) {
    // 90 дней — стандартный срок жизни атрибуции.
    define('USTAGE_UTM_TTL', 90 * 24 * 60 * 60);
}

if (!defined('USTAGE_UTM_FIELDS_FILE')) {
    // Карта «метка → код пользовательского поля сделки» (UF_CRM_...).
    define('USTAGE_UTM_FIELDS_FILE', __DIR__ . '/utm_fields.php');
}

/**
 * Список поддерживаемых меток.
 *
 * @return string[]
 */
function ustageUtmKeys()
{
    return ['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term'];
}

/**
 * Карта соответствия UTM-меток кодам пользовательских полей сделки.
 *
 * Приёмник CRM записывает значения в поля по коду (UF_CRM_...), поэтому
 * одних ключей utm_source недостаточно. Коды по умолчанию рассчитаны на
 * поля, созданные через API с читаемыми кодами; если в Битрикс24 коды
 * числовые (UF_CRM_1690000000), их нужно указать в
 * local/php_interface/utm_fields.php.
 *
 * @return array<string,string>
 */
function ustageUtmCrmFieldMap()
{
    static $map = null;

    if ($map !== null) {
        return $map;
    }

    $map = [
        'utm_source' => 'UF_CRM_UTM_SOURCE',
        'utm_medium' => 'UF_CRM_UTM_MEDIUM',
        'utm_campaign' => 'UF_CRM_UTM_CAMPAIGN',
        'utm_content' => 'UF_CRM_UTM_CONTENT',
        'utm_term' => 'UF_CRM_UTM_TERM',
    ];

    if (!is_file(USTAGE_UTM_FIELDS_FILE)) {
        return $map;
    }

    $custom = include USTAGE_UTM_FIELDS_FILE;
    if (!is_array($custom)) {
        return $map;
    }

    foreach ($custom as $key => $code) {
        if (!is_string($key) || !in_array($key, ustageUtmKeys(), true)) {
            continue;
        }

        // null или пустая строка отключают передачу конкретной метки.
        if ($code === null || $code === '') {
            unset($map[$key]);
            continue;
        }

        if (!is_string($code)) {
            continue;
        }

        $code = trim($code);
        if (!preg_match('/^UF_CRM_[A-Za-z0-9_]+$/', $code)) {
            continue;
        }

        $map[$key] = $code;
    }

    return $map;
}

/**
 * Очищает значение метки: убирает теги, управляющие символы и ограничивает длину.
 *
 * @param mixed $value
 * @return string
 */
function ustageUtmClean($value)
{
    if (is_array($value) || is_object($value)) {
        return '';
    }

    $value = (string)$value;
    $value = strip_tags($value);
    $value = preg_replace('/[\x00-\x1F\x7F]+/u', ' ', $value);

    if ($value === null) {
        return '';
    }

    $value = trim($value);

    if (function_exists('mb_substr')) {
        $value = mb_substr($value, 0, 255, 'UTF-8');
    } else {
        $value = substr($value, 0, 255);
    }

    return $value;
}

/**
 * Достаёт UTM-метки из массива (GET, referer, cookie).
 *
 * @param array $source
 * @return array
 */
function ustageUtmFromArray($source)
{
    $result = [];

    if (!is_array($source)) {
        return $result;
    }

    foreach (ustageUtmKeys() as $key) {
        if (!isset($source[$key])) {
            continue;
        }

        $value = ustageUtmClean($source[$key]);
        if ($value !== '') {
            $result[$key] = $value;
        }
    }

    return $result;
}

/**
 * Домен для cookie: общий для www и без www, пустой для localhost/IP.
 *
 * @param string $host
 * @return string
 */
function ustageUtmCookieDomain($host)
{
    $host = strtolower(trim((string)$host));
    $host = preg_replace('/:\d+$/', '', $host);

    if ($host === '' || strpos($host, '.') === false || filter_var($host, FILTER_VALIDATE_IP)) {
        return '';
    }

    $host = preg_replace('/^www\./', '', $host);

    if ($host === 'localhost'
        || substr($host, -6) === '.local'
        || substr($host, -5) === '.test'
    ) {
        return '';
    }

    return '.' . $host;
}

/**
 * Текущие UTM-метки из cookie.
 *
 * @return array
 */
function ustageUtmGet()
{
    if (empty($_COOKIE[USTAGE_UTM_COOKIE]) || !is_string($_COOKIE[USTAGE_UTM_COOKIE])) {
        return [];
    }

    $data = json_decode($_COOKIE[USTAGE_UTM_COOKIE], true);

    return is_array($data) ? ustageUtmFromArray($data) : [];
}

/**
 * Сохраняет UTM-метки из текущего запроса в cookie.
 * Вызывается на каждом хите, записывает cookie только при наличии меток.
 *
 * @return void
 */
function ustageUtmCapture()
{
    if (PHP_SAPI === 'cli' || headers_sent()) {
        return;
    }

    $incoming = ustageUtmFromArray($_GET);

    // Если редирект на «красивый» URL потерял query, метки можно достать из referer.
    if (empty($incoming) && !empty($_SERVER['HTTP_REFERER'])) {
        $query = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY);
        if (!empty($query)) {
            $refererParams = [];
            parse_str($query, $refererParams);
            $incoming = ustageUtmFromArray($refererParams);
        }
    }

    if (empty($incoming)) {
        return;
    }

    $current = ustageUtmGet();
    $merged = array_merge($current, $incoming);

    if ($merged === $current) {
        return;
    }

    $value = json_encode($merged, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($value === false) {
        return;
    }

    $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
    $isHttps = (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off')
        || (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])
            && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https');

    $options = [
        'expires' => time() + USTAGE_UTM_TTL,
        'path' => '/',
        'secure' => $isHttps,
        'httponly' => true,
        'samesite' => 'Lax',
    ];

    $domain = ustageUtmCookieDomain($host);
    if ($domain !== '') {
        $options['domain'] = $domain;
    }

    setcookie(USTAGE_UTM_COOKIE, $value, $options);
    $_COOKIE[USTAGE_UTM_COOKIE] = $value;
}

/**
 * Добавляет UTM-метки к данным, которые уходят в CRM.
 *
 * UTM_SOURCE не перезаписываем: в этом поле остаётся название формы,
 * которое приходит из свойства инфоблока/заказа. Реальные метки передаём
 * отдельными ключами:
 *  - utm_source, utm_medium, ... — для полей CRM, созданных под эти метки;
 *  - UTM_MEDIUM, UTM_CAMPAIGN, UTM_CONTENT, UTM_TERM — стандартные поля сделки;
 *  - UF_CRM_... — коды пользовательских полей сделки из ustageUtmCrmFieldMap().
 *
 * @param array $fields
 * @return void
 */
function ustageUtmApplyToCrmFields(&$fields)
{
    if (!is_array($fields)) {
        return;
    }

    $utm = ustageUtmGet();
    if (empty($utm)) {
        return;
    }

    foreach ($utm as $key => $value) {
        $fields[$key] = $value;
    }

    $standardFields = [
        'utm_medium' => 'UTM_MEDIUM',
        'utm_campaign' => 'UTM_CAMPAIGN',
        'utm_content' => 'UTM_CONTENT',
        'utm_term' => 'UTM_TERM',
    ];

    foreach ($standardFields as $key => $crmKey) {
        if (!empty($utm[$key])) {
            $fields[$crmKey] = $utm[$key];
        }
    }

    // Пользовательские поля сделки: Битрикс24 заполняет их только по коду UF_CRM_*.
    foreach (ustageUtmCrmFieldMap() as $key => $crmKey) {
        if (!empty($utm[$key])) {
            $fields[$crmKey] = $utm[$key];
        }
    }
}

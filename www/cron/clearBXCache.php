<?php
$_SERVER['DOCUMENT_ROOT'] = __DIR__.'/../';
$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);
define('BX_CRONTAB', true);
define('BX_NO_ACCELERATOR_RESET', true);


// Настройки телеграм-уведомления
defined('TG_BOT_TOKEN') || define('TG_BOT_TOKEN', '6603974711:AAHYfO7DaXj5qfbCw6GlV87iEKf80w7wL78');
defined('TG_API_URL') || define('TG_API_URL', 'https://api.telegram.org/bot' . TG_BOT_TOKEN . '/');
defined('TG_CHAT_ID') || define('TG_CHAT_ID', -4145833312); // Ustage-Group Log

if (!function_exists("sendAlarmTG")) {
    function sendAlarmTG($text) {
        try {
            $reply = urlencode(
                $text . 
                PHP_EOL
                // '$_SERVER[\'HTTP_X_FORWARDED_FOR\'] = ' . $_SERVER['HTTP_X_FORWARDED_FOR'] //. PHP_EOL .
                // '$_SERVER[\'REMOTE_ADDR\'] = ' . $_SERVER['REMOTE_ADDR']
            );
            $sendto = TG_API_URL . 'sendmessage?chat_id=' . TG_CHAT_ID . '&text=' . $reply;
            file_get_contents($sendto);
        } catch (Exception $e) {
            // nothing
        }
    }
}

if (!function_exists("sendFileTG")) {
    function sendFileTG($file_path, $url) {
        try {
            $arrayQuery = array(
                'chat_id' => TG_CHAT_ID,
                'caption' => 'Лог работы скрипта ' . $url,
                'document' => new \CURLFile($file_path)
            );      
            $ch = curl_init(TG_API_URL . 'sendDocument');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $arrayQuery);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
            $res = curl_exec($ch);
            curl_close($ch);
        } catch (Exception $e) {
            // nothing
        }
    }
}

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

@set_time_limit(0);
@ignore_user_abort(true);

echo date('d.m.Y');

sendAlarmTG('🏁 /cron/clearBXCache.php. Запускается BXClearCache(true).');

BXClearCache(true);
$GLOBALS["CACHE_MANAGER"]->CleanAll();
$GLOBALS["stackCacheManager"]->CleanAll();
$taggedCache = \Bitrix\Main\Application::getInstance()->getTaggedCache();
$taggedCache->deleteAllTags();
$page = \Bitrix\Main\Composite\Page::getInstance();
$page->deleteAll();
 
sendAlarmTG('/cron/clearBXCache.php. Завершается BXClearCache(true) 🔚');

mail('diz55@mail.ru,a.nesbitnov@altera-media.com,n.krasilnikova@altera-media.com', 'ustage clear cache', 'ustage clear cache'); 

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php');


?>
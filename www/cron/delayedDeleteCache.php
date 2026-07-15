<?php
$_SERVER['DOCUMENT_ROOT'] = __DIR__.'/../';
$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];

define("NO_KEEP_STATISTIC", true);
define("PUBLIC_AJAX_MODE", true);
define("STOP_STATISTICS", true);
define("NO_AGENT_STATISTIC", true);
define("NO_AGENT_CHECK", true);

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

echo date('d.m.Y h:m:i');

\Bitrix\Main\Data\CacheEngineFiles::delayedDelete(1000);

mail('diz55@mail.ru', 'ustage clear ~', 'ustage clear ~'); 

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php');
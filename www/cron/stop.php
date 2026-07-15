<?php
//$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__).'/../../../..');
$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);
define('BX_CRONTAB', true);
define('BX_NO_ACCELERATOR_RESET', true);

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

@set_time_limit(0);
@ignore_user_abort(true);

CModule::IncludeModule('energosoft.utils');
CModule::IncludeModule('iblock');
CModule::IncludeModule('catalog');

$arStatus = ESUtils::LoadOption('status');

$arStatus['RUN'] = 'STOP';
ESUtils::SaveOption('status', $arStatus);

/*
ESParser::clean(null, 300);
ESParser::cleanResizeCache();
*/

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_after.php';

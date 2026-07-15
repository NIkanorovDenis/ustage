<?php
/** @var @global CMain $APPLICATION */
global $APPLICATION;

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

CModule::IncludeModule('iblock');

require $_SERVER['DOCUMENT_ROOT'] . '/send/PHPMailer/src/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/send/PHPMailer/src/Exception.php';

require $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php";

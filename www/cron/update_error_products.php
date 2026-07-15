<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);
define('BX_CRONTAB', true);
define('BX_NO_ACCELERATOR_RESET', true);

@ignore_user_abort(true);

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

//CModule::IncludeModule('iblock');
//CModule::IncludeModule('catalog');
//
//$obElement = CIBlockElement::GetList(array(), array(
//    'IBLOCK_ID' => 32,
//    'IBLOCK_SECTION_ID' => 3669
//), false, false, array('ID'));

//while ($arItem=$obElement->Fetch()){
//    CIBlockElement::Delete($arItem['ID']);
//}

require_once('crest.php');

var_dump(CRest::call(
    'crm.contact.list',
    [
        'FILTER' => ['PHONE' => 77777777]
    ])
);
<?php
    ini_set('error_reporting' , 1);
    ini_set('display_errors' , 1);
    ini_set('display_startup_errors' , 1);

    error_reporting(E_ALL);

    @set_time_limit(0);
    @ignore_user_abort(true);

    require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';
    CModule::IncludeModule('energosoft.utils');
    try {
        EsParser::SlamiAdd();
       //ESParser::Slami();
    } catch (Exception $exception){
        echo $exception;
    }


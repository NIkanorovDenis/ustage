<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if ($arParams['BXR_PRESENT_SETTINGS']["BXREADY_LIST_SLIDER"] == "Y" ||  true):
    $APPLICATION->AddHeadScript('/bitrix/js/alexkova.bxready2/slick/slick.js');
    $APPLICATION->SetAdditionalCSS('/bitrix/js/alexkova.bxready2/slick/slick.css', false);
endif;
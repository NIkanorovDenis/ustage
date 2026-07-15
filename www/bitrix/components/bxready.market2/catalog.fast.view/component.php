<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (intval($arParams["IBLOCK_ID"]) <= 0)
    return false;

if ( \Bitrix\Main\Loader::includeModule("alexkova.bxready2"))
    \Alexkova\Bxready2\Component::prepareParams($arParams, "bxready.market2:catalog.fast.view");

$this->IncludeComponentTemplate();
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!\Bitrix\Main\Loader::includeModule('alexkova.market2')
    || !\Bitrix\Main\Loader::includeModule('alexkova.bxready2')   
    || !\Bitrix\Main\Loader::includeModule('iblock') )
    return ;

if( \COption::GetOptionString( 'alexkova.market2', "regions_mode_domain"."_".SITE_TEMPLATE_ID, "N") == "Y")
    $arParams["USE_DOMAIN"] = "Y";

\Alexkova\Bxready2\Component::prepareParams($arParams, "bxready.market2:region.selector");

if(isset($arParams["HIDE_COMPONENT"]) && $arParams["HIDE_COMPONENT"]=="Y")
    return false;

if( \COption::GetOptionString( 'alexkova.market2', "regions_mode"."_".SITE_TEMPLATE_ID, "N") != "Y")
    return false;


CJSCore::Init(array('ajax', 'window'));

$arResult = array();

$marketRegistry = \Alexkova\Market2\Bxmarket::getInstance();

$arResult['REGION_INFO'] = $marketRegistry->getRegionData();

$arCacheParams = array(
	$arResult['use_geoip'],
	$arResult['detect_region']
);



if($_REQUEST["ajax_mode"] !== "yes")
    $this->arParams["CURRENT_PAGE"] = $APPLICATION->GetCurPage(false);

if ($_REQUEST["ajax_mode"] === "yes") {
    $arResult['REGION_LIST'] = $this->getList();
    $this->IncludeComponentTemplate();
} elseif ($this->StartResultCache(false,$arResult['REGION_INFO']['current_region'])) {
    $arResult['REGION_LIST'] = $this->getList();
	$arResult['REGION_LIST_ALL'] = $this->getList(true);
	$this->IncludeComponentTemplate();
} elseif ($_REQUEST["ajax_call"] === "y" && $_REQUEST["INPUT_ID"]=="title-search-input-region") {
    $APPLICATION->RestartBuffer();
    $this->IncludeComponentTemplate();
    CMain::FinalActions();
    die();
}
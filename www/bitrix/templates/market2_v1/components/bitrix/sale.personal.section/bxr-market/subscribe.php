<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;

if ($arParams['SHOW_SUBSCRIBE_PAGE'] !== 'Y')
{
	LocalRedirect($arParams['SEF_FOLDER']);
}

if (strlen($arParams["MAIN_CHAIN_NAME"]) > 0)
{
	$APPLICATION->AddChainItem(htmlspecialcharsbx($arParams["MAIN_CHAIN_NAME"]), $arResult['SEF_FOLDER']);
}
$APPLICATION->AddChainItem(Loc::getMessage("SPS_CHAIN_SUBSCRIBE_NEW"));

$type = htmlspecialchars($_REQUEST['type']);
?><a class="bxr-subscribe-tab-link bxr-font-color bxr-border-color<?=$type != 'list' ? ' bxr-color' : ''?>" data-tab="products"><?=GetMessage("BXR_SUBSCRIBE_PRODUCTS")?></a>
<a class="bxr-subscribe-tab-link bxr-font-color bxr-border-color<?=$type == 'list' ? ' bxr-color' : ''?>" data-tab="list"><?=GetMessage("BXR_SUBSCRIBE_LIST")?></a>
<div class="bxr-subscribe-tab<?=$type == 'list' ? ' bxr-hidden' : ''?>" data-tab="products"><?
    $APPLICATION->IncludeComponent(
        'bitrix:catalog.product.subscribe.list',
        'market',
        array('SET_TITLE' => $arParams['SET_TITLE'])
        ,
        $component
    );
?></div>
<div class="bxr-subscribe-tab<?=$type != 'list' ? ' bxr-hidden' : ''?>" data-tab="list"><?
    $APPLICATION->IncludeComponent(
        "bitrix:subscribe.edit",
        "market",
        array(
            "SHOW_HIDDEN" => "N",
            "ALLOW_ANONYMOUS" => "Y",
            "SHOW_AUTH_LINKS" => "Y",
            "CACHE_TIME" => "36000000",
            "SET_TITLE" => "N",
            "COMPONENT_TEMPLATE" => "market",
            "AJAX_MODE" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "AJAX_OPTION_HISTORY" => "N",
            "AJAX_OPTION_ADDITIONAL" => "",
            "CACHE_TYPE" => "A"
        ),
        false
);
?></div>

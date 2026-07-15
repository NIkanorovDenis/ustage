<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if ( \Bitrix\Main\Loader::includeModule("alexkova.bxready2"))
    \Alexkova\Bxready2\Component::prepareParams($arParams, "bxready.market2:one.click.order.basket");

if ($arParams['PERSONAL_DATA'] == "Y") {
    $arResult["USE_PERSONAL_ACCEPT"] = true;
    $arResult['PERSONAL_SETTINGS'] = array(
        'CAPTION' => $arParams['PERSONAL_DATA_TEXT'],
        'ACCEPT_DOCUMENT' => $arParams['PERSONAL_DATA_CAPTION'],
        'URL' => $arParams['PERSONAL_DATA_URL'],
    );
} else
    $arResult["USE_PERSONAL_ACCEPT"] = false;

if ($arParams["AJAX_MODE"] == "Y") {    
    foreach ($_REQUEST["ORDER_FIELDS"] as $fieldName => $fieldVal) {
        $arResult["ORDER_FIELDS"][$fieldName] = trim($fieldVal);
    }

    $orderParams = $arResult["ORDER_FIELDS"];
    $orderStatus = OneClickOrder::makeOrder($orderParams);
    
    $arResult["ORDER_STATUS"] = $orderStatus;
}
$this->IncludeComponentTemplate();
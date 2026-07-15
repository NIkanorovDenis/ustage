<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $arSortGlobal, $bestsallersGrid, $unicumID;

$sort = $arSortGlobal["sort"];
$sort_order = $arSortGlobal["sort_order"];
//$unicumID = ($unicumID <= 0) ? $unicumID = 1 : $unicumID++;
    
$commonListParams = array(
    "COMPONENT_TEMPLATE" => "",
    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
    "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
    "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],		
    "SHOW_NAME" => "Y",
    "SHOW_IMAGE" => "Y",
    "FILTER_NAME" => $arParams["FILTER_NAME"],
    "ORDER_FILTER_NAME" => "arOrderFilter",
    "BY" => array(
        0 => "AMOUNT",
    ),
    "PERIOD" => array(
        0 => "15",
    ),
    "FILTER" => array(
        0 => "CANCELED",
        1 => "ALLOW_DELIVERY",
        2 => "PAYED",
        3 => "DEDUCTED",
        4 => "N",
        5 => "P",
        6 => "F",
    ),		
    "HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
    "HIDE_NOT_AVAILABLE_OFFERS" => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
    "ELEMENT_SORT_FIELD" => $sort,
    "ELEMENT_SORT_ORDER" => $sort_order,
    "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
    "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
    "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
    "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
    "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
    "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
    "PAGE_ELEMENT_COUNT" => $arParams["BESTSALLERS_CNT"],
    "LINE_ELEMENT_COUNT" => $arParams["BESTSALLERS_CNT"],
    "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
    "PROPERTY_CODE_MOBILE" => $arParams["LIST_PROPERTY_CODE_MOBILE"],
    "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
    "OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
    "OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],
    "PRODUCT_DISPLAY_MODE" => $arParams["PRODUCT_DISPLAY_MODE"],
    "ADDITIONAL_PICT_PROP_".$arParams["IBLOCK_ID"] => $arParams["ADD_PICT_PROP"],
    "ADDITIONAL_PICT_PROP_".$arRecomData["OFFER_IBLOCK_ID"] => $arParams["OFFER_ADD_PICT_PROP"],    
    "SHOW_PRODUCTS_".$arParams["IBLOCK_ID"] => "Y",
    "OFFER_TREE_PROPS_".$arRecomData["OFFER_IBLOCK_ID"] => $arParams["OFFER_TREE_PROPS"],
    "PRODUCT_SUBSCRIPTION" => $arParams["PRODUCT_SUBSCRIPTION"],		
    "SHOW_DISCOUNT_PERCENT" => $arParams["SHOW_DISCOUNT_PERCENT"],		
    "SHOW_OLD_PRICE" => $arParams["SHOW_OLD_PRICE"],
    "BXR_SHOW_MAX_QUANTITY" => $arParams["SHOW_MAX_QUANTITY"],		
    "SHOW_CLOSE_POPUP" => isset($arParams["COMMON_SHOW_CLOSE_POPUP"]) ? $arParams["COMMON_SHOW_CLOSE_POPUP"] : "", 		
    "MESS_BTN_BUY" => (isset($arParams["~MESS_BTN_BUY"]) ? $arParams["~MESS_BTN_BUY"] : ""),
    "MESS_BTN_ADD_TO_BASKET" => (isset($arParams["~MESS_BTN_ADD_TO_BASKET"]) ? $arParams["~MESS_BTN_ADD_TO_BASKET"] : ""),
    "MESS_BTN_SUBSCRIBE" => (isset($arParams["~MESS_BTN_SUBSCRIBE"]) ? $arParams["~MESS_BTN_SUBSCRIBE"] : ""),
    "MESS_BTN_DETAIL" => (isset($arParams["~MESS_BTN_DETAIL"]) ? $arParams["~MESS_BTN_DETAIL"] : ""),
    "MESS_NOT_AVAILABLE" => (isset($arParams["~MESS_NOT_AVAILABLE"]) ? $arParams["~MESS_NOT_AVAILABLE"] : ""),
    "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
    "CACHE_TIME" => $arParams["CACHE_TIME"],
    "CACHE_FILTER" => $arParams["CACHE_FILTER"],
    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
    "ACTION_VARIABLE" => (!empty($arParams["ACTION_VARIABLE"]) ? $arParams["ACTION_VARIABLE"] : "action")."_slb",
    "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
    "PRICE_CODE" => $arParams["PRICE_CODE"],
    "USE_PRICE_COUNT" => "N",
    "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
    "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
    "CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
    "CURRENCY_ID" => $arParams["CURRENCY_ID"],
    "BASKET_URL" => $arParams["BASKET_URL"],
    "USE_PRODUCT_QUANTITY" => $arParams["USE_PRODUCT_QUANTITY"],
    "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
    "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ""),
    "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
    "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ""),
    "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],		
    "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],		
    "ADD_TO_BASKET_ACTION" => $basketAction,
    "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
    "COMPARE_PATH" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["compare"],
    "MESS_BTN_COMPARE" => (isset($arParams["~MESS_BTN_COMPARE"]) ? $arParams["~MESS_BTN_COMPARE"] : ""),
    "COMPARE_NAME" => $arParams["COMPARE_NAME"],		
    "MESS_SHOW_MAX_QUANTITY" => (isset($arParams["~MESS_SHOW_MAX_QUANTITY"]) ? $arParams["~MESS_SHOW_MAX_QUANTITY"] : ""),
    "RELATIVE_QUANTITY_FACTOR" => (isset($arParams["RELATIVE_QUANTITY_FACTOR"]) ? $arParams["RELATIVE_QUANTITY_FACTOR"] : ""),
    "MESS_RELATIVE_QUANTITY_MANY" => (isset($arParams["~MESS_RELATIVE_QUANTITY_MANY"]) ? $arParams["~MESS_RELATIVE_QUANTITY_MANY"] : ""),
    "MESS_RELATIVE_QUANTITY_FEW" => (isset($arParams["~MESS_RELATIVE_QUANTITY_FEW"]) ? $arParams["~MESS_RELATIVE_QUANTITY_FEW"] : ""),
    "QUANTITY_IN_STOCK" => (isset($arParams["~QUANTITY_IN_STOCK"]) ? $arParams["~QUANTITY_IN_STOCK"] : ""),
    "QUANTITY_OUT_STOCK" => (isset($arParams["~QUANTITY_OUT_STOCK"]) ? $arParams["~QUANTITY_OUT_STOCK"] : ""),
    "PAGE_BLOCK_TITLE" => $arParams["BESTSALLERS_TITLE"],
    "THIS_UNIC_ID" => "bestsellers"
);

if ($arParams["BXR_EXT_LIST_SETTINGS_MODE"] == "Y" || $arParams["BXR_EXT_LIST_SETTINGS_SALELEADER"] != "Y")
    $allBXRPrefix = array("_OTHER");        
else
    $allBXRPrefix = array("_SALELEADER");       


foreach ($arParams as $cell => $val) {
    foreach ($allBXRPrefix as $prefix) {
        if (substr_count($cell, "~") > 0) continue;
        if (substr($cell, strlen($cell)-strlen($prefix), strlen($prefix)) == $prefix)
            $additionalListParams["BXR_SALELEADER"][substr($cell, 0, strlen($cell)-strlen($prefix))] =  $val;
        $arGridParams = array(
            "BXREADY_LIST_XLG_CNT".$prefix, 
            "BXREADY_LIST_LG_CNT".$prefix, 
            "BXREADY_LIST_MD_CNT".$prefix, 
            "BXREADY_LIST_SM_CNT".$prefix, 
            "BXREADY_LIST_XS_CNT".$prefix
        );
        if ($bestsallersGrid == "col" && in_array($cell, $arGridParams))
            $additionalListParams["BXR_SALELEADER"][substr($cell, 0, strlen($cell)-strlen($prefix))] =  12;
    }
}

$arBestsallersParams = array_merge($commonListParams, $additionalListParams);
$arBestsallersParams["PAGE_ELEMENT_COUNT"] = $arParams["BESTSALLERS_CNT"];
$arBestsallersParams["REGION"] = $arParams["REGION"];
$arBestsallersParams["USE_BXR_STORES"] = $arParams["USE_BXR_STORES"];
$arBestsallersParams["STORES"] = $arParams["STORES"];

$APPLICATION->IncludeComponent(
    "bitrix:sale.bestsellers",
    "",
    $arBestsallersParams,
    $component,
    array("HIDE_ICONS" => "Y")
);
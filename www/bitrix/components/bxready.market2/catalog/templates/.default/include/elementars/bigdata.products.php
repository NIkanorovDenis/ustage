<?
global $unicumID;

$unicumID = ($unicumID <= 0) ? $unicumID = 1 : $unicumID++;

$commonListParams = array(
    "LINE_ELEMENT_COUNT" => $arParams["BIG_DATA_CNT"],
    "TEMPLATE_THEME" => (isset($arParams["TEMPLATE_THEME"]) ? $arParams["TEMPLATE_THEME"] : ""),
    //"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
    "BASKET_URL" => $arParams["BASKET_URL"],
    "ACTION_VARIABLE" => (!empty($arParams["ACTION_VARIABLE"]) ? $arParams["ACTION_VARIABLE"] : "action")."_cbdp",
    "SHOW_CLOSE_POPUP" => isset($arParams["COMMON_SHOW_CLOSE_POPUP"]) ? $arParams["COMMON_SHOW_CLOSE_POPUP"] : "", 
    "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
    "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],    		
    "ADD_TO_BASKET_ACTION" => $basketAction,
    "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ""),
    "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
    "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ""),
    "SHOW_OLD_PRICE" => $arParams["SHOW_OLD_PRICE"],
    "SHOW_DISCOUNT_PERCENT" => $arParams["SHOW_DISCOUNT_PERCENT"],
    "PRICE_CODE" => $arParams["PRICE_CODE"],
    "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
    "PRODUCT_SUBSCRIPTION" => $arParams["PRODUCT_SUBSCRIPTION"],
    "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
    "USE_PRODUCT_QUANTITY" => $arParams["USE_PRODUCT_QUANTITY"],
    "SHOW_NAME" => "Y",
    "SHOW_IMAGE" => "Y",
    "MESS_BTN_BUY" => $arParams["MESS_BTN_BUY"],
    "MESS_BTN_DETAIL" => $arParams["MESS_BTN_DETAIL"],
    "MESS_BTN_SUBSCRIBE" => $arParams["MESS_BTN_SUBSCRIBE"],
    "MESS_NOT_AVAILABLE" => $arParams["MESS_NOT_AVAILABLE"],
    "MESS_BTN_ADD_TO_BASKET" => (isset($arParams["~MESS_BTN_ADD_TO_BASKET"]) ? $arParams["~MESS_BTN_ADD_TO_BASKET"] : ""),
    "PAGE_ELEMENT_COUNT" => $arParams["BIG_DATA_CNT"],
    "SHOW_FROM_SECTION" => "N",
    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
    "OFFERS_IBLOCK_ID" => $arRecomData["OFFER_IBLOCK_ID"],
    "DEPTH" => "2",
    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
    "CACHE_TIME" => $arParams["CACHE_TIME"],
    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
    "SHOW_PRODUCTS_".$arParams["IBLOCK_ID"] => "Y",
    "HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
    "CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
    "CURRENCY_ID" => $arParams["CURRENCY_ID"],
    "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
    "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
    "SECTION_ELEMENT_ID" => "",
    "SECTION_ELEMENT_CODE" => "",
    "LABEL_PROP_".$arParams["IBLOCK_ID"] => $arParams["LABEL_PROP"],
    "PROPERTY_CODE_".$arParams["IBLOCK_ID"] => $arParams["LIST_PROPERTY_CODE"],
    "PROPERTY_CODE_".$arRecomData["OFFER_IBLOCK_ID"] => $arParams["LIST_OFFERS_PROPERTY_CODE"],
    "CART_PROPERTIES_".$arParams["IBLOCK_ID"] => $arParams["PRODUCT_PROPERTIES"],
    "CART_PROPERTIES_".$arRecomData["OFFER_IBLOCK_ID"] => $arParams["OFFERS_CART_PROPERTIES"],
    "ADDITIONAL_PICT_PROP_".$arParams["IBLOCK_ID"] => $arParams["ADD_PICT_PROP"],
    "ADDITIONAL_PICT_PROP_".$arRecomData["OFFER_IBLOCK_ID"] => $arParams["OFFER_ADD_PICT_PROP"],
    "OFFER_TREE_PROPS_".$arRecomData["OFFER_IBLOCK_ID"] => $arParams["OFFER_TREE_PROPS"],
    "RCM_TYPE" => (isset($arParams["BIG_DATA_RCM_TYPE"]) ? $arParams["BIG_DATA_RCM_TYPE"] : ""),
    "BLOCK_TITLE" => $arParams["BIG_DATA_TITLE"],
    "USE_VOTE_RATING" => $arParams["DETAIL_USE_VOTE_RATING"],
    "VOTE_DISPLAY_AS_RATING" => $arParams["DETAIL_VOTE_DISPLAY_AS_RATING"],                    
    "SHOW_MAX_QUANTITY" => $arParams["BXR_SHOW_MAX_QUANTITY"],
    "MESS_SHOW_MAX_QUANTITY" => $arParams["MESS_SHOW_MAX_QUANTITY"],
    "RELATIVE_QUANTITY_FACTOR" => $arParams["RELATIVE_QUANTITY_FACTOR"],
    "MESS_RELATIVE_QUANTITY_MANY" => $arParams["MESS_RELATIVE_QUANTITY_MANY"],
    "MESS_RELATIVE_QUANTITY_FEW" => $arParams["MESS_RELATIVE_QUANTITY_FEW"],                                        
    "QUANTITY_IN_STOCK" => $arParams["QUANTITY_IN_STOCK"],
    "QUANTITY_OUT_STOCK" => $arParams["QUANTITY_OUT_STOCK"],                                        
    "PRODUCT_DISPLAY_MODE" => $arParams["PRODUCT_DISPLAY_MODE"],
    "DISPLAY_COMPARE" => (isset($arParams["USE_COMPARE"]) ? $arParams["USE_COMPARE"] : ""),
    "COMPARE_PATH" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["compare"],
    "OFFERS_VIEW" => $arParams["OFFERS_VIEW"],
    "THIS_UNIC_ID" => $unicumID."_bigdata",
	"BXR_LAZY_LOAD" => "N",

);

if ($arParams["BXR_EXT_LIST_SETTINGS_MODE"] == "Y" || $arParams["BXR_EXT_LIST_SETTINGS_BIGDATA"] != "Y")
    $allBXRPrefix = array("_OTHER");        
else
    $allBXRPrefix = array("_BIGDATA");       

foreach ($arParams as $cell => $val) {
    foreach ($allBXRPrefix as $prefix) {
        if (substr_count($cell, "~") > 0) continue;
        if (substr($cell, strlen($cell)-strlen($prefix), strlen($prefix)) == $prefix)
            $additionalListParams["BXR_BIGDATA"][substr($cell, 0, strlen($cell)-strlen($prefix))] =  $val;
    }
}

$arBigDataParams = array_merge($commonListParams, $additionalListParams);
$arBigDataParams['PAGE_ELEMENT_COUNT'] = $arParams["BIG_DATA_CNT"];
$arBigDataParams["REGION"] = $arParams["REGION"];

$APPLICATION->IncludeComponent(
    "bitrix:catalog.bigdata.products", 
    ".default", 
    $arBigDataParams,
    false,
    array("HIDE_ICONS" => "Y")
);
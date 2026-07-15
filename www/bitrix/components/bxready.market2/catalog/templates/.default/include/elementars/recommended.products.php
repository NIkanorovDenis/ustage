<?
$commonListParams = array(
    "ID" => $ElementID,
    "MIN_BUYES" => $arParams["ALSO_BUY_MIN_BUYES"],
    "ELEMENT_COUNT" => $arParams["ALSO_BUY_ELEMENT_COUNT"],
    "LINE_ELEMENT_COUNT" => $arParams["ALSO_BUY_ELEMENT_COUNT"],
    "DETAIL_URL" => $arParams["DETAIL_URL"],
    "BASKET_URL" => $arParams["BASKET_URL"],
    "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
    "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
    "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
    "PAGE_ELEMENT_COUNT" => $arParams["ALSO_BUY_ELEMENT_COUNT"],
    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
    "CACHE_TIME" => $arParams["CACHE_TIME"],
    "PRICE_CODE" => $arParams["PRICE_CODE"],
    "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
    "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
    "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
    'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
    'CURRENCY_ID' => $arParams['CURRENCY_ID'],
    'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
    "SHOW_PRODUCTS_".$arParams["IBLOCK_ID"] => "Y",
    "PROPERTY_CODE_".$arRecomData['OFFER_IBLOCK_ID'] => array(    ),
    "OFFER_TREE_PROPS_".$arRecomData['OFFER_IBLOCK_ID'] => $arParams["OFFER_TREE_PROPS"],
    "BLOCK_TITLE" => $arParams["ALSO_BUY_TITLE"],   
    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
    "BXR_SHOW_MAX_QUANTITY" => $arParams["SHOW_MAX_QUANTITY"],
    "MESS_SHOW_MAX_QUANTITY" => $arParams["MESS_SHOW_MAX_QUANTITY"],
    "RELATIVE_QUANTITY_FACTOR" => $arParams["RELATIVE_QUANTITY_FACTOR"],
    "MESS_RELATIVE_QUANTITY_MANY" => $arParams["MESS_RELATIVE_QUANTITY_MANY"],
    "MESS_RELATIVE_QUANTITY_FEW" => $arParams["MESS_RELATIVE_QUANTITY_FEW"],                                        
    "QUANTITY_IN_STOCK" => $arParams["QUANTITY_IN_STOCK"],
    "QUANTITY_OUT_STOCK" => $arParams["QUANTITY_OUT_STOCK"],                                        
    "PRODUCT_DISPLAY_MODE" => $arParams["PRODUCT_DISPLAY_MODE"],
    'DISPLAY_COMPARE' => (isset($arParams['USE_COMPARE']) ? $arParams['USE_COMPARE'] : ''),
    "COMPARE_PATH" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["compare"],
    'USE_VOTE_RATING' => $arParams['DETAIL_USE_VOTE_RATING'],
    'VOTE_DISPLAY_AS_RATING' => (isset($arParams['DETAIL_VOTE_DISPLAY_AS_RATING']) ? $arParams['DETAIL_VOTE_DISPLAY_AS_RATING'] : ''),
    'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],		
    "SHOW_DISCOUNT_PERCENT" => $arParams["SHOW_DISCOUNT_PERCENT"],
    "USE_PRODUCT_QUANTITY" => $arParams["USE_PRODUCT_QUANTITY"],
    "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],	
    "ADD_TO_BASKET_ACTION" => $basketAction,
    "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
    "SHOW_CLOSE_POPUP" => isset($arParams["COMMON_SHOW_CLOSE_POPUP"]) ? $arParams["COMMON_SHOW_CLOSE_POPUP"] : "", 		
    "MESS_BTN_BUY" => (isset($arParams["~MESS_BTN_BUY"]) ? $arParams["~MESS_BTN_BUY"] : ""),
    "MESS_BTN_ADD_TO_BASKET" => (isset($arParams["~MESS_BTN_ADD_TO_BASKET"]) ? $arParams["~MESS_BTN_ADD_TO_BASKET"] : ""),
    "MESS_BTN_SUBSCRIBE" => (isset($arParams["~MESS_BTN_SUBSCRIBE"]) ? $arParams["~MESS_BTN_SUBSCRIBE"] : ""),
    "MESS_BTN_DETAIL" => (isset($arParams["~MESS_BTN_DETAIL"]) ? $arParams["~MESS_BTN_DETAIL"] : ""),
    "MESS_NOT_AVAILABLE" => (isset($arParams["~MESS_NOT_AVAILABLE"]) ? $arParams["~MESS_NOT_AVAILABLE"] : ""),
    "OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"]
);

if ($arParams["BXR_EXT_LIST_SETTINGS_MODE"] == "Y" || $arParams["BXR_EXT_LIST_SETTINGS_RECOMMENDED"] != "Y")
    $allBXRPrefix = array("_OTHER");        
else
    $allBXRPrefix = array("_RECOMMENDED");       


foreach ($arParams as $cell => $val) {
    foreach ($allBXRPrefix as $prefix) {
        if (substr_count($cell, "~") > 0) continue;
        if (substr($cell, strlen($cell)-strlen($prefix), strlen($prefix)) == $prefix)
            $additionalListParams["BXR_RECOMMENDED"][substr($cell, 0, strlen($cell)-strlen($prefix))] =  $val;
    }
}

$arRecommendedParams = array_merge($commonListParams, $additionalListParams);
$arBestsallersParams["PAGE_ELEMENT_COUNT"] = $arParams["ALSO_BUY_ELEMENT_COUNT"];
$arRecommendedParams["REGION"] = $arParams["REGION"];
$arRecommendedParams["USE_BXR_STORES"] = $arParams["USE_BXR_STORES"];
$arRecommendedParams["STORES"] = $arParams["STORES"];

$APPLICATION->IncludeComponent(
    "bitrix:sale.recommended.products",
    'market_recommended', 
    $arRecommendedParams,
    $component
);
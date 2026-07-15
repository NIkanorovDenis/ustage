<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Web\Json;

global $arSortGlobal, $unicumID;

$sort = $arSortGlobal["sort"];
$sort_order = $arSortGlobal["sort_order"];
$num = $arSortGlobal["num"];
$view = $arSortGlobal["view"]; 
$unicumID = ($unicumID <= 0) ? $unicumID = 1 : $unicumID++;

$commonListParams = array(
    "COMPONENT_TEMPLATE" => $arParams["BXR_LIST_TYPE"],
    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
    "SECTION_ID" => '',
    "SECTION_CODE" => '',
    "BY_LINK" => "Y",
    "FILTER_NAME" => $arParams["FILTER_NAME"],
    "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],		
    "SHOW_ALL_WO_SECTION" => "N",		
    "CUSTOM_FILTER" => "",		
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
    "PAGE_ELEMENT_COUNT" => $num,
    "LINE_ELEMENT_COUNT" => $num,
    "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
    "PROPERTY_CODE_MOBILE" => $arParams["LIST_PROPERTY_CODE_MOBILE"],
    "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
    "OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
    "OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],
    "PRODUCT_DISPLAY_MODE" => $arParams["PRODUCT_DISPLAY_MODE"],
    "ADD_PICT_PROP" => $arParams["ADD_PICT_PROP"],
    "OFFER_ADD_PICT_PROP" => $arParams["OFFER_ADD_PICT_PROP"],
    "OFFER_TREE_PROPS" => $arParams["OFFER_TREE_PROPS"],
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
    "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
    "DETAIL_URL" => $arResult["URL_TEMPLATES"]["element"],
    "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],"CACHE_TYPE" => $arParams["CACHE_TYPE"],
    "CACHE_TIME" => $arParams["CACHE_TIME"],
    "CACHE_FILTER" => $arParams["CACHE_FILTER"],
    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
    "SET_TITLE" => $arParams["SET_TITLE"],		
    "BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],		
    "META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],		
    "META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
    "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
    "USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
    "ADD_SECTIONS_CHAIN" => "N",
    "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
    "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
    "PRICE_CODE" => $arParams["PRICE_CODE"],
    "USE_PRICE_COUNT" => 'N',
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
    "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
    "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
    "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
    "PAGER_TITLE" => $arParams["PAGER_TITLE"],
    "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
    "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
    "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
    "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
    "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
    "PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
    "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
    "LAZY_LOAD" => $arParams["LAZY_LOAD"],
    "MESS_BTN_LAZY_LOAD" => $arParams["~MESS_BTN_LAZY_LOAD"],
    "LOAD_ON_SCROLL" => $arParams["LOAD_ON_SCROLL"],
    "SET_STATUS_404" => $arParams["SET_STATUS_404"],
    "SHOW_404" => $arParams["SHOW_404"],
    "FILE_404" => $arParams["FILE_404"],
    "MESSAGE_404" => $arParams["~MESSAGE_404"],
    "COMPATIBLE_MODE" => (isset($arParams["COMPATIBLE_MODE"]) ? $arParams["COMPATIBLE_MODE"] : ""),
    "DISABLE_INIT_JS_IN_COMPONENT" => (isset($arParams["DISABLE_INIT_JS_IN_COMPONENT"]) ? $arParams["DISABLE_INIT_JS_IN_COMPONENT"] : ""), 
    "USE_ENHANCED_ECOMMERCE" => (isset($arParams["USE_ENHANCED_ECOMMERCE"]) ? $arParams["USE_ENHANCED_ECOMMERCE"] : ""),
    "ENLARGE_PROP" => isset($arParams["LIST_ENLARGE_PROP"]) ? $arParams["LIST_ENLARGE_PROP"] : "",		
    "COMPARE_PATH" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["compare"],
    "MESS_BTN_COMPARE" => (isset($arParams["~MESS_BTN_COMPARE"]) ? $arParams["~MESS_BTN_COMPARE"] : ""),
    "COMPARE_NAME" => $arParams["COMPARE_NAME"],		
    "MESS_SHOW_MAX_QUANTITY" => (isset($arParams["~MESS_SHOW_MAX_QUANTITY"]) ? $arParams["~MESS_SHOW_MAX_QUANTITY"] : ""),
    "RELATIVE_QUANTITY_FACTOR" => (isset($arParams["RELATIVE_QUANTITY_FACTOR"]) ? $arParams["RELATIVE_QUANTITY_FACTOR"] : ""),
    "MESS_RELATIVE_QUANTITY_MANY" => (isset($arParams["~MESS_RELATIVE_QUANTITY_MANY"]) ? $arParams["~MESS_RELATIVE_QUANTITY_MANY"] : ""),
    "MESS_RELATIVE_QUANTITY_FEW" => (isset($arParams["~MESS_RELATIVE_QUANTITY_FEW"]) ? $arParams["~MESS_RELATIVE_QUANTITY_FEW"] : ""),
    "QUANTITY_IN_STOCK" => (isset($arParams["~QUANTITY_IN_STOCK"]) ? $arParams["~QUANTITY_IN_STOCK"] : ""),
    "QUANTITY_OUT_STOCK" => (isset($arParams["~QUANTITY_OUT_STOCK"]) ? $arParams["~QUANTITY_OUT_STOCK"] : ""),
    "HIDE_SECTION_DESCRIPTION" => "Y",
    "THIS_UNIC_ID" => $unicumID."_section",
    "REGION" => (isset($arParams["REGION"]) && !empty($arParams["REGION"])) ? $arParams["REGION"] : "",
    "BXR_AJAX_REGION_INFO" => (isset($arParams["BXR_AJAX_REGION_INFO"]) && !empty($arParams["BXR_AJAX_REGION_INFO"])) ? $arParams["BXR_AJAX_REGION_INFO"] : "",
	"BXR_LAZY_LOAD" => $arParams["BXR_LAZY_LOAD"],
);

$sectionTemplate = ($arParams["BXR_LIST_TYPE"] == ".default" && !in_array($view, array('list', 'table'))) ? ".default" : "bxready";

switch ($view) {
    case 'list':
        $allBXRPrefix = array('_PRESENT_LIST');
        $allBXPrefix = array();
        break;
    case 'table':
        $allBXRPrefix = array('_PRESENT_TABLE');
        $allBXPrefix = array();
        break;
    default: 
        $allBXRPrefix = array('_LISTPAGE');        
        $allBXPrefix = array('_STANDART', '_BIG', '_SMALL');
        break;
}

switch ($sectionTemplate) {
    case "bxready":
        foreach ($arParams as $cell => $val) {
            foreach ($allBXRPrefix as $prefix) {
                if (substr_count($cell, "~") > 0) continue;
                if (substr($cell, strlen($cell)-strlen($prefix), strlen($prefix)) == $prefix)
                    $additionalListParams[str_replace ($prefix, '_LISTPAGE', $cell)] =  $val;
            }
        }
        break;
    case ".default":
	foreach ($arParams as $cell => $val) {
            foreach ($allBXPrefix as $prefix) {
                if (substr_count($cell, "~") > 0) continue;
                if (substr($cell, strlen($cell)-strlen($prefix), strlen($prefix)) == $prefix)
                    $additionalListParams[$cell] =  $val;
            }
	};
        
        $additionalListParams["PAGE_ELEMENT_COUNT"] = $arParams["PAGE_ELEMENT_COUNT"];
        $additionalListParams["LINE_ELEMENT_COUNT"] = $arParams["LINE_ELEMENT_COUNT"];
        $additionalListParams["PRODUCT_ROW_VARIANTS"] = $arParams["PRODUCT_ROW_VARIANTS"];
        break;
    default: 
        $additionalListParams = array();
        break;
}

$arSectionParams = array_merge($commonListParams, $additionalListParams);
$arSectionParams["USE_BIG_DATA"] = "N";
$arSectionParams["CACHE_FILTER"] = "Y";

$intSectionID = $APPLICATION->IncludeComponent(
    "bxready.market2:catalog.section",
    $sectionTemplate,
    $arSectionParams,
    $component,
    array('HIDE_ICONS' => 'Y')
);
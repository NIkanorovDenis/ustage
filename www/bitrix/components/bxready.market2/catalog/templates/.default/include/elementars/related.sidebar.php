<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $notVerticalAlign;
$notVerticalAlign= true;
$arComponentParams = array(
	"ACTIVE_DATE_FORMAT" => "d.m.Y",
	"ADD_SECTIONS_CHAIN" => "N",
	"AJAX_MODE" => "N",
	"AJAX_OPTION_ADDITIONAL" => "",
	"AJAX_OPTION_HISTORY" => "N",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "Y",
	"BXREADY_COLLECTION_DRAW" => $currentParams["BXREADY_COLLECTION_DRAW"],
	"BXREADY_ELEMENT_DRAW" => $currentParams["BXREADY_ELEMENT_DRAW"],
	"BXREADY_LIST_BOOTSTRAP_GRID_STYLE" => $currentParams["BXREADY_LIST_BOOTSTRAP_GRID_STYLE"],
	"BXREADY_LIST_LG_CNT" => $currentParams["BXREADY_LIST_LG_CNT"],
	"BXREADY_LIST_MD_CNT" => $currentParams["BXREADY_LIST_MD_CNT"],
	"BXREADY_LIST_SM_CNT" => $currentParams["BXREADY_LIST_SM_CNT"],
	"BXREADY_LIST_XS_CNT" => $currentParams["BXREADY_LIST_XS_CNT"],
	"BXREADY_LIST_PAGE_BLOCK_TITLE" => $currentParams["BXREADY_LIST_PAGE_BLOCK_TITLE"],
	"BXREADY_LIST_PAGE_BLOCK_TITLE_GLYPHICON" => $currentParams["BXREADY_LIST_PAGE_BLOCK_TITLE_GLYPHICON"],
	"BXREADY_LIST_SLIDER" => $currentParams["BXREADY_LIST_SLIDER"],
	"BXREADY_LIST_TYPES" => $currentParams["BXREADY_LIST_TYPES"],
	"BXREADY_SECTION_DRAW" => $currentParams["BXREADY_SECTION_DRAW"],
	"CACHE_FILTER" => "N",
	"CACHE_GROUPS" => "Y",
	"CACHE_TIME" => $arParams['CACHE_TIME'],
	"CACHE_TYPE" => $arParams['CACHE_TYPE'],
	"CHECK_DATES" => $arParams['CHECK_DATES'],
	"COMPONENT_TEMPLATE" => '.default',
	"DETAIL_URL" => "",
	"DISPLAY_BOTTOM_PAGER" => "N",
	"DISPLAY_TOP_PAGER" => "N",
	"FIELD_CODE" => $currentParams["BXR_RELATED_IBLOCK_FIELDS"],
	"FILTER_NAME" => "arrRelatedFilter",
	"HIDE_LINK_WHEN_NO_DETAIL" => "N",
	"IBLOCK_ID" => $currentParams["BXR_RELATED_IBLOCK_ID"],
	"IBLOCK_TYPE" => $currentParams["BXR_RELATED_IBLOCK_TYPE"],
	"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
	"INCLUDE_SUBSECTIONS" => "Y",
	"NEWS_COUNT" => intval($currentParams["BXR_RELATED_LIST_COUNT"])>0 ? intval($currentParams["BXR_RELATED_LIST_COUNT"]) : 10,
	"PAGER_DESC_NUMBERING" => "N",
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
	"PAGER_SHOW_ALL" => "N",
	"PAGER_SHOW_ALWAYS" => "N",
	"PAGER_TEMPLATE" => ".default",
	"PAGER_TITLE" => "Новости",
	"PARENT_SECTION" => "",
	"PARENT_SECTION_CODE" => "",
	"PREVIEW_TRUNCATE_LEN" => "",
	"PROPERTY_CODE" => $currentParams["BXR_RELATED_IBLOCK_PROPERTIES"],
	"SET_BROWSER_TITLE" => "N",
	"SET_META_DESCRIPTION" => "N",
	"SET_META_KEYWORDS" => "N",
	"SET_STATUS_404" => "N",
	"SET_TITLE" => "N",
	"SORT_BY1" => $currentParams["BXR_RELATED_IBLOCK_SORT_FILELD"],
	"SORT_BY2" => "SORT",
	"SORT_ORDER1" => $currentParams["BXR_RELATED_IBLOCK_SORT_ORDER"],
	"SORT_ORDER2" => "ASC",
	"BXREADY_USER_TYPES" =>$currentParams["BXREADY_USER_TYPES"],
	"BXREADY_USER_TYPE_VARIANT" =>$currentParams["BXREADY_USER_TYPE_VARIANT"],
	"BXREADY_LIST_VERTICAL_SLIDER_MODE" => $currentParams["BXREADY_LIST_VERTICAL_SLIDER_MODE"],
	"BXREADY_LIST_HIDE_SLIDER_ARROWS" => $currentParams["BXREADY_LIST_HIDE_SLIDER_ARROWS"],
	"BXREADY_LIST_SLIDER_MARKERS" => $currentParams["BXREADY_LIST_SLIDER_MARKERS"],
	"BXREADY_LIST_HIDE_MOBILE_SLIDER_ARROWS" => $currentParams["BXREADY_LIST_HIDE_MOBILE_SLIDER_ARROWS"],
	"BXREADY_LIST_HIDE_MOBILE_SLIDER_AUTOSCROLL" => $currentParams["BXREADY_LIST_HIDE_MOBILE_SLIDER_AUTOSCROLL"],
	"BXREADY_ELEMENT_ADDCLASS" => $currentParams["BXREADY_ELEMENT_ADDCLASS"],
	"BXREADY_USE_ELEMENTCLASS" => $currentParams["BXREADY_USE_ELEMENTCLASS"],
);

foreach ($currentParams as $cell=>$val){
    if (substr($cell, 0, 9) == 'BXR_PRST_'){
            $arComponentParams[$cell] = $val;
    }
}

/**/

use Bitrix\Main\Web\Json;
global $arSortGlobal, $unicumID;

$sort = $arSortGlobal["sort"];
$sort_order = $arSortGlobal["sort_order"];
$num = $arSortGlobal["num"];
$view = $arSortGlobal["view"]; 
$unicumID = ($unicumID <= 0) ? $unicumID = 1 : $unicumID++;
                
$commonListParams = array(
    
    "IBLOCK_ID" => $currentParams["BXR_RELATED_IBLOCK_ID"],
    "IBLOCK_TYPE" => $currentParams["BXR_RELATED_IBLOCK_TYPE"],	

    "INCLUDE_SUBSECTIONS" => "Y",
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
    "PAGE_ELEMENT_COUNT" => $arParams["VIEWED_PRODUCTS_CNT"],
    "LINE_ELEMENT_COUNT" => $arParams["VIEWED_PRODUCTS_CNT"],
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
    
    "BXR_SHOW_MAX_QUANTITY" => $arParams["SHOW_MAX_QUANTITY"], //???
    
    "SHOW_CLOSE_POPUP" => isset($arParams["COMMON_SHOW_CLOSE_POPUP"]) ? $arParams["COMMON_SHOW_CLOSE_POPUP"] : "", //?	
    
    "MESS_BTN_BUY" => (isset($arParams["~MESS_BTN_BUY"]) ? $arParams["~MESS_BTN_BUY"] : ""),
    "MESS_BTN_ADD_TO_BASKET" => (isset($arParams["~MESS_BTN_ADD_TO_BASKET"]) ? $arParams["~MESS_BTN_ADD_TO_BASKET"] : ""),
    "MESS_BTN_SUBSCRIBE" => (isset($arParams["~MESS_BTN_SUBSCRIBE"]) ? $arParams["~MESS_BTN_SUBSCRIBE"] : ""),
    "MESS_BTN_DETAIL" => (isset($arParams["~MESS_BTN_DETAIL"]) ? $arParams["~MESS_BTN_DETAIL"] : ""),
    "MESS_NOT_AVAILABLE" => (isset($arParams["~MESS_NOT_AVAILABLE"]) ? $arParams["~MESS_NOT_AVAILABLE"] : ""),
    
    "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
    "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
    "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],"CACHE_TYPE" => $arParams["CACHE_TYPE"],
    
    "CACHE_TIME" => $arParams["CACHE_TIME"],
    "CACHE_FILTER" => $arParams["CACHE_FILTER"],
    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
    
    "SET_TITLE" => "N",		
    "BROWSER_TITLE" => "N",		
    "META_KEYWORDS" => "N",		
    "META_DESCRIPTION" => "N",
    "SET_LAST_MODIFIED" => "N",
    
    "USE_MAIN_ELEMENT_SECTION" => "Y",
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
    
    //"PAGER_TITLE" => $arParams["PAGER_TITLE"],
    "PAGER_SHOW_ALWAYS" => "N",
    "PAGER_DESC_NUMBERING" => "N",
    //"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
    "PAGER_SHOW_ALL" => "N",
    "PAGER_BASE_LINK_ENABLE" => "N",
    "PAGER_BASE_LINK" => "N",
    "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
    "LAZY_LOAD" => $arParams["LAZY_LOAD"],
    "MESS_BTN_LAZY_LOAD" => $arParams["~MESS_BTN_LAZY_LOAD"],
    "LOAD_ON_SCROLL" => $arParams["LOAD_ON_SCROLL"],

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
    
    "FILTER_NAME" => "arrRelatedFilter",
    "SHOW_ALL_WO_SECTION" => "Y",
    
    "SET_BROWSER_TITLE" => "N",
    "SET_META_DESCRIPTION" => "N",
    "SET_META_KEYWORDS" => "N",
    "SET_STATUS_404" => "N",
    "SHOW_404" => "N",
    "SET_TITLE" => "N",
    "MESSAGE_404" => "",
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

$relatedParams = array(
    "BXREADY_LIST_XLG_CNT_LISTPAGE" => $currentParams["BXREADY_LIST_XLG_CNT"],
    "BXREADY_LIST_LG_CNT_LISTPAGE" => $currentParams["BXREADY_LIST_LG_CNT"],
    "BXREADY_LIST_MD_CNT_LISTPAGE" => $currentParams["BXREADY_LIST_MD_CNT"],
    "BXREADY_LIST_SM_CNT_LISTPAGE" => $currentParams["BXREADY_LIST_SM_CNT"],
    "BXREADY_LIST_XS_CNT_LISTPAGE" => $currentParams["BXREADY_LIST_XS_CNT"],
    "BXREADY_ELEMENT_DRAW_LISTPAGE" => $currentParams["BXREADY_ELEMENT_DRAW"],
    "BXREADY_VERTICAL_ALIGN_LISTPAGE" => "N",
);

$arSectionParams = array_merge($commonListParams, $additionalListParams);
$arSectionParams = array_merge($arSectionParams, $relatedParams);

unset($arSectionParams["BXR_RECOMMENDED"]);
unset($arSectionParams["BXR_BIGDATA"]);

?>
<div style="width: 100%">
        <?if($currentParams["BXREADY_LIST_TYPES"]=="ecommerce"):?>
            <?if(!empty($currentParams["BXREADY_LIST_PAGE_BLOCK_TITLE"])):?>
                <h2><?=$currentParams["BXREADY_LIST_PAGE_BLOCK_TITLE"];?></h2>
            <?endif;?>
     
            <?$APPLICATION->IncludeComponent(
                 "bxready.market2:catalog.section",
                 $sectionTemplate,
                 $arSectionParams,
                 $component,
                 array('HIDE_ICONS' => 'Y')
             );?>                     
        <?else:?>
            <?$APPLICATION->IncludeComponent(
                "bxready2:block.list",
                ".default",
                $arComponentParams,
                false,
                array('HIDE_ICONS'=>'Y')
            );?>
        <?endif;?>
</div>
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $arSortGlobal, $viewedFilter, $viewedGrid, $searchElements;

    $sort = $arSortGlobal["sort"];
    $sort_order = $arSortGlobal["sort_order"];

$commonListParams = array(
    "COMPONENT_TEMPLATE" => $arParams["BXR_LIST_TYPE"],
    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
    "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
    "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
    "FILTER_NAME" => "searchFilter",
    "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
    "SHOW_ALL_WO_SECTION" => "Y",
    "CUSTOM_FILTER" => "",
    "HIDE_NOT_AVAILABLE" => "N",//$arParams["HIDE_NOT_AVAILABLE"],
    "HIDE_NOT_AVAILABLE_OFFERS" => "N",$arParams["HIDE_NOT_AVAILABLE_OFFERS"],
    "ELEMENT_SORT_FIELD" => $sort,
    "ELEMENT_SORT_ORDER" => $sort_order,
    "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
    "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
    "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
    "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
    "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
    "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
    "PAGE_ELEMENT_COUNT" => intval($arParams['BXR_SEARCH_PAGE_RESULT_COUNT'])>0 ? $arParams['BXR_SEARCH_PAGE_RESULT_COUNT'] : 8,
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
    "BXR_SHOW_MAX_QUANTITY" => $arParams["SHOW_MAX_QUANTITY"],
    "SHOW_CLOSE_POPUP" => isset($arParams["COMMON_SHOW_CLOSE_POPUP"]) ? $arParams["COMMON_SHOW_CLOSE_POPUP"] : "",
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
    "DISPLAY_TOP_PAGER" => "N",
    "DISPLAY_BOTTOM_PAGER" => "N",
    "PAGER_TITLE" => $arParams["PAGER_TITLE"],
    "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
    "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
    "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
    "PAGER_SHOW_ALL" => "N",
    "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
    "PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
    "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
    "LAZY_LOAD" => "N",//$arParams["LAZY_LOAD"],
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
    "PAGE_BLOCK_TITLE" => $arParams["SEARCH_BLOCK_TITLE"],//$arParams["VIEWED_PRODUCTS_BLOCK_TITLE"],
    "HIDE_SECTION_DESCRIPTION" => "Y"
);

$searchArray = array(
	"RESTART" => $arParams["RESTART"],
	"NO_WORD_LOGIC" => $arParams["NO_WORD_LOGIC"],
	"USE_LANGUAGE_GUESS" => $arParams["USE_LANGUAGE_GUESS"],
	"CHECK_DATES" => $arParams["CHECK_DATES"],
	"arrFILTER" => array("iblock_".$arParams["IBLOCK_TYPE"]),
    "arrFILTER_iblock_".$arParams["IBLOCK_TYPE"] => array($arParams["IBLOCK_ID"]),
	"USE_TITLE_RANK" => $arParams['BXR_SEARCH_USE_TITLE_RANK'],
	"DEFAULT_SORT" => $arParams['BXR_SEARCH_DEFAULT_SORT'],
	"FILTER_NAME" => "addSearchFilter",
	"SHOW_WHERE" => "N",
	"arrWHERE" => array(),
	"SHOW_WHEN" => "N",
	"PAGE_RESULT_COUNT" => intval($arParams['BXR_SEARCH_PAGE_RESULT_COUNT'])>0 ? $arParams['BXR_SEARCH_PAGE_RESULT_COUNT'] : 8,
	"DISPLAY_TOP_PAGER" => "Y",
	"DISPLAY_BOTTOM_PAGER" => "Y",
	"PAGER_TITLE" => "",
	"PAGER_SHOW_ALWAYS" => "N",
	"PAGER_TEMPLATE" => "",
	"CACHE_TIME" => $arParams["CACHE_TIME"],
	"CACHE_FILTER" => $arParams["CACHE_FILTER"],
	"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
	'EXPORT_LIST_PARAMS' => $commonListParams,
	'EXPORT_PARENT_PARAMS' => $arParams
);?>

<div class="bxr-cloud-all bxr-cloud-padding">

	<?
	$searchTitle = GetMessage('CATALOG_SEARCH_TITLE');
	if (strlen($searchTitle)>0){
		$APPLICATION->SetTitle($searchTitle);
	}
	?>

	<h1><?=$APPLICATION->ShowTitle(false)?></h1>
	<?global $addSearchFilter;
    $addSearchFilter['!ITEM_ID'] = 'S%';

	$APPLICATION->IncludeComponent(
		"visualteam:search.page", //bitrix:search.page
		".default",
		$searchArray,
		$component
	);

	?>
</div>

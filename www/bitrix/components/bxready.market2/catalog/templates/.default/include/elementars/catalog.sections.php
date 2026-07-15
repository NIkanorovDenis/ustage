<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Web\Json;

$commonListParams = Array(
	"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
	"IBLOCK_ID" => $arParams["IBLOCK_ID"],
	"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
	"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
	"CACHE_TYPE" => $arParams["CACHE_TYPE"],
	"CACHE_TIME" => $arParams["CACHE_TIME"],
	"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
	"ADD_SECTIONS_CHAIN" => "N",
	"SECTION_FIELDS" => $sectionFields,
	"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
	"SECTION_USER_FIELDS" => array(),
	"SHOW_PARENT_NAME" => "Y",
	"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
	"VIEW_MODE" => "LIST",
	"BXREADY_ELEMENT_DRAW" => $elementLibrary,
	"DETAIL_PAGE_URL_CAPTION" => $arParams["DETAIL_PAGE_URL_CAPTION"],
	"COUNT_ELEMENTS" => (isset($arParams["REGION"]) && !empty($arParams["REGION"])) ? "N" : $arParams["SECTION_COUNT_ELEMENTS"],
	"BXR_LAZY_LOAD" => $arParams["BXR_LAZY_LOAD"],
);

$additionalListParams = array();

$allBXRPrefix = array('_CINDEX');

foreach ($arParams as $cell => $val) {
	foreach ($allBXRPrefix as $prefix) {
		if (substr_count($cell, "~") > 0) continue;
		if (substr($cell, strlen($cell)-strlen($prefix), strlen($prefix)) == $prefix) {
                    $additionalListParams[str_replace ($prefix, '', $cell)] =  $val;
                }
	}
}

$arCatalogParams = array_merge($commonListParams, $additionalListParams);
$arCatalogParams["REGION"] = $arParams["REGION"];

$APPLICATION->IncludeComponent(
	"bxready.market2:catalog.section.tree",
	"",
	$arCatalogParams,
	false,
	array('HIDE_ICONS' => 'Y')
);
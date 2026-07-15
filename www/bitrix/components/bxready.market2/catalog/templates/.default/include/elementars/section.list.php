<?
if ($arResult['USE_SMART_FILTER'] != "Y") {
	$APPLICATION->IncludeComponent(
		"bitrix:catalog.section.list",
		"row",
		array(
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
			"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
			"COUNT_ELEMENTS" => (isset($arParams["REGION"]) && !empty($arParams["REGION"])) ? "N" : $arParams["SECTION_COUNT_ELEMENTS"],
			"TOP_DEPTH" => 1,
			"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
			"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
			"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
			"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
			"ADD_SECTIONS_CHAIN" => "N",
			"REGION" => (isset($arParams["REGION"]) && !empty($arParams["REGION"])) ? $arParams["REGION"] : "",
			"SECTION_USER_FIELDS" => array('UF_BXR_SEO_SECTION')
		),
		$component,
		array("HIDE_ICONS" => "Y")
	);
}

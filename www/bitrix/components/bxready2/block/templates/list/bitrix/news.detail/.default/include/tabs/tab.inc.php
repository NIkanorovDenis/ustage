<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>
<?
$APPLICATION->IncludeComponent(
	"bitrix:main.include", 
	"named_area", 
	array(
		"COMPONENT_TEMPLATE" => "named_area",
		"INCLUDE_PTITLE" => GetMessage("TAB_MORE_TEXT_INCLUDE"),
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_SUFFIX" => "bxr",
		"AREA_FILE_RECURSIVE" => "N",
		"EDIT_TEMPLATE" => "",
		"PATH" => $arParams["BXR_DETAIL_TABS"]["BXR_DETAIL_TAB_INC_URL"]
	),
	false
);
?>
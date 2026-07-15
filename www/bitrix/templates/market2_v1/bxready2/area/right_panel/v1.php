<? global $APPLICATION;?>

<?
$marketRegistry = \Alexkova\Market2\Bxmarket::getInstance();
$contentData = $marketRegistry->getContentData();

if (\Bitrix\Main\Loader::includeModule('alexkova.bxready2')){
	$APPLICATION->IncludeComponent("bxready2:abmanager", "full-responsive", array(
	"SHOW" => "BXR_SIDEBAR",
		"BANTYPE" => "BXR_SIDEBAR",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "0",
		"USE_IN_LG_MODE" => "Y",
		"USE_IN_MD_MODE" => "Y",
		"USE_IN_SM_MODE" => "N",
		"USE_IN_XS_MODE" => "N",
		"COMPONENT_TEMPLATE" => "full-static"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "Y",
		"HIDE_ICONS" => "N"
	)
);};

$APPLICATION->IncludeComponent("bxready.market2:main.include", "named_area", array(
	"AREA_FILE_SHOW" => "sect",
		"AREA_FILE_SUFFIX" => "right_column",
		"EDIT_TEMPLATE" => "",
		"COMPONENT_TEMPLATE" => "named_area",
		"INCLUDE_PTITLE" => "Right Column",
		"AREA_FILE_RECURSIVE" => "Y"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "Y"
	)
);
?>

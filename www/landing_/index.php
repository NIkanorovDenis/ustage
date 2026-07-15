<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Профессиональное  караоке-оборудование для ресторанов, баров и клубов любого формата теперь доступно каждому, звоните нам и наши менеджеры проконсультируют вас!");
$APPLICATION->SetTitle("1С-Битрикс: Управление сайтом");
?><?$APPLICATION->IncludeComponent(
	"concept:pages", 
	".default", 
	array(
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BROWSER_TITLE" => "-",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"COMPOSITE_FRAME_MODE" => "N",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"DETAIL_SET_CANONICAL_URL" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"FILE_404" => "",
		"IBLOCK_ID" => "27",
		"IBLOCK_TYPE" => "concept_hameleon",
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"SEF_FOLDER" => "/landing/",
		"SEF_MODE" => "Y",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "Y",
		"SHOW_404" => "Y",
		"USE_PERMISSIONS" => "N",
		"USE_SHARE" => "N",
		"COMPONENT_TEMPLATE" => ".default",
		"SEF_URL_TEMPLATES" => array(
			"main" => "",
			"page" => "#SECTION_CODE#/",
		)
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
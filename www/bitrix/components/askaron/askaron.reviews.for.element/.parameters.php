<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"PARAMETERS" => array(
		"AJAX_MODE" => array(),
		"ELEMENT_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("ASKARON_REVIEWS_ELEMENT_ID"),
			"TYPE" => "STRING",
			"DEFAULT" => '={$ELEMENT_ID}',
		),
//		"CURRENT_USER" => array(
//			"PARENT" => "BASE",
//			"NAME" => GetMessage("ASKARON_REVIEWS_USER_ID"),
//			"TYPE" => "CHECKBOX",
//			"DEFAULT" => 'N',
//		),
		"PAGE_ELEMENT_COUNT" => array(
		   "PARENT" => "VISUAL",
		   "NAME" => GetMessage("ASKARON_REVIEWS_PAGE_ELEMENT_COUNT"),
		   "TYPE" => "VALUE",
		   "DEFAULT" => "20",
		),		
		"CACHE_TIME"  =>  Array("DEFAULT"=>86400),
	),
);

if(!CModule::IncludeModule("iblock"))
{
	return;
}

CIBlockParameters::AddPagerSettings($arComponentParameters, GetMessage("ASKARON_REVIEWS_PAGE_NAVIGATION_NAME"), true, true);

//DISPLAY_BOTTOM_PAGER
//PAGER_TEMPLATE
unset( $arComponentParameters["PARAMETERS"]["DISPLAY_TOP_PAGER"] );
unset( $arComponentParameters["PARAMETERS"]["PAGER_DESC_NUMBERING"] );
unset( $arComponentParameters["PARAMETERS"]["PAGER_TITLE"] );
unset( $arComponentParameters["PARAMETERS"]["PAGER_SHOW_ALWAYS"] );
unset( $arComponentParameters["PARAMETERS"]["PAGER_DESC_NUMBERING"] );
unset( $arComponentParameters["PARAMETERS"]["PAGER_DESC_NUMBERING_CACHE_TIME"] );
unset( $arComponentParameters["PARAMETERS"]["PAGER_SHOW_ALL"] );
?>

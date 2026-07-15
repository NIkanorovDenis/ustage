<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
if(!CModule::IncludeModule("iblock"))
    return;

$arTypesEx = CIBlockParameters::GetIBlockTypes(array("-"=>" "));

$arIBlocks=array();
$db_iblock = CIBlock::GetList(array("SORT"=>"ASC"), array("SITE_ID"=>$_REQUEST["site"], "TYPE" => ($arCurrentValues["IBLOCK_TYPE"]!="-"?$arCurrentValues["IBLOCK_TYPE"]:"")));
while($arRes = $db_iblock->Fetch())
    $arIBlocks[$arRes["ID"]] = $arRes["NAME"];
$arSections=array();
$arSections[] = GetMessage('IBLOCK_SECTION_NONE');
$arFilterSect = array("SITE_ID"=>$_REQUEST["site"], "TYPE" => ($arCurrentValues["IBLOCK_TYPE"]!="-"?$arCurrentValues["IBLOCK_TYPE"]:""), "IBLOCK_ID" => ($arCurrentValues["IBLOCK_ID"]!="-"?$arCurrentValues["IBLOCK_ID"]:""));
$db_section = CIBlockSection::GetList(array(), $arFilterSect, false);
while($arResSect = $db_section->GetNext())
{
    $arSections[$arResSect["ID"]] = $arResSect["NAME"];
}
$arTemplateParameters = array(

	"PROMO_CONTROLLER_TYPE" => array(
		"PARENT" => "COMPONENT_TEMPLATE",
		"NAME" => GetMessage("PROMO_CONTROLLER_TYPE"),
		"TYPE" => "LIST",
		"VALUES" => $arPromoTypes,
		"REFRESH" => "Y",
	)
	,
    "BXR_SLIDER_IBLOCK_TYPE" => array(
        "PARENT" => "SLIDER_SETTINGS",
        "NAME" => GetMessage("SLIDER_IBLOCK_TYPE"),
        "TYPE" => "LIST",
        "VALUES" => $arTypesEx,
        "DEFAULT" => "news",
        "REFRESH" => "Y",
    ),
    "BXR_SLIDER_IBLOCK_ID" => array(
        "PARENT" => "SLIDER_SETTINGS",
        "NAME" => GetMessage("SLIDER_IBLOCK_ID"),
        "TYPE" => "LIST",
        "VALUES" => $arIBlocks,
        "DEFAULT" => '={$_REQUEST["ID"]}',
        "ADDITIONAL_VALUES" => "Y",
        "REFRESH" => "Y",
    ),
    "BXR_SLIDER_PARENT_SECTION" => array(
        "PARENT" => "SLIDER_SETTINGS",
        "NAME" => GetMessage("IBLOCK_SECTION_ID"),
        "TYPE" => "LIST",
        "VALUES" => $arSections,
        "DEFAULT" => '',
        "REFRESH" => "Y"
    ),
    'BXR_SLIDER_PARENT_SECTION_CODE' => array(
        "PARENT" => "SLIDER_SETTINGS",
        "NAME" => GetMessage("IBLOCK_SECTION_CODE"),
        "TYPE" => "STRING",
        "DEFAULT" => '',
    ),
    "BXR_SLIDER_SLIDER_FULL_SCREEN" => array(
        "PARENT" => "SLIDER_SETTINGS",
        "NAME" => GetMessage("SLIDER_FULL_SCREEN"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    ),
    "BXR_SLIDER_SLIDER_FADE" => array(
        "PARENT" => "SLIDER_SETTINGS",
        "NAME" => GetMessage("SLIDER_FADE"),
        "TYPE" => "CHECKBOX",
    ), 
    "BXR_SLIDER_SLIDER_INFINITE" => array(
        "PARENT" => "SLIDER_SETTINGS",
        "NAME" => GetMessage("SLIDER_INFINITE"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "N"
    ),
    "BXR_SLIDER_SLIDER_AUTOPLAY" => array(
        "PARENT" => "SLIDER_SETTINGS",
        "NAME" => GetMessage("SLIDER_AUTOPLAY"),
        "TYPE" => "CHECKBOX",
    ),
    "BXR_SLIDER_SLIDER_SPEED" => array(
        "PARENT" => "SLIDER_SETTINGS",
        "NAME" => GetMessage("SLIDER_SPEED"),
        "TYPE" => "TEXT",
        "DEFAULT" => "1500"
    ),
    "BXR_SLIDER_SLIDER_AUTOPLAY_SPEED" => array(
        "PARENT" => "SLIDER_SETTINGS",
        "NAME" => GetMessage("SLIDER_AUTOPLAY_SPEED"),
        "TYPE" => "TEXT",
        "DEFAULT" => "3000"
    ),
    "BXR_SLIDER_HIDE_SLIDER_ARROWS_LISTPAGE" => array(
        "PARENT" => "SLIDER_SETTINGS",
        "NAME" => GetMessage("SLIDER_HIDE_SLIDER_ARROWS_LISTPAGE"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y"
    ),
    "BXR_SLIDER_HIDE_MOBILE_SLIDER_ARROWS_LISTPAGE" => array(
        "PARENT" => "SLIDER_SETTINGS",
        "NAME" => GetMessage("BXR_SLIDER_HIDE_MOBILE_SLIDER_ARROWS_LISTPAGE"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y"
    ),
    "BXR_SLIDER_LIST_SLIDER_MARKERS_LISTPAGE" => array(
        "PARENT" => "SLIDER_SETTINGS",
        "NAME" => GetMessage("SLIDER_LIST_SLIDER_MARKERS_LISTPAGE"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y"
    ),
    "BXR_SLIDER_HEIGHT" => array(
        "PARENT" => "SLIDER_SETTINGS",
        "NAME" => GetMessage("SLIDER_HEIGHT"),
        "TYPE" => "STRING",
        "DEFAULT" => "400px"
    ),
    "BXR_SLIDER_ADAPTIVE_MODE" => array(
        "PARENT" => "SLIDER_SETTINGS",
        "NAME" => GetMessage("SLIDER_ADAPTIVE_MODE"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "N",
        "REFRESH" => "Y",
    ),
);
    /*Parametres of breakpoints*/
if(isset($arCurrentValues['BXR_SLIDER_ADAPTIVE_MODE']) && $arCurrentValues['BXR_SLIDER_ADAPTIVE_MODE'] == 'Y') {
    $arTemplateParameters["BXR_SLIDER_CUSTOM_BREAKPOINT"] = array(
        "PARENT" => "SLIDER_SETTINGS",
        "NAME" => GetMessage("CUSTOM_BREAKPOINT"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "N",
        "REFRESH" => "Y",
    );
}
if(isset($arCurrentValues['BXR_SLIDER_CUSTOM_BREAKPOINT']) && $arCurrentValues['BXR_SLIDER_CUSTOM_BREAKPOINT'] == 'Y'){
    $arTemplateParameters["BXR_SLIDER_CUSTOM_BREAKPOINT_XL"] = array(
        "PARENT" => "SLIDER_BREACKPOINT_XL",
        "NAME" => GetMessage("CUSTOM_BREAKPOINT_XL"),
        "TYPE" => "STRING",
        "DEFAULT" => "1920",);
    $arTemplateParameters["BXR_SLIDER_CUSTOM_HEIGHT_XL"] = array(
        "PARENT" => "SLIDER_BREACKPOINT_XL",
        "NAME" => GetMessage("CUSTOM_HEIGHT_XL"),
        "TYPE" => "STRING",
        "DEFAULT" => "400px",);
    $arTemplateParameters["BXR_SLIDER_CUSTOM_HIDDEN_XL"] = array(
        "PARENT" => "SLIDER_BREACKPOINT_XL",
        "NAME" => GetMessage("CUSTOM_HIDDEN_XL"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "N",);
    $arTemplateParameters["BXR_SLIDER_CUSTOM_BREAKPOINT_LG"] = array(
        "PARENT" => "SLIDER_BREACKPOINT_LG",
        "NAME" => GetMessage("CUSTOM_BREAKPOINT_LG"),
        "TYPE" => "STRING",
        "DEFAULT" => "1200",);
    $arTemplateParameters["BXR_SLIDER_CUSTOM_HEIGHT_LG"] = array(
        "PARENT" => "SLIDER_BREACKPOINT_LG",
        "NAME" => GetMessage("CUSTOM_HEIGHT_LG"),
        "TYPE" => "STRING",
        "DEFAULT" => "350px",);
    $arTemplateParameters["BXR_SLIDER_CUSTOM_HIDDEN_LG"] = array(
        "PARENT" => "SLIDER_BREACKPOINT_LG",
        "NAME" => GetMessage("CUSTOM_HIDDEN_LG"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "N",);
    $arTemplateParameters["BXR_SLIDER_CUSTOM_BREAKPOINT_MD"] = array(
        "PARENT" => "SLIDER_BREACKPOINT_MD",
        "NAME" => GetMessage("CUSTOM_BREAKPOINT_MD"),
        "TYPE" => "STRING",
        "DEFAULT" => "992",);
    $arTemplateParameters["BXR_SLIDER_CUSTOM_HEIGHT_MD"] = array(
        "PARENT" => "SLIDER_BREACKPOINT_MD",
        "NAME" => GetMessage("CUSTOM_HEIGHT_MD"),
        "TYPE" => "STRING",
        "DEFAULT" => "300px",);
    $arTemplateParameters["BXR_SLIDER_CUSTOM_HIDDEN_MD"] = array(
        "PARENT" => "SLIDER_BREACKPOINT_MD",
        "NAME" => GetMessage("CUSTOM_HIDDEN_MD"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "N",);
    $arTemplateParameters["BXR_SLIDER_CUSTOM_BREAKPOINT_SM"] = array(
        "PARENT" => "SLIDER_BREACKPOINT_SM",
        "NAME" => GetMessage("CUSTOM_BREAKPOINT_SM"),
        "TYPE" => "STRING",
        "DEFAULT" => "768",);
    $arTemplateParameters["BXR_SLIDER_CUSTOM_HEIGHT_SM"] = array(
        "PARENT" => "SLIDER_BREACKPOINT_SM",
        "NAME" => GetMessage("CUSTOM_HEIGHT_SM"),
        "TYPE" => "STRING",
        "DEFAULT" => "300px",);
    $arTemplateParameters["BXR_SLIDER_CUSTOM_HIDDEN_SM"] = array(
        "PARENT" => "SLIDER_BREACKPOINT_SM",
        "NAME" => GetMessage("CUSTOM_HIDDEN_SM"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "N",);
    $arTemplateParameters["BXR_SLIDER_CUSTOM_BREAKPOINT_XS"] = array(
        "PARENT" => "SLIDER_BREACKPOINT_XS",
        "NAME" => GetMessage("CUSTOM_BREAKPOINT_XS"),
        "TYPE" => "STRING",
        "DEFAULT" => "0",);
    $arTemplateParameters["BXR_SLIDER_CUSTOM_HEIGHT_XS"] = array(
        "PARENT" => "SLIDER_BREACKPOINT_XS",
        "NAME" => GetMessage("CUSTOM_HEIGHT_XS"),
        "TYPE" => "STRING",
        "DEFAULT" => "350px",);
    $arTemplateParameters["BXR_SLIDER_CUSTOM_HIDDEN_XS"] = array(
        "PARENT" => "SLIDER_BREACKPOINT_XS",
        "NAME" => GetMessage("CUSTOM_HIDDEN_XS"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "N",);
}
?>

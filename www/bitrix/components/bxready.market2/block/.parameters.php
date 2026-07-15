<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader;

if(!CModule::IncludeModule("iblock"))
	return;

if(!CModule::IncludeModule("alexkova.bxready2"))
	return;

global $USER_FIELD_MANAGER;

$arSorts = Array("ASC"=>GetMessage("T_IBLOCK_DESC_ASC"), "DESC"=>GetMessage("T_IBLOCK_DESC_DESC"));
$arSortFields = Array(
	"ID"=>GetMessage("T_IBLOCK_DESC_FID"),
	"NAME"=>GetMessage("T_IBLOCK_DESC_FNAME"),
	"ACTIVE_FROM"=>GetMessage("T_IBLOCK_DESC_FACT"),
	"SORT"=>GetMessage("T_IBLOCK_DESC_FSORT"),
	"TIMESTAMP_X"=>GetMessage("T_IBLOCK_DESC_FTSAMP")
);

$arProperty_LNS = array();
$arProperty = array();
$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arCurrentValues["IBLOCK_ID"]));
while ($arr=$rsProp->Fetch())
{
	$arProperty[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
	if (in_array($arr["PROPERTY_TYPE"], array("L", "N", "S", "E", "F")))
	{
		$arProperty_LNS[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
	}
}

$arSortFields = array_merge($arSortFields, $arProperty_LNS);


$arIBlockType = CIBlockParameters::GetIBlockTypes();

$arIBlock=array();
$rsIBlock = CIBlock::GetList(Array("sort" => "asc"), Array("TYPE" => $arCurrentValues["IBLOCK_TYPE"], "ACTIVE"=>"Y"));
while($arr=$rsIBlock->Fetch())
{
	$arIBlock[$arr["ID"]] = "[".$arr["ID"]."] ".$arr["NAME"];
}

$arGroups = array();
$rsGroups = CGroup::GetList($by="c_sort", $order="asc", Array("ACTIVE" => "Y"));
while ($arGroup = $rsGroups->Fetch())
{
	$arGroups[$arGroup["ID"]] = $arGroup["NAME"];
}

$arProperty_UF = array();
$arUserFields = $USER_FIELD_MANAGER->GetUserFields("IBLOCK_".$arCurrentValues["IBLOCK_ID"]."_SECTION", 0, LANGUAGE_ID);
foreach($arUserFields as $FIELD_NAME=>$arUserField)
{
	$arUserField['LIST_COLUMN_LABEL'] = (string)$arUserField['LIST_COLUMN_LABEL'];
	$arProperty_UF[$FIELD_NAME] = $arUserField['LIST_COLUMN_LABEL'] ? '['.$FIELD_NAME.']'.$arUserField['LIST_COLUMN_LABEL'] : $FIELD_NAME;
}


$arComponentParameters = array(
	"GROUPS" => array(
		/*"INDEX_PAGE_SETTINGS" => array(
			"SORT" => 120,
			"NAME" => GetMessage("T_INDEX_PAGE_SETTINGS"),
		),*/
		"BXR_FORM_SETTINGS_GROUP" => array(
			"SORT" => 280,
			"NAME" => GetMessage("BXR_FORM_SETTINGS_GROUP"),
		),
		"BXR_INCLUDE_SETTINGS_GROUP" => array(
			"SORT" => 320,
			"NAME" => GetMessage("BXR_INCLUDE_SETTINGS_GROUP"),
		),
		"BXR_DETAIL_PICTURE_SETTINGS_GROUP" => array(
			"SORT" => 210,
			"NAME" => GetMessage("BXR_DETAIL_PICTURE_SETTINGS_GROUP"),
		),
		"RATING_SETTINGS" => array(
			"SORT" => 320,
			"NAME" => GetMessage("T_IBLOCK_DESC_RATING_SETTINGS"),
		),
		"DETAIL_SETTINGS" =>array(
			"SORT" => 200,
			"NAME" => GetMessage("T_DETAIL_SETTINGS_DESC"),
		),

		"LIST_SETTINGS" =>array(
			"SORT" => 150,
			"NAME" => GetMessage("T_LIST_SETTINGS_DESC"),
		),

		"INDEX_SETTINGS" =>array(
			"SORT" => 120,
			"NAME" => GetMessage("T_INDEX_SETTINGS_DESC"),
		),
	),
	"PARAMETERS" => array(


		"IBLOCK_TYPE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BN_P_IBLOCK_TYPE"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlockType,
			"REFRESH" => "Y",
		),
		"IBLOCK_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BN_P_IBLOCK"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlock,
			"REFRESH" => "Y",
			"ADDITIONAL_VALUES" => "Y",
		),

		//"AJAX_MODE" => array(),

		"VARIABLE_ALIASES" => Array(
			"SECTION_ID" => Array("NAME" => GetMessage("BN_P_SECTION_ID_DESC")),
			"ELEMENT_ID" => Array("NAME" => GetMessage("NEWS_ELEMENT_ID_DESC")),
		),
		"SEF_MODE" => Array(
			"index" => array(
				"NAME" => GetMessage("T_IBLOCK_SEF_PAGE_NEWS"),
				"DEFAULT" => "",
				"VARIABLES" => array(),
			),
			"section" => array(
				"NAME" => GetMessage("T_IBLOCK_SEF_PAGE_NEWS_SECTION"),
				"DEFAULT" => "",
				"VARIABLES" => array("SECTION_ID"),
			),
			"detail" => array(
				"NAME" => GetMessage("T_IBLOCK_SEF_PAGE_NEWS_DETAIL"),
				"DEFAULT" => "#ELEMENT_ID#/",
				"VARIABLES" => array("ELEMENT_ID", "SECTION_ID"),
			),
		),

		'AJAX_MODE' => false,

		"DETAIL_FIELD_CODE" => CIBlockParameters::GetFieldCode(GetMessage("KZNC_IBLOCK_FIELDS"), "DETAIL_PAGE_SETTINGS"),

		"DETAIL_PROPERTY_CODE" => array(
			"PARENT" => "DETAIL_PAGE_SETTINGS",
			"NAME" => GetMessage("T_IBLOCK_PROPERTY"),
			"TYPE" => "LIST",
			"MULTIPLE" => "Y",
			"VALUES" => $arProperty,
			"ADDITIONAL_VALUES" => "Y",
		),

		"LIST_FIELD_CODE" => CIBlockParameters::GetFieldCode(GetMessage("CP_BCSL_ELEMENT_SECTION_FIELDS"), "LIST_SETTINGS"),

		"LIST_PROPERTY_CODE" => array(
			"PARENT" => "LIST_SETTINGS",
			"NAME" => GetMessage("T_IBLOCK_PROPERTY"),
			"TYPE" => "LIST",
			"MULTIPLE" => "Y",
			"VALUES" => $arProperty,
			"ADDITIONAL_VALUES" => "Y",
		),

		"LIST_SORT_BY1" => Array(
			"PARENT" => "LIST_SETTINGS",
			"NAME" => GetMessage("T_IBLOCK_DESC_IBORD1"),
			"TYPE" => "LIST",
			"DEFAULT" => "ACTIVE_FROM",
			"VALUES" => $arSortFields,
			"ADDITIONAL_VALUES" => "Y",
		),
		"LIST_SORT_ORDER1" => Array(
			"PARENT" => "LIST_SETTINGS",
			"NAME" => GetMessage("T_IBLOCK_DESC_IBBY1"),
			"TYPE" => "LIST",
			"DEFAULT" => "DESC",
			"VALUES" => $arSorts,
			"ADDITIONAL_VALUES" => "Y",
		),
		"LIST_SORT_BY2" => Array(
			"PARENT" => "LIST_SETTINGS",
			"NAME" => GetMessage("T_IBLOCK_DESC_IBORD2"),
			"TYPE" => "LIST",
			"DEFAULT" => "SORT",
			"VALUES" => $arSortFields,
			"ADDITIONAL_VALUES" => "Y",
		),
		"LIST_SORT_ORDER2" => Array(
			"PARENT" => "LIST_SETTINGS",
			"NAME" => GetMessage("T_IBLOCK_DESC_IBBY2"),
			"TYPE" => "LIST",
			"DEFAULT" => "ASC",
			"VALUES" => $arSorts,
			"ADDITIONAL_VALUES" => "Y",
		),

            
                "INCLUDE_SUBSECTIONS" => array(
			"PARENT" => "LIST_SETTINGS",
			"NAME" => GetMessage("T_INCLUDE_SUBSECTIONS"),
			"TYPE" => "LIST",
			"VALUES" => array(
				"Y" => GetMessage('T_INCLUDE_SUBSECTIONS_ALL'),
				"A" => GetMessage('T_INCLUDE_SUBSECTIONS_ACTIVE'),
				"N" => GetMessage('T_INCLUDE_SUBSECTIONS_NO'),
			),
			"DEFAULT" => "Y",
		),

		"DETAIL_ACTIVE_DATE_FORMAT" => CIBlockParameters::GetDateFormat(GetMessage("T_IBLOCK_DESC_ACTIVE_DATE_FORMAT"), "DETAIL_PAGE_SETTINGS"),

		"LIST_ACTIVE_DATE_FORMAT" => CIBlockParameters::GetDateFormat(GetMessage("T_IBLOCK_DESC_ACTIVE_DATE_FORMAT"), "LIST_SETTINGS"),

		"CACHE_TIME"  =>  array("DEFAULT"=>3600000),

		/*"INDEX_SECTION_FIELDS" => CIBlockParameters::GetSectionFieldCode(
				GetMessage("CP_BCSL_SECTION_FIELDS"),
				"INDEX_SETTINGS",
				array()
			),

		"INDEX_SECTION_USER_FIELDS" =>array(
			"PARENT" => "INDEX_SETTINGS",
			"NAME" => GetMessage("CP_BCSL_SECTION_USER_FIELDS"),
			"TYPE" => "LIST",
			"MULTIPLE" => "Y",
			"ADDITIONAL_VALUES" => "Y",
			"VALUES" => $arProperty_UF,
		),*/

		/*"LIST_SECTION_FIELDS" => CIBlockParameters::GetSectionFieldCode(
				GetMessage("CP_BCSL_SECTION_FIELDS"),
				"LIST_SETTINGS",
				array()
			),
		"LIST_SECTION_USER_FIELDS" =>array(
			"PARENT" => "LIST_SETTINGS",
			"NAME" => GetMessage("CP_BCSL_SECTION_USER_FIELDS"),
			"TYPE" => "LIST",
			"MULTIPLE" => "Y",
			"ADDITIONAL_VALUES" => "Y",
			"VALUES" => $arProperty_UF,
		),*/

		"BXR_USE_FORM" => array(
			"PARENT" => "BXR_FORM_SETTINGS_GROUP",
			"NAME" => GetMessage("BXR_USE_FORM_DESC"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			'REFRESH' => 'Y'
		),


	),

);


if ($arCurrentValues['CBXR_PICTURE_BXR_DETAIL_PICTURE_TYPE'] == "slider"){

}

if ($arCurrentValues['CBXR_PICTURE_BXR_DETAIL_PICTURE_TYPE'] == "picture"){

}

/**********FROM SETTINGS**********/
if ($arCurrentValues['BXR_USE_FORM'] == "Y"){
    
        $arComponentParameters['PARAMETERS']["BXR_FORM_SIDEBAR"] = array(
            "PARENT" => "BXR_FORM_SETTINGS_GROUP",
            "NAME" => GetMessage("BXR_FORM_SIDEBAR"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
        );

	$rsIBlock = CIBlock::GetList(Array("sort" => "asc"), Array("TYPE" => $arCurrentValues["CBXR_FORM_IBLOCK_TYPE"], "ACTIVE"=>"Y"));
	while($arr=$rsIBlock->Fetch())
	{
		$arIBlockForm[$arr["ID"]] = "[".$arr["ID"]."] ".$arr["NAME"];
	}

	if($arCurrentValues["BXR_FORM_IBLOCK_ID"] > 0)
	{
		$arIBlock1 = CIBlock::GetArrayByID($arCurrentValues["CBXR_FORM_IBLOCK_ID"]);

		$bWorkflowIncluded = ($arIBlock1["WORKFLOW"] == "Y") && CModule::IncludeModule("workflow");
		$bBizproc = ($arIBlock1["BIZPROC"] == "Y") && CModule::IncludeModule("bizproc");
	}
	else
	{
		$bWorkflowIncluded = CModule::IncludeModule("workflow");
		$bBizproc = false;
	}

	$arProperty_LNSF = array();
	$arVirtualProperties = $arProperty_LNSF;

	$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arCurrentValues["CBXR_FORM_IBLOCK_ID"]));
	while ($arr=$rsProp->Fetch())
	{
		$arProperty[$arr["ID"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
		if (in_array($arr["PROPERTY_TYPE"], array("L", "N", "S", "F")))
		{
			$arProperty_LNSF[$arr["ID"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
		}
	}

	if ($bWorkflowIncluded)
	{
		$rsWFStatus = CWorkflowStatus::GetList($by="c_sort", $order="asc", Array("ACTIVE" => "Y"), $is_filtered);
		$arWFStatus = array();
		while ($arWFS = $rsWFStatus->Fetch())
		{
			$arWFStatus[$arWFS["ID"]] = $arWFS["TITLE"];
		}
	}
	else
	{
		$arActive = array("ANY" => GetMessage("KZNC_IBLOCK_STATUS_ANY"), "INACTIVE" => GetMessage("KZNC_IBLOCK_STATUS_INCATIVE"));
		$arActiveNew = array("N" => GetMessage("KZNC_IBLOCK_ALLOW_N"), "NEW" => GetMessage("KZNC_IBLOCK_ACTIVE_NEW_NEW"));
	}

	$arComponentParameters["PARAMETERS"]['CBXR_FORM_INITIAL_TEXT'] = array(
		"PARENT" => "BXR_FORM_SETTINGS_GROUP",
		"NAME" => GetMessage("CBXR_FORM_INITIAL_TEXT"),
		"TYPE" => "TEXT",
		"DEFAULT" => '',
	);

	$arComponentParameters['PARAMETERS']["CBXR_FORM_IBLOCK_TYPE"] = array(
		"PARENT" => "BXR_FORM_SETTINGS_GROUP",
		"NAME" => GetMessage("KZNC_IBLOCK_TYPE"),
		"TYPE" => "LIST",
		"ADDITIONAL_VALUES" => "Y",
		"VALUES" => $arIBlockType,
		"REFRESH" => "Y",
	);

	$arComponentParameters['PARAMETERS']["CBXR_FORM_IBLOCK_ID"] = array(
		"PARENT" => "BXR_FORM_SETTINGS_GROUP",
		"NAME" => GetMessage("KZNC_IBLOCK_IBLOCK"),
		"TYPE" => "LIST",
		"ADDITIONAL_VALUES" => "Y",
		"VALUES" => $arIBlockForm,
		"REFRESH" => "Y",
	);

	$arComponentParameters['PARAMETERS']["CBXR_FORM_PROPERTY_CODES"] = array(
		"PARENT" => "BXR_FORM_SETTINGS_GROUP",
		"NAME" => GetMessage("KZNC_IBLOCK_PROPERTY"),
		"TYPE" => "LIST",
		"MULTIPLE" => "Y",
		"VALUES" => $arProperty_LNSF,
		"SIZE" => 8
	);

	$arComponentParameters['PARAMETERS']["CBXR_FORM_NAME_FROM_PROPERTY"] = array(
		"PARENT" => "BXR_FORM_SETTINGS_GROUP",
		"NAME" => GetMessage("KZNC_IBLOCK_NAME_FROM_PROPERTY"),
		"TYPE" => "LIST",
		"VALUES" => $arProperty_LNSF,
	);

	$arComponentParameters['PARAMETERS']["CBXR_FORM_GROUPS"] = array(
		"PARENT" => "BXR_FORM_SETTINGS_GROUP",
		"NAME" => GetMessage("KZNC_IBLOCK_GROUPS"),
		"TYPE" => "LIST",
		"MULTIPLE" => "Y",
		"ADDITIONAL_VALUES" => "N",
		"VALUES" => $arGroups,
	);

	$arComponentParameters['PARAMETERS']["CBXR_FORM_STATUS_NEW"] = array(
		"PARENT" => "BXR_FORM_SETTINGS_GROUP",
		"NAME" => $bWorkflowIncluded? GetMessage("KZNC_IBLOCK_STATUS_NEW"): ($bBizproc? GetMessage("KZNC_IBLOCK_BP_NEW"): GetMessage("KZNC_IBLOCK_ACTIVE_NEW")),
		"TYPE" => "LIST",
		"MULTIPLE" => "N",
		"VALUES" => $bWorkflowIncluded ? $arWFStatus : $arActiveNew,
	);

	$arComponentParameters["PARAMETERS"]["CBXR_FORM_USE_CAPTCHA"] = array(
		"PARENT" => "BXR_FORM_SETTINGS_GROUP",
		"NAME" => GetMessage("KZNC_IBLOCK_USE_CAPTCHA"),
		"TYPE" => "CHECKBOX",
	);

	$arComponentParameters["PARAMETERS"]["CBXR_FORM_USER_MESSAGE_ADD"] = array(
		"PARENT" => "BXR_FORM_SETTINGS_GROUP",
		"NAME" => GetMessage("KZNC_IBLOCK_USER_MESSAGE_ADD"),
		"TYPE" => "TEXT",
	);

	/*$arComponentParameters["PARAMETERS"]["CBXR_FORM_RESIZE_IMAGES"] = array(
		"PARENT" => "BXR_FORM_SETTINGS_GROUP",
		"NAME" => GetMessage("CP_BIEAF_RESIZE_IMAGES"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
	);

	$arComponentParameters["PARAMETERS"]["CBXR_FORM_MAX_FILE_SIZE"] = array(
		"PARENT" => "BXR_FORM_SETTINGS_GROUP",
		"NAME" => GetMessage("KZNC_IBLOCK_MAX_FILE_SIZE"),
		"TYPE" => "TEXT",
		"DEFAULT" => "0",
	);*/


	$arComponentParameters["PARAMETERS"]['CBXR_FORM_FORM_TITLE'] = array(
		"PARENT" => "BXR_FORM_SETTINGS_GROUP",
		"NAME" => GetMessage("KZNC_IBLOCK_POPUP_TITLE"),
		"TYPE" => "TEXT",
		"DEFAULT" => GetMessage("KZNC_IBLOCK_POPUP_DEFAULT_TITLE"),
	);


	$arComponentParameters["PARAMETERS"]["CBXR_FORM_BXR_FORM_ID"] = array(
		"PARENT" => "BXR_FORM_SETTINGS_GROUP",
		"NAME" => GetMessage("KZNC_FORM_ID"),
		"TYPE" => "STRING",
	);

	$arComponentParameters["PARAMETERS"]['CBXR_FORM_BXR_FORM_SUBMIT_CAPTION'] = array(
		'NAME' => GetMessage('BXR_FORM_SUBMIT_CAPTION'),
		'PARENT' => 'BXR_FORM_SETTINGS_GROUP',
		'TYPE' => 'STRING',
	);


	$arComponentParameters["PARAMETERS"]['CBXR_FORM_BXR_FORM_SUBMIT_ICON'] = array(
		'NAME' => GetMessage('BXR_FORM_SUBMIT_ICON'),
		'PARENT' => 'BXR_FORM_SETTINGS_GROUP',
		'TYPE' => 'STRING',
	);

	$arComponentParameters["PARAMETERS"]["CBXR_FORM_SEND_EVENT"] = array(
		'PARENT'=>'BXR_FORM_SETTINGS_GROUP',
		"NAME" => GetMessage("KZNC_IBLOCK_POPUP_SEND_EVENT"),
		"TYPE" => "TEXT",
		"DEFAULT" => 'KZNC_NEW_FORM_RESULT',
	);

	$arComponentParameters["PARAMETERS"]["CBXR_FORM_BUTTON_TEXT"] = array(
		"PARENT" => "BXR_FORM_SETTINGS_GROUP",
		"NAME" => GetMessage("KZNC_IBLOCK_BUTTON_TEXT"),
		"TYPE" => "TEXT",
	);
}
/********** END FROM SETTINGS**********/

CIBlockParameters::Add404Settings($arComponentParameters, $arCurrentValues);


global $arComponentGroups, $arReload;

if (isset($arComponentGroups)){
	foreach ($arComponentGroups as $cell=>$val){
		$arComponentParameters["GROUPS"][$cell] = $val;
	}
}

if (isset($arReload)){
    if(is_array($arReload["PARAMETERS"])) {
	foreach ($arReload["PARAMETERS"] as $cell=>$val){
		$arComponentParameters["PARAMETERS"][$cell] = $val;
	}
    }
}

if (Loader::includeModule('alexkova.market2')){

	$arLessParams = \Alexkova\Market2\Bxmarket::getLazyLoadParameters();

	if(is_array($arLessParams) && !empty($arLessParams)) {
		$arComponentParameters = array_merge_recursive($arComponentParameters, $arLessParams);
	}
}

?>

<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
	return;

if(!CModule::IncludeModule("alexkova.bxready2"))
	return;

global $USER_FIELD_MANAGER;

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

$arProperty_LNSF = array();
$arProperty2 = array();
if ($arCurrentValues["SKU_IBLOCK_ID"]>0){
	$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arCurrentValues["SKU_IBLOCK_ID"]));
	while ($arr=$rsProp->Fetch())
	{
		$arProperty2[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
		if (in_array($arr["PROPERTY_TYPE"], array("L", "N", "S", "E", "F")))
		{
			$arProperty_LNSF[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
		}
	}
}



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

$arSort = CIBlockParameters::GetElementSortFields(
	array('SHOWS', 'SORT', 'TIMESTAMP_X', 'NAME', 'ID', 'ACTIVE_FROM', 'ACTIVE_TO'),
	array('KEY_LOWERCASE' => 'Y')
);

$catalogIncluded = CModule::includeModule('catalog');
$arSort = CIBlockParameters::GetElementSortFields(
    array('SHOWS', 'SORT', 'TIMESTAMP_X', 'NAME', 'ID', 'ACTIVE_FROM', 'ACTIVE_TO'),
    array('KEY_LOWERCASE' => 'Y')
);
$arSort = array_merge($arSort, $arProperty_LNS);



$arSiderbar = array(
    "N" => GetMessage("T_SIDEBAR_N"),
    "LEFT" => GetMessage("T_SIDEBAR_LEFT"),
    "RIGHT" => GetMessage("T_SIDEBA_RIGHT"),
);


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
                "FILTER_SETTINGS" => array(
			"NAME" => GetMessage("T_IBLOCK_DESC_FILTER_SETTINGS"),
                        "SORT" => 105,
		),
                "SORT_PANEL_SETTINGS" => array(
			"NAME" => GetMessage("T_IBLOCK_SORT_PANEL_SETTINGS"),
                        "SORT" => 107,
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

		"SKU_SETTINGS" =>array(
			"SORT" => 110,
			"NAME" => GetMessage("T_SKU_SETTINGS_DESC"),
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
		),
            
                "USE_FILTER" => array(
			"PARENT" => "FILTER_SETTINGS",
			"NAME" => GetMessage("T_IBLOCK_DESC_USE_FILTER"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"REFRESH" => "Y",
		),
            
                "USE_SORT_PANEL" => array(
			"PARENT" => "SORT_PANEL_SETTINGS",
			"NAME" => GetMessage("T_USE_SORT_PANEL"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
			"REFRESH" => "Y",
		),

		"SKU_MODE" => array(
			"PARENT" => "SKU_SETTINGS",
			"NAME" => GetMessage("SKU_MODE"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => 'N',
			"REFRESH" => "Y",
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
            
                "SIDEBAR_SECTIONS_SHOW" => array(
			"PARENT" => "INDEX_SETTINGS",
			"NAME" => GetMessage("T_SIDEBAR_SECTIONS_SHOW"),
			"TYPE" => "LIST",
			"MULTIPLE" => "N",
			"VALUES" => $arSiderbar,
                        "DEFAULT" => "N",
		),
            
                "SIDEBAR_SECTION_SHOW" => array(
			"PARENT" => "LIST_SETTINGS",
			"NAME" => GetMessage("T_SIDEBAR_SECTION_SHOW"),
			"TYPE" => "LIST",
			"MULTIPLE" => "N",
			"VALUES" => $arSiderbar,
                        "DEFAULT" => "N",
		),
            
                "SIDEBAR_DETAIL_SHOW" => array(
			"PARENT" => "DETAIL_SETTINGS",
			"NAME" => GetMessage("T_SIDEBAR_DETAIL_SHOW"),
			"TYPE" => "LIST",
			"MULTIPLE" => "N",
			"VALUES" => $arSiderbar,
                        "DEFAULT" => "N",
		),

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


if (isset($arCurrentValues['USE_SORT_PANEL']) && $arCurrentValues['USE_SORT_PANEL'] == 'Y') {
    
    $arThemes = array(
        "default" => GetMessage("T_SORT_PANEL_THEME_DEFAULT"),
        "solid"=> GetMessage("T_SORT_PANEL_THEME_SOLID")
    );

    $arComponentParameters["PARAMETERS"]["SORT_PANEL_THEME"] = array(
        "PARENT" => "SORT_PANEL_SETTINGS",
        "NAME" => GetMessage("T_SORT_PANEL_THEME"),
        "TYPE" => "LIST",
        "VALUES" => $arThemes,
        "MULTIPLE" => "N",
        "DEFAULT" => "default",
    );

    /*$arComponentParameters["PARAMETERS"]["ELEMENT_SORT_FIELD"] = array(
        "PARENT" => "SORT_PANEL_SETTINGS",
        "NAME" => GetMessage("IBLOCK_ELEMENT_SORT_FIELD"),
        "TYPE" => "LIST",
        "VALUES" => $arProperty,
        "MULTIPLE" => "Y",
        "DEFAULT" => "sort",
        "REFRESH" => "Y",
        "SIZE" => 10,
    );*/
    
    /*$arCurrentSortFields = "";

    $arComponentParameters["PARAMETERS"]["CATALOG_DEFAULT_SORT"] = array(
        "PARENT" => "SORT_PANEL_SETTINGS",
        "NAME" => GetMessage("KZNC_CATALOG_DEFAULT_SORT"),
        "TYPE" => "LIST",
        "DEFAULT" => "sort",
        "VALUES" => $arCurrentSortFields,
    );*/

    /*$arComponentParameters["PARAMETERS"]["PAGE_ELEMENT_COUNT_SHOW"] = array(
        "PARENT" => "SORT_PANEL_SETTINGS",
        "NAME" => GetMessage("KZNC_PAGE_ELEMENT_COUNT_SHOW"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
        "REFRESH" => "Y",
    );*/

    /*$arComponentParameters["PARAMETERS"]["PAGE_ELEMENT_COUNT"] = array(
        "PARENT" => "SORT_PANEL_SETTINGS",
        "NAME" => GetMessage("IBLOCK_PAGE_ELEMENT_COUNT"),
        "TYPE" => "STRING",
        "DEFAULT" => "16",
    );*/

    /*if($arCurrentValues["PAGE_ELEMENT_COUNT_SHOW"]=="Y") {

        $arComponentParameters["PARAMETERS"]["PAGE_ELEMENT_COUNT_LIST"] = array(
            "PARENT" => "SORT_PANEL_SETTINGS",
            "NAME" => GetMessage("KZNC_PAGE_ELEMENT_COUNT_LIST"),
            "TYPE" => "LIST",
            "MULTIPLE" => "Y",
            "ADDITIONAL_VALUES" => "Y",
            "VALUES" => $arPageCount,
        );
    }*/
    
    $arComponentParameters["PARAMETERS"]["SORT_PANEL_CATALOG_VIEW_SHOW"] = array(
        "PARENT" => "SORT_PANEL_SETTINGS",
        "NAME" => GetMessage("T_SORT_PANEL_CATALOG_VIEW_SHOW"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
        "REFRESH" => "Y",
    );

    
    if (isset($arCurrentValues['SORT_PANEL_CATALOG_VIEW_SHOW']) && $arCurrentValues['SORT_PANEL_CATALOG_VIEW_SHOW'] == 'Y') {
    
        $arCatalogView = array(
            "TITLE" => GetMessage("T_SORT_PANEL_CATALOG_VIEW_SHOW_TITLE"),
            "LIST" => GetMessage("T_SORT_PANEL_CATALOG_VIEW_SHOW_LIST"),
            "TABLE" => GetMessage("T_SORT_PANEL_CATALOG_VIEW_SHOW_TABLE"),
        );

        $arComponentParameters["PARAMETERS"]["SORT_PANEL_DEFAULT_CATALOG_VIEW"] = array(
            "PARENT" => "SORT_PANEL_SETTINGS",
            "NAME" => GetMessage("T_SORT_PANEL_DEFAULT_CATALOG_VIEW"),
            "TYPE" => "LIST",
            "VALUES" => $arCatalogView,
            "DEFAULT" => "TITLE",
        );
    }
        
    /*$arComponentParameters["PARAMETERS"]["SORT_PANEL_CATALOG_VIEW_SHOW"] = array(
        "PARENT" => "SORT_PANEL_SETTINGS",
        "NAME" => GetMessage("T_SORT_PANEL_CATALOG_VIEW_SHOW"),
        "TYPE" => "LIST",
        "VALUES" => $arCatalogView,
        "MULTIPLE" => "Y",
        "DEFAULT" => array("TITLE" => GetMessage("T_SORT_PANEL_CATALOG_VIEW_SHOW_TITLE")),
        "REFRESH" => "Y",
    );*/
    
    /*if(count($arCurrentValues["SORT_PANEL_CATALOG_VIEW_SHOW"])>1) {
        foreach($arCurrentValues["SORT_PANEL_CATALOG_VIEW_SHOW"] as $k => $v) {
            $arComponentParameters["PARAMETERS"]["SORT_PANEL_CATALOG_VIEW_".$v] = array(
                "PARENT" => "SORT_PANEL_SETTINGS",
                "NAME" => GetMessage("T_SORT_PANEL_CATALOG_VIEW_SORT")." (".$arCatalogView[$v].")",
                "TYPE" => "TEXT",
                "DEFAULT" => 100,
            );
        };
    }  */  
}
else {   

    $arAscDesc = array(
	"asc" => GetMessage("IBLOCK_SORT_ASC"),
	"desc" => GetMessage("IBLOCK_SORT_DESC"),
    );
    
    $arComponentParameters["PARAMETERS"]["ELEMENT_SORT_FIELD"] = array(
        "PARENT" => "SORT_PANEL_SETTINGS",
        "NAME" => GetMessage("IBLOCK_ELEMENT_SORT_FIELD"),
        "TYPE" => "LIST",
        "VALUES" => $arSort,
        "ADDITIONAL_VALUES" => "Y",
        "DEFAULT" => "sort",
    );
    
    $arComponentParameters["PARAMETERS"]["ELEMENT_SORT_ORDER"] = array(
        "PARENT" => "SORT_PANEL_SETTINGS",
        "NAME" => GetMessage("IBLOCK_ELEMENT_SORT_ORDER"),
        "TYPE" => "LIST",
        "VALUES" => $arAscDesc,
        "DEFAULT" => "asc",
        "ADDITIONAL_VALUES" => "Y",
    );
    
    $arComponentParameters["PARAMETERS"]["ELEMENT_SORT_FIELD2"] = array(
        "PARENT" => "SORT_PANEL_SETTINGS",
        "NAME" => GetMessage("IBLOCK_ELEMENT_SORT_FIELD2"),
        "TYPE" => "LIST",
        "VALUES" => $arSort,
        "ADDITIONAL_VALUES" => "Y",
        "DEFAULT" => "id",
    );
    
    $arComponentParameters["PARAMETERS"]["ELEMENT_SORT_ORDER2"] = array(
        "PARENT" => "SORT_PANEL_SETTINGS",
        "NAME" => GetMessage("IBLOCK_ELEMENT_SORT_ORDER2"),
        "TYPE" => "LIST",
        "VALUES" => $arAscDesc,
        "DEFAULT" => "desc",
        "ADDITIONAL_VALUES" => "Y",
    );
}

if (isset($arCurrentValues['USE_FILTER']) && $arCurrentValues['USE_FILTER'] == 'Y') {
    
    $arFilterViewModeList = array(
	"VERTICAL" => GetMessage("T_FILTER_VIEW_MODE_VERTICAL"),
	"HORIZONTAL" => GetMessage("T_FILTER_VIEW_MODE_HORIZONTAL")
    );
    
    $arComponentParameters["PARAMETERS"]["FILTER_VIEW_MODE"] = array(
            "PARENT" => "FILTER_SETTINGS",
            "NAME" => GetMessage('T_FILTER_VIEW_MODE'),
            "TYPE" => "LIST",
            "VALUES" => $arFilterViewModeList,
            "DEFAULT" => "VERTICAL",
            "HIDDEN" => (!isset($arCurrentValues['USE_FILTER']) || 'N' == $arCurrentValues['USE_FILTER'])
    );

    $arComponentParameters["PARAMETERS"]["DISPLAY_ELEMENT_COUNT"] = array(
            "PARENT" => "FILTER_SETTINGS",
            "NAME" => GetMessage('T_DISPLAY_ELEMENT_COUNT_FILTER'),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N"
    );
    $arComponentParameters["PARAMETERS"]["HIDE_FILTER_MOBILE"] = array(
            "PARENT" => "FILTER_SETTINGS",
            "NAME" => GetMessage('T_HIDE_FILTER_MOBILE'),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y"
    );
}

if($arCurrentValues["SEF_MODE"]=="Y")
{
	$arComponentParameters["PARAMETERS"]["VARIABLE_ALIASES"] = array();
	$arComponentParameters["PARAMETERS"]["VARIABLE_ALIASES"]["ELEMENT_ID"] = array(
		"NAME" => GetMessage("CP_BC_VARIABLE_ALIASES_ELEMENT_ID"),
		"TEMPLATE" => "#ELEMENT_ID#",
	);
	$arComponentParameters["PARAMETERS"]["VARIABLE_ALIASES"]["ELEMENT_CODE"] = array(
		"NAME" => GetMessage("CP_BC_VARIABLE_ALIASES_ELEMENT_CODE"),
		"TEMPLATE" => "#ELEMENT_CODE#",
	);
	$arComponentParameters["PARAMETERS"]["VARIABLE_ALIASES"]["SECTION_ID"] = array(
		"NAME" => GetMessage("CP_BC_VARIABLE_ALIASES_SECTION_ID"),
		"TEMPLATE" => "#SECTION_ID#",
	);
	$arComponentParameters["PARAMETERS"]["VARIABLE_ALIASES"]["SECTION_CODE"] = array(
		"NAME" => GetMessage("CP_BC_VARIABLE_ALIASES_SECTION_CODE"),
		"TEMPLATE" => "#SECTION_CODE#",
	);
	$arComponentParameters["PARAMETERS"]["VARIABLE_ALIASES"]["SECTION_CODE_PATH"] = array(
		"NAME" => GetMessage("CP_BC_VARIABLE_ALIASES_SECTION_CODE_PATH"),
		"TEMPLATE" => "#SECTION_CODE_PATH#",
	);
	$arComponentParameters["PARAMETERS"]["VARIABLE_ALIASES"]["SMART_FILTER_PATH"] = array(
		"NAME" => GetMessage("CP_BC_VARIABLE_ALIASES_SMART_FILTER_PATH"),
		"TEMPLATE" => "#SMART_FILTER_PATH#",
	);

	$smartBase = ($arCurrentValues["SEF_URL_TEMPLATES"]["section"]? $arCurrentValues["SEF_URL_TEMPLATES"]["section"]: "#SECTION_ID#/");
	$arComponentParameters["PARAMETERS"]["SEF_MODE"]["smart_filter"] = array(
		"NAME" => GetMessage("T_SEF_MODE_SMART_FILTER"),
		"DEFAULT" => $smartBase."filter/#SMART_FILTER_PATH#/apply/",
		"VARIABLES" => array(
			"SECTION_ID",
			"SECTION_CODE",
			"SECTION_CODE_PATH",
			"SMART_FILTER_PATH",
		),
	);
}

if ($arCurrentValues['SKU_MODE'] == "Y"){

	$arComponentParameters["PARAMETERS"]["SKU_IBLOCK_TYPE"]	 = array(
		"PARENT" => "SKU_SETTINGS",
		"NAME" => GetMessage("BN_P_IBLOCK_TYPE"),
		"TYPE" => "LIST",
		"VALUES" => $arIBlockType,
		"REFRESH" => "Y",
	);

	$arComponentParameters["PARAMETERS"]["SKU_IBLOCK_ID"]= array(
		"PARENT" => "SKU_SETTINGS",
		"NAME" => GetMessage("BN_P_IBLOCK"),
		"TYPE" => "LIST",
		"VALUES" => $arIBlock,
		"REFRESH" => "Y",
	);

	$arComponentParameters["PARAMETERS"]["SKU_FIELD_CODE"]= CIBlockParameters::GetFieldCode(GetMessage("CP_BCSL_ELEMENT_SECTION_FIELDS"), "SKU_SETTINGS");

	$arComponentParameters["PARAMETERS"]["SKU_PROPERTY_CODE"] = array(
		"PARENT" => "SKU_SETTINGS",
		"NAME" => GetMessage("T_IBLOCK_PROPERTY"),
		"TYPE" => "LIST",
		"MULTIPLE" => "Y",
		"VALUES" => $arProperty2,
		"ADDITIONAL_VALUES" => "Y",
	);
        
        $arComponentParameters["PARAMETERS"]["BXR_DETAIL_TAB_SKU_CAPTION"] = array(
		"PARENT" => "SKU_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_SKU_CAPTION"),
		"TYPE" => "STRING",
		"DEFAULT" => GetMessage("BXR_DETAIL_TAB_SKU_CAPTION_DEFAULT")
	);

	$arComponentParameters["PARAMETERS"]["BXR_DETAIL_TAB_SKU_GLYPH"] = array(
		"PARENT" => "SKU_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_GLYPH"),
		"TYPE" => "STRING",
		"DEFAULT" => ''
	);

	$arComponentParameters["PARAMETERS"]["BXR_DETAIL_TAB_SKU_LINK"] = array(
		"PARENT" => "SKU_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_SMART_LINK"),
		"TYPE" => "STRING",
		"DEFAULT" => ""
	);

	$arComponentParameters["PARAMETERS"]["BXR_DETAIL_TAB_SKU_SORT"] = array(
		"PARENT" => "SKU_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_SORT"),
		"TYPE" => "STRING",
		"DEFAULT" => '500'
	); 
}


if (CModule::IncludeModule('alexkova.business')){

	$additionalParams = \Alexkova\Business\Menu::getComponentParams($arCurrentValues);

	if (is_array($additionalParams)){

		if (count($additionalParams['GROUPS'])>0){
			foreach ($additionalParams['GROUPS'] as $cell=>$val){
				$arComponentParameters['GROUPS'][$cell] = $val;
			}
		}

		if (count($additionalParams['PARAMETERS'])>0){
			foreach ($additionalParams['PARAMETERS'] as $cell=>$val){
				$arComponentParameters['PARAMETERS'][$cell] = $val;
			}
		}
	}

}


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


global $arComponentGroups;

if (isset($arComponentGroups)){
	foreach ($arComponentGroups as $cell=>$val){
		$arComponentParameters["GROUPS"][$cell] = $val;
	}
}

?>

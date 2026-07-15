<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/** @var array $arCurrentValues */
/** @global CUserTypeManager $USER_FIELD_MANAGER */

use Bitrix\Main\Loader;
use Bitrix\Iblock;

if (!Loader::includeModule('iblock'))
	return;

$catalogIncluded = Loader::includeModule('catalog');
$iblockExists = (!empty($arCurrentValues['IBLOCK_ID']) && (int)$arCurrentValues['IBLOCK_ID'] > 0);

$arIBlockType = CIBlockParameters::GetIBlockTypes();

$arIBlock = array();
$iblockFilter = (
	!empty($arCurrentValues['IBLOCK_TYPE'])
	? array('TYPE' => $arCurrentValues['IBLOCK_TYPE'], 'ACTIVE' => 'Y')
	: array('ACTIVE' => 'Y')
);

$rsIBlock = CIBlock::GetList(array('SORT' => 'ASC'), $iblockFilter);

while ($arr = $rsIBlock->Fetch())
	$arIBlock[$arr['ID']] = '['.$arr['ID'].'] '.$arr['NAME'];
unset($arr, $rsIBlock, $iblockFilter);

$arAccuracy = array(
    'city' => GetMessage("CITY"),
    'region' => GetMessage("REGION"),
    'district' => GetMessage("DISTRICT")
);

$arComponentParameters = array(
	"GROUPS" => array(
		
	),
	"PARAMETERS" => array(
		
		"IBLOCK_TYPE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_TYPE"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlockType,
			"REFRESH" => "Y",
		),
		"IBLOCK_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_IBLOCK"),
			"TYPE" => "LIST",
			"ADDITIONAL_VALUES" => "Y",
			"VALUES" => $arIBlock,
			"REFRESH" => "Y",
		),

		"CACHE_TIME" => array(
			"DEFAULT" => 36000000,
		),

                "COUNT_CITY" => array(
                    "NAME" => GetMessage("COUNT_CITY"),
                    "DEFAULT" => 8,
                ),

                "CONSIDER_SHOW_FORM" => array(
                    "NAME" => GetMessage("CONSIDER_SHOW_FORM"),
                    "TYPE" => "CHECKBOX",
                    "DEFAULT" => "N",
                ),

                "FORM_MODE" => array(
                    "TYPE" => "LIST",
                    "NAME" => GetMessage("FORM_MODE"),
                    "VALUES" => array(
                        "SELECT" => GetMessage("FORM_MODE_LIST_SELECT"),
                        "STATIC" => GetMessage("FORM_MODE_LIST_STATIC"),
                        "POPUP" => GetMessage("FORM_MODE_LIST_POPUP"),
                    ),
                    "DEFAULT" => 'POPUP',
                    "REFRESH" => "Y",
                ),
	),
);

if(isset($arCurrentValues["FORM_MODE"]) && $arCurrentValues["FORM_MODE"] === "SELECT" )
{
    $arComponentParameters["PARAMETERS"]["COUNT_CITY_SELECT"] = array(
        "NAME" => GetMessage("COUNT_CITY_SELECT"),
        "DEFAULT" => "",
    );
}
/*
if(!isset($arCurrentValues["FORM_MODE"]) || ($arCurrentValues["FORM_MODE"] === "POPUP" || $arCurrentValues["FORM_MODE"] === "SELECT") )
{ */
    $arComponentParameters["PARAMETERS"]["USE_SEARCH_TITLE"] = array (
        "NAME" => GetMessage("USE_SEARCH_TITLE"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    );
    
    $arComponentParameters["PARAMETERS"]["REGION_INFO_TEXT"] = array (
        "NAME" => GetMessage("REGION_INFO_TEXT"),
        "DEFAULT" => "",
    );
    
/*}*/
    
    $arComponentParameters["PARAMETERS"]["REGION_CORRECTLY"] = array (
        "NAME" => GetMessage("REGION_CORRECTLY"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
        "REFRESH" => "Y",
    );
    
    if(!isset($arCurrentValues["REGION_CORRECTLY"]) || ($arCurrentValues["REGION_CORRECTLY"] === "Y" ) )
    {     
        $arComponentParameters["PARAMETERS"]["REGION_CURRENT_INFO_TEXT"] = array (
            "NAME" => GetMessage("REGION_CURRENT_INFO_TEXT"),
            "DEFAULT" => "",
        );
    }

?>
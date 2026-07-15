<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arCurrentValues */
/** @global CUserTypeManager $USER_FIELD_MANAGER */
use Bitrix\Main\Loader;
use Bitrix\Iblock;

$arComponentParameters = array(
	"GROUPS" => array(
		"PROMO_BLOCK_SETTINGS" => array(
			"NAME" => GetMessage('PROMO_BLOCK_SETTINGS')
		),
		"SLIDER_SETTINGS" => array(
			"NAME" => GetMessage('SLIDER_SETTINGS'),
            "SORT" => 1000
		),
		"SLIDER_BREACKPOINT_XL" => array(
			"NAME" => GetMessage("SLIDER_BREACKPOINT_XL"),
            "SORT" => 1001
		),
		"SLIDER_BREACKPOINT_LG" => array(
			"NAME" => GetMessage("SLIDER_BREACKPOINT_LG"),
            "SORT" => 1002
		),
        "SLIDER_BREACKPOINT_MD" => array(
			"NAME" => GetMessage('SLIDER_BREACKPOINT_MD'),
            "SORT" => 1003
		),
		"SLIDER_BREACKPOINT_SM" => array(
			"NAME" => GetMessage('SLIDER_BREACKPOINT_SM'),
            "SORT" => 1004
		),
		"SLIDER_BREACKPOINT_XS" => array(
			"NAME" => GetMessage('SLIDER_BREACKPOINT_XS'),
            "SORT" => 1005
		),
		"ACTION_SETTINGS" => array(
			"NAME" => GetMessage('IBLOCK_ACTIONS')
		),
	),
	"PARAMETERS" => array(
		"CACHE_TIME"  =>  array("DEFAULT"=>36000000),
	),
);

global $arComponentGroups;

if (isset($arComponentGroups)){
	foreach ($arComponentGroups as $cell=>$val){
		$arComponentParameters["GROUPS"][$cell] = $val;
	}
}

if (Loader::includeModule('alexkova.market2')){

	$arLessParams = \Alexkova\Market2\Bxmarket::getLazyLoadParameters();

	if(is_array($arLessParams) && !empty($arLessParams)) {
		$arComponentParameters = array_merge_recursive($arComponentParameters, $arLessParams);
	}
}
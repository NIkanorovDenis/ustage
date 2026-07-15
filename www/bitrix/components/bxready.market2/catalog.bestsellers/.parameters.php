<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arCurrentValues */
/** @global CUserTypeManager $USER_FIELD_MANAGER */

use Bitrix\Main\Loader;

global $USER_FIELD_MANAGER;

if (!Loader::includeModule('iblock')
	|| !Loader::includeModule('alexkova.bxready2')
	|| !Loader::includeModule('alexkova.market2')){
	return;
}

$boolCatalog = Loader::includeModule("catalog");

$arIBlockType = CIBlockParameters::GetIBlockTypes();
$arIBlockType2 = CIBlockParameters::GetIBlockTypes();

$arIBlock = array();
$rsIBlock = CIBlock::GetList(array("sort" => "asc"), array("TYPE" => $arCurrentValues["IBLOCK_TYPE"], "ACTIVE"=>"Y"));
while($arr=$rsIBlock->Fetch())
	$arIBlock[$arr["ID"]] = "[".$arr["ID"]."] ".$arr["NAME"];

$arIBlock2 = array();
$rsIBlock2 = CIBlock::GetList(array("sort" => "asc"), array("TYPE" => $arCurrentValues["BESTSELLER_IBLOCK_TYPE"], "ACTIVE"=>"Y"));
while($arr=$rsIBlock2->Fetch())
	$arIBlock2[$arr["ID"]] = "[".$arr["ID"]."] ".$arr["NAME"];


$arProperty = array();
$arProperty_LNS = array();
$arProperty_N = array();
$arProperty_X = array();
if (0 < intval($arCurrentValues['IBLOCK_ID']))
{
	$rsProp = CIBlockProperty::GetList(array("sort"=>"asc", "name"=>"asc"), array("IBLOCK_ID"=>$arCurrentValues["IBLOCK_ID"], "ACTIVE"=>"Y"));
	while ($arr=$rsProp->Fetch())
	{
		if($arr["PROPERTY_TYPE"] != "F")
			$arProperty[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];

		if($arr["PROPERTY_TYPE"]=="N")
			$arProperty_N[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];

		if($arr["PROPERTY_TYPE"]!="F")
		{
			if($arr["MULTIPLE"] == "Y")
				$arProperty_X[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
			elseif($arr["PROPERTY_TYPE"] == "L")
				$arProperty_X[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
			elseif($arr["PROPERTY_TYPE"] == "E" && $arr["LINK_IBLOCK_ID"] > 0)
				$arProperty_X[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
		}
	}
}

$arProperty_UF = array();
$arSProperty_LNS = array();
$arUserFields = $USER_FIELD_MANAGER->GetUserFields("IBLOCK_".$arCurrentValues["IBLOCK_ID"]."_SECTION");
foreach($arUserFields as $FIELD_NAME=>$arUserField)
{
	$arProperty_UF[$FIELD_NAME] = $arUserField["LIST_COLUMN_LABEL"]? $arUserField["LIST_COLUMN_LABEL"]: $FIELD_NAME;
	if($arUserField["USER_TYPE"]["BASE_TYPE"]=="string")
		$arSProperty_LNS[$FIELD_NAME] = $arProperty_UF[$FIELD_NAME];
}

$arOffers = CIBlockPriceTools::GetOffersIBlock($arCurrentValues["IBLOCK_ID"]);
$OFFERS_IBLOCK_ID = is_array($arOffers)? $arOffers["OFFERS_IBLOCK_ID"]: 0;
$arProperty_Offers = array();
$arProperty_OffersWithoutFile = array();
if($OFFERS_IBLOCK_ID)
{
	$rsProp = CIBlockProperty::GetList(array("sort"=>"asc", "name"=>"asc"), array("IBLOCK_ID"=>$OFFERS_IBLOCK_ID, "ACTIVE"=>"Y"));
	while($arr=$rsProp->Fetch())
	{
		$arr['ID'] = intval($arr['ID']);
		if ($arOffers['OFFERS_PROPERTY_ID'] == $arr['ID'])
			continue;
		$strPropName = '['.$arr['ID'].']'.('' != $arr['CODE'] ? '['.$arr['CODE'].']' : '').' '.$arr['NAME'];
		if ('' == $arr['CODE'])
			$arr['CODE'] = $arr['ID'];
		$arProperty_Offers[$arr["CODE"]] = $strPropName;
		if ('F' != $arr['PROPERTY_TYPE'])
			$arProperty_OffersWithoutFile[$arr["CODE"]] = $strPropName;
	}
}

$arSort = CIBlockParameters::GetElementSortFields(
	array('SHOWS', 'SORT', 'TIMESTAMP_X', 'NAME', 'ID', 'ACTIVE_FROM', 'ACTIVE_TO'),
	array('KEY_LOWERCASE' => 'Y')
);

$arPrice = array();
if ($boolCatalog)
{
	$arSort = array_merge($arSort, CCatalogIBlockParameters::GetCatalogSortFields());
	$rsPrice=CCatalogGroup::GetList($v1="sort", $v2="asc");
	while($arr=$rsPrice->Fetch()) $arPrice[$arr["NAME"]] = "[".$arr["NAME"]."] ".$arr["NAME_LANG"];
}
else
{
	$arPrice = $arProperty_N;
}

$arAscDesc = array(
	"asc" => GetMessage("IBLOCK_SORT_ASC"),
	"desc" => GetMessage("IBLOCK_SORT_DESC"),
);

$arComponentParameters = array(
	"GROUPS" => array(
		"PRICES" => array(
			"NAME" => GetMessage("IBLOCK_PRICES"),
		),
		"BASKET" => array(
			"NAME" => GetMessage("IBLOCK_BASKET"),
		),
        "MOBILE_SETTINGS" =>array(
            "NAME" => GetMessage("MOBILE_SETTINGS"),
            "SORT" => 10000
        )
	),
	"PARAMETERS" => array(
		/*"AJAX_MODE" => array(),*/
		"BESTSELLER_IBLOCK_TYPE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BESTSELLER_IBLOCK_TYPE"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlockType2,
			"REFRESH" => "Y",
		),
		"BESTSELLER_IBLOCK_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BESTSELLER_IBLOCK_IBLOCK"),
			"TYPE" => "LIST",
			"ADDITIONAL_VALUES" => "Y",
			"VALUES" => $arIBlock2,
			"REFRESH" => "Y",
		),
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

		"ELEMENT_SORT_FIELD" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage("IBLOCK_ELEMENT_SORT_FIELD"),
			"TYPE" => "LIST",
			"VALUES" => $arSort,
			"ADDITIONAL_VALUES" => "Y",
			"DEFAULT" => "sort",
		),

		"PAGE_ELEMENT_COUNT" => array(
			"PARENT" => "VISUAL",
			"NAME" => GetMessage("IBLOCK_PAGE_ELEMENT_COUNT"),
			"TYPE" => "STRING",
			"DEFAULT" => "30",
		),

                "BXR_SHOW_MAX_QUANTITY" => array(
                        'PARENT' => 'VISUAL',
                        'NAME' => GetMessage('CP_BC_TPL_SHOW_MAX_QUANTITY'),
                        'TYPE' => 'LIST',
                        'REFRESH' => 'Y',
                        'MULTIPLE' => 'N',
                        'VALUES' => array(
                                'N' => GetMessage('CP_BC_TPL_SHOW_MAX_QUANTITY_N'),
                                'A' => GetMessage('CP_BC_TPL_SHOW_MAX_QUANTITY_A'),
                                'Y' => GetMessage('CP_BC_TPL_SHOW_MAX_QUANTITY_Y'),
                                'M' => GetMessage('CP_BC_TPL_SHOW_MAX_QUANTITY_M')
                        ),
                        'DEFAULT' => array('N')
                ),

		"PRICE_CODE" => array(
			"PARENT" => "PRICES",
			"NAME" => GetMessage("IBLOCK_PRICE_CODE"),
			"TYPE" => "LIST",
			"MULTIPLE" => "Y",
			"VALUES" => $arPrice,
		),
		"USE_PRICE_COUNT" => array(
			"PARENT" => "PRICES",
			"NAME" => GetMessage("IBLOCK_USE_PRICE_COUNT"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			),
		"SHOW_PRICE_COUNT" => array(
			"PARENT" => "PRICES",
			"NAME" => GetMessage("IBLOCK_SHOW_PRICE_COUNT"),
			"TYPE" => "STRING",
			"DEFAULT" => "1",
		),
		"PRICE_VAT_INCLUDE" => array(
			"PARENT" => "PRICES",
			"NAME" => GetMessage("IBLOCK_VAT_INCLUDE"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),

		"PRODUCT_ID_VARIABLE" => array(
			"PARENT" => "BASKET",
			"NAME" => GetMessage("IBLOCK_PRODUCT_ID_VARIABLE"),
			"TYPE" => "STRING",
			"DEFAULT" => "id",
		),
		"USE_PRODUCT_QUANTITY" => array(
			"PARENT" => "BASKET",
			"NAME" => GetMessage("CP_BCS_USE_PRODUCT_QUANTITY"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"REFRESH" => "Y",
		),
		"PRODUCT_QUANTITY_VARIABLE" => array(
			"PARENT" => "BASKET",
			"NAME" => GetMessage("CP_BCS_PRODUCT_QUANTITY_VARIABLE"),
			"TYPE" => "STRING",
			"DEFAULT" => "quantity",
			"HIDDEN" => (isset($arCurrentValues['USE_PRODUCT_QUANTITY']) && $arCurrentValues['USE_PRODUCT_QUANTITY'] == 'Y' ? 'N' : 'Y')
		),
		"ADD_PROPERTIES_TO_BASKET" => array(
			"PARENT" => "BASKET",
			"NAME" => GetMessage("CP_BCS_ADD_PROPERTIES_TO_BASKET"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
			"REFRESH" => "Y"
		),
		"PRODUCT_PROPS_VARIABLE" => array(
			"PARENT" => "BASKET",
			"NAME" => GetMessage("CP_BCS_PRODUCT_PROPS_VARIABLE"),
			"TYPE" => "STRING",
			"DEFAULT" => "prop",
			"HIDDEN" => (isset($arCurrentValues['ADD_PROPERTIES_TO_BASKET']) && $arCurrentValues['ADD_PROPERTIES_TO_BASKET'] == 'N' ? 'Y' : 'N')
		),
		"PARTIAL_PRODUCT_PROPERTIES" => array(
			"PARENT" => "BASKET",
			"NAME" => GetMessage("CP_BCS_PARTIAL_PRODUCT_PROPERTIES"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"HIDDEN" => (isset($arCurrentValues['ADD_PROPERTIES_TO_BASKET']) && $arCurrentValues['ADD_PROPERTIES_TO_BASKET'] == 'N' ? 'Y' : 'N')
		),
		"PRODUCT_PROPERTIES" => array(
			"PARENT" => "BASKET",
			"NAME" => GetMessage("CP_BCS_PRODUCT_PROPERTIES"),
			"TYPE" => "LIST",
			"MULTIPLE" => "Y",
			"VALUES" => $arProperty_X,
			"HIDDEN" => (isset($arCurrentValues['ADD_PROPERTIES_TO_BASKET']) && $arCurrentValues['ADD_PROPERTIES_TO_BASKET'] == 'N' ? 'Y' : 'N')
		),
		"CACHE_TIME"  =>  array("DEFAULT"=>36000000),
		"CACHE_FILTER" => array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => GetMessage("IBLOCK_CACHE_FILTER"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"CACHE_GROUPS" => array(
			"PARENT" => "CACHE_SETTINGS",
			"NAME" => GetMessage("CP_BCS_CACHE_GROUPS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),

		/***** bxready settings **********/
		"BXREADY_LIST_PAGE_BLOCK_TITLE" => array(
			"PARENT" => "BXREADY_LIST_MODE",
			"NAME" => GetMessage("PAGE_BLOCK_TITLE"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),

		"BXREADY_LIST_PAGE_BLOCK_TITLE_GLYPHICON" => array(
			"PARENT" => "BXREADY_LIST_MODE",
			"NAME" => GetMessage("PAGE_BLOCK_TITLE_GLYPHICON"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),

		"BXREADY_LIST_BOOTSTRAP_GRID_STYLE" => array(
			"PARENT" => "BXREADY_LIST_MODE",
			"NAME" => GetMessage("BOOTSTRAP_GRID_STYLE"),
			"TYPE" => "LIST",
			"VALUES" => $defaultBootstrapGrids,
			"REFRESH" => "Y",
			"DEFAULT" => 12
		),
        "MOBILE_SETTINGS_USE_LAZY_LOAD" => array(
            "PARENT" => "MOBILE_SETTINGS",
            "NAME" => GetMessage("MOBILE_SETTINGS_USE_LAZY_LOAD"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
        )
	),
);

if (isset($arCurrentValues['BXR_SHOW_MAX_QUANTITY']))
{
        if ($arCurrentValues['BXR_SHOW_MAX_QUANTITY'] !== 'N' && $arCurrentValues['BXR_SHOW_MAX_QUANTITY'] !== 'A')
        {
                $arComponentParameters["PARAMETERS"]['MESS_SHOW_MAX_QUANTITY'] = array(
                        'PARENT' => 'VISUAL',
                        'NAME' => GetMessage('CP_BC_TPL_MESS_SHOW_MAX_QUANTITY'),
                        'TYPE' => 'STRING',
                        'DEFAULT' => GetMessage('CP_BC_TPL_MESS_SHOW_MAX_QUANTITY_DEFAULT')
                );
        }

        if ($arCurrentValues['BXR_SHOW_MAX_QUANTITY'] === 'M')
        {
                $arComponentParameters["PARAMETERS"]['RELATIVE_QUANTITY_FACTOR'] = array(
                        'PARENT' => 'VISUAL',
                        'NAME' => GetMessage('CP_BC_TPL_RELATIVE_QUANTITY_FACTOR'),
                        'TYPE' => 'STRING',
                        'DEFAULT' => '5'
                );
                $arComponentParameters["PARAMETERS"]['MESS_RELATIVE_QUANTITY_MANY'] = array(
                        'PARENT' => 'VISUAL',
                        'NAME' => GetMessage('CP_BC_TPL_MESS_RELATIVE_QUANTITY_MANY'),
                        'TYPE' => 'STRING',
                        'DEFAULT' => GetMessage('CP_BC_TPL_MESS_RELATIVE_QUANTITY_MANY_DEFAULT')
                );
                $arComponentParameters["PARAMETERS"]['MESS_RELATIVE_QUANTITY_FEW'] = array(
                        'PARENT' => 'VISUAL',
                        'NAME' => GetMessage('CP_BC_TPL_MESS_RELATIVE_QUANTITY_FEW'),
                        'TYPE' => 'STRING',
                        'DEFAULT' => GetMessage('CP_BC_TPL_MESS_RELATIVE_QUANTITY_FEW_DEFAULT')
                );
        }
        if ($arCurrentValues['BXR_SHOW_MAX_QUANTITY'] === 'A')
        {
                $arComponentParameters["PARAMETERS"]['QUANTITY_IN_STOCK'] = array(
                        'PARENT' => 'VISUAL',
                        'NAME' => GetMessage('QUANTITY_IN_STOCK'),
                        'TYPE' => 'STRING',
                        'DEFAULT' => GetMessage('QUANTITY_IN_STOCK_DEFAULT_TEXT')
                );
                $arComponentParameters["PARAMETERS"]['QUANTITY_OUT_STOCK'] = array(
                        'PARENT' => 'VISUAL',
                        'NAME' => GetMessage('QUANTITY_OUT_STOCK'),
                        'TYPE' => 'STRING',
                        'DEFAULT' => GetMessage('QUANTITY_OUT_STOCK_DEFAULT_TEXT')
                );
        }
}

CIBlockParameters::AddPagerSettings($arComponentParameters, GetMessage("T_IBLOCK_DESC_PAGER_CATALOG"), true, true);



if ($boolCatalog)
{
	$arComponentParameters["PARAMETERS"]['HIDE_NOT_AVAILABLE'] = array(
		'PARENT' => 'DATA_SOURCE',
		'NAME' => GetMessage('CP_BCS_HIDE_NOT_AVAILABLE'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
	);
	$arComponentParameters["PARAMETERS"]['CONVERT_CURRENCY'] = array(
		'PARENT' => 'PRICES',
		'NAME' => GetMessage('CP_BCS_CONVERT_CURRENCY'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
		'REFRESH' => 'Y',
	);

	if (isset($arCurrentValues['CONVERT_CURRENCY']) && 'Y' == $arCurrentValues['CONVERT_CURRENCY'])
	{
		$arCurrencyList = array();
		$by = 'SORT';
		$order = 'ASC';
		$rsCurrencies = CCurrency::GetList($by, $order);
		while ($arCurrency = $rsCurrencies->Fetch())
		{
			$arCurrencyList[$arCurrency['CURRENCY']] = $arCurrency['CURRENCY'];
		}
		$arComponentParameters['PARAMETERS']['CURRENCY_ID'] = array(
			'PARENT' => 'PRICES',
			'NAME' => GetMessage('CP_BCS_CURRENCY_ID'),
			'TYPE' => 'LIST',
			'VALUES' => $arCurrencyList,
			'DEFAULT' => CCurrency::GetBaseCurrency(),
			"ADDITIONAL_VALUES" => "Y",
		);
	}
}

if(!$OFFERS_IBLOCK_ID)
{
	unset($arComponentParameters["PARAMETERS"]["OFFERS_FIELD_CODE"]);
	unset($arComponentParameters["PARAMETERS"]["OFFERS_PROPERTY_CODE"]);
	unset($arComponentParameters["PARAMETERS"]["OFFERS_SORT_FIELD"]);
	unset($arComponentParameters["PARAMETERS"]["OFFERS_SORT_ORDER"]);
	unset($arComponentParameters["PARAMETERS"]["OFFERS_SORT_FIELD2"]);
	unset($arComponentParameters["PARAMETERS"]["OFFERS_SORT_ORDER2"]);
}
else
{
	$arComponentParameters["PARAMETERS"]["OFFERS_PROPERTY_CODE"] = array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("CP_BCS_OFFERS_PROPERTY_CODE"),
		"TYPE" => "LIST",
		"MULTIPLE" => "Y",
		"VALUES" => $arProperty_OffersWithoutFile,
	);
}

$additionalParams = \Alexkova\Bxready2\Component::getCustomListSettings(

	12,
	$arCurrentValues,
	array(
		'slider'=>true,
		'title'=>true,
		'collection'=>array('ecommerce.m2.v1', 'ecommerce.m2.v1'),
		'sort'=>1050
	),

	'LISTPAGE'
);

if (is_array($additionalParams)){

	if (count($additionalParams['LIST_GROUPS'])>0){
		foreach ($additionalParams['LIST_GROUPS'] as $cell=>$val){
			$arComponentParameters["GROUPS"][$cell] = $val;
		}
	}

	if (count($additionalParams['LIST_PARAMS'])>0){
		foreach ($additionalParams['LIST_PARAMS'] as $cell=>$val){
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
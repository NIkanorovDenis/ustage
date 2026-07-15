<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var string $componentPath
 * @var string $componentName
 * @var array $arCurrentValues
 */

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Web\Json;

if (!Loader::includeModule('iblock'))
	return;

$boolCatalog = Loader::includeModule('catalog');
CBitrixComponent::includeComponentClass($componentName);

$defaultValue = array('-' => GetMessage('CP_BCS_TPL_PROP_EMPTY'));
$arSKU = false;
$boolSKU = false;
$filterDataValues = array();
if ($boolCatalog && (isset($arCurrentValues['IBLOCK_ID']) && 0 < intval($arCurrentValues['IBLOCK_ID'])))
{
	$arSKU = CCatalogSku::GetInfoByProductIBlock($arCurrentValues['IBLOCK_ID']);
	$boolSKU = !empty($arSKU) && is_array($arSKU);
	$filterDataValues['iblockId'] = (int)$arCurrentValues['IBLOCK_ID'];
	if ($boolSKU)
	{
		$filterDataValues['offersIblockId'] = $arSKU['IBLOCK_ID'];
	}
}

$arAllPropList = array();
$arFilePropList = $defaultValue;
$arListPropList = array();

if (isset($arCurrentValues['IBLOCK_ID']) && intval($arCurrentValues['IBLOCK_ID']) > 0)
{
	$rsProps = CIBlockProperty::GetList(
		array('SORT' => 'ASC', 'ID' => 'ASC'),
		array('IBLOCK_ID' => $arCurrentValues['IBLOCK_ID'], 'ACTIVE' => 'Y')
	);
	while ($arProp = $rsProps->Fetch())
	{
		$strPropName = '['.$arProp['ID'].']'.('' != $arProp['CODE'] ? '['.$arProp['CODE'].']' : '').' '.$arProp['NAME'];

		if ($arProp['CODE'] == '')
		{
			$arProp['CODE'] = $arProp['ID'];
		}

		$arAllPropList[$arProp['CODE']] = $strPropName;

		if ($arProp['PROPERTY_TYPE'] === 'F')
		{
			$arFilePropList[$arProp['CODE']] = $strPropName;
		}

		if ($arProp['PROPERTY_TYPE'] === 'L')
		{
			$arListPropList[$arProp['CODE']] = $strPropName;
		}
	}

	if ($boolSKU)
	{
		$arTemplateParameters['PRODUCT_DISPLAY_MODE'] = array(
			'PARENT' => 'VISUAL',
			'NAME' => GetMessage('CP_BCS_TPL_PRODUCT_DISPLAY_MODE'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'N',
			'ADDITIONAL_VALUES' => 'N',
			'REFRESH' => 'Y',
			'DEFAULT' => 'N',
			'VALUES' => array(
				'N' => GetMessage('CP_BCS_TPL_DML_SIMPLE'),
				'Y' => GetMessage('CP_BCS_TPL_DML_EXT')
			)
		);
	}

	if ($boolSKU && isset($arCurrentValues['PRODUCT_DISPLAY_MODE']) && 'Y' == $arCurrentValues['PRODUCT_DISPLAY_MODE'])
	{
		$arAllOfferPropList = array();
		$arFileOfferPropList = $arTreeOfferPropList = $defaultValue;
		$rsProps = CIBlockProperty::GetList(
			array('SORT' => 'ASC', 'ID' => 'ASC'),
			array('IBLOCK_ID' => $arSKU['IBLOCK_ID'], 'ACTIVE' => 'Y')
		);
		while ($arProp = $rsProps->Fetch())
		{
			if ($arProp['ID'] == $arSKU['SKU_PROPERTY_ID'])
				continue;
			$arProp['USER_TYPE'] = (string)$arProp['USER_TYPE'];
			$strPropName = '['.$arProp['ID'].']'.('' != $arProp['CODE'] ? '['.$arProp['CODE'].']' : '').' '.$arProp['NAME'];
			if ('' == $arProp['CODE'])
				$arProp['CODE'] = $arProp['ID'];
			$arAllOfferPropList[$arProp['CODE']] = $strPropName;
			if ('F' == $arProp['PROPERTY_TYPE'])
				$arFileOfferPropList[$arProp['CODE']] = $strPropName;
			if ('N' != $arProp['MULTIPLE'])
				continue;
			if (
				'L' == $arProp['PROPERTY_TYPE']
				|| 'E' == $arProp['PROPERTY_TYPE']
				|| ('S' == $arProp['PROPERTY_TYPE'] && 'directory' == $arProp['USER_TYPE'] && CIBlockPriceTools::checkPropDirectory($arProp))
			)
				$arTreeOfferPropList[$arProp['CODE']] = $strPropName;
		}

		$arTemplateParameters['OFFER_TREE_PROPS'] = array(
			'PARENT' => 'VISUAL',
			'NAME' => GetMessage('CP_BCS_TPL_OFFER_TREE_PROPS'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'Y',
			'ADDITIONAL_VALUES' => 'N',
			'REFRESH' => 'N',
			'DEFAULT' => '-',
			'VALUES' => $arTreeOfferPropList
		);
	}
}

if ($boolCatalog)
{
	$arTemplateParameters['SHOW_OLD_PRICE'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BCS_TPL_SHOW_OLD_PRICE'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N'
	);
	$arTemplateParameters['BXR_SHOW_MAX_QUANTITY'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BCS_TPL_SHOW_MAX_QUANTITY'),
		'TYPE' => 'LIST',
		'REFRESH' => 'Y',
		'MULTIPLE' => 'N',
		'VALUES' => array(			
			'N' => GetMessage('CP_BC_TPL_SHOW_MAX_QUANTITY_N'),
                        'A' => GetMessage('CP_BC_TPL_SHOW_MAX_QUANTITY_A'),
			'Y' => GetMessage('CP_BC_TPL_SHOW_MAX_QUANTITY_Y'),
			'M' => GetMessage('CP_BC_TPL_SHOW_MAX_QUANTITY_M')
		),
		'DEFAULT' => 'N',
	);

	if (isset($arCurrentValues['BXR_SHOW_MAX_QUANTITY']))
	{
		if ($arCurrentValues['BXR_SHOW_MAX_QUANTITY'] !== 'N' && $arCurrentValues['BXR_SHOW_MAX_QUANTITY'] !== 'A')
		{
			$arTemplateParameters['MESS_SHOW_MAX_QUANTITY'] = array(
				'PARENT' => 'VISUAL',
				'NAME' => GetMessage('CP_BCS_TPL_MESS_SHOW_MAX_QUANTITY'),
				'TYPE' => 'STRING',
				'DEFAULT' => GetMessage('CP_BCS_TPL_MESS_SHOW_MAX_QUANTITY_DEFAULT')
			);
		}

		if ($arCurrentValues['BXR_SHOW_MAX_QUANTITY'] === 'M')
		{
			$arTemplateParameters['RELATIVE_QUANTITY_FACTOR'] = array(
				'PARENT' => 'VISUAL',
				'NAME' => GetMessage('CP_BCS_TPL_RELATIVE_QUANTITY_FACTOR'),
				'TYPE' => 'STRING',
				'DEFAULT' => '5'
			);
			$arTemplateParameters['MESS_RELATIVE_QUANTITY_MANY'] = array(
				'PARENT' => 'VISUAL',
				'NAME' => GetMessage('CP_BCS_TPL_MESS_RELATIVE_QUANTITY_MANY'),
				'TYPE' => 'STRING',
				'DEFAULT' => GetMessage('CP_BCS_TPL_MESS_RELATIVE_QUANTITY_MANY_DEFAULT')
			);
			$arTemplateParameters['MESS_RELATIVE_QUANTITY_FEW'] = array(
				'PARENT' => 'VISUAL',
				'NAME' => GetMessage('CP_BCS_TPL_MESS_RELATIVE_QUANTITY_FEW'),
				'TYPE' => 'STRING',
				'DEFAULT' => GetMessage('CP_BCS_TPL_MESS_RELATIVE_QUANTITY_FEW_DEFAULT')
			);
		}
                if ($arCurrentValues['BXR_SHOW_MAX_QUANTITY'] === 'A')
		{
			$arTemplateParameters['QUANTITY_IN_STOCK'] = array(
				'PARENT' => 'VISUAL',
				'NAME' => GetMessage('QUANTITY_IN_STOCK'),
				'TYPE' => 'STRING',
				'DEFAULT' => GetMessage('QUANTITY_IN_STOCK_DEFAULT_TEXT')
			);
			$arTemplateParameters['QUANTITY_OUT_STOCK'] = array(
				'PARENT' => 'VISUAL',
				'NAME' => GetMessage('QUANTITY_OUT_STOCK'),
				'TYPE' => 'STRING',
				'DEFAULT' => GetMessage('QUANTITY_OUT_STOCK_DEFAULT_TEXT')
			);
                }
	}
	
	$arTemplateParameters['ADD_TO_BASKET_ACTION'] = array(
		'PARENT' => 'BASKET',
		'NAME' => GetMessage('CP_BCS_TPL_ADD_TO_BASKET_ACTION'),
		'TYPE' => 'LIST',
		'VALUES' => array(
			'ADD' => GetMessage('ADD_TO_BASKET_ACTION_ADD'),
			'BUY' => GetMessage('ADD_TO_BASKET_ACTION_BUY')
		),
		'DEFAULT' => 'ADD',
		'REFRESH' => 'N'
	);
}

$arTemplateParameters['MESS_BTN_BUY'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CP_BCS_TPL_MESS_BTN_BUY'),
	'TYPE' => 'STRING',
	'DEFAULT' => GetMessage('CP_BCS_TPL_MESS_BTN_BUY_DEFAULT')
);

$arTemplateParameters['LAZY_LOAD'] = array(
	'PARENT' => 'PAGER_SETTINGS',
	'NAME' => GetMessage('CP_BCS_TPL_LAZY_LOAD'),
	'TYPE' => 'CHECKBOX',
	'REFRESH' => 'Y',
	'DEFAULT' => 'N'
);

if (isset($arCurrentValues['LAZY_LOAD']) && $arCurrentValues['LAZY_LOAD'] === 'Y')
{
	$arTemplateParameters['MESS_BTN_LAZY_LOAD'] = array(
		'PARENT' => 'PAGER_SETTINGS',
		'NAME' => GetMessage('CP_BCS_TPL_MESS_BTN_LAZY_LOAD'),
		'TYPE' => 'TEXT',
		'DEFAULT' => GetMessage('CP_BCS_TPL_MESS_BTN_LAZY_LOAD_DEFAULT')
	);
}

$arTemplateParameters['LOAD_ON_SCROLL'] = array(
	'PARENT' => 'PAGER_SETTINGS',
	'NAME' => GetMessage('CP_BCS_TPL_LOAD_ON_SCROLL'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'N'
);

$arTemplateParameters['MESS_BTN_ADD_TO_BASKET'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CP_BCS_TPL_MESS_BTN_ADD_TO_BASKET'),
	'TYPE' => 'STRING',
	'DEFAULT' => GetMessage('CP_BCS_TPL_MESS_BTN_ADD_TO_BASKET_DEFAULT')
);
$arTemplateParameters['MESS_BTN_SUBSCRIBE'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CP_BCS_TPL_MESS_BTN_SUBSCRIBE'),
	'TYPE' => 'STRING',
	'DEFAULT' => GetMessage('CP_BCS_TPL_MESS_BTN_SUBSCRIBE_DEFAULT')
);

if (isset($arCurrentValues['DISPLAY_COMPARE']) && $arCurrentValues['DISPLAY_COMPARE'] === 'Y')
{
	$arTemplateParameters['MESS_BTN_COMPARE'] = array(
		'PARENT' => 'COMPARE',
		'NAME' => GetMessage('CP_BCS_TPL_MESS_BTN_COMPARE'),
		'TYPE' => 'STRING',
		'DEFAULT' => GetMessage('CP_BCS_TPL_MESS_BTN_COMPARE_DEFAULT')
	);
	$arTemplateParameters['COMPARE_NAME'] = array(
		'PARENT' => 'COMPARE',
		'NAME' => GetMessage('CP_BCS_TPL_COMPARE_NAME'),
		'TYPE' => 'STRING',
		'DEFAULT' => 'CATALOG_COMPARE_LIST'
	);
}

$arTemplateParameters['MESS_BTN_DETAIL'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CP_BCS_TPL_MESS_BTN_DETAIL'),
	'TYPE' => 'STRING',
	'DEFAULT' => GetMessage('CP_BCS_TPL_MESS_BTN_DETAIL_DEFAULT')
);
$arTemplateParameters['MESS_NOT_AVAILABLE'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CP_BCS_TPL_MESS_NOT_AVAILABLE'),
	'TYPE' => 'STRING',
	'DEFAULT' => GetMessage('CP_BCS_TPL_MESS_NOT_AVAILABLE_DEFAULT')
);

$arTemplateParameters['USE_ENHANCED_ECOMMERCE'] = array(
	'PARENT' => 'ANALYTICS_SETTINGS',
	'NAME' => GetMessage('CP_BCS_TPL_USE_ENHANCED_ECOMMERCE'),
	'TYPE' => 'CHECKBOX',
	'REFRESH' => 'Y',
	'DEFAULT' => 'N'
);

if (isset($arCurrentValues['USE_ENHANCED_ECOMMERCE']) && $arCurrentValues['USE_ENHANCED_ECOMMERCE'] === 'Y')
{
	$arTemplateParameters['DATA_LAYER_NAME'] = array(
		'PARENT' => 'ANALYTICS_SETTINGS',
		'NAME' => GetMessage('CP_BCS_TPL_DATA_LAYER_NAME'),
		'TYPE' => 'STRING',
		'DEFAULT' => 'dataLayer'
	);
	$arTemplateParameters['BRAND_PROPERTY'] = array(
		'PARENT' => 'ANALYTICS_SETTINGS',
		'NAME' => GetMessage('CP_BCS_TPL_BRAND_PROPERTY'),
		'TYPE' => 'LIST',
		'MULTIPLE' => 'N',
		'DEFAULT' => '',
		'VALUES' => $defaultValue + $arAllPropList
	);
}

if (Loader::includeModule('alexkova.bxready2')){

	global $arComponentGroups, $arReload;

	$additionalParams = \Alexkova\Bxready2\Component::getCustomListSettings(
                12,
                $arCurrentValues,
                array(
                        'slider' => true,
                        'collection' => array(
                                'ecommerce.m2.v1',
                                'ecommerce.m2.small.v1'
                        ),
                        'sort'=>300
                ),
                'LISTPAGE'
	);

	if (count($additionalParams['LIST_GROUPS'])>0){
		foreach($additionalParams["LIST_GROUPS"] as $cell=>$val){
				$arComponentGroups[$cell] = $val;
		}
	}

	if (count($additionalParams['LIST_PARAMS'])>0){
		foreach($additionalParams["LIST_PARAMS"] as $cell=>$val){
				$arTemplateParameters[$cell] = $val;
		}
	}
}
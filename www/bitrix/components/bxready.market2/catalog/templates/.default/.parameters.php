<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/** @var array $arCurrentValues */

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Web\Json;

if (!Loader::includeModule('iblock')
	|| !Loader::includeModule('alexkova.bxready2'))
	return;

$boolCatalog = Loader::includeModule('catalog');
CBitrixComponent::includeComponentClass('bitrix:catalog.section');
CBitrixComponent::includeComponentClass('bitrix:catalog.top');
CBitrixComponent::includeComponentClass('bitrix:catalog.element');

$arSKU = false;
$boolSKU = false;
if ($boolCatalog && (isset($arCurrentValues['IBLOCK_ID']) && (int)$arCurrentValues['IBLOCK_ID']) > 0)
{
	$arSKU = CCatalogSKU::GetInfoByProductIBlock($arCurrentValues['IBLOCK_ID']);
	$boolSKU = !empty($arSKU) && is_array($arSKU);
}

$defaultValue = array('-' => GetMessage('CP_BC_TPL_PROP_EMPTY'));

$arThemes = array();
if (ModuleManager::isModuleInstalled('bitrix.eshop'))
{
	$arThemes['site'] = GetMessage('CPT_BC_TPL_THEME_SITE');
}

$arThemes['blue'] = GetMessage('CPT_BC_TPL_THEME_BLUE');
$arThemes['green'] = GetMessage('CPT_BC_TPL_THEME_GREEN');
$arThemes['red'] = GetMessage('CPT_BC_TPL_THEME_RED');
$arThemes['wood'] = GetMessage('CPT_BC_TPL_THEME_WOOD');
$arThemes['yellow'] = GetMessage('CPT_BC_TPL_THEME_YELLOW');
$arThemes['black'] = GetMessage('CP_BC_TPL_THEME_BLACK');

$documentRoot = Loader::getDocumentRoot();

$arViewModeList = array(
	'LIST' => GetMessage('CPT_BC_SECTIONS_VIEW_MODE_LIST'),
	'LINE' => GetMessage('CPT_BC_SECTIONS_VIEW_MODE_LINE'),
	'TEXT' => GetMessage('CPT_BC_SECTIONS_VIEW_MODE_TEXT'),
	'TILE' => GetMessage('CPT_BC_SECTIONS_VIEW_MODE_TILE')
);

$arFilterViewModeList = array(
	"VERTICAL" => GetMessage("CPT_BC_FILTER_VIEW_MODE_VERTICAL"),
	"HORIZONTAL" => GetMessage("CPT_BC_FILTER_VIEW_MODE_HORIZONTAL")
);

$arTemplateParameters = array(
	"SECTIONS_VIEW_MODE" => array(
		"PARENT" => "SECTIONS_SETTINGS",
		"NAME" => GetMessage('CPT_BC_SECTIONS_VIEW_MODE'),
		"TYPE" => "LIST",
		"VALUES" => $arViewModeList,
		"MULTIPLE" => "N",
		"DEFAULT" => "LIST",
		"REFRESH" => "Y"
	),
	"SECTIONS_SHOW_PARENT_NAME" => array(
		"PARENT" => "SECTIONS_SETTINGS",
		"NAME" => GetMessage('CPT_BC_SECTIONS_SHOW_PARENT_NAME'),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y"
	)
);

if (isset($arCurrentValues['SECTIONS_VIEW_MODE']) && 'TILE' == $arCurrentValues['SECTIONS_VIEW_MODE'])
{
	$arTemplateParameters['SECTIONS_HIDE_SECTION_NAME'] = array(
		'PARENT' => 'SECTIONS_SETTINGS',
		'NAME' => GetMessage('CPT_BC_SECTIONS_HIDE_SECTION_NAME'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N'
	);
}

$arTemplateParameters["FILTER_VIEW_MODE"] = array(
	"PARENT" => "FILTER_SETTINGS",
	"NAME" => GetMessage('CPT_BC_FILTER_VIEW_MODE'),
	"TYPE" => "LIST",
	"VALUES" => $arFilterViewModeList,
	"DEFAULT" => "VERTICAL",
	"HIDDEN" => (!isset($arCurrentValues['USE_FILTER']) || 'N' == $arCurrentValues['USE_FILTER'])
);
$arTemplateParameters["FILTER_HIDE_ON_MOBILE"] = array(
	"PARENT" => "FILTER_SETTINGS",
	"NAME" => GetMessage("CPT_BC_FILTER_HIDE_ON_MOBILE"),
	"TYPE" => "CHECKBOX",
	"DEFAULT" => "N",
);
$arTemplateParameters["INSTANT_RELOAD"] = array(
	"PARENT" => "FILTER_SETTINGS",
	"NAME" => GetMessage("CPT_BC_INSTANT_RELOAD"),
	"TYPE" => "CHECKBOX",
	"DEFAULT" => "N",
);
$arTemplateParameters["DISPLAY_ELEMENT_COUNT"] = array(
        "PARENT" => "FILTER_SETTINGS",
        "NAME" => GetMessage('KZNC_DISPLAY_ELEMENT_COUNT_FILTER'),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "N"
);

$arAllPropList = array();
$arListPropList = array();
$arHighloadPropList = array();
$arFilePropList = $defaultValue;

if (isset($arCurrentValues['IBLOCK_ID']) && (int)$arCurrentValues['IBLOCK_ID'] > 0)
{
	$rsProps = CIBlockProperty::GetList(
		array('SORT' => 'ASC', 'ID' => 'ASC'),
		array('IBLOCK_ID' => $arCurrentValues['IBLOCK_ID'], 'ACTIVE' => 'Y')
	);
	while ($arProp = $rsProps->Fetch())
	{
		$strPropName = '['.$arProp['ID'].']'.('' != $arProp['CODE'] ? '['.$arProp['CODE'].']' : '').' '.$arProp['NAME'];
		if ('' == $arProp['CODE'])
		{
			$arProp['CODE'] = $arProp['ID'];
		}

		$arAllPropList[$arProp['CODE']] = $strPropName;

		if ('F' == $arProp['PROPERTY_TYPE'])
		{
			$arFilePropList[$arProp['CODE']] = $strPropName;
		}

		if ('L' == $arProp['PROPERTY_TYPE'])
		{
			$arListPropList[$arProp['CODE']] = $strPropName;
		}

		if ('S' == $arProp['PROPERTY_TYPE'] && 'directory' == $arProp['USER_TYPE'] && CIBlockPriceTools::checkPropDirectory($arProp))
		{
			$arHighloadPropList[$arProp['CODE']] = $strPropName;
		}
	}
        $arProperty_LNS = $arAllPropList;

	if (!empty($arCurrentValues['LIST_PROPERTY_CODE']))
	{
		$selected = array();

		foreach ($arCurrentValues['LIST_PROPERTY_CODE'] as $code)
		{
			if (isset($arAllPropList[$code]))
			{
				$selected[$code] = $arAllPropList[$code];
			}
		}

		$arTemplateParameters['LIST_PROPERTY_CODE_MOBILE'] = array(
			'PARENT' => 'LIST_SETTINGS',
			'NAME' => GetMessage('CP_BC_TPL_PROPERTY_CODE_MOBILE'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'Y',
			'VALUES' => $selected
		);
	}

	$arTemplateParameters['ADD_PICT_PROP'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BC_TPL_ADD_PICT_PROP'),
		'TYPE' => 'LIST',
		'MULTIPLE' => 'N',
		'ADDITIONAL_VALUES' => 'N',
		'REFRESH' => 'N',
		'DEFAULT' => '-',
		'VALUES' => $arFilePropList
	);

	if ($boolSKU)
	{
		$arTemplateParameters['PRODUCT_DISPLAY_MODE'] = array(
			'PARENT' => 'VISUAL',
			'NAME' => GetMessage('CP_BC_TPL_PRODUCT_DISPLAY_MODE'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'N',
			'ADDITIONAL_VALUES' => 'N',
			'REFRESH' => 'Y',
			'DEFAULT' => 'N',
			'VALUES' => array(
				'N' => GetMessage('CP_BC_TPL_DML_SIMPLE'),
				'Y' => GetMessage('CP_BC_TPL_DML_EXT')
			)
		);
		$arAllOfferPropList = array();
		$arFileOfferPropList = array(
			'-' => GetMessage('CP_BC_TPL_PROP_EMPTY')
		);
		$arTreeOfferPropList = array(
			'-' => GetMessage('CP_BC_TPL_PROP_EMPTY')
		);
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
		$arTemplateParameters['OFFER_ADD_PICT_PROP'] = array(
			'PARENT' => 'VISUAL',
			'NAME' => GetMessage('CP_BC_TPL_OFFER_ADD_PICT_PROP'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'N',
			'ADDITIONAL_VALUES' => 'N',
			'REFRESH' => 'N',
			'DEFAULT' => '-',
			'VALUES' => $arFileOfferPropList
		);
		$arTemplateParameters['OFFER_TREE_PROPS'] = array(
			'PARENT' => 'VISUAL',
			'NAME' => GetMessage('CP_BC_TPL_OFFER_TREE_PROPS'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'Y',
			'ADDITIONAL_VALUES' => 'N',
			'REFRESH' => 'N',
			'DEFAULT' => '-',
			'VALUES' => $arTreeOfferPropList
		);
	}
}

$arCurrentValues['DETAIL_PROPERTY_CODE'] = isset($arCurrentValues['DETAIL_PROPERTY_CODE']) ? $arCurrentValues['DETAIL_PROPERTY_CODE'] : array();
if (!empty($arCurrentValues['DETAIL_PROPERTY_CODE']))
{
	$selected = array();

	foreach ($arCurrentValues['DETAIL_PROPERTY_CODE'] as $code)
	{
		if (isset($arAllPropList[$code]))
		{
			$selected[$code] = $arAllPropList[$code];
		}
	}
}

$arCurrentValues['DETAIL_OFFERS_PROPERTY_CODE'] = isset($arCurrentValues['DETAIL_OFFERS_PROPERTY_CODE']) ? $arCurrentValues['DETAIL_OFFERS_PROPERTY_CODE'] : array();
if (!empty($arCurrentValues['DETAIL_OFFERS_PROPERTY_CODE']))
{
	$selected = array();

	foreach ($arCurrentValues['DETAIL_OFFERS_PROPERTY_CODE'] as $code)
	{
		if (isset($arAllOfferPropList[$code]))
		{
			$selected[$code] = $arAllOfferPropList[$code];
		}
	}
}

$arTemplateParameters['DETAIL_USE_VOTE_RATING'] = array(
	'PARENT' => 'DETAIL_SETTINGS',
	'NAME' => GetMessage('CP_BC_TPL_DETAIL_USE_VOTE_RATING'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'N',
	'REFRESH' => 'Y'
);

if (isset($arCurrentValues['DETAIL_USE_VOTE_RATING']) && 'Y' == $arCurrentValues['DETAIL_USE_VOTE_RATING'])
{
	$arTemplateParameters['DETAIL_VOTE_DISPLAY_AS_RATING'] = array(
		'PARENT' => 'DETAIL_SETTINGS',
		'NAME' => GetMessage('CP_BC_TPL_DETAIL_VOTE_DISPLAY_AS_RATING'),
		'TYPE' => 'LIST',
		'VALUES' => array(
			'rating' => GetMessage('CP_BC_TPL_DVDAR_RATING'),
			'vote_avg' => GetMessage('CP_BC_TPL_DVDAR_AVERAGE'),
		),
		'DEFAULT' => 'rating'
	);
}

$arTemplateParameters['DETAIL_USE_COMMENTS'] = array(
	'PARENT' => 'DETAIL_SETTINGS',
	'NAME' => GetMessage('CP_BC_TPL_DETAIL_USE_COMMENTS'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'N',
	'REFRESH' => 'Y'
);

if (isset($arCurrentValues['DETAIL_USE_COMMENTS']) && 'Y' == $arCurrentValues['DETAIL_USE_COMMENTS'])
{
	if (ModuleManager::isModuleInstalled("blog"))
	{
		$arTemplateParameters['DETAIL_BLOG_USE'] = array(
			'PARENT' => 'DETAIL_SETTINGS',
			'NAME' => GetMessage('CP_BC_TPL_DETAIL_BLOG_USE'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'N',
			'REFRESH' => 'Y'
		);
		if (isset($arCurrentValues['DETAIL_BLOG_USE']) && $arCurrentValues['DETAIL_BLOG_USE'] == 'Y')
		{
			$arTemplateParameters['DETAIL_BLOG_URL'] = array(
				'PARENT' => 'DETAIL_SETTINGS',
				'NAME' => GetMessage('CP_BC_DETAIL_TPL_BLOG_URL'),
				'TYPE' => 'STRING',
				'DEFAULT' => 'catalog_comments'
			);
			$arTemplateParameters['DETAIL_BLOG_EMAIL_NOTIFY'] = array(
				'PARENT' => 'DETAIL_SETTINGS',
				'NAME' => GetMessage('CP_BC_TPL_DETAIL_BLOG_EMAIL_NOTIFY'),
				'TYPE' => 'CHECKBOX',
				'DEFAULT' => 'N'
			);
		}
	}

	$boolRus = false;
	$langBy = "id";
	$langOrder = "asc";
	$rsLangs = CLanguage::GetList($langBy, $langOrder, array('ID' => 'ru',"ACTIVE" => "Y"));
	if ($arLang = $rsLangs->Fetch())
	{
		$boolRus = true;
	}

	if ($boolRus)
	{
		$arTemplateParameters['DETAIL_VK_USE'] = array(
			'PARENT' => 'DETAIL_SETTINGS',
			'NAME' => GetMessage('CP_BC_TPL_DETAIL_VK_USE'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'N',
			'REFRESH' => 'Y'
		);

		if (isset($arCurrentValues['DETAIL_VK_USE']) && 'Y' == $arCurrentValues['DETAIL_VK_USE'])
		{
			$arTemplateParameters['DETAIL_VK_API_ID'] = array(
				'PARENT' => 'DETAIL_SETTINGS',
				'NAME' => GetMessage('CP_BC_TPL_DETAIL_VK_API_ID'),
				'TYPE' => 'STRING',
				'DEFAULT' => 'API_ID'
			);
		}
	}

	$arTemplateParameters['DETAIL_FB_USE'] = array(
		'PARENT' => 'DETAIL_SETTINGS',
		'NAME' => GetMessage('CP_BC_TPL_DETAIL_FB_USE'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
		'REFRESH' => 'Y'
	);

	if (isset($arCurrentValues['DETAIL_FB_USE']) && 'Y' == $arCurrentValues['DETAIL_FB_USE'])
	{
		$arTemplateParameters['DETAIL_FB_APP_ID'] = array(
			'PARENT' => 'DETAIL_SETTINGS',
			'NAME' => GetMessage('CP_BC_TPL_DETAIL_FB_APP_ID'),
			'TYPE' => 'STRING',
			'DEFAULT' => ''
		);
	}
}

if (ModuleManager::isModuleInstalled("highloadblock"))
{
	$arTemplateParameters['DETAIL_BRAND_USE'] = array(
		'PARENT' => 'DETAIL_SETTINGS',
		'NAME' => GetMessage('CP_BC_TPL_DETAIL_BRAND_USE'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
		'REFRESH' => 'Y'
	);

	if (isset($arCurrentValues['DETAIL_BRAND_USE']) && 'Y' == $arCurrentValues['DETAIL_BRAND_USE'])
	{
		$arTemplateParameters['DETAIL_BRAND_PROP_CODE'] = array(
			'PARENT' => 'DETAIL_SETTINGS',
			"NAME" => GetMessage("CP_BC_TPL_DETAIL_PROP_CODE"),
			"TYPE" => "LIST",
			"VALUES" => $arHighloadPropList,
			"MULTIPLE" => "Y",
			"ADDITIONAL_VALUES" => "Y"
		);
	}
}
$arTemplateParameters['DETAIL_ANOUNCE_BLOCKS_ORDER'] = array(
        'PARENT' => 'DETAIL_SETTINGS',
        'NAME' => GetMessage('DETAIL_ANOUNCE_BLOCKS_ORDER'),
        'TYPE' => 'CUSTOM',
        'JS_FILE' => CatalogSectionComponent::getSettingsScript('/bitrix/components/bitrix/catalog.element', 'dragdrop_order'),
        'JS_EVENT' => 'initDraggableOrderControl',
        'JS_DATA' => Json::encode(array(
                'rating' => GetMessage('RATING_BLOCK_ORDER'),
                'preview_text' => GetMessage('PREVIEW_TEXT_BLOCK_ORDER'),
                'preview_props' => GetMessage('PREVIEW_PROPS_BLOCK_ORDER'),
        )),
        'DEFAULT' => 'rating,preview_text,preview_props'
);

$arTemplateParameters['DETAIL_BUY_BLOCKS_ORDER'] = array(
        'PARENT' => 'DETAIL_SETTINGS',
        'NAME' => GetMessage('DETAIL_BUY_BLOCKS_ORDER'),
        'TYPE' => 'CUSTOM',
        'JS_FILE' => CatalogSectionComponent::getSettingsScript('/bitrix/components/bitrix/catalog.element', 'dragdrop_order'),
        'JS_EVENT' => 'initDraggableOrderControl',
        'JS_DATA' => Json::encode(array(
                'price' => GetMessage('PRICE_BLOCK_ORDER'),
                'avail' => GetMessage('AVAIL_BLOCK_ORDER'),
                'sku' => GetMessage('SKU_BLOCK_ORDER'),
                'buy' => GetMessage('BUY_BLOCK_ORDER'),
                'share' => GetMessage('SHARE_BLOCK_ORDER'),
                'gift_notice' => GetMessage('CP_BC_TPL_PRODUCT_BLOCK_GIFT_NOTICE')
        )),
        'DEFAULT' => 'price,avail,sku,buy,share,gift_notice'
);


$arTemplateParameters['DETAIL_DETAIL_PICTURE_MODE'] = array(
	'PARENT' => 'DETAIL_SETTINGS',
	'NAME' => GetMessage('CP_BC_TPL_DETAIL_DETAIL_PICTURE_MODE'),
	'TYPE' => 'LIST',
	'MULTIPLE' => 'Y',
	'DEFAULT' => array('POPUP', 'MAGNIFIER'),
	'VALUES' => array(
		'POPUP' => GetMessage('DETAIL_DETAIL_PICTURE_MODE_POPUP'),
		'MAGNIFIER' => GetMessage('DETAIL_DETAIL_PICTURE_MODE_MAGNIFIER'),
	)
);

if ($boolCatalog)
{
	$arTemplateParameters['USE_COMMON_SETTINGS_BASKET_POPUP'] = array(
		'PARENT' => 'BASKET',
		'NAME' => GetMessage('CP_BC_TPL_USE_COMMON_SETTINGS_BASKET_POPUP'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
		'REFRESH' => 'Y'
	);
	$useCommonSettingsBasketPopup = (
		isset($arCurrentValues['USE_COMMON_SETTINGS_BASKET_POPUP'])
		&& $arCurrentValues['USE_COMMON_SETTINGS_BASKET_POPUP'] == 'Y'
	);
	$addToBasketActions = array(
		'BUY' => GetMessage('ADD_TO_BASKET_ACTION_BUY'),
		'ADD' => GetMessage('ADD_TO_BASKET_ACTION_ADD')
	);
	$arTemplateParameters['COMMON_ADD_TO_BASKET_ACTION'] = array(
		'PARENT' => 'BASKET',
		'NAME' => GetMessage('CP_BC_TPL_COMMON_ADD_TO_BASKET_ACTION'),
		'TYPE' => 'LIST',
		'VALUES' => $addToBasketActions,
		'DEFAULT' => 'ADD',
		'REFRESH' => 'N',
		'HIDDEN' => ($useCommonSettingsBasketPopup ? 'N' : 'Y')
	);
	$arTemplateParameters['COMMON_SHOW_CLOSE_POPUP'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BC_TPL_COMMON_SHOW_CLOSE_POPUP'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
	);
	$arTemplateParameters['TOP_ADD_TO_BASKET_ACTION'] = array(
		'PARENT' => 'BASKET',
		'NAME' => GetMessage('CP_BC_TPL_TOP_ADD_TO_BASKET_ACTION'),
		'TYPE' => 'LIST',
		'VALUES' => $addToBasketActions,
		'DEFAULT' => 'ADD',
		'REFRESH' => 'N',
		'HIDDEN' => (!$useCommonSettingsBasketPopup ? 'N' : 'Y')
	);
	$arTemplateParameters['SECTION_ADD_TO_BASKET_ACTION'] = array(
		'PARENT' => 'BASKET',
		'NAME' => GetMessage('CP_BC_TPL_SECTION_ADD_TO_BASKET_ACTION'),
		'TYPE' => 'LIST',
		'VALUES' => $addToBasketActions,
		'DEFAULT' => 'ADD',
		'REFRESH' => 'N',
		'HIDDEN' => (!$useCommonSettingsBasketPopup ? 'N' : 'Y')
	);
	$arTemplateParameters['DETAIL_ADD_TO_BASKET_ACTION'] = array(
		'PARENT' => 'BASKET',
		'NAME' => GetMessage('CP_BC_TPL_DETAIL_ADD_TO_BASKET_ACTION'),
		'TYPE' => 'LIST',
		'VALUES' => $addToBasketActions,
		'DEFAULT' => 'BUY',
		'REFRESH' => 'Y',
		'MULTIPLE' => 'Y',
		'HIDDEN' => (!$useCommonSettingsBasketPopup ? 'N' : 'Y')
	);

	if (!$useCommonSettingsBasketPopup && !empty($arCurrentValues['DETAIL_ADD_TO_BASKET_ACTION']))
	{
		$selected = array();

		if (!is_array($arCurrentValues['DETAIL_ADD_TO_BASKET_ACTION']))
		{
			$arCurrentValues['DETAIL_ADD_TO_BASKET_ACTION'] = array($arCurrentValues['DETAIL_ADD_TO_BASKET_ACTION']);
		}

		foreach ($arCurrentValues['DETAIL_ADD_TO_BASKET_ACTION'] as $action)
		{
			if (isset($addToBasketActions[$action]))
			{
				$selected[$action] = $addToBasketActions[$action];
			}
		}

		$arTemplateParameters['DETAIL_ADD_TO_BASKET_ACTION_PRIMARY'] = array(
			'PARENT' => 'BASKET',
			'NAME' => GetMessage('CP_BC_TPL_DETAIL_ADD_TO_BASKET_ACTION_PRIMARY'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'Y',
			'VALUES' => $selected,
			'DEFAULT' => 'BUY',
			'REFRESH' => 'N'
		);
		unset($selected);
	}

	$arTemplateParameters['PRODUCT_SUBSCRIPTION'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BC_TPL_PRODUCT_SUBSCRIPTION'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y',
	);
	$arTemplateParameters['SHOW_MAX_QUANTITY'] = array(
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
	);

	if (isset($arCurrentValues['SHOW_MAX_QUANTITY']))
	{
		if ($arCurrentValues['SHOW_MAX_QUANTITY'] !== 'N' && $arCurrentValues['SHOW_MAX_QUANTITY'] !== 'A')
		{
			$arTemplateParameters['MESS_SHOW_MAX_QUANTITY'] = array(
				'PARENT' => 'VISUAL',
				'NAME' => GetMessage('CP_BC_TPL_MESS_SHOW_MAX_QUANTITY'),
				'TYPE' => 'STRING',
				'DEFAULT' => GetMessage('CP_BC_TPL_MESS_SHOW_MAX_QUANTITY_DEFAULT')
			);
		}

		if ($arCurrentValues['SHOW_MAX_QUANTITY'] === 'M')
		{
			$arTemplateParameters['RELATIVE_QUANTITY_FACTOR'] = array(
				'PARENT' => 'VISUAL',
				'NAME' => GetMessage('CP_BC_TPL_RELATIVE_QUANTITY_FACTOR'),
				'TYPE' => 'STRING',
				'DEFAULT' => '5'
			);
			$arTemplateParameters['MESS_RELATIVE_QUANTITY_MANY'] = array(
				'PARENT' => 'VISUAL',
				'NAME' => GetMessage('CP_BC_TPL_MESS_RELATIVE_QUANTITY_MANY'),
				'TYPE' => 'STRING',
				'DEFAULT' => GetMessage('CP_BC_TPL_MESS_RELATIVE_QUANTITY_MANY_DEFAULT')
			);
			$arTemplateParameters['MESS_RELATIVE_QUANTITY_FEW'] = array(
				'PARENT' => 'VISUAL',
				'NAME' => GetMessage('CP_BC_TPL_MESS_RELATIVE_QUANTITY_FEW'),
				'TYPE' => 'STRING',
				'DEFAULT' => GetMessage('CP_BC_TPL_MESS_RELATIVE_QUANTITY_FEW_DEFAULT')
			);
		}
                if ($arCurrentValues['SHOW_MAX_QUANTITY'] === 'A')
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
}

$arTemplateParameters['LAZY_LOAD'] = array(
	'PARENT' => 'PAGER_SETTINGS',
	'NAME' => GetMessage('CP_BC_TPL_LAZY_LOAD'),
	'TYPE' => 'CHECKBOX',
	'REFRESH' => 'Y',
	'DEFAULT' => 'N'
);

if (isset($arCurrentValues['LAZY_LOAD']) && $arCurrentValues['LAZY_LOAD'] === 'Y')
{
	$arTemplateParameters['MESS_BTN_LAZY_LOAD'] = array(
		'PARENT' => 'PAGER_SETTINGS',
		'NAME' => GetMessage('CP_BC_TPL_MESS_BTN_LAZY_LOAD'),
		'TYPE' => 'TEXT',
		'DEFAULT' => GetMessage('CP_BC_TPL_MESS_BTN_LAZY_LOAD_DEFAULT')
	);
}

$arTemplateParameters['LOAD_ON_SCROLL'] = array(
	'PARENT' => 'PAGER_SETTINGS',
	'NAME' => GetMessage('CP_BC_TPL_LOAD_ON_SCROLL'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'N'
);

$arTemplateParameters['MESS_BTN_BUY'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CP_BC_TPL_MESS_BTN_BUY'),
	'TYPE' => 'STRING',
	'DEFAULT' => GetMessage('CP_BC_TPL_MESS_BTN_BUY_DEFAULT')
);
$arTemplateParameters['MESS_BTN_ADD_TO_BASKET'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CP_BC_TPL_MESS_BTN_ADD_TO_BASKET'),
	'TYPE' => 'STRING',
	'DEFAULT' => GetMessage('CP_BC_TPL_MESS_BTN_ADD_TO_BASKET_DEFAULT')
);
$arTemplateParameters['MESS_BTN_COMPARE'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CP_BC_TPL_MESS_BTN_COMPARE'),
	'TYPE' => 'STRING',
	'DEFAULT' => GetMessage('CP_BC_TPL_MESS_BTN_COMPARE_DEFAULT')
);
$arTemplateParameters['MESS_BTN_DETAIL'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CP_BC_TPL_MESS_BTN_DETAIL'),
	'TYPE' => 'STRING',
	'DEFAULT' => GetMessage('CP_BC_TPL_MESS_BTN_DETAIL_DEFAULT')
);
$arTemplateParameters['MESS_NOT_AVAILABLE'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CP_BC_TPL_MESS_NOT_AVAILABLE'),
	'TYPE' => 'STRING',
	'DEFAULT' => GetMessage('CP_BC_TPL_MESS_NOT_AVAILABLE_DEFAULT')
);
$arTemplateParameters['MESS_BTN_SUBSCRIBE'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CP_BC_TPL_MESS_BTN_SUBSCRIBE'),
	'TYPE' => 'STRING',
	'DEFAULT' => GetMessage('CP_BC_TPL_MESS_BTN_SUBSCRIBE_DEFAULT')
);

if (isset($arCurrentValues['USE_ALSO_BUY']) && $arCurrentValues['USE_ALSO_BUY'] === 'Y')
{
    $arTemplateParameters["ALSO_BUY_TITLE"] = array(
            "PARENT" => "ALSO_BUY_SETTINGS",
            "NAME" => GetMessage("ALSO_BUY_TITLE"),
            'TYPE' => 'STRING',
            'DEFAULT' => GetMessage('ALSO_BUY_TITLE_TEXT'),
    );
}

if (ModuleManager::isModuleInstalled("sale"))
{
	$arTemplateParameters['USE_SALE_BESTSELLERS'] = array(
		'NAME' => GetMessage('CP_BC_TPL_USE_SALE_BESTSELLERS'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y',
		'REFRESH' => 'Y'
	);

	$arTemplateParameters['USE_BIG_DATA'] = array(
		'PARENT' => 'BIG_DATA_SETTINGS',
		'NAME' => GetMessage('CP_BC_TPL_USE_BIG_DATA'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y',
		'REFRESH' => 'Y'
	);
	if (!isset($arCurrentValues['USE_BIG_DATA']) || $arCurrentValues['USE_BIG_DATA'] == 'Y')
	{
		$rcmTypeList = array(
			'bestsell' => GetMessage('CP_BC_TPL_RCM_BESTSELLERS'),
			'personal' => GetMessage('CP_BC_TPL_RCM_PERSONAL'),
			'similar_sell' => GetMessage('CP_BC_TPL_RCM_SOLD_WITH'),
			'similar_view' => GetMessage('CP_BC_TPL_RCM_VIEWED_WITH'),
			'similar' => GetMessage('CP_BC_TPL_RCM_SIMILAR'),
			'any_similar' => GetMessage('CP_BC_TPL_RCM_SIMILAR_ANY'),
			'any_personal' => GetMessage('CP_BC_TPL_RCM_PERSONAL_WBEST'),
			'any' => GetMessage('CP_BC_TPL_RCM_RAND')
		);
		$arTemplateParameters['BIG_DATA_RCM_TYPE'] = array(
			'PARENT' => 'BIG_DATA_SETTINGS',
			'NAME' => GetMessage('CP_BC_TPL_BIG_DATA_RCM_TYPE'),
			'TYPE' => 'LIST',
			'VALUES' => $rcmTypeList
		);
		unset($rcmTypeList);
                
                $arTemplateParameters['BIG_DATA_TITLE'] = array(
                        'PARENT' => 'BIG_DATA_SETTINGS',
                        'NAME' => GetMessage('BIG_DATA_TITLE'),
                        'TYPE' => 'STRING',
                        'DEFAULT' => GetMessage('BIG_DATA_TITLE_TEXT'),
                );

                $arTemplateParameters['BIG_DATA_CNT'] = array(
                        'PARENT' => 'BIG_DATA_SETTINGS',
                        "NAME" => GetMessage("BIG_DATA_CNT"),
                        'TYPE' => 'STRING',
                        'DEFAULT' => 4,
                );
	}
        
        $arTemplateParameters["USE_BIGDATA_DETAIL"] = array(
                "PARENT" => "BIG_DATA_SETTINGS",
                "NAME" => GetMessage('CP_BC_TPL_USE_BIG_DATA_DETAIL'),
                "TYPE" => "CHECKBOX",
                "DEFAULT" => "N",
                "REFRESH" => "Y",
        );
        if (!isset($arCurrentValues['USE_BIGDATA_DETAIL']) || $arCurrentValues['USE_BIGDATA_DETAIL'] == 'Y')
	{
            $rcmTypeList = array(
                    'bestsell' => GetMessage('CP_BC_TPL_RCM_BESTSELLERS'),
                    'personal' => GetMessage('CP_BC_TPL_RCM_PERSONAL'),
                    'similar_sell' => GetMessage('CP_BC_TPL_RCM_SOLD_WITH'),
                    'similar_view' => GetMessage('CP_BC_TPL_RCM_VIEWED_WITH'),
                    'similar' => GetMessage('CP_BC_TPL_RCM_SIMILAR'),
                    'any_similar' => GetMessage('CP_BC_TPL_RCM_SIMILAR_ANY'),
                    'any_personal' => GetMessage('CP_BC_TPL_RCM_PERSONAL_WBEST'),
                    'any' => GetMessage('CP_BC_TPL_RCM_RAND')
            );
            $arTemplateParameters['BIG_DATA_RCM_TYPE_DETAIL'] = array(
                    'PARENT' => 'BIG_DATA_SETTINGS',
                    'NAME' => GetMessage('CP_BC_TPL_BIG_DATA_RCM_TYPE_DETAIL'),
                    'TYPE' => 'LIST',
                    'VALUES' => $rcmTypeList
            );
            unset($rcmTypeList);

            $arTemplateParameters['BIG_DATA_TITLE_DETAIL'] = array(
                    'PARENT' => 'BIG_DATA_SETTINGS',
                    'NAME' => GetMessage('BIG_DATA_TITLE_DETAIL'),
                    'TYPE' => 'STRING',
                    'DEFAULT' => GetMessage('BIG_DATA_TITLE_TEXT_DETAIL'),
            );

            $arTemplateParameters['BIG_DATA_CNT_DETAIL'] = array(
                    'PARENT' => 'BIG_DATA_SETTINGS',
                    "NAME" => GetMessage("BIG_DATA_CNT_DETAIL"),
                    'TYPE' => 'STRING',
                    'DEFAULT' => 4,
            );
        }
}
/*
if (isset($arCurrentValues['SHOW_TOP_ELEMENTS']) && 'Y' == $arCurrentValues['SHOW_TOP_ELEMENTS'])
{
	$arTemplateParameters['TOP_VIEW_MODE'] = array(
		'PARENT' => 'TOP_SETTINGS',
		'NAME' => GetMessage('CPT_BC_TPL_TOP_VIEW_MODE'),
		'TYPE' => 'LIST',
		'VALUES' => array(
			'BANNER' => GetMessage('CPT_BC_TPL_VIEW_MODE_BANNER'),
			'SLIDER' => GetMessage('CPT_BC_TPL_VIEW_MODE_SLIDER'),
			'SECTION' => GetMessage('CPT_BC_TPL_VIEW_MODE_SECTION')
		),
		'MULTIPLE' => 'N',
		'DEFAULT' => 'SECTION',
		'REFRESH' => 'Y'
	);

	if (isset($arCurrentValues['TOP_VIEW_MODE']) && ('SLIDER' == $arCurrentValues['TOP_VIEW_MODE'] || 'BANNER' == $arCurrentValues['TOP_VIEW_MODE']))
	{
		$arTemplateParameters['TOP_ROTATE_TIMER'] = array(
			'PARENT' => 'TOP_SETTINGS',
			'NAME' => GetMessage('CPT_BC_TPL_TOP_ROTATE_TIMER'),
			'TYPE' => 'STRING',
			'DEFAULT' => '30'
		);
	}

	if (isset($arCurrentValues['TOP_VIEW_MODE']) && $arCurrentValues['TOP_VIEW_MODE'] === 'SECTION')
	{
		if (!empty($arCurrentValues['TOP_PROPERTY_CODE']))
		{
			$selected = array();

			foreach ($arCurrentValues['TOP_PROPERTY_CODE'] as $code)
			{
				if (isset($arAllPropList[$code]))
				{
					$selected[$code] = $arAllPropList[$code];
				}
			}

			$arTemplateParameters['TOP_PROPERTY_CODE_MOBILE'] = array(
				'PARENT' => 'TOP_SETTINGS',
				'NAME' => GetMessage('CP_BC_TPL_PROPERTY_CODE_MOBILE'),
				'TYPE' => 'LIST',
				'MULTIPLE' => 'Y',
				'VALUES' => $selected
			);
		}

		$arTemplateParameters['TOP_PRODUCT_BLOCKS_ORDER'] = array(
			'PARENT' => 'TOP_SETTINGS',
			'NAME' => GetMessage('CP_BC_TPL_PRODUCT_BLOCKS_ORDER'),
			'TYPE' => 'CUSTOM',
			'JS_FILE' => CatalogTopComponent::getSettingsScript('/bitrix/components/bitrix/catalog.top', 'dragdrop_order'),
			'JS_EVENT' => 'initDraggableOrderControl',
			'JS_DATA' => Json::encode(array(
				'price' => GetMessage('CP_BC_TPL_PRODUCT_BLOCK_PRICE'),
				'quantityLimit' => GetMessage('CP_BC_TPL_PRODUCT_BLOCK_QUANTITY_LIMIT'),
				'quantity' => GetMessage('CP_BC_TPL_PRODUCT_BLOCK_QUANTITY'),
				'buttons' => GetMessage('CP_BC_TPL_PRODUCT_BLOCK_BUTTONS'),
				'props' => GetMessage('CP_BC_TPL_PRODUCT_BLOCK_PROPS'),
				'sku' => GetMessage('CP_BC_TPL_PRODUCT_BLOCK_SKU'),
				'compare' => GetMessage('CP_BC_TPL_PRODUCT_BLOCK_COMPARE')
			)),
			'DEFAULT' => 'price,props,sku,quantityLimit,quantity,buttons,compare'
		);

		$lineElementCount = (int)$arCurrentValues['TOP_LINE_ELEMENT_COUNT'] ?: 3;
		$pageElementCount = (int)$arCurrentValues['TOP_ELEMENT_COUNT'] ?: 9;

//		$arTemplateParameters['TOP_PRODUCT_ROW_VARIANTS'] = array(
//			'PARENT' => 'TOP_SETTINGS',
//			'NAME' => GetMessage('CP_BC_TPL_PRODUCT_ROW_VARIANTS'),
//			'TYPE' => 'CUSTOM',
//			'BIG_DATA' => 'N',
//			'COUNT_PARAM_NAME' => 'TOP_ELEMENT_COUNT',
//			'JS_FILE' => CatalogTopComponent::getSettingsScript('/bitrix/components/bitrix/catalog.top', 'dragdrop_add'),
//			'JS_EVENT' => 'initDraggableAddControl',
//			'JS_MESSAGES' => Json::encode(array(
//				'variant' => GetMessage('CP_BC_TPL_SETTINGS_VARIANT'),
//				'delete' => GetMessage('CP_BC_TPL_SETTINGS_DELETE'),
//				'quantity' => GetMessage('CP_BC_TPL_SETTINGS_QUANTITY'),
//				'quantityBigData' => GetMessage('CP_BC_TPL_SETTINGS_QUANTITY_BIG_DATA')
//			)),
//			'JS_DATA' => Json::encode(CatalogTopComponent::getTemplateVariantsMap()),
//			'DEFAULT' => Json::encode(CatalogTopComponent::predictRowVariants($lineElementCount, $pageElementCount))
//		);

		$arTemplateParameters['TOP_ENLARGE_PRODUCT'] = array(
			'PARENT' => 'TOP_SETTINGS',
			'NAME' => GetMessage('CP_BC_TPL_ENLARGE_PRODUCT'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'N',
			'ADDITIONAL_VALUES' => 'N',
			'REFRESH' => 'Y',
			'DEFAULT' => 'N',
			'VALUES' => array(
				'STRICT' => GetMessage('CP_BC_TPL_ENLARGE_PRODUCT_STRICT'),
				'PROP' => GetMessage('CP_BC_TPL_ENLARGE_PRODUCT_PROP')
			)
		);

		if (isset($arCurrentValues['TOP_ENLARGE_PRODUCT']) && $arCurrentValues['TOP_ENLARGE_PRODUCT'] === 'PROP')
		{
			$arTemplateParameters['TOP_ENLARGE_PROP'] = array(
				'PARENT' => 'TOP_SETTINGS',
				'NAME' => GetMessage('CP_BC_TPL_ENLARGE_PROP'),
				'TYPE' => 'LIST',
				'MULTIPLE' => 'N',
				'ADDITIONAL_VALUES' => 'N',
				'REFRESH' => 'N',
				'DEFAULT' => '-',
				'VALUES' => $defaultValue + $arListPropList
			);
		}
		$arTemplateParameters['TOP_SHOW_SLIDER'] = array(
			'PARENT' => 'TOP_SETTINGS',
			'NAME' => GetMessage('CP_BC_TPL_SHOW_SLIDER'),
			'TYPE' => 'CHECKBOX',
			'MULTIPLE' => 'N',
			'REFRESH' => 'Y',
			'DEFAULT' => 'Y'
		);

		if (!isset($arCurrentValues['TOP_SHOW_SLIDER']) || $arCurrentValues['TOP_SHOW_SLIDER'] === 'Y')
		{
			$arTemplateParameters['TOP_SLIDER_INTERVAL'] = array(
				'PARENT' => 'TOP_SETTINGS',
				'NAME' => GetMessage('CP_BC_TPL_SLIDER_INTERVAL'),
				'TYPE' => 'TEXT',
				'MULTIPLE' => 'N',
				'REFRESH' => 'N',
				'DEFAULT' => '3000'
			);
			$arTemplateParameters['TOP_SLIDER_PROGRESS'] = array(
				'PARENT' => 'TOP_SETTINGS',
				'NAME' => GetMessage('CP_BC_TPL_SLIDER_PROGRESS'),
				'TYPE' => 'CHECKBOX',
				'MULTIPLE' => 'N',
				'REFRESH' => 'N',
				'DEFAULT' => 'N'
			);
		}
	}
}*/

$arLeftMenuShow = array(
    'N' => GetMessage('CPT_LEFTMENU_LIST_N'),
    'Y' => GetMessage('CPT_LEFTMENU_LIST_Y'),
    'T' => GetMessage('CPT_LEFTMENU_LIST_T'),
);
$arTemplateParameters['INDEX_SHOW_IBLOCK_DESCRIPTION'] = array(
	'PARENT' => 'SECTIONS_SETTINGS',
	'NAME' => GetMessage('INDEX_SHOW_IBLOCK_DESCRIPTION'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'Y',
	'SORT' => 770
);
$arTemplateParameters['INDEX_SHOW_DESCRIPTION'] = array(
	'PARENT' => 'SECTIONS_SETTINGS',
	'NAME' => GetMessage('INDEX_SHOW_DESCRIPTION'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'Y',
	'SORT' => 780
);
$arTemplateParameters['SIDEBAR_INDEX_SHOW'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CPT_SIDEBAR_INDEX_SHOW'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'Y',
	'SORT' => 790
);
$arTemplateParameters['LEFTMENU_INDEX_SHOW'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CPT_LEFTMENU_INDEX_SHOW'),
	'TYPE' => 'LIST',
	'DEFAULT' => 'Y',
	'SORT' => 795,
        'MULTIPLE' => 'N',
	'VALUES' => $arLeftMenuShow
);
$arTemplateParameters['SIDEBAR_SECTION_SHOW'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CPT_SIDEBAR_SECTION_SHOW'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'Y',
	'SORT' => 800
);
$arTemplateParameters['LEFTMENU_SECTION_SHOW'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CPT_LEFTMENU_SECTION_SHOW'),
	'TYPE' => 'LIST',
	'DEFAULT' => 'Y',
	'SORT' => 805,
        'MULTIPLE' => 'N',
	'VALUES' => $arLeftMenuShow
);
/*$arTemplateParameters['SIDEBAR_DETAIL_SHOW'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CPT_SIDEBAR_DETAIL_SHOW'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'N',
	'SORT' => 810
);*/
$arTemplateParameters['LEFTMENU_DETAIL_SHOW'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CPT_LEFTMENU_DETAIL_SHOW'),
	'TYPE' => 'LIST',
	'DEFAULT' => 'Y',
	'SORT' => 815,
        'MULTIPLE' => 'N',
	'VALUES' => $arLeftMenuShow
);
$arTemplateParameters['SIDEBAR_PATH'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CPT_SIDEBAR_PATH'),
	'TYPE' => 'STRING',
	'SORT' => 820
);

$arTemplateParameters['USE_ENHANCED_ECOMMERCE'] = array(
	'PARENT' => 'ANALYTICS_SETTINGS',
	'NAME' => GetMessage('CP_BC_TPL_USE_ENHANCED_ECOMMERCE'),
	'TYPE' => 'CHECKBOX',
	'REFRESH' => 'Y',
	'DEFAULT' => 'N'
);

if (isset($arCurrentValues['USE_ENHANCED_ECOMMERCE']) && $arCurrentValues['USE_ENHANCED_ECOMMERCE'] === 'Y')
{
	$arTemplateParameters['DATA_LAYER_NAME'] = array(
		'PARENT' => 'ANALYTICS_SETTINGS',
		'NAME' => GetMessage('CP_BC_TPL_DATA_LAYER_NAME'),
		'TYPE' => 'STRING',
		'DEFAULT' => 'dataLayer'
	);
	$arTemplateParameters['BRAND_PROPERTY'] = array(
		'PARENT' => 'ANALYTICS_SETTINGS',
		'NAME' => GetMessage('CP_BC_TPL_BRAND_PROPERTY'),
		'TYPE' => 'LIST',
		'MULTIPLE' => 'N',
		'DEFAULT' => '',
		'VALUES' => $defaultValue + $arAllPropList
	);
}

$arTemplateParameters['USE_RATIO_IN_RANGES'] = array(
	'PARENT' => 'PRICES',
	'NAME' => GetMessage('CP_BC_TPL_USE_RATIO_IN_RANGES'),
	'TYPE' => 'CHECKBOX',
	'HIDDEN' => isset($arCurrentValues['USE_PRICE_COUNT']) && $arCurrentValues['USE_PRICE_COUNT'] === 'Y' ? 'N' : 'Y',
	'DEFAULT' => 'Y'
);


$arTemplateParameters["PREVIEW_DETAIL_PROPERTY_CODE"] = array(
        "PARENT" => "DETAIL_SETTINGS",
        "NAME" => GetMessage("PREVIEW_DETAIL_PROPERTY_CODE"),
        "TYPE" => "LIST",
        "MULTIPLE" => "Y",
        "ADDITIONAL_VALUES" => "Y",
        "VALUES" => $arAllPropList,
);

$arTemplateParameters['HIDE_PREVIEW_PROPS_INLIST'] = array(
	'PARENT' => 'DETAIL_SETTINGS',
	'NAME' => GetMessage('HIDE_PREVIEW_PROPS_INLIST'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'Y'
);

$arTemplateParameters['OWN_CODES_SERVICE_PROPERTIES'] = array(
	'PARENT' => 'DETAIL_SETTINGS',
	'NAME' => GetMessage('OWN_CODES_SERVICE_PROPERTIES'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'N',
	'REFRESH' => 'Y',
);

if (isset($arCurrentValues['OWN_CODES_SERVICE_PROPERTIES']) && $arCurrentValues['OWN_CODES_SERVICE_PROPERTIES'] === 'Y')
{
	$arTemplateParameters['OWN_CODES_BXR_FILES'] = array(
		'PARENT' => 'DETAIL_SETTINGS',
		'NAME' => GetMessage('OWN_CODES_BXR_FILES'),
		'TYPE' => 'STRING',
		'DEFAULT' => 'BXR_FILES',
	);

	$arTemplateParameters['OWN_CODES_BXR_VIDEO'] = array(
		'PARENT' => 'DETAIL_SETTINGS',
		'NAME' => GetMessage('OWN_CODES_BXR_VIDEO'),
		'TYPE' => 'STRING',
		'DEFAULT' => 'BXR_VIDEO',
	);

	$arTemplateParameters['OWN_CODES_BXR_SCHEMES'] = array(
		'PARENT' => 'DETAIL_SETTINGS',
		'NAME' => GetMessage('OWN_CODES_BXR_SCHEMES'),
		'TYPE' => 'STRING',
		'DEFAULT' => 'BXR_SCHEMES',
	);
}

$arTimerValues = array(
    'LIGHT' => GetMessage('BXR_ACTION_TIMER_LIGHT'),
    'DARK' => GetMessage('BXR_ACTION_TIMER_DARK')
);

$arTemplateParameters['BXR_SHOW_ACTION_TIMER_DETAIL'] = array(
    'PARENT' => 'BXR_ELEMENT_SETTINGS',
    'NAME' => GetMessage('CP_BCS_TPL_SHOW_ACTION_TIMER'),
    'TYPE' => 'LIST',
    'VALUES' => $arTimerValues,
    'DEFAULT' => 'N',
);

$arTemplateParameters['USE_FAVORITES'] = array(
	'PARENT' => 'KZNC_BUTTON_BLOCK',
	'NAME' => GetMessage('KZNC_USE_FAVORITES'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'Y',
	'REFRESH' => 'Y',
);
if (isset($arCurrentValues['USE_FAVORITES']) && 'Y' == $arCurrentValues['USE_FAVORITES']) {
	$arTemplateParameters['USE_FAVORITES_TEXT'] = array(
		'PARENT' => 'KZNC_BUTTON_BLOCK',
		'NAME' => GetMessage('KZNC_USE_FAVORITES_TEXT'),
		'TYPE' => 'STRING',
		'DEFAULT' => GetMessage('KZNC_USE_FAVORITES_TEXT_DEFAULT')
	);
}
$arTemplateParameters['USE_SHARE'] = array(
	'PARENT' => 'KZNC_BUTTON_BLOCK',
	'NAME' => GetMessage('KZNC_USE_SHARE'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'Y',
	'REFRESH' => 'Y',
);
if (isset($arCurrentValues['USE_SHARE']) && 'Y' == $arCurrentValues['USE_SHARE']) {
	$arTemplateParameters['USE_SHARE_TEXT'] = array(
		'PARENT' => 'KZNC_BUTTON_BLOCK',
		'NAME' => GetMessage('KZNC_USE_SHARE_TEXT'),
		'TYPE' => 'STRING',
		'DEFAULT' => GetMessage('KZNC_USE_SHARE_TEXT_DEFAULT')
	);
}
$arTemplateParameters['USE_ONE_CLICK'] = array(
	'PARENT' => 'KZNC_BUTTON_BLOCK',
	'NAME' => GetMessage('KZNC_USE_ONE_CLICK'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'Y',
	'REFRESH' => 'Y',
);
if (isset($arCurrentValues['USE_ONE_CLICK']) && 'Y' == $arCurrentValues['USE_ONE_CLICK']) {
	$arTemplateParameters['USE_ONE_CLICK_TEXT'] = array(
		'PARENT' => 'KZNC_BUTTON_BLOCK',
		'NAME' => GetMessage('KZNC_USE_ONE_CLICK_TEXT'),
		'TYPE' => 'STRING',
		'DEFAULT' => GetMessage('KZNC_USE_ONE_CLICK_TEXT_DEFAULT')
	);
}

$detailPictMode = array(
	'IMG' => GetMessage('DETAIL_DETAIL_PICTURE_MODE_IMG'),
	'POPUP' => GetMessage('DETAIL_DETAIL_PICTURE_MODE_POPUP'),
	'ZOOM' => GetMessage('DETAIL_DETAIL_PICTURE_MODE_ZOOM'),
	'POPUP_ZOOM' => GetMessage('DETAIL_DETAIL_PICTURE_MODE_POPUP_ZOOM')
);


$arTemplateParameters['DETAIL_DETAIL_PICTURE_MODE'] = array(
	'PARENT' => 'SLIDER_SETTINGS',
	'NAME' => GetMessage('CP_BC_TPL_DETAIL_DETAIL_PICTURE_MODE'),
	'TYPE' => 'LIST',
	'DEFAULT' => 'IMG',
	'VALUES' => $detailPictMode
);

$arTemplateParameters['DETAIL_ADD_DETAIL_TO_SLIDER'] = array(
	'PARENT' => 'SLIDER_SETTINGS',
	'NAME' => GetMessage('CP_BC_TPL_DETAIL_ADD_DETAIL_TO_SLIDER'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'N'
);

$arTemplateParameters['DETAIL_ADD_DETAIL_TO_SLIDER_SKU'] = array(
	'PARENT' => 'SLIDER_SETTINGS',
	'NAME' => GetMessage('CP_BC_TPL_DETAIL_ADD_DETAIL_TO_SLIDER_SKU'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'Y',
	'REFRESH' => 'N'
);

$arTemplateParameters['ADDITIONAL_SKU_PIC_2_SLIDER'] = array(
    'PARENT' => 'SLIDER_SETTINGS',
    'NAME' => GetMessage('ADDITIONAL_SKU_PIC_2_SLIDER'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N'
);

$arTemplateParameters['FILTER_SKU_PHOTO'] = array(
        'PARENT' => 'SLIDER_SETTINGS',
        'NAME' => GetMessage('FILTER_SKU_PHOTO'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N'
);

$arTemplateParameters['FILTER_SKU_PHOTO_FLEX'] = array(
    'PARENT' => 'SLIDER_SETTINGS',
    'NAME' => GetMessage('FILTER_SKU_PHOTO_FLEX'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N'
);

$arTemplateParameters["SHOW_MAIN_INSTEAD_NF_SKU"] = array(
        "PARENT" => "SLIDER_SETTINGS",
        "NAME" => GetMessage('SHOW_MAIN_INSTEAD_NF_SKU'),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "N",
);

$arSyncing = array(
    "N" => GetMessage('SHOW_SLIDER_SYNCING_SELECT')["N"],
	"D" => GetMessage('SHOW_SLIDER_SYNCING_SELECT')["D"],
	"Y" => GetMessage('SHOW_SLIDER_SYNCING_SELECT')["Y"],
);

$arTemplateParameters["SHOW_SLIDER_SYNCING"] = array(
        "PARENT" => "SLIDER_SETTINGS",
        "NAME" => GetMessage('SHOW_SLIDER_SYNCING'),
        'TYPE' => 'LIST',
		'VALUES' => $arSyncing,
        "DEFAULT" => "D",
);

$arOffersViewModeList = array(
        'SELECT' => GetMessage('OFFERS_SELECT_VIEW'),
        'CHOISE' => GetMessage('OFFERS_CHOISE_VIEW'),
        'ICONS' => GetMessage('OFFERS_ICONS_VIEW')
);

$arTemplateParameters['OFFERS_VIEW'] = array(
        'PARENT' => 'OFFERS_SETTINGS',
        'NAME' => GetMessage('OFFERS_VIEW'),
        'TYPE' => 'LIST',
        'VALUES' => $arOffersViewModeList,
        'MULTIPLE' => 'N',
        'DEFAULT' => 'LIST',
	'REFRESH' => 'Y'
);

$skuPropsShowType = array(
    "square" => GetMessage('square'),
    "rounded" => GetMessage('rounded')
);

$arTemplateParameters["SKU_PROPS_SHOW_TYPE"] = array(
        "PARENT" => "OFFERS_SETTINGS",
        "NAME" => GetMessage("SKU_PROPS_SHOW_TYPE"),
        'TYPE' => 'LIST',
        'VALUES' => $skuPropsShowType,
        'DEFAULT' => "square",
);

$arTemplateParameters['CHANGE_TITLE_SKU'] = array(
        'PARENT' => 'OFFERS_SETTINGS',
        'NAME' => GetMessage('CHANGE_TITLE_SKU'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N',
);

$arTemplateParameters['HIDE_OFFERS_LIST'] = array(
	'PARENT' => 'OFFERS_SETTINGS',
	'NAME' => GetMessage('HIDE_OFFERS_LIST'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'N',
	'REFRESH' => 'Y'
);

$arTemplateParameters['SHOW_OFFER_PIC_BYCLICK'] = array(
        'PARENT' => 'OFFERS_SETTINGS',
        'NAME' => GetMessage('SHOW_OFFER_PIC_BYCLICK'),
        'TYPE' => 'CHECKBOX',
        'REFRESH' => 'N',
        'DEFAULT' => 'Y'
);

/*detail tabs*/
$arTemplateParameters["BXR_DETAIL_TAB_TYPE"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_TYPE_DESC"),
        "TYPE" => "LIST",
        "VALUES" => array(
                'tabs' => GetMessage('BXR_DETAIL_TAB_TYPE_TABS'),
                'list' => GetMessage('BXR_DETAIL_TAB_TYPE_LIST')
        ),
        'REFRESH'=>'Y'
);

if (isset($arCurrentValues['BXR_DETAIL_TAB_TYPE']) && 'tabs' == $arCurrentValues['BXR_DETAIL_TAB_TYPE']) {
    $arTemplateParameters["BXR_DETAIL_TAB_VIEW"] = array(
            "PARENT" => "DETAIL_TAB_SETTINGS",
            "NAME" => GetMessage("BXR_DETAIL_TAB_VIEW"),
            "TYPE" => "LIST",
            "VALUES" => array(
//                    'list' => GetMessage('BXR_DETAIL_TAB_TYPE_VIEW_LIST'),
                    'tabs' => GetMessage('BXR_DETAIL_TAB_TYPE_VIEW_TABS'),
                    'links' => GetMessage('BXR_DETAIL_TAB_TYPE_VIEW_LINKS')
            ),
            'REFRESH'=>'Y'
    );
}

if (isset($arCurrentValues['BXR_DETAIL_TAB_VIEW']) && 'tabs' == $arCurrentValues['BXR_DETAIL_TAB_VIEW']) {
    $arTemplateParameters["BXR_DETAIL_TAB_VIEW_TABS_COLOR"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_VIEW_TABS_COLOR"),
        "TYPE" => "LIST",
        "VALUES" => array(
            'color' => GetMessage('BXR_DETAIL_TAB_TYPE_VIEW_TABS_COLOR'),
            'light' => GetMessage('BXR_DETAIL_TAB_TYPE_VIEW_TABS_LIGHT')
        ),
        'REFRESH'=>'N'
    );
}

$arTemplateParameters["BXR_DETAIL_TAB_TEXT"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_TEXT_DESC"),
        "TYPE" => "LIST",
        "VALUES" => array(
                'tabs' => GetMessage('BXR_DETAIL_TAB_TEXT_TAB'),
                'detail' => GetMessage('BXR_DETAIL_TAB_TEXT_DETAIL')
        ),
        'REFRESH'=>'N'
);

$arTemplateParameters["BXR_DETAIL_TAB_TEXT_CAPTION"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_TEXT_CAPTION"),
        "TYPE" => "STRING",
        "DEFAULT" => GetMessage("BXR_DETAIL_TAB_TEXT_CAPTION_DEFAULT")
);

$arTemplateParameters["BXR_DETAIL_TAB_TEXT_GLYPH"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_GLYPH"),
        "TYPE" => "STRING",
        "DEFAULT" => ''
);

$arTemplateParameters["BXR_DETAIL_TAB_TEXT_LINK"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_SMART_LINK"),
        "TYPE" => "STRING",
        "DEFAULT" => GetMessage("BXR_DETAIL_TAB_TEXT_LINK_DEFAULT")
);

$arTemplateParameters["BXR_DETAIL_TAB_SKU"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_SKU"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y"
);

$arTemplateParameters["BXR_DETAIL_TAB_SKU_CAPTION"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_SKU_CAPTION"),
        "TYPE" => "STRING",
        "DEFAULT" => GetMessage("BXR_DETAIL_TAB_SKU_CAPTION_DEFAULT")
);

$arTemplateParameters["BXR_DETAIL_TAB_SKU_GLYPH"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_GLYPH"),
        "TYPE" => "STRING",
        "DEFAULT" => ''
);

$arTemplateParameters["BXR_DETAIL_TAB_SKU_LINK"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_SMART_LINK"),
        "TYPE" => "STRING",
        "DEFAULT" => GetMessage("BXR_DETAIL_TAB_SKU_LINK_DEFAULT")
);

$arTemplateParameters["BXR_DETAIL_TAB_SKU_SORT"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_SORT"),
        "TYPE" => "STRING",
        "DEFAULT" => '500'
);

$arTemplateParameters["BXR_DETAIL_TAB_PROPERTIES"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_PROPERTIES"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y"
);

$arTemplateParameters["BXR_DETAIL_TAB_PROPERTIES_CAPTION"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_PROPERTIES_CAPTION"),
        "TYPE" => "STRING",
        "DEFAULT" => GetMessage("BXR_DETAIL_TAB_PROPERTIES_CAPTION_DEFAULT")
);

$arTemplateParameters["BXR_DETAIL_TAB_PROPERTIES_GLYPH"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_GLYPH"),
        "TYPE" => "STRING",
        "DEFAULT" => ''
);

$arTemplateParameters["BXR_DETAIL_TAB_PROPERTIES_LINK"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_SMART_LINK"),
        "TYPE" => "STRING",
        "DEFAULT" => GetMessage("BXR_DETAIL_TAB_PROPERTIES_LINK_DEFAULT")
);

$arTemplateParameters["BXR_DETAIL_TAB_PROPERTIES_SORT"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_SORT"),
        "TYPE" => "STRING",
        "DEFAULT" => '500'
);

$arTemplateParameters["BXR_DETAIL_TAB_REVIEWS"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_REVIEWS"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y"
);

$arTemplateParameters["BXR_DETAIL_TAB_REVIEWS_CAPTION"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_REVIEWS_CAPTION"),
        "TYPE" => "STRING",
        "DEFAULT" => GetMessage("BXR_DETAIL_TAB_REVIEWS_CAPTION_DEFAULT")
);

$arTemplateParameters["BXR_DETAIL_TAB_REVIEWS_GLYPH"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_GLYPH"),
        "TYPE" => "STRING",
        "DEFAULT" => ''
);

$arTemplateParameters["BXR_DETAIL_TAB_REVIEWS_LINK"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_SMART_LINK"),
        "TYPE" => "STRING",
        "DEFAULT" => GetMessage("BXR_DETAIL_TAB_REVIEWS_LINK_DEFAULT")
);

$arTemplateParameters["BXR_DETAIL_TAB_REVIEWS_SORT"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_SORT"),
        "TYPE" => "STRING",
        "DEFAULT" => '500'
);

$arTemplateParameters["BXR_DETAIL_TAB_STORES"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_STORES"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y"
);

$arTemplateParameters["BXR_DETAIL_TAB_STORES_CAPTION"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_STORES_CAPTION"),
        "TYPE" => "STRING",
        "DEFAULT" => GetMessage("BXR_DETAIL_TAB_STORES_CAPTION_DEFAULT")
);

$arTemplateParameters["BXR_DETAIL_TAB_STORES_GLYPH"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_GLYPH"),
        "TYPE" => "STRING",
        "DEFAULT" => ''
);

$arTemplateParameters["BXR_DETAIL_TAB_STORES_LINK"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_SMART_LINK"),
        "TYPE" => "STRING",
        "DEFAULT" => GetMessage("BXR_DETAIL_TAB_STORES_LINK_DEFAULT")
);

$arTemplateParameters["BXR_DETAIL_TAB_STORES_SORT"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_SORT"),
        "TYPE" => "STRING",
        "DEFAULT" => '500'
);

$arTemplateParameters["BXR_DETAIL_TAB_SCHEMES"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_SCHEMES"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y"
);

$arTemplateParameters["BXR_DETAIL_TAB_SCHEMES_CAPTION"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_SCHEMES_CAPTION"),
        "TYPE" => "STRING",
        "DEFAULT" => GetMessage("BXR_DETAIL_TAB_SCHEMES_CAPTION_DEFAULT")
);

$arTemplateParameters["BXR_DETAIL_TAB_SCHEMES_GLYPH"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_GLYPH"),
        "TYPE" => "STRING",
        "DEFAULT" => ''
);

$arTemplateParameters["BXR_DETAIL_TAB_SCHEMES_LINK"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_SMART_LINK"),
        "TYPE" => "STRING",
        "DEFAULT" => GetMessage("BXR_DETAIL_TAB_SHEMES_LINK_DEFAULT")
);

$arTemplateParameters["BXR_DETAIL_TAB_SCHEMES_SORT"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_SORT"),
        "TYPE" => "STRING",
        "DEFAULT" => '500'
);

$arTemplateParameters["BXR_DETAIL_TAB_FILES"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_FILES"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y"
);

$arTemplateParameters["BXR_DETAIL_TAB_FILES_CAPTION"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_FILES_CAPTION"),
        "TYPE" => "STRING",
        "DEFAULT" => GetMessage("BXR_DETAIL_TAB_FILES_CAPTION_DEFAULT")
);

$arTemplateParameters["BXR_DETAIL_TAB_FILES_GLYPH"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_GLYPH"),
        "TYPE" => "STRING",
        "DEFAULT" => ''
);

$arTemplateParameters["BXR_DETAIL_TAB_FILES_LINK"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_SMART_LINK"),
        "TYPE" => "STRING",
        "DEFAULT" => GetMessage("BXR_DETAIL_TAB_FILES_LINK_DEFAULT")
);

$arTemplateParameters["BXR_DETAIL_TAB_FILES_SORT"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_SORT"),
        "TYPE" => "STRING",
        "DEFAULT" => '500'
);

$arTemplateParameters["BXR_DETAIL_TAB_VIDEO"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_VIDEO"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y"
);

$arTemplateParameters["BXR_DETAIL_TAB_VIDEO_MODE"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_VIDEO_MODE"),
        "TYPE" => "LIST",
        "VALUES" => array(
                'table' => GetMessage('BXR_DETAIL_TAB_VIDEO_MODE_TABLE'),
                'list' => GetMessage('BXR_DETAIL_TAB_VIDEO_MODE_LIST'),
                'fullsize' => GetMessage('BXR_DETAIL_TAB_VIDEO_MODE_FULLSIZE'),
                'table_iframe' => GetMessage('BXR_DETAIL_TAB_VIDEO_MODE_TABLE_IFRAME'),
                'list_iframe' => GetMessage('BXR_DETAIL_TAB_VIDEO_MODE_LIST_IFRAME'),
                'fullsize_iframe' => GetMessage('BXR_DETAIL_TAB_VIDEO_MODE_FULLSIZE_IFRAME'),
                'table_bitrix' => GetMessage('BXR_DETAIL_TAB_VIDEO_MODE_TABLE_BITRIX'),
                'list_bitrix' => GetMessage('BXR_DETAIL_TAB_VIDEO_MODE_LIST_BITRIX'),
                'fullsize_bitrix' => GetMessage('BXR_DETAIL_TAB_VIDEO_MODE_FULLSIZE_BITRIX'),
        ),
        "DEFAULT" => "table"
);

$arTemplateParameters["BXR_DETAIL_TAB_VIDEO_CAPTION"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_VIDEO_CAPTION"),
        "TYPE" => "STRING",
        "DEFAULT" => GetMessage("BXR_DETAIL_TAB_VIDEO_CAPTION_DEFAULT")
);

$arTemplateParameters["BXR_DETAIL_TAB_VIDEO_GLYPH"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_GLYPH"),
        "TYPE" => "STRING",
        "DEFAULT" => ''
);

$arTemplateParameters["BXR_DETAIL_TAB_VIDEO_LINK"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_SMART_LINK"),
        "TYPE" => "STRING",
        "DEFAULT" => GetMessage("BXR_DETAIL_TAB_VIDEO_LINK_DEFAULT")
);

$arTemplateParameters["BXR_DETAIL_TAB_VIDEO_SORT"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_SORT"),
        "TYPE" => "STRING",
        "DEFAULT" => '500'
);

$arTemplateParameters["BXR_DETAIL_TAB_INC"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_INC"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y"
);

$arTemplateParameters["BXR_DETAIL_TAB_INC_CAPTION"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_INC_CAPTION"),
        "TYPE" => "STRING",
        "DEFAULT" => GetMessage("BXR_DETAIL_TAB_INC_CAPTION_DEFAULT")
);

$arTemplateParameters["BXR_DETAIL_TAB_INC_GLYPH"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_GLYPH"),
        "TYPE" => "STRING",
        "DEFAULT" => ''
);

$arTemplateParameters["BXR_DETAIL_TAB_INC_LINK"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_SMART_LINK"),
        "TYPE" => "STRING",
        "DEFAULT" => GetMessage("BXR_DETAIL_TAB_INC_LINK_DEFAULT")
);

$arTemplateParameters["BXR_DETAIL_TAB_INC_URL"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_INC_URL"),
        "TYPE" => "STRING",
        "DEFAULT" => ""
);

$arTemplateParameters["BXR_DETAIL_TAB_INC_SORT"] = array(
        "PARENT" => "DETAIL_TAB_SETTINGS",
        "NAME" => GetMessage("BXR_DETAIL_TAB_SORT"),
        "TYPE" => "STRING",
        "DEFAULT" => '500'
);

//todo сформирвоать набор параметрова для таба коллекции BXR_DETAIL_TAB_COLLECTION_
$arTemplateParameters["BXR_DETAIL_TAB_COLLECTION_CAPTION"] = array(
	"PARENT" => "DETAIL_TAB_SETTINGS",
	"NAME" => GetMessage("BXR_DETAIL_TAB_COLLECTION_CAPTION"),
	"TYPE" => "STRING",
	"DEFAULT" => GetMessage("BXR_DETAIL_TAB_COLLECTION_CAPTION_DEFAULT"),
);

$arTemplateParameters["BXR_DETAIL_TAB_COLLECTION_LINK"] = array(
	"PARENT" => "DETAIL_TAB_SETTINGS",
	"NAME" => GetMessage("BXR_DETAIL_TAB_COLLECTION_LINK"),
	"TYPE" => "STRING",
	"DEFAULT" => GetMessage("BXR_DETAIL_TAB_COLLECTION_LINK_DEFAULT")
);

$arTemplateParameters["BXR_DETAIL_TAB_COLLECTION_GLYPH"] = array(
	"PARENT" => "DETAIL_TAB_SETTINGS",
	"NAME" => GetMessage("BXR_DETAIL_TAB_COLLECTION_GLYPH"),
	"TYPE" => "STRING",
	"DEFAULT" => ''
);

//$arTemplateParameters["BXR_DETAIL_TAB_GIFT"] = array(
//        "PARENT" => "DETAIL_TAB_SETTINGS",
//        "NAME" => GetMessage("BXR_DETAIL_TAB_GIFT"),
//        "TYPE" => "CHECKBOX",
//        "DEFAULT" => "Y"
//);
//
//$arTemplateParameters["BXR_DETAIL_TAB_GIFT_CAPTION"] = array(
//        "PARENT" => "DETAIL_TAB_SETTINGS",
//        "NAME" => GetMessage("BXR_DETAIL_TAB_GIFT_CAPTION"),
//        "TYPE" => "STRING",
//        "DEFAULT" => GetMessage("BXR_DETAIL_TAB_GIFT_CAPTION_DEFAULT")
//);
//
//$arTemplateParameters["BXR_DETAIL_TAB_GIFT_GLYPH"] = array(
//        "PARENT" => "DETAIL_TAB_SETTINGS",
//        "NAME" => GetMessage("BXR_DETAIL_TAB_GLYPH"),
//        "TYPE" => "STRING",
//        "DEFAULT" => ''
//);
//
//$arTemplateParameters["BXR_DETAIL_TAB_GIFT_LINK"] = array(
//        "PARENT" => "DETAIL_TAB_SETTINGS",
//        "NAME" => GetMessage("BXR_DETAIL_TAB_SMART_LINK"),
//        "TYPE" => "STRING",
//        "DEFAULT" => GetMessage("BXR_DETAIL_TAB_GIFT_LINK_DEFAULT")
//);
//
//$arTemplateParameters["BXR_DETAIL_TAB_GIFT_SORT"] = array(
//        "PARENT" => "DETAIL_TAB_SETTINGS",
//        "NAME" => GetMessage("BXR_DETAIL_TAB_SORT"),
//        "TYPE" => "STRING",
//        "DEFAULT" => '500'
//);
/*end tabs*/


$arTemplateParameters['SHOW_DISCOUNT_PERCENT'] = array(
        'PARENT' => 'PRICES',
        'NAME' => GetMessage('CP_BC_TPL_SHOW_DISCOUNT_PERCENT'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N'
);

$arTemplateParameters['SHOW_DISCOUNT_VALUE'] = array(
        'PARENT' => 'PRICES',
        'NAME' => GetMessage('SHOW_DISCOUNT_VALUE'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N'
);

$arTemplateParameters['SHOW_OLD_PRICE'] = array(
        'PARENT' => 'PRICES',
        'NAME' => GetMessage('CP_BC_TPL_SHOW_OLD_PRICE'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N',
);

$arTemplateParameters["SHOW_PRICE_NAME"] = array(
    "PARENT" => "PRICES",
    "NAME" => GetMessage("IBLOCK_SHOW_PRICE_NAME"),
    "TYPE" => "CHECKBOX",
    "DEFAULT" => "N",
);

$arPriceCountGroup = array(
    "count" => GetMessage("IBLOCK_GROUP_PRICE_COUNT_PRODUCTS"),
    "price" => GetMessage("IBLOCK_GROUP_PRICE_COUNT_TYPE"),
);

$arTemplateParameters["GROUP_PRICE_COUNT"] = array(
    "PARENT" => "PRICES",
    "NAME" => GetMessage("IBLOCK_GROUP_PRICE_COUNT"),
    "TYPE" => "LIST",
    "VALUES" => $arPriceCountGroup,
);

$arTemplateParameters['SHOW_MEASURE'] = array(
	'PARENT' => 'PRICES',
	'NAME' => GetMessage('KZNC_SHOW_MEASURE'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'N',
);

/* SORT_PANEL */

$arCatalogView = array("TITLE" => GetMessage("KZNC_VIEW_TITLE"), "LIST" => GetMessage("KZNC_VIEW_LIST"), "TABLE" => GetMessage("KZNC_VIEW_TABLE"));
$arPageCount = array(8 => 8, 16 => 16, 32 => 32);

$arSort = CIBlockParameters::GetElementSortFields(
	array('SHOWS', 'SORT', 'TIMESTAMP_X', 'NAME', 'ID', 'ACTIVE_FROM', 'ACTIVE_TO'),
	array('KEY_LOWERCASE' => 'Y')
);

if ($boolCatalog)
{
    $arSort = array_merge($arSort, CCatalogIBlockParameters::GetCatalogSortFields());
}

$arSort["PROPERTY_MINIMUM_PRICE"] = GetMessage("KZNC_SORT_PRICE_NAME");

$arThemes = array(
    "default" => GetMessage("KZNC_THEME_DEFAULT"), 
    "solid" => GetMessage("KZNC_THEME_SOLID"), 
);

$arProperty = array_merge($arProperty_LNS, $arSort);

if(is_array($arProperty_X)) {
    foreach ($arProperty_X as $k => $v) {
        $arProperty[str_replace("PROPERTY_", "PROPERTYSORT_", $k)] = $arProperty[$k] . " " . GetMessage("KZNC_PROPERTYSORT");
    }
}

$arCurrentSortFields = array();
foreach ($arCurrentValues["ELEMENT_SORT_FIELD"] as $val):
	if(array_key_exists($val, $arProperty))
		$arCurrentSortFields[$val] = $arProperty[$val];
endforeach;

//$arTemplateParameters["THEME"] = array(
//    "PARENT" => "SORT_PANEL_SETTINGS",
//    "NAME" => GetMessage("KZNC_THEME_NAME"),
//    "TYPE" => "LIST",
//    "VALUES" => $arThemes,
//    "MULTIPLE" => "N",
//    "DEFAULT" => "default",
//);

$arTemplateParameters["ELEMENT_SORT_FIELD"] = array(
    "PARENT" => "SORT_PANEL_SETTINGS",
    "NAME" => GetMessage("IBLOCK_ELEMENT_SORT_FIELD"),
    "TYPE" => "LIST",
    "VALUES" => $arProperty,
    "MULTIPLE" => "Y",
    "DEFAULT" => "sort",
    "REFRESH" => "Y",
    "SIZE" => 10,
);

$arTemplateParameters["CATALOG_DEFAULT_SORT"] = array(
    "PARENT" => "SORT_PANEL_SETTINGS",
    "NAME" => GetMessage("KZNC_CATALOG_DEFAULT_SORT"),
    "TYPE" => "LIST",
    "DEFAULT" => "sort",
    "VALUES" => $arCurrentSortFields,
);

$arTemplateParameters["CATALOG_DEFAULT_SORT_ORDER"] = array(
    "PARENT" => "SORT_PANEL_SETTINGS",
    "NAME" => GetMessage("KZNC_CATALOG_DEFAULT_SORT_ORDER"),
    "TYPE" => "LIST",
    "DEFAULT" => "desc",
    "VALUES" => array("asc" => GetMessage("KZNC_CATALOG_DEFAULT_SORT_ORDER_ASC"), "desc" => GetMessage("KZNC_CATALOG_DEFAULT_SORT_ORDER_DESC")),
);

$arTemplateParameters["PAGE_ELEMENT_COUNT_SHOW"] = array(
    "PARENT" => "SORT_PANEL_SETTINGS",
    "NAME" => GetMessage("KZNC_PAGE_ELEMENT_COUNT_SHOW"),
    "TYPE" => "CHECKBOX",
    "DEFAULT" => "Y",
    "REFRESH" => "Y",
);

$arTemplateParameters["PAGE_ELEMENT_COUNT"] = array(
    "PARENT" => "SORT_PANEL_SETTINGS",
    "NAME" => GetMessage("IBLOCK_PAGE_ELEMENT_COUNT"),
    "TYPE" => "STRING",
    "DEFAULT" => "16",
);

if($arCurrentValues["PAGE_ELEMENT_COUNT_SHOW"]=="Y") {
	
    $arTemplateParameters["PAGE_ELEMENT_COUNT_LIST"] = array(
        "PARENT" => "SORT_PANEL_SETTINGS",
        "NAME" => GetMessage("KZNC_PAGE_ELEMENT_COUNT_LIST"),
        "TYPE" => "LIST",
        "MULTIPLE" => "Y",
        "ADDITIONAL_VALUES" => "Y",
        "VALUES" => $arPageCount,
    );
}

$arTemplateParameters["CATALOG_VIEW_SHOW"] = array(
    "PARENT" => "SORT_PANEL_SETTINGS",
    "NAME" => GetMessage("KZNC_CATALOG_VIEW_SHOW"),
    "TYPE" => "CHECKBOX",
    "DEFAULT" => "Y",
    "REFRESH" => "Y",
);

if($arCurrentValues["CATALOG_VIEW_SHOW"]=="Y") {
    $arTemplateParameters["DEFAULT_CATALOG_VIEW"] = array(
        "PARENT" => "SORT_PANEL_SETTINGS",
        "NAME" => GetMessage("KZNC_DEFAULT_CATALOG_VIEW"),
        "TYPE" => "LIST",
        "VALUES" => $arCatalogView,
        "DEFAULT" => "TITLE",
    );
}

/*bestsaler block*/
$arShowType = array(
    "left" => GetMessage('SHOW_LEFT'),
    "bottom" => GetMessage('SHOW_BOTTOM')
);

if ($arCurrentValues['USE_SALE_BESTSELLERS'] == 'Y') {
	$arTemplateParameters["BESTSALLERS_WERE_SHOW"] = array(
	        "PARENT" => "ADDITIONAL_SETTINGS",
	        "NAME" => GetMessage("BESTSALLERS_WERE_SHOW"),
		'TYPE' => 'LIST',
	        'VALUES' => $arShowType,
	);
	
	$arTemplateParameters["BESTSALLERS_SORT"] = array(
	        "PARENT" => "ADDITIONAL_SETTINGS",
	        "NAME" => GetMessage("BESTSALLERS_SORT"),
		'TYPE' => 'STRING',
	        'DEFAULT' => 50
	);
	
	$arTemplateParameters["BESTSALLERS_TITLE"] = array(
	        "PARENT" => "ADDITIONAL_SETTINGS",
	        "NAME" => GetMessage("BESTSALLERS_TITLE"),
		'TYPE' => 'STRING',
	        'DEFAULT' => GetMessage('BESTSALLERS_TITLE_TEXT'),
	);
	
	$arTemplateParameters["BESTSALLERS_CNT"] = array(
	        "PARENT" => "ADDITIONAL_SETTINGS",
	        "NAME" => GetMessage("BESTSALLERS_CNT"),
		'TYPE' => 'STRING',
	        'DEFAULT' => 4,
	);
}	
/*viewed block*/
$arTemplateParameters["VIEWED_PRODUCTS_SHOW"] = array(
	"PARENT" => "ADDITIONAL_SETTINGS",
	"NAME" => GetMessage("VIEWED_PRODUCTS_SHOW"),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'Y',
	'REFRESH' => 'Y'
);

if ($arCurrentValues['VIEWED_PRODUCTS_SHOW'] == 'Y') {
	$arTemplateParameters["VIEWED_PRODUCTS_WERE_SHOW"] = array(
		"PARENT" => "ADDITIONAL_SETTINGS",
		"NAME" => GetMessage("VIEWED_PRODUCTS_WERE_SHOW"),
		'TYPE' => 'LIST',
		'VALUES' => $arShowType,
	);
	
	$arTemplateParameters["VIEWED_PRODUCTS_SORT"] = array(
		"PARENT" => "ADDITIONAL_SETTINGS",
		"NAME" => GetMessage("VIEWED_PRODUCTS_SORT"),
		'TYPE' => 'STRING',
		'DEFAULT' => 100
	);
	
	$arTemplateParameters["VIEWED_PRODUCTS_BLOCK_TITLE"] = array(
		"PARENT" => "ADDITIONAL_SETTINGS",
		"NAME" => GetMessage("VIEWED_PRODUCTS_BLOCK_TITLE"),
		'TYPE' => 'STRING',
		'DEFAULT' => GetMessage('VIEWED_PRODUCTS_BLOCK_TITLE_TEXT'),
	);
	
	$arTemplateParameters["VIEWED_PRODUCTS_CNT"] = array(
		"PARENT" => "ADDITIONAL_SETTINGS",
		"NAME" => GetMessage("VIEWED_PRODUCTS_CNT"),
		'TYPE' => 'STRING',
		'DEFAULT' => 4,
	);

	$arTemplateParameters["VIEWED_PRODUCTS_ONLY_PRODUCTS_CURRENT_SECTION"] = array(
		"PARENT" => "ADDITIONAL_SETTINGS",
		"NAME" => GetMessage("VIEWED_PRODUCTS_ONLY_PRODUCTS_CURRENT_SECTION"),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => "Y",
	);
}

/*show section desc*/
$arShowDescType = array(
    "none" => GetMessage("SHOW_NONE"),
    "top" => GetMessage("SHOW_TOP"),
    "bottom" => GetMessage("SHOW_BOTTOM"),
);

$arTemplateParameters["SHOW_SECTION_DESC"] = array(
        "PARENT" => "LIST_SETTINGS",
        "NAME" => GetMessage("SHOW_SECTION_DESC"),
	'TYPE' => 'LIST',
        'VALUES' => $arShowDescType,
);

$arTemplateParameters["SHOW_SECTION_SEO"] = array(
        "PARENT" => "LIST_SETTINGS",
        "NAME" => GetMessage("SHOW_SECTION_SEO"),
		'TYPE' => 'CHECKBOX',
);

include('params/.search.page.parameters.php');
include('params/.ext.parameters.php');


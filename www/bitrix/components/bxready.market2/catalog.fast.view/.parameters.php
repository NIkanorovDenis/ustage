<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arCurrentValues */
/** @global CUserTypeManager $USER_FIELD_MANAGER */
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;
use Bitrix\Iblock;
use Bitrix\Currency;
use Bitrix\Main\Web\Json;

global $USER_FIELD_MANAGER;

if (!Loader::includeModule('iblock') || !Loader::includeModule('alexkova.bxready2'))
	return;

$catalogIncluded = Loader::includeModule('catalog');
CBitrixComponent::includeComponentClass('bitrix:catalog.section');
$iblockExists = (!empty($arCurrentValues['IBLOCK_ID']) && (int)$arCurrentValues['IBLOCK_ID'] > 0);

$compatibleMode = !(isset($arCurrentValues['COMPATIBLE_MODE']) && $arCurrentValues['COMPATIBLE_MODE'] === 'N');

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

$arProperty = array();
$arProperty_N = array();
$arProperty_X = array();
$arProperty_F = array();
$arProperty_HL = array();
if ($iblockExists)
{
	$propertyIterator = Iblock\PropertyTable::getList(array(
		'select' => array('ID', 'IBLOCK_ID', 'NAME', 'CODE', 'PROPERTY_TYPE', 'MULTIPLE', 'LINK_IBLOCK_ID', 'USER_TYPE', 'SORT'),
		'filter' => array('=IBLOCK_ID' => $arCurrentValues['IBLOCK_ID'], '=ACTIVE' => 'Y'),
		'order' => array('SORT' => 'ASC', 'NAME' => 'ASC')
	));
	while ($property = $propertyIterator->fetch())
	{
		$propertyCode = (string)$property['CODE'];
		if ($propertyCode == '')
			$propertyCode = $property['ID'];
		$propertyName = '['.$propertyCode.'] '.$property['NAME'];

		if ($property['PROPERTY_TYPE'] != Iblock\PropertyTable::TYPE_FILE)
		{
			$arProperty[$propertyCode] = $propertyName;

			if ($property['MULTIPLE'] == 'Y')
				$arProperty_X[$propertyCode] = $propertyName;
			elseif ($property['PROPERTY_TYPE'] == Iblock\PropertyTable::TYPE_LIST)
				$arProperty_X[$propertyCode] = $propertyName;
			elseif ($property['PROPERTY_TYPE'] == Iblock\PropertyTable::TYPE_ELEMENT && (int)$property['LINK_IBLOCK_ID'] > 0)
				$arProperty_X[$propertyCode] = $propertyName;
		}
		else
		{
                        $arProperty_F[$propertyCode] = $propertyName;
		}

		if ($property['PROPERTY_TYPE'] == Iblock\PropertyTable::TYPE_NUMBER)
			$arProperty_N[$propertyCode] = $propertyName;

                if ($property['PROPERTY_TYPE'] == Iblock\PropertyTable::TYPE_STRING && 'directory' == $property['USER_TYPE'])
//                        && CIBlockPriceTools::checkPropDirectory($property))
			$arProperty_HL[$propertyCode] = $propertyName;
	}
	unset($propertyCode, $propertyName, $property, $propertyIterator);
}
$arProperty_LNS = $arProperty;

$arIBlock_LINK = array();
$iblockFilter = (
	!empty($arCurrentValues['LINK_IBLOCK_TYPE'])
	? array('TYPE' => $arCurrentValues['LINK_IBLOCK_TYPE'], 'ACTIVE' => 'Y')
	: array('ACTIVE' => 'Y')
);
$rsIblock = CIBlock::GetList(array('SORT' => 'ASC'), $iblockFilter);
while ($arr = $rsIblock->Fetch())
	$arIBlock_LINK[$arr['ID']] = '['.$arr['ID'].'] '.$arr['NAME'];
unset($iblockFilter);

$arProperty_LINK = array();
if (!empty($arCurrentValues['LINK_IBLOCK_ID']) && (int)$arCurrentValues['LINK_IBLOCK_ID'] > 0)
{
	$propertyIterator = Iblock\PropertyTable::getList(array(
		'select' => array('ID', 'IBLOCK_ID', 'NAME', 'CODE', 'PROPERTY_TYPE', 'MULTIPLE', 'LINK_IBLOCK_ID', 'USER_TYPE', 'SORT'),
		'filter' => array('=IBLOCK_ID' => $arCurrentValues['LINK_IBLOCK_ID'], '=PROPERTY_TYPE' => Iblock\PropertyTable::TYPE_ELEMENT, '=ACTIVE' => 'Y'),
		'order' => array('SORT' => 'ASC', 'NAME' => 'ASC')
	));
	while ($property = $propertyIterator->fetch())
	{
		$propertyCode = (string)$property['CODE'];
		if ($propertyCode == '')
			$propertyCode = $property['ID'];
		$arProperty_LINK[$propertyCode] = '['.$propertyCode.'] '.$property['NAME'];
	}
	unset($propertyCode, $property, $propertyIterator);
}

$arUserFields_S = array("-"=>" ");
$arUserFields_F = array("-"=>" ");
if ($iblockExists)
{
	$arUserFields = $USER_FIELD_MANAGER->GetUserFields('IBLOCK_'.$arCurrentValues['IBLOCK_ID'].'_SECTION', 0, LANGUAGE_ID);
	foreach ($arUserFields as $FIELD_NAME => $arUserField)
	{
		$arUserField['LIST_COLUMN_LABEL'] = (string)$arUserField['LIST_COLUMN_LABEL'];
		$arProperty_UF[$FIELD_NAME] = $arUserField['LIST_COLUMN_LABEL'] ? '['.$FIELD_NAME.']'.$arUserField['LIST_COLUMN_LABEL'] : $FIELD_NAME;
		if ($arUserField["USER_TYPE"]["BASE_TYPE"] == "string")
			$arUserFields_S[$FIELD_NAME] = $arProperty_UF[$FIELD_NAME];
		if ($arUserField["USER_TYPE"]["BASE_TYPE"] == "file" && $arUserField['MULTIPLE'] == 'N')
			$arUserFields_F[$FIELD_NAME] = $arProperty_UF[$FIELD_NAME];
	}
	unset($arUserFields);
}

$offers = false;
$arProperty_Offers = array();
$arProperty_OffersWithoutFile = array();
$arProperty_OffersFile = array();
$arProperty_OffersTree = array();
if ($catalogIncluded && $iblockExists)
{
	$offers = CCatalogSku::GetInfoByProductIBlock($arCurrentValues['IBLOCK_ID']);
	if (!empty($offers))
	{
		$propertyIterator = Iblock\PropertyTable::getList(array(
			'select' => array('ID', 'IBLOCK_ID', 'NAME', 'CODE', 'PROPERTY_TYPE', 'MULTIPLE', 'LINK_IBLOCK_ID', 'USER_TYPE', 'SORT'),
			'filter' => array('=IBLOCK_ID' => $offers['IBLOCK_ID'], '=ACTIVE' => 'Y', '!=ID' => $offers['SKU_PROPERTY_ID']),
			'order' => array('SORT' => 'ASC', 'NAME' => 'ASC')
		));
		while ($property = $propertyIterator->fetch())
		{
			$propertyCode = (string)$property['CODE'];
			if ($propertyCode == '')
				$propertyCode = $property['ID'];
			$propertyName = '['.$propertyCode.'] '.$property['NAME'];

			$arProperty_Offers[$propertyCode] = $propertyName;
			if ($property['PROPERTY_TYPE'] != Iblock\PropertyTable::TYPE_FILE)
				$arProperty_OffersWithoutFile[$propertyCode] = $propertyName;

                        if ($property['PROPERTY_TYPE'] == Iblock\PropertyTable::TYPE_FILE)
				$arProperty_OffersFile[$propertyCode] = $propertyName;
			if (
				$property['PROPERTY_TYPE'] == Iblock\PropertyTable::TYPE_LIST
				|| $property['PROPERTY_TYPE'] == Iblock\PropertyTable::TYPE_ELEMENT
				|| ($property['PROPERTY_TYPE'] == Iblock\PropertyTable::TYPE_STRING && 'directory' == $property['USER_TYPE'])
//                                        && CIBlockPriceTools::checkPropDirectory($property))
//                                || ($property['PROPERTY_TYPE'] == 'S' && 'directory' == $property['USER_TYPE'] && CIBlockPriceTools::checkPropDirectory($property))
			)
				$arProperty_OffersTree[$propertyCode] = $propertyName;

		}
		unset($propertyCode, $propertyName, $property, $propertyIterator);
	}
}

$arSort = CIBlockParameters::GetElementSortFields(
	array('SHOWS', 'SORT', 'TIMESTAMP_X', 'NAME', 'ID', 'ACTIVE_FROM', 'ACTIVE_TO'),
	array('KEY_LOWERCASE' => 'Y')
);

$arPrice = array();
if ($catalogIncluded)
{
	$arSort = array_merge($arSort, CCatalogIBlockParameters::GetCatalogSortFields());
	if (isset($arSort['CATALOG_AVAILABLE']))
		unset($arSort['CATALOG_AVAILABLE']);
	$arPrice = CCatalogIBlockParameters::getPriceTypesList();
}
else
{
	$arPrice = $arProperty_N;
}

$arAscDesc = array(
	"asc" => GetMessage("IBLOCK_SORT_ASC"),
	"desc" => GetMessage("IBLOCK_SORT_DESC"),
);

$arPriceCountGroup = array(
    "count" => GetMessage("IBLOCK_GROUP_PRICE_COUNT_PRODUCTS"),
    "price" => GetMessage("IBLOCK_GROUP_PRICE_COUNT_TYPE"),
);

$detailPictMode = array(
        'IMG' => GetMessage('DETAIL_DETAIL_PICTURE_MODE_IMG'),
//        'POPUP' => GetMessage('DETAIL_DETAIL_PICTURE_MODE_POPUP'),
        'ZOOM' => GetMessage('DETAIL_DETAIL_PICTURE_MODE_ZOOM'),
//        'POPUP_ZOOM' => GetMessage('DETAIL_DETAIL_PICTURE_MODE_POPUP_ZOOM')
);

$arComponentParameters = array(
	"GROUPS" => array(
//		"ACTION_SETTINGS" => array(
//			"NAME" => GetMessage('IBLOCK_ACTIONS')
//		),
		"COMPARE_SETTINGS" => array(
			"NAME" => GetMessage("T_IBLOCK_DESC_COMPARE_SETTINGS_EXT"),
		),
		"PRICES" => array(
			"NAME" => GetMessage("IBLOCK_PRICES"),
		),
		"BASKET" => array(
			"NAME" => GetMessage("IBLOCK_BASKET"),
		),
		"DETAIL_SETTINGS" => array(
			"NAME" => GetMessage("T_IBLOCK_DESC_DETAIL_SETTINGS"),
		),
                "SLIDER_SETTINGS" => array(
                    "NAME" => GetMessage("T_IBLOCK_DESC_SLIDER_SETTINGS"),
		),
		"KZNC_BUTTON_BLOCK" => array(
			"NAME" => GetMessage("KZNC_BUTTON_BLOCK"),
		),
		"OFFERS_SETTINGS" => array(
			"NAME" => GetMessage("CP_BC_OFFERS_SETTINGS"),
		),
//		"EXTENDED_SETTINGS" => array(
//			"NAME" => GetMessage("IBLOCK_EXTENDED_SETTINGS"),
//			"SORT" => 10000
//		),
	),
	"PARAMETERS" => array(
//		"VARIABLE_ALIASES" => array(
//			"ELEMENT_ID" => array(
//				"NAME" => GetMessage("CP_BC_VARIABLE_ALIASES_ELEMENT_ID"),
//			),
//			"SECTION_ID" => array(
//				"NAME" => GetMessage("CP_BC_VARIABLE_ALIASES_SECTION_ID"),
//			),
//
//		),
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
//                "ELEMENT_ID" => array(
//			"PARENT" => "BASE",
//			"NAME" => GetMessage("ELEMENT_ID"),
//			"TYPE" => "STRING",
//			"REFRESH" => "N",
//		),
//                "ELEMENT_CODE" => array(
//			"PARENT" => "BASE",
//			"NAME" => GetMessage("ELEMENT_CODE"),
//			"TYPE" => "STRING",
//			"REFRESH" => "N",
//		),
//                "OFFER_ID" => array(
//			"PARENT" => "BASE",
//			"NAME" => GetMessage("OFFER_ID"),
//			"TYPE" => "STRING",
//			"REFRESH" => "N",
//		),
//                "SECTION_ID" => array(
//			"PARENT" => "BASE",
//			"NAME" => GetMessage("SECTION_ID"),
//			"TYPE" => "STRING",
//			"REFRESH" => "N",
//		),
//                "SECTION_CODE" => array(
//			"PARENT" => "BASE",
//			"NAME" => GetMessage("SECTION_CODE"),
//			"TYPE" => "STRING",
//			"REFRESH" => "N",
//		),
//                "DETAIL_PAGE_URL" => array(
//			"PARENT" => "BASE",
//			"NAME" => GetMessage("DETAIL_PAGE_URL"),
//			"TYPE" => "STRING",
//			"REFRESH" => "N",
//		),
		"USE_COMPARE" => array(
			"PARENT" => "COMPARE_SETTINGS",
			"NAME" => GetMessage("T_IBLOCK_DESC_USE_COMPARE_EXT"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"REFRESH" => "Y",
		),
		"PROPERTY_CODE" => array(
			"PARENT" => "DETAIL_SETTINGS",
			"NAME" => GetMessage("IBLOCK_PROPERTY"),
			"TYPE" => "LIST",
			"MULTIPLE" => "Y",
			"ADDITIONAL_VALUES" => "Y",
			"VALUES" => $arProperty_LNS,
		),
		"SECTION_ID_VARIABLE" => array(
			"PARENT" => "DETAIL_SETTINGS",
			"NAME" => GetMessage("IBLOCK_SECTION_ID_VARIABLE"),
			"TYPE" => "STRING",
			"DEFAULT" => "SECTION_ID"
		),
		"CHECK_SECTION_ID_VARIABLE" => array(
			"PARENT" => "DETAIL_SETTINGS",
			"NAME" => GetMessage("CP_BC_DETAIL_CHECK_SECTION_ID_VARIABLE"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N"
		),

		"SHOW_DEACTIVATED" => array(
			"PARENT" => "DETAIL_SETTINGS",
			"NAME" => GetMessage('CP_BC_SHOW_DEACTIVATED'),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N"
		),
                'USE_VOTE_RATING' => array(
                        'PARENT' => 'DETAIL_SETTINGS',
                        'NAME' => GetMessage('CP_BC_TPL_DETAIL_USE_VOTE_RATING'),
                        'TYPE' => 'CHECKBOX',
                        'DEFAULT' => 'N',
                        'REFRESH' => 'Y'
                ),
                'DETAIL_ANOUNCE_BLOCKS_ORDER' => array(
                        'PARENT' => 'DETAIL_SETTINGS',
                        'NAME' => GetMessage('DETAIL_ANOUNCE_BLOCKS_ORDER'),
                        'TYPE' => 'CUSTOM',
                        'JS_FILE' => CatalogSectionComponent::getSettingsScript('/bitrix/components/bitrix/catalog.element', 'dragdrop_order'),
                        'JS_EVENT' => 'initDraggableOrderControl',
                        'JS_DATA' => Json::encode(array(
//                                'name' => GetMessage('NAME_BLOCK_ORDER'),
                                'rating' => GetMessage('RATING_BLOCK_ORDER'),
                                'article' => GetMessage('ARTICLE_BLOCK_ORDER'),
                                'preview_text' => GetMessage('PREVIEW_TEXT_BLOCK_ORDER'),
                                'preview_props' => GetMessage('PREVIEW_PROPS_BLOCK_ORDER'),
                        )),
                        'DEFAULT' => 'rating,preview_text,preview_props'
                ),
                'DETAIL_BUY_BLOCKS_ORDER' => array(
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
                                'avail_detail' => GetMessage('AVAIL_DETAIL_BLOCK_ORDER'),
                                'buy_one_click' => GetMessage('BUY_ONE_CLICK_BLOCK_ORDER'),
                                'share' => GetMessage('SHARE_BLOCK_ORDER')
                        )),
                        'DEFAULT' => 'price,avail,sku,buy,share'
                ),
                "PREVIEW_DETAIL_PROPERTY_CODE" => array(
                        "PARENT" => "DETAIL_SETTINGS",
                        "NAME" => GetMessage("PREVIEW_DETAIL_PROPERTY_CODE"),
                        "TYPE" => "LIST",
                        "MULTIPLE" => "Y",
                        "ADDITIONAL_VALUES" => "Y",
                        "VALUES" => $arProperty,
                ),
                'DETAIL_PICTURE_MODE' => array(
                        'PARENT' => 'SLIDER_SETTINGS',
                        'NAME' => GetMessage('CP_BC_TPL_DETAIL_DETAIL_PICTURE_MODE'),
                        'TYPE' => 'LIST',
                        'DEFAULT' => 'IMG',
                        'VALUES' => $detailPictMode
                ),
                'ADD_DETAIL_TO_SLIDER' => array(
                        'PARENT' => 'SLIDER_SETTINGS',
                        'NAME' => GetMessage('CP_BC_TPL_DETAIL_ADD_DETAIL_TO_SLIDER'),
                        'TYPE' => 'CHECKBOX',
                        'DEFAULT' => 'N'
                ),
                'ADD_DETAIL_TO_SLIDER_SKU' => array(
                        'PARENT' => 'SLIDER_SETTINGS',
                        'NAME' => GetMessage('CP_BC_TPL_DETAIL_ADD_DETAIL_TO_SLIDER_SKU'),
                        'TYPE' => 'CHECKBOX',
                        'DEFAULT' => 'Y',
                        'REFRESH' => 'N'
                ),
                'ADDITIONAL_SKU_PIC_2_SLIDER' => array(
                    'PARENT' => 'SLIDER_SETTINGS',
                    'NAME' => GetMessage('ADDITIONAL_SKU_PIC_2_SLIDER'),
                    'TYPE' => 'CHECKBOX',
                    'DEFAULT' => 'N'
                ),
                'FILTER_SKU_PHOTO' => array(
                        'PARENT' => 'SLIDER_SETTINGS',
                        'NAME' => GetMessage('FILTER_SKU_PHOTO'),
                        'TYPE' => 'CHECKBOX',
                        'DEFAULT' => 'N'
                ),
                'FILTER_SKU_PHOTO_FLEX' => array(
                    'PARENT' => 'SLIDER_SETTINGS',
                    'NAME' => GetMessage('FILTER_SKU_PHOTO_FLEX'),
                    'TYPE' => 'CHECKBOX',
                    'DEFAULT' => 'N'
                ),
                "SHOW_MAIN_INSTEAD_NF_SKU" => array(
                        "PARENT" => "SLIDER_SETTINGS",
                        "NAME" => GetMessage('SHOW_MAIN_INSTEAD_NF_SKU'),
                        "TYPE" => "CHECKBOX",
                        "DEFAULT" => "N",
                ),
                'MESS_BTN_FAST_VIEW' => array(
                        'PARENT' => 'VISUAL',
                        'NAME' => GetMessage('MESS_BTN_FAST_VIEW'),
                        'TYPE' => 'STRING',
                        'DEFAULT' => GetMessage('FAST_VIEW_BTN_TEXT')
                ),
//                'FORM_TITLE_TEXT' => array(
//                        'PARENT' => 'VISUAL',
//                        'NAME' => GetMessage('FORM_TITLE_TEXT'),
//                        'TYPE' => 'STRING',
//                        'DEFAULT' => GetMessage('FORM_TITLE_TEXT_DEFAULT')
//                ),
                'MESS_MORE_DETAIL_INFO' => array(
                        'PARENT' => 'VISUAL',
                        'NAME' => GetMessage('MESS_MORE_DETAIL_INFO'),
                        'TYPE' => 'STRING',
                        'DEFAULT' => GetMessage('MORE_DETAIL_INFO_TEXT')
                ),
                "ADD_PICT_PROP" => array(
                        "PARENT" => "VISUAL",
                        "NAME" => GetMessage('CP_BC_TPL_ADD_PICT_PROP'),
                        "TYPE" => "LIST",
                        "MULTIPLE" => "N",
                        "ADDITIONAL_VALUES" => "N",
                        "REFRESH" => "N",
                        "DEFAULT" => "-",
                        "VALUES" => $arProperty_F
                ),
//                'MESS_BTN_BUY' => array(
//                        'PARENT' => 'VISUAL',
//                        'NAME' => GetMessage('CP_BC_TPL_MESS_BTN_BUY'),
//                        'TYPE' => 'STRING',
//                        'DEFAULT' => GetMessage('CP_BC_TPL_MESS_BTN_BUY_DEFAULT')
//                ),
                'MESS_BTN_ADD_TO_BASKET' => array(
                        'PARENT' => 'VISUAL',
                        'NAME' => GetMessage('CP_BC_TPL_MESS_BTN_ADD_TO_BASKET'),
                        'TYPE' => 'STRING',
                        'DEFAULT' => GetMessage('CP_BC_TPL_MESS_BTN_ADD_TO_BASKET_DEFAULT')
                ),
                'MESS_BTN_COMPARE' => array(
                        'PARENT' => 'VISUAL',
                        'NAME' => GetMessage('CP_BC_TPL_MESS_BTN_COMPARE'),
                        'TYPE' => 'STRING',
                        'DEFAULT' => GetMessage('CP_BC_TPL_MESS_BTN_COMPARE_DEFAULT')
                ),
//                'MESS_BTN_DETAIL' => array(
//                        'PARENT' => 'VISUAL',
//                        'NAME' => GetMessage('CP_BC_TPL_MESS_BTN_DETAIL'),
//                        'TYPE' => 'STRING',
//                        'DEFAULT' => GetMessage('CP_BC_TPL_MESS_BTN_DETAIL_DEFAULT')
//                ),
//                'MESS_NOT_AVAILABLE' => array(
//                        'PARENT' => 'VISUAL',
//                        'NAME' => GetMessage('CP_BC_TPL_MESS_NOT_AVAILABLE'),
//                        'TYPE' => 'STRING',
//                        'DEFAULT' => GetMessage('CP_BC_TPL_MESS_NOT_AVAILABLE_DEFAULT')
//                ),
//                'MESS_BTN_SUBSCRIBE' => array(
//                        'PARENT' => 'VISUAL',
//                        'NAME' => GetMessage('CP_BC_TPL_MESS_BTN_SUBSCRIBE'),
//                        'TYPE' => 'STRING',
//                        'DEFAULT' => GetMessage('CP_BC_TPL_MESS_BTN_SUBSCRIBE_DEFAULT')
//                ),
		"CACHE_TIME"  =>  array("DEFAULT"=>36000000),
		"CACHE_GROUPS" => array(
			"PARENT" => "CACHE_SETTINGS",
			"NAME" => GetMessage("CP_BC_CACHE_GROUPS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
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
			"REFRESH" => isset($templateProperties['USE_RATIO_IN_RANGES']) ? "Y" : "N",
			"DEFAULT" => "N",
		),
		"SHOW_PRICE_COUNT" => array(
			"PARENT" => "PRICES",
			"NAME" => GetMessage("IBLOCK_SHOW_PRICE_COUNT"),
			"TYPE" => "STRING",
			"DEFAULT" => "1"
		),
		"PRICE_VAT_INCLUDE" => array(
			"PARENT" => "PRICES",
			"NAME" => GetMessage("IBLOCK_VAT_INCLUDE"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"PRICE_VAT_SHOW_VALUE" => array(
			"PARENT" => "PRICES",
			"NAME" => GetMessage("IBLOCK_VAT_SHOW_VALUE"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
                'SHOW_DISCOUNT_PERCENT' => array(
                    'PARENT' => 'PRICES',
                    'NAME' => GetMessage('CP_BC_TPL_SHOW_DISCOUNT_PERCENT'),
                    'TYPE' => 'CHECKBOX',
                    'DEFAULT' => 'N'
                ),
                'SHOW_DISCOUNT_VALUE' => array(
                        'PARENT' => 'PRICES',
                        'NAME' => GetMessage('SHOW_DISCOUNT_VALUE'),
                        'TYPE' => 'CHECKBOX',
                        'DEFAULT' => 'N'
                ),
                'SHOW_OLD_PRICE' => array(
                        'PARENT' => 'PRICES',
                        'NAME' => GetMessage('CP_BC_TPL_SHOW_OLD_PRICE'),
                        'TYPE' => 'CHECKBOX',
                        'DEFAULT' => 'N',
                ),

                "SHOW_PRICE_NAME" => array(
                    "PARENT" => "PRICES",
                    "NAME" => GetMessage("IBLOCK_SHOW_PRICE_NAME"),
                    "TYPE" => "CHECKBOX",
                    "DEFAULT" => "N",
                ),

                "GROUP_PRICE_COUNT" => array(
                    "PARENT" => "PRICES",
                    "NAME" => GetMessage("IBLOCK_GROUP_PRICE_COUNT"),
                    "TYPE" => "LIST",
                    "VALUES" => $arPriceCountGroup,
                ),
                'SHOW_MEASURE' => array(
                        'PARENT' => 'PRICES',
                        'NAME' => GetMessage('KZNC_SHOW_MEASURE'),
                        'TYPE' => 'CHECKBOX',
                        'DEFAULT' => 'N',
                ),
                'USE_FAVORITES' => array(
                        'PARENT' => 'KZNC_BUTTON_BLOCK',
                        'NAME' => GetMessage('KZNC_USE_FAVORITES'),
                        'TYPE' => 'CHECKBOX',
                        'DEFAULT' => 'Y',
                        'REFRESH' => 'Y',
                ),
                'USE_SHARE' => array(
                        'PARENT' => 'KZNC_BUTTON_BLOCK',
                        'NAME' => GetMessage('KZNC_USE_SHARE'),
                        'TYPE' => 'CHECKBOX',
                        'DEFAULT' => 'Y',
                        'REFRESH' => 'Y',
                ),
                'USE_ONE_CLICK' => array(
                        'PARENT' => 'KZNC_BUTTON_BLOCK',
                        'NAME' => GetMessage('KZNC_USE_ONE_CLICK'),
                        'TYPE' => 'CHECKBOX',
                        'DEFAULT' => 'Y',
                        'REFRESH' => 'Y',
                ),
//		"BASKET_URL" => array(
//			"PARENT" => "BASKET",
//			"NAME" => GetMessage("IBLOCK_BASKET_URL"),
//			"TYPE" => "STRING",
//			"DEFAULT" => "/personal/basket.php",
//		),
//		"ACTION_VARIABLE" => array(
//			"PARENT" => "ACTION_SETTINGS",
//			"NAME"		=> GetMessage("IBLOCK_ACTION_VARIABLE"),
//			"TYPE"		=> "STRING",
//			"DEFAULT"	=> "action"
//		),
//		"PRODUCT_ID_VARIABLE" => array(
//			"PARENT" => "ACTION_SETTINGS",
//			"NAME"		=> GetMessage("IBLOCK_PRODUCT_ID_VARIABLE"),
//			"TYPE"		=> "STRING",
//			"DEFAULT"	=> "id"
//		),
//		"USE_PRODUCT_QUANTITY" => array(
//			"PARENT" => "BASKET",
//			"NAME" => GetMessage("CP_BC_USE_PRODUCT_QUANTITY"),
//			"TYPE" => "CHECKBOX",
//			"DEFAULT" => "N",
//			"REFRESH" => "Y",
//		),
//		"PRODUCT_QUANTITY_VARIABLE" => array(
//			"PARENT" => "BASKET",
//			"NAME" => GetMessage("CP_BC_PRODUCT_QUANTITY_VARIABLE"),
//			"TYPE" => "STRING",
//			"DEFAULT" => "quantity",
//			"HIDDEN" => (isset($arCurrentValues['USE_PRODUCT_QUANTITY']) && $arCurrentValues['USE_PRODUCT_QUANTITY'] == 'Y' ? 'N' : 'Y')
//		),
//		"ADD_PROPERTIES_TO_BASKET" => array(
//			"PARENT" => "BASKET",
//			"NAME" => GetMessage("CP_BC_ADD_PROPERTIES_TO_BASKET"),
//			"TYPE" => "CHECKBOX",
//			"DEFAULT" => "Y",
//			"REFRESH" => "Y"
//		),
//		"PRODUCT_PROPS_VARIABLE" => array(
//			"PARENT" => "BASKET",
//			"NAME" => GetMessage("CP_BC_PRODUCT_PROPS_VARIABLE"),
//			"TYPE" => "STRING",
//			"DEFAULT" => "prop",
//			"HIDDEN" => (isset($arCurrentValues['ADD_PROPERTIES_TO_BASKET']) && $arCurrentValues['ADD_PROPERTIES_TO_BASKET'] == 'N' ? 'Y' : 'N')
//		),
//		"PARTIAL_PRODUCT_PROPERTIES" => array(
//			"PARENT" => "BASKET",
//			"NAME" => GetMessage("CP_BC_PARTIAL_PRODUCT_PROPERTIES"),
//			"TYPE" => "CHECKBOX",
//			"DEFAULT" => "N",
//			"HIDDEN" => (isset($arCurrentValues['ADD_PROPERTIES_TO_BASKET']) && $arCurrentValues['ADD_PROPERTIES_TO_BASKET'] == 'N' ? 'Y' : 'N')
//		),
//		"PRODUCT_PROPERTIES" => array(
//			"PARENT" => "BASKET",
//			"NAME" => GetMessage("CP_BC_PRODUCT_PROPERTIES"),
//			"TYPE" => "LIST",
//			"MULTIPLE" => "Y",
//			"VALUES" => $arProperty_X,
//			"HIDDEN" => (isset($arCurrentValues['ADD_PROPERTIES_TO_BASKET']) && $arCurrentValues['ADD_PROPERTIES_TO_BASKET'] == 'N' ? 'Y' : 'N')
//		),
//		'COMPATIBLE_MODE' => array(
//			'PARENT' => 'EXTENDED_SETTINGS',
//			'NAME' => GetMessage('CP_BC_COMPATIBLE_MODE'),
//			'TYPE' => 'CHECKBOX',
//			'DEFAULT' => 'Y',
//			'REFRESH' => 'Y'
//		),
//		"USE_ELEMENT_COUNTER" => array(
//			"PARENT" => "EXTENDED_SETTINGS",
//			"NAME" => GetMessage('CP_BC_USE_ELEMENT_COUNTER'),
//			"TYPE" => "CHECKBOX",
//			"DEFAULT" => "Y"
//		),
	),
);

if(isset($arCurrentValues["USE_COMPARE"]) && $arCurrentValues["USE_COMPARE"]=="Y")
{
	$arComponentParameters["PARAMETERS"]["COMPARE_NAME"] = array(
		"PARENT" => "COMPARE_SETTINGS",
		"NAME" => GetMessage("IBLOCK_COMPARE_NAME"),
		"TYPE" => "STRING",
		"DEFAULT" => "CATALOG_COMPARE_LIST"
	);
	$arComponentParameters["PARAMETERS"]["COMPARE_FIELD_CODE"] = CIBlockParameters::GetFieldCode(GetMessage("IBLOCK_FIELD"), "COMPARE_SETTINGS");
	$arComponentParameters["PARAMETERS"]["COMPARE_PROPERTY_CODE"] = array(
		"PARENT" => "COMPARE_SETTINGS",
		"NAME" => GetMessage("IBLOCK_PROPERTY"),
		"TYPE" => "LIST",
		"MULTIPLE" => "Y",
		"VALUES" => $arProperty_LNS,
		"ADDITIONAL_VALUES" => "Y",
	);
	if(!empty($offers))
	{
		$arComponentParameters["PARAMETERS"]["COMPARE_OFFERS_FIELD_CODE"] = CIBlockParameters::GetFieldCode(GetMessage("CP_BC_COMPARE_OFFERS_FIELD_CODE"), "COMPARE_SETTINGS");
		$arComponentParameters["PARAMETERS"]["COMPARE_OFFERS_PROPERTY_CODE"] = array(
			"PARENT" => "COMPARE_SETTINGS",
			"NAME" => GetMessage("CP_BC_COMPARE_OFFERS_PROPERTY_CODE"),
			"TYPE" => "LIST",
			"MULTIPLE" => "Y",
			"VALUES" => $arProperty_OffersWithoutFile,
			"ADDITIONAL_VALUES" => "Y",
		);
	}
	$arComponentParameters["PARAMETERS"]["COMPARE_ELEMENT_SORT_FIELD"] = array(
		"PARENT" => "COMPARE_SETTINGS",
		"NAME" => GetMessage("CP_BC_COMPARE_ELEMENT_SORT_FIELD"),
		"TYPE" => "LIST",
		"VALUES" => $arSort,
		"ADDITIONAL_VALUES" => "Y",
		"DEFAULT" => "sort",
	);
	$arComponentParameters["PARAMETERS"]["COMPARE_ELEMENT_SORT_ORDER"] = array(
		"PARENT" => "COMPARE_SETTINGS",
		"NAME" => GetMessage("CP_BC_COMPARE_ELEMENT_SORT_ORDER"),
		"TYPE" => "LIST",
		"VALUES" => $arAscDesc,
		"DEFAULT" => "asc",
		"ADDITIONAL_VALUES" => "Y",
	);
	if ($compatibleMode)
	{
		$arComponentParameters["PARAMETERS"]["DISPLAY_ELEMENT_SELECT_BOX"] = array(
			"PARENT" => "COMPARE_SETTINGS",
			"NAME" => GetMessage("T_IBLOCK_DESC_ELEMENT_BOX"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"REFRESH" => "Y",
		);
		if (isset($arCurrentValues["DISPLAY_ELEMENT_SELECT_BOX"]) && $arCurrentValues["DISPLAY_ELEMENT_SELECT_BOX"] == "Y")
		{
			$arComponentParameters["PARAMETERS"]["ELEMENT_SORT_FIELD_BOX"] = array(
				"PARENT" => "COMPARE_SETTINGS",
				"NAME" => GetMessage("IBLOCK_ELEMENT_SORT_FIELD_BOX"),
				"TYPE" => "LIST",
				"VALUES" => $arSort,
				"ADDITIONAL_VALUES" => "Y",
				"DEFAULT" => "name",
			);
			$arComponentParameters["PARAMETERS"]["ELEMENT_SORT_ORDER_BOX"] = array(
				"PARENT" => "COMPARE_SETTINGS",
				"NAME" => GetMessage("IBLOCK_ELEMENT_SORT_ORDER_BOX"),
				"TYPE" => "LIST",
				"VALUES" => $arAscDesc,
				"DEFAULT" => "asc",
				"ADDITIONAL_VALUES" => "Y",
			);
			$arComponentParameters["PARAMETERS"]["ELEMENT_SORT_FIELD_BOX2"] = array(
				"PARENT" => "COMPARE_SETTINGS",
				"NAME" => GetMessage("IBLOCK_ELEMENT_SORT_FIELD_BOX2"),
				"TYPE" => "LIST",
				"VALUES" => $arSort,
				"ADDITIONAL_VALUES" => "Y",
				"DEFAULT" => "id",
			);
			$arComponentParameters["PARAMETERS"]["ELEMENT_SORT_ORDER_BOX2"] = array(
				"PARENT" => "COMPARE_SETTINGS",
				"NAME" => GetMessage("IBLOCK_ELEMENT_SORT_ORDER_BOX2"),
				"TYPE" => "LIST",
				"VALUES" => $arAscDesc,
				"DEFAULT" => "desc",
				"ADDITIONAL_VALUES" => "Y",
			);
		}
	}
}

if (!empty($offers))
{
	$arComponentParameters["PARAMETERS"]["OFFERS_FIELD_CODE"] = CIBlockParameters::GetFieldCode(GetMessage("CP_BC_DETAIL_OFFERS_FIELD_CODE"), "DETAIL_SETTINGS");
	$arComponentParameters["PARAMETERS"]["OFFERS_PROPERTY_CODE"] = array(
		"PARENT" => "DETAIL_SETTINGS",
		"NAME" => GetMessage("CP_BC_DETAIL_OFFERS_PROPERTY_CODE"),
		"TYPE" => "LIST",
		"MULTIPLE" => "Y",
		"VALUES" => $arProperty_Offers,
		"ADDITIONAL_VALUES" => "Y",
	);
}

if ($catalogIncluded)
{
	$arComponentParameters["PARAMETERS"]['CONVERT_CURRENCY'] = array(
		'PARENT' => 'PRICES',
		'NAME' => GetMessage('CP_BC_CONVERT_CURRENCY'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
		'REFRESH' => 'Y',
	);

	if (isset($arCurrentValues['CONVERT_CURRENCY']) && $arCurrentValues['CONVERT_CURRENCY'] == 'Y')
	{
		$arComponentParameters['PARAMETERS']['CURRENCY_ID'] = array(
			'PARENT' => 'PRICES',
			'NAME' => GetMessage('CP_BC_CURRENCY_ID'),
			'TYPE' => 'LIST',
			'VALUES' => Currency\CurrencyManager::getCurrencyList(),
			'DEFAULT' => Currency\CurrencyManager::getBaseCurrency(),
			"ADDITIONAL_VALUES" => "Y",
		);
	}
}

if(empty($offers))
{
	unset($arComponentParameters["GROUPS"]["OFFERS_SETTINGS"]);
}
else
{
//	$arComponentParameters["PARAMETERS"]["OFFERS_CART_PROPERTIES"] = array(
//		"PARENT" => "BASKET",
//		"NAME" => GetMessage("CP_BC_OFFERS_CART_PROPERTIES"),
//		"TYPE" => "LIST",
//		"MULTIPLE" => "Y",
//		"VALUES" => $arProperty_OffersWithoutFile,
//		"HIDDEN" => (isset($arCurrentValues['ADD_PROPERTIES_TO_BASKET']) && $arCurrentValues['ADD_PROPERTIES_TO_BASKET'] == 'N' ? 'Y' : 'N')
//	);

	$arComponentParameters["PARAMETERS"]["OFFERS_SORT_FIELD"] = array(
		"PARENT" => "OFFERS_SETTINGS",
		"NAME" => GetMessage("CP_BC_OFFERS_SORT_FIELD"),
		"TYPE" => "LIST",
		"VALUES" => $arSort,
		"ADDITIONAL_VALUES" => "Y",
		"DEFAULT" => "sort",
	);
	$arComponentParameters["PARAMETERS"]["OFFERS_SORT_ORDER"] = array(
		"PARENT" => "OFFERS_SETTINGS",
		"NAME" => GetMessage("CP_BC_OFFERS_SORT_ORDER"),
		"TYPE" => "LIST",
		"VALUES" => $arAscDesc,
		"DEFAULT" => "asc",
		"ADDITIONAL_VALUES" => "Y",
	);
	$arComponentParameters["PARAMETERS"]["OFFERS_SORT_FIELD2"] = array(
		"PARENT" => "OFFERS_SETTINGS",
		"NAME" => GetMessage("CP_BC_OFFERS_SORT_FIELD2"),
		"TYPE" => "LIST",
		"VALUES" => $arSort,
		"ADDITIONAL_VALUES" => "Y",
		"DEFAULT" => "id",
	);
	$arComponentParameters["PARAMETERS"]["OFFERS_SORT_ORDER2"] = array(
		"PARENT" => "OFFERS_SETTINGS",
		"NAME" => GetMessage("CP_BC_OFFERS_SORT_ORDER2"),
		"TYPE" => "LIST",
		"VALUES" => $arAscDesc,
		"DEFAULT" => "desc",
		"ADDITIONAL_VALUES" => "Y",
	);
        $arOffersViewModeList = array(
                'SELECT' => GetMessage('OFFERS_SELECT_VIEW'),
                'CHOISE' => GetMessage('OFFERS_CHOISE_VIEW'),
                'ICONS' => GetMessage('OFFERS_ICONS_VIEW')
        );

        $arComponentParameters["PARAMETERS"]['OFFERS_VIEW'] = array(
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

        $arComponentParameters["PARAMETERS"]["SKU_PROPS_SHOW_TYPE"] = array(
                "PARENT" => "OFFERS_SETTINGS",
                "NAME" => GetMessage("SKU_PROPS_SHOW_TYPE"),
                'TYPE' => 'LIST',
                'VALUES' => $skuPropsShowType,
                'DEFAULT' => "square",
        );

        $arComponentParameters["PARAMETERS"]['OFFER_ADD_PICT_PROP'] = array(
                'PARENT' => 'VISUAL',
                'NAME' => GetMessage('CP_BC_TPL_OFFER_ADD_PICT_PROP'),
                'TYPE' => 'LIST',
                'MULTIPLE' => 'N',
                'ADDITIONAL_VALUES' => 'N',
                'REFRESH' => 'N',
                'DEFAULT' => '-',
                'VALUES' => $arProperty_OffersFile
        );
        $arComponentParameters["PARAMETERS"]['OFFER_TREE_PROPS'] = array(
                'PARENT' => 'VISUAL',
                'NAME' => GetMessage('CP_BC_TPL_OFFER_TREE_PROPS'),
                'TYPE' => 'LIST',
                'MULTIPLE' => 'Y',
                'ADDITIONAL_VALUES' => 'N',
                'REFRESH' => 'N',
                'DEFAULT' => '-',
                'VALUES' => $arProperty_OffersTree
        );
}


$arComponentParameters["PARAMETERS"]['SHOW_MAX_QUANTITY'] = array(
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
                $arComponentParameters["PARAMETERS"]['MESS_SHOW_MAX_QUANTITY'] = array(
                        'PARENT' => 'VISUAL',
                        'NAME' => GetMessage('CP_BC_TPL_MESS_SHOW_MAX_QUANTITY'),
                        'TYPE' => 'STRING',
                        'DEFAULT' => GetMessage('CP_BC_TPL_MESS_SHOW_MAX_QUANTITY_DEFAULT')
                );
        }

        if ($arCurrentValues['SHOW_MAX_QUANTITY'] === 'M')
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
        if ($arCurrentValues['SHOW_MAX_QUANTITY'] === 'A')
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

if (isset($arCurrentValues['USE_VOTE_RATING']) && 'Y' == $arCurrentValues['USE_VOTE_RATING'])
{
	$arComponentParameters["PARAMETERS"]['VOTE_DISPLAY_AS_RATING'] = array(
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

if (ModuleManager::isModuleInstalled("highloadblock"))
{
	$arComponentParameters["PARAMETERS"]['BRAND_USE'] = array(
		'PARENT' => 'DETAIL_SETTINGS',
		'NAME' => GetMessage('CP_BC_TPL_DETAIL_BRAND_USE'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
		'REFRESH' => 'Y'
	);

	if (isset($arCurrentValues['BRAND_USE']) && 'Y' == $arCurrentValues['BRAND_USE'])
	{
		$arComponentParameters["PARAMETERS"]['BRAND_PROP_CODE'] = array(
			'PARENT' => 'DETAIL_SETTINGS',
			"NAME" => GetMessage("CP_BC_TPL_DETAIL_PROP_CODE"),
			"TYPE" => "LIST",
			"VALUES" => $arProperty_HL,
			"MULTIPLE" => "Y",
			"ADDITIONAL_VALUES" => "Y"
		);
	}
}

if (isset($arCurrentValues['USE_FAVORITES']) && 'Y' == $arCurrentValues['USE_FAVORITES']) {
	$arComponentParameters["PARAMETERS"]['USE_FAVORITES_TEXT'] = array(
		'PARENT' => 'KZNC_BUTTON_BLOCK',
		'NAME' => GetMessage('KZNC_USE_FAVORITES_TEXT'),
		'TYPE' => 'STRING',
		'DEFAULT' => GetMessage('KZNC_USE_FAVORITES_TEXT_DEFAULT')
	);
}

if (isset($arCurrentValues['USE_SHARE']) && 'Y' == $arCurrentValues['USE_SHARE']) {
	$arComponentParameters["PARAMETERS"]['USE_SHARE_TEXT'] = array(
		'PARENT' => 'KZNC_BUTTON_BLOCK',
		'NAME' => GetMessage('KZNC_USE_SHARE_TEXT'),
		'TYPE' => 'STRING',
		'DEFAULT' => GetMessage('KZNC_USE_SHARE_TEXT_DEFAULT')
	);
}

if (isset($arCurrentValues['USE_ONE_CLICK']) && 'Y' == $arCurrentValues['USE_ONE_CLICK']) {
	$arComponentParameters["PARAMETERS"]['USE_ONE_CLICK_TEXT'] = array(
		'PARENT' => 'KZNC_BUTTON_BLOCK',
		'NAME' => GetMessage('KZNC_USE_ONE_CLICK_TEXT'),
		'TYPE' => 'STRING',
		'DEFAULT' => GetMessage('KZNC_USE_ONE_CLICK_TEXT_DEFAULT')
	);
}

$arMarkersValues = \Alexkova\Bxready2\Component::getMarkerListParams();

$arComponentParameters["PARAMETERS"]['BXREADY_DETAIL_MARKER_TYPE'] = array(
    'PARENT' => 'DETAIL_SETTINGS',
    'NAME' => GetMessage('BXREADY_DETAIL_MARKER_TYPE'),
    'TYPE' => 'LIST',
    'VALUES' => $arMarkersValues["system"],
    'DEFAULT' => 'not',
);

$arComponentParameters["PARAMETERS"]['BXREADY_DETAIL_OWN_MARKER_USE'] = array(
    'PARENT' => 'DETAIL_SETTINGS',
    'NAME' => GetMessage('BXREADY_DETAIL_OWN_MARKER_USE'),
    'TYPE' => 'CHECKBOX',
    'REFRESH' => 'Y',
    'DEFAULT' => 'N',
);

if ((isset($arCurrentValues['BXREADY_DETAIL_OWN_MARKER_USE']) && $arCurrentValues['BXREADY_DETAIL_OWN_MARKER_USE'] === 'Y')) {
    $arComponentParameters["PARAMETERS"]['BXREADY_DETAIL_OWN_MARKER_TYPE'] = array(
        'PARENT' => 'DETAIL_SETTINGS',
        'NAME' => GetMessage('BXREADY_DETAIL_OWN_MARKER_TYPE'),
        'TYPE' => 'LIST',
        'VALUES' => $arMarkersValues["user"],
        'DEFAULT' => '',
    );
}

$arTimerValues = array(
    'LIGHT' => GetMessage('BXR_ACTION_TIMER_LIGHT'),
    'DARK' => GetMessage('BXR_ACTION_TIMER_DARK')
);

$arComponentParameters["PARAMETERS"]['BXR_SHOW_ACTION_TIMER_DETAIL'] = array(
    'PARENT' => 'DETAIL_SETTINGS',
    'NAME' => GetMessage('CP_BCS_TPL_SHOW_ACTION_TIMER'),
    'TYPE' => 'LIST',
    'VALUES' => $arTimerValues,
    'DEFAULT' => 'N',
);

<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

global $arComponentGroups, $arReload;

$arComponentGroups = array();
$arReload = array(
	"PARAMETERS" => array(),
	"GROUPS" => array()
);

$arComponentGroups['DETAIL_TAB_SETTINGS']=array(
	"SORT" => 300,
	"NAME" => GetMessage("DETAIL_TAB_SETTINGS_DESC"),
);

$arComponentGroups['ADV_SETTINGS']=array(
	"SORT" => 400,
	"NAME" => GetMessage("ADV_SETTINGS_DESC"),
);

$arComponentGroups["SHARE_SETTINGS"] = array(
        "NAME" => GetMessage("T_SHARE_SETTINGS"),
        "SORT" => 420
);

$arComponentGroups["PAGER_SETTINGS"] = array(
	"NAME" => GetMessage("T_PAGER_SETTINGS"),
	"SORT" => 350
);

$arTemplateParameters = array(
	"BXR_DISCOUNT_SHOW_TYPE" =>array(
		"PARENT" => "DETAIL_SETTINGS",
		"NAME" => GetMessage("BXR_DISCOUNT_SHOW_TYPE_DESC"),
		"TYPE" => "LIST",
		"VALUES" => array(
			'none' => GetMessage('BXR_DISCOUNT_SHOW_TYPE_NONE'),
			'percent' => GetMessage('BXR_DISCOUNT_SHOW_TYPE_PERCENT'),
			'diff' => GetMessage('BXR_DISCOUNT_SHOW_TYPE_DIFF'),
			'both' => GetMessage('BXR_DISCOUNT_SHOW_TYPE_BOTH')
		),
		'REFRESH'=>'N'
	),

	"INDEX_SHOW_IBLOCK_DESCRIPTION" =>array(
		"PARENT" => "INDEX_SETTINGS",
		"NAME" => GetMessage("INDEX_SHOW_IBLOCK_DESCRIPTION"),
		"TYPE" => "CHECKBOX",
		'REFRESH'=>'N'
	),

	/*"INDEX_ELEMENT_DRAW" =>array(
		"PARENT" => "INDEX_SETTINGS",
		"NAME" => GetMessage("INDEX_ELEMENT_TYPE"),
		"TYPE" => "LIST",
		"VALUES" => array(
			'section.horizontal.v1'=>'section.horizontal.v1'
		)
	),*/

	"INDEX_SHOW_SEO" =>array(
		"PARENT" => "INDEX_SETTINGS",
		"NAME" => GetMessage("INDEX_SHOW_SEO"),
		"TYPE" => "CHECKBOX",
		'REFRESH'=>'N'
	),

	"BXR_SHOW_OFFERS" =>array(
		"PARENT" => "DETAIL_SETTINGS",
		"NAME" => GetMessage("BXR_SHOW_OFFERS_DESC"),
		"TYPE" => "CHECKBOX",
		'REFRESH'=>'Y'
	),
	"BXR_SHOW_IMG_IN_FORM" => Array(
		"PARENT" => "DETAIL_SETTINGS",
		"NAME" => GetMessage("BXR_SHOW_IMG_IN_FORM"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
	),
	"BXR_SHOW_NAME_IN_FORM" => Array(
		"PARENT" => "DETAIL_SETTINGS",
		"NAME" => GetMessage("BXR_SHOW_NAME_IN_FORM"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
	),

	/*"LIST_ADD_IBLOCK_CHAIN" =>array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => GetMessage("ADD_IBLOCK_CHAIN_S"),
		"TYPE" => "CHECKBOX",
		'REFRESH'=>'N'
	),*/

	"LIST_ADD_SECTIONS_CHAIN" =>array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => GetMessage("ADD_SECTIONS_CHAIN_S"),
		"TYPE" => "CHECKBOX",
		'REFRESH'=>'N'
	),

	"LIST_MAX_NEWS_COUNT" =>array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => GetMessage("LIST_MAX_NEWS_COUNT_S"),
		"TYPE" => "STRING",
		"DEFAULT" => 10
	),

	"LIST_BXR_SHOW_DESCRIPTION" =>array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => GetMessage("LIST_BXR_SHOW_DESCRIPTION"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),

	"LIST_BXR_SHOW_SEO" =>array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => GetMessage("LIST_BXR_SHOW_SEO"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),

	"LIST_SET_TITLE" =>array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => GetMessage("LIST_SET_TITLE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),

	"LIST_SET_BROWSER_TITLE" =>array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => GetMessage("LIST_SET_BROWSER_TITLE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),

	"LIST_SET_META_KEYWORDS" =>array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => GetMessage("LIST_SET_META_KEYWORDS"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),

	"LIST_SET_META_DESCRIPTION" =>array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => GetMessage("LIST_SET_META_DESCRIPTION"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),


	"DISPLAY_TOP_PAGER" => array(
		"PARENT" => "PAGER_SETTINGS",
		"NAME" => GetMessage("T_IBLOCK_DESC_TOP_PAGER"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
	),
	"DISPLAY_BOTTOM_PAGER" => array(
		"PARENT" => "PAGER_SETTINGS",
		"NAME" => GetMessage("T_IBLOCK_DESC_BOTTOM_PAGER"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"PAGER_TITLE" => array(
		"PARENT" => "PAGER_SETTINGS",
		"NAME" => GetMessage("T_IBLOCK_DESC_PAGER_TITLE"),
		"TYPE" => "STRING",
		"DEFAULT" => GetMessage("T_IBLOCK_DESC_PAGER_TITLE_PAGE"),
	),
	"PAGER_TEMPLATE" => array(
		"PARENT" => "PAGER_SETTINGS",
		"NAME" => GetMessage("T_IBLOCK_DESC_PAGER_TEMPLATE"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
	),
	"PAGER_SHOW_ALWAYS" => array(
		"PARENT" => "PAGER_SETTINGS",
		"NAME" => GetMessage("CP_BN_DETAIL_PAGER_SHOW_ALLWAYS"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),

	"BXR_DETAIL_TAB_TYPE" =>array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_TYPE_DESC"),
		"TYPE" => "LIST",
		"VALUES" => array(
			'tabs' => GetMessage('BXR_DETAIL_TAB_TYPE_TABS'),
			'list' => GetMessage('BXR_DETAIL_TAB_TYPE_LIST')
		),
		'REFRESH'=>'N'
	),

	"BXR_DETAIL_TAB_TEXT" =>array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_TEXT_DESC"),
		"TYPE" => "LIST",
		"VALUES" => array(
			'tabs' => GetMessage('BXR_DETAIL_TAB_TEXT_TAB'),
			'detail' => GetMessage('BXR_DETAIL_TAB_TEXT_DETAIL')
		),
		'REFRESH'=>'N'
	),

	"BXR_DETAIL_TAB_TEXT_CAPTION" =>array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_TEXT_CAPTION"),
		"TYPE" => "STRING",
		"DEFAULT" => GetMessage("BXR_DETAIL_TAB_TEXT_CAPTION_DEFAULT")
	),

	"BXR_DETAIL_TAB_TEXT_GLYPH" =>array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_GLYPH"),
		"TYPE" => "STRING",
		"DEFAULT" => ''
	),

	"BXR_DETAIL_TAB_TEXT_LINK" =>array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_SMART_LINK"),
		"TYPE" => "STRING",
		"DEFAULT" => GetMessage("BXR_DETAIL_TAB_TEXT_LINK_DEFAULT")
	),

	"BXR_DETAIL_TAB_PROPERTIES" =>array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_PROPERTIES"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y"
	),

	"BXR_DETAIL_TAB_PROPERTIES_CAPTION" =>array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_PROPERTIES_CAPTION"),
		"TYPE" => "STRING",
		"DEFAULT" => GetMessage("BXR_DETAIL_TAB_PROPERTIES_CAPTION_DEFAULT")
	),

	"BXR_DETAIL_TAB_PROPERTIES_GLYPH" =>array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_GLYPH"),
		"TYPE" => "STRING",
		"DEFAULT" => ''
	),

	"BXR_DETAIL_TAB_PROPERTIES_LINK" =>array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_SMART_LINK"),
		"TYPE" => "STRING",
		"DEFAULT" => ""
	),

	"BXR_DETAIL_TAB_PROPERTIES_SORT" =>array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_SORT"),
		"TYPE" => "STRING",
		"DEFAULT" => '500'
	),

	"BXR_DETAIL_TAB_SCHEMES" =>array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_SCHEMES"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y"
	),

	"BXR_DETAIL_TAB_SCHEMES_CAPTION" =>array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_SCHEMES_CAPTION"),
		"TYPE" => "STRING",
		"DEFAULT" => GetMessage("BXR_DETAIL_TAB_SCHEMES_CAPTION_DEFAULT")
	),

	"BXR_DETAIL_TAB_SCHEMES_GLYPH" =>array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_GLYPH"),
		"TYPE" => "STRING",
		"DEFAULT" => ''
	),

	"BXR_DETAIL_TAB_SCHEMES_LINK" =>array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_SMART_LINK"),
		"TYPE" => "STRING",
		"DEFAULT" => ""
	),

	"BXR_DETAIL_TAB_SCHEMES_SORT" =>array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_SORT"),
		"TYPE" => "STRING",
		"DEFAULT" => '500'
	),

	"BXR_DETAIL_TAB_FILES" =>array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_FILES"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y"
	),

	"BXR_DETAIL_TAB_FILES_CAPTION" =>array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_FILES_CAPTION"),
		"TYPE" => "STRING",
		"DEFAULT" => GetMessage("BXR_DETAIL_TAB_FILES_CAPTION_DEFAULT")
	),

	"BXR_DETAIL_TAB_FILES_GLYPH" =>array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_GLYPH"),
		"TYPE" => "STRING",
		"DEFAULT" => ''
	),

	"BXR_DETAIL_TAB_FILES_LINK" =>array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_SMART_LINK"),
		"TYPE" => "STRING",
		"DEFAULT" => ""
	),

	"BXR_DETAIL_TAB_FILES_SORT" =>array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_SORT"),
		"TYPE" => "STRING",
		"DEFAULT" => '500'
	),

	"BXR_DETAIL_TAB_VIDEO" =>array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_VIDEO"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y"
	),

	"BXR_DETAIL_TAB_VIDEO_MODE" =>array(
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
		),
		"DEFAULT" => "table"
	),

	"BXR_DETAIL_TAB_VIDEO_CAPTION" =>array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_VIDEO_CAPTION"),
		"TYPE" => "STRING",
		"DEFAULT" => GetMessage("BXR_DETAIL_TAB_VIDEO_CAPTION_DEFAULT")
	),

	"BXR_DETAIL_TAB_VIDEO_GLYPH" =>array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_GLYPH"),
		"TYPE" => "STRING",
		"DEFAULT" => ''
	),

	"BXR_DETAIL_TAB_VIDEO_LINK" =>array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_SMART_LINK"),
		"TYPE" => "STRING",
		"DEFAULT" => ""
	),

	"BXR_DETAIL_TAB_VIDEO_SORT" =>array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_SORT"),
		"TYPE" => "STRING",
		"DEFAULT" => '500'
	),

	"BXR_DETAIL_TAB_INC" =>array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_INC"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y"
	),

	"BXR_DETAIL_TAB_INC_CAPTION" =>array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_INC_CAPTION"),
		"TYPE" => "STRING",
		"DEFAULT" => GetMessage("BXR_DETAIL_TAB_INC_CAPTION_DEFAULT")
	),

	"BXR_DETAIL_TAB_INC_GLYPH" =>array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_GLYPH"),
		"TYPE" => "STRING",
		"DEFAULT" => ''
	),

	"BXR_DETAIL_TAB_INC_LINK" =>array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_SMART_LINK"),
		"TYPE" => "STRING",
		"DEFAULT" => ""
	),

	"BXR_DETAIL_TAB_INC_URL" =>array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_INC_URL"),
		"TYPE" => "STRING",
		"DEFAULT" => ""
	),

	"BXR_DETAIL_TAB_INC_SORT" =>array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_SORT"),
		"TYPE" => "STRING",
		"DEFAULT" => '500'
	),

	"DETAIL_ADD_SECTIONS_CHAIN" => array(
		"PARENT" => "DETAIL_SETTINGS",
		"NAME" => GetMessage("DETAIL_ADD_SECTIONS_CHAIN"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),

	"ADD_ELEMENT_CHAIN" => array(
		"PARENT" => "DETAIL_SETTINGS",
		"NAME" => GetMessage("ADD_ELEMENT_CHAIN"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),	

	"BXR_ADV_TOP_CONTENT_INDEX" =>array(
		"PARENT" => "ADV_SETTINGS",
		"NAME" => GetMessage("BXR_ADV_TOP_CONTENT_INDEX"),
		"TYPE" => "LIST",
		"VALUES" => array(
			'full-static' => GetMessage('BXR_ADV_MODE_STATIC'),
			'full-responsive' => GetMessage('BXR_ADV_MODE_RESPONSIVE'),
			'none' => GetMessage('BXR_ADV_MODE_NONE'),
		),
		"DEFAULT" => "full-static"
	),

	"BXR_ADV_TOP_CONTENT_SECTION" =>array(
		"PARENT" => "ADV_SETTINGS",
		"NAME" => GetMessage("BXR_ADV_TOP_CONTENT_SECTION"),
		"TYPE" => "LIST",
		"VALUES" => array(
			'full-static' => GetMessage('BXR_ADV_MODE_STATIC'),
			'full-responsive' => GetMessage('BXR_ADV_MODE_RESPONSIVE'),
			'none' => GetMessage('BXR_ADV_MODE_NONE'),
		),
		"DEFAULT" => "full-static"
	),

	"BXR_ADV_BOTTOM_CONTENT_INDEX" =>array(
		"PARENT" => "ADV_SETTINGS",
		"NAME" => GetMessage("BXR_ADV_BOTTOM_CONTENT_INDEX"),
		"TYPE" => "LIST",
		"VALUES" => array(
			'full-static' => GetMessage('BXR_ADV_MODE_STATIC'),
			'full-responsive' => GetMessage('BXR_ADV_MODE_RESPONSIVE'),
			'none' => GetMessage('BXR_ADV_MODE_NONE'),
		),
		"DEFAULT" => "full-static"
	),

	"BXR_ADV_BOTTOM_CONTENT_SECTION" =>array(
		"PARENT" => "ADV_SETTINGS",
		"NAME" => GetMessage("BXR_ADV_BOTTOM_CONTENT_SECTION"),
		"TYPE" => "LIST",
		"VALUES" => array(
			'full-static' => GetMessage('BXR_ADV_MODE_STATIC'),
			'full-responsive' => GetMessage('BXR_ADV_MODE_RESPONSIVE'),
			'none' => GetMessage('BXR_ADV_MODE_NONE'),
		),
		"DEFAULT" => "full-static"
	),

	"BXR_ADV_BOTTOM_CONTENT_DETAIL" =>array(
		"PARENT" => "ADV_SETTINGS",
		"NAME" => GetMessage("BXR_ADV_BOTTOM_CONTENT_DETAIL"),
		"TYPE" => "LIST",
		"VALUES" => array(
			'full-static' => GetMessage('BXR_ADV_MODE_STATIC'),
			'full-responsive' => GetMessage('BXR_ADV_MODE_RESPONSIVE'),
			'none' => GetMessage('BXR_ADV_MODE_NONE'),
		),
		"DEFAULT" => "full-static"
	),

	"BXR_USE_INCLUDE" => array(
		"PARENT" => "BXR_INCLUDE_SETTINGS_GROUP",
		"NAME" => GetMessage("BXR_USE_INCLUDE_DESC"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
	),

	"CBXR_PICTURE_BXR_DETAIL_PICTURE_TYPE" => array(
		"PARENT" => "BXR_DETAIL_PICTURE_SETTINGS_GROUP",
		"NAME" => GetMessage("BXR_DETAIL_PICTURE_TYPE_DESC"),
		"TYPE" => "LIST",
		"VALUES" => array(
			'picture' => GetMessage('BXR_DETAIL_PICTURE_TYPE_PICTURE'),
			'slider' => GetMessage('BXR_DETAIL_PICTURE_TYPE_SLIDER'),
			'fullsize_picture' => GetMessage('BXR_DETAIL_PICTURE_TYPE_FULLSIZE'),
			'fullsize_slider' => GetMessage('BXR_DETAIL_PICTURE_TYPE_FULLSIZE_SLIDER')
		),
		'REFRESH'=>'Y'
	),

	"CBXR_PICTURE_BXR_ZOOM_PICTURE_TYPE" => array(
		"PARENT" => "BXR_DETAIL_PICTURE_SETTINGS_GROUP",
		"NAME" => GetMessage("BXR_ZOOM_PICTURE_TYPE_DESC"),
		"TYPE" => "LIST",
		"VALUES" => array(
			'none' => GetMessage('BXR_ZOOM_PICTURE_TYPE_NONE'),
			'inside' => GetMessage('BXR_ZOOM_PICTURE_TYPE_INSIDE'),
			'outside' => GetMessage('BXR_ZOOM_PICTURE_TYPE_OUTSIDE')
		)
	),

	"CBXR_PICTURE_BXR_SLIDER_HEIGHT" => array(
		"PARENT" => "BXR_DETAIL_PICTURE_SETTINGS_GROUP",
		"NAME" => GetMessage("CBXR_PICTURE_BXR_SLIDER_HEIGHT"),
		"TYPE" => "STRING",
		'DEFAULT' => 300
	),

	"DETAIL_PAGE_URL_CAPTION" => array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => GetMessage("DETAIL_PAGE_URL_CAPTION"),
		"TYPE" => "STRING",
		'DEFAULT' => GetMEssage('DETAIL_PAGE_URL_CAPTION_DEFAULT')
	),



	"BXR_BUSINESS_SHOW_SOCIAL_SHARE" => array(
	        "NAME" => GetMessage("BXR_BUSINESS_SHOW_SOCIAL_SHARE"),
	        "PARENT" => "SHARE_SETTINGS",
	        "TYPE" => "CHECKBOX",
	        "DEFAULT" => "Y",
		"REFRESH" => "Y"
	),
);



if($arCurrentValues["BXR_BUSINESS_SHOW_SOCIAL_SHARE"] == "Y") :
    $arTemplateParameters["BXR_SHARE_HANDLERS"] = array(
        "NAME" => GetMessage("BXR_SHARE_HANDLERS"),
        "PARENT" => "SHARE_SETTINGS",
        "TYPE" => "LIST",
        "VALUES" => array(
            "twitter" => GetMessage("BXR_SHARE_HANDLERS_TWITTER"),
            "vk" => GetMessage("BXR_SHARE_HANDLERS_VK"),
            "pinterest" => GetMessage("BXR_SHARE_HANDLERS_PRINTEREST"),
            "facebook" => GetMessage("BXR_SHARE_HANDLERS_FACEBOOK"),
            "gplus" => GetMessage("BXR_SHARE_HANDLERS_GPLUS")
        ),
        "DEFAULT" => array(
            "twitter",
            "vk",
            "pinterest",
            "facebook",
            "gplus"
        ),
        "MULTIPLE" => "Y"
    );
    $arTemplateParameters["BXR_HIDE_SHARE_PANEL"] = array(
        "NAME" => GetMessage("BXR_HIDE_SHARE_PANEL"),
        "PARENT" => "SHARE_SETTINGS",
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "N"
    );
    $arTemplateParameters["BXR_SHARE_SHORTEN_URL_KEY"] = array(
        "NAME" => GetMessage("BXR_SHARE_SHORTEN_URL_KEY"),
        "PARENT" => "SHARE_SETTINGS",
        "TYPE" => "STRING",
        "DEFAULT" => ""
    );
    $arTemplateParameters["BXR_SHARE_SHORTEN_URL_LOGIN"] = array(
        "NAME" => GetMessage("BXR_SHARE_SHORTEN_URL_LOGIN"),
        "PARENT" => "SHARE_SETTINGS",
        "TYPE" => "STRING",
        "DEFAULT" => ""
    );
endif;

if ($arCurrentValues["BXR_SHOW_OFFERS"] == "Y"){
	$arTemplateParameters["BXR_SHOW_OFFERS_TITLE"] = array(
		"PARENT" => "DETAIL_SETTINGS",
		"NAME" => GetMessage("BXR_SHOW_OFFERS_TITLE_DESC"),
		"TYPE" => "CHECKBOX",
		'REFRESH'=>'N'
	);
}

if($arCurrentValues["BXR_BUSINESS_USE_SMARTPRICE"] == "Y"){

	$arTemplateParameters["BXR_DETAIL_TAB_SMARTPRICE_CAPTION"] = array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_SMARTPRICE_CAPTION"),
		"TYPE" => "STRING",
		"DEFAULT" => GetMessage("BXR_DETAIL_TAB_SMARTPRICE_CAPTION_DEFAULT")
	);

	$arTemplateParameters["BXR_DETAIL_TAB_SMARTPRICE_GLYPH"] = array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_GLYPH"),
		"TYPE" => "STRING",
		"DEFAULT" => ''
	);

	$arTemplateParameters["BXR_DETAIL_TAB_SMARTPRICE_LINK"] = array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_SMART_LINK"),
		"TYPE" => "STRING",
		"DEFAULT" => ""
	);

	$arTemplateParameters["BXR_DETAIL_TAB_SMARTPRICE_SORT"] = array(
		"PARENT" => "DETAIL_TAB_SETTINGS",
		"NAME" => GetMessage("BXR_DETAIL_TAB_SORT"),
		"TYPE" => "STRING",
		"DEFAULT" => '500'
	);
}

if (CModule::IncludeModule('alexkova.bxready2')){
	$additionalParams = \Alexkova\Bxready2\Component::getRelatedListSettings(
		array(),
		$arCurrentValues,
		array(
			'sidebar' => 'sidebar',
			//'content' => 'content',
			'bottom' => 'bottom',
		)
	);

	if (is_array($additionalParams)){

		if (count($additionalParams['GROUPS'])>0){
			foreach ($additionalParams['GROUPS'] as $cell=>$val){
				$arComponentGroups[$cell] = $val;
			}
		}

		if (count($additionalParams['PARAMETERS'])>0){
			foreach ($additionalParams['PARAMETERS'] as $cell=>$val){
				$arTemplateParameters[$cell] = $val;
			}
		}
	}

	$additionalParams = \Alexkova\Bxready2\Component::getCustomListSettings(
		12,
		$arCurrentValues,
		array(
			'slider'=>false,
			'collection'=>array('news.horizontal.v1'),
			'sort'=>150
		),

		'LISTPAGE'
	);

	if (is_array($additionalParams)){

		if (count($additionalParams['LIST_GROUPS'])>0){
			foreach ($additionalParams['LIST_GROUPS'] as $cell=>$val){
				$arComponentGroups[$cell] = $val;
			}
		}

		if (count($additionalParams['LIST_PARAMS'])>0){
			foreach ($additionalParams['LIST_PARAMS'] as $cell=>$val){
				$arTemplateParameters[$cell] = $val;
			}
		}
	}
}

if (CModule::IncludeModule('alexkova.business')){

	$additionalParams = \Alexkova\Business\Smartprice::getComponentParams($arCurrentValues, true);

	if (is_array($additionalParams)){

		if (count($additionalParams['GROUPS'])>0){
			foreach ($additionalParams['GROUPS'] as $cell=>$val){
				$arComponentGroups[$cell] = $val;
			}
		}

		if (count($additionalParams['PARAMETERS'])>0){
			foreach ($additionalParams['PARAMETERS'] as $cell=>$val){
				$arTemplateParameters[$cell] = $val;
			}
		}
	}
}

$arReload['PARAMETERS']["SEF_MODE"] = Array(
	/*"index" => array(
		"NAME" => GetMessage("T_IBLOCK_SEF_PAGE_NEWS"),
		"DEFAULT" => "",
		"VARIABLES" => array(),
	),*/
	"detail" => array(
		"NAME" => GetMessage("T_IBLOCK_SEF_PAGE_NEWS_DETAIL"),
		"DEFAULT" => "#ELEMENT_ID#/",
		"VARIABLES" => array("ELEMENT_ID"),
	),
);
?>

<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);

global $elementID;

$elementID = 0;

$extractFormParams = array();
$extractPictureParams = array();
$extractTabsParams = array();
$extractSmartpriceParams = array();


foreach ($arParams as $cell=>$val){

	if ($arParams['BXR_USE_FORM'] == "Y"){
		if (substr($cell,0,10) == 'CBXR_FORM_'){
			$extractFormParams[str_replace('CBXR_FORM_','', $cell)] = $val;
		}
	}

	if (substr($cell,0,13) == 'CBXR_PICTURE_'){
		$extractPictureParams[str_replace('CBXR_PICTURE_','', $cell)] = $val;
	}

	if (substr($cell,0,15) == 'BXR_DETAIL_TAB_'){
		$extractTabsParams[$cell] = $val;
	}

	if (substr($cell,0,15) == 'BXR_SMARTPRICE_' || substr($cell,0,24) == 'BXR_BUSINESS_SMARTPRICE_'){
		$extractSmartpriceParams[$cell] = $val;
	}

}

$extractSmartpriceParams['USE_SMARTPRICE'] = $arParams['BXR_BUSINESS_USE_SMARTPRICE'];

if ($arParams['BXR_BUSINESS_USE_SMARTPRICE'] == "Y"){
	$extractTabsParams['BXR_DETAIL_TAB_SMARTPRICE'] = 'Y';
}


$APPLICATION->IncludeComponent(
	"bxready2:buffer.content",
	"",
	array(
		"BUFFER_NAME" => "smartlink"
	),
	false,
	array('HIDE_ICONS' => 'Y')
);

$elementID = $APPLICATION->IncludeComponent(
	"bxready2:block.detail",
	"",
	Array(
		"DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
		"DISPLAY_NAME" => $arParams["DISPLAY_NAME"],
		"DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
		"DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"FIELD_CODE" => $arParams["DETAIL_FIELD_CODE"],
		"PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
		"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"META_KEYWORDS" => $arParams["META_KEYWORDS"],
		"META_DESCRIPTION" => $arParams["META_DESCRIPTION"],
		"BROWSER_TITLE" => $arParams["BROWSER_TITLE"],
		"SET_CANONICAL_URL" => $arParams["DETAIL_SET_CANONICAL_URL"],
		"DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
		"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
		"SET_TITLE" => $arParams["SET_TITLE"],
		"MESSAGE_404" => $arParams["MESSAGE_404"],
		"SET_STATUS_404" => $arParams["SET_STATUS_404"],
		"SHOW_404" => $arParams["SHOW_404"],
		"FILE_404" => $arParams["FILE_404"],
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",//$arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
		"ADD_SECTIONS_CHAIN" => $arParams["DETAIL_ADD_SECTIONS_CHAIN"],
		"ACTIVE_DATE_FORMAT" => $arParams["DETAIL_ACTIVE_DATE_FORMAT"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
		"GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
		"DISPLAY_TOP_PAGER" => $arParams["DETAIL_DISPLAY_TOP_PAGER"],
		"DISPLAY_BOTTOM_PAGER" => $arParams["DETAIL_DISPLAY_BOTTOM_PAGER"],
		"PAGER_TITLE" => $arParams["DETAIL_PAGER_TITLE"],
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => $arParams["DETAIL_PAGER_TEMPLATE"],
		"PAGER_SHOW_ALL" => $arParams["DETAIL_PAGER_SHOW_ALL"],
		"CHECK_DATES" => $arParams["CHECK_DATES"],
		"ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
		"ELEMENT_CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"],
		"IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
		"USE_SHARE" => $arParams["BXR_USE_SHARE"],
		"SHARE_HIDE" => $arParams["BXR_SHARE_HIDE"],
		"SHARE_TEMPLATE" => $arParams["BXR_SHARE_TEMPLATE"],
		"SHARE_HANDLERS" => $arParams["BXR_SHARE_HANDLERS"],
		"SHARE_SHORTEN_URL_LOGIN" => $arParams["BXR_SHARE_SHORTEN_URL_LOGIN"],
		"SHARE_SHORTEN_URL_KEY" => $arParams["BXR_SHARE_SHORTEN_URL_KEY"],
                "BXR_SHARE_BLOCK_TEXT" => $arParams["BXR_SHARE_BLOCK_TEXT"],
		"ADD_ELEMENT_CHAIN" => (isset($arParams["ADD_ELEMENT_CHAIN"]) ? $arParams["ADD_ELEMENT_CHAIN"] : ''),
                "BXR_FORM_SIDEBAR" => (isset($arParams["BXR_FORM_SIDEBAR"]) ? $arParams["BXR_FORM_SIDEBAR"] : 'N'),
		"BXR_FORMS"=> $extractFormParams,
		"BXR_PICTURE"=> $extractPictureParams,
		'BXR_DETAIL_TABS' => $extractTabsParams,
		'BXR_SMARTPRICE' => $extractSmartpriceParams,
		'BXR_OFFERS_BLOCK' => array(
			'BXR_SHOW_OFFERS'=>$arParams['BXR_SHOW_OFFERS'],
			'BXR_SHOW_OFFERS_TITLE'=>$arParams['BXR_SHOW_OFFERS_TITLE'],
			'BXR_DISCOUNT_SHOW_TYPE'=>$arParams['BXR_DISCOUNT_SHOW_TYPE']

		),
                "BXR_SLIDER_HEIGHT" => $arParams["CBXR_PICTURE_BXR_SLIDER_HEIGHT"],
                "BXR_SHOW_IMG_IN_FORM" => $arParams["BXR_SHOW_IMG_IN_FORM"],
                "BXR_SHOW_NAME_IN_FORM" => $arParams["BXR_SHOW_NAME_IN_FORM"],
	),
	$component
);
?>
<?

$APPLICATION->IncludeComponent(
"bitrix:main.include",
"named_area",
array(
	"COMPONENT_TEMPLATE" => "named_area",
	"INCLUDE_PTITLE" => GetMessage('CHANGE_FORM_TEXT'),
	"AREA_FILE_SHOW" => "sect",
	"AREA_FILE_SUFFIX" => "bxr",
	"AREA_FILE_RECURSIVE" => "N",
	"EDIT_TEMPLATE" => ""
),
$component
//array('HIDE_ICONS' => 'Y')
);


if ($arParams['BXR_ADV_BOTTOM_CONTENT_DETAIL'] != "none"){

	$APPLICATION->IncludeComponent("bxready2:abmanager",
		$arParams['BXR_ADV_BOTTOM_CONTENT_DETAIL'],
		array(
			"SHOW" => "BXR_CONTENT_BOTTOM",
			"BANTYPE" => "BXR_CONTENT_BOTTOM",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "0",
			"USE_IN_LG_MODE" => "Y",
			"USE_IN_MD_MODE" => "Y",
			"USE_IN_SM_MODE" => "N",
			"USE_IN_XS_MODE" => "N"
		),
		false,
		array(
			"ACTIVE_COMPONENT" => "Y",
			"HIDE_ICONS"=>"Y"
		)
	);

}

/// закешировать
if ($elementID > 0){



	$obCache = new CPHPCache();
	$arCacheArray = $arParams;
	$arCacheArray['ELEMENT_ID'] = $elementID;
	if ($obCache->InitCache($arParams['CACHE_TIME'], serialize($arCacheArray), "/iblock/related")){

		$arCurRelated = $obCache->GetVars();

	}
	elseif ($obCache->StartDataCache()){

		$arCurRelated = array();

		$related = \Alexkova\Bxready2\Related::getRelatedElements($elementID, \Alexkova\Bxready2\Component::getRelatedIblockList($arParams));

		$sections = $arResult["RELATED_SECTIONS"] = \Alexkova\Bxready2\Component::prepareRelatedParams($arParams, array(
			'sidebar' => 'sidebar',
			//'content' => 'content',
			'bottom' => 'bottom'
		));

		$arCurRelated["SECTIONS"] = $sections;
		$arCurRelated["RELATED"] = $related;

		if(defined("BX_COMP_MANAGED_CACHE"))
		{
			global $CACHE_MANAGER;
			$CACHE_MANAGER->StartTagCache("/iblock/related");

			$CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);

			$CACHE_MANAGER->EndTagCache();
		}

		$obCache->EndDataCache($arCurRelated);
	}

	if (isset($arCurRelated))
	{
		$related = $arCurRelated['RELATED'];
		$sections = $arCurRelated['SECTIONS'];

		if (count($sections['order']['sidebar'])>0):
			foreach ($sections['order']['sidebar'] as $cell=>$val):
				$iblockID = $sections['iblocks'][$cell]['BXR_RELATED_IBLOCK_ID'];

				if ($iblockID>0 && count($related[$iblockID])>0){
					$this->SetViewTarget('sidebar', $val);
					$currentParams = $sections['iblocks'][$cell];
					global $arrRelatedFilter;
					$arrRelatedFilter = array ('ID' => $related[$iblockID]);

					include('include/related/related.php');
					$this->EndViewTarget();

				}
			endforeach;
		endif;

		if (count($sections['order']['bottom'])>0):
			foreach ($sections['order']['bottom'] as $cell=>$val):
				$iblockID = $sections['iblocks'][$cell]['BXR_RELATED_IBLOCK_ID'];

				if ($iblockID>0 && count($related[$iblockID])>0){
					$currentParams = $sections['iblocks'][$cell];
					global $arrRelatedFilter;
					$arrRelatedFilter = array ('ID' => $related[$iblockID]);
					include('include/related/related.php');
				}
			endforeach;
		endif;

	}
}else{
	if ($arParams['SET_STATUS_404'] == 'Y'){
		CHTTP::SetStatus("404 Not Found");
	}
}

global $arGlobalSmartLink;
if (isset($arGlobalSmartLink) && is_array($arGlobalSmartLink)){
	$this->SetViewTarget('smartlink', 100);
	include('include/smartlink.php');
	$this->EndViewTarget();
}
?>
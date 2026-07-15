<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);

global $elementID;

$elementID = 0;

$extractFormParams = array();
$extractPictureParams = array();
$extractTabsParams = array();

foreach ($arParams as $cell=>$val) {
	if ($arParams['BXR_USE_FORM'] == "Y") {
		if (substr($cell,0,10) == 'CBXR_FORM_')
			$extractFormParams[str_replace('CBXR_FORM_','', $cell)] = $val;
	}

	if (substr($cell,0,13) == 'CBXR_PICTURE_')
		$extractPictureParams[str_replace('CBXR_PICTURE_','', $cell)] = $val;

	if (substr($cell,0,15) == 'BXR_DETAIL_TAB_')
		$extractTabsParams[$cell] = $val;
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

$includeAreaName = 'detail.block';
include('include_handler.php');
?>
<?
$APPLICATION->IncludeComponent(
	"bxready.market2:main.include",
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
);

if ($arParams['BXR_ADV_BOTTOM_CONTENT_DETAIL'] != "none") {
	$includeAreaName = 'detail.bottom.banner';
	include('include_handler.php');
}

if ($elementID > 0) {
	$obCache = new CPHPCache();
	$arCacheArray = $arParams;
	$arCacheArray['ELEMENT_ID'] = $elementID;
	if ($obCache->InitCache($arParams['CACHE_TIME'], serialize($arCacheArray), "/iblock/related"))
		$arCurRelated = $obCache->GetVars();
	elseif ($obCache->StartDataCache())
	{
		$arCurRelated = array();
		$related = \Alexkova\Bxready2\Related::getRelatedElements($elementID, \Alexkova\Bxready2\Component::getRelatedIblockList($arParams));

		$sections = $arResult["RELATED_SECTIONS"] = \Alexkova\Bxready2\Component::prepareRelatedParams($arParams, array(
			'sidebar' => 'sidebar',
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

		if (!empty($sections['order']['sidebar']) && count($sections['order']['sidebar']) > 0):
			foreach ($sections['order']['sidebar'] as $cell=>$val):
				$iblockID = $sections['iblocks'][$cell]['BXR_RELATED_IBLOCK_ID'];

				if ($iblockID>0 && count($related[$iblockID]) > 0) {
					$this->SetViewTarget('sidebar', $val);
					$currentParams = $sections['iblocks'][$cell];
					global $arrRelatedFilter;
					$arrRelatedFilter = array ('ID' => $related[$iblockID]);

                    $includeAreaName = 'detail.related';
					include('include_handler.php');

					$this->EndViewTarget();
				}
			endforeach;
		endif;

		if (count($sections['order']['bottom']) > 0):
			foreach ($sections['order']['bottom'] as $cell=>$val):
				$iblockID = $sections['iblocks'][$cell]['BXR_RELATED_IBLOCK_ID'];

				if ($iblockID>0 && count($related[$iblockID]) > 0) {
					$currentParams = $sections['iblocks'][$cell];
					global $arrRelatedFilter;
					$arrRelatedFilter = array ('ID' => $related[$iblockID]);

					$includeAreaName = 'detail.related';
					include('include_handler.php');
				}
			endforeach;
		endif;
	}
} else {
	if ($arParams['SET_STATUS_404'] == 'Y')
		CHTTP::SetStatus("404 Not Found");
}

global $arGlobalSmartLink;
if (isset($arGlobalSmartLink) && is_array($arGlobalSmartLink)) {

    $this->SetViewTarget('smartlink', 100);
	
	$includeAreaName = 'detail.smartlink';
	include('include_handler.php');

	$this->EndViewTarget();
}
?>
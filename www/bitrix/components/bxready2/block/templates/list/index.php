<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Loader,
	Bitrix\Iblock\InheritedProperty;
$this->setFrameMode(true);

if ($arParams['INDEX_SHOW_IBLOCK_DESCRIPTION'] == "Y"){
	if ($arParams['IBLOCK_ID']>0){
		$obCache = new CPHPCache();

		if ($obCache->InitCache($arParams['CACHE_TIME'], serialize(array($arParams['IBLOCK_ID'])), $APPLICATION->GetCurPage()))
		{
			$arCurIblock = $obCache->GetVars();
		}
		elseif ($obCache->StartDataCache())
		{
			$arCurIblock = array();
			if (Loader::includeModule("iblock"))
			{
				$dbRes = CIBlock::GetByID($arParams['IBLOCK_ID']);

				if(defined("BX_COMP_MANAGED_CACHE"))
				{
					global $CACHE_MANAGER;
					$CACHE_MANAGER->StartTagCache($APPLICATION->GetCurPage());
					if ($arCurIblock = $dbRes->GetNext())
					{
						$CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);
					}
					$CACHE_MANAGER->EndTagCache();
				}
				else
				{
					if(!$arCurIblock = $dbRes->Fetch())
						$arCurIblock = array();
				}
			}
			$obCache->EndDataCache($arCurIblock);
		}

		if (!isset($arCurIblock))
		{
			$arCurIblock = array();

		}
	}

	$sectionDesc = $arCurIblock["DESCRIPTION"];
	if (strlen($sectionDesc)>0):?>
		<div class="row">
			<div class="col-lg-12 bxr-section-desc">
				<?=$sectionDesc?>
				<div class="clearfix"></div>
			</div>
		</div>
	<?endif;
}

if ($arParams['BXR_ADV_TOP_CONTENT_SECTION'] != "none"){?>
	<div class="bxr-catalog-top-b">
		<?$APPLICATION->IncludeComponent("bxready2:abmanager",
			$arParams['BXR_ADV_TOP_CONTENT_SECTION'],
			array(
				"SHOW" => "BXR_CONTENT_TOP",
				"BANTYPE" => "BXR_CONTENT_TOP",
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
		);?>
	</div>
<?
}
?>
        <?$arBlockParams = array(
            "ACTIVE_DATE_FORMAT" => $arParams["LIST_ACTIVE_DATE_FORMAT"],
            "ADD_SECTIONS_CHAIN" => $arParams["LIST_ADD_SECTIONS_CHAIN"],
            "AJAX_MODE" => $arParams["AJAX_MODE"],
            "AJAX_OPTION_ADDITIONAL" => $arParams["AJAX_OPTION_ADDITIONAL"],
            "AJAX_OPTION_HISTORY" => $arParams["AJAX_OPTION_HISTORY"],
            "AJAX_OPTION_JUMP" => $arParams["AJAX_OPTION_JUMP"],
            "AJAX_OPTION_STYLE" => $arParams["AJAX_OPTION_STYLE"],
            "BXREADY_COLLECTION_DRAW" => "",
            "BXREADY_USER_TYPES" => $arParams["BXREADY_USER_TYPES_LISTPAGE"],
            "BXREADY_USER_TYPE_VARIANT" => $arParams["BXREADY_USER_TYPE_VARIANT_LISTPAGE"],
            "BXREADY_ELEMENT_DRAW" => ($arParams["BXREADY_USER_TYPES_LISTPAGE"] == "Y") ? $arParams["BXREADY_USER_TYPE_VARIANT_LISTPAGE"] : $arParams["BXREADY_ELEMENT_DRAW_LISTPAGE"],
            "BXREADY_LIST_BOOTSTRAP_GRID_STYLE" => $arParams["BXREADY_LIST_BOOTSTRAP_GRID_STYLE_LISTPAGE"],
            "BXREADY_LIST_LG_CNT" => $arParams["BXREADY_LIST_LG_CNT_LISTPAGE"],
            "BXREADY_LIST_MD_CNT" => $arParams["BXREADY_LIST_MD_CNT_LISTPAGE"],
            "BXREADY_LIST_SM_CNT" => $arParams["BXREADY_LIST_SM_CNT_LISTPAGE"],
            "BXREADY_LIST_XS_CNT" => $arParams["BXREADY_LIST_XS_CNT_LISTPAGE"],
            "BXREADY_LIST_TYPES" => 'elements',
            "BXREADY_SECTION_DRAW" => "",
            "CACHE_FILTER" => "Y",
            "CACHE_GROUPS" => $arParams['CACHE_GROUPS'],
            "CACHE_TIME" => $arParams['CACHE_TIME'],
            "CACHE_TYPE" => $arParams['CACHE_TYPE'],
            "CHECK_DATES" => $arParams['CHECK_DATES'],
            "DISPLAY_DATE" => "Y",       
            "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
            "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
            "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
            "FIELD_CODE" => $arParams["LIST_FIELD_CODE"],
            "FILTER_NAME" => "",
            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",//$arParams['LIST_ADD_IBLOCK_CHAIN'],
            "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
            "NEWS_COUNT" => $arParams['LIST_MAX_NEWS_COUNT'],
            "PAGER_DESC_NUMBERING" => $arParams['PAGER_DESC_NUMBERING'],
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "N",
            "PAGER_SHOW_ALWAYS" => $arParams['PAGER_SHOW_ALWAYS'],
            "PAGER_TEMPLATE" => $arParams['PAGER_TEMPLATE'],
            "PAGER_TITLE" => $arParams['PAGER_TITLE'],
            "DETAIL_PAGE_URL_CAPTION" => $arParams["DETAIL_PAGE_URL_CAPTION"],
            "PARENT_SECTION" => "",
            "PARENT_SECTION_CODE" => "",
            "PREVIEW_TRUNCATE_LEN" => "",
            "PROPERTY_CODE" => $arParams['LIST_PROPERTY_CODE'],

            "SET_BROWSER_TITLE" => "Y",
            "SET_META_DESCRIPTION" => "Y",
            "SET_META_KEYWORDS" => "Y",

            "MESSAGE_404" => $arParams["MESSAGE_404"],
            "SET_STATUS_404" => $arParams["SET_STATUS_404"],
            "SHOW_404" => $arParams["SHOW_404"],
            "FILE_404" => $arParams["FILE_404"],

            "SET_TITLE" => "Y",

            "SORT_BY1" => $arParams['LIST_SORT_BY1'],
            "SORT_BY2" => $arParams['LIST_SORT_BY2'],
            "SORT_ORDER1" => $arParams['LIST_SORT_ORDER1'],
            "SORT_ORDER2" => $arParams['LIST_SORT_ORDER2'],

            "BXREADY_ELEMENT_ADDCLASS" => $arParams["BXREADY_ELEMENT_ADDCLASS_LISTPAGE"],
            "BXREADY_USE_ELEMENTCLASS" => $arParams["BXREADY_USE_ELEMENTCLASS_LISTPAGE"],
            "BXREADY_ELEMENT_EXT_PARAMS" => $arParams["BXREADY_ELEMENT_EXT_PARAMS_LISTPAGE"],
            "BXREADY_VERTICAL_ALIGN" => $arParams["BXREADY_VERTICAL_ALIGN_LISTPAGE"],            
        );
        foreach ($arParams as $cell=>$val){
		if (substr($cell, 0, 9) == 'BXR_PRST_'){
			$name = str_replace('_LISTPAGE', '', $cell);
			$arBlockParams[$name] = $val;
		}
	}?>
	<?
	$APPLICATION->IncludeComponent(
		"bxready2:block.list",
		".default",
		$arBlockParams,
		false,
		array('HIDE_ICONS'=>'Y')
	);

if ($arParams['INDEX_SHOW_SEO'] == "Y"){
	$APPLICATION->IncludeComponent(
		"bitrix:main.include",
		"named_area",
		array(
			"COMPONENT_TEMPLATE" => "named_area",
			"INCLUDE_PTITLE" => GetMessage('SEO_TEXT_INDEX'),
			"AREA_FILE_SHOW" => "sect",
			"AREA_FILE_SUFFIX" => "bxr_index",
			"AREA_FILE_RECURSIVE" => "N",
			"EDIT_TEMPLATE" => ""
		),
		$component
	//array('HIDE_ICONS' => 'Y')
	);
};




if ($arParams['BXR_ADV_BOTTOM_CONTENT_SECTION'] != "none"){?>
	<div class="bxr-catalog-bottom-b">
		<?$APPLICATION->IncludeComponent("bxready2:abmanager",
			$arParams['BXR_ADV_BOTTOM_CONTENT_SECTION'],
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
		);?>
	</div>
<?}



?>
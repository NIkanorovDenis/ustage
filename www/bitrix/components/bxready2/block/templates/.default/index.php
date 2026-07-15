<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Loader;

$this->setFrameMode(true);
if ($arParams['BXR_ADV_TOP_CONTENT_INDEX'] != "none"){?>
	<div class="bxr-catalog-top-b">
		<?$APPLICATION->IncludeComponent("bxready2:abmanager",
			$arParams['BXR_ADV_TOP_CONTENT_INDEX'],
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

$arDesc = explode("#STEXT#", $arCurIblock["DESCRIPTION"]);
$sectionDesc = $arCurIblock["DESCRIPTION"];
if (strlen($sectionDesc)>0 && $arParams['INDEX_SHOW_IBLOCK_DESCRIPTION']):?>
	<div class="row">
		<div class="col-lg-12 bxr-section-desc">
			<?=$sectionDesc?>
			<div class="clearfix"></div>
		</div>
	</div>
<?endif;

$sectionFields = array('NAME', 'PICTURE', 'DETAIL_PICTURE');
if ($arParams['INDEX_SHOW_DESCRIPTION'] == "Y"){
	$sectionFields[] = "DESCRIPTION";
}

$indexTemplate = strlen($arParams["INDEX_PAGE_TYPE"]) > 0 ? $arParams["INDEX_PAGE_TYPE"] : "";

$APPLICATION->IncludeComponent(
	"bxready2:catalog.section.tree",
	$indexTemplate,
	Array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
		"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"ADD_SECTIONS_CHAIN" => "N",
		"COUNT_ELEMENTS" => $arParams["INDEX_SHOW_COUNT"],
		"SECTION_FIELDS" => $sectionFields,		
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"SECTION_USER_FIELDS" => array(),
		"SHOW_PARENT_NAME" => "Y",
		"TOP_DEPTH" => $arParams["INDEX_MAX_LEVEL"],
		"VIEW_MODE" => "LIST",
		"BXREADY_ELEMENT_DRAW" => $arParams["INDEX_ELEMENT_DRAW"],
		"DETAIL_PAGE_URL_CAPTION" => $arParams["DETAIL_PAGE_URL_CAPTION"],
	),
	$component
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

if ($arParams['BXR_ADV_BOTTOM_CONTENT_INDEX'] != "none"){?>
	<div class="bxr-catalog-bottom-b">
		<?$APPLICATION->IncludeComponent("bxready2:abmanager",
			$arParams['BXR_ADV_BOTTOM_CONTENT_INDEX'],
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
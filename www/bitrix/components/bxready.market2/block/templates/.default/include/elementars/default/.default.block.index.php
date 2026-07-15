<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Loader;

if ($arParams['BXR_ADV_TOP_CONTENT_INDEX'] != "none") {
    $elementarArea = \Alexkova\Bxready2\Elementars::getArea('block','default.index.banner.top');
    if (strlen($elementarArea) > 0)
        include($elementarArea);
    else
        include('banner.top.php');

}

if ($arParams['IBLOCK_ID'] > 0) {
    $obCache = new CPHPCache();

    if ($obCache->InitCache($arParams['CACHE_TIME'], serialize(array($arParams['IBLOCK_ID'])), $APPLICATION->GetCurPage()))
        $arCurIblock = $obCache->GetVars();
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
                    $CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);
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
        $arCurIblock = array();
}

$arCurIblock["DESCRIPTION"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arCurIblock["DESCRIPTION"]);
$arDesc = explode("#STEXT#", $arCurIblock["DESCRIPTION"]);
$sectionDesc = $arDesc[0];
$seoText = $arDesc[1];

if (strlen($sectionDesc)>0 && $arParams['INDEX_SHOW_IBLOCK_DESCRIPTION']) {
	$includeAreaName = 'index.section.desc';
	include(__DIR__ . '/../include_handler.php');
}

$sectionFields = array('NAME', 'PICTURE', 'DETAIL_PICTURE');
if ($arParams['INDEX_SHOW_DESCRIPTION'] == "Y")
    $sectionFields[] = "DESCRIPTION";

$indexTemplate = strlen($arParams["INDEX_PAGE_TYPE"]) > 0 ? $arParams["INDEX_PAGE_TYPE"] : "";

$includeAreaName = 'index.section.tree';
include(__DIR__ . '/../include_handler.php');

if ($arParams['INDEX_SHOW_SEO'] == "Y") {
	$includeAreaName = 'index.section.seo';
	include(__DIR__ . '/../include_handler.php');

};

if ($arParams['BXR_ADV_BOTTOM_CONTENT_INDEX'] != "none") {
	$includeAreaName = 'index.banner.bottom';
	include(__DIR__ . '/../include_handler.php');
}?>
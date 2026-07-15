<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Loader,
    Bitrix\Iblock\InheritedProperty;
$this->setFrameMode(true);

if ($arParams['INDEX_SHOW_IBLOCK_DESCRIPTION'] == "Y") {
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
            };
            $obCache->EndDataCache($arCurIblock);
        }

        if (!isset($arCurIblock))
            $arCurIblock = array();
    }

    $sectionDesc = $arCurIblock["DESCRIPTION"];
    if (strlen($sectionDesc)>0) {

		$includeAreaName = 'index.section.desc';
		include(__DIR__ . '/../include_handler.php');
    }
}

if ($arParams['BXR_ADV_TOP_CONTENT_SECTION'] != "none") {

	$includeAreaName = 'banner.top';
	include(__DIR__ . '/../include_handler.php');
}

$elementarArea = \Alexkova\Bxready2\Elementars::getArea('block','list.section.block.list');
if (strlen($elementarArea) > 0)
    include($elementarArea);
else
    include('index.block.list.php');

if ($arParams['INDEX_SHOW_SEO'] == "Y") {
	$includeAreaName = 'index.section.seo';
	include(__DIR__ . '/../include_handler.php');
};

if ($arParams['BXR_ADV_BOTTOM_CONTENT_SECTION'] != "none") {
	$includeAreaName = 'banner.bottom';
	include(__DIR__ . '/../include_handler.php');;
}?>
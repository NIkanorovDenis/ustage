<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Loader;

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

$includeAreaName = 'section.section.list';
include(__DIR__ . '/../include_handler.php');

$includeAreaName = 'section.block.list';
include(__DIR__ . '/../include_handler.php');

if ($arParams['INDEX_SHOW_SEO'] == "Y") {

	$includeAreaName = 'index.section.seo';
	include(__DIR__ . '/../include_handler.php');

};
?>
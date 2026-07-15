<?if ($arParams['BXR_ADV_TOP_CONTENT_SECTION'] != "none"){
    $includeAreaName = 'section.banner.top';
	include(__DIR__ . '/../include_handler.php');
}

$showDesc = ($arParams["LIST_BXR_SHOW_DESCRIPTION"] == "Y") ? true : false;
$showSeo = ($arParams["LIST_BXR_SHOW_SEO"] == "Y") ? true : false;

$arFilter = array(
    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
    "ACTIVE" => "Y",
    "GLOBAL_ACTIVE" => "Y",
);

if (0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
    $arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"])
    $arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];

$arSelect = array("ID", "NAME", "DESCRIPTION");
$arSelect = array();

$obCache = new CPHPCache();
if ($obCache->InitCache($arParams['CACHE_TIME'], serialize($arFilter), $APPLICATION->GetCurUri()))
    $arCurSection = $obCache->GetVars();
elseif ($obCache->StartDataCache())
{
    $arCurSection = array();
    if (CModule::includeModule("iblock"))
    {
        $dbRes = CIBlockSection::GetList(array(), $arFilter, false, $arSelect);
        if(defined("BX_COMP_MANAGED_CACHE"))
        {
            global $CACHE_MANAGER;
            $CACHE_MANAGER->StartTagCache($APPLICATION->GetCurUri());
            if ($arCurSection = $dbRes->Fetch())
                $CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);
            $CACHE_MANAGER->EndTagCache();
        }
        else
        {
            if(!$arCurSection = $dbRes->Fetch())
                $arCurSection = array();
        }
    };
    $obCache->EndDataCache($arCurSection);
}

if (!isset($arCurSection))
    $arCurSection = array();

if (intval($arCurSection["ID"]) <= 0) {
    if ($arParams['SET_STATUS_404'] == 'Y') {
        CHTTP::SetStatus("404 Not Found");

        if ($arParams['SHOW_404'] == "Y") {

            if (strlen($arParams['FILE_404']) > 0)
                $file404 = $arParams['FILE_404'];
            else
                $file404 = '/404.php';

            include($_SERVER['DOCUMENT_ROOT'] . $file404);

        } else {
            if (strlen($arParams['MESSAGE_404'])>0) { ?>
                <div class="bxr-404-message">
                    <?=$arParams['MESSAGE_404']?>
                </div>
            <?}
        }
    }
} else {?>
    <div class="row bxr-section">
        <div class="col-lg-12 bxr-section-desc">
            <?
            $arCurSection["DESCRIPTION"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arCurSection["DESCRIPTION"]);
            $arDesc = explode("#STEXT#", $arCurSection["DESCRIPTION"]);
            $sectionDesc = $arDesc[0];
            $seoText = $arDesc[1];
            if (strlen($sectionDesc)>0 && $showDesc) {
                $includeAreaName = 'section.section.list';
				include(__DIR__ . '/../include_handler.php');
            }

            ?>

        </div>
    </div>
    <?

	$includeAreaName = 'section.block.list';
	include(__DIR__ . '/../include_handler.php');

    if (strlen($seoText) > 0 && $showSeo) {
		$includeAreaName = 'section.section.seo';
		include(__DIR__ . '/../include_handler.php');
    }

    $ipropValues = new Bitrix\Iblock\InheritedProperty\SectionValues($arParams["IBLOCK_ID"], $arCurSection["ID"]);
    $Path = $ipropValues->getValues();

    if($arParams["LIST_SET_TITLE"] == "Y")
    {

        if (strlen($Path['SECTION_PAGE_TITLE'])>0){
            $APPLICATION->SetTitle($Path['SECTION_PAGE_TITLE']);
        }
        elseif(isset($arCurSection["NAME"])){
            $APPLICATION->SetTitle($arCurSection["NAME"], true);
        }
    }

    if ($arParams["LIST_SET_BROWSER_TITLE"] === 'Y')
    {
        if (strlen($Path['SECTION_META_TITLE'])>0 )
            $APPLICATION->SetPageProperty("title", $Path['SECTION_META_TITLE']);
    }

    if ($arParams["LIST_SET_META_KEYWORDS"] === 'Y')
    {
        if (strlen($Path['SECTION_META_KEYWORDS'])>0 )
            $APPLICATION->SetPageProperty("keywords", $Path['SECTION_META_KEYWORDS']);
    }

    if ($arParams["LIST_SET_META_DESCRIPTION"] === 'Y')
    {
        if (strlen($Path['SECTION_META_DESCRIPTION'])>0 )
            $APPLICATION->SetPageProperty("description", $Path['SECTION_META_DESCRIPTION']);
    }
}

if ($arParams['BXR_ADV_BOTTOM_CONTENT_SECTION'] != "none") {
	$includeAreaName = 'banner.bottom';
	include(__DIR__ . '/../include_handler.php');
}?>
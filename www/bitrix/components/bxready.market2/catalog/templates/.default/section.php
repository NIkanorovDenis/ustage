<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;
$this->setFrameMode(true);
//$this->addExternalCss("/bitrix/css/main/bootstrap.css");

//include('prepare.params.php');

if (!isset($arParams['FILTER_VIEW_MODE']) || (string)$arParams['FILTER_VIEW_MODE'] == '')
	$arParams['FILTER_VIEW_MODE'] = 'VERTICAL';
$arParams['USE_FILTER'] = (isset($arParams['USE_FILTER']) && $arParams['USE_FILTER'] == 'Y' ? 'Y' : 'N');

$arParams['LEFTMENU_SECTION_SHOW'] = (!isset($arParams['LEFTMENU_SECTION_SHOW'])) ? "Y" : $arParams['LEFTMENU_SECTION_SHOW'];
if (!isset($arParams["SIDEBAR_SECTION_SHOW"])) $arParams["SIDEBAR_SECTION_SHOW"] = 'Y';

$isMenu = ($arParams['SHOW_LEFT_MENU'] == 'Y');
$isVerticalFilter = ('Y' == $arParams['USE_FILTER'] && $arParams["FILTER_VIEW_MODE"] == "VERTICAL");
$isSidebar = $arParams["SIDEBAR_SECTION_SHOW"] == "Y";
$isAdditionalSideBar = (isset($arParams["SIDEBAR_PATH"]) && !empty($arParams["SIDEBAR_PATH"]));
$isFilter = ($arParams['USE_FILTER'] == 'Y');
$isSeoFilter = false;

$bxmarket = \Alexkova\Market2\Bxmarket::getInstance();
$bxmarket->setCoreData(array(
    'left_column' => $arParams["SIDEBAR_SECTION_SHOW"],
    'left_menu' => $arParams["LEFTMENU_SECTION_SHOW"],
));

$arFilter = array(
    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
    /*"ACTIVE" => "Y",
    "GLOBAL_ACTIVE" => "Y",*/
);
if (0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
    $arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"])
    $arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];

$obCache = new CPHPCache();
if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog"))
{
    $arCurSection = $obCache->GetVars();
}
elseif ($obCache->StartDataCache())
{
    $arCurSection = array();
    if (Loader::includeModule("iblock"))
    {
        if($arParams["INCLUDE_SUBSECTIONS"]=="N")
            $arFilter["ELEMENT_SUBSECTIONS"] = "N";
        //$arFilter["CNT_ACTIVE"] = "Y";
        $dbRes = CIBlockSection::GetList(array(), $arFilter, true, array("ID", "NAME", "DESCRIPTION", "IBLOCK_SECTION_ID"));
        if(defined("BX_COMP_MANAGED_CACHE"))
        {
            global $CACHE_MANAGER;
            $CACHE_MANAGER->StartTagCache("/iblock/catalog");
            if ($arCurSection = $dbRes->Fetch())
                $CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);
            $CACHE_MANAGER->EndTagCache();
        }
        else
        {
            if(!$arCurSection = $dbRes->Fetch())
                $arCurSection = array();
        }
		if ($arCurSection['ID'] > 0) {
			$seoData = \Alexkova\Market2\Seo::isSEOSection($arParams["IBLOCK_ID"], $arCurSection['ID']);
			if (is_array($seoData)) {
				$arCurSection['SEO_DATA'] = $seoData;
			}
			unset($seoData);
		}
    }
    $obCache->EndDataCache($arCurSection);
}

if (!isset($arCurSection))
        $arCurSection = array();

$filterSectionId = $arCurSection['IBLOCK_SECTION_ID'] > 0 && is_array($arCurSection['SEO_DATA']['DESCR']) ? $arCurSection['IBLOCK_SECTION_ID'] : $arCurSection['ID'];
if ($arCurSection['SEO_DATA']['DEST'] == "F") {
	global ${$arParams["FILTER_NAME"]};
	${$arParams["FILTER_NAME"]}['SECTION_ID'] = $filterSectionId;
}

if ($arCurSection["ELEMENT_CNT"]>0 || is_array($arCurSection['SEO_DATA']['DESCR']))
    $showElementsFilters = true;
else
    $showElementsFilters = false;
?>
<?
if (isset($arCurSection['SEO_DATA']) && $arCurSection['SEO_DATA']['DEST'] == 'F'){
	foreach ($arCurSection['SEO_DATA']['ADD_GET'] as $cell=>$val) {
		$_GET[$filterName.$cell] = $val;
	}
	$_GET['set_filter'] = 'Y';
}

if (isset($arCurSection['SEO_DATA']) && is_array($arCurSection['SEO_DATA']['filter'])){
	global ${$arParams['FILTER_NAME']};
	if (!is_array(${$arParams['FILTER_NAME']})) {
		${$arParams['FILTER_NAME']} = array();
	}
	${$arParams['FILTER_NAME']} = array_merge(
		${$arParams['FILTER_NAME']},
		$arCurSection['SEO_DATA']['filter']
	);
}

if ((!$isSidebar && ( $arParams['LEFTMENU_SECTION_SHOW']=="Y" || $arParams['LEFTMENU_SECTION_SHOW']=="T")) || ($isSidebar && $arParams['LEFTMENU_SECTION_SHOW']=="T")){
    include_once($_SERVER["DOCUMENT_ROOT"]."/".$this->GetFolder()."/top_left_menu.php");
}

if ($isVerticalFilter)
	include($_SERVER["DOCUMENT_ROOT"]."/".$this->GetFolder()."/section_vertical.php");
else
	include($_SERVER["DOCUMENT_ROOT"]."/".$this->GetFolder()."/section_horizontal.php");
?>

<?
$content_data = $export_data = array(
	'content_type' => 'catalog_section',
	'content_item' => $arCurSection['ID'],
	'content_iblock' => $arParams["IBLOCK_ID"],
);


$marketRegistry = \Alexkova\Market2\Bxmarket::getInstance();
$marketRegistry->setContentData($content_data);
$marketRegistry->setExportData($export_data);

$marketRegistry->setAjaxContent();
?>

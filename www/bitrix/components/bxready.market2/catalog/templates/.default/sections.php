<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;
$this->setFrameMode(true);
$elementLibrary = 'section.horizontal.v2';

$arParams['LEFTMENU_INDEX_SHOW'] = (!isset($arParams['LEFTMENU_INDEX_SHOW'])) ? "Y" : $arParams['LEFTMENU_INDEX_SHOW'];
if (!isset($arParams["SIDEBAR_INDEX_SHOW"])) $arParams["SIDEBAR_INDEX_SHOW"] = 'Y';

$isSidebar = $arParams["SIDEBAR_INDEX_SHOW"] == "Y";
$isAdditionalSideBar = (isset($arParams["SIDEBAR_PATH"]) && !empty($arParams["SIDEBAR_PATH"]));

$bxmarket = \Alexkova\Market2\Bxmarket::getInstance();
$bxmarket->setCoreData(array(
    'left_column' => $arParams["SIDEBAR_INDEX_SHOW"],
    'left_menu' => $arParams["LEFTMENU_INDEX_SHOW"],
));

?>
<?if ((!$isSidebar && ( $arParams['LEFTMENU_INDEX_SHOW']=="Y" || $arParams['LEFTMENU_INDEX_SHOW']=="T")) || ($isSidebar && $arParams['LEFTMENU_INDEX_SHOW']=="T")){
    include_once($_SERVER["DOCUMENT_ROOT"]."/".$this->GetFolder()."/top_left_menu.php");
}?>
<div class="row">
<?if ($isSidebar): ?>
    <?
        $cl = " col-xl-2 col-lg-3 col-md-3 col-sm-12 col-xs-12" ;
        
        if(isset($arParams['FILTER_HIDE_ON_MOBILE']) && $arParams['FILTER_HIDE_ON_MOBILE'] === 'Y')
            $cl .=  ' hidden-sm hidden-xs ';
        
        if($bxmarket->getCoreData("right_column")=="Y")
            $cl .= " bxr-col-20 ";

    ?>
    <div class="<?=$cl;?>">
        <div class="bx-sidebar-block">
            <?if ($arParams['LEFTMENU_INDEX_SHOW']=="Y"):
                include_once($_SERVER["DOCUMENT_ROOT"]."/".$this->GetFolder()."/top_left_menu.php");                
            endif;?>
            <?
            if ($isAdditionalSideBar):
                $APPLICATION->IncludeComponent(
                    "bxready.market2:main.include",
                    "",
                    Array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => $arParams["SIDEBAR_PATH"],
                        "AREA_FILE_RECURSIVE" => "N",
                        "EDIT_MODE" => "html",
                    ),
                    false,
                    Array('HIDE_ICONS' => 'Y')
                );
            endif?>   
        </div>
    </div>
<?endif?>

<?
if ($arParams['IBLOCK_ID']>0){
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

$arDesc = explode("#STEXT#", $arCurIblock["DESCRIPTION"]);
$sectionDesc = $arDesc[0];
$seoText = $arDesc[1];
//$sectionDesc = $arCurIblock["DESCRIPTION"];

$sectionFields = array('NAME', 'PICTURE', 'DETAIL_PICTURE');
if ($arParams['INDEX_SHOW_DESCRIPTION'] == "Y")
    $sectionFields[] = "DESCRIPTION";
?>
<?
    $bxmarket = \Alexkova\Market2\Bxmarket::getInstance();

    $cl = " col-xs-12 ";
    
    if($isSidebar)
        $cl .= " col-xl-10 col-lg-9 col-md-9 col-sm-12 ";
    
    if($bxmarket->getCoreData("right_column")=="Y")
        $cl .= " bxr-col-80 ";
?>
<div class="<?=$cl;?>">
    <div class="row bxr-list">
        <div class="col-xs-12 bxr-container-catalog-sections">
<?$APPLICATION->IncludeComponent(
	"bxready2:block.list", 
	".default", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BXREADY_COLLECTION_DRAW" => "standart",
		"BXREADY_ELEMENT_ADDCLASS" => "",
		"BXREADY_ELEMENT_DRAW" => "trigger.flat.horizontal.v2",
		"BXREADY_ELEMENT_EXT_PARAMS" => "arrExtParams",
		"BXREADY_LIST_BOOTSTRAP_GRID_STYLE" => "12",
		"BXREADY_LIST_HIDE_MOBILE_SLIDER_ARROWS" => "Y",
		"BXREADY_LIST_HIDE_SLIDER_ARROWS" => "Y",
		"BXREADY_LIST_LG_CNT" => "3",
		"BXREADY_LIST_MD_CNT" => "6",
		"BXREADY_LIST_PAGE_BLOCK_TITLE" => "",
		"BXREADY_LIST_PAGE_BLOCK_TITLE_GLYPHICON" => "",
		"BXREADY_LIST_SLIDER" => "N",
		"BXREADY_LIST_SLIDER_AUTOSCROLL" => "N",
		"BXREADY_LIST_SLIDER_MARKERS" => "N",
		"BXREADY_LIST_SM_CNT" => "12",
		"BXREADY_LIST_TYPES" => "elements",
		"BXREADY_LIST_VERTICAL_SLIDER_MODE" => "N",
		"BXREADY_LIST_XLG_CNT" => "3",
		"BXREADY_LIST_XS_CNT" => "12",
		"BXREADY_SECTION_DRAW" => "other",
		"BXREADY_USER_TYPES" => "N",
		"BXREADY_USE_ELEMENTCLASS" => "Y",
		"BXREADY_VERTICAL_ALIGN" => "Y",
		"BXR_PRST_USE_HREF" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "NAME",
			1 => "",
		),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "2",
		"IBLOCK_TYPE" => "content",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "4",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => GetMessage("TITLE_5"),
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "BXR_URL",
			1 => "BXR_GLYPH",
			2 => "",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?>



            <div class="bxr-cloud-all">
                <h1 ><?$APPLICATION->ShowTitle(false)?></h1>
                <?if (strlen($sectionDesc)>0 && $arParams['INDEX_SHOW_IBLOCK_DESCRIPTION'] == "Y"):?>
                    <div class="row">
                        <div class="col-lg-12 bxr-section-desc">
                            <?=\Alexkova\Market2\Bxmarket::replaceRegionMegaTags($sectionDesc)?>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                <?endif;?>
				<?
				$elementarArea = \Alexkova\Bxready2\Elementars::getArea('catalog','catalog.sections');
				if (strlen($elementarArea) > 0)
					include($elementarArea);
				else
					include('include/elementars/catalog.sections.php');
				?>
                <?if (strlen($seoText)>0 && $arParams['INDEX_SHOW_IBLOCK_DESCRIPTION'] == "Y"):?>
                    <div class="row">
                        <div class="col-lg-12 bxr-section-seo">
                            <?=\Alexkova\Market2\Bxmarket::replaceRegionMegaTags($seoText)?>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                <?endif;?>
            </div>
        </div>
    </div>
</div></div>
<?
$content_data = $export_data = array(
	'content_type' => 'catalog_index',
	'content_iblock' => $arParams["IBLOCK_ID"],
);


$marketRegistry = \Alexkova\Market2\Bxmarket::getInstance();
$marketRegistry->setContentData($content_data);
$marketRegistry->setExportData($export_data);

$marketRegistry->setAjaxContent();
?>
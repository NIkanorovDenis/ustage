<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Loader,
	Bitrix\Iblock\InheritedProperty;
$this->setFrameMode(true)?>
<?
//$showDesc = in_array("DESCRIPTION", $arParams["LIST_SECTION_FIELDS"]) ? true : false;
$showDesc = ($arParams["LIST_BXR_SHOW_DESCRIPTION"] == "Y") ? true : false;
//$showPicture = in_array("PICTURE", $arParams["LIST_SECTION_FIELDS"]) ? true : false;
$showSeo = ($arParams["LIST_BXR_SHOW_SEO"] == "Y") ? true : false;

$arFilter = array(
	"IBLOCK_ID" => $arParams["IBLOCK_ID"],
	"ACTIVE" => "Y",
	"GLOBAL_ACTIVE" => "Y",
);
if (0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
{
	$arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
}
elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"])
{
	$arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];
}

$arSelect = array("ID", "NAME", "DESCRIPTION");
$arSelect = array();

$obCache = new CPHPCache();
if ($obCache->InitCache($arParams['CACHE_TIME'], serialize($arFilter), $APPLICATION->GetCurUri()))
{
    $arCurSection = $obCache->GetVars();
}
elseif ($obCache->StartDataCache())
{
    $arCurSection = array();
    if (Loader::includeModule("iblock"))
    {
        $dbRes = CIBlockSection::GetList(array(), $arFilter, false, $arSelect);            
        if(defined("BX_COMP_MANAGED_CACHE"))
        {
            global $CACHE_MANAGER;
            $CACHE_MANAGER->StartTagCache($APPLICATION->GetCurUri());
            if ($arCurSection = $dbRes->Fetch())
            {
                $CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);
            }
            $CACHE_MANAGER->EndTagCache();
        }
        else
        {
            if(!$arCurSection = $dbRes->Fetch())
                $arCurSection = array();
        }
    }
    $obCache->EndDataCache($arCurSection);
}

if (!isset($arCurSection))
{
    $arCurSection = array();

}


if (intval($arCurSection["ID"])<=0){
	if ($arParams['SET_STATUS_404'] == 'Y'){
		CHTTP::SetStatus("404 Not Found");

		if ($arParams['SHOW_404'] == "Y"){

			if (strlen($arParams['FILE_404'])>0){
				$file404 = $arParams['FILE_404'];
			}else{
				$file404 = '/404.php';
			}

			include($_SERVER['DOCUMENT_ROOT'].$file404);

		}else{
			if (strlen($arParams['MESSAGE_404'])>0){?>

			<div class="bxr-404-message">
				<?=$arParams['MESSAGE_404']?>
			</div>

			<?}
		}
	}
}else{?>
    <div class="row">
    <?
    $showLeft = false;
    $showSmartFilter = true;
    if(isset($arParams["SIDEBAR_SECTION_SHOW"]) && ($arParams["SIDEBAR_SECTION_SHOW"]=="LEFT" || $arParams["SIDEBAR_SECTION_SHOW"]=="RIGHT")):?>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12<?if($arParams["SIDEBAR_SECTION_SHOW"]=="RIGHT") { echo " pull-right "; $showLeft = true;}?>">
            <?include($_SERVER["DOCUMENT_ROOT"]."/".$this->GetFolder()."/siderbar.php");?>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
    <?else:?>
        <div class="col-xs-12">
    <?endif;?>
    <?if ($arParams['BXR_ADV_TOP_CONTENT_SECTION'] != "none"){?>
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
    <?}?>

	<div class="row bxr-section">
		<div class="col-lg-12 bxr-section-desc">
	<?

	$arDesc = explode("#STEXT#", $arCurSection["DESCRIPTION"]);
	$sectionDesc = $arDesc[0];
	$seoText = $arDesc[1];
	if (strlen($sectionDesc)>0 && $showDesc):?>


				<?=$sectionDesc?>
				<div class="clearfix"></div>


	<?endif;

$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list", 
	"list",
	array(
		"ADD_SECTIONS_CHAIN" => "N",
		"CACHE_GROUPS" => $arParams['CACHE_GROUPS'],
		"CACHE_TIME" => $arParams['CACHE_TIME'],
		"CACHE_TYPE" => $arParams['CACHE_TYPE'],
		"COUNT_ELEMENTS" => $arParams['LIST_COUNT_ELEMENTS'],
		"IBLOCK_ID" => $arParams['IBLOCK_ID'],
		"IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
		"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		"SECTION_FIELDS" => array("NAME","PICTURE",""),
		"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"SECTION_USER_FIELDS" => array(),
		"SHOW_PARENT_NAME" => "N",
		"TOP_DEPTH" => "1",
		"VIEW_MODE" => "LIST"
	),
	$component
);?>

	</div></div>
<?
    if(isset($arParams["FILTER_VIEW_MODE"]) && $arParams["FILTER_VIEW_MODE"]=="HORIZONTAL")
        include($_SERVER["DOCUMENT_ROOT"]."/".$this->GetFolder()."/smart_filter.php");
?>
<?if(isset($arParams["USE_SORT_PANEL"]) && $arParams["USE_SORT_PANEL"]=="Y"):?>
    <?
        $APPLICATION->IncludeComponent(
        "alexkova.business:sort.panel", 
        "lite", 
        array(
                "COMPONENT_TEMPLATE" => ".default",
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                "THEME" =>  $arParams["SORT_PANEL_THEME"],
                "ELEMENT_SORT_FIELD" => array(),//$arParams["ELEMENT_SORT_FIELD"],
                /*"PAGE_ELEMENT_COUNT_SHOW" => $arParams["PAGE_ELEMENT_COUNT_SHOW"],
                "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
                "PAGE_ELEMENT_COUNT_LIST" => $arParams["PAGE_ELEMENT_COUNT_LIST"],*/
                "CATALOG_VIEW_SHOW" => $arParams["SORT_PANEL_CATALOG_VIEW_SHOW"],
                "DEFAULT_CATALOG_VIEW" => $arParams["SORT_PANEL_DEFAULT_CATALOG_VIEW"],
                "CATALOG_DEFAULT_SORT" => $arParams["CATALOG_DEFAULT_SORT"],
        ),
        false,
        array(
                "HIDE_ICONS" => "Y"
        )
    );?>
<?
    global $arSortGlobal;
    $sort = $arSortGlobal["sort"];
    $sort_order = $arSortGlobal["sort_order"];
    $view = $arSortGlobal["view"];
    $sort2 = "SORT";
    $sort_order2 = "ASC";
?>
<?else:
    $sort = (isset($arParams["ELEMENT_SORT_FIELD"]))? $arParams["ELEMENT_SORT_FIELD"] : "NAME";
    $sort_order = (isset($arParams["ELEMENT_SORT_ORDER"]))? $arParams["ELEMENT_SORT_ORDER"] : "ASC";
    $sort2 = (isset($arParams["ELEMENT_SORT_FIELD2"]))? $arParams["ELEMENT_SORT_FIELD2"] : "SORT";
    $sort_order2 = (isset($arParams["ELEMENT_SORT_ORDER2"]))? $arParams["ELEMENT_SORT_ORDER2"] : "ASC";
endif;?>
<?
    if(in_array($view,array('.default','list','table'))){
        switch ($view){
            case "list":
                $arParams["BXREADY_USER_TYPES_LISTPAGE"] = "N";
                $arParams["BXREADY_ELEMENT_DRAW_LISTPAGE"] = "ecommerce.list.lite.v1";
                $arParams["BXREADY_LIST_LG_CNT_LISTPAGE"] = 12;
                $arParams["BXREADY_LIST_MD_CNT_LISTPAGE"] = 12;
                $arParams["BXREADY_LIST_SM_CNT_LISTPAGE"] = 12;
                $arParams["BXREADY_LIST_XS_CNT_LISTPAGE"] = 12;
                break;
            case "table":
                $arParams["BXREADY_USER_TYPES_LISTPAGE"] = "N";
                $arParams["BXREADY_ELEMENT_DRAW_LISTPAGE"] = "ecommerce.table.lite.v1";
                $arParams["BXREADY_LIST_LG_CNT_LISTPAGE"] = 12;
                $arParams["BXREADY_LIST_MD_CNT_LISTPAGE"] = 12;
                $arParams["BXREADY_LIST_SM_CNT_LISTPAGE"] = 12;
                $arParams["BXREADY_LIST_XS_CNT_LISTPAGE"] = 12;
                break;
        }
    }
    else{
            $elementLibrary = $elementBlock;
            $arResponsiveParams = $arDefaultResponsive;
    }
?>
<?
	$APPLICATION->IncludeComponent(
		"bxready2:block.list",
		".default",
		array(
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
                        "BXREADY_LIST_MARKER_TYPE" => (isset($arParams["BXREADY_LIST_MARKER_TYPE"])) ? $arParams["BXREADY_LIST_MARKER_TYPE"] : "circle.vertical.small",
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
			"FILTER_NAME" => $arParams["FILTER_NAME"],
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
			"PARENT_SECTION" => $arCurSection["ID"],
			"PARENT_SECTION_CODE" => "",
			"PREVIEW_TRUNCATE_LEN" => "",
			"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],

			"SET_BROWSER_TITLE" => "Y",
			"SET_META_DESCRIPTION" => "Y",
			"SET_META_KEYWORDS" => "Y",

			"MESSAGE_404" => $arParams["MESSAGE_404"],
			"SET_STATUS_404" => $arParams["SET_STATUS_404"],
			"SHOW_404" => $arParams["SHOW_404"],
			"FILE_404" => $arParams["FILE_404"],

			"SET_TITLE" => "Y",

			"SORT_BY1" => $sort,
			"SORT_BY2" => $sort2,
			"SORT_ORDER1" => $sort_order,
			"SORT_ORDER2" => $sort_order2,

			"BXREADY_ELEMENT_ADDCLASS" => $arParams["BXREADY_ELEMENT_ADDCLASS_LISTPAGE"],
			"BXREADY_USE_ELEMENTCLASS" => $arParams["BXREADY_USE_ELEMENTCLASS_LISTPAGE"],
			"BXREADY_ELEMENT_EXT_PARAMS" => $arParams["BXREADY_ELEMENT_EXT_PARAMS_LISTPAGE"],
		),
		false,
		array('HIDE_ICONS'=>'Y')
	);

	if (strlen($seoText)>0 && $showSeo):?>
		<div class="row">
			<div class="col-lg-12 tb20">
				<?=$seoText?>
			</div>
		</div>
	<?endif;

	$ipropValues = new Bitrix\Iblock\InheritedProperty\SectionValues($arParams["IBLOCK_ID"], $arCurSection["ID"]);
	$Path = $ipropValues->getValues();

	if($arParams["LIST_SET_TITLE"] == "Y")
	{
		$pageTitle =  strlen($Path['SECTION_PAGE_TITLE'])>0 ? $Path['SECTION_PAGE_TITLE'] : $Path['ELEMENT_PAGE_TITLE'];
		if ($pageTitle != ""){
			//$APPLICATION->AddChainItem($pageTitle,"");
			$APPLICATION->SetTitle($pageTitle);
		}
		elseif(isset($arCurSection["NAME"])){
			$APPLICATION->SetTitle($arCurSection["NAME"], true);
			//$APPLICATION->AddChainItem($arCurSection["NAME"],"");
		}

	}

	if ($arParams["LIST_SET_BROWSER_TITLE"] === 'Y')
	{
		$browserTitle = strlen($Path['SECTION_META_TITLE'])>0 ? $Path['SECTION_META_TITLE'] : $Path['ELEMENT_META_TITLE'];
		if ($browserTitle != "")
			$APPLICATION->SetPageProperty("title", $browserTitle);
	}

	if ($arParams["LIST_SET_META_KEYWORDS"] === 'Y')
	{
		$metaKeywords = strlen($Path['SECTION_META_KEYWORDS'])>0 ? $Path['SECTION_META_KEYWORDS'] : $Path['ELEMENT_META_KEYWORDS'];
		if ($metaKeywords != "")
			$APPLICATION->SetPageProperty("keywords", $metaKeywords);
	}

	if ($arParams["LIST_SET_META_DESCRIPTION"] === 'Y')
	{
		$metaDescription = strlen($Path['SECTION_META_DESCRIPTION'])>0 ? $Path['SECTION_META_DESCRIPTION'] : $Path['ELEMENT_META_DESCRIPTION'];
		if ($metaDescription != "")
			$APPLICATION->SetPageProperty("description", $metaDescription, $arTitleOptions);
	}

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
    <?}?>
    </div></div>
<?}?>
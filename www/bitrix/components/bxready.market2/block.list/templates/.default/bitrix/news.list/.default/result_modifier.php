<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


$arResult["DESCRIPTION"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["DESCRIPTION"]);
$arResult["~DESCRIPTION"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["~DESCRIPTION"]);

if(isset($arResult["ITEMS"]) && is_array($arResult["ITEMS"])) {
    foreach ($arResult["ITEMS"] as $k => $v) {
        if(isset($v["IPROPERTY_VALUES"]) && is_array($v["IPROPERTY_VALUES"])) {
            $arResult["ITEMS"][$k]["IPROPERTY_VALUES"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["ITEMS"][$k]["IPROPERTY_VALUES"]);
        }
        $arResult["ITEMS"][$k]["PREVIEW_TEXT"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["ITEMS"][$k]["PREVIEW_TEXT"]);
        $arResult["ITEMS"][$k]["~PREVIEW_TEXT"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["ITEMS"][$k]["~PREVIEW_TEXT"]);
        $arResult["ITEMS"][$k]["DETAIL_TEXT"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["ITEMS"][$k]["DETAIL_TEXT"]);
        $arResult["ITEMS"][$k]["~DETAIL_TEXT"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["ITEMS"][$k]["~DETAIL_TEXT"]);
    }
}

if(isset($arResult["SECTION"]["PATH"]) && is_array($arResult["SECTION"]["PATH"])) {
    foreach ($arResult["SECTION"]["PATH"] as $k => $v) {
        if(isset($v["IPROPERTY_VALUES"]) && is_array($v["IPROPERTY_VALUES"])) {
            $arResult["SECTION"]["PATH"][$k]["IPROPERTY_VALUES"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["SECTION"]["PATH"][$k]["IPROPERTY_VALUES"]);
        }
    }
}

$arResult["PREVIEW_TEXT"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["PREVIEW_TEXT"]);
$arResult["DETAIL_TEXT"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["DETAIL_TEXT"]);
$arResult["~PREVIEW_TEXT"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["~PREVIEW_TEXT"]);
$arResult["~DETAIL_TEXT"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["~DETAIL_TEXT"]);

foreach($arResult["ITEMS"] as &$val){
	if (is_array($val["PREVIEW_PICTURE"])){
                $val["PICTURE"] = $val["PREVIEW_PICTURE"]['SRC'];
	}elseif (!is_array($val["PREVIEW_PICTURE"]) && is_array($val["DETAIL_PICTURE"])){
                $val["PICTURE"] = $val["DETAIL_PICTURE"]['SRC'];
	}
}

$arResult["COUNT_ELS"] = count($arResult["ITEMS"]);

$this->__component->arResultCacheKeys[] = "COUNT_ELS";

$use_seo_pagenavigation = COption::GetOptionString("alexkova.market2", "use_seo_pagenavigation", "N");
if($use_seo_pagenavigation == "Y") {
	$cp = $this->__component;
	if (is_object($cp))
	{
		$dbresult =& $arResult["NAV_RESULT"];

		$cp->arResult['CURRENT_PAGE'] = $dbresult->NavPageNomer;
		$cp->arResult['MAX_PAGE'] = $dbresult->NavPageCount;
		$cp->arResult['NAV_NUM'] = $dbresult->NavNum;

		$cp->SetResultCacheKeys(array('CURRENT_PAGE','MAX_PAGE', 'SECTION_PAGE_URL', 'NAV_NUM'));

		$arResult['CURRENT_PAGE'] = $cp->arResult['CURRENT_PAGE'];
		$arResult['MAX_PAGE'] = $cp->arResult['MAX_PAGE'];
		$arResult['NAV_NUM'] = $cp->arResult['NAV_NUM'];
	}
}
?>
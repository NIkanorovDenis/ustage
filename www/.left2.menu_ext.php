<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;

$aMenuLinksExt = $APPLICATION->IncludeComponent(
    "bxready.market2:menu.sections",
    "",
    Array(
            "IS_SEF" => "Y",
            "ID" => &$_REQUEST["ID"],
            "IBLOCK_TYPE" => "catalog_new",
            "IBLOCK_ID" => "32",
            "SECTION_URL" => "",
            "DEPTH_LEVEL" => "5",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "360000",
            "SEF_BASE_URL" => "/catalog/",
            "SECTION_PAGE_URL" => "#SECTION_CODE#/",
            "DETAIL_PAGE_URL" => "#SECTION_CODE#/#ELEMENT_CODE#/"
    ),
    false,
    array("HIDE_ICONS" => "Y")
);

foreach ($aMenuLinksExt as $k => &$val){
    $val["DEPTH_LEVEL"] = $val["DEPTH_LEVEL"] ?? false;

    if($k!="PICTURE" && $val["DEPTH_LEVEL"])
        $val["DEPTH_LEVEL"]++;
}

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);    

?>
<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */
use Alexkova\Market2\Basket;
use Alexkova\Market2\Bxmarket;

foreach ($arResult['ITEMS'] as $num => $item){
    $item["NAME"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($item["NAME"]);
    $item["~NAME"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($item["~NAME"]);
    $item["PREVIEW_TEXT"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($item["PREVIEW_TEXT"]);
    $item["DETAIL_TEXT"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($item["DETAIL_TEXT"]);
    $item["~PREVIEW_TEXT"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($item["~PREVIEW_TEXT"]);
    $item["~DETAIL_TEXT"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($item["~DETAIL_TEXT"]);
    $item["IPROPERTY_VALUES"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($item["IPROPERTY_VALUES"]);
    $arResult['ITEMS'][$num] = $item;
}
?>
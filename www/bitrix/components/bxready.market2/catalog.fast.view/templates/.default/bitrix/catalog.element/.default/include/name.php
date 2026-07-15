<?
if(!empty($arResult["META_TAGS"]) && is_array($arResult["META_TAGS"])) { 
    $arResult["META_TAGS"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["META_TAGS"]); 
    $arResult["IPROPERTY_VALUES"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["IPROPERTY_VALUES"]); 
}

$arResult["PREVIEW_TEXT"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["PREVIEW_TEXT"]); 
$arResult["DETAIL_TEXT"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["DETAIL_TEXT"]); 
$arResult["~PREVIEW_TEXT"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["~PREVIEW_TEXT"]); 
$arResult["~DETAIL_TEXT"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["~DETAIL_TEXT"]); 

$name = ($arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]) ? $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"] : $arResult["NAME"];
?>
<a id ="<?=$arItemIDs['NAME']?>" class="bxr-name-wrap bxr-font-color-hover" href="<?=$arParams["DETAIL_PAGE_URL"]?>">
    <?=($arParams["OFFER_ID"] && $arResult["OFFERS"][$arParams["OFFER_ID"]]["NAME"]) ? $arResult["OFFERS"][$arParams["OFFER_ID"]]["NAME"] : $name?>
</a>
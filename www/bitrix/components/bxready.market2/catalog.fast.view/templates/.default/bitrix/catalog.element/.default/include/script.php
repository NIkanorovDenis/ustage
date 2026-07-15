<?
if(file_exists($_SERVER["DOCUMENT_ROOT"]."/local/js/alexkova.market2/bxr-sku-script.js")) {
	$elementDraw->setAdditionalFile("JS", "/local/js/alexkova.market2/bxr-sku-script.js", true);
}
else {
	$elementDraw->setAdditionalFile("JS", "/bitrix/js/alexkova.market2/bxr-sku-script.js", true);
}

$bxr_select_first_sku = COption::GetOptionString("alexkova.market2", "bxr_select_first_sku", "N");
$offerId = (intval($arParams["OFFER_ID"])) ? intval($arParams["OFFER_ID"]) : (($bxr_select_first_sku == "Y") ? $arResult["FIRST_SKU_SELECT"] : 0);

$arSkuJsParams = array(
    'isModal' => "Y",
    'productId' => $arResult['ID'],
    'productName' => CUtil::JSEscape($arResult['NAME']),
    'productLink' => $arParams['DETAIL_PAGE_URL'],
    'productImgLink' => $arResult['DETAIL_PICTURE']['SRC'],
    'offers' => $arResult["OFFERS"],
    'offerCnt' => count($arResult["OFFERS"]),
    'currentOfferId' => 0,
    'offersView' => $arResult["OFFERS_VIEW"],
    'skuProps' => $arResult["SKU_PROPS_LIST"],
    'useSkuUrl' => 'N',
    'hideOffersList' => 'Y',
    'nameId' => $arItemIDs['NAME'],
    'skuWrapId' => $arItemIDs['SKU_WRAP'],
    'pricesWrapId' => $arItemIDs['PRICES_WRAP'],
    'baketBtnWrapId' => $arItemIDs['BASKET_BTN_WRAP'],
    'availWrapId' => $arItemIDs['AVAIL_WRAP'],
    'sliderId' => $arItemIDs['SLIDER_CONT_ID'],
    'sliderNavId' => $arItemIDs['SLIDER_NAV_CONT_ID'],
    'setWrapId' => $arItemIDs['SET_WRAP'],
    'skuTabId' => $arItemIDs['SKU_TAB'],
    'filterSkuPhoto' => $arParams["FILTER_SKU_PHOTO"],
    'filterSkuPhotoFlex' => $arParams["FILTER_SKU_PHOTO_FLEX"],
    'detailPictureMode' => $arParams["DETAIL_PICTURE_MODE"],
    'changeTitle' => 'N',
    'msg' => array(
        'offersFound' => GetMessage("OFFERS_FOUND"),
        'offersFound1' => GetMessage("OFFERS_FOUND_1"),
        'offersFound2' => GetMessage("OFFERS_FOUND_2"),
        'offersFoundN' => GetMessage("OFFERS_FOUND_n"),
        'lookOffers' => GetMessage("LOOK_OFFERS"),
        'noOffersWithParams' => GetMessage("NO_OFFER_WITH_PARAMS"),
        'leaveRequest' => GetMessage("LEAVE_REQUEST"),
        'offerRequest' => GetMessage("OFFER_REQUEST_MSG"),
        'requestBtn' => GetMessage("REQUEST_BTN"),
    )
);
?>
<script>
    var <?='ob_'.$arItemIDs['OFFER_JS']?> = new JBXRCatalogSku(<?=CUtil::PhpToJSObject($arSkuJsParams)?>);
    
    paramsSKU = [];
    <?if(is_array($arResult["OFFERS"][$offerId]["PROPERTIES"])):?>
        <?foreach ($arResult["OFFERS"][$offerId]["PROPERTIES"] as $k => $params):?>
            <?if(!isset($arResult["SKU_PROPS_LIST"][$params["CODE"]])) continue;?>
            paramsSKU["<?=$k?>"] = [];
            paramsSKU["<?=$k?>"].id = "<?=$params["ID"]?>";
            paramsSKU["<?=$k?>"].val = "<?=$params["VALUE"]?>";
        <?endforeach;?>
    <?endif;?>
    <?if ($offerId) {?>
        <?='ob_'.$arItemIDs['OFFER_JS']?>.selectSKU("<?=$offerId?>", paramsSKU);
    <?}?>
       
    $(document).on('click', '.offers-cnt .popup-window-close-icon', function() {
        $('.offers-cnt').hide();
        return false;
    });
</script>

<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$bxr_use_links_sku = COption::GetOptionString("alexkova.market2", "bxr_use_links_sku", "N");
$usePriceCount = ($arParams["USE_PRICE_COUNT"] == "Y") ? true : false;
$params = array(
    "SHOW_MAX_QUANTITY" => $arParams["SHOW_MAX_QUANTITY"],
    "MESS_SHOW_MAX_QUANTITY" => $arParams["MESS_SHOW_MAX_QUANTITY"],
    "RELATIVE_QUANTITY_FACTOR" => $arParams["RELATIVE_QUANTITY_FACTOR"],
    "MESS_RELATIVE_QUANTITY_MANY" => $arParams["MESS_RELATIVE_QUANTITY_MANY"],
    "MESS_RELATIVE_QUANTITY_FEW" => $arParams["MESS_RELATIVE_QUANTITY_FEW"],
    "QUANTITY_IN_STOCK" => $arParams["QUANTITY_IN_STOCK"],
    "QUANTITY_OUT_STOCK" => $arParams["QUANTITY_OUT_STOCK"],
);
?>
<table id="<?=$arItemIDs["SKU_TAB"]?>">
    <tbody>
        <?  foreach ($arResult["OFFERS"] as $key => $offer) :?>
        <tr data-offer-id="<?=$offer["ID"]?>" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
            <td class="bxr-offer-img-td first hidden-xs">
                <?
                    if (is_array($offer["PREVIEW_PICTURE"])) {
                        $src = $offer["PREVIEW_PICTURE"]["SRC"];
                    } elseif (intval($offer["PREVIEW_PICTURE"]) > 0) {
                        $src = CFile::GetPath($offer["PREVIEW_PICTURE"]);
                    } elseif (is_array($offer["DETAIL_PICTURE"])) {
                        $src = $offer["DETAIL_PICTURE"]["SRC"];
                    } elseif (intval($offer["DETAIL_PICTURE"]) > 0) {
                        $src = CFile::GetPath($offer["DETAIL_PICTURE"]);
                    } elseif ($offer["MORE_PHOTO"][0]["SRC"] && $offer["MORE_PHOTO"][0]["TYPE"] != "NO_PHOTO") {
                        $src = $offer["MORE_PHOTO"][0]["SRC"];
                    } elseif ($arResult["MORE_PHOTO"][0]["SRC"] && $arParams["SHOW_MAIN_INSTEAD_NF_SKU"] == "Y") {
                        $src = $arResult["MORE_PHOTO"][0]["SRC"];
                    } else {
                        $src = '/bitrix/tools/bxready2/.default/no-image.png';
                    }?>                
                    <a href="<?=($arParams["SHOW_OFFER_PIC_BYCLICK"] == "Y")?$src:$offer["DETAIL_PAGE_URL"]?>"
			class="bxr-offer-img-in-list<?=($arParams["SHOW_OFFER_PIC_BYCLICK"] == "Y")?' fancybox-offer':''?>"
			<?=$offer["DETAIL_PAGE_URL"]?' itemprop="url"':''?> <?=($arParams["SHOW_OFFER_PIC_BYCLICK"] == "Y")?' data-fancybox="sku_list_gallery"':''?>
		    >
                        <img src="<?=$src?>" itemprop="image" alt="<?=$offer["NAME"]?>">
                    </a>
            </td>
            <td class="bxr-offer-name-td">
                <?if($bxr_use_links_sku == "Y"):?>
                    <a href="<?=$offer["DETAIL_PAGE_URL"];?>" itemprop="sku">
                        <?=$offer["NAME"]?>
                    </a>
                <?else:?>
                     <span itemprop="sku">
                        <?=$offer["NAME"]?>
                    </span>
                <?endif;?>   
                <div class="bxr-offer-display-props"><?=$offer["OFFER_PROPS_TEXT"]?></div>
            </td>
            <td class="bxr-offer-price-td">
                <div class="bxr-offer-price-wrap" data-item="<?=$offer["ID"]?>">
                    <?if (!empty($offer["PRICES"]) && !$usePriceCount) {?>
                        <div id="bxr-detail-offers-price-wrap-td-<?=$offer["ID"]?>" class="bxr-detail-offers-price-wrap-td">
                            <?foreach ($offer["PRICES"] as $priceName => $price) {
                                if ($showPriceName && count($offer["PRICES"]) > 1) {?>
                                    <div class="bxr-detail-price-name">
                                        <?=$arResult["CAT_PRICES"][$priceName]["TITLE"]?>
                                    </div>
                                <?}
                                if ($showOldPrice && $price["DISCOUNT_DIFF"]) {?>
                                    <div class="bxr-detail-old-price" id="<?=$arItemIDs["PRICE"]."_".$priceIndex?>">
                                        <?= Alexkova\Market2\Core::bxrFormatPrice($price["PRINT_VALUE_VAT"])?>
                                    </div>
                                <?}?>
                                <div class="bxr-detail-price" id="<?=$arItemIDs["DISCOUNT_PRICE"]."_".$priceIndex?>">
                                    <?= Alexkova\Market2\Core::bxrFormatPrice($price["PRINT_DISCOUNT_VALUE_VAT"], false, true)?>
                                    <?if ($showMeasure && $offer["ITEM_MEASURE"]["TITLE"]) {?>
                                        <span class="bxr-detail-measure">/ <?=$offer["ITEM_MEASURE"]["TITLE"]?></span>
                                    <?}?>
                                </div>                        
                                <div class="clearfix"></div>                
                                <meta itemprop="price" content="<?=($price['DISCOUNT_VALUE'])?$price['DISCOUNT_VALUE']:0?>">
                                <meta itemprop="priceCurrency" content="<?=($price['CURRENCY'])?$price['CURRENCY']:'RUB'?>">       
                            <?}?>
                        </div>
                    <?} elseif (!empty($offer["ITEM_PRICES"]) && $usePriceCount) {?>
                        <div id="bxr-detail-offers-price-wrap-td-<?=$offer["ID"]?>" class="bxr-detail-offers-price-wrap-td">
                            <?foreach ($offer["ITEM_PRICES"] as $priceName => $price) {
                                $isRange = ($price["QUANTITY_FROM"] != 0 || $price["QUANTITY_TO"] != 0) ? true : false;
                                if ($isRange) {?>
                                    <div class="bxr-detail-range">
                                        <?=GetMessage("BXR_FROM").' '.$price["QUANTITY_FROM"];if ($price["QUANTITY_TO"] > 0) echo '-'.$price["QUANTITY_TO"]; echo ' '.$offer["ITEM_MEASURE"]["TITLE"].": ";?>
                                    </div>
                                <?}
                                if ($showPriceName && $offer["CATALOG_GROUP_NAME_".$price["PRICE_TYPE_ID"]] && count($offer["ITEM_PRICES"]) > 1) {?>
                                    <div class="bxr-detail-price-name">
                                        <?=$offer["CATALOG_GROUP_NAME_".$price["PRICE_TYPE_ID"]]?>
                                    </div>
                                <?}
                                if ($showOldPrice && $price["DISCOUNT"]) {?>
                                    <div class="bxr-detail-old-price" id="<?=$arItemIDs["PRICE"]."_".$priceIndex?>">
                                        <?= Alexkova\Market2\Core::bxrFormatPrice($price["PRINT_BASE_PRICE"])?>
                                    </div>
                                <?}?>
                                <div class="bxr-detail-price<?=($isRange)?"":" bxr-without-range"?>" id="<?=$arItemIDs["DISCOUNT_PRICE"]."_".$priceIndex?>">
                                    <?= Alexkova\Market2\Core::bxrFormatPrice($price["PRINT_RATIO_PRICE"], false, true)?>
                                    <?if ($showMeasure && $offer["ITEM_MEASURE"]["TITLE"]) {?>
                                        <span class="bxr-detail-measure">/ <?=$offer["ITEM_MEASURE"]["TITLE"]?></span>
                                    <?}?>
                                </div>                        
                                <div class="clearfix"></div>                
                                <meta itemprop="price" content="<?=($price['RATIO_BASE_PRICE'])?$price['RATIO_BASE_PRICE']:0?>">
                                <meta itemprop="priceCurrency" content="<?=($price['CURRENCY'])?$price['CURRENCY']:'RUB'?>">       
                            <?}?>
                        </div>
                    <?}?>
                </div>
				<div><?=\Alexkova\Market2\Core::printAvailHtmlV2Lite($offer["CATALOG_QUANTITY"], $offer["CATALOG_MEASURE_NAME"], $params);?></div>
            </td>
            <td class="bxr-offer-basket-btn-td">
                <div id="bxr-detail-offers-buy-btn-wrap-td-<?=$offer["ID"]?>" class="bxr-detail-offers-buy-btn-wrap-td">
                    <?if ( $offer["CATALOG_QUANTITY"] <= 0 && $offer["CATALOG_CAN_BUY_ZERO"] == "N"  || empty($offer["ITEM_PRICES"]) ) {
                        $useSubscribeBtn = ($offer['CATALOG_SUBSCRIBE'] == 'Y') ? true : false;
                        if($useSubscribeBtn) {?>
<?/*
                            <div class="bxr-subscribe-wrap">
                                <?$APPLICATION->includeComponent(
                                    'bxready.market2:catalog.product.subscribe',
                                    '',
                                    array(
                                        'PRODUCT_ID' => $offer['ID'],
                                        'BUTTON_ID' => 'bxr-'.$offer['ID'].'-td-subscribe',
                                        'BUTTON_CLASS' => 'bxr-color-button bxr-detail-subscribe',
                                        'MESS_BTN_SUBSCRIBE' => (isset($arParams['MESS_BTN_SUBSCRIBE']) ? $arParams['MESS_BTN_SUBSCRIBE'] : ''),
                                    ),
                                    $component, 
                                    array('HIDE_ICONS' => 'Y')
                                );?>
                            </div>
*/?>
                            <div class="bxr-basket-action">
                                <button class="bxr-check-exist bxr-font-color-hover"
                                        data-pid="<?=$arResult["ID"]?>"
                                        data-oid="<?=$offer["ID"]?>"
                                        data-toggle="modal"
                                        data-target="#bxr-check-exist-popup">
                                    Уточнить наличие и цену
                                </button>
                            </div>
                        <?} else {?>
                            <button class="bxr-color-button bxr-detail-product-request" value="<?=$offer["ID"]?>" 
                                data-pid="<?=$arResult["ID"]?>" 
                                data-oid="<?=$offer["ID"]?>"
                                data-toggle="modal" 
                                data-target="#bxr-request-product-popup">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                <?=(strlen($arParams["MESS_BTN_SUBSCRIBE"]) > 0) ? $arParams["MESS_BTN_SUBSCRIBE"] : GetMessage("BXR_REQUEST_BTN");?>
                            </button>
                        <?}
                    } else {        
                        $qtyMax = ($offer["CATALOG_CAN_BUY_ZERO"] == "Y") ? 0 : $offer["CATALOG_QUANTITY"];?>                    
                        <form class="bxr-basket-action bxr-basket-group bxr-currnet-torg">
                            <div class="bxr-quant-wrap hidden-xs">
                                <input type="button" class="bxr-quantity-button-minus" value="-" data-item="<?=$offer["ID"]?>" data-ratio="<?=$offer["RATIO"];?>">
                                <input type="text" name="quantity" value="<?=$offer["START_QTY"];?>" class="bxr-quantity-text" data-item="<?=$offer["ID"]?>">
                                <input type="button" class="bxr-quantity-button-plus" value="+" data-item="<?=$offer["ID"]?>" data-ratio="<?=$offer["RATIO"];?>" data-max="<?=$offer["QTY_MAX"]?>">
                            </div>
                            <button class="bxr-color-button bxr-basket-add">
                                <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                <?=(strlen($arParams["MESS_BTN_ADD_TO_BASKET"]) > 0) ? $arParams["MESS_BTN_ADD_TO_BASKET"] : GetMessage("BXR_TO_BASKET");?>
                            </button>
                            <input class="bxr-basket-item-id" type="hidden" name="item" value="<?=$offer["ID"]?>">
                            <input type="hidden" name="action" value="add">
                        </form>
                        <?if ($useOneClick):?>
                            <div class="bxr-basket-action bxr-one-click-action hidden-xs">
                                <button class="bxr-one-click-buy bxr-font-color-hover" 
                                data-pid="<?=$arResult["ID"]?>" 
                                data-oid="<?=$offer["ID"]?>"
                                data-toggle="modal" 
                                data-target="#bxr-one-click-buy-popup">
                                    <?=(strlen($arParams["USE_ONE_CLICK_TEXT"]) > 0) ?  $arParams["USE_ONE_CLICK_TEXT"] : GetMessage("BXR_ONE_CLICK_BUY");?>
                                </button>
                            </div>
                        <?endif;?>
                        <div class="clearfix"></div>
                    <?}?>
                </div>
            </td>
        </tr>
        <?endforeach;?>
    </tbody>
</table>
<script>
    <?if (isset($arParams["SHOW_OFFER_PIC_BYCLICK"]) && $arParams["SHOW_OFFER_PIC_BYCLICK"] == "Y" ):?>
        $(".fancybox-offer").fancybox({
            slideShow: false,
            fullScreen: false,        
            onComplete: function() {
                $('.fancybox-thumbs').scrollbar();            
                $('.scroll-bar').addClass('bxr-color');
            },
            thumbs : {
                showOnStart: true,
            },
        });
    <?endif;?>
</script>
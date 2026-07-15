<div id="<?=$arItemIDs['BASKET_BTN_WRAP']?>" class="bxr-detail-buy-btn-wrap">
    <?
    $hasOffers = (empty($arResult["OFFERS"])) ? false : true;
    $subscribe = ( $arResult["CATALOG_QUANTITY"] <= 0 && $arResult["CATALOG_CAN_BUY_ZERO"] == "N"  || empty($arResult["ITEM_PRICES"]) ) ? true : false;
    $useSubscribeBtn = ($arResult['CATALOG_SUBSCRIBE'] == 'Y') ? true : false;

    if($hasOffers || $subscribe && $useSubscribeBtn) {?>
<?/*
        <div class="bxr-subscribe-wrap<?=($hasOffers)?' bxr-catalog-simple-hidden':''?>">
            <?$APPLICATION->includeComponent(
                'bxready.market2:catalog.product.subscribe',
                '',
                array(
                    'PRODUCT_ID' => $arResult['ID'],
                    'BUTTON_ID' => $arItemIDs['SUBSCRIBE_LINK'],
                    'BUTTON_CLASS' => 'bxr-color-button bxr-detail-subscribe',
                    'MESS_BTN_SUBSCRIBE' => (isset($arParams['MESS_BTN_SUBSCRIBE']) ? $arParams['MESS_BTN_SUBSCRIBE'] : ''),
                ),
                $component,
                array('HIDE_ICONS' => 'Y')
            );?>
        </div>
*/?>
        <div class="bxr-basket-action">
            <button class="bxr-check-exist bxr-font-color-hover<?=($hasOffers)?' bxr-hidden':''?>"
                    data-pid="<?=$arResult["ID"]?>"
                    data-oid=""
                    data-toggle="modal"
                    data-target="#bxr-check-exist-popup">
                Уточнить наличие и цену
            </button>
        </div>
    <? }
    if($hasOffers || $subscribe && !$useSubscribeBtn) {?>
        <button class="bxr-color-button bxr-detail-product-request<?=($hasOffers)?' bxr-catalog-simple-hidden':''?>" value="<?=$arResult["ID"]?>"
            data-pid="<?=$arResult["ID"]?>"
            data-oid=""
            data-toggle="modal"
            data-target="#bxr-request-product-popup">
            <i class="fa fa-pencil" aria-hidden="true"></i>
            <?=(strlen($arParams["MESS_BTN_SUBSCRIBE"]) > 0) ? $arParams["MESS_BTN_SUBSCRIBE"] : GetMessage("BXR_REQUEST_BTN");?>
        </button>
    <? }
    if($hasOffers || !$subscribe) {
        $qtyMax = ($arResult["CATALOG_CAN_BUY_ZERO"] == "Y") ? 0 : $arResult["CATALOG_QUANTITY"];?>
        <?if (!$hasOffers && ($arResult["BASKET_PROPS"]["REQUIRED_CHECK"] || $arResult["BASKET_PROPS"]["OPTIONAL_CHECK"])) {?>
            <table id="bxr-bprop-table-<?=$arResult["ID"]?>" class="bxr-bprop-table">
                <?if(is_array($arResult["BASKET_PROPS"]["REQUIRED_CHECK"])) {
                    foreach ($arResult["BASKET_PROPS"]["REQUIRED_CHECK"] as $pCode) {?>
                        <tr>
                            <td class="bxr-bprop-name"><?=$pCode["NAME"]?>: </td>
                            <td class="bxr-bprop-value">
                                <div class="bxr-bprop-tooltip"><?=GetMessage('SELECT_BPROP')?> <?=$pCode["NAME"]?><i class="fa fa-caret-down"></i></div>
                                <select class="bxr-bprop-required bxr-bprop-select" id="bxr-bprop-required-<?=$pCode["ID"]?>" data-required="Y" data-code="<?=$pCode["CODE"]?>" data-name="<?=$pCode["NAME"]?>" data-sort="<?=$pCode["SORT"]?>">
                                    <option value="false"><?=GetMessage("BPROP_NOT_SELECT")?></option>
                                    <?foreach ($pCode["VALUE"] as $val) {?>
                                        <option value="<?=$val?>"><?=$val?></option>
                                    <?}?>
                                </select>
                            </td>
                        </tr>
                    <?}
                }
                if(is_array($arResult["BASKET_PROPS"]["OPTIONAL_CHECK"])) {
                    foreach ($arResult["BASKET_PROPS"]["OPTIONAL_CHECK"] as $pCode) {?>
                        <tr>
                            <td class="bxr-bprop-name"><?=$pCode["NAME"]?>: </td>
                            <td class="bxr-bprop-value">
                                <select class="bxr-bprop-optional bxr-bprop-select" data-required="N" data-code="<?=$pCode["CODE"]?>" data-name="<?=$pCode["NAME"]?>" data-sort="<?=$pCode["SORT"]?>">
                                    <option value="<?=GetMessage("BPROP_NOT_SELECT")?>"><?=GetMessage("BPROP_NOT_SELECT")?></option>
                                    <?foreach ($pCode["VALUE"] as $val) {?>
                                        <option value="<?=$val?>"><?=$val?></option>
                                    <?}?>
                                </select>
                            </td>
                    <?}
                }?>
            </table>
        <?}?>
        <form class="bxr-basket-action bxr-basket-group bxr-currnet-torg<?=($hasOffers)?' bxr-catalog-simple-hidden':''?>">
            <input type="button" class="bxr-quantity-button-minus" value="-" data-item="<?=$arResult["ID"]?>" data-ratio="<?=$arResult["RATIO"];?>">
            <input type="text" name="quantity" value="<?=$arResult["START_QTY"];?>" class="bxr-quantity-text" data-item="<?=$arResult["ID"]?>">
            <input type="button" class="bxr-quantity-button-plus" value="+" data-item="<?=$arResult["ID"]?>" data-ratio="<?=$arResult["RATIO"];?>" data-max="<?=$arResult["QTY_MAX"]?>">

            <button class="bxr-color-button bxr-basket-add">
                <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                <?=(strlen($arParams["MESS_BTN_ADD_TO_BASKET"]) > 0) ? $arParams["MESS_BTN_ADD_TO_BASKET"] : GetMessage("BXR_TO_BASKET");?>
            </button>
            <input class="bxr-basket-item-id" type="hidden" name="item" value="<?=$arResult["ID"]?>">
            <input type="hidden" name="action" value="add">
        </form>
        <?if ($useOneClick):?>
            <div class="bxr-basket-action">
                <button class="bxr-one-click-buy bxr-font-color-hover<?=($hasOffers)?' bxr-catalog-simple-hidden':''?>"
                        data-pid="<?=$arResult["ID"]?>"
                        data-oid=""
                        data-toggle="modal"
                        data-target="#bxr-one-click-buy-popup">
                    <?=(strlen($arParams["USE_ONE_CLICK_TEXT"]) > 0) ?  $arParams["USE_ONE_CLICK_TEXT"] : GetMessage("BXR_ONE_CLICK_BUY");?>
                </button>
            </div>
        <?endif;?>
        <div class="clearfix"></div>
    <? }?>
    <script>
        BXReady.Market.basketValues[<?=$arResult['ID']?>] = {
            ID: '<?=$arResult['ID']?>',
            OFFER_ID: '',
            NAME: '<?=htmlspecialchars($arResult['NAME'],ENT_QUOTES, SITE_CHARSET)?>',
            LINK: '<?=$arResult['DETAIL_PAGE_URL']?>',
            IMG: '<?=$arResult['DETAIL_PICTURE']['SRC']?>',
            MSG: '<?=str_replace('#TRADE_NAME#', htmlspecialchars($arResult['NAME'],ENT_QUOTES, SITE_CHARSET), GetMessage('TRADE_REQUEST_MSG'))?>',
            HAS_PRICE: '<?=(empty($arResult["ITEM_PRICES"])) ? 'N' : 'Y'?>',
            CATALOG_QUANTITY: '<?=$arResult['CATALOG_QUANTITY']?>',
            CATALOG_CAN_BUY_ZERO: '<?=$arResult['CATALOG_CAN_BUY_ZERO']?>',
            CATALOG_SUBSCRIBE: '<?=$arResult['CATALOG_SUBSCRIBE']?>',
            QTY_MAX: '<?=$arResult['QTY_MAX']?>',
            RATIO: '<?=$arResult['RATIO']?>',
            START_QTY: '<?=$arResult['START_QTY']?>'
        };
    </script>
</div>
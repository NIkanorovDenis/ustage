<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="basket-body-title">
    <span class="basket-body-title-h bxr-basket-tab tab-basket active" data-tab="buy"><?=GetMessage('BASKET_TITLE')?>
        <? if (isset($arResult["BASKET_ITEMS"]) && !empty($arResult["BASKET_ITEMS"]["CAN_BUY"])): ?>
            <span class="bxr-basket-cnt bxr-color"><?=count($arResult["BASKET_ITEMS"]["CAN_BUY"])?></span>
        <?endif;?>
    </span>
    <?if(!isset($arParams["USE_DELAY"]) || $arParams["USE_DELAY"]=="Y"):?>
        <span class="basket-body-title-h bxr-basket-tab tab-delay" data-tab="delay"><?=GetMessage('DELAY_TITLE')?>
            <?if(isset($arResult["BASKET_ITEMS"]) && !empty($arResult["BASKET_ITEMS"]["DELAY"])):?>
                <span class="bxr-basket-cnt bxr-color"><?=count($arResult["BASKET_ITEMS"]["DELAY"])?></span>
            <?endif;?>
        </span>
    <?endif;?>
     <? if (isset($arResult["BASKET_ITEMS"]) && !empty($arResult["BASKET_ITEMS"]["CAN_BUY"])): ?>
            <span class="basket-body-title-h tab-basket-clear bxr-border-color-hover bxr-font-color-hover"><i class="fa fa-close"></i><?=GetMessage('BASKET_CLEAR_LIST')?></span>
        <?endif;?>
    <div class="clearfix"></div>
</div>
<input type="hidden" id="currency-format" value="<?=$arResult["CURRENCY_FORMAT"]?>">
<input type="hidden" id="min-order-price" value="<?=$arResult["MIN_ORDER_PRICE"]?>">
<input type="hidden" id="min-order-price-msg" value="<?=$arResult["MIN_ORDER_PRICE_MSG_FLAGS"]?>">
<div class="min-order-price-notify" <?if ($arResult["SUMM"] >= $arResult["MIN_ORDER_PRICE"]) {?>style="display: none;"<?}?>><?=$arResult["MIN_ORDER_PRICE_MSG"]?></div>

<div class="bxr-basket-tab-content active" data-tab="buy">
    <?include('items_can_by.php');?>
</div>
<?if(!isset($arParams["USE_DELAY"]) || $arParams["USE_DELAY"]=="Y"):?>
    <div class="bxr-basket-tab-content" data-tab="delay">
        <?include('items_delay.php');?>
    </div>
<?endif;?>
<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>
<?
global $DB;
$currency = $arResult["PROPERTIES"]["BXR_UNIT_PRICE"]["VALUE"];
$price = round($arResult["PROPERTIES"]["BXR_PRICE"]["VALUE"]);
$display_price = number_format($price, 0, ".", " ");
$discount_price = round($arResult["PROPERTIES"]["BXR_DISCOUNT_PRICE"]["VALUE"]);
$display_discount_price = number_format($discount_price, 0, ".", " ");
$discount_period_from = strtotime($arResult["PROPERTIES"]["BXR_DISCOUNT_PERIOD_FROM"]["VALUE"]);
$discount_period_to = strtotime($arResult["PROPERTIES"]["BXR_DISCOUNT_PERIOD_TO"]["VALUE"]);
$date = strtotime(date($DB->DateFormatToPHP(CLang::GetDateFormat("FULL"))));
$discount_active = ((!$discount_period_from && !$discount_period_to) || ($date >= $discount_period_from && $date <= $discount_period_to) || ($date >= $discount_period_from && !$discount_period_to)) ? true : false;
$show_timer = ($arResult["PROPERTIES"]["BXR_DISCOUNT_TIMER"]["VALUE"] == "Y" && $discount_active) ? true : false;
$discount_show_type = $arParams["BXR_OFFERS_BLOCK"]["BXR_DISCOUNT_SHOW_TYPE"];
?>
<div class="bxr-price">
    <? if ($price > 0 && $discount_price > 0 && $discount_active) {?>
        <span class="bxr-old-price"><span><?=$display_price?></span></span>
        <span class="bxr-current-price"><?=$display_discount_price?></span>
        <span class="bxr-price-currency"><?=$currency?></span>
    <?} elseif ($price > 0) {?>
        <span class="bxr-current-price"><?=$display_price?></span>
        <span class="bxr-price-currency"><?=$currency?></span>
    <?}?>
</div>
<? if ($price > 0 && $discount_price > 0 && $discount_active) {?>
    <div class="bxr-discount">
    <?switch ($discount_show_type) {
        case 'percent':
            $discount_percent = 100 - round($discount_price/$price*100);?>
            <?if(intval($discount_percent) > 0):?>
                <div class="bxr-discount-percent">
                    -<?=$discount_percent?>%
                </div>
            <?endif;?>
            <?break;
        case 'diff':
            $discount_diff = number_format($price - $discount_price, 0, ".", " ");?>
            <div class="bxr-discount-diff">
                <?=GetMessage('YOUR_PROFIT')?><span><?=$discount_diff?></span> <?=$currency?>
            </div>
            <?break;
        case 'both':
            $discount_percent = 100 - round($discount_price/$price*100);
            $discount_diff = number_format($price - $discount_price, 0, ".", " ");?>
            <?if(intval($discount_percent) > 0):?>
                <div class="bxr-discount-percent">
                    -<?=$discount_percent?>%
                </div>
            <?endif;?>
            <div class="bxr-discount-diff">
                <?=GetMessage('YOUR_PROFIT')?><span><?=$discount_diff?></span> <?=$currency?>
            </div>
            <?break;
        default:
            break;
    }?>    
    </div>
<?}?>
<?if ($show_timer) {?>
    <div class="bxr-discount-timer">
        <div id="main-offer-countdown" class="bxr-countdown">
            <div class="bxr-countdown-title"><?=GetMessage('TIME_LEFT');?></div>
            <div id='main-offer-tiles' class="bxr-tiles"></div>
            <div class="labels">
                <li><?=GetMessage('DAYS');?></li>
                <li><?=GetMessage('HOURS');?></li>
                <li><?=GetMessage('MINUTES');?></li>
                <li><?=GetMessage('SECONDS');?></li>
            </div>
        </div>
        <script>
            var mainOfferCountdown = new countdownBXR('<?=$discount_period_to?>',document.getElementById("main-offer-tiles"));
            mainOfferCountdown.start();
        </script>
    </div>
<?  $this->addExternalJs('/bitrix/js/alexkova.bxready2/countdown/countdown.js');
    $this->addExternalCss('/bitrix/js/alexkova.bxready2/countdown/countdown.css');
}?>
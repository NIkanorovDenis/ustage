<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>
<?if($price > 0):?>
    <div class="bxr-price">
        <? if ($discount_price > 0 && $discount_active) {?>
            <span class="bxr-old-price"><span><?=$display_price?></span></span>
            <span class="bxr-current-price"><?=$display_discount_price?></span>
            <span class="bxr-price-currency"><? echo $check ? '' : $currency ?></span>
        <?} else {?>
            <span class="bxr-current-price"><?=$display_price?></span>
            <span class="bxr-price-currency"><? echo $check ? '' : $currency ?></span>
        <?}?>
    </div>
<?endif;?>
<? if ($price > 0 && $discount_price > 0 && $discount_active) {?>
    <div class="bxr-discount">
    <?switch ($discount_show_type) {
        case 'percent':
            $discount_percent = 100 - round($discount_price/$price*100);?>
            <div class="bxr-discount-percent">
                -<?=$discount_percent?>%
            </div>
            <?break;
        case 'diff':
            $discount_diff = number_format($price - $discount_price, 0, ".", " ");?>
            <div class="bxr-discount-diff">
                <?=GetMessage('YOUR_PROFIT')?><span><?=$discount_diff?></span> <? echo $check ? '' : $currency ?>
            </div>
            <?break;
        case 'both':
            $discount_percent = 100 - round($discount_price/$price*100);?>
            <div class="bxr-discount-percent">
                -<?=$discount_percent?>%
            </div>
            <div class="bxr-discount-diff">
                <?=GetMessage('YOUR_PROFIT')?><span><?=$discount_diff?></span> <? echo $check ? '' : $currency ?>
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
<div id="<?=$arItemIDs['PRICES_WRAP']?>" class="bxr-detail-price-line">
    <?if (!empty($arResult["PRICES"]) && (!$usePriceCount || count($arResult["OFFERS"]) > 0) ) {?>
        <div id="<?=$arItemIDs['PRICES_WRAP']."_main"?>" class="bxr-detail-price-wrap">
            <?foreach ($arResult["PRICES"] as $priceName => $price) {
                if ($showPriceName && count($arResult["PRICES"]) > 1) {?>
                    <div class="bxr-detail-price-name bxr-without-range">
                        <?=$arResult["CAT_PRICES"][$priceName]["TITLE"]?>
                    </div>
                <?}
                if ($showOldPrice && $price["DISCOUNT_DIFF"] > 0) {?>
                    <div class="bxr-detail-old-price" id="<?=$arItemIDs["PRICE"]."_".$priceIndex?>">
                        <? if (!empty($arResult["OFFERS"])) echo GetMessage("BXR_FROM");?>
                        <?= Alexkova\Market2\Core::bxrFormatPrice($price["PRINT_VALUE_VAT"])?>
                    </div>
                <?}?>
                <div class="bxr-detail-price" id="<?=$arItemIDs["DISCOUNT_PRICE"]."_".$priceIndex?>">
                    <? if (!empty($arResult["OFFERS"])){?>
                        <span class="bxr-detail-from"><?=GetMessage("BXR_FROM");?></span>
                    <?}?>
                    <?= Alexkova\Market2\Core::bxrFormatPrice($price["PRINT_DISCOUNT_VALUE"], false, true)?>
                    <?if ($showMeasure && $arResult["ITEM_MEASURE"]["TITLE"]) {?>
                        <span class="bxr-detail-measure">/ <?=$arResult["ITEM_MEASURE"]["TITLE"]?></span>
                    <?}?>
                </div>
                <div class="clearfix"></div>                
		<meta itemprop="price" content="<?=($price['DISCOUNT_VALUE'])?$price['DISCOUNT_VALUE']:0?>">
		<meta itemprop="priceCurrency" content="<?=($price['CURRENCY'])?$price['CURRENCY']:'RUB'?>">
                <?if (empty($arResult["OFFERS"])) {?>
                    <?if ($showDiscountPercent && $price["DISCOUNT_DIFF_PERCENT"]) {?>
                        <span class="bxr-discount-percent">
                            -<?=$price["DISCOUNT_DIFF_PERCENT"]?>%
                        </span>
                    <?}?>
                    <?if ($showDiscountValue && $price["DISCOUNT_DIFF"]) {?>
                        <span class="bxr-discount-value">
                            <?=GetMessage("BXR_YOUR_SAVING")."<span>".Alexkova\Market2\Core::bxrFormatPrice($price["PRINT_DISCOUNT_DIFF"], false, true)."</span>"?>
                        </span>
                    <?}?>
                    <?if ($showDiscountPercent && $price["DISCOUNT_DIFF_PERCENT"] || $showDiscountValue && $price["DISCOUNT_DIFF"]) {?>
                        <div class="clearfix"></div>   
                    <?}?>  
                <?}?>
            <?}?>
        </div>
    <?} elseif (!empty($arResult["PRICE_MATRIX"]) && $usePriceCount) {?>
        <div id="<?=$arItemIDs['PRICES_WRAP']."_main"?>" class="bxr-detail-price-wrap">
            <?if ($arParams["GROUP_PRICE_COUNT"] == "count") {
                foreach ($arResult["PRICE_MATRIX"]["ROWS"] as $itemRangeKey => $itemRange) {?>
                    <div class="bxr-detail-range-wrap">
                        <?
                        $isRange = ($itemRange["QUANTITY_FROM"] != 0 || $itemRange["QUANTITY_TO"] != 0) ? true : false;
                        if ($isRange) {?>
                            <div class="bxr-detail-range bxr-detail-range-title">
                                <?=GetMessage("BXR_DETAIL_RANGE").' '.$itemRange["QUANTITY_FROM"];if ($itemRange["QUANTITY_TO"] > 0) echo '-'.$itemRange["QUANTITY_TO"]; echo ' '.$arResult["ITEM_MEASURE"]["TITLE"].": ";?>
                            </div>
                        <?}
                        foreach ($arResult["PRICE_MATRIX"]["MATRIX"] as $priceIndex => $price) {
                            $currentPriceCnt = $price[$itemRangeKey];
                            if (!$currentPriceCnt) continue;
                            $priceName = $arResult["PRICE_MATRIX"]["COLS"][$priceIndex]["NAME_LANG"];
                            $displayPrice = CurrencyFormat($currentPriceCnt["PRICE"], $currentPriceCnt["CURRENCY"]);
                            $displayDiscountPrice = CurrencyFormat($currentPriceCnt["DISCOUNT_PRICE"], $currentPriceCnt["CURRENCY"]);
                            if ($showPriceName && count($arResult["PRICE_MATRIX"]["MATRIX"]) > 1 && is_array($currentPriceCnt)) {?>
                                <div class="bxr-detail-price-name">
                                    <?=$priceName?>
                                </div>
                            <?}
                            if ($showOldPrice && $currentPriceCnt["PRICE"] != $currentPriceCnt["DISCOUNT_PRICE"]) {?>
                                <div class="bxr-detail-old-price<?=($isRange)?" bxr-with-range":""?>">
                                    <? if (!empty($arResult["OFFERS"])) echo GetMessage("BXR_FROM");?>
                                    <?= Alexkova\Market2\Core::bxrFormatPrice($displayPrice)?>
                                </div>
                                <?if ($isRange) {?>
                                    <div class="clearfix"></div>
                                <?}?>
                            <?}?>
                            <div class="bxr-detail-price<?=($isRange)?" bxr-with-range":""?>">                                
                                <? if (!empty($arResult["OFFERS"])){?>
                                    <span class="bxr-detail-from"><?=GetMessage("BXR_FROM");?></span>
                                <?}?>
                                <?= Alexkova\Market2\Core::bxrFormatPrice($displayDiscountPrice, false, true)?>
                                <?if ($showMeasure && $arResult["ITEM_MEASURE"]["TITLE"]) {?>
                                    <span class="bxr-detail-measure">/ <?=$arResult["ITEM_MEASURE"]["TITLE"]?></span>
                                <?}?>
                            </div>
                            <div class="clearfix"></div>                
                            <meta itemprop="price" content="<?=($currentPriceCnt["DISCOUNT_PRICE"])?$currentPriceCnt["DISCOUNT_PRICE"]:0?>">
                            <meta itemprop="priceCurrency" content="<?=($currentPriceCnt["CURRENCY"])?$currentPriceCnt["CURRENCY"]:'RUB'?>">
                        <?}?>
                    </div>
            <?  }
            } else {
                foreach ($arResult["PRICE_MATRIX"]["MATRIX"] as $priceIndex => $price) {?>
                    <div class="bxr-detail-price-name-wrap">
                        <?$priceName = $arResult["PRICE_MATRIX"]["COLS"][$priceIndex]["NAME_LANG"];
                        if ($showPriceName && count($arResult["PRICE_MATRIX"]["MATRIX"]) > 1) {?>
                            <div class="bxr-detail-price-name bxr-detail-price-name-title">
                                <?=$priceName?>
                            </div>
                        <?}
                        foreach ($price as $priceRange => $currentPriceCnt) {                            
                            $displayPrice = CurrencyFormat($currentPriceCnt["PRICE"], $currentPriceCnt["CURRENCY"]);
                            $displayDiscountPrice = CurrencyFormat($currentPriceCnt["DISCOUNT_PRICE"], $currentPriceCnt["CURRENCY"]);
                            $itemRange = $arResult["PRICE_MATRIX"]["ROWS"][$priceRange];
                            $isRange = ($itemRange["QUANTITY_FROM"] != 0 || $itemRange["QUANTITY_TO"] != 0) ? true : false;
                            if ($isRange) {?>
                                <div class="bxr-detail-range">
                                    <?=GetMessage("BXR_DETAIL_RANGE").' '.$itemRange["QUANTITY_FROM"];if ($itemRange["QUANTITY_TO"] > 0) echo '-'.$itemRange["QUANTITY_TO"]; echo ' '.$arResult["ITEM_MEASURE"]["TITLE"].": ";?>
                                </div>
                            <?}
                            if ($showOldPrice && $currentPriceCnt["PRICE"] != $currentPriceCnt["DISCOUNT_PRICE"]) {?>
                                <div class="bxr-detail-old-price<?=($isRange)?" bxr-with-range":""?>">
                                    <? if (!empty($arResult["OFFERS"])) echo GetMessage("BXR_FROM");?>
                                    <?= Alexkova\Market2\Core::bxrFormatPrice($displayPrice)?>
                                </div>
                                <?if ($isRange) {?>
                                    <div class="clearfix"></div>
                                <?}?>
                            <?}?>
                            <div class="bxr-detail-price<?=($isRange)?" bxr-with-range":""?>">
                                <? if (!empty($arResult["OFFERS"])){?>
                                    <span class="bxr-detail-from"><?=GetMessage("BXR_FROM");?></span>
                                <?}?>
                                <?= Alexkova\Market2\Core::bxrFormatPrice($displayDiscountPrice, false, true)?>
                                <?if ($showMeasure && $arResult["ITEM_MEASURE"]["TITLE"]) {?>
                                    <span class="bxr-detail-measure">/ <?=$arResult["ITEM_MEASURE"]["TITLE"]?></span>
                                <?}?>
                            </div>
                            <div class="clearfix"></div>                
                            <meta itemprop="price" content="<?=($currentPriceCnt["DISCOUNT_PRICE"])?$currentPriceCnt["DISCOUNT_PRICE"]:0?>">
                            <meta itemprop="priceCurrency" content="<?=($currentPriceCnt["CURRENCY"])?$currentPriceCnt["CURRENCY"]:'RUB'?>">
                        <?}?>
                    </div>
                <?}?>
            <?}?>
        </div>
    <?}?>
    <?if (!empty($arResult["OFFERS"])) {
        foreach ($arResult["OFFERS"] as $offer) {
            if (!empty($offer["PRICES"]) && !$usePriceCount) {?>
                <div id="<?=$arItemIDs['PRICES_WRAP']."_offer_".$offer["ID"]?>" class="bxr-detail-offers-price-wrap">
                    <?foreach ($offer["PRICES"] as $priceName => $price) {
                        if ($showPriceName && count($offer["PRICES"]) > 1) {?>
                            <div class="bxr-detail-price-name bxr-without-range">
                                <?=$arResult["CAT_PRICES"][$priceName]["TITLE"]?>
                            </div>
                        <?}
                        if ($showOldPrice && $price["DISCOUNT_DIFF"]) {?>
                            <div class="bxr-detail-old-price" id="<?=$arItemIDs["PRICE"]."_".$priceIndex?>">
                                <?= Alexkova\Market2\Core::bxrFormatPrice($price["PRINT_VALUE_VAT"])?>
                            </div>
                        <?}?>
                        <div class="bxr-detail-price" id="<?=$arItemIDs["DISCOUNT_PRICE"]."_".$priceIndex?>">
                            <?= Alexkova\Market2\Core::bxrFormatPrice($price["PRINT_DISCOUNT_VALUE"], false, true)?>
                            <?if ($showMeasure && $offer["ITEM_MEASURE"]["TITLE"]) {?>
                                <span class="bxr-detail-measure">/ <?=$offer["ITEM_MEASURE"]["TITLE"]?></span>
                            <?}?>
                        </div>                        
                        <div class="clearfix"></div>                
                        <meta itemprop="price" content="<?=($price['DISCOUNT_VALUE'])?$price['DISCOUNT_VALUE']:0?>">
                        <meta itemprop="priceCurrency" content="<?=($price['CURRENCY'])?$price['CURRENCY']:'RUB'?>">
                        <?if ($showDiscountPercent && $price["DISCOUNT_DIFF_PERCENT"]) {?>
                            <span class="bxr-discount-percent">
                                -<?=$price["DISCOUNT_DIFF_PERCENT"]?>%
                            </span>
                        <?}?>
                        <?if ($showDiscountValue && $price["DISCOUNT_DIFF"]) {?>
                            <span class="bxr-discount-value">
                                <?=GetMessage("BXR_YOUR_SAVING")."<span>".Alexkova\Market2\Core::bxrFormatPrice($price["PRINT_DISCOUNT_DIFF"], false, true)."</span>"?>
                            </span>
                        <?}?>                        
                        <?if ($showDiscountPercent && $price["DISCOUNT_DIFF_PERCENT"] || $showDiscountValue && $price["DISCOUNT_DIFF"]) {?>
                            <div class="clearfix"></div>   
                        <?}?>       
                    <?}?>
                </div>
            <?} elseif (!empty($offer["ITEM_PRICES"]) && $usePriceCount) {?>
                <div id="<?=$arItemIDs['PRICES_WRAP']."_offer_".$offer["ID"]?>" class="bxr-detail-offers-price-wrap">
                    <?foreach ($offer["ITEM_PRICES"] as $priceIndex => $price) {
                        $isRange = ($price["QUANTITY_FROM"] != 0 || $price["QUANTITY_TO"] != 0) ? true : false;
                        if ($isRange) {?>
                            <div class="bxr-detail-range-wrap">
                                <div class="bxr-detail-range bxr-detail-range-title">
                                    <?=GetMessage("BXR_DETAIL_RANGE").' '.$price["QUANTITY_FROM"];if ($price["QUANTITY_TO"] > 0) echo '-'.$price["QUANTITY_TO"]; echo ' '.$offer["ITEM_MEASURE"]["TITLE"].": ";?>
                                </div>
                        <?}
                        if ($showPriceName && $offer["CATALOG_GROUP_NAME_".$price["PRICE_TYPE_ID"]] && count($offer["ITEM_PRICES"]) > 1) {?>
                            <div class="bxr-detail-price-name">
                                <?=$offer["CATALOG_GROUP_NAME_".$price["PRICE_TYPE_ID"]]?>
                            </div>
                        <?}
                        if ($arParams["SHOW_OLD_PRICE"] == "Y" && $price["DISCOUNT"]) {?>
                            <div class="bxr-detail-old-price <?=($isRange)?"bxr-with-range":""?>" id="<?=$arItemIDs["PRICE"]."_".$priceIndex?>">
                                <?= Alexkova\Market2\Core::bxrFormatPrice($price["PRINT_BASE_PRICE"])?>
                            </div>
                            <?if ($isRange) {?>
                                <div class="clearfix"></div>
                            <?}?>
                        <?}?>
                        <div class="bxr-detail-price <?=($isRange)?"bxr-with-range":""?>" id="<?=$arItemIDs["DISCOUNT_PRICE"]."_".$priceIndex?>">
                            <?= Alexkova\Market2\Core::bxrFormatPrice($price["PRINT_RATIO_PRICE"], false, true)?>
                            <?if ($showMeasure && $offer["ITEM_MEASURE"]["TITLE"]) {?>
                                <span class="bxr-detail-measure">/ <?=$offer["ITEM_MEASURE"]["TITLE"]?></span>
                            <?}?>
                        </div>
                        <div class="clearfix"></div>                   
                        <meta itemprop="price" content="<?=($price['RATIO_BASE_PRICE'])?$price['RATIO_BASE_PRICE']:0?>">
                        <meta itemprop="priceCurrency" content="<?=($price['CURRENCY'])?$price['CURRENCY']:'RUB'?>">
                        <?if ($isRange) {?>
                            </div>
                        <?} else {?>
                            <?if ($showDiscountPercent && $price["PERCENT"]) {?>
                                <span class="bxr-discount-percent">
                                    -<?=$price["PERCENT"]?>%
                                </span>
                            <?}?>
                            <?if ($showDiscountValue && $price["DISCOUNT"]) {?>
                                <span class="bxr-discount-value">
                                    <?=GetMessage("BXR_YOUR_SAVING")."<span>".Alexkova\Market2\Core::bxrFormatPrice($price["PRINT_DISCOUNT"], false, true)."</span>"?>
                                </span>
                            <?}?>                        
                            <?if ($showDiscountPercent && $price["PERCENT"] || $showDiscountValue && $price["DISCOUNT"]) {?>
                                <div class="clearfix"></div>   
                            <?}?>  
                        <?}?>
                    <?}?>
                </div>
            <?}
        }
    } ?>
    
    <?global $DB;
    if ($arResult["SHOW_TIMER"]) {?>
        <div class="bxr-discount-timer">
            <div id="<?=$arItemIDs['COUNTDOWN_CONT_ID']?>" class="bxr-countdown">
                <div class="bxr-countdown-title"><?=GetMessage('TIME_LEFT');?></div>
                <div id='<?=$arItemIDs['COUNTDOWN_ID']?>' class="bxr-tiles<?=($arParams['BXR_SHOW_ACTION_TIMER_DETAIL'] == "DARK") ? " gray" : ""?>"></div>
                <div class="labels<?=($arParams['BXR_SHOW_ACTION_TIMER_DETAIL'] == "DARK") ? " gray" : ""?>">
                    <li class="days"><?=GetMessage('DAYS');?></li>
                    <li class="hours"><?=GetMessage('HOURS');?></li>
                    <li class="minutes"><?=GetMessage('MINUTES');?></li>
                    <li class="seconds"><?=GetMessage('SECONDS');?></li>
                </div>
            </div>
            <script>
                var <?='ob_'.$arItemIDs['COUNTDOWN_ID']?> = new countdownBXR('<?=$arResult["DISCOUNT_PERIOD_TO"]?>',document.getElementById("<?=$arItemIDs['COUNTDOWN_ID']?>"));
                <?='ob_'.$arItemIDs['COUNTDOWN_ID']?>.start();
            </script>
        </div>
    <?}?>
</div>
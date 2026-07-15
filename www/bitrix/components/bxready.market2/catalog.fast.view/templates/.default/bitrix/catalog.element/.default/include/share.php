<?
if ($useCompare || $useFavorites):?>
    <div class="bxr-detail-torg-btn">
        <?if ($useCompare):?>
            <button class="bxr-indicator-item white bxr-indicator-item-compare bxr-compare-button bxr-border-color-hover bxr-font-color-hover" value="" data-item="<?=$arResult["ID"]?>">
                <i class="fa fa-bar-chart hidden-md" aria-hidden="true"></i>
                    <?=(strlen($arParams["MESS_BTN_COMPARE"]) > 0) ? $arParams["MESS_BTN_COMPARE"] : GetMessage("BXR_COMPARE");?>
            </button>
        <?endif;
        if ($useFavorites):?>
            <form class="bxr-basket-action bxr-basket-group">
                <button class="bxr-indicator-item white bxr-indicator-item-favor bxr-basket-favor bxr-border-color-hover bxr-font-color-hover" data-item="<?=$arResult["ID"]?>" tabindex="0">
                    <span class="fa fa-heart-o hidden-md"></span>
                        <?=(strlen($arParams["USE_FAVORITES_TEXT"]) > 0) ? $arParams["USE_FAVORITES_TEXT"] : GetMessage("BXR_FAVORITE");?>
                </button>
                <input type="hidden" name="item" value="<?=$arResult["ID"]?>" tabindex="0">
                <input type="hidden" name="action" value="favor" tabindex="0">
                <input type="hidden" name="favor" value="yes">
            </form>
	<?endif;?>        
    </div>
<?endif;?>
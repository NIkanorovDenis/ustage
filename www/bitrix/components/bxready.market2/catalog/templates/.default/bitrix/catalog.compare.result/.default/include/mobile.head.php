<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Alexkova\Market2\Bxmarket;
?>
<div class="row">
    <div class="col-xs-<?=(count($arResult["ITEMS"]) > 1)?6:12?> bxr-compare-slider-col">
        <div id="sl_compare_1" class="bxr-compare-slider" data-side="left">
            <?foreach($arResult["ITEMS"] as $arElement):
                $img = (empty( $arElement["PREVIEW_PICTURE"]["SRC"] ) && empty( $arElement["DETAIL_PICTURE"]["SRC"] )) ? $this->GetFolder().'/images/no-image.png'
                    : ((empty( $arElement["PREVIEW_PICTURE"]["SRC"] )) ? $arElement["DETAIL_PICTURE"]["SRC"] : $arElement["PREVIEW_PICTURE"]["SRC"]);?>
                <div class="bxr-compare-product" data-item="<?=$arElement["ID"]?>">
                    <a  href="<?=$arElement["DETAIL_PAGE_URL"]?>"  class="bxr-product-compare-img">
                        <img src="<?=$img?>">
                    </a>
                    <a href="<?=$APPLICATION->GetCurPage()?>?action=DELETE_FROM_COMPARE_RESULT&IBLOCK_ID=<?=$arParams["IBLOCK_ID"]?>&ID[]=<?=$arElement["ID"]?>" class="bxr-product-compare-delete">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </a>
                    <a  href="<?=$arElement["DETAIL_PAGE_URL"]?>" class="bxr-product-compare-name">
                        <?=$arElement["NAME"]?>
                    </a>
                    <a  href="<?=$arElement["DETAIL_PAGE_URL"]?>"  class="bxr-product-compare-link bxr-color-button">
                        <?=GetMessage("CATALOG_COMPARE_BUY")?>
                    </a>
                </div>
            <?endforeach?>
        </div>
        <div class="bxr-compare-dots">
            <div class="bxr-compare-slick-button bxr-compare-slick-button-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div><!--
            --><div class="bxr-compare-count"><span class="bxr-compare-current-slide">1</span>/<?=count($arResult["ITEMS"])?></div><!--
            --><div class="bxr-compare-slick-button bxr-compare-slick-button-next" data-max="<?=count($arResult["ITEMS"])?>"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
        </div>
    </div>
    <?if (count($arResult["ITEMS"]) > 1) {?>
        <div class="col-xs-6 bxr-compare-slider-col">
            <div id="sl_compare_2" class="bxr-compare-slider" data-side="right">
                <?foreach($arResult["ITEMS"] as $arElement):
                    $img = (empty( $arElement["PREVIEW_PICTURE"]["SRC"] ) && empty( $arElement["DETAIL_PICTURE"]["SRC"] )) ? $this->GetFolder().'/images/no-image.png'
                        : ((empty( $arElement["PREVIEW_PICTURE"]["SRC"] )) ? $arElement["DETAIL_PICTURE"]["SRC"] : $arElement["PREVIEW_PICTURE"]["SRC"]);?>
                    <div class="bxr-compare-product" data-item="<?=$arElement["ID"]?>">
                        <a href="<?=$APPLICATION->GetCurPage()?>?action=DELETE_FROM_COMPARE_RESULT&IBLOCK_ID=<?=$arParams["IBLOCK_ID"]?>&ID[]=<?=$arElement["ID"]?>" class="bxr-product-compare-delete">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </a>
                        <a  href="<?=$arElement["DETAIL_PAGE_URL"]?>" class="bxr-product-compare-img">
                            <img src="<?=$img?>">
                        </a>
                        <a  href="<?=$arElement["DETAIL_PAGE_URL"]?>" class="bxr-product-compare-name">
                            <?=$arElement["NAME"]?>
                        </a>
                        <a  href="<?=$arElement["DETAIL_PAGE_URL"]?>"  class="bxr-product-compare-link bxr-color-button">
                            <?=GetMessage("CATALOG_COMPARE_BUY")?>
                        </a>
                    </div>
                <?endforeach?>
            </div>
            <div class="bxr-compare-dots">
                <div class="bxr-compare-slick-button bxr-compare-slick-button-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div><!--
                --><div class="bxr-compare-count"><span class="bxr-compare-current-slide">2</span>/<?=count($arResult["ITEMS"])?></div><!--
                --><div class="bxr-compare-slick-button bxr-compare-slick-button-next" data-max="<?=count($arResult["ITEMS"])?>"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
            </div>
        </div>
    <?}?>
</div>

<script>
    $(document).ready(function() {
        var ob_sl_compare_1 = new JCCatalogCompareSlider({
            uniqId: 'compare_1',
            initialSlide: 0
        });

        if ($('#sl_compare_2').length > 0) {
            var ob_sl_compare_2 = new JCCatalogCompareSlider({
                uniqId: 'compare_2',
                initialSlide: 1
            });
        }
    });
</script>
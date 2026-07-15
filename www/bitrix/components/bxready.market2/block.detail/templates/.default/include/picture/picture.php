<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<? if (!empty($arResult["DETAIL_PICTURE"])): ?>
    <? $dPict = $arResult["DETAIL_PICTURE"]; ?>
    <div class="bxr-element-slider-main bxr-element-picture" style="height:<?= $arParams["BXR_SLIDER_HEIGHT"]; ?>px;">
        <a href="<?= $dPict["SRC"] ?>" data-rel="gallery" data-fancybox="bx-gallery" id="main-photo">
            <img class="img-responsive bxr-zoom-img" src="<?= $dPict["SRC"] ?>" title="<?= $dPict["TITLE"] ?>"
                 alt="<?= $dPict["ALT"] ?>" itemprop="image">
        </a>
    </div>
<? endif; ?>

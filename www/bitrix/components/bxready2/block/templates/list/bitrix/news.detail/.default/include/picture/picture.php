<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>
<?if(!empty($arResult["DETAIL_PICTURE"])):
  // $arParams["BXR_SLIDER_HEIGHT"] = 500;?>
  <?$dPict = $arResult["DETAIL_PICTURE"];?>
  <div class="bxr-element-slider-main bxr-element-picture" style="height:<?= $arParams["BXR_SLIDER_HEIGHT"];?>px;">
    <a href="<?=$dPict["SRC"]?>" class="fancybox" rel="element-gallery" id="main-photo">
      <img class="img-responsive zoom-img" src="<?=$dPict["SRC"]?>" title="<?=$dPict["TITLE"]?>" alt="<?=$dPict["ALT"]?>" data-large="<?=$dPict["SRC"]?>" itemprop="image">
    </a>
  </div>
<?/*else:?>
  <div class="bxr-no-image-detail-wrap" id="main-photo">
      <img src="<?= $elementDraw->getDefaultImage();?>">
  </div>
<?*/endif;?>

<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$this->addExternalJS("/bitrix/js/alexkova.bxready2/slick/slick.js");
$this->addExternalCss("/bitrix/js/alexkova.bxready2/slick/slick.css");?>
<?$picType = $arParams["BXR_PICTURE"]["BXR_DETAIL_PICTURE_TYPE"];?>
<?$fullsize = ($picType == "fullsize_slider") ? "bxr-fullsize-slider" : "bxr-slider" ;?>
<div class="bxr-element-slider-main <?= $fullsize?>" style="height:<?= $arParams["BXR_SLIDER_HEIGHT"];?>px;">
  <?if (count($arResult["IMAGES"]) > 0):?>
    <?foreach ($arResult["IMAGES"] as $key => $slide):
       $title = ($arResult["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]) ? $arResult["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"] : $arResult["NAME"];
       $alt = ($arResult["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_ALT"]) ? $arResult["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_ALT"] : $arResult["NAME"];
       $imgTitle = ($key > 0) ? $title.'. '.GetMessage("PHOTO").' ¹'.($key+1) : $title;
       $imgAlt = ($key > 0) ? $alt.'. '.GetMessage("PHOTO").' ¹'.($key+1) : $alt;?>
      <a href="<?=$slide["SRC"]?>" class="fancybox" rel="element-gallery" <?if ($key == 0) echo 'id="main-photo"'?>>
        <img class="img-responsive zoom-img" src="<?=$slide["TMB"]["SRC"]?>" title="<?=$imgTitle?>" alt="<?=$imgAlt?>"
        data-state="show" data-large="<?=$slide["SRC"]?>" itemprop="image">
      </a>
    <?endforeach;?>
  <?else:?>
      <div class="bxr-no-image-detail-wrap" id="main-photo">
          <img src="<?= $elementDraw->getDefaultImage();?>">
      </div>
  <?endif;?>
</div>
<?if (count($arResult["IMAGES"])>1):?>
  <div class="bxr-element-slider-nav <?= $fullsize?> hidden-xs">
      <?foreach ($arResult["IMAGES"] as $key => $slide):
         $title = ($arResult["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]) ? $arResult["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"] : $arResult["NAME"];
         $alt = ($arResult["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_ALT"]) ? $arResult["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_ALT"] : $arResult["NAME"];
         $imgTitle = ($key > 0) ? $title.'. '.GetMessage("PHOTO").' ¹'.($key+1) : $title;
         $imgAlt = ($key > 0) ? $alt.'. '.GetMessage("PHOTO").' ¹'.($key+1) : $alt;?>
        <div class="bxr-nav-element <?if($key == 0) echo "bxr-slide-active"?>">
            <div class="slide-wrap <?if ($key == 0) echo 'first-slide'?>" data-item="<?=$slide["ITEM_ID"]?>" <?if ($key == 0) echo 'id="main-photo-small"'?>>
                <img class="img-responsive" src="<?=$slide["TMB"]["SRC"]?>" title="<?=$imgTitle?>" alt="<?=$imgAlt?>" itemprop="image">
            </div>
        </div>
      <?endforeach;?>
  </div>
<?endif;?>
<?$picType = $arParams["BXR_PICTURE"]["BXR_DETAIL_PICTURE_TYPE"];?>
<?$Slidecount = ($picType == "fullsize_slider") ? 5 : 3 ;?>
<?$CenterSlide = (!$picType == "fullsize_slider") ? "true" : "false" ;?>
<?if (count($arResult["IMAGES"]) > 0):?>
  <script>
    $('.bxr-element-slider-main').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        speed: 500,
        arrows: true,
        prevArrow: '<button type="button" class="bxr-color-button slick-prev"></button>',
        nextArrow: '<button type="button" class="bxr-color-button slick-next"></button>',
        // fade: true,
        dots: false,
        infinite: false,
        cssEase: 'linear',
        asNavFor: '.bxr-element-slider-nav',
        slide: 'a'
    });
    $('.bxr-element-slider-nav').slick({
        slidesToShow: <?= $Slidecount;?>,
        slidesToScroll: 1,
        speed: 500,
        asNavFor: '.bxr-element-slider-main',
        arrows: true,
        prevArrow: '<button type="button" class="bxr-color-button slick-prev"></button>',
        nextArrow: '<button type="button" class="bxr-color-button slick-next"></button>',
        centerPadding: 60,
        dots: false,
        infinite: false,
        centerMode: <?= $CenterSlide;?>,
        focusOnSelect: true,
        slide: 'div'
    });
    $('.bxr-element-slider-main').on('beforeChange', function(event, slick, currentSlide, nextSlide){
      var iIndex = nextSlide + 1;
      $(".bxr-nav-element").eq(nextSlide).addClass("bxr-slide-active");
      $(".bxr-nav-element").eq(nextSlide).siblings().removeClass("bxr-slide-active");
    });
  </script>
<?endif;?>

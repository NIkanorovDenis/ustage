<?  $this->addExternalJs('/bitrix/js/alexkova.bxready2/fancybox3/jquery.fancybox.min.js');
    $this->addExternalCss('/bitrix/js/alexkova.bxready2/fancybox3/jquery.fancybox.min.css');
    //$APPLICATION->AddHeadScript('/company/magnific-popup.min.js');
    $APPLICATION->SetAdditionalCSS("/include/company_slider-new.css");
    CModule::IncludeModule("energosoft.utils");
    $arSlider = ESIBlock::GetList(37, array("PREVIEW_PICTURE","DETAIL_PICTURE","PREVIEW_TEXT"),false,false,array("sort" => "asc"));
    ?>
    <div class="clients__items slick_slider">
        <?foreach($arSlider as $arItem):?>
           <div class="clients__elem">
               <div class="opinion">
                    <div class="opinion__image">
                        <? if ($arItem["DETAIL_PICTURE"]):?>
                            <a data-rel="gallery"  data-fancybox="bx-gallery" href="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>">
                                <img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="Логотип <?echo $arItem["NAME"]?>" class="opinion__img">
                            </a>
                        <? else: ?>    
                            <img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="Логотип <?echo $arItem["NAME"]?>" class="opinion__img">
                        <? endif; ?>
                    </div>
                </div>
                <?=$arItem["PREVIEW_TEXT"]?>
            </div>
        <?endforeach;?> 
    </div>
    <script>
        $('.clients__items.slick_slider').on('init', function(event, slick) {
            $('.slick-slide .opinion').each(function(index) {
                if ($(this).height()>120){
                    $(this).find('img').css('max-height', $(this).height());
                }
            });
        })
        .slick({
            slidesToShow: 2,
            slidesToScroll: 1,
            speed: 1000,
            arrows: true,
            prevArrow: '<button type="button" class="bxr-color-button slick-prev  hidden-arrow slick-arrow" style="display: block;"></button>',
            nextArrow: '<button type="button" class="bxr-color-button slick-next  hidden-arrow slick-arrow" style="display: block;"></button>',
            dots: true,
            infinite: true,
            responsive: [
                {
                    breakpoint: 800,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });     
   

        $(function(){
            $("[data-fancybox]").fancybox({});
        });
        
    </script> 
<?
$this->addExternalJS(SITE_TEMPLATE_PATH.'/js/slick/slick.js');
$this->addExternalCss(SITE_TEMPLATE_PATH.'/js/slick/slick.css', false);

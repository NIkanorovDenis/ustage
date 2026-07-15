<?
    $APPLICATION->AddHeadScript('/company/magnific-popup.min.js');
    $APPLICATION->AddHeadScript('/company/owl.carousel.min.js');
$APPLICATION->SetAdditionalCSS("/include/company_slider.css");
    CModule::IncludeModule("energosoft.utils");
    $arSlider = ESIBlock::GetList(37, array("PREVIEW_PICTURE","DETAIL_PICTURE","PREVIEW_TEXT"));
    ?>
    <div class="clients__items js-clients owl-carousel">
        <?foreach($arSlider as $arItem):?>
            <a href="#opinion_<?=$arItem["ID"]?>" class="clients__link js-popup">
				<span class="clients__image">
					<span class="clients__img-wrap">
						<img src="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>" alt="Логотип <?echo $arItem["NAME"]?>" class="clients__img clients__img_grayscale">
						<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="Логотип <?echo $arItem["NAME"]?>" class="clients__img clients__img_color">
					</span>
				</span>
                <span class="clients__text">Отзыв</span>
            </a>
        <?endforeach;?> 
    </div>
    <?foreach($arSlider as $arItem):?>
        <div id="opinion_<?=$arItem["ID"]?>" class="popup popup_opinion mfp-hide">
            <div class="popup__content">
                <div class="opinion">
                    <div class="opinion__image">
                        <img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="Логотип <?echo $arItem["NAME"]?>" class="opinion__img">
                    </div>
                </div>
                <?=$arItem["PREVIEW_TEXT"]?>
            </div>
        </div>
    <?endforeach;?>
 <script>
    $(document).ready(function()
    {
        $('.js-popup').magnificPopup({
            type: 'inline',
            midClick: true,
            closeMarkup: '<button title="%title%" type="button" class="mfp-close mfp-close_orange"><i class="fa fa-close"></i></button>',
            closeOnBgClick: false,
            mainClass: 'mfp-fade',
            removalDelay: 300,
        });

        var owlClients = $('.js-clients');
        owlClients.owlCarousel({
            responsive: {
                0: {
                    items: 2,
                },
                420: {
                    items: 3,
                },
                768: {
                    items: 4,
                },
                992: {
                    items: 6,
                },
            },
            loop: true,
            smartSpeed: 1000,
            slideBy: 1,
            nav: false,
            dots: false,
            autoplay: true,
            autoplayTimeout: 2500,
            autoplayHoverPause: false,
        });
        owlClients.on('mouseenter', function(e) {
            $(this).trigger('stop.owl.autoplay');
        });
        owlClients.on('mouseleave', function(e) {
            $(this).trigger('play.owl.autoplay');
        });
        owlClients.find('.js-popup').click(function (e) {
            if($(this).parent().hasClass('cloned')) {
                owlClients.find('.js-popup[href="'+ $(this).attr('href') +'"]').each(function () {
                    if(!$(this).parent().hasClass('cloned')) {
                        $(this).click();
                        return false;
                    }
                });
                e.preventDefault();
            }
        });
    });
    </script>

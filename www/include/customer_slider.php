<?
    $APPLICATION->AddHeadScript('/company/magnific-popup.min.js');
    $APPLICATION->AddHeadScript('/company/owl.carousel.min.js');
$APPLICATION->SetAdditionalCSS("/include/company_slider.css");
    CModule::IncludeModule("energosoft.utils");
    $arSlider = ESIBlock::GetList(62, array("PREVIEW_PICTURE","DETAIL_PICTURE","PREVIEW_TEXT"));
    ?>
    <div class="clients__items customer-slider js-clients owl-carousel">
        <?foreach($arSlider as $arItem):?>
            <a href="#opinion_<?=$arItem["ID"]?>" class="clients__link js-popup">
				<span class="clients__image">
					<span class="clients__img-wrap">
						<img src="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>" alt="Логотип <?echo $arItem["NAME"]?>" class="clients__img clients__img_grayscale">
						<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="Логотип <?echo $arItem["NAME"]?>" class="clients__img clients__img_color">
					</span>
				</span>
            </a>
        <?endforeach;?>
    </div>
    <?foreach($arSlider as $arItem):?>
        <div id="opinion_<?=$arItem["ID"]?>" class="popup popup_opinion mfp-hide">
            <div class="popup__content">
                <div class="opinion">
                    <div class="opinion__image customer-opinion-image">
                        <img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="Логотип <?echo $arItem["NAME"]?>" class="opinion__img">
                    </div>
                </div>
                <?=$arItem["PREVIEW_TEXT"]?>
            </div>
        </div>
    <?endforeach;?>
    <style>
    .clients__items {
        padding: 0px 10px;
        margin-bottom: 10px;
    }
    .clients__image {
        height: 133px;
    }
    .owl-prev, .owl-next {
        font-size: 0;
        line-height: 0;
        background: #d29b0a;
        border-radius: 3px;
        cursor: pointer;
        outline: none !important;
        border: none !important;
        display: block;
        position: absolute;
        left: -8px;
        top: 50%;
        margin-top: -6px;
        width: 20px;
        height: 18px;
        background: url(/bitrix/templates/market2_v1/css/../images/right-black.svg) no-repeat;
        opacity: 0.5;
    }
    .owl-prev:hover, .owl-next:hover {
        opacity: 1;
    }
    .owl-next {
        right: 12px;
        left: auto;
        margin-top: -12px;
        -moz-transform:rotate(180deg);
        -webkit-transform:rotate(180deg);
        -o-transform:rotate(180deg);
        -ms-transform:rotate(180deg);
        transform:rotate(180deg);
    }
    .owl-nav {
        width: 100%;
        position: absolute;
        height: 1px;
        top: 50%;
        margin-top: -8px;
    }
    </style>
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
            nav : true,
            autoplay: true,
            autoplayTimeout: 3000,
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
        $('body').on('click', '.mfp-ready', function(){
            $('.mfp-close').click();
        });
    });
    </script>
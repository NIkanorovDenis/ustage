<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$elementDraw = \Alexkova\Bxready2\Draw::getInstance($this);
?>
<?
$this->addExternalJs('/bitrix/js/alexkova.bxready2/fancybox3/jquery.fancybox.min.js');
$this->addExternalCss('/bitrix/js/alexkova.bxready2/fancybox3/jquery.fancybox.min.css');
$this->addExternalCss("/bitrix/templates/market2_v1/components/bxready.market2/block.detail/include/slider.css");
$this->addExternalJs('/bitrix/js/alexkova.bxready2/jquery.loupe.min.js');
$this->addExternalJS("/bitrix/js/alexkova.bxready2/slick/slick.js");
$this->addExternalCss("/bitrix/js/alexkova.bxready2/slick/slick.css");
?>
<div class="container-fluid">
    <div class="row">
        <? if (count($allotment_sliders_picture) > 0): ?>
            <div class="bxr-element-slider">
                <div class="bxr-element-slider-main bxr-fullsize-slider">
                    <? foreach ($allotment_sliders_picture as $key => $slide): ?>
                        <a href="<?= CFile::GetPath($slide); ?>" data-rel="gallery"
                           data-fancybox="bx-gallery" <? if ($key == 0) echo 'id="main-photo"' ?>>
                            <img class="img-responsive bxr-zoom-img" src="<?= CFile::GetPath($slide); ?>" title=""
                                 alt=""
                                 data-state="show" itemprop="image">
                        </a>
                    <? endforeach; ?>
                </div>
                <script>
                    $('.bxr-element-slider-main').slick({
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        speed: 500,
                        arrows: true,
                        prevArrow: '<button type="button" class="bxr-color-button slick-prev"></button>',
                        nextArrow: '<button type="button" class="bxr-color-button slick-next"></button>',
                        dots: false,
                        infinite: false,
                        cssEase: 'linear',
                        asNavFor: '.bxr-element-slider-nav',
                        slide: 'a'
                    });
                    $('.bxr-element-slider-nav').slick({
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        speed: 500,
                        asNavFor: '.bxr-element-slider-main',
                        arrows: true,
                        prevArrow: '<button type="button" class="bxr-color-button slick-prev"></button>',
                        nextArrow: '<button type="button" class="bxr-color-button slick-next"></button>',
                        centerPadding: 60,
                        dots: false,
                        infinite: false,
                        centerMode: false,
                        focusOnSelect: true,
                        slide: 'div'
                    });
                    $('.bxr-element-slider-main').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
                        var iIndex = nextSlide + 1;
                        $(".bxr-nav-element").eq(nextSlide).addClass("bxr-slide-active");
                        $(".bxr-nav-element").eq(nextSlide).siblings().removeClass("bxr-slide-active");
                    });
                </script>
            </div>
        <? endif; ?>
    </div>
</div>
<script type="text/javascript">
    function fancyReinit() {
        $("[data-fancybox]").fancybox({
            slideShow: false,
            fullScreen: false,
            onComplete: function () {
                $('.fancybox-thumbs').scrollbar();
                $('.scroll-bar').addClass('bxr-color');
            },
            thumbs: {
                showOnStart: true,
            },
        });
    };

    function zoomReInit() {
        $('.bxr-zoom-img').loupe({loupe: 'bxr-loupe'});
    };

    $(function () {
        fancyReinit();
    });


    $(document).on("click", ".bxr-loupe", function () {
        var src = $(this).find("img").attr("src");
        $('.bxr-zoom-img[src="' + src + '"]').closest('a.slick-active').trigger("click");
    });

</script>
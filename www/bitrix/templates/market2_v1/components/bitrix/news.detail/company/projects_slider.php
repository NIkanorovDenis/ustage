<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
?>
<?
$this->addExternalCss("/bitrix/templates/market2_v1/components/bxready.market2/block.detail/include/slider.css");
$this->addExternalJS("/bitrix/js/alexkova.bxready2/slick/slick.js");
$this->addExternalCss("/bitrix/js/alexkova.bxready2/slick/slick.css");
?>
<div class="container-fluid 2">
    <div class="row">
        <? if (count($arResult["PROPERTIES"]["PROJECTS"]["VALUE"]) > 0): ?>
                <div class="project-slider">
                    <? foreach ($arResult["PROPERTIES"]["PROJECTS"]["VALUE"] as $key => $slide): ?>

                        <?
                        $res = CIBlockElement::GetByID($slide);
                        if($ar_res = $res->GetNext()){  ?>                   
                            <div class="item">
                                <a href="<?= $ar_res["DETAIL_PAGE_URL"]; ?>" >
                                    <div class="img" style="background-image: url('<?= CFile::GetPath($ar_res["PREVIEW_PICTURE"]); ?>')"></div>
                                </a>
                                <div class="title"><a href="<?= $ar_res["DETAIL_PAGE_URL"]; ?>" ><?=$ar_res['NAME']?></a></div>
                            </div>
                        <?  }
                        ?>
                    <? endforeach; ?>
                </div>
                <script>
                    $('.project-slider').slick({
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        speed: 500,
                        arrows: true,
                        prevArrow: '<button type="button" class=" slick-prev"></button>',
                        nextArrow: '<button type="button" class=" slick-next"></button>',
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
                                breakpoint: 500,
                                settings: {
                                    slidesToShow: 1
                                }
                            }
                        ]
                    });
                    
                </script>
            </div>
        <? endif; ?>
</div>

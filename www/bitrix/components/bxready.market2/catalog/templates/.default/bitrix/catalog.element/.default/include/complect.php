<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>
<div class="bxr-detail-col bxr-detail-col-complect">
    <div class="h3"><?=($arParams["COMPLECT_TITLE"] != "") ? $arParams["COMPLECT_TITLE"] : GetMessage("COMPLECT_TITLE")?></div>
    <div class="bxr-complect-wrap">
        <?
        $elementDraw = \Alexkova\Bxready2\Draw::getInstance($this);
        $elementDraw->setCurrentTemplate($this);
        global $unicumID;
        if ($unicumID<=0) {$unicumID = 1;} else {$unicumID++;}
        ?>
        <?foreach ($arResult["COMPLECT_ITEMS"] as $key => $complect):?>
            <?$strMainID = $this->GetEditAreaId($complect['ID'] . $key);?>
            <?if ( ($key+1) == count($arResult["COMPLECT_ITEMS"])) 
                $arParams["LAST"] = "Y";?>
            <?$elementDraw->showElement("elements", "complect", $complect, $arParams);?>  
        <?endforeach;?>
    </div>
</div>
<script>
    $('.bxr-complect-wrap').slick({
            infinite: false,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 1,            
            slide: 'div',
            prevArrow: '<button type="button" class="bxr-color-button slick-prev"></button>',
            nextArrow: '<button type="button" class="bxr-color-button slick-next"></button>',
            responsive: [
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 1
                    }
                },
                {
                    breakpoint: 1919,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 2
                    }
                }
            ]
    });
</script>
<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

use Bitrix\Main\Loader;
use Bitrix\Conversion\Internals\MobileDetect;

$this->setFrameMode(true);
global $unicumID;
if ($unicumID<=0) {$unicumID = 1;} else {$unicumID++;}

$usLazyLoad = \Alexkova\Market2\Bxmarket::usLazyLoad(false, $arParams['BXR_LAZY_LOAD']);
/***parametri breakpoints of slider****/
$Sheight = $arParams["HEIGHT"];
if ($arParams["ADAPTIVE_MODE"]) {
    $arAdapt = array(
        "XS" => array("POINT" => 0, "HEIGHT" => "350px", "HIDDEN" => "N"),
        "SM" => array("POINT" => 768, "HEIGHT" => "300px", "HIDDEN" => "N"),
        "MD" => array("POINT" => 992, "HEIGHT" => "300px", "HIDDEN" => "N"),
        "LG" => array("POINT" => 1200, "HEIGHT" => "350px", "HIDDEN" => "N"),
        "XL" => array("POINT" => 1920, "HEIGHT" => $Sheight, "HIDDEN" => "N")
    );
    if($arParams["CUSTOM_BREAKPOINT"] == "Y") {
        foreach ($arAdapt as $key => $adapt) {
            $arAdapt[$key]["POINT"] = $arParams["CUSTOM_BREAKPOINT_" . $key];
            $arAdapt[$key]["HEIGHT"] = $arParams["CUSTOM_HEIGHT_" . $key];
            $arAdapt[$key]["HIDDEN"] = $arParams["CUSTOM_HIDDEN_" . $key];
            if ($arAdapt[$key]["POINT"] == "") {
                unset($arAdapt[$key]);
            }
        }
    }
}
if (count($arResult["ITEMS"])<=0) return;
$target = "";
global $fixedPanelTemplate;
$firstSlide = true;

$isMobile = true;

if (Loader::includeModule('conversion')) {
  $mobileDetect = new MobileDetect();
  $isMobile = $mobileDetect->isMobile();
}

if(isset($arParams['SLIDER_FULL_SCREEN']) && $arParams['SLIDER_FULL_SCREEN']=="N") {?>

<div class="container" <?if ($fixedPanelTemplate !== true) {?>style="margin-top:20px;"<?}?>>
    <?}?>

    <div class="bxr-slider bxr-slider_main-poster" id="slider_<?= $unicumID?>" accesskey="" style="position: relative; height: <?= $Sheight?>;">
        <?foreach ($arResult["ITEMS"] as $key => $item):
        if (($item['ID'] == '45195' || $item['ID'] == '45210') && !$isMobile) continue;
        ?>
            <?
            $name = ($item["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]) ? $item["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"] : $item["NAME"];
            ($item["PROPERTIES"]["NEW_TAB"]["VALUE"] == "Y") ? $target = "target='_blank'" : $target = "target='_self'";
            if ($item["PROPERTIES"]["LOCATION"]["VALUE"] != ""):
                $locationParts = explode(";", $item["PROPERTIES"]["LOCATION"]["VALUE"]);
                $location = $locationParts[0];
            else:
                $location = "left";
            endif;
            $bContainClass = ($item["PROPERTIES"]["BACKGROUND_SIZE"]["VALUE_XML_ID"] == "contain") ? "bxr-contain" : "";?>
			<?if($usLazyLoad && !$firstSlide):?>
				<div class="lazy container-fluid slick-slide <?=$location;?> <?=$bContainClass;?>" data-bxr-lazy="<?=$item["DETAIL_PICTURE"]["SRC"]?>">
			<?else:?>
				<div class="container-fluid slick-slide <?=$location;?> <?=$bContainClass;?>" style="background: url('<?=$item["DETAIL_PICTURE"]["SRC"]?>');">
			<?endif;?>
                <div class="row">

                    <?
                    $link = "/";
                    if(isset($item["PROPERTIES"]["LINK"]["VALUE"][0]))
                        $link = $item["PROPERTIES"]["LINK"]["VALUE"][0];
                    ?>
                    <?if ($item["PROPERTIES"]["SLIDER_LINK"]["VALUE"] == "Y"):?>
                    <a <?=$target;?> href="<?=$link;?>">
                    <?endif;?>
                        <div class="col-md-12">
                            <?
                            if ($item["PROPERTIES"]["TITLE_COLOR"]["VALUE"] != "")
                                $title_color = "#" . $item["PROPERTIES"]["TITLE_COLOR"]["VALUE"];
                            else
                                $title_color = "fff";

                            if ($item["PROPERTIES"]["TEXT_COLOR"]["VALUE"] != "")
                                $text_color = "#" . $item["PROPERTIES"]["TEXT_COLOR"]["VALUE"];
                            else
                                $text_color = "fff";
                            ?>
                            <?if ($item["PROPERTIES"]["LOCATION"]["VALUE"] != ""):?>
                                <div class="col-md-5 bxr-slider-img hidden-xs hidden-sm hidden-md pull-<?=$location?>">
                                    <?if(isset($item["PREVIEW_PICTURE"]["SRC"])):?>
                                    <img class="img-responsive" alt="<?=$item["PREVIEW_PICTURE"]["ALT"]?>" src="<?=$item["PREVIEW_PICTURE"]["SRC"]?>"  title="<?=$name?>"  data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat">
                                    <?endif;?>
                                </div>
                                <div class=" col-md-7 col-sm-8 col-xs-8 slick-banner-content <?=$location?>">
                            <?else:?>
                                <div class="col-md-12 slick-banner-content <?=$location?>">
                            <?endif;?>
                                <div class="bxr-table-cell">
                                    <?if ($item["PROPERTIES"]["DONT_SHOW_SLIDENAME"]["VALUE"] !== "Y") {?>
                                        <div class="h2" style="color: <?=$title_color?>" ><?=$name?></div>
                                    <?}?>
                                    <?if ($item["PROPERTIES"]["SHOW_PREVIEW_TEXT"]["VALUE"] == "Y"):?>
                                        <p class="visible-md visible-lg" style="color: <?=$text_color?>"><?=$item["PREVIEW_TEXT"]?></p>
                                    <? endif;?>
                                    <div class="hidden-xs slick-buttons">
                                        <?if (is_array($item["PROPERTIES"]["LINK"]["VALUE"]))
                                            foreach ($item["PROPERTIES"]["LINK"]["VALUE"] as $k => $link): ?>
                                                <?if(empty($item["PROPERTIES"]["LINK"]["DESCRIPTION"][$k]))continue;?>
                                                <div class="modern-card-buttons">
                                                    <?if ($item["PROPERTIES"]["SLIDER_LINK"]["VALUE"] != "Y"):?>
                                                        <a <?=$target;?> href="<?=$link;?>" class="bxr-slider-button bxr-color-flat bxr-bg-hover-dark-flat"><?=$item["PROPERTIES"]["LINK"]["DESCRIPTION"][$k];?></a>
                                                    <?else:?>
                                                        <span class="bxr-slider-button bxr-color-flat bxr-bg-hover-dark-flat"><?=$item["PROPERTIES"]["LINK"]["DESCRIPTION"][$k];?></span>
                                                    <? endif;?>
                                                </div>
                                            <?endforeach;?>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <?if ($item["PROPERTIES"]["SLIDER_LINK"]["VALUE"] == "Y"):?>
                    </a>
                <?endif;?>
                </div></div>
        <?$firstSlide = false;?>
        <?endforeach;?>
    </div>
    <?if(isset($arParams['SLIDER_FULL_SCREEN']) && $arParams['SLIDER_FULL_SCREEN']=="N") {?>
</div>
<?}?>
<div class="clearfix"></div>
<?
$mainId = $this->GetEditAreaId($navParams['NavNum']);
$obSlName = 'obSl'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);
?>
<script>
    (function() {
        var <?=$obSlName?> = new JCPromoControllerSlider({
            uniqId: '<?=$unicumID?>',
            dots: <?=($arParams["LIST_SLIDER_MARKERS_LISTPAGE"] == "Y") ? 'true' : 'false'?>,
            infinite: <?=($arParams["SLIDER_INFINITE"] == "Y") ? 'true' : 'false'?>,
            speed: <?= (intval($arParams['SLIDER_SPEED']) > 0) ? $arParams['SLIDER_SPEED'] : 500?>,
            autoPlay: <?=($arParams["SLIDER_AUTOPLAY"] == "Y") ? 'true' : 'false'?>,
            autoPlaySpeed: <?=intval($arParams["SLIDER_AUTOPLAY_SPEED"])>0 ? intval($arParams["SLIDER_AUTOPLAY_SPEED"]) :  2000?>,
            fade: <?= ($arParams['SLIDER_FADE']=="Y") ? "true" : "false" ?>,
            hideDesktop: <?=($arParams["HIDE_SLIDER_ARROWS_LISTPAGE"] == "Y") ? 'true' : 'false'?>,
            hideMobile: <?=($arParams["HIDE_MOBILE_SLIDER_ARROWS_LISTPAGE"] == "Y") ? 'true' : 'false'?>,
            <?if(isset($arAdapt)){?>
            break: {
                <?foreach ($arAdapt as $key => $break){
                    echo $key.":{ point:".$break["POINT"].",height:\"".$break["HEIGHT"]."\",hidden:\"".$break["HIDDEN"]."\"},";
                }?>
            }
            <?}?>
        });
    })(jQuery);
</script>

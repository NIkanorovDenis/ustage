<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
use Alexkova\Bxready2\Draw
    , Alexkova\Market2\Bxmarket;

$elementDraw = \Alexkova\Bxready2\Draw::getInstance($this);
$elementDraw->setCurrentTemplate($this);

if (!CModule::IncludeModule('alexkova.bxready2')) return;
$this->setFrameMode(true);

if (empty($arResult["BRAND_BLOCKS"]))
	return;

global $unicumID;
if ($unicumID<=0) {$unicumID = 1;} else {$unicumID++;}

$unicumID .= "_brands";

$arParams["UNICUM_ID"] = $unicumID;

$coreData = Bxmarket::getInstance()->getCoreData();

$coreData['lg_breakpoint'] = intval($coreData['lg_breakpoint'])>0 ? $coreData['lg_breakpoint'] : 1919;
$coreData['md_breakpoint'] = intval($coreData['md_breakpoint'])>0 ? $coreData['md_breakpoint'] : 1199;
$coreData['sm_breakpoint'] = intval($coreData['sm_breakpoint'])>0 ? $coreData['sm_breakpoint'] : 991;
$coreData['xs_breakpoint'] = intval($coreData['xs_breakpoint'])>0 ? $coreData['xs_breakpoint'] : 761;

$colToElem = array(
    "XLG" => 6,
    "LG" => 5,
    "MD" => 4,
    "SM" => 3,
    "XS" => 2
);
?>
<div id="c<?=intval($_REQUEST["ID"])?>" class="bxr-list bxr-brands-list bxr-cloud-all bxr-brandblock-slider-max-height" data-slider="<?=$unicumID?>" >
    <div id="sl_<?=$unicumID?>">
        <?foreach ($arResult["BRAND_BLOCKS"] as $cell => $arItem):
            $arItem["PREVIEW_PICTURE"] = $arItem["PICT"];
            $arItem["DETAIL_PAGE_URL"] = strlen($arItem["LINK"])>0 ? SITE_DIR.ltrim($arItem["LINK"], '/'): '';
            $arParams["BXREADY_ELEMENT_DRAW"] = 'brand.list.v1';
            if($arItem["ACTIVE"]){
            ?><div class="t_<?=$unicumID?> bxr-brand-item">
                    <?$elementDraw->showElement("elements", $arParams["BXREADY_ELEMENT_DRAW"], $arItem, $arParams);?>
                </div><?
            }?>
        <? endforeach; ?>
    </div>
</div>

<script>
    $(document).ready(function() {
        var obBrandsSlider = new JCCatalogBrandSlider({
            uniqId: '<?=$unicumID?>',
            dots: false,
            speed: <?=intval($arParams["BXREADY_LIST_SLIDER_SCROLLSPEED_LISTPAGE"])>0 ? intval($arParams["BXREADY_LIST_SLIDER_SCROLLSPEED_LISTPAGE"]) : 300?>,
            hideDesktop: <?=($arParams["HIDE_SLIDER_ARROWS"] != "N") ? 'true' : 'false'?>,
            hideMobile: <?=($arParams["HIDE_MOBILE_SLIDER_ARROWS"] != "N") ? 'true' : 'false'?>,
            XLG_CNT: <?=$colToElem["XLG"]?>,
            LG_CNT: <?=$colToElem["LG"]?>,
            MD_CNT: <?=$colToElem["MD"]?>,
            SM_CNT: <?=$colToElem["SM"]?>,
            XS_CNT: <?=$colToElem["XS"]?>,
            LG_BREAKPOINT: <?=$coreData['lg_breakpoint']?>,
            MD_BREAKPOINT: <?=$coreData['md_breakpoint']?>,
            SM_BREAKPOINT: <?=$coreData['sm_breakpoint']?>,
            XS_BREAKPOINT: <?=$coreData['xs_breakpoint']?>
        });
    });
</script>

<?
$this->addExternalJS(SITE_TEMPLATE_PATH.'/js/slick/slick.js');
$this->addExternalCss(SITE_TEMPLATE_PATH.'/js/slick/slick.css', false);
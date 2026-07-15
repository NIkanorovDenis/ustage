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
$this->setFrameMode(true);
use Alexkova\Bxready2\Draw;
$templateLibrary = array('popup');
$currencyList = '';
if (!empty($arResult['CURRENCIES']))
{
	$templateLibrary[] = 'currency';
	$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}
$templateData = array(
	'CURRENCIES' => $currencyList
);
unset($currencyList, $templateLibrary);

$elementDraw = \Alexkova\Bxready2\Draw::getInstance($this);

$strMainID = $this->GetEditAreaId($arResult['ID']);
$arItemIDs = array(
	'ID' => $strMainID,
        'NAME' => $strMainID.'_name',
	'PICT' => $strMainID.'_pict',
        'SLIDER_WRAP_ID' => $strMainID.'_slider_wrap',
	'SLIDER_CONT_ID' => $strMainID.'_slider_cont',
        'SLIDER_NAV_CONT_ID' => $strMainID.'_slider_nav_cont',
        'MAIN_PHOTO_ID' => $strMainID.'_main_photo',
        'MAIN_PHOTO_SMALL_ID' => $strMainID.'_main_photo_small',
	'OLD_PRICE' => $strMainID.'_old_price',
	'PRICE' => $strMainID.'_price',
	'DISCOUNT_PRICE' => $strMainID.'_price_discount',
        'COUNTDOWN_CONT_ID' => $strMainID.'_countdown_cont',
        'COUNTDOWN_ID' => $strMainID.'_countdown',
	'QUANTITY' => $strMainID.'_quantity',
	'QUANTITY_DOWN' => $strMainID.'_quant_down',
	'QUANTITY_UP' => $strMainID.'_quant_up',
	'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
	'QUANTITY_LIMIT' => $strMainID.'_quant_limit',
	'BASIS_PRICE' => $strMainID.'_basis_price',
	'BUY_LINK' => $strMainID.'_buy_link',
	'ADD_BASKET_LINK' => $strMainID.'_add_basket_link',
	'BASKET_ACTIONS' => $strMainID.'_basket_actions',
	'NOT_AVAILABLE_MESS' => $strMainID.'_not_avail',
	'COMPARE_LINK' => $strMainID.'_compare_link',
	'PROP' => $strMainID.'_prop_',
	'PROP_DIV' => $strMainID.'_skudiv',
	'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
	'OFFER_GROUP' => $strMainID.'_set_group_',
	'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
	'SUBSCRIBE_LINK' => $strMainID.'_subscribe',        
        'OFFER_JS' => $strMainID.'_offer_js',
        'SKU_WRAP' => $strMainID.'_sku_select_wrap',
        'PRICES_WRAP' => $strMainID.'_prices_wrap',
        'BASKET_BTN_WRAP' => $strMainID.'_basket_btn_wrap',
        'AVAIL_WRAP' => $strMainID.'_avail_wrap',
);
$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
$templateData['JS_OBJ'] = $strObName;

$strTitle = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]) && $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"] != ''
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
	: $arResult['NAME']
);
$strAlt = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]) && $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"] != ''
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
	: $arResult['NAME']
);

$useCompare = ('Y' == $arParams['USE_COMPARE']);
$useFavorites = ('Y' == $arParams['USE_FAVORITES']);
$useShare = ('Y' == $arParams['USE_SHARE']);
$useOneClick = ('Y' == $arParams['USE_ONE_CLICK']);

$usePriceCount = ($arParams["USE_PRICE_COUNT"] == "Y") ? true : false;
$showOldPrice = ($arParams["SHOW_OLD_PRICE"] == "Y") ? true : false;
$showDiscountPercent = ($arParams["SHOW_DISCOUNT_PERCENT"] == "Y") ? true : false;
$showDiscountValue = ($arParams["SHOW_DISCOUNT_VALUE"] == "Y") ? true : false;
$showPriceName = ($arParams["SHOW_PRICE_NAME"] == "Y") ? true : false;
$showMeasure = ($arParams["SHOW_MEASURE"] == "Y") ? true : false;

$anounceBlocksOrderParams = explode(',', $arParams["DETAIL_ANOUNCE_BLOCKS_ORDER"]);
$anounceBlocksOrder = (count($anounceBlocksOrderParams) > 0 && strlen($arParams["DETAIL_ANOUNCE_BLOCKS_ORDER"]) > 0) ? $anounceBlocksOrderParams : array('rating', 'article', 'preview_text', 'preview_props');
$buyBlocksOrderParams = explode(',', $arParams["DETAIL_BUY_BLOCKS_ORDER"]);
$buyBlocksOrder = (count($$buyBlocksOrderParams) > 0 && strlen($arParams["DETAIL_BUY_BLOCKS_ORDER"]) > 0) ? $$buyBlocksOrderParams : array('price' ,'avail', 'sku', 'buy', 'share');
?>
<div class="row">
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12 bxr-slider-detail-col">
        <div class="bxr-detail-col">
            <?
            $elementarArea = \Alexkova\Bxready2\Elementars::getArea('catalog.fast.view','element.slider');
            if (strlen($elementarArea) > 0) {
                include($elementarArea);
            } else {
                include 'include/slider.php';
            }
            ?>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12 bxr-preview-detail-col">
        <div class="bxr-detail-col" >
            <?include 'include/name.php';?>
            <?foreach ($anounceBlocksOrder as $includeName) {?>
                <?$elementarArea = \Alexkova\Bxready2\Elementars::getArea('catalog.fast.view','element.'.$includeName);
                if (strlen($elementarArea) > 0) {
                    include($elementarArea);
                } else {
                    include 'include/'.$includeName.'.php';
                }?>
            <?}?>
            <a href="<?=$arParams["DETAIL_PAGE_URL"]?>"><?=($arParams["MORE_DETAIL_INFO"])?:GetMessage("MORE_DETAIL_INFO")?></a>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12 pull-right bxr-prices-detail-col">
        <div class="bxr-right-col-detail bxr-detail-col">
            <?
            foreach ($buyBlocksOrder as $includeName) {
                if ($includeName == 'sku' && empty($arResult['OFFERS'])) continue;
                $elementarArea = \Alexkova\Bxready2\Elementars::getArea('catalog.fast.view','element.'.$includeName);
                if (strlen($elementarArea) > 0) {
                    include($elementarArea);
                } else {
                    include 'include/'.$includeName.'.php';
                }
            }
            ?>
        </div>
    </div>
</div>
        
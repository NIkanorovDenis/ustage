<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
/** @var array $templateData */
/** @var @global CMain $APPLICATION */
global $MESS;
include_once(GetLangFileName(dirname(__FILE__) . '/lang/', '/template.php'));

global $APPLICATION;

if (substr_count($arParams["DETAIL_PICTURE_MODE"], "ZOOM") > 0) 
    $APPLICATION->AddHeadScript("/bitrix/js/alexkova.bxready2/jquery.loupe.min.js");

$APPLICATION->AddHeadScript('/bitrix/js/alexkova.bxready2/slick/slick.js', true);
$APPLICATION->SetAdditionalCSS('/bitrix/js/alexkova.bxready2/slick/slick.css', false);

if ($arResult["SHOW_TIMER"]) {
    $APPLICATION->AddHeadScript('/bitrix/js/alexkova.bxready2/countdown/countdown.js', true);
    $APPLICATION->SetAdditionalCSS('/bitrix/js/alexkova.bxready2/countdown/countdown.css', false);
}    

if (substr_count($arParams["DETAIL_PICTURE_MODE"], "POPUP") > 0 || count($arResult["SCHEMES"]) || isset($arParams["SHOW_OFFER_PIC_BYCLICK"]) && $arParams["SHOW_OFFER_PIC_BYCLICK"] == "Y") {
    $APPLICATION->AddHeadScript('/bitrix/js/alexkova.bxready2/fancybox3/jquery.fancybox.min.js');
    $APPLICATION->SetAdditionalCSS('/bitrix/js/alexkova.bxready2/fancybox3/jquery.fancybox.min.css');
}

Bitrix\Catalog\CatalogViewedProductTable::refresh($arResult['ID'], CSaleBasket::GetBasketUserID(true));
$GLOBALS["CURRENT_ELEMENT_ID"] = $arResult["ID"];
?>

            <div class="row">
                <div class="col-xs-12">
                    <div class="bxr-detail-epilog">
                        <a href="<?=$arResult['SECTION']['SECTION_PAGE_URL']?>" class="bxr-color-button bxr-element-get-back">
                            <i class="fa fa-angle-left"></i><?=GetMessage('BXR_GET_BACK')?>
                        </a>
                        <?if ('Y' == $arParams['USE_SHARE']) {?>
                            <div class="bxr-share-wrap">
                                <span class="bxr-share-title"><?=GetMessage("BXR_SHARE_TITLE")?></span>
                                <?$APPLICATION->IncludeComponent(
                                        "bitrix:main.share",
                                        "element_detail",
                                        Array(
                                                "COMPONENT_TEMPLATE" => ".default",
                                                "HANDLERS" => $arParams["HANDLERS"],
                                                "HIDE" => "N",
                                                "PAGE_TITLE" => $arResult["NAME"],
                                                "PAGE_URL" => $arResult["DETAIL_PAGE_URL"],
                                                "SHORTEN_URL_KEY" => "",
                                                "SHORTEN_URL_LOGIN" => ""
                                        ),
                                        false,
                                        array("HIDE_ICONS" => "Y")
                                );?> 
                            </div>
                        <?}?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?
if ($arResult['UNCACHED_PROPS']['BXR_COLLECTION'] == 'Y') {
	$marketRegistry = \Alexkova\Market2\Bxmarket::getInstance();
	$marketRegistry->setContentData(array('collection' => 'Y'));
}
?>
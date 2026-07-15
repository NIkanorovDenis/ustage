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
$this->addExternalCss("/bitrix/css/main/bootstrap.css");

$templateData = array(
    'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
    'TEMPLATE_CLASS' => 'bx-'.$arParams['TEMPLATE_THEME'],
    'CURRENCIES' => CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true)
);
$curJsId = $this->randString();
?>
<div id="bx-set-const-<?=$curJsId?>" class="bx-set-constructor <?=$templateData['TEMPLATE_CLASS'];?>">
    <div class="row">
        <div class="col-xs-12">
            <strong class="bx-modal-small-title"><?=GetMessage("CATALOG_SET_BUY_SET")?></strong>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3 col-xl-4">
            <div class="bx-original-item-container">
                <div class="bxr-element-image">
                    <?if ($arResult["ELEMENT"]["DETAIL_PICTURE"]["src"]):?>
                        <img src="<?=$arResult["ELEMENT"]["DETAIL_PICTURE"]["src"]?>" alt="">
                    <?else:?>
                        <img src="<?=$this->GetFolder().'/images/no_foto.png'?>" alt="">
                    <?endif?>              
                </div>
                <div class="bxr-element-name bxr-font-color bxr-font-color-hover" id="bxr-element-name-<?=$arElement["ID"]?>">
                    <?=$arResult["ELEMENT"]["NAME"]?>
                </div>
                <div class="bxr-market-item-price bxr-format-price">
                    <?if (!($arResult["ELEMENT"]["PRICE_VALUE"] == $arResult["ELEMENT"]["PRICE_DISCOUNT_VALUE"])):?>
                        <span class="bxr-market-old-price"><?= Alexkova\Market2\Core::bxrFormatPrice($arResult["ELEMENT"]["PRICE_PRINT_VALUE"], false, true, true)?></span>
                    <?endif?>
                    <span class="bxr-market-current-price bxr-market-format-price">
                        <?= Alexkova\Market2\Core::bxrFormatPrice($arResult["ELEMENT"]["PRICE_PRINT_DISCOUNT_VALUE"], false, true)?><span class="bxr-detail-currency">* <?=$arResult["ELEMENT"]["BASKET_QUANTITY"];?> <?=$arResult["ELEMENT"]["MEASURE"]["SYMBOL_RUS"];?></span>
                    </span>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>

        <div class="col-sm-9 col-xl-8 col-xs-12 bxr-right-zero">
            <div class="col-xs-12 bxr-left-zero">
                <div class="bx-added-item-table-container">
                        <table class="bx-added-item-table">
                                <tbody data-role="set-items">
                                <?foreach($arResult["SET_ITEMS"]["DEFAULT"] as $key => $arItem):?>
                                        <tr
                                                data-id="<?=$arItem["ID"]?>"
                                                data-img="<?=$arItem["DETAIL_PICTURE"]["src"]?>"
                                                data-url="<?=$arItem["DETAIL_PAGE_URL"]?>"
                                                data-name="<?=$arItem["NAME"]?>"
                                                data-price="<?=$arItem["PRICE_DISCOUNT_VALUE"]?>"
                                                data-print-price="<?=$arItem["PRICE_PRINT_DISCOUNT_VALUE"]?>"
                                                data-old-price="<?=$arItem["PRICE_VALUE"]?>"
                                                data-print-old-price="<?=$arItem["PRICE_PRINT_VALUE"]?>"
                                                data-diff-price="<?=$arItem["PRICE_DISCOUNT_DIFFERENCE_VALUE"]?>"
                                                data-measure="<?=$arItem["MEASURE"]["SYMBOL_RUS"];?>"
                                                data-quantity="<?=$arItem["BASKET_QUANTITY"];?>"
                                        >
                                                <td class="bx-added-item-table-cell-img">
                                                        <?if ($arItem["DETAIL_PICTURE"]["src"]):?>
                                                                <img src="<?=$arItem["DETAIL_PICTURE"]["src"]?>" class="img-responsive" alt="">
                                                        <?else:?>
                                                                <img src="<?=$this->GetFolder().'/images/no_foto.png'?>" class="img-responsive" alt="">
                                                        <?endif?>
                                                </td>
                                                <td class="bx-added-item-table-cell-itemname">
                                                        <a class="tdn" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
                                                </td>
                                                <td class="bx-added-item-table-cell-price">
                                                        <span class="bx-added-item-new-price"><?=$arItem["PRICE_PRINT_DISCOUNT_VALUE"]?> * <?=$arItem["BASKET_QUANTITY"];?> <?=$arItem["MEASURE"]["SYMBOL_RUS"];?></span>
                                                        <?if ($arItem["PRICE_VALUE"] != $arItem["PRICE_DISCOUNT_VALUE"]):?>
                                                                <br><span class="bx-added-item-old-price"><?=$arItem["PRICE_PRINT_VALUE"]?></span>
                                                        <?endif?>
                                                </td>
                                                <td class="bx-added-item-table-cell-del"><div class="bx-added-item-delete" data-role="set-delete-btn"></div></td>
                                        </tr>
                                <?endforeach?>
                                </tbody>
                        </table><div style="display: none;margin:20px;" data-set-message="empty-set"></div>
                </div>
            </div>
            <div class="col-xs-12 bxr-left-zero">
                <div class="bx-catalog-set-topsale-slider" <?=(count($arResult["SET_ITEMS"]["OTHER"]) == 0)?" style='display:none;'":""?>>
                        <div class="bx-catalog-set-topsale-slider-box">
                                <div class="bx-catalog-set-topsale-slider-container">
                                        <div class="bx-catalog-set-topsale-slids bx-catalog-set-topsale-slids-<?=$curJsId?>" data-role="set-other-items">
                                                <?
                                                $first = true;
                                                foreach($arResult["SET_ITEMS"]["OTHER"] as $key => $arItem):?>
                                                        <div class="bx-catalog-set-item-container bx-catalog-set-item-container-<?=$curJsId?>"
                                                                data-id="<?=$arItem["ID"]?>"
                                                                data-img="<?=$arItem["DETAIL_PICTURE"]["src"]?>"
                                                                data-url="<?=$arItem["DETAIL_PAGE_URL"]?>"
                                                                data-name="<?=$arItem["NAME"]?>"
                                                                data-price="<?=$arItem["PRICE_DISCOUNT_VALUE"]?>"
                                                                data-print-price="<?=$arItem["PRICE_PRINT_DISCOUNT_VALUE"]?>"
                                                                data-old-price="<?=$arItem["PRICE_VALUE"]?>"
                                                                data-print-old-price="<?=$arItem["PRICE_PRINT_VALUE"]?>"
                                                                data-diff-price="<?=$arItem["PRICE_DISCOUNT_DIFFERENCE_VALUE"]?>"
                                                                data-measure="<?=$arItem["MEASURE"]["SYMBOL_RUS"];?>"
                                                                data-quantity="<?=$arItem["BASKET_QUANTITY"];?>"<?
                                                        if (!$arItem['CAN_BUY'] && $first)
                                                        {
                                                                echo 'data-not-avail="yes"';
                                                                $first = false;
                                                        }
                                                        ?>
                                                        >
                                                                <div class="bx-catalog-set-item">
                                                                        <div class="bx-catalog-set-item-img">
                                                                                <div class="bx-catalog-set-item-img-container">
                                                                                        <?if ($arItem["DETAIL_PICTURE"]["src"]):?>
                                                                                                <img src="<?=$arItem["DETAIL_PICTURE"]["src"]?>" class="img-responsive" alt=""/>
                                                                                        <?else:?>
                                                                                                <img src="<?=$this->GetFolder().'/images/no_foto.png'?>" class="img-responsive"/>
                                                                                        <?endif?>
                                                                                </div>
                                                                        </div>
                                                                        <div class="bx-catalog-set-item-title">
                                                                                <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
                                                                        </div>
                                                                        <div class="bx-catalog-set-item-price">
                                                                                <div class="bx-catalog-set-item-price-new"><?=$arItem["PRICE_PRINT_DISCOUNT_VALUE"]?> * <?=$arItem["BASKET_QUANTITY"];?> <?=$arItem["MEASURE"]["SYMBOL_RUS"];?></div>
                                                                                <?if ($arItem["PRICE_VALUE"] != $arItem["PRICE_DISCOUNT_VALUE"]):?>
                                                                                        <div class="bx-catalog-set-item-price-old"><?=$arItem["PRICE_PRINT_VALUE"]?></div>
                                                                                <?endif?>
                                                                        </div>
                                                                        <div class="bx-catalog-set-item-add-btn">
                                                                                <?
                                                                                if ($arItem['CAN_BUY'])
                                                                                {
                                                                                        ?><a href="javascript:void(0)" data-role="set-add-btn" class="btn btn-default btn-sm bxr-color-button"><?=GetMessage("CATALOG_SET_BUTTON_ADD")?></a><?
                                                                                }
                                                                                else
                                                                                {
                                                                                        ?><span class="bx-catalog-set-item-notavailable"><?=GetMessage('CATALOG_SET_MESS_NOT_AVAILABLE');?></span><?
                                                                                }
                                                                                ?>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                <?endforeach?>
                                        </div>
                                </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-right: 0px !important;">        
            <div class="col-xs-12 bxr-set-result">
                <div class="col-xl-9 col-lg-9 col-md-8 col-sm-8 col-xs-7">
                        <table class="bx-constructor-result-table">
                                <tr style="display: <?=($arResult['SHOW_DEFAULT_SET_DISCOUNT'] ? 'table-row' : 'none'); ?>;">
                                        <td class="bx-constructor-result-table-title"><?=GetMessage("CATALOG_SET_PRODUCTS_PRICE")?>:</td>
                                        <td class="bx-constructor-result-table-value">
                                                <strong data-role="set-old-price"><?= Alexkova\Market2\Core::bxrFormatPrice($arResult["SET_ITEMS"]["OLD_PRICE"], false, true)?></strong>
                                        </td>
                                </tr>
                                <tr>
                                        <td class="bx-constructor-result-table-title"><?=GetMessage("CATALOG_SET_SET_PRICE")?>:</td>
                                        <td class="bx-constructor-result-table-value">
                                                <strong data-role="set-price"><?= Alexkova\Market2\Core::bxrFormatPrice($arResult["SET_ITEMS"]["PRICE"], false, true)?></strong>
                                        </td>
                                </tr>
                                <tr style="display: <?=($arResult['SHOW_DEFAULT_SET_DISCOUNT'] ? 'table-row' : 'none'); ?>;">
                                        <td class="bx-constructor-result-table-title"><?=GetMessage("CATALOG_SET_ECONOMY_PRICE")?>:</td>
                                        <td class="bx-constructor-result-table-value">
                                                <strong data-role="set-diff-price"><?= Alexkova\Market2\Core::bxrFormatPrice($arResult["SET_ITEMS"]["PRICE_DISCOUNT_DIFFERENCE"], false, true)?></strong>
                                        </td>
                                </tr>
                        </table>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-xs-5" style="text-align: right; padding-right: 0px !important;">
                        <div class="bx-constructor-result-btn-container">
                                <span class="bx-constructor-result-price" data-role="set-price-duplicate">
                                    <?= Alexkova\Market2\Core::bxrFormatPrice($arResult["SET_ITEMS"]["PRICE"], false, true)?>
                                </span>
                        </div>
                        <div class="bx-constructor-result-btn-container">
                                <a href="javascript:void(0)" data-role="set-buy-btn" class="btn btn-default btn-sm bxr-color-button"
                                        <?=($arResult["ELEMENT"]["CAN_BUY"] ? '' : 'style="display: none;"')?>>
                                        <?=GetMessage("CATALOG_SET_BUY")?>
                                </a>
                        </div>
                </div>                    
            </div>
    </div>
</div>
<?
$arJsParams = array(
	"numSliderItems" => count($arResult["SET_ITEMS"]["OTHER"]),
	"numSetItems" => count($arResult["SET_ITEMS"]["DEFAULT"]),
	"jsId" => $curJsId,
	"parentContId" => "bx-set-const-".$curJsId,
	"ajaxPath" => $this->GetFolder().'/ajax.php',
	"canBuy" => $arResult["ELEMENT"]["CAN_BUY"],
	"currency" => $arResult["ELEMENT"]["PRICE_CURRENCY"],
	"mainElementPrice" => $arResult["ELEMENT"]["PRICE_DISCOUNT_VALUE"],
	"mainElementOldPrice" => $arResult["ELEMENT"]["PRICE_VALUE"],
	"mainElementDiffPrice" => $arResult["ELEMENT"]["PRICE_DISCOUNT_DIFFERENCE_VALUE"],
	"mainElementBasketQuantity" => $arResult["ELEMENT"]["BASKET_QUANTITY"],
	"lid" => SITE_ID,
	"iblockId" => $arParams["IBLOCK_ID"],
	"basketUrl" => $arParams["BASKET_URL"],
	"setIds" => $arResult["DEFAULT_SET_IDS"],
	"offersCartProps" => $arParams["OFFERS_CART_PROPERTIES"],
	"itemsRatio" => $arResult["BASKET_QUANTITY"],
	"noFotoSrc" => $this->GetFolder().'/images/no_foto.png',
	"messages" => array(
		"EMPTY_SET" => GetMessage('CT_BCE_CATALOG_MESS_EMPTY_SET'),
		"ADD_BUTTON" => GetMessage("CATALOG_SET_BUTTON_ADD")
	)
);
?>
<script type="text/javascript">
	BX.ready(function(){
		new BX.Catalog.SetConstructor(<?=CUtil::PhpToJSObject($arJsParams, false, true, true)?>);
	});
</script>

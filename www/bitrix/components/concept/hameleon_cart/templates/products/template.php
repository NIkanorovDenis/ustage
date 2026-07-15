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
global $DB_cham;
?>
                                       
<table class="product mobile-break">
<tbody>

<?foreach ($arResult["ITEMS"] as $arItem):?>

    <tr class="product-element parent-preload-circleG-wrap clearfix">

        <td class="td-lvl-1 product-info col-lg-6 col-md-6 col-sm-6 col-xs-12">

            <table>
                <tbody>
                    <tr>
                        <td class="img">
                            <?if($arItem["PROPERTIES"]["PICTURES"]["VALUE"][0] > 0):?>

                                <?if($arItem["PROPERTIES"]["RESIZE_IMAGES"]["VALUE_XML_ID"] == "scale"):?>
                                    <?$img_big = CFile::ResizeImageGet($arItem["PROPERTIES"]["PICTURES"]["VALUE"][0], array('width'=>70, 'height'=>70), BX_RESIZE_IMAGE_PROPORTIONAL, false, Array(), false, $img_quality);?>
                                <?else:?>
                                    <?$img_big = CFile::ResizeImageGet($arItem["PROPERTIES"]["PICTURES"]["VALUE"][0], array('width'=>70, 'height'=>70), BX_RESIZE_IMAGE_EXACT, false, Array(), false, $img_quality);?>
                                <?endif;?>
                            
                                <img alt="<?=$arItem["NAME"]?>" class="img-responsive" src="<?=$img_big["src"]?>">

                            <?else:?>
                                <img alt="<?=$arItem["NAME"]?>" class="img-responsive" src="<?=SITE_TEMPLATE_PATH?>/images/catalog.png">
                            <?endif;?>
                        </td>


                        <td class="name">
                            <div class="main bold"><?=$arItem["~NAME"]?></div>

                            <?if(strlen($arItem["PROPERTIES"]["BOX_ARTICULE"]["~VALUE"])>0):?>
                                <div class="other"><?=$arItem["PROPERTIES"]["BOX_ARTICULE"]["~VALUE"]?></div>
                            <?endif;?>

                            <?if(strlen($arItem["OTHER_COMPLECT"]["VALUE"]) > 0):?>
                                <div class="other"><?=$arItem["OTHER_COMPLECT"]["NAME"]?></div>
                            <?endif;?>
                        </td>
                    </tr>
                </tbody>
            </table>

        </td>


        <td class="td-lvl-1 counter col-lg-2 col-md-2 col-sm-2 col-xs-12">

            <div class="count-box parent-calcbox">
                <input class = "other_complect_box" type="hidden" value = "<?=$arItem["OTHER_COMPLECT"]["VALUE"]?>">
                <table>
                    <tbody>
                        <tr>
                            <td class="left minus count-minus click_box" data-box-action="update" data-box-id="<?=$arItem["ID"]?>"><div></div></td>
                            <td class="center"><input class="count-val" name="count-box" type="text" value="<?=$arItem["PROPERTIES"]["BOX_PRICE_STEP_"]["VALUE"]?>" data-box-action="update" data-box-id="<?=$arItem["ID"]?>" data-box-step="<?=$arItem["PROPERTIES"]["BOX_PRICE_STEP"]["VALUE"]?>" data-box-min="<?=$arItem["PROPERTIES"]["BOX_MIN_COUNT"]["VALUE"]?>" data-box-step="<?=$arItem["PROPERTIES"]["BOX_PRICE_STEP"]["VALUE"]?>"></td>
                            <td class="right plus count-plus click_box" data-box-action="update" data-box-id="<?=$arItem["ID"]?>"><div ></div></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <?if(strlen($arItem["PROPERTIES"]["BOX_PRICE"]["VALUE"])>0):?>

                <div class="price-unit"> 
                    <?=$arItem["PROPERTIES"]["BOX_PRICE_FORMAT"]["VALUE"]?>
                </div>

            <?endif;?>

        </td>


        <td class="td-lvl-1 price col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <?if($arItem["PROPERTIES"]["BOX_PRICE_COUNT"]["VALUE"]>0 || $arItem["PROPERTIES"]["REQUEST_PRICE"]["VALUE"] == "Y"):?>

                <div class="price-one bold parent-preload-circleG">
                    <div class="circleG-opacity"><?=$arItem["PROPERTIES"]["BOX_PRICE_COUNT_FORMAT"]["VALUE"]?></div>

                    <div class="circleG-wrap small">
                        <div class="circleG circleG_1"></div>
                        <div class="circleG circleG_2"></div>
                        <div class="circleG circleG_3"></div>
                    </div>
                </div>
            <?endif;?>
       

            <?if($arItem["PROPERTIES"]["BOX_OLD_PRICE_COUNT"]["VALUE"]>0 && $arItem["PROPERTIES"]["REQUEST_PRICE"]["VALUE"] != "Y"):?>
                <div class="price-old parent-preload-circleG">
                    <div class="circleG-opacity"><?=$arItem["PROPERTIES"]["BOX_OLD_PRICE_COUNT_FORMAT"]["VALUE"]?></div>
                    
                    <div class="circleG-wrap small">
                        <div class="circleG circleG_1"></div>
                        <div class="circleG circleG_2"></div>
                        <div class="circleG circleG_3"></div>
                    </div>
                </div>
            <?endif;?>
        </td>


        <td class="td-lvl-1 remove-wrap col-lg-1 col-md-1 col-sm-1 col-xs-12">
            <div>

                <a class="remove click_box" data-box-id="<?=$arItem["ID"]?>" data-box-action="delete"></a>

            </div>

        </td>

    </tr>

<?endforeach;?>

</tbody>
</table>


                                        
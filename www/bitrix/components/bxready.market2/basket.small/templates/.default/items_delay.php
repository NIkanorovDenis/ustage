<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if(isset($arResult["BASKET_ITEMS"]) && !empty($arResult["BASKET_ITEMS"]["DELAY"])){?>
    <div class="bxr-content-scroll">
        <table>
            <tr>
                <th colspan="2" class="first"><?=GetMessage('BASKET_TD_NAME')?></th>
                <th><?=GetMessage('BASKET_TD_PRICE')?></th>
                <th class="last">&nbsp;</th>
            </tr>
            <?foreach($arResult["BASKET_ITEMS"]["DELAY"] as $arBasketItem):
                $pictureID = (!empty($arResult["CATALOG"][$arBasketItem["PRODUCT_ID"]]["PREVIEW_PICTURE"])) ? $arResult["CATALOG"][$arBasketItem["PRODUCT_ID"]]["PREVIEW_PICTURE"] : "";
                $pictureID = (empty($pictureID) && !empty($arResult["CATALOG"][$arBasketItem["PRODUCT_ID"]]["DETAIL_PICTURE"])) ? $arResult["CATALOG"][$arBasketItem["PRODUCT_ID"]]["DETAIL_PICTURE"] : $pictureID;

                if (!empty($pictureID)){
                    $metrics = array('width' => 54, 'height' => 54) ;
                    $resizedImage = \CFile::ResizeImageGet($pictureID, $metrics, BX_RESIZE_IMAGE_PROPORTIONAL, true);
                    if (strlen($resizedImage["src"])>0) 
                        $img = $resizedImage["src"];
                    else
                        $img = $arBasketItem["PICTURE"];
                } 
                else {
                    $img = $arBasketItem["PICTURE"];
                }

                $img = (strlen($img)>0)
                    ? '<a href="'.$arBasketItem["URL"].'"
                            style="background: url('.$img.') no-repeat center center;
                            background-size: contain;
                            " title="'.$arBasketItem["NAME"].'" alt="'.$arBasketItem["NAME"].'"></a>'
                    : "&nbsp;";
                ?>
                <tr>
                    <td class="basket-image first">
                        <?=$img?>
                    </td>
                    <td class="basket-name xs-hide">
                        <a href="<?=$arBasketItem["URL"]?>" class="bxr-font-hover-light"><?=$arBasketItem["NAME"]?></a>
                        <?if(is_array($arBasketItem["PROPS"])) {
                            foreach ($arBasketItem["PROPS"] as $prop) {?>
                            <div class="bxr-bsmall-prop"><?=$prop["NAME"]?>: <?=$prop["VALUE"]?></div>
                        <?}}?>
                    </td>
                    <td class="basket-price bxr-format-price"><?=Alexkova\Market2\Core::bxrFormatPrice($arBasketItem['FORMAT_PRICE'], false, true)?></td>
                    <td class="basket-action last">
                        <button id="button-delay-<?=$arBasketItem["ID"]?>" class="bxr-indicator-item icon-button-cart" value="" data-item="<?=$arBasketItem["ID"]?>" title="<?=GetMessage("SALE_ADD_TO_BASKET")?>">
                                <span class="fa fa-shopping-basket" aria-hidden="true"></span>
                        </button>
                        <button id="button-delay-<?=$arBasketItem["ID"]?>" class="bxr-indicator-item icon-button-delete" value="" data-item="<?=$arBasketItem["ID"]?>" title="<?=GetMessage("SALE_DELETE")?>">
                                <span class="fa fa-close" aria-hidden="true"></span>
                        </button>
                    </td>
                </tr>
            <?endforeach;?>
        </table>
    </div>
<?}else{?>
	<p class="bxr-helper bg-info">
		<?=GetMessage('BASKET_DELAY_EMPTY')?>
	</p>
<?}?>
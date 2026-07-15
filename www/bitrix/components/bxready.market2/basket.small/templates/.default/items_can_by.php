<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (isset($arResult["BASKET_ITEMS"]) && !empty($arResult["BASKET_ITEMS"]["CAN_BUY"])){?>
    <div class="bxr-content-scroll">
        <table>
            <tr>
                <th colspan="2" class="first"><?=GetMessage('BASKET_TD_NAME')?></th>
                <th><?=GetMessage('BASKET_TD_PRICE')?></th>
                <th><?=GetMessage('BASKET_TD_QTY')?></th>
                <th><?=GetMessage('BASKET_TD_SUM')?></th>
                <th class="last">&nbsp;</th>
            </tr>
            <?foreach($arResult["BASKET_ITEMS"]["CAN_BUY"] as $arBasketItem):
                $pictureID = (!empty($arResult["CATALOG"][$arBasketItem["PRODUCT_ID"]]["PREVIEW_PICTURE"])) ? $arResult["CATALOG"][$arBasketItem["PRODUCT_ID"]]["PREVIEW_PICTURE"] : "";
                $pictureID = (empty($pictureID) && !empty($arResult["CATALOG"][$arBasketItem["PRODUCT_ID"]]["DETAIL_PICTURE"])) ? $arResult["CATALOG"][$arBasketItem["PRODUCT_ID"]]["DETAIL_PICTURE"] : $pictureID;

				//Фотка торгового предложения (если есть)
				if(CModule::IncludeModule("iblock")) {
					$SKU_ID = $arBasketItem["PRODUCT_ID"];
					$res = CIBlockElement::GetByID($SKU_ID);
					if($row = $res->GetNext()) {
						$db_props = CIBlockElement::GetProperty(33, $row['ID'], array("sort" => "asc"), Array("CODE"=>"PICTURES_SKU"));
						if($ar_props = $db_props->Fetch()) {
							if (!empty($ar_props["VALUE"])) $pictureID = $ar_props["VALUE"];
						}
					}
				}

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
                    <td class="basket-image first"><?=$img?></td>
                    <td class="basket-name xs-hide">
                        <a href="<?=$arBasketItem["URL"]?>" class="bxr-font-hover-light"><?=$arBasketItem["NAME"]?></a>
                        <?  if(is_array($arBasketItem["PROPS"])) {
                            foreach ($arBasketItem["PROPS"] as $prop) {?>
                            <div class="bxr-bsmall-prop"><?=$prop["NAME"]?>: <?=$prop["VALUE"]?></div>
                        <?}}?>
                    </td>
                    <td class="basket-price bxr-format-price"><?=Alexkova\Market2\Core::bxrFormatPrice($arBasketItem['FORMAT_PRICE'], false, true)?></td>
                    <td class="basket-line-qty xs-hide sm-hide">
                        <div class="bxr-basket-group">
                            <input type="button" class="bxr-quantity-button-minus" value="-" data-item="<?=$arBasketItem["ID"]?>" data-ratio="<?=$arBasketItem["RATIO"]?>" data-operation="auto_save" title="<?=GetMessage("SALE_QUANTITY_MINUS")?>">
                            <input type="text" value="<?=$arBasketItem["QUANTITY"]?>" class="bxr-quantity-text" name="quantity" data-item="<?=$arBasketItem["ID"]?>">
                            <input type="button" class="bxr-quantity-button-plus" value="+" data-item="<?=$arBasketItem["ID"]?>" data-ratio="<?=$arBasketItem["RATIO"]?>" data-operation="auto_save" data-max="<?=$arBasketItem["QTY_MAX"]?>" title="<?=GetMessage("SALE_QUANTITY_PLUS")?>">
                        </div>
                    </td>
                    <td class="basket-summ bxr-format-price"><?=Alexkova\Market2\Core::bxrFormatPrice($arBasketItem['FORMAT_SUMM'], false, true)?></td>
                    <td class="basket-action last">
                        <?if(!isset($arParams["USE_DELAY"]) || $arParams["USE_DELAY"]=="Y"):?>
                            <button id="button-delay-<?=$arBasketItem["ID"]?>" class="bxr-indicator-item icon-button-delay" value="" data-item="<?=$arBasketItem["ID"]?>" title="<?=GetMessage("SALE_DELAY")?>">
                                <span class="fa fa-level-up"></span>
                            </button>
                        <?endif;?>
                        <button id="button-delay-<?=$arBasketItem["ID"]?>" class="bxr-indicator-item icon-button-delete" value="" data-item="<?=$arBasketItem["ID"]?>" title="<?=GetMessage("SALE_DELETE")?>">
                            <span class="fa fa-close"></span>
                        </button>
                    </td>
                </tr>
            <?endforeach;?>
        </table>
    </div>
    <div class="basket-footer">
        <?if ($arResult["SUMM"] >= $arResult["MIN_ORDER_PRICE"]):?>
            <div><a href="<?=$arParams["PATH_TO_BASKET"];?>"><?=GetMessage('GO_IN_BASKET')?></a></div>
        <?endif;?>
        <div><b class="bxr-format-price"><?=GetMessage('BASKET_PRODUCTS')?>: <span><?=Alexkova\Market2\Core::bxrFormatPrice($arResult['FORMAT_SUMM'], false, true)?></span></b></div>
        <?if ($arResult["SUMM"] >= $arResult["MIN_ORDER_PRICE"]):?>
            <div>
              <?
              $bxr_one_click_order_basket = COption::GetOptionString('alexkova.market2', "bxr_one_click_order_basket", "N");
              if ($bxr_one_click_order_basket == "Y") {
                ?>
                <button type="button" class="bxr-color-button bxr-one-click-order-basket" data-toggle="modal" data-target="#bxr-one-click-order"><?=GetMessage("ONE_CLICK_ORDER")?></button>
                <?
              }?>

              <a href="<?=$arParams["PATH_TO_ORDER"]?>" class="bxr-color-button"><?=GetMessage('BASKET_TO_ORDER')?></a>
            </div>
        <?endif;?>
    </div>
<?}else{?>
    <p class="bxr-helper bg-info"><?=GetMessage('BASKET_DROP_EMPTY')?></p>
<?}?>

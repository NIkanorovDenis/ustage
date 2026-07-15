<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>
<?/*
echo "<pre>";
print_r($arResult['OFFERS']);
echo "</pre>";
echo "<pre>";
print_r($arResult);
echo "</pre>";*//*return false;*/
/*echo "<pre>";
print_r($arResult["OFFERS"]);
echo "</pre>";*/
?>
<table class="bxr-sku-list-in-detail" width="100%">
    <tbody>
        <?  foreach ($arResult["OFFERS"] as $key => $offer) {
            $propsStr = "";
            $arServiceProperties = array(
                "BXR_PRICE" => array(),
                "BXR_DISCOUNT_PRICE" => array(),
                "BXR_UNIT_PRICE" => array(),
                "BXR_DISCOUNT_PERIOD_FROM" => array(),
                "BXR_DISCOUNT_PERIOD_TO" => array(),
                "BXR_AVAILABILITY_INDICATOR" => array(),
            );
            $offer["DISPLAY_PROPERTIES"] = array_diff_assoc($offer["PROPERTIES"], $arServiceProperties);
            foreach($offer["DISPLAY_PROPERTIES"] as $propCode => $arProp):
                $printValue = "";?>
                <? if (in_array("PROPERTY_".$arProp["CODE"], $arParams["SKU"]["SKU_PROPERTY_CODE"])): 
                    $sPropId = $arResult["SKU_PROPS"][$propCode]["XML_MAP"][$arProp["VALUE"]];
                    if ($arProp["PROPERTY_TYPE"] == "E" && strlen($arResult["SKU_PROPS"][$propCode]["VALUES"][$arProp["VALUE"]]["NAME"]) > 0) {
                        $printValue = $arProp["NAME"].": ".$arResult["SKU_PROPS"][$propCode]["VALUES"][$arProp["VALUE"]]["NAME"];
                    } else if ($arProp["PROPERTY_TYPE"] == "S" && strlen($arResult["SKU_PROPS"][$propCode]["VALUES"][$sPropId]["NAME"]) > 0) {
                        echo '1';
                        $printValue = $arProp["NAME"].": ".$arResult["SKU_PROPS"][$propCode]["VALUES"][$sPropId]["NAME"];
                    } else if ($arProp["PROPERTY_TYPE"] == "L" && $arProp["MULTIPLE"] == "Y" && $arProp["VALUE"]) {
                            $printValue = $arProp["NAME"].": ";
                            $valueCount = count($arProp["VALUE"])-1;
                            foreach ($arProp["VALUE"] as $key => $value)
                            {
                                $printValue .= $value;
                                if ($key!=$valueCount) $printValue .= ',';
                            }
                    } else if (strlen($arProp["VALUE"]) > 0) {
                            $printValue = $arProp["NAME"].": ".$arProp["VALUE"];
                    }
                    ?>
                    <?
                        if(!empty($printValue))
                            $propsStr .= $printValue.", ";
                    ?>
                <? endif;?>
            <?endforeach;?>
            <?$propsStr = rtrim($propsStr, ", ");?>
        <?            
            $this->AddEditAction($offer['ID'], $offer['EDIT_LINK'], CIBlock::GetArrayByID($offer["IBLOCK_ID"], "ELEMENT_EDIT"));
        ?>
        <tr data-offer-id="<?=$offer["ID"]?>" id="<?=$this->GetEditAreaID($offer["ID"])?>">
            <td class="basket-image first hidden-xs">
                <?
                    if (is_array($offer["PREVIEW_PICTURE"])) {
                        $src = $offer["PREVIEW_PICTURE"]["SRC"];
                    } elseif (intval($offer["PREVIEW_PICTURE"]) > 0) {
                        $src = CFile::GetPath($offer["PREVIEW_PICTURE"]);
                    } elseif (is_array($offer["DETAIL_PICTURE"])) {
                        $src = $offer["DETAIL_PICTURE"]["SRC"];
                    } elseif (intval($offer["DETAIL_PICTURE"]) > 0) {
                        $src = CFile::GetPath($offer["DETAIL_PICTURE"]);
                    } elseif ($arResult["MORE_PHOTO"][0]["SRC"]) {
                        $src = $arResult["MORE_PHOTO"][0]["SRC"];
                    } else {
                        $src = SITE_TEMPLATE_PATH."/images/no-photo.png";
                    }
                ?>                
                <a href="<?=$src?>"  class="bxr-offer-img-in-list fancybox">
                    <img src="<?=$src?>" itemprop="image" alt="<?=$offer["NAME"]?>">
                </a>
            </td>
            <td class="basket-name">
                <span>
                   <?=$offer["NAME"]?>
                </span>
                <div class="offers-display-props"><?=$propsStr?></div>
                <input type="hidden" value="<?=$propsStr?>" class="offers-props">
            </td>
            <td class="basket-price bxr-format-price hidden-xs">
                <?
                    $boolDiscountShow = 'Y';//('Y' == $arElementParams['SHOW_OLD_PRICE']);

                    global $DB,$GlobalDate;

                    $currency = $offer["PROPERTIES"]["BXR_UNIT_PRICE"]["VALUE"];
                    $price = round($offer["PROPERTIES"]["BXR_PRICE"]["VALUE"]);
                    $display_price = number_format($price, 0, ".", " ");
                    $discount_price = round($offer["PROPERTIES"]["BXR_DISCOUNT_PRICE"]["VALUE"]);
                    $display_discount_price = number_format($discount_price, 0, ".", " ");
                    $discount_period_from = strtotime($offer["PROPERTIES"]["BXR_DISCOUNT_PERIOD_FROM"]["VALUE"]);
                    $discount_period_to = strtotime($offer["PROPERTIES"]["BXR_DISCOUNT_PERIOD_TO"]["VALUE"]);

                    if(empty($GlobalDate))
                        $GlobalDate = strtotime(date($DB->DateFormatToPHP(CLang::GetDateFormat("FULL"))));
                ?>
                <div class="bxr-offer-price-wrap" data-item="<?=$offer["ID"]?>">
                    <?if ($price > 0 && $discount_price > 0 && $discount_active) {?>
                        <span class="bxr-old-price"><span><?=$display_price?></span></span>
                        <span class="bxr-current-price"><?=$display_discount_price?></span>
                        <span class="bxr-price-currency"><?=$currency?></span>
                    <?} elseif ($price > 0) {?>
                        <span class="bxr-current-price"><?=$display_price?></span>
                        <span class="bxr-price-currency"><?=$currency?></span>
                    <?}?>
                </div>     
            </td>
            <td class="basket-line-qty">
                 <span class="bxr-market-current-price bxr-market-format-price hidden-lg hidden-md hidden-sm"><span class="bxr-current-price"><?=$display_price?></span><span class="bxr-price-currency"><?=$currency?></span></span>
                <div class="offers-btn-wrap">
                    <button class="<?=$arParams['BXR_FORMS']['EVENT_CLASS']?> bxr-color-button-small" href="javascript:void(0);" data-toggle="modal" data-primary-pid="<?=$arResult["ID"]?>"   data-pid="<?=$offer["ID"]?>" data-target="#<?=$arParams['BXR_FORMS']['BXR_FORM_ID']?>">
			<?if (strlen($arParams['BXR_FORMS']['BXR_FORM_SUBMIT_ICON'])>0):?>
				<span class="<?=$arParams['BXR_FORMS']['BXR_FORM_SUBMIT_ICON']?>"></span>
			<?endif;?>
			<?=$arParams['BXR_FORMS']["BUTTON_TEXT"]?>
                    </button>              
                </div>
            </td>
        </tr>
        <?}?>
    </tbody>
</table>
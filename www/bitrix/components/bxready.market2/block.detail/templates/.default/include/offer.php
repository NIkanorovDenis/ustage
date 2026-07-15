<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>
<?
$show_offers_title = ($arParams["BXR_OFFERS_BLOCK"]['BXR_SHOW_OFFERS_TITLE'] == "Y") ? true : false;
?>
<?if (is_array($arResult["PROPERTIES"]["BXR_OFFER_DETAIL"]["VALUE"]) && count($arResult["PROPERTIES"]["BXR_OFFER_DETAIL"]["VALUE"]) > 0) {?>
    <table class="bxr-offer <?=(!$show_offers_title) ? 'without-desc' : '';?>">
        <?  foreach ($arResult["PROPERTIES"]["BXR_OFFER_DETAIL"]["VALUE"] as $key => $offer_desc) {
            $offer_title = $arResult["PROPERTIES"]["BXR_OFFER_DETAIL"]["DESCRIPTION"][$key];
            $offer_desc_class = ($offer_title && $show_offers_title) ? "bxr-offer-desc-with-title" : "bxr-offer-desc";
            $col_span = ($offer_title && $show_offers_title) ? "" : "colspan='2'";?>
            <tr>
                <?if ($offer_title && $show_offers_title) {?>
                    <td class="bxr-offer-title"><?=$offer_title?></td>
                <?}?>
                <td class="<?=$offer_desc_class?>" <?=$col_span?>><?=$offer_desc?></td>
            </tr>
        <?}?>
    </table>
<?}?>
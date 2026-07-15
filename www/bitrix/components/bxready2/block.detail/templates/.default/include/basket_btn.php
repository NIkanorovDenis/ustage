<?
global $BXRGeneral;
$BXRGeneral = \Alexkova\Bxready2\Settings::loadConfiguration(SITE_TEMPLATE_ID);
$optionBasketOn = COption::GetOptionString("alexkova.bxready2", "basket_on_template_".SITE_TEMPLATE_ID, "N");

if (($BXRGeneral["BASKET"]["include"] === "Y" || $optionBasketOn === "Y") && $arResult["PROPERTIES"]["BXR_INSTOCK"]["VALUE_XML_ID"] === "Y"):?>
    <form class="bxr-basket-action" data-item="<?=$arResult["ID"]?>">
        <button class="bxr-basket-action-button bxr-color-button" data-action="add">
            <span class="fa fa-shopping-cart"> </span>
            <?=GetMessage("DETAIL_MORE_INFO_BUY")?>
        </button>
        <button class="bxr-basket-action-button bxr-basket-favor" data-action="favor">
            <span class="fa fa-heart-o"></span>
        </button>
    </form>
<?endif;?>

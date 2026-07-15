<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
if ($arResult['DATE_ACTIVE_FROM'] && in_array("DATE_ACTIVE_FROM", $arParams["FIELD_CODE"]) || $arResult['DATE_ACTIVE_TO'] && in_array("DATE_ACTIVE_TO", $arParams["FIELD_CODE"])):?>
    <div class="bxr-element-date bxr-color<?=(in_array("PREVIEW_TEXT", $arParams["FIELD_CODE"]) && strlen($arResult["PREVIEW_TEXT"]) > 0) ? " bxr-with-anounce" : ""?>">
        <?if ($arResult['DATE_ACTIVE_FROM'] && in_array("DATE_ACTIVE_FROM", $arParams["FIELD_CODE"])) {?>
            <?=$arResult["DISPLAY_ACTIVE_FROM"]?>
        <?}?>
        <?if ($arResult['DATE_ACTIVE_FROM'] && $arResult['DATE_ACTIVE_TO']
              && in_array("DATE_ACTIVE_FROM", $arParams["FIELD_CODE"])
              && in_array("DATE_ACTIVE_TO", $arParams["FIELD_CODE"])) {?>
         - 
        <?}?>
        <?if ($arResult['DATE_ACTIVE_TO'] && in_array("DATE_ACTIVE_TO", $arParams["FIELD_CODE"])) {?>
            <?=$arResult["DISPLAY_ACTIVE_TO"]?>
         <?}?>
    </div>
<?endif; 
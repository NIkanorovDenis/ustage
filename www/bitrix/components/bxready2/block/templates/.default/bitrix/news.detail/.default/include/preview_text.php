<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>
<?
if (in_array("PREVIEW_TEXT", $arParams["FIELD_CODE"]) && strlen($arResult["PREVIEW_TEXT"]) > 0) {
?>
    <div class="bxr-preview-text"><?=$arResult["PREVIEW_TEXT"]?></div>
<?}?>

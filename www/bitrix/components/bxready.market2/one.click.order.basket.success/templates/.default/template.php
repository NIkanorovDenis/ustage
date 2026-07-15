<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>

<?
$orderId = $arParams["ORDER_ID"];
$error = $arParams["ERROR_CODE"];
if ($orderId > 0 && !$error) {
    ?><div class="bxr-success-order-wrap">
        <?=str_replace(["#ORDER_ID#", "#ORDER_DATE#"], [$orderId, date('d.m.Y h:i')], GetMessage("BXR_SUCCESS_ORDER"))?></br>
        <?=($USER->IsAuthorized()) ? GetMessage("BXR_SHOW_ORDER") : ""?>
    </div><?
} elseif ($error) {
    ?><div class="bxr-error-order-wrap">
        <?=GetMessage("BXR_ERROR")?></br>
        <?=str_replace("#ERROR_CODE#", $error, GetMessage("BXR_ERROR_CODE"))?>
    </div><?
}?>

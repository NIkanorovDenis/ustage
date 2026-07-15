<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
$template = ".default";
$arParams = array();
if (isset($_SESSION["BXR_BASKET_ACTION_COMPARE"]) && strlen($_SESSION["BXR_BASKET_ACTION_COMPARE"])>0)
    $template = $_SESSION["BXR_BASKET_ACTION_COMPARE"];

if (isset($_SESSION["BXR_COMPARE_PARAMS"]) && is_array($_SESSION["BXR_COMPARE_PARAMS"])) {
    $arParams = $_SESSION["BXR_COMPARE_PARAMS"];
}
else {
    $arParams = array(
        "AJAX_MODE" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "N",
        "DETAIL_URL" => "",
        "COMPARE_URL" => SITE_DIR."catalog/compare.php",
        "NAME" => "CATALOG_COMPARE_LIST"
    );
}
?>
<?$APPLICATION->IncludeComponent("bxready.market2:catalog.compare.list", $template, $arParams);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>
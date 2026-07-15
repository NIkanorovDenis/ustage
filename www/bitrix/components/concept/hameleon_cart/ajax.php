<?
$site_id = trim($_REQUEST["site_id"]);
define("SITE_ID", $site_id);

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');



CModule::IncludeModule('iblock');

$templ = trim($_REQUEST["templ"]);
$sect = trim($_REQUEST["sect"]);
$modal_mode = trim($_REQUEST["modal_mode"]);
$link_empty_box = trim($_REQUEST["link_empty_box"]);

$arTemplate["mini_cart"] = Array();
$arTemplate["mini_cart"]["TEMPLATE"] = "mini_cart";

$arTemplate["mini_cart_mob"] = Array();
$arTemplate["mini_cart_mob"]["TEMPLATE"] = "mini_cart_mob";

$arTemplate["products"] = Array();
$arTemplate["products"]["TEMPLATE"] = "products";

$arTemplate["adv"] = Array();
$arTemplate["adv"]["TEMPLATE"] = "adv";

$arTemplate["info_table"] = Array();
$arTemplate["info_table"]["TEMPLATE"] = "info_table";



$APPLICATION->IncludeComponent(
    "concept:hameleon_cart",
    $arTemplate[$templ]["TEMPLATE"],
    Array(
        "COMPOSITE_FRAME_MODE" => "A",
        "COMPOSITE_FRAME_TYPE" => "AUTO",
        "CURRENT_LAND" => $sect,
        "COMPONENT_TEMPLATE" => $arTemplate[$templ]["TEMPLATE"],
        "IBLOCK_TYPE" => "concept_hameleon",
        "MESSAGE_404" => "",
        "SET_STATUS_404" => "N",
        "SHOW_404" => "N",
        "LINK_EMPTY_BOX" => $link_empty_box
    )
);?>


<?
//require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');
?>
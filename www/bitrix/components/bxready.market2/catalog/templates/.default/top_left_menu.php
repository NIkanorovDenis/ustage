<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$bxmarket = \Alexkova\Market2\Bxmarket::getInstance();?>
<div class="bxr-show-left-menu">
    <?$APPLICATION->IncludeComponent(
        "bxready.market2:main.include",
        "named_area",
        Array(
            "AREA_FILE_SHOW" => "file",
            "AREA_FILE_SUFFIX" => "inc",
            "EDIT_TEMPLATE" => "",
            "PATH" => SITE_DIR."include/left_menu.php",
        ),
        false
    );?>
</div>
<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
$arTemplateParameters = array(
    "SHOW_SECTION_NAME" => array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("CP_SHOW_SECTION_NAME"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => 'N',
    ),
    "SHOW_SECTION_DESCRIPTION" => array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("CP_SHOW_SECTION_DESCRIPTION"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => 'N',
    )
);
?>
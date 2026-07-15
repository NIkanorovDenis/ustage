<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

global $arReload;

$arReload['PARAMETERS']["SEF_MODE"] = Array(
    "detail" => array(
        "NAME" => GetMessage("T_IBLOCK_SEF_PAGE_NEWS_DETAIL"),
        "DEFAULT" => "#ELEMENT_ID#/",
        "VARIABLES" => array("ELEMENT_ID"),
    ),
);
?>

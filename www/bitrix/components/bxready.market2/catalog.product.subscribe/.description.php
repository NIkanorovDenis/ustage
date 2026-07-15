<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("CATALOG_PRODUCT_SUBSCRIBE_NAME"),
	"DESCRIPTION" => GetMessage("CATALOG_PRODUCT_SUBSCRIBE_DESCRIPTION"),
	"ICON" => "/images/sale_viewed.gif",
	"SORT" => 50,
	"PATH" => array(
        "ID" => "market2",
        "NAME" => GetMessage("MARKET2_SECTION_DESCRIPTION"),
        "CHILD" => array(
            "ID" => "catalog",
            "NAME" => GetMessage("T_IBLOCK_DESC_CATALOG"),
            "SORT" => 30,
        )
	)
);
<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("IBLOCK_CATALOG_MARKERS_TEMPLATE_NAME"),
	"DESCRIPTION" => GetMessage("IBLOCK_CATALOG_MARKERS_DESCRIPTION"),
	"ICON" => "/images/sections_top_count.gif",
	"CACHE_PATH" => "Y",
	"SORT" => 20,
	"PATH" => array(
        "ID" => "market2",
        "NAME" => GetMessage("MARKET2_SECTION_DESCRIPTION"),
        "CHILD" => array(
            "ID" => "catalog",
            "NAME" => GetMessage("T_IBLOCK_DESC_CATALOG"),
            "SORT" => 30,
        )
	),
);

?>
<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("MARKET_BESTSELLERS_NAME"),
	"DESCRIPTION" => GetMessage("MARKET_BESTSELLERS_DESCRIPTION"),
	"ICON" => "/images/icon.gif",
	"COMPLEX" => "Y",
	"SORT" => 10,
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
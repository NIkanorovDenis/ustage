<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("BXREADY_BLOCK_LIST2_NAME"),
	"DESCRIPTION" => GetMessage("BXREADY_BLOCK_LIST2_DESCRIPTION"),
	"ICON" => "/images/news_list.gif",
	"COMPLEX" => "Y",
	"SORT" => 10,
	"PATH" => array(
        "ID" => "market2",
        "NAME" => GetMessage("MARKET2_SECTION_DESCRIPTION"),
	),
);

?>
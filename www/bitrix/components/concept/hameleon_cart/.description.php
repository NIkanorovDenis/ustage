<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("HAM_T_IBLOCK_DESC_LIST"),
	"DESCRIPTION" => GetMessage("HAM_T_IBLOCK_DESC_LIST_DESC"),
	"ICON" => "/images/news_list.gif",
	"SORT" => 20,
	"CACHE_PATH" => "Y",
	"PATH" => array(
		"ID" => "concept",
        "NAME" => GetMessage("HAM_T_IBLOCK_DESC_COMPANY_GENERATOR"),
		"SORT" => 200,
		"CHILD" => array(
			"ID" => "pages",
			"NAME" => GetMessage("HAM_T_IBLOCK_DESC_PAGE_GENERATOR"),
			"SORT" => 10,
			"CHILD" => array(
				"ID" => "page_cmpx",
			),
		),
	),
);

?>
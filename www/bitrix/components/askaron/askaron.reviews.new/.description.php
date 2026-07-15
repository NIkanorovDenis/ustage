<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("ASKARON_REVIEWS_LIST_NAME"),
	"DESCRIPTION" => GetMessage("ASKARON_REVIEWS_LIST_DESCRIPTION"),	
	"CACHE_PATH" => "Y",
	"PATH" => array(
		"ID" => "askaron_components",
		"NAME" => GetMessage("ASKARON_COMPONENTS_GROUP_NAME"),
		"CHILD" => array(
			"ID" => "askaron_reviews",
			"NAME" => GetMessage("ASKARON_REVIEWS_GROUP_NAME"),
		)
	),	
);
?>
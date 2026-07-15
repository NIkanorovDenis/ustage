<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"PARAMETERS" => array(
		"AJAX_MODE" => array(),
		"ELEMENT_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("ASKARON_REVIEWS_ELEMENT_ID"),
			"TYPE" => "STRING",
			"DEFAULT" => '={$ELEMENT_ID}',
		),
		//"CACHE_TIME"  =>  Array("DEFAULT"=>86400),
	),
);
?>

<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arComponentParameters = array(
	"GROUPS" => array(
		"PARAMS" => array(
			"NAME" => GetMessage("MAIN_INCLUDE_PARAMS"),
		),
	),
	
	"PARAMETERS" => array(
		"BXR_SIDEBAR_ID" => array(
			"NAME" => GetMessage("BXR_SIDEBAR_ID"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
			"PARENT" => "PARAMS",
		),

		"BXR_SIDEBAR_FILENAME" => array(
			"NAME" => GetMessage("BXR_SIDEBAR_FILENAME"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
			"PARENT" => "PARAMS",
		),

		"BXR_SIDEBAR_EXT_FILENAME" => array(
			"NAME" => GetMessage("BXR_SIDEBAR_EXT_FILENAME"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
			"PARENT" => "PARAMS",
		)
	),
);
?>
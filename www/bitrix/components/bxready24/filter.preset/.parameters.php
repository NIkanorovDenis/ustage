<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"GROUPS" => array(),
	"PARAMETERS" => array(
		"FILTER_PRESET_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BXR24_FILTER_PRESET_ID"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
                "BLOCK_ID" => array(
			"PARENT" => "BASE",
			"NAME" => "BLOCK_ID",
			"TYPE" => "STRING",
			"DEFAULT" => "",
                ),
	),
);

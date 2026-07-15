<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"GROUPS" => array(
	),

	"PARAMETERS" => array(

		"USE_FIXED_PANEL" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BXR_USE_FIXED_PANEL"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),

		"MAX_WIDTH" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BXR_FIXED_MAX_WIDTH"),
			"TYPE" => "STRING"
		),

		"FIXED_PANEL_CODE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BXR_FIXED_PANEL_CODE"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),

		"FIXED_PANEL_DEFAULT_VARIANT" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BXR_FIXED_PANEL_DEFAULT_VARIANT"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
            
                "SHOW_DIRECTLY_IN_EDIT_MODE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("SHOW_DIRECTLY_IN_EDIT_MODE"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),

		"USE_FEXT_FILES" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BXR_USE_FEXT_FILES"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
	),
);

?>
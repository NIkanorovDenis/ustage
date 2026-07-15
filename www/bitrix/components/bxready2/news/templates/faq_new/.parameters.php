<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Alexkova\Bxready2\Core;
use Alexkova\Bxready2\Lists;

if(!CModule::IncludeModule("alexkova.bxready2"))
	return;

$arTemplateParameters = array(
	"SHOW_ALL_SECTIONS_AND_Q" => Array(
		"NAME" => GetMessage("T_SHOW_ALL_SECTIONS_AND_Q"),
		"TYPE" => "CHECKBOX",
		"MULTIPLE" => "N",
		"VALUE" => "Y",
		"DEFAULT" =>"N",
		"REFRESH"=> "Y",
	),
	"SHOW_INDEX_ELEMENTS" => Array( 
            "NAME" => GetMessage("SHOW_INDEX_ELEMENTS"), 
            "TYPE" => "CHECKBOX", 
            "DEFAULT" => "N", 
        ), 
);

if ($arCurrentValues["SHOW_ALL_SECTIONS_AND_Q"] != "Y")
{
	$arTemplateParameters["SHOWS_ELEMENTS_Q"] = array(
		"NAME" => GetMessage("T_SHOWS_ELEMENTS_Q"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
	);
}
?>
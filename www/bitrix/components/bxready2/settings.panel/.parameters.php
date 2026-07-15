<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!CModule::IncludeModule("alexkova.bxready2"))
	return;

$arComponentParameters['PARAMETERS']['TYPE'] = Array(
	"NAME" => GetMessage("BXR_SETTINGS_TYPE"),
	"TYPE" => "LIST",
	"MULTIPLE" => "N",
	"DEFAULT" => "A",
	"VALUES"=>array(
		'U'=>'User',
		'A'=>'Admin',
	),
	"PARENT" => "DATA",
);

if (isset($arCurrentValues['TYPE'])) {
	if ($arCurrentValues['TYPE'] == 'U') {
		$arComponentParameters['PARAMETERS']['USE_SHARE'] = Array(
			"NAME" => GetMessage("BXR_SETTINGS_USE_SHARE"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N"
		);
	}
}
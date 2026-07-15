<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!CModule::IncludeModule("iblock")
|| !CModule::IncludeModule("alexkova.sets"))
	return;

$arComponentParameters['PARAMETERS']['CROSS_TYPE'] = Array(
	"NAME" => GetMessage("BXR_CROSS_TYPE"),
	"TYPE" => "LIST",
	"MULTIPLE" => "N",
	"DEFAULT" => "E",
	"VALUES"=>array(
		'S'=>'Section',
		'E'=>'Element',
	),
	"PARENT" => "DATA",
);

$arComponentParameters['PARAMETERS']['ID'] = Array(
	"NAME" => GetMessage("BXR_SET_ELEMENT_ID"),
	"TYPE" => "STRING",
	"MULTIPLE" => "N",
	"DEFAULT" => 0,
	"PARENT" => "DATA",
);

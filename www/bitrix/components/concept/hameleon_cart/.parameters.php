<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arCurrentValues */

if(!CModule::IncludeModule("iblock"))
	return;

$arTypesEx = CIBlockParameters::GetIBlockTypes(array("-"=>" "));

$arIBlocks=array();
$db_iblock = CIBlock::GetList(array("SORT"=>"ASC"), array("SITE_ID"=>$_REQUEST["site"], "TYPE" => ($arCurrentValues["IBLOCK_TYPE"]!="-"?$arCurrentValues["IBLOCK_TYPE"]:"")));
while($arRes = $db_iblock->Fetch())
	$arIBlocks[$arRes["ID"]] = $arRes["NAME"];


$arComponentParameters = array(
	"GROUPS" => array(
	),
	"PARAMETERS" => array(
		
		"CURRENT_LAND" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage("HAM_CUR"),
			"TYPE" => "STRING",
			"DEFAULT" => '',
		)
		
	),
);


CIBlockParameters::Add404Settings($arComponentParameters, $arCurrentValues);

?>
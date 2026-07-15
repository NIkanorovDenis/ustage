<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

//if (!CModule::IncludeModule('bxready2')) return;

$arComponentParameters = array(
	"GROUPS" => array(
	),
	"PARAMETERS" => array(

		"CACHE_TIME"  =>  Array("DEFAULT"=>3600),

		"ELEMENT_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_ELEMENT_ID"),
			"TYPE" => "STRING",
			"DEFAULT" => '',
		),

		"IBLOCK_ELEMENT_ID_VARIABLE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_ELEMENT_ID_VARIABLE"),
			"TYPE" => "STRING",
			"DEFAULT" => '={$_REQUEST["ID"]}',
		),
		
	),
);

if (CModule::IncludeModule('alexkova.bxready2')){

	$additionalParams = \Alexkova\Bxready2\Component::getRelatedListSettings(array(), $arCurrentValues);

	if (is_array($additionalParams)){

		if (count($additionalParams['GROUPS'])>0){
			foreach ($additionalParams['GROUPS'] as $cell=>$val){
				$arComponentParameters['GROUPS'][$cell] = $val;
			}
		}

		if (count($additionalParams['PARAMETERS'])>0){
			foreach ($additionalParams['PARAMETERS'] as $cell=>$val){
				$arComponentParameters['PARAMETERS'][$cell] = $val;
			}
		}
	}

}


?>
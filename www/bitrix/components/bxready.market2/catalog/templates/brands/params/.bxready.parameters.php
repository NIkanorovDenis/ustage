<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();


$additionalParams = \Alexkova\Bxready2\Component::getCustomListSettings(
	12,
	$arCurrentValues,
	array(
		'slider' => false,
		'collection' => array(
			'ecommerce.m2.v1',
			'ecommerce.m2.managed.v1'
		),
		'sort'=>1012
	),
	'LISTPAGE',
	'BXRClassic'
);

if (count($additionalParams['LIST_GROUPS'])>0){
	foreach($additionalParams["LIST_GROUPS"] as $cell=>$val){
		$arComponentGroups[$cell] = $val;
	}
}

if (count($additionalParams['LIST_PARAMS'])>0){
	foreach($additionalParams["LIST_PARAMS"] as $cell=>$val){
		$arTemplateParameters[$cell] = $val;
	}
}
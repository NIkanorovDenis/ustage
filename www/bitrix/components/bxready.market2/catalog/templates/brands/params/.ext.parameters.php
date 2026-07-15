<?
global $arComponentGroups;

if (!isset($arComponentGroups) || !is_array($arComponentGroups)){
	$arComponentGroups = array();
}

$arComponentGroups = array(
	'BXR_PRESENT_SETTINGS' => array(
		'NAME' => GetMessage('BXR_PRESENT_SETTINGS'),
		'SORT' => 1009
	),
	'BXR_LIST_SETTINGS' => array(
		'NAME' => GetMessage('BXR_LIST_SETTINGS'),
		'SORT' => 1010
	),
	'BXR_BITRIX_LIST_SETTINGS' => array(
		'NAME' => GetMessage('BXR_BITRIX_LIST_SETTINGS'),
		'SORT' => 1011
	),
	'BXR_EXT_LIST_SETTINGS' => array(
		'NAME' => GetMessage('BXR_EXT_LIST_SETTINGS'),
		'SORT' => 940
	),
);

$bxrListTypes = array(
	".default" => GetMessage("BXR_LIST_TYPE_BX"),
	"bxready" => GetMessage("BXR_LIST_TYPE_BXR"),
);

$arTemplateParameters['BXR_LIST_TYPE'] = array(
	'PARENT' => 'BXR_PRESENT_SETTINGS',
	'NAME' => GetMessage('BXR_LIST_TYPE'),
	'TYPE' => 'LIST',
	'VALUES' => $bxrListTypes,
	'REFRESH' => 'Y',
	'DEFAULT' => 'bxready',
);

if ((isset($arCurrentValues['BXR_LIST_TYPE']) && $arCurrentValues['BXR_LIST_TYPE'] === '.default')) {
	include('.bitrix.parameters.php');
}else{
	include('.bxready.parameters.php');
}

include('.present.list.parameters.php');
include('.present.table.parameters.php');

<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentGroups['BXR_CROSS_SELL_SETTINGS'] = array(
	'NAME' => GetMessage('BXR_CROSS_SELL_SETTINGS'),
	'SORT' => 5011
);

$arTemplateParameters['BXR_USE_CROSS_SELL'] = array(
	'PARENT' => 'BXR_CROSS_SELL_SETTINGS',
	'NAME' => GetMessage('BXR_USE_CROSS_SELL'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'N',
	'REFRESH' => "Y"
);

if ((isset($arCurrentValues['BXR_USE_CROSS_SELL']) && $arCurrentValues['BXR_USE_CROSS_SELL'] == 'Y')) {

	$arTemplateParameters['BXR_USE_CROSS_SELL_MERGE_MODE'] = array(
		'PARENT' => 'BXR_CROSS_SELL_SETTINGS',
		'NAME' => GetMessage('BXR_USE_CROSS_SELL_MERGE_MODE'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y',
	);

	$arTemplateParameters['BXR_CROSS_SELL_TITLE'] = array(
		'PARENT' => 'BXR_CROSS_SELL_SETTINGS',
		'NAME' => GetMessage('BXR_CROSS_SELL_TITLE'),
		'TYPE' => 'STRING',
		'DEFAULT' => GetMessage('CROSS_SELL_TITLE'),
	);

    $arTemplateParameters['BXR_CROSS_SELL_COUNT'] = array(
        'PARENT' => 'BXR_CROSS_SELL_SETTINGS',
        'NAME' => GetMessage('BXR_CROSS_SELL_COUNT'),
        'TYPE' => 'STRING',
        'DEFAULT' => 10,
    );

	/*$arTemplateParameters['BXR_CROSS_SELL_ICON'] = array(
		'PARENT' => 'BXR_CROSS_SELL_SETTINGS',
		'NAME' => GetMessage('BXR_CROSS_SELL_ICON'),
		'TYPE' => 'STRING',
		'DEFAULT' => '',
	);*/

}


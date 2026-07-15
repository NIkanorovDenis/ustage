<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
if (\Bitrix\Main\Loader::includeModule('alexkova.bxready2')){
	$allPrefix = array(
		'_LISTPAGE',
                '_PRESENT_LIST',
                '_PRESENT_TABLE',
                '_STANDART',
                '_BIG',
		'_SMALL',
		'_FAST_VIEW',
		'_SALELEADER',
		'_BIGDATA',
		'_OTHER',
		'_RECOMMENDED',
		'_VIEWED'
	);

	foreach ($arParams as $cell=>$val){
		foreach ($allPrefix as $prefix){
                        if (substr_count($cell, "~") > 0) continue;
			if (substr($cell, strlen($cell)-strlen($prefix), strlen($prefix)) == $prefix)
				$arParams['BXR'.$prefix][substr($cell, 0, strlen($cell)-strlen($prefix))] =  $val;
		}
	}
}
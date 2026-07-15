<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arResult['ELEMENTS'] = array();

foreach ($arResult['SECTION_TREE']['CHILD'] as $cell=>$val){

	$arSection = array(
		"NAME" => $arResult['SECTIONS'][$cell]["NAME"],
		"DETAIL_PAGE_URL" => $arResult['SECTIONS'][$cell]["SECTION_PAGE_URL"]
	);

	if ($arParams['COUNT_ELEMENTS'] == "Y" && intval($arResult['SECTIONS'][$cell]['ELEMENT_CNT'])>0){
		$arSection['NAME'] .= ' ('.$arResult['SECTIONS'][$cell]['ELEMENT_CNT'].')';
	}

	if (is_array($val["PICTURE"]) && strlen($val["PICTURE"]['SRC'])>0){
		$arSection['PREVIEW_PICTURE'] = $val["PICTURE"];
	}

	if (strlen($val["DESCRIPTION"])>0){
		if (substr_count($val["DESCRIPTION"], '#STEXT#')){
			$arDesc = explode('#STEXT#', $val['DESCRIPTION']);
			$val['DESCRIPTION'] = $arDesc[0];
		}
		$arSection['PREVIEW_TEXT'] = $val["DESCRIPTION"];
	}

	if (!empty($val['CHILD'])){
		foreach ($val['CHILD'] as $cell2=>$child){
			$arChild = array(
				'NAME' => $child["NAME"],
				'DETAIL_PAGE_URL' => $child['SECTION_PAGE_URL']
			);

			if ($arParams['COUNT_ELEMENTS'] == "Y" && intval($arResult['SECTIONS'][$cell2]['ELEMENT_CNT'])>0){
				$arChild['NAME'] .= ' ('.$arResult['SECTIONS'][$cell2]['ELEMENT_CNT'].')';
			}

			$arSection['CHILD'][$cell2] = $arChild;
		}
	}

	$arResult["ELEMENTS"][$cell] = $arSection;
}

if (\Bitrix\Main\Loader::includeModule('alexkova.bxready2')){
	$allPrefix = array(
		'_CINDEX',
	);

	foreach ($arParams as $cell=>$val){
		foreach ($allPrefix as $prefix){
			if (substr($cell, strlen($cell)-strlen($prefix), strlen($prefix)) == $prefix)
				$arParams['BXR'.$prefix][substr($cell, 0, strlen($cell)-strlen($prefix))] =  $val;
		}
	}
}

?>
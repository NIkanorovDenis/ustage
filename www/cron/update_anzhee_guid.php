<?php
$_SERVER['DOCUMENT_ROOT'] = __DIR__.'/../';
$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);
define('BX_CRONTAB', true);
define('BX_NO_ACCELERATOR_RESET', true);

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

CModule::IncludeModule('iblock');

$IBLOCK_ID = 32;
$IBLOCK_ID_OFFER = 33;

$arPriceList = [];
$arColumns = [];

$arColumns["NAME"] = 3;
$arColumns["NAME_TP"] = 4;
$arColumns["PRICE"] = 12;
$arColumns["QUANTITY"] = 15;
$arColumns["GUID"] = 0;
$arColumns["GUID_TP"] = 1;

$f = $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/energosoft.utils/classes/general/anzhee-stock.csv";

if (file_exists($f)) { echo 'ok';
	$handle = fopen($f, "r");
	while (($arRow = fgetcsv($handle, 10000, ";")) !== false) {
		
		$tp = false;
		//$GUID = !empty($arRow[$arColumns["GUID_TP"]]) ? $arRow[$arColumns["GUID_TP"]] : $arRow[$arColumns["GUID"]]; 
		$GUID = $arRow[$arColumns["GUID"]];
		$GUID_TP = $arRow[$arColumns["GUID_TP"]];

		$PRICE = (float)$arRow[$arColumns["PRICE"]];  

		$QUANTITY = (int)$arRow[$arColumns["QUANTITY"]];

		$NAME = trim($arRow[$arColumns["NAME"]]); 
		$NAME_TP = trim($arRow[$arColumns["NAME_TP"]]); 

		if (!empty($NAME)) {
			
			if (!empty($NAME_TP) && ($NAME_TP !== '?' && $NAME_TP !== 'без характеристики' && $NAME_TP !== 'Без характеристики')) {
				$NAME .= ' ('. $NAME_TP .')';
				$tp = true;
			}
			//$NAME = ToLower($NAME);

			if ($tp === true) {
				$arPriceList['TP'][ToLower($NAME)] = array("N" => $NAME, "P" => $PRICE, "Q" => $QUANTITY, "G" => $GUID_TP);	
			} else {
				$arPriceList['PROD'][ToLower($NAME)] = array("N" => $NAME, "P" => $PRICE, "Q" => $QUANTITY, "G" => $GUID);
			}
		}

	} 

	fclose($handle);
}
//print_r($arPriceList);

$arFilter = [
	'IBLOCK_ID' => $IBLOCK_ID,
	//'ACTIVE' => 'Y',
	'PROPERTY_UPLOADED_FROM_PAGE' => '%anzhee.ru%',
	'PROPERTY_GUID' => '',
];
$res = CIBlockElement::GetList(false, $arFilter, ["ID", "IBLOCK_ID", "NAME", "PROPERTY_GUID"]);	
while ($arItem = $res->GetNext()) {
	
	$nm = ToLower(trim($arItem["~NAME"]));	
	
	if (!empty($arPriceList['PROD'][$nm]['G'])) {
		
		CIblockElement::SetPropertyValuesEx($arItem['ID'], $IBLOCK_ID, ['GUID' => $arPriceList['PROD'][$nm]['G']]);	
		echo 'update product '.$arItem['~NAME'].' guid <br/>';
		
		
	} /*else {*/	
	
		$arFilterTP = [
			'IBLOCK_ID' => $IBLOCK_ID_OFFER,
			//'ACTIVE' => 'Y',
			'PROPERTY_CML2_LINK' => $arItem['ID'],
			'PROPERTY_GUID' => '',
		];
		$resTP = CIBlockElement::GetList(false, $arFilterTP, ["ID", "IBLOCK_ID", "NAME", "PROPERTY_GUID"]);	
		while ($arItemTP = $resTP->GetNext()) { 
			
			$nmTP = ToLower(trim($arItemTP["~NAME"]));	; 
			if (!empty($arPriceList['TP'][$nmTP]['G'])) { 
				CIblockElement::SetPropertyValuesEx($arItemTP['ID'], $IBLOCK_ID_OFFER, ['GUID' => $arPriceList['TP'][$nmTP]['G']]);	
				echo 'update tp '.$arItemTP['ID'].' guid <br/>';
			}	

		}
	
	/*}*/

}



mail('diz55@mail.ru', 'ustage anzhee guid', 'ustage anzhee guid'); 

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php');

?>
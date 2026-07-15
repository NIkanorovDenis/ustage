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

use Bitrix\Catalog\PriceTable;
use Bitrix\Main\Loader;
Loader::includeModule('iblock');
Loader::includeModule('catalog');

$IBLOCK_ID = 32;
$IBLOCK_ID_OFFER = 33;

$arInfo = CCatalogSKU::GetInfoByProductIBlock($IBLOCK_ID);
$arFilter = [
	'IBLOCK_ID' => $IBLOCK_ID,
	'ACTIVE' => 'Y'
];
$res = CIBlockElement::GetList(false, $arFilter, ["ID", "IBLOCK_ID", "NAME"]);	
while ($el = $res->GetNext()) { 

	$id = $idList = $el['ID'];

	if (is_array($arInfo)) {
		$rsOffers = CIBlockElement::GetList([], [
			'IBLOCK_ID' => $arInfo['IBLOCK_ID'],
			'PROPERTY_' . $arInfo['SKU_PROPERTY_ID'] => $idList,
		], false, false, ['ID']);

		if ($rsOffers->SelectedRowsCount()) {
			$idList = [];

			while ($arOffer = $rsOffers->GetNext()) { 
				$idList [] = $arOffer['ID'];
			}
		}
	}

	$arPricesList = PriceTable::getList([
		'select' => ['PRICE'],
		'filter' => [
			'=PRODUCT_ID' => $idList,
		],
		'order' => [
			'CATALOG_GROUP_ID' => 'ASC',
		],
	])->fetchAll();

	$minPrice = 0;
	$maxPrice = 0;

	foreach ($arPricesList as $arPrice) {
		$price = (float)$arPrice['PRICE'];

		if ($price <= 0) {
			continue;
		}

		if ($minPrice === 0 || $minPrice > $price) {
			$minPrice = $price;
		}

		if ($maxPrice < $price) {
			$maxPrice = $price;
		}
	} 

	$minPrice = $minPrice == 0 ? '' : number_format($minPrice, 2, '.', ''); echo ' min='.$minPrice;
	$maxPrice = $maxPrice == 0 ? '': number_format($maxPrice, 2, '.', ''); echo ' max='.$maxPrice;

	CIBlockElement::SetPropertyValueCode($id, 'MINIMUM_PRICE', $minPrice);
	CIBlockElement::SetPropertyValueCode($id, 'MAXIMUM_PRICE', $maxPrice);
	
	echo '<br />' . $el['NAME'].' - minPrice: '. $minPrice .' - maxPrice: '. $maxPrice;		

}

mail('diz55@mail.ru', 'ustage update minmaxprice', 'ustage update minmaxprice'); 

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php');

?>
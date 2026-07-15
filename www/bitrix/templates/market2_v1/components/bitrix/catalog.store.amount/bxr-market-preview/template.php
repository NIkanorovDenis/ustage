<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$bxr_total_avail = 0;

$params = $arParams['PARAMS'];

foreach($arResult["STORES"] as $pid => $arProperty) {
  if ($arParams['SHOW_EMPTY_STORE'] == 'N' && isset($arProperty['REAL_AMOUNT']) && $arProperty['REAL_AMOUNT'] <= 0) {
    continue;
  }

  $bxr_total_avail += $arProperty['REAL_AMOUNT'];
}

if (count($arParams["OFFERS"]) > 0) {
  $bxr_total_avail = 0;

  foreach ($arParams["OFFERS"] as $offer) {
    $offerParams = $params;

    if ($offer['CATALOG_QUANTITY'] <= 0 && $arParams['PENDING_QUANTITY'] > 0) {
      $offerParams['SHOW_MAX_QUANTITY'] = 'P';
    }

    $bxr_total_avail += $offer["CATALOG_QUANTITY"];
  }
}

if ($bxr_total_avail <= 0 && $arParams['PENDING_QUANTITY'] > 0) {
  $params['SHOW_MAX_QUANTITY'] = 'P';
}

echo \Alexkova\Market2\Core::printAvailHtmlV2Lite($bxr_total_avail, $arResult["CATALOG_MEASURE_NAME"], $params);

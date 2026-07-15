<?php
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Bitrix\Catalog\PriceTable;
class FinanceManager {


  static function updateMinMaxPrices( $id ) {
    $arInfo = CCatalogSKU::GetInfoByProductIBlock(32);

    $idList = $id;

    if (is_array($arInfo)) {
      $rsOffers = CIBlockElement::GetList([], [
        'IBLOCK_ID' => $arInfo['IBLOCK_ID'],
        'PROPERTY_' . $arInfo['SKU_PROPERTY_ID'] => $idList,
      ], false, false, ['ID']);

      if ($rsOffers->SelectedRowsCount()) {
        $idList = [];

        while ($arOffer = $rsOffers->GetNext()) {
          $idList[] = $arOffer['ID'];
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
      $price = (float) $arPrice['PRICE'];

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

    $minPrice = number_format($minPrice, 2, '.', '');
    $maxPrice = number_format($maxPrice, 2, '.', '');

    CIBlockElement::SetPropertyValueCode($id, 'MINIMUM_PRICE', $minPrice);
    CIBlockElement::SetPropertyValueCode($id, 'MAXIMUM_PRICE', $maxPrice);
  }
  static function comparePrices( $id, $name, $uploadedFrom, $oldPrice = null, $newPrice = null, $article = null ) {
    if ($oldPrice !== null) {
      $oldPrice = number_format($oldPrice, 2, '.', '');
    }

    if ($newPrice === null) {
      $newPrice = 0;
    }

    $newPrice = number_format($newPrice, 2, '.', '');

    if ($oldPrice === '0.00' || $newPrice === '0.00' || $oldPrice === $newPrice) {
      return;
    }

    $arFilter = [
      'IBLOCK_ID' => 59,
    ];

    if ($article) {
      $arFilter['PROPERTY_CML2_ARTICLE'] = $article;
    }
    elseif ($uploadedFrom) {
      $arFilter['PROPERTY_UPLOADED_FROM_PAGE'] = $uploadedFrom;
    }
    else {
      $arFilter['NAME'] = $name;
    }

    $obElement = CIBlockElement::GetList([], $arFilter, false, false, ['ID', 'PROPERTY_OLD_PRICE']);

    $arItem = $obElement->Fetch();

    $element = new CIBlockElement();

    if (!empty($arItem['ID'])) {
      $element->Update($arItem['ID'], [
        'NAME' => $name,
        'PROPERTY_VALUES' => [
          'UPLOADED_FROM_PAGE' => $uploadedFrom,
          'CML2_ARTICLE' => $article,
          'OLD_PRICE' => $arItem['PROPERTY_OLD_PRICE_VALUE'],
          'NEW_PRICE' => $newPrice,
        ],
        'ACTIVE' => 'Y',
      ]);
    }
    else {
      if ($oldPrice !== null) {
        $oldPrice = $newPrice;
      }

      $element->Add([
        'NAME' => $name,
        'IBLOCK_SECTION_ID' => false,
        'IBLOCK_ID' => 59,
        'PROPERTY_VALUES' => [
          'UPLOADED_FROM_PAGE' => $uploadedFrom,
          'CML2_ARTICLE' => $article,
          'OLD_PRICE' => $oldPrice,
          'NEW_PRICE' => $newPrice,
        ],
        'ACTIVE' => 'Y',
      ]);
    }
  }



}
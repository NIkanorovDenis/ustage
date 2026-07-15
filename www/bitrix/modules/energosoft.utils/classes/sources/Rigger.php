<?php

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

class Rigger {
  static function update( &$arStatus, $blockID = 32, $sectionID = null, $itemID = null, $debug = false ) {
    // $blockID = 32 товары

    Log::msg('Rigger update' . ($debug ? " Debug mode" : ""));
    Log::msg("block - $blockID , section - $sectionID, item - $itemID");

    global $DB; // bitrix DB
    $arStatus["LOG_RIGGER"] = array(); // log object (идет в админку)

    $preEl = new CIBlockElement;

    // Start 1
    $arElements = array();

    // список элементов на апдейт

    $obElement = CIBlockElement::GetList(
      array(),
      array(
        'IBLOCK_ID' => $blockID,
        'IBLOCK_SECTION_ID' => $sectionID,
        'ID' => $itemID,
        'PROPERTY_UPLOADED_FROM_PAGE' => '%riggershop.ru%'),
      false,
      false,
      array('ID', 'NAME', 'ACTIVE')
    );


    while ($arItem = $obElement->Fetch())
      $arElements[] = $arItem;


    $arOffersOk = array();
    $arOffers = ESIBlock::GetList(33, false, array("CML2_LINK", "ES_NAME_SEARCH"), array("ACTIVE" => "ALL"));
	

    foreach ($arOffers as $arItem) {
      if (intval($arItem["PROPERTIES"]["CML2_LINK"]["VALUE"]) == 0) {
        $arParts = array();
        if (stripos($arItem["NAME"], "(") !== false)
          $arParts = explode("(", $arItem["NAME"]);
        if (stripos($arItem["NAME"], ",") !== false)
          $arParts = explode(",", $arItem["NAME"]);
        if (count($arParts) > 1) {
          foreach ($arElements as $arElement) {
            if (trim($arElement["NAME"]) == trim($arParts[0])) {
              if ((int) $arElement['ID'] === 9772 && time() < 1618002000) {
                continue 2;
              }

              $arItem["ES_ELEMENT"] = $arElement;
              break;
            }
          }
        }
        $arOffersOk[] = $arItem;
      }
    }


    // Fix offers

    foreach ($arOffersOk as $arItem) {
      if ((int) $arItem['ES_ELEMENT']['ID'] === 9772 && time() < 1618002000) {
        continue;
      }

      if (isset($arItem["ES_ELEMENT"])) {
        CIBlockElement::SetPropertyValueCode($arItem["ID"], "CML2_LINK", $arItem["ES_ELEMENT"]["ID"]);
      }
    }


    // Start 2

    $arElements = array();
    $obElement = CIBlockElement::GetList(
      array(),
      array(
        'IBLOCK_ID' => $blockID,
        'IBLOCK_SECTION_ID' => $sectionID,
        'ID' => $itemID,
        'PROPERTY_UPLOADED_FROM_PAGE' => '%riggershop.ru%'),
      false,
      false,
      array('ID', 'NAME', 'ACTIVE')
    );

    while ($arItem = $obElement->Fetch())
      $arElements[$arItem["ID"]] = $arItem;



    $arOffers = ESIBlock::GetList(33, false, array("CML2_LINK", "ES_NAME_SEARCH"), array("ACTIVE" => "ALL"));
    foreach ($arOffers as $arOffer) {
      if ($arOffer["PROPERTIES"]["ES_NAME_SEARCH"]["VALUE"] == "") {
        $arItem = $arElements[$arOffer["PROPERTIES"]["CML2_LINK"]["VALUE"]];
        CIBlockElement::SetPropertyValueCode($arOffer["ID"], "ES_NAME_SEARCH", $arItem["NAME"]);
      }
	  
      /* // vremenno ubrali vse obnovleniya krome cen i kol-va
	  if ($arOffer["PROPERTIES"]["ES_NAME_SEARCH"]["VALUE"] == $arOffer["NAME"]) {
        $arItem = $arElements[$arOffer["PROPERTIES"]["CML2_LINK"]["VALUE"]];
        $preEl->Update($arOffer["ID"], array("NAME" => $arItem["NAME"]));
      }*/
	  
    }

    CModule::IncludeModule('highloadblock');
    $arHLColors = array();
    $arHLBlock = Bitrix\Highloadblock\HighloadBlockTable::getById(1)->fetch();
    $obEntity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
    $strEntityDataClass = $obEntity->getDataClass();
    $rsData = $strEntityDataClass::getList(array('select' => array('ID', 'UF_NAME', 'UF_XML_ID'), 'order' => array('ID' => 'ASC')));
    while ($arItem = $rsData->Fetch())
      $arHLColors[$arItem["UF_XML_ID"]] = $arItem;

    $arPropOffers = ESIBlock::GetPropertyEnum(33, false, false, false, "PROPERTY_CODE", "XML_ID", false);

    //$obElement = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>32, '<TIMESTAMP_X'=>ConvertTimeStamp((time() - 8400), 'FULL')), false, false, array('ID', 'NAME', 'ACTIVE', 'XML_ID', 'IBLOCK_ID', 'PROPERTY_UPLOADED_FROM_PAGE'));


    // список элементов на апдейт 

    $obElement = CIBlockElement::GetList(
      [],
      [
        'IBLOCK_ID' => $blockID,
        'IBLOCK_SECTION_ID' => $sectionID,
        'ID' => $itemID,
        'PROPERTY_UPLOADED_FROM_PAGE' => '%riggershop.ru%'
      ],
      false,
      false,
      [
        'ID',
        'NAME',
        'ACTIVE',
        'XML_ID',
        'IBLOCK_ID',
        'PROPERTY_UPLOADED_FROM_PAGE',
        'CATALOG_GROUP_1',
        'PROPERTY_CML2_ARTICLE',
		'PROPERTY_NOUPDATEPHOTO',
        'PROPERTY_PRICE_FROZEN']
    );

	$errorStatusElements = [];

    // перебор всех элементов 
    $currentProccesingElementIndex = 0;
    while ($arItem = $obElement->Fetch()) {
		
      if ((int) $arItem['ID'] === 9772 && time() < 1618002000) {
        continue;
      }
	  
	  $isPriceFrozen = $arItem['PROPERTY_PRICE_FROZEN_VALUE'] !== null;

      $currentProccesingElementIndex++;
      $sourceUrl = $arItem['PROPERTY_UPLOADED_FROM_PAGE_VALUE'];

      $stLog = "Q:0, P:0";
      $stLogOffers = array();
      $arCurl = ESUtils::CurlGet($sourceUrl);


      // парсинг 
      if ($arCurl["CODE"] == 200) {


        $searchPage = str_replace(array("\n", "\r"), "", $arCurl["DATA"]);
        $searchPage = str_replace("\'", "@@@", $searchPage);

        $arSiteSize = array();
        preg_match_all("/<a.*?title=\"(.*?)\".*?data-treevalue=\"363\_.*?\".*?data-onevalue=\"(.*?)\">.*?<\/a>/i", $searchPage, $arData);

        foreach ($arData[1] as $k => $v) {
          $arSiteSize[$arData[2][$k]] = $v;
        }

        foreach ($arSiteSize as $xmlId => $value) {
          if (!isset($arPropOffers["SIZE"][$xmlId])) {
            $arEnumAdd = array(
              "PROPERTY_ID" => 1943,
              "XML_ID" => $xmlId,
              "VALUE" => $value,
            );
            $arEnumAdd["ID"] = CIBlockPropertyEnum::Add($arEnumAdd);
            $arPropOffers["SIZE"][$xmlId] = $arEnumAdd;
          }
        }

        $arSiteColor = array();
        preg_match_all("/<a.*?title=\"(.*?)\".*?data-treevalue=\"362\_.*?\".*?data-onevalue=\"(.*?)\">.*?src=\"(.*?)\".*?<\/a>/i", $searchPage, $arData);

        foreach ($arData[1] as $k => $v) {
          $arSiteColor[$arData[2][$k]] = array("NAME" => $v, "IMG" => $arData[3][$k]);
        }

        foreach ($arSiteColor as $xmlId => $arColor) {
          if (!isset($arHLColors[$xmlId])) {

            // return 'https://www.riggershop.ru' . $arColor["IMG"];
            $arEnumAdd = array(
              "UF_NAME" => $arColor["NAME"],
              "UF_XML_ID" => $xmlId,
              "UF_FILE" => FilesManager::DownloadFile('https://www.riggershop.ru' . $arColor["IMG"]),
              "UF_DEF" => 0,
            );

            $r = $strEntityDataClass::add($arEnumAdd);
            $arEnumAdd["ID"] = $r->getId();
            $arHLColors[$xmlId] = $arEnumAdd;
          }
        }

        //
        preg_match("#PRODUCT':(.*?),'OFFERS':#i", $searchPage, $arProductName);
        preg_match("#NAME':'(.*?)'#i", $arProductName[1], $arProductName);
        $arProductName[1] = str_replace("@@@", "'", $arProductName[1]);

        $incomingTradeOffers = []; // $incomingTradeOffers

        preg_match_all('/new JCCatalogElement\(({\'CONFIG\':.*?)\);/m', $searchPage, $offers);


        if (!empty($offers[1][0])) {
          $offers = str_replace(['"', "'"], ['\"', '"'], $offers[1][0]);
          $offers = json_decode($offers, true);
          if ($offers['OFFERS']) {
            $offers = $offers['OFFERS'];

            foreach ($offers as $offer) {
              $incomingTradeOffers[] = [
                'ID' => $offer['ID'],
                'NAME' => $offer['NAME'],
              ];
            }
          }
          else {
            $incomingTradeOffers[] = [
              'ID' => $offers['PRODUCT']['ID'],
              'NAME' => $offers['PRODUCT']['NAME']
            ];
          }
        }


        preg_match("#OFFERS':(.*?),'OFFER_SELECTED'#i", $searchPage, $JCCatalogElement);

        preg_match_all("#NAME':'(.*?)'#i", $JCCatalogElement[1], $names);
        foreach ($names[1] as $i => $name) {
          $name = html_entity_decode($name, ENT_NOQUOTES, 'UTF-8');
          $name = str_replace("@@@", "'", $name);
          $incomingTradeOffers[$i]["NAME"] = $name;
        }

        $count_element = count($incomingTradeOffers);
        preg_match_all("#PRICE':{'VALUE':'(.*?)'#i", $JCCatalogElement[1], $prices);

        $arePricesEqual = false;
        $previousPrice = null;

        $price = 0;

        for ($i = 0; $i < $count_element; $i++) {
          if ($prices[1][$i]) {
            $price = $prices[1][$i];

            if ($previousPrice !== null && $price === $previousPrice) {
              $arePricesEqual = true;
            }

            $previousPrice = $price;
          }
        }

        for ($i = 0; $i < $count_element; $i++) {
          if ($prices[1][$i]) {
            $incomingTradeOffers[$i]["PRICE"] = $prices[1][$i];
          }
          elseif ($arePricesEqual) {
            $incomingTradeOffers[$i]["PRICE"] = $price;
          }
          else {
            $incomingTradeOffers[$i]["PRICE"] = 0;
          }
        }

        preg_match_all('/JCCatalogStoreSKU\({\'SKU\':(.*?),\'ID\'/m', $searchPage, $quantities);

        if (!empty($quantities[1][0])) {

          $quantities = str_replace(['"', "'"], ['\"', '"'], $quantities[1][0]);
          $quantities = json_decode($quantities, true);

          foreach ($incomingTradeOffers as $i => $tp) {
            foreach ($quantities as $id => $warehouses) {
              if ((string) $id === (string) $tp['ID']) {
                $incomingTradeOffers[$i]["QUANTITY"] = 0;


                foreach ($warehouses as $quantity) {
                  $incomingTradeOffers[$i]["QUANTITY"] += $quantity;
                }

                break;
              }
            }
          }
        }
        else {
          preg_match_all("#MAX_QUANTITY':'(.*?)'#i", $JCCatalogElement[1], $quantities);

          for ($i = 0; $i < $count_element; $i++) {
            $incomingTradeOffers[$i]["QUANTITY"] = $quantities[1][$i];
          }
        }
        preg_match("/<div class=\"product-available\"(.*?)>/im", $searchPage, $arrAvailableContainer);
        preg_match("/<div class=\"product-available-title\">(.*?)<\/div>/im", $searchPage, $arrAvailable);

        if (stripos($arrAvailable[0], 'Нет в наличии') && stripos($arrAvailableContainer[0], 'display:none;') === false) {
          for ($i = 0; $i < $count_element; $i++) {
            $incomingTradeOffers[$i]["QUANTITY"] = 0;
          }
        }


        preg_match_all("#SLIDER':(.*?),'SLIDER_COUNT'#i", $JCCatalogElement[1], $photos_slider);
        for ($i = 0; $i < $count_element; $i++) {
          preg_match_all("#SRC':'(.*?)'#i", $photos_slider[1][$i], $photos);
          for ($j = 0; $j < count($photos[1]); $j++) {
            try {
              $incomingTradeOffers[$i]["PHOTO"][$j] = FilesManager::DownloadFile('https://www.riggershop.ru' . $photos[1][$j]);
              //                            $arPhotoArr = explode('.', $incomingTradeOffers[$i]["PHOTO"][$j]['name']);
              //          $incomingTradeOffers[$i]["PHOTO"][$j]['name'] = md5(uniqid(rand(), true)).'.'.$arPhotoArr[sizeof($arPhotoArr)-1];
            }
            catch (Exception $exception) {
              $incomingTradeOffers[$i]["PHOTO"][$j] = false;
            }
          }
        }

        preg_match_all("#ART':'(.*?)'#i", $JCCatalogElement[1], $artnumbers);
        for ($i = 0; $i < $count_element; $i++) {
          $incomingTradeOffers[$i]["ARTNUMBER"] = $artnumbers[1][$i];
        }
        preg_match("#PROP_(.*?)'#i", $JCCatalogElement[1], $propTp);
        if ($propTp[1] == 362) {
          preg_match_all("#PROP_362':'(.*?)'#i", $JCCatalogElement[1], $color);
          for ($i = 0; $i < $count_element; $i++)
            $incomingTradeOffers[$i]["COLOR"] = $color[1][$i];
        }
        if ($propTp[1] == 363) {
          preg_match_all("#PROP_363':'(.*?)'#i", $JCCatalogElement[1], $size);
          for ($i = 0; $i < $count_element; $i++)
            $incomingTradeOffers[$i]["SIZE"] = $size[1][$i];
        }

        //Удалить пустые размеры
        foreach ($incomingTradeOffers as $i => $tp) {
          if (isset($tp["SIZE"]) && $tp["SIZE"] == 0) {
            unset($incomingTradeOffers[$i]);
          }
          if (isset($tp["COLOR"]) && $tp["COLOR"] == 0) {
            unset($incomingTradeOffers[$i]);
          }
        }


        // пришло одно торговое предложение

        if (count($incomingTradeOffers) == 1) {
          foreach ($incomingTradeOffers as $i => $tp) {
            $arCheck = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 33, 'PROPERTY_ES_NAME_SEARCH' => $tp['NAME'], 'PROPERTY_CML2_LINK' => $arItem['ID']), false, false, array('ID', 'NAME', 'ACTIVE'))->Fetch();

            if (intval($arCheck['ID']) > 0) {
              CIBlockElement::Delete($arCheck['ID']);
            }

            $arProdFields = array(
              "PRODUCT_ID" => $arItem['ID'],
              "STORE_ID" => 5,
              "AMOUNT" => (int) $tp["QUANTITY"],
            );

            CCatalogStoreProduct::UpdateFromForm($arProdFields);

			if (!$isPriceFrozen) {
				if (!empty($tp["PRICE"]) && intval($tp["PRICE"]) > 0) {
				  // Цена не зафиксирована
				  CPrice::SetBasePrice($arItem['ID'], $tp["PRICE"], 'RUB');

				  if ($arItem['ACTIVE'] === 'Y') {
					FinanceManager::comparePrices($arItem['ID'], $arItem['NAME'], $arItem['PROPERTY_UPLOADED_FROM_PAGE_VALUE'], null, $tp["PRICE"], $tp['ARTNUMBER']);
				  }
				}
			}

            $stLog = "Q:" . intval($tp["QUANTITY"]) . ", P:" . floatval($arItem['CATALOG_PRICE_1']);
          }
        }


        /* Замена двойных пробелов на одинарные - */
        // чистка невалидных предложений

        $items = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 33, 'PROPERTY_CML2_LINK' => $arItem['ID']), false, false, array('ID', 'NAME', 'ACTIVE', 'PROPERTY_ES_NAME_SEARCH', 'PROPERTY_SIZE', 'PROPERTY_COLOR'));

        while ($itemRow = $items->Fetch()) {

          $PROP_SIZE = $itemRow['PROPERTY_SIZE_VALUE'];
          $PROP_COLOR = $itemRow['PROPERTY_COLOR_VALUE'];
          if ($PROP_SIZE == '-' || $PROP_COLOR == '-') {
            CIBlockElement::Delete($itemRow['ID']);
          }

          $NAME = trim($itemRow['NAME']);
          $NAME = str_replace('  ', ' ', $NAME);
          $preEl->Update($itemRow['ID'], array("NAME" => $NAME));

          $NAME_SEARCH = $itemRow['PROPERTY_ES_NAME_SEARCH_VALUE'];
          if (!empty($NAME_SEARCH)) {
            $NAME_SEARCH = str_replace('  ', ' ', $NAME_SEARCH);
            CIBlockElement::SetPropertyValueCode($itemRow['ID'], "ES_NAME_SEARCH", $NAME_SEARCH);
          }
          elseif (!empty($arItem["NAME"])) {
            CIBlockElement::SetPropertyValueCode($itemRow['ID'], "ES_NAME_SEARCH", $arItem["NAME"]);
          }

          /*
		  if ($NAME_SEARCH == $NAME) {
            $preEl->Update($itemRow['ID'], array("NAME" => $arItem["NAME"]));
          }
		  */
        }

        // работа с торговыми предложениями +-

        foreach ($incomingTradeOffers as $key => $tp) {

          $tp['NAME'] = str_replace('  ', ' ', $tp['NAME']);

          $tovar_name = trim($arProductName[1]);
          $product_name = ToLower(trim($arProductName[1]));
          $tp_name = ToLower(trim($tp['NAME']));

          if (!empty($tp['NAME']) && $product_name <> $tp_name) {

            // удаляем 1 торговое предложение // зачем ? хз....
            $FIRST_ID = '';
            if (count($incomingTradeOffers) > 1) {
              $arCheck = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 33, 'PROPERTY_CML2_LINK' => $arItem['ID'], 'PROPERTY_ES_NAME_SEARCH' => trim($tp['NAME'])), false, false, array('ID', 'NAME', 'ACTIVE', 'PROPERTY_ES_NAME_SEARCH'));
              while ($arCheckRow = $arCheck->Fetch()) {
                if (empty($FIRST_ID))
                  $FIRST_ID = $arCheckRow['PROPERTY_ES_NAME_SEARCH_VALUE'];
                else {
                  CIBlockElement::Delete($arCheckRow['ID']);
                }
              }
            }

            $arCheck = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 33, 'PROPERTY_CML2_LINK' => $arItem['ID'], 'PROPERTY_ES_NAME_SEARCH' => trim($tp['NAME'])), false, false, array('ID', 'NAME', 'ACTIVE', 'PROPERTY_CML2_LINK'))->Fetch();


            if (intval($arCheck['ID']) > 0) {

              /* // vremenno ubrali vse obnovleniya krome cen i kol-va
			  if (empty($arItem['PROPERTY_NOUPDATEPHOTO_VALUE'])) {
				CIBlockElement::SetPropertyValuesEx($arCheck['ID'], 33, ["PICTURES_SKU" => $tp['PHOTO']]);
			  }
			  */

              $arProdFields = array(
                "PRODUCT_ID" => $arCheck['ID'],
                "STORE_ID" => 5,
                "AMOUNT" => (int) $tp["QUANTITY"],
              );

              CCatalogStoreProduct::UpdateFromForm($arProdFields);

			  if (!$isPriceFrozen) {
				  if (!empty($tp["PRICE"]) && intval($tp["PRICE"]) > 0) {
					CPrice::SetBasePrice($arCheck['ID'], $tp["PRICE"], 'RUB');
				  }

				  if ($arItem['ACTIVE'] === 'Y') {
					FinanceManager::comparePrices($arItem['ID'], $arItem['NAME'], $arItem['PROPERTY_UPLOADED_FROM_PAGE_VALUE'], null, $tp["PRICE"], $tp['ARTNUMBER']);
				  }
			  }			  

			  $stLog = "Q:" . intval($tp["QUANTITY"]) . ", P:" . floatval($arItem['CATALOG_PRICE_1']);
				  
            }
            else {

              if ($tp["ARTNUMBER"]) {
                // добавляем торговое предложение


                /* --- Если у поставщика пропали цены выводим хотя бы старые цены --- */
                $ITEM_PRICE = intval($arItem['CATALOG_PRICE_1']);
                if (empty(intval($tp["PRICE"])) && !empty($ITEM_PRICE)) {
                  $tp["PRICE"] = $ITEM_PRICE;
                }
                /* --- // --- */

                $arProps = array();
                $arProps["CML2_LINK"] = $arItem['ID'];
                $arProps["CML2_ARTICLE"] = $tp["ARTNUMBER"];
                $arProps["ES_NAME_SEARCH"] = $tp["NAME"];
                $arProps["PICTURES_SKU"] = $tp["PHOTO"];
                $arProps["SIZE"] = $arPropOffers["SIZE"][$tp["SIZE"]]["ID"];
                $arProps["COLOR"] = $tp["COLOR"];

                $arFields = array(
                  'NAME' => $arItem["NAME"],
                  'IBLOCK_ID' => 33,
                  'ACTIVE' => 'Y',
                  'PROPERTY_VALUES' => $arProps,
                );

                $id = $preEl->Add($arFields);

                $arProdFields = array(
                  "PRODUCT_ID" => $id,
                  "STORE_ID" => 5,
                  "AMOUNT" => (int) $tp["QUANTITY"],
                );

                CCatalogStoreProduct::UpdateFromForm($arProdFields);

				if (!$isPriceFrozen) {
					if (!empty($tp["PRICE"]) && intval($tp["PRICE"]) > 0) {
					  CPrice::SetBasePrice($id, $tp["PRICE"], 'RUB');

					  if ($arItem['ACTIVE'] === 'Y') {
						FinanceManager::comparePrices($arItem['ID'], $arItem['NAME'], $arItem['PROPERTY_UPLOADED_FROM_PAGE_VALUE'], $arItem['CATALOG_PRICE_1'], $tp["PRICE"], $tp['ARTNUMBER']);
					  }
					}
				}
                $stLog = "Q:" . intval($tp["QUANTITY"]) . ", P:" . floatval($tp["PRICE"]);
              }
            }

            $stLogOffers[] = array(
              "NAME" => $tp['NAME'],
              "STATUS" => $stLog,
            );
          }
        }

        $itemOffers = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 33, 'PROPERTY_CML2_LINK' => $arItem['ID']), false, false, array('ID', 'NAME', 'PROPERTY_ES_NAME_SEARCH', "PROPERTY_CML2_ARTICLE"));
        while ($itemOffer = $itemOffers->Fetch()) {
          foreach ($incomingTradeOffers as $incomingTradeOffersItem) {
            if ($incomingTradeOffersItem['ARTNUMBER'] == $itemOffer["PROPERTY_CML2_ARTICLE_VALUE"]) {
              continue 2;
            }
          }

          $arProdFields = array(
            "PRODUCT_ID" => $itemOffer['ID'],
            "STORE_ID" => 5,
            "AMOUNT" => 0,
          );
          CCatalogStoreProduct::UpdateFromForm($arProdFields);
        }

        //Обновить кол-во у торговых если OFFERS пустой
        if (count($incomingTradeOffers) == 0) {
          $itemOffers = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 33, 'PROPERTY_CML2_LINK' => $arItem['ID']), false, false, array('ID', 'NAME', 'PROPERTY_ES_NAME_SEARCH'));
          while ($itemOffer = $itemOffers->Fetch()) {
            $arProdFields = array(
              "PRODUCT_ID" => $itemOffer['ID'],
              "STORE_ID" => 5,
              "AMOUNT" => 0,
            );
            CCatalogStoreProduct::UpdateFromForm($arProdFields);

            $arProdFields = array(
              "PRODUCT_ID" => $itemOffer['ID'],
              "STORE_ID" => 6,
              "AMOUNT" => 0,
            );
            CCatalogStoreProduct::UpdateFromForm($arProdFields);
          }
        }
        elseif (count($incomingTradeOffers) == 1) {
          $itemOffers = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 33, 'PROPERTY_CML2_LINK' => $arItem['ID']), false, false, array('ID', 'NAME', 'PROPERTY_ES_NAME_SEARCH', "PROPERTY_CML2_ARTICLE"));
          $itemOffersCount = $itemOffers->SelectedRowsCount();
          if ($itemOffersCount == 1) {
            $itemOffer = $itemOffers->Fetch();

            $OFFER_QUANTITY = (int) $incomingTradeOffers[0]['QUANTITY'];
            $OFFER_PRICE = (int) $incomingTradeOffers[0]['PRICE'];
            $arProdFields = array(
              "PRODUCT_ID" => $arItem['ID'],
              "STORE_ID" => 5,
              "AMOUNT" => $OFFER_QUANTITY,
            );
            CCatalogStoreProduct::UpdateFromForm($arProdFields);

            if (!$isPriceFrozen && !empty($OFFER_PRICE)) {
              CPrice::SetBasePrice($arItem['ID'], $OFFER_PRICE, 'RUB');
            }

            CIBlockElement::Delete($itemOffer['ID']);
          }
        }
		
		/*if ($arItem['IBLOCK_SECTION_ID'] != 3532 && $arItem['IBLOCK_SECTION_ID'] != 3688 && $arItem['IBLOCK_SECTION_ID'] != 3688) {
			$preEl->Update($arItem['ID'], ['ACTIVE' => 'Y']);	
		}*/
		
      } else { // deactivate non 200

		if ($arItem['ACTIVE'] == 'Y') {
			$errorStatusElements[] = $arItem['NAME']. ' - '. $arItem['PROPERTY_UPLOADED_FROM_PAGE_VALUE']. ': status '. $arCurl['CODE'];
		}
		/*if ($arCurl["CODE"] == 404 || $arCurl["CODE"] == 301) {
			$preEl->Update($arItem['ID'], ['ACTIVE' => 'N']);		
		}*/
		  
	  }
	  
      if (!$isPriceFrozen) {
		FinanceManager::updateMinMaxPrices($arItem['ID']);
	  }

      // заполняем логи (идет в админку)

      $arLog = array();
      $arLog["DATE"] = time();
      $arLog["URL"] = $sourceUrl;
      $arLog["HTTP_CODE"] = $arCurl["CODE"];
      $arLog["STATUS"] = $stLog;
      $arLog["OFFERS"] = $stLogOffers;

      $arStatus["LOG_RIGGER"][] = $arLog;


      // изменяем статус парсера (идет в админку)

      ESUtils::SaveOption("status-run", array(
        "ID" => "riggershop.ru",
        "URL" => $sourceUrl,
        "CNT" => $currentProccesingElementIndex . " / " . $obElement->SelectedRowsCount(),
      ));
	  
    }
	
	if (!empty($errorStatusElements)) {
		
		ESUtils::SaveOption("errors-page", array(
			"ID" => "Rigger",
			"PAGE" => $errorStatusElements,
		));		
		
	}

    // изменяем статус парсера (идет в админку)
    ESUtils::SaveOption("status-run", [
      "ID" => "riggershop.ru",
      "URL" => '',
      "CNT" => '...',
    ]);

    // удаляет промежуточные файлы +-
    FilesManager::cleanCachedFiles();

    Log::msg('Rigger update finish');
  }

  private static function start1() {

  }
  private static function start2() {

  }


}
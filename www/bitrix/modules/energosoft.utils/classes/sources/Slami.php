<?php
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Xbartes\PhpSimple\HtmlDomParser;

class Slami {
  private static $url = 'https://slami.ru';

  static function update( &$arStatus = null, $blockID = 32, $sectionID = '', $itemID = '' ) {
    // $blockID = 32 товары

    Log::msg('Slami update');
    Log::msg("block - $blockID , section - $sectionID, item - $itemID");

    $GLOBALS['SLAMI_SERVER'] = static::$url;
    $arStatus["LOG_SLAMI"] = [];

    $priceListFileStream = static::getPriceListFile();
    $pricelist = static::slamiPriceList($priceListFileStream);

    $preEl = new CIBlockElement;

    $obElement = CIBlockElement::GetList(
      array(),
      array(
        'IBLOCK_ID' => $blockID,
        'IBLOCK_SECTION_ID' => $sectionID,
        'ID' => $itemID,
        'PROPERTY_UPLOADED_FROM_PAGE' => '%slami%',
        //'ACTIVE' => 'Y'
	  ),
      false,
      false,
      array(
        'ID',
        'NAME',
        'ACTIVE',
        "IBLOCK_SECTION_ID",
        'XML_ID',
        'IBLOCK_ID',
        'PROPERTY_UPLOADED_FROM_PAGE',
        'CATALOG_GROUP_1',
        'PROPERTY_CML2_ARTICLE',
        'PROPERTY_UPDATE_DETAIL_TEXT_STATUS',
        'PROPERTY_UPDATE_PREVIEW_TEXT_STATUS',
        'PROPERTY_PRICE_FROZEN'
      )
    );
    while ($arItem = $obElement->Fetch()) {

      // return $arItem;
	  
	  $isPriceFrozen = $arItem['PROPERTY_PRICE_FROZEN_VALUE'] !== null;
	  
	  $errorStatusElements = [];

      $arCurl = ESUtils::CurlGet($arItem['PROPERTY_UPLOADED_FROM_PAGE_VALUE']);
      if ($arCurl['CODE'] == 200) {

        $arCurl['DATA'] = iconv("Windows-1251", "UTF-8", $arCurl['DATA']);
        $html = HtmlDomParser::str_get_html($arCurl['DATA']);
        $ar_number = $html->find('span.code', 0)->innertext;
        $ar_number = trim($ar_number);

        //$name = $pricelist[$ar_number]['NAME'];
        $price = $pricelist[$ar_number]['PRICE'];

        /* --- Если в файле нет цены то берем с сайта поставщика --- */
        preg_match_all('#<div class="priceblock">(.+?)</div>#is', $html, $arr);
        preg_match_all('#<span class="value">(.+?)</span>#is', $arr[1][0], $arr2);
        $price_site = $arr2[1][0];
        $price_site = preg_replace('/\s+/', '', $price_site);
        if (empty($price))
          $price = $price_site;
        /* --- // --- */

        /*$image = $html->find('.photo img', 0)->src;
        if (!empty($image)) {
          $image = $GLOBALS['SLAMI_SERVER'] . $image;
          $image = CFile::MakeFileArray($image);
        }

        $name = $html->find('h1', 0)->innertext;
        $name = str_replace('amp;', '', $name);
        $preview_text = $html->find('.preview-text', 0)->innertext;
        $description = $html->find('.description', 0);

        foreach ($description->find('h2') as $value3) {
          $description->removeChild($value3);
        }
        $description->removeChild($description->find('.alsosimilar', 0));

        //код + краткое описание = название
        $name = $name . ' ' . $preview_text;

        $CODE = CUtil::translit(ESUtils::Transliterator($name), "ru", array("replace_space" => "-", "replace_other" => "-"));

        $arFields = array(
          "NAME" => $name,
          "CODE" => $CODE
        );

        if (!$arItem['PROPERTY_UPDATE_PREVIEW_TEXT_STATUS_VALUE']) {
          $arFields["PREVIEW_TEXT"] = $preview_text ?? '';
        }
        if (!$arItem['PROPERTY_UPDATE_DETAIL_TEXT_STATUS_VALUE'] && $arItem['PROPERTY_UPDATE_DETAIL_TEXT_STATUS_VALUE'] <> 'да') {
          $arFields["DETAIL_TEXT"] = $description ?? '';
        }*/

        //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/cron/logs.txt' , date("Y-m-d H:i:s").' '.$arItem['ID'].' = '.$arItem['PROPERTY_UPDATE_DETAIL_TEXT_STATUS_VALUE'].PHP_EOL , FILE_APPEND );

        //$preEl->update($arItem['ID'], $arFields); // vremenno ubrali vse obnovleniya krome cen i kol-va

        //Остаток
        $QUANTITY = $pricelist[$ar_number]['QUANTITY'];

        if (!is_int($pricelist[$ar_number]['QUANTITY'])) {
			$QUANTITY = (int) filter_var($QUANTITY, FILTER_SANITIZE_NUMBER_INT);
		}

        CCatalogStoreProduct::UpdateFromForm([
          'PRODUCT_ID' => $arItem['ID'],
          'STORE_ID' => 5, //Удаленный склад
          'AMOUNT' => $QUANTITY
        ]);

        $ar_number_new = 'S-' . $ar_number;
        CIBlockElement::SetPropertyValueCode($arItem["ID"], "CML2_ARTICLE", $ar_number_new);
        
        // Цена      
        if (!$isPriceFrozen && !empty($price)) {
			CPrice::SetBasePrice($arItem['ID'], $price, 'RUB');
			
			FinanceManager::updateMinMaxPrices($arItem['ID']);
		}

        //////////////////

        $arLog = array();
        $arLog['DATE'] = time();
        $arLog['LINK'] = '<a href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=' . $arItem['IBLOCK_ID'] . '&type=catalog_new&ID=' . $arItem['ID'] . '&lang=ru&find_section_section=' . $arItem['IBLOCK_SECTION_ID'] . '&WF=Y">' . $arItem['NAME'] . '</a>';
        $arLog['URL'] = $arItem['PROPERTY_UPLOADED_FROM_PAGE_VALUE'];
        $arLog['HTTP_CODE'] = $arCurl['CODE'];
        $arLog['STATUS'] = 'Прайс';
        $arLog['PRICE_LIST'] = 'P:' . $price;
        $arStatus['LOG_SLAMI'][] = $arLog;
		
		if ($arItem['IBLOCK_SECTION_ID'] != 3577 && $arItem['IBLOCK_SECTION_ID'] != 3612) {
			$preEl->Update($arItem['ID'], ['ACTIVE' => 'Y']);	
		}
		
      } else { // deactivate non 200
	  
		if ($arItem['ACTIVE'] == 'Y') {
			$errorStatusElements[] = $arItem['NAME']. ' - '. $arItem['PROPERTY_UPLOADED_FROM_PAGE_VALUE']. ': status '. $arCurl['CODE'];
		}
		if ($arCurl["CODE"] == 404 || $arCurl["CODE"] == 301) {
			$preEl->Update($arItem['ID'], ['ACTIVE' => 'N']);	
		}
		
      }
	  
    }
	
	if (!empty($errorStatusElements)) {

		ESUtils::SaveOption("errors-page", array(
			"ID" => "Slami",
			"PAGE" => $errorStatusElements,
		));		
		
	}
	
    fclose($priceListFileStream);
    ESUtils::SaveOption("status-run", array(
      "ID" => "slami.ru",
      "URL" => '',
      "CNT" => '...',
    ));
    Log::msg('Slami update finish');
	
  }
  
  static function getPriceListFile() {
    $filename = $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/energosoft.utils/tmp/sl_price.csv";
    $f = fopen($filename, "w");
   
   $ch = curl_init();
    curl_setopt_array($ch, [
      //CURLOPT_URL => "https://dealer.slami.ru/api/getcsv/?token=08e0c0203de54515a9e121dc001d90df",
	  CURLOPT_URL => "https://dealer.slami.ru/info/pricelist.csv",
	  CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_FILE => $f
    ]);
    curl_exec($ch); print_r($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); echo $http_code;
    curl_close($ch);
    
	if ($http_code == 200) {
      $file_data = file_get_contents($filename);
      $utf8_file_data = iconv("Windows-1251", "UTF-8", $file_data);
      $utf8_filename = $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/energosoft.utils/tmp/sl_price_utf8.csv";
      file_put_contents($utf8_filename, $utf8_file_data);
      fclose($f);

      $f = fopen($utf8_filename, "r");
      return $f;
    }
    else {
      fclose($f);
      return false;
    }
  }
  
  static function slamiPriceList( $fileStream ) {
    $arr_pricelist_ustage = static::slamiPriceUstage(); //файл который дали ustage статичный

    $arr_pricelist = [];
    $i = 0;
    while (($arRow = fgetcsv($fileStream, 10000, ";")) !== false) {
      if (++$i == 1)
        continue;

      $arnumber = trim($arRow[12]);

      //теперь добавляются и обновляются только товары из файла который дали они, но разница в ценах и процент из актуального файла
      if (!isset($arr_pricelist_ustage[$arnumber]) || empty($arr_pricelist_ustage[$arnumber])) {
        continue;
      }

      $dlrPrice = ($arRow[9] == 0) ? $arRow[8] : $arRow[9];
	  $PERCENT = (float) 1 - ($arRow[10] / $dlrPrice);
      $PERCENT = round($PERCENT, 2);

      if ($PERCENT >= 0.2) {
        $arr_pricelist[$arnumber]['PRICE'] = $dlrPrice;
        $arr_pricelist[$arnumber]['NAME'] = $arRow[7];
        $arr_pricelist[$arnumber]['PERCENT'] = $PERCENT;
        $arr_pricelist[$arnumber]['QUANTITY'] = $arRow[11];
      }
    }

    return $arr_pricelist;
  }
  
  static function slamiPriceUstage() {
    //файл который дали сами ustage чтобы обновлялись только эти товары

    $filename = $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/energosoft.utils/tmp/sl_price_ustage.csv";
    $file_data = file_get_contents($filename);
    $utf8_file_data = iconv("Windows-1251", "UTF-8", $file_data);
    $utf8_filename = $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/energosoft.utils/tmp/sl_price_ustage_utf8.csv";
    file_put_contents($utf8_filename, $utf8_file_data);
    // fclose($f); // ?????? 
    $f = fopen($utf8_filename, "r");

    $arr_pricelist = [];
    $i = 0;
    while (($arRow = fgetcsv($f, 10000, ";")) !== false) {
      if (++$i == 1)
        continue;

      $arnumber = trim($arRow[12]);
	
	  $dlrPrice = ($arRow[9] == 0) ? $arRow[8] : $arRow[9];
      $arr_pricelist[$arnumber]['PRICE'] = $dlrPrice;
      $arr_pricelist[$arnumber]['NAME'] = $arRow[7];
    }

    return $arr_pricelist;
  }

}
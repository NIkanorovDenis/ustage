<?php
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Xbartes\PhpSimple\HtmlDomParser;

class Imlight {
	
  private static $url = 'https://www.imlight.ru/sitemap.xml';
  private static $iblockID = 32;
  private static $sectionID = 3689;
  private static $postID = 'imlight';
  private static $postUrl = 'imlight.ru';

  static function update(&$arStatus = null) {

	Log::msg('Imlight update');
	
	$arStatus["LOG_IMLIGHT"] = [];
    $arCurl = ESUtils::CurlGet(static::$url);
	
	if ($arCurl["CODE"] == 200) {
          
		$arElements = [];
		$xml = (array)simplexml_load_string($arCurl["DATA"]);
		
		$errorStatusElements = [];
		$el = new CIBlockElement;
		
		foreach ($xml["url"] as $k=>$obLink) { 
			
			$arLink = (array)$obLink;
			
			if (stripos($arLink['loc'], '/katalog-tovarov/') === false) {
				continue;
			}		
			
			$arCurlItem = ESUtils::CurlGet($arLink['loc']); 

			$obElement = CIBlockElement::GetList(
				[], 
				['IBLOCK_ID' => static::$iblockID, 'PROPERTY_UPLOADED_FROM_PAGE' => $arLink['loc']], 
				false, 
				false, 
				['ID', 'NAME', 'ACTIVE', 'IBLOCK_ID', 'PROPERTY_UPLOADED_FROM_PAGE', 'PROPERTY_PRICE_FROZEN']
			);	
			$arItem = $obElement->Fetch();	
			
			if ($arCurlItem["CODE"] == '200') {	

				$html = HtmlDomParser::str_get_html($arCurlItem['DATA']);
				if (!empty($html)) {
					
					$productBlock = $html->find('div.product-specifications__content', 0)->innertext;
					
					if (!$productBlock) {
						continue;
					} 			
								
					/*$obElement = CIBlockElement::GetList(
						[], 
						['IBLOCK_ID' => static::$iblockID, 'PROPERTY_UPLOADED_FROM_PAGE' => $arLink['loc']], 
						false, 
						false, 
						['ID', 'NAME', 'ACTIVE', 'IBLOCK_ID', 'PROPERTY_UPLOADED_FROM_PAGE', 'PROPERTY_PRICE_FROZEN']
					);*/
					$num = $obElement->SelectedRowsCount();
					$name = trim(strip_tags( $html->find('.product_name_title', 0)->plaintext ));
					$name2 = trim(strip_tags( $html->find('.product-specifications__right_block div[umi:field-name="short_description"]', 0)->plaintext ));
					$detailText = $html->find('#description div[umi:field-name="description"]', 0)->innertext;
					
					$stock = str_replace([' ', '&nbsp;', '\xc2\xa0'], '', htmlentities(trim($html->find('.product-specifications__right_block span[umi:field-name="common_quantity"]', 0)->plaintext)));
					$stock = html_entity_decode($stock); 				
					
					if ($num == 0) {
						if (!empty($name)) {
							
							$elCode = CUtil::translit(ESUtils::Transliterator($name), "ru", array("replace_space" => "-", "replace_other" => "-"));
							
							$photo = $html->find('.product-specifications__image-big a', 0)->href;					
							$dopPhotos = [];
							
							if (!empty($photo)) {
								$arFields['PREVIEW_PICTURE'] = $arFields['DETAIL_PICTURE'] = CFile::MakeFileArray('https://' . static::$postUrl . $photo);
								$dopPhotos[] = $arFields['PREVIEW_PICTURE'];
							}					
							
							if (count($html->find('.product-specifications__images .product-specifications__images-item-wrap'))) {
								foreach ($html->find('.product-specifications__images .product-specifications__images-item-wrap') as $dopPhoto) {
									$dopPhotos[] = CFile::MakeFileArray('https://' . static::$postUrl . $dopPhoto->find('a.product-specifications__images-item', 0)->href);
								}
							}
							
							$files = [];
							if (count($html->find('.download-items .download-items__item'))) {
								foreach ($html->find('.download-items .download-items__item') as $file) {
									$files[] = [
										'DESCRIPTION' => $file->find('span.download-items__item-text', 0)->plaintext,
										'VALUE'  => CFile::MakeFileArray('https://' . static::$postUrl . $file->href)
									];
								}
							}

							$PROPS = array(
								'UPLOADED_FROM_PAGE' => $arLink['loc'],
								'UPLOADED_PHOTO' => 'https://' . static::$postUrl . $photo,
								'MORE_PHOTO' => $dopPhotos,
								'DOCS' => $files,
								'GUID' => str_replace('Код: ', '', $html->find('.product-interaction span[umi:field-name="1c_guid"]', 0)->innertext),
								'CML2_ARTICLE' => str_replace('Артикул: ', '', $html->find('.product-interaction ._date', 0)->last_child()->innertext),	
								'ES_EXIST' => !empty($stock) ? 642 : 0,	
								'POSTAVSHCHIK' => static::$postID					
							);					

							$arFields = [
								'MODIFIED_BY' => 1, 
								'IBLOCK_SECTION_ID' => static::$sectionID,
								'IBLOCK_ID' => static::$iblockID,
								'PROPERTY_VALUES' => $PROPS,
								"NAME" => (!empty($name2) ? $name2.' ' : '') . $name,
								'CODE' => $elCode,
								'ACTIVE' => 'N',
								'DETAIL_TEXT' => $detailText,
								'DETAIL_TEXT_TYPE'  => 'HTML',
							];			

							if ($PRODUCT_ID = $el->Add($arFields)) {
								
								Log::msg('New ID: '. $PRODUCT_ID  .'-'. $name);
								
							}	

							$isPriceFrozen = false;
					
						}
					} else {
						
						$PRODUCT_ID = $arItem['ID'];
						$isPriceFrozen = $arItem['PROPERTY_PRICE_FROZEN_VALUE'] !== null;
						
						/*if (!empty($PRODUCT_ID)) {
							
							$el = new CIBlockElement;
							$arUpdateProduct = Array(
							   "NAME" => (!empty($name2) ? $name2.' ' : '') . $name,
							   "DETAIL_TEXT_TYPE" =>"html",
							   "DETAIL_TEXT" => html_entity_decode($detailText), 
							);
							$resUpdate = $el->Update($PRODUCT_ID, $arUpdateProduct);
							
						}*/
						
						Log::msg('UPDATE: ' . $PRODUCT_ID);
						
					}	
					
					if (!empty($PRODUCT_ID)) {
							
						$price = str_replace([' ', '&nbsp;', '\xc2\xa0'], '', htmlentities($html->find('.product-interaction__price-number .item_total', 0)->plaintext)); 
						$price = html_entity_decode($price); 
						if (!$isPriceFrozen && !empty($price)) {
							CPrice::SetBasePrice($PRODUCT_ID, $price, 'RUB');
							FinanceManager::updateMinMaxPrices($PRODUCT_ID);
						}	

						$stockVal = !empty($stock) ? 100 : 0;
						$arFieldsStore = [
							'ID' => $PRODUCT_ID,
							'AVAILABLE' => (!empty($stock) ? 'Y' : 'N'),
							'QUANTITY' => $stockVal
						]; 
						if (!CCatalogProduct::Add($arFieldsStore)) {
							CCatalogProduct::Update($PRODUCT_ID, $arFieldsStore);
						}
						
						CCatalogStoreProduct::UpdateFromForm([
						  'PRODUCT_ID' => $PRODUCT_ID,
						  'STORE_ID' => 5, //Удаленный склад
						  'AMOUNT' => $stockVal
						]);

						$stLog = 'Q:' . $stockVal . ', P:' . floatval($price);

						$arLog = [];
						$arLog["DATE"] = time();
						$arLog["LINK"] = '<a href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID='. static::$iblockID .'&type=catalog_new&ID='. $PRODUCT_ID .'&lang=ru&find_section_section='. static::$sectionID .'&WF=Y">' . $name . '</a>';
						$arLog["URL"] = $arLink['loc'];
						$arLog["HTTP_CODE"] = $arCurlItem["CODE"];
						$arLog["STATUS"] = $stLog;
						$arStatus["LOG_IMLIGHT"][] = $arLog; 

						ESUtils::SaveOption('status-run', [
							'ID' => 'imlight.ru',
							'URL' => $arLink['loc'],
							'CNT' => $k . ' / ' . count($xml["url"]),
						]);				
						
						$arElements[] = $arLink['loc'];	
						
						//$el->Update($arItem['ID'], ['ACTIVE' => 'Y']);	

					}		
					
				}
			}  else { // deactivate non 200					
				
				if ($arItem['ACTIVE'] == 'Y') {
					$errorStatusElements[] = date('Ymdh') . ' - '. $arItem['NAME']. ' - '. $arItem['PROPERTY_UPLOADED_FROM_PAGE_VALUE']. ': status '. $arCurlItem["CODE"];
				}
				$el->Update($arItem['ID'], ['ACTIVE' => 'N']);			
				
			}
			
		}	

		if (!empty($errorStatusElements)) {
			
            ESUtils::SaveOption("errors-page", array(
                "ID" => "Imlight",
                "PAGE" => $errorStatusElements,
            ));			
			
		}
		
        ESUtils::SaveOption("status-run", array(
            "ID" => "imlight.ru",
            "URL" => '',
            "CNT" => '...',
        ));
		Log::msg('Imlight update finish');		
		
	} 	
	
  }

}


<?php

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

require $_SERVER['DOCUMENT_ROOT'] . '/send/PHPMailer/src/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/send/PHPMailer/src/SMTP.php';
require $_SERVER['DOCUMENT_ROOT'] . '/send/PHPMailer/src/Exception.php';

require $_SERVER['DOCUMENT_ROOT'] . '/lib/PHPExcel.php';
require $_SERVER['DOCUMENT_ROOT'] . '/lib/PHPExcel/IOFactory.php';

use Shuchkin\SimpleXLS;

use PHPMailer\PHPMailer\PHPMailer;

use Automattic\WooCommerce\Client;

// use Automattic\WooCommerce\HttpClient\HttpClientException;

use Bitrix\Catalog\PriceTable;
use Bitrix\Iblock\Model\PropertyFeature;

use Xbartes\PhpSimple\HtmlDomParser;

use Alchemy\Zippy\Zippy;

define('ID_IBLOCK_CATALOG', 32);
define('ID_SECTION_EDS', 3546);

define('ID_MODIFICATION_PROPERTY', 8394); 

class ESParser {
    protected static $cachedImages = [];
	
	public static function Imlight(&$arStatus) {
        
		//sendAlarmTG('🏁 /bitrix/modules/energosoft.utils/classes/general/es-parser.php. Запускается функция Imlight');
        return Imlight::update($arStatus);
                
    }
	
	/*eds*/

    public static function EDS(&$arStatus) {
		
        sendAlarmTG('🏁 /bitrix/modules/energosoft.utils/classes/general/es-parser.php. Запускается функция EDS Update');

        $arStatus["LOG_EDS"] = [];

        $woocommerce = new Client(
            'https://edsy.ru',
            'ck_2503434fc3c7f489d57e85f639df9ee5aa0789c0',
            'cs_58e6d0e91cd573e3136d92c9a87f8851a2febd1b',
            [
                'wp_api' => true,
                'version' => 'wc/v3',
                // 'query_string_auth' => true,
            ]
        );

        $categories = [
            '303', // Ввод от 63А
            '324', // Дистрибьюторы со встроенным сплиттером
            '349', // Коробки коммутационные
            '313', // Пульты лебедочные аналоговые
            '353', // Пульты лебедочные цифровые
            '305', // Рэковые дистрибьюторы
            '326', // Секвенсоры
            '306', // Серия Black Edition
            '304', // Туровые дистрибьюторы
            '312' // Устройства с защитными реле
        ];

        function recursiveGetChildren($id, &$categories, $woocommerce)
        {
            $children = $woocommerce->get('products/categories', [
                'parent' => $id,
            ]);

            if (!$children) {
                return;
            }

            foreach ($children as $child) {
                if (!in_array($child->id, $categories)) {
                    $categories[] = $child->id;

                    recursiveGetChildren($child->id, $categories, $woocommerce);
                }
            }
        }

        foreach ($categories as $id) {
            recursiveGetChildren($id, $categories, $woocommerce);
        }

        foreach ($categories as $i => $id) {
            /** @var object $category */
            $category = $woocommerce->get('products/categories/' . $id);

            if (!$category) {
                unset($categories[$i]);
                continue;
            }

            $categories[$i] = $category;
        }

        $element = new CIBlockElement();
        $section = new CIBlockSection();

        $productNumber = 1;

        foreach ($categories as $category) {
            $page = 1;

            // Add category
            $sectionName = trim($category->name);

            $arSection = CIBlockSection::GetList([], [
                'IBLOCK_ID' => ID_IBLOCK_CATALOG,
                'IBLOCK_SECTION_ID' => ID_SECTION_EDS,
                'UF_API_ID' => $category->id
            ])->Fetch();

            if ($arSection['ID'] > 0) {
                $sectionId = $arSection['ID'];
            } else {
                $sectionCode = trim(ToLower(CUtil::translit(ESUtils::Transliterator($sectionName), 'ru', [
                    'replace_space' => '-',
                    'replace_other' => '-',
                ])), '-');

                $arSectionFields = [
                    'IBLOCK_ID' => ID_IBLOCK_CATALOG,
                    'IBLOCK_SECTION_ID' => ID_SECTION_EDS,
                    'ACTIVE' => 'Y',
                    'UF_API_ID' => $category->id,
                    'NAME' => $sectionName,
                    'CODE' => 'eds-' . $sectionCode,
                ];

                if ($category->image) {
                    try {
                        $arFile = self::makeFileArray($category->image->src);
                        $arSectionFields['PICTURE'] = $arFile;
                    } catch (Exception $exception) {
                    }
                }

                $sectionId = $section->Add($arSectionFields);

                if (!$sectionId) {
                    continue;
                }
            }

            do {
				
                $products = $woocommerce->get('products', [
                    'page' => $page,
                    'per_page' => 100,
                    'status' => 'publish',
                    'category' => $category->id,
                ]);


                foreach ($products as $product) {

                    //if (!strpos($product->name, '406 RCD')) continue;

                    if (!$product->sku) {
                        continue;
                    }

                    $arElement = CIBlockElement::GetList([], [
                        'IBLOCK_ID' => ID_IBLOCK_CATALOG,
                        'PROPERTY_CML2_ARTICLE' => $product->sku,
                    ], false, false, [
                        'ID',
                        'NAME',
                        'ACTIVE',
                        'XML_ID',
                        'IBLOCK_ID',
                        'PROPERTY_UPLOADED_FROM_PAGE',
                        'CATALOG_GROUP_1',
                        'PROPERTY_CML2_ARTICLE',
                        'PROPERTY_MORE_PHOTO',
                        'PROPERTY_PRICE_FROZEN', // 716
                        'PROPERTY_UPDATE_DETAIL_TEXT_STATUS'       
                    ])->Fetch();


                    if ($arElement['ID'] > 0) {
                        $productId = $arElement['ID'];
                    } else {
                        $productId = null;
                    }


                    $code = trim(ToLower(CUtil::translit(ESUtils::Transliterator($product->name), 'ru', [
                        'replace_space' => '-',
                        'replace_other' => '-',
                    ])), '-');


                    $arFields = [
                        'IBLOCK_ID' => ID_IBLOCK_CATALOG,
                        'IBLOCK_SECTION_ID' => $sectionId,
                        'ACTIVE' => 'Y',
                        'NAME' => $product->name,
                        'CODE' => $code,
                        'PROPERTY_VALUES' => [],
                    ];

                    $arFields['PROPERTY_VALUES']['CML2_ARTICLE'] = $product->sku;
                    $arFields['PROPERTY_VALUES']['UPLOADED_FROM_PAGE'] = $product->permalink;

                    $description = '';

                    foreach ($product->meta_data as $metaData) {
                        if ($metaData->key === 'opisanie') {
                            $description = trim($metaData->value);
                            break;
                        }
                    }


                    if (!$description) {
                        $description = trim($product->short_description);
                    }

                    if (
                        $description && 
                        !$arElement['PROPERTIES']['DETAIL_TEXT']['VALUE'] && 
                        !$arItem['PROPERTY_UPDATE_DETAIL_TEXT_STATUS_VALUE'] && 
                        $arItem['PROPERTY_UPDATE_DETAIL_TEXT_STATUS_VALUE'] <> 'да'
                    ) {
                        $arFields['DETAIL_TEXT'] = $description;
                        $arFields['DETAIL_TEXT_TYPE'] = 'html';
                    }

                    // Parse PROPERTY_VALUES and NAME from description
                    try {
                        $html = HtmlDomParser::str_get_html($product->description);

                        $h2List = $html->find('h2');

                        foreach ($h2List as $h2) {
                            $h2Text = trim(strip_tags($h2->innertext()));

                            if ($h2Text) {
                                $arFields['NAME'] = $h2Text;
                                break;
                            }
                        }


                        $propertyCodes = [];

                        $tablesList = $html->find('table');

                        foreach ($tablesList as $table) {
                            $tableRowsList = $table->find('tr');

                            foreach ($tableRowsList as $tableRow) {
                                $tableDataList = $tableRow->find('td');

                                if (count($tableDataList) !== 2) {
                                    continue;
                                }

                                $propName = trim(strip_tags($tableDataList[0]->innertext()));
                                $propValue = trim(strip_tags($tableDataList[1]->innertext()));

                                $propCode = self::getPropCodeByName($propName);

                                if ($propCode) {
                                    $arFields['PROPERTY_VALUES'][$propCode] = $propValue;

                                    if ($productId) {
                                        //CIBlockElement::SetPropertyValueCode($productId, $propCode, $propValue); // vremenno ubrali vse obnovleniya krome cen i kol-va

                                        $propertyCodes[] = $propCode;
                                    }
                                }
                            }
                        }

                        if ($productId) {
                            self::cleanProperties($productId, $propertyCodes);
                        }
                    } catch (Exception $exception) {
                    }


                    if (is_array($product->images) && count($product->images) > 0) {
                        /*if ($productId) { // vremenno ubrali vse obnovleniya krome cen i kol-va
                            CIBlockElement::SetPropertyValuesEx($productId, ID_IBLOCK_CATALOG, [
                                'MORE_PHOTO' => [
                                    'VALUE' => ['DEL' => 'Y'],
                                ],
                            ]);
                        }*/

                        foreach ($product->images as $i => $image) {
                            try {
                                $arFile = self::makeFileArray($image->src);
                                $arFields['PROPERTY_VALUES']['MORE_PHOTO'][] = $arFile;

                                if ($i === 0) {
                                    $arFields['PREVIEW_PICTURE'] = $arFile;
                                }
                            } catch (Exception $exception) {
                            }
                        }

                    }


                    $price = round((float)$product->price);
                    $price = number_format($price, 2, '.', '');

                    $arFields['PROPERTY_VALUES']['MINIMUM_PRICE'] = $price;
                    $arFields['PROPERTY_VALUES']['MAXIMUM_PRICE'] = $price;

                    $arFields['PROPERTY_VALUES']['MANUFACTURER'] = 'eds';
                    $arFields['PROPERTY_VALUES']['POSTAVSHCHIK'] = 'eds';


                    if ($productId) {
                        //$element->Update($productId, $arFields); // vremenno ubrali vse obnovleniya krome cen i kol-va

                        $isPriceFrozen = $arElement['PROPERTY_PRICE_FROZEN_VALUE'] !== null;

                        if (!$isPriceFrozen) {
                            CPrice::SetBasePrice($productId, $price, 'RUB');							
							self::updateMinMaxPrices($productId);
                        }
                    } else {
                        $productId = $element->Add($arFields);

                        CPrice::SetBasePrice($productId, $price, 'RUB');

                        if (!$productId) {
                            continue;
                        }
                    }

                    $stockQuantity = $product->stock_quantity;

                    if ($stockQuantity > 0) {
                        CIBlockElement::SetPropertyValueCode($productId, 'ES_EXIST', 642);
                    } else {
                        CIBlockElement::SetPropertyValueCode($productId, 'ES_EXIST', false);
                    }

                    // Удаленный склад
                    CCatalogStoreProduct::UpdateFromForm([
                        'PRODUCT_ID' => $productId,
                        'STORE_ID' => 5,
                        'AMOUNT' => $stockQuantity,
                    ]);

                    // Магазин в Санкт-Петербурге
                    CCatalogStoreProduct::UpdateFromForm([
                        'PRODUCT_ID' => $productId,
                        'STORE_ID' => 6,
                        'AMOUNT' => 0,
                    ]);

                    $stLog = 'Q:' . intval($stockQuantity) . ', P:' . floatval($price);

                    $arStatus['LOG_EDS'][] = [
                        'DATE' => time(),
                        'URL' => $product->permalink,
                        'HTTP_CODE' => 200,
                        'STATUS' => $stLog,
                        'OFFERS' => [],
                    ];

                    ESUtils::SaveOption('status-run', [
                        'ID' => 'edsy.ru',
                        'URL' => $product->permalink,
                        'CNT' => $productNumber,
                    ]);

                    $productNumber++;


                }
                $page++;
            } while ($products && $page <= 1000);
        }

        sendAlarmTG('/bitrix/modules/energosoft.utils/classes/general/es-parser.php. Завершается функция EDS 🔚');

    }

	/*anzhee*/
	public static function AnzheeAdd() {
		sendAlarmTG('🏁 /bitrix/modules/energosoft.utils/classes/general/es-parser.php. Запускается функция Anzhee Add');

        $server = 'https://anzhee-light.ru/';
        $url = 'https://anzhee-light.ru/catalog/';

        $arCurl = ESUtils::CurlGet($url);

        if ($arCurl["CODE"] == 200) {
            $searchPage = str_replace(array("\n", "\r", "\t"), "", $arCurl["DATA"]);
            $searchPage = preg_replace('/<!---.*?--->/ui', "", $searchPage);

            // links
            $arLinks = array();
            $arProducts = array();
            $arr = array();
            preg_match_all("/<a href=\"\/catalog\/(.*?)\">/im", $searchPage, $arr);

            foreach ($arr[1] as $link) {
                $link = strip_tags($link);

                $arr_link = explode('"', $link);
                $link = $arr_link[0];

                if (empty($link)) continue;

                $arLinks[] = $url . $link;
            }

            $arLinks = array_unique($arLinks);

            foreach ($arLinks as $cat) {
				
                $get = ESUtils::CurlGet($cat);
                if ($get["CODE"] == 200) {
					
                    $childs = str_replace(array("\n", "\r", "\t"), "", $get["DATA"]);
                    $childs = preg_replace('/<!---.*?--->/ui', "", $childs);

                    preg_match_all("/<div class=\"col-lg-3 col-md-3 col-sm-3 col-ms-3 col-xs-6\">(.*?)<\/div>/im", $childs, $arrChilds);
                    $find = false;
                    foreach ($arrChilds[1] as $child) {
                        preg_match_all("/<a href=\"(.*?)\"/im", $child, $arrChild);
                        $child = trim($arrChild[1][0]);
                        if (!empty($child)) {
                            $child = 'https://anzhee-light.ru' . $child;
                            $find = true;
                        }

                        $getChild = ESUtils::CurlGet($child);
                        if ($getChild["CODE"] == 200) {
                            $pageChild = str_replace(array("\n", "\r", "\t"), "", $getChild["DATA"]);
                            $pageChild = preg_replace('/<!---.*?--->/ui', "", $pageChild);

                            preg_match_all("/<div class=\"col-lg-3 col-md-3 col-sm-3 col-ms-3 col-xs-6\">(.*?)<\/div>/im", $pageChild, $arrChilds2);
                            $find2 = false;
                            foreach ($arrChilds2[1] as $child2) {
                                preg_match_all("/<a href=\"(.*?)\"/im", $child2, $arrChild2);
                                $child2 = trim($arrChild2[1][0]);
                                if (!empty($child2)) {
                                    $child2 = 'https://anzhee-light.ru' . $child2;
                                    $arProducts[] = $child2;
                                    $find2 = true;
                                }
                            }
                            if (!$find2) {
                                $arProducts[] = $child;
                            }
                        }
                    }
                    if (!$find) {
                        $arProducts[] = $cat;
                    }
                }
            }

            $arTovar = array();
            $arProducts = array_unique($arProducts);

            foreach ($arProducts as $products) {
                $getProduct = ESUtils::CurlGet($products);
				
                if ($getProduct["CODE"] == 200) {
					
                    $product = str_replace(array("\n", "\r", "\t"), "", $getProduct["DATA"]);
                    $product = preg_replace('/<!---.*?--->/ui', "", $product);

                    preg_match_all("/<a class=\"img-block img\" href=\"\/product\/(.*?)\">/im", $product, $arrProduct);

                    foreach ($arrProduct[1] as $tovar) {
                        if (!empty($tovar)) {
                            $arTovar[] = $server . 'product/' . $tovar;
                        }
                    }
					
                }
            }
            $arTovar = array_unique($arTovar);

            //$arTovar[] = 'https://anzhee-light.ru/product/anzhee-pro-led-panel-100/';
            foreach ($arTovar as $link) {

                $getTovar = ESUtils::CurlGet($link);
                if ($getTovar["CODE"] == 200) {

                    $link_http = trim(str_replace('https://', '', $link), '/');

                    $tovarPage = str_replace(array("\n", "\r", "\t"), "", $getTovar["DATA"]);
                    $tovarPage = preg_replace('/<!---.*?--->/ui', "", $tovarPage);

                    preg_match_all("/<h1>(.*?)<\/h1>/im", $tovarPage, $arrPage);

                    $name = trim(strip_tags($arrPage[1][0]));

                    preg_match_all("/<a href=\"\/images\/products\/(.*?)\" class/im", $tovarPage, $arrPage2);

                    $image = trim($arrPage2[1][0]);
                    if (!empty($image)) {
                        $image = $server . 'images/products/' . $image;
                    }

                    preg_match_all("/<span class=\"price-is\">(.*?)<\/span>/im", $tovarPage, $arrPage3);
                    $price = trim($arrPage3[1][0]);
                    $price = intval(preg_replace('/[^0-9,.]/', '', $price));

                    preg_match_all("/<div class=\"h4-text\">(.*?)<\/div>/im", $tovarPage, $arrPage4);
                    $text = trim($arrPage4[1][0]);

                    preg_match_all("/product-price-block clearfix(.*?)<div class=\"clear\"><\/div>/im", $tovarPage, $arrPage5);
                    $arrEx = explode('</form>', $arrPage5[1][0]);
                    $preview = trim(strip_tags($arrEx[1]));

                    //поиск а базе
                    $obElement = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 32, 'PROPERTY_UPLOADED_FROM_PAGE' => '%'.$link_http.'%'), false, false, array('ID', 'NAME', 'ACTIVE', 'IBLOCK_ID', 'IBLOCK_SECTION_ID', 'DETAIL_PICTURE', 'PROPERTY_UPLOADED_FROM_PAGE'));
                    $num = $obElement->SelectedRowsCount();
                    if ($num == 0 && !empty($name)) {
                        //Добавляем
                        $el = new CIBlockElement;

                        $PROPS = array(
                            "UPLOADED_FROM_PAGE" => $link,
                        );

                        $CODE = CUtil::translit(ESUtils::Transliterator($name), "ru", array("replace_space" => "-", "replace_other" => "-"));

                        $arFields = array(
                            "MODIFIED_BY" => 1, // элемент изменен текущим пользователем
                            "IBLOCK_SECTION_ID" => 3529,          // элемент лежит в корне раздела
                            "IBLOCK_ID" => 32,
                            "PROPERTY_VALUES" => $PROPS,
                            "NAME" => $name,
                            "CODE" => $CODE,
                            "ACTIVE" => "N",
                            "PREVIEW_TEXT" => $preview,
                            "DETAIL_TEXT" => $text
                        );

                        if (!empty($image)) {
                            $arFields['PREVIEW_PICTURE'] = $arFields['DETAIL_PICTURE'] = CFile::MakeFileArray($image);
                        }

                        if ($PRODUCT_ID = $el->Add($arFields)) {
                            echo "New ID: " . $PRODUCT_ID . "<br>";
                        }

                        CPrice::SetBasePrice($PRODUCT_ID, $price, 'RUB');
                    } else {
                        $arItem = $obElement->Fetch();
                        $PRODUCT_ID = $arItem['ID'];
                        $IBLOCK_SECTION_ID = $arItem['IBLOCK_SECTION_ID'];

                        if ($IBLOCK_SECTION_ID == 3529) {
                            CPrice::SetBasePrice($PRODUCT_ID, $price, 'RUB');
                        }

                        echo "UPDATE: " . $PRODUCT_ID . "<br>";
                    }
                }
            }
        }
    }	
	
	
	public static function AnzheeUpdatePrice(&$arStatus)  {

        $preEl = new CIBlockElement;
        $arStatus["LOG_ANZHEE"] = [];
		$arProdIds = [];

        $arPriceList = ESParser::AnzheePriceList(); 

        if (count($arPriceList) > 0) { 
			
            $arElements = array();
			$obElement = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 32, 'PROPERTY_UPLOADED_FROM_PAGE' => '%//anzhee%'), false, false, array('ID', 'NAME', 'ACTIVE', "IBLOCK_SECTION_ID", 'XML_ID', 'IBLOCK_ID', 'PROPERTY_UPLOADED_FROM_PAGE', 'CATALOG_GROUP_1', 'PROPERTY_CML2_ARTICLE', 'PROPERTY_GUID', 'PROPERTY_PRICE_FROZEN'));
			while ($arItem = $obElement->Fetch()) {
				$url = ToLower($arItem['PROPERTY_UPLOADED_FROM_PAGE_VALUE']);
				$url = str_ireplace("http://", "https://", $url);
				if ($url != "" && (stripos($url, 'https://anzhee-light.ru/') !== false || stripos($url, 'https://anzhee.ru/') !== false)) {
					$arElements[$url] = $arItem;
					$arProdIds[] = $arItem['ID'];
				}
			}		
			
            if (count($arElements) > 0) { 
				
                $ind = 0;
                $cnt = count($arElements);
				
                foreach ($arElements as $url => $arItem) {
					
                    $ind++;
					
					$isPriceFrozen = $arItem['PROPERTY_PRICE_FROZEN_VALUE'] !== null;

                    // TODO: remove
                    if ((string)$arItem['ID'] !== '40843') {
                        // continue;
                    }
										
					$guid = $arItem['PROPERTY_GUID_VALUE'];
					if (!empty($arPriceList[$guid])) { 
						
						$price = (float)$arPriceList[$guid]['P'];
						$quantity = (int)$arPriceList[$guid]['Q'];	
						//$pactive = !empty($arPriceList[$guid]['A']) ? $arPriceList[$guid]['A'][0] : false;
						$pactive = $arPriceList[$guid]['A'];
						
						CCatalogStoreProduct::UpdateFromForm([
							'PRODUCT_ID' => $arItem['ID'],
							'STORE_ID' => 5,
							'AMOUNT' => $quantity,
						]);

						if (!$isPriceFrozen) {
							CPrice::SetBasePrice($arItem['ID'], $price, 'RUB');		
						}					
					
						if ($pactive !== false) {
							$preEl->Update($arItem['ID'], ['ACTIVE' => $pactive]);	
						}	

						$stLog = "Q:" . $quantity . ", P:" . $price;
						$stPrice = "Прайс";					
						
						$arLog = array();
						$arLog["DATE"] = time();
						$arLog["LINK"] = '<a href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=32&type=catalog_new&ID=' . $arItem["ID"] . '&lang=ru&find_section_section=' . intval($arItem["IBLOCK_SECTION_ID"]) . '&WF=Y">' . $arItem["NAME"] . '</a>';
						$arLog["URL"] = $url;
						$arLog["STATUS"] = $stLog;
						$arLog["PRICE_LIST"] = $stPrice;
						$arStatus["LOG_ANZHEE"][] = $arLog;

						ESUtils::SaveOption("status-run", array(
							"ID" => "anzhee.ru",
							"URL" => $url,
							"CNT" => $ind . " / " . $cnt,
						));						
						
					} 				
					
                }
            }
			
			/*update price & quantity for modification from price*/
			$arElementsModif = [];			
			if (!empty($arProdIds)) {
				
				$obElementModif = CIBlockElement::GetList(
                    array(),
                    array('IBLOCK_ID' => 33, 'PROPERTY_CML2_LINK' => $arProdIds),
                    false,
                    false,
                    array('ID', 'NAME', 'ACTIVE', "IBLOCK_SECTION_ID", 'XML_ID', 'IBLOCK_ID', 'PROPERTY_ES_NAME_SEARCH', 'PROPERTY_GUID', 'PROPERTY_CML2_LINK')
                );
				while ($arItemModif = $obElementModif->Fetch()) {
					$arElementsModif[] =  $arItemModif;		
				}
			}
			
			if (!empty($arElementsModif)) {

                $arParentActivities = [];

				foreach ($arElementsModif as $arItemModif) {
					
					$guid = $arItemModif['PROPERTY_GUID_VALUE'];
					if (!empty($arPriceList[$guid])) {
					
						$priceModif = (float)$arPriceList[$guid]['P'];
						$quantityModif = (int)$arPriceList[$guid]['Q'];	
						//$pactiveModif = !empty($arPriceList[$guid]['A']) ? $arPriceList[$guid]['A'][0] : false;	
						$pactiveModif = $arPriceList[$guid]['A'];

						CCatalogStoreProduct::UpdateFromForm([
							'PRODUCT_ID' => $arItemModif['ID'],
							'STORE_ID' => 5,
							'AMOUNT' => $quantityModif,
						]);

						if (!$isPriceFrozen) {
							CPrice::SetBasePrice($arItemModif['ID'], $priceModif, 'RUB');		
						}
						
						if ($pactiveModif !== false) {

                            if (!isset($arParentActivities[$arItemModif['PROPERTY_CML2_LINK_VALUE']]["ACTIVITY"]) || ($pactiveModif == "N")) {
                                $arParentActivities[$arItemModif['PROPERTY_CML2_LINK_VALUE']]["ACTIVITY"] = $pactiveModif;
                            }
                            $arParentActivities[$arItemModif['PROPERTY_CML2_LINK_VALUE']][] = $pactiveModif;

							$preEl->Update($arItemModif['ID'], ['ACTIVE' => $pactiveModif]);	
						}
					}
				}

                // поставим активность родительскому товару в зависимости от активности предложений
                foreach ($arParentActivities as $parentID => $arParentActivity) {
                    $preEl->Update($parentID, ['ACTIVE' => $arParentActivity["ACTIVITY"]]);
                }
			}		
        }

        ESUtils::SaveOption("status-run", array(
            "ID" => "anzhee.ru",
            "URL" => '',
            "CNT" => '...',
        ));
        
    }

    public static function Anzhee(&$arStatus) {		
		sendAlarmTG('🏁 /bitrix/modules/energosoft.utils/classes/general/es-parser.php. Запускается функция Anzhee Update');

        $sec = new CIBlockSection;
        $preEl = new CIBlockElement;
        $ibp = new CIBlockProperty;
        $arStatus["LOG_ANZHEE"] = [];
		$arProdIds = [];

        $arPropOffers = ESIBlock::GetPropertyEnum(33, false, false, false, 'PROPERTY_CODE', 'XML_ID', false);
			
		$arElements = array();
		$obElement = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 32, 'PROPERTY_UPLOADED_FROM_PAGE' => '%//anzhee%'), false, false, array('ID', 'NAME', 'ACTIVE', "IBLOCK_SECTION_ID", 'XML_ID', 'IBLOCK_ID', 'PROPERTY_UPLOADED_FROM_PAGE', 'CATALOG_GROUP_1', 'PROPERTY_CML2_ARTICLE', 'PROPERTY_GUID', 'PROPERTY_PRICE_FROZEN'));
		while ($arItem = $obElement->Fetch()) {
			$url = ToLower($arItem['PROPERTY_UPLOADED_FROM_PAGE_VALUE']);
			$url = str_ireplace("http://", "https://", $url);
			if ($url != "" && (stripos($url, 'https://anzhee-light.ru/') !== false || stripos($url, 'https://anzhee.ru/') !== false)) {
				$arElements[$url] = $arItem;
				$arProdIds[] = $arItem['ID'];
			}
		}		

		/*"Не могу определить ответ сервера" from anzhee.ru*/
		$sitemap = new Sitemap('https://anzhee.ru', 'https');
		$xml = (array)simplexml_load_string($sitemap->print(true));
		unset($sitemap);
		
		$arSiteMap = [];	
		if (!empty($xml)) {
			foreach ($xml["url"] as $obLink) {
				$arLink = (array)$obLink;
				if (stripos($arLink["loc"], '/product/') === false) continue;
				$arLink["loc"] = str_ireplace("http://", "https://", $arLink["loc"]);
				$arLink["loc"] = ToLower($arLink["loc"]);
				$arSiteMap[$arLink["loc"]] = false;
			}
		}
		
		echo 'start ';
		if (count($arSiteMap) > 0 || count($arElements) > 0) { 
			
			$ind = 0;
			$cnt = count($arSiteMap) + count($arElements);
			
			$errorStatusElements = [];
			
			foreach ($arElements as $url => $arItem) {
				
				$ind++;
				unset($arSiteMap[$url]);

				// TODO: remove
				if ((string)$arItem['ID'] !== '40843') {
					// continue;
				}

				$NAME = $arItem["NAME"];			

				$url = str_replace('anzhee-light.ru', 'anzhee.ru', $url); // fix redirect
				$arCurl = ESUtils::CurlGet($url);
				$arModifications = [];

				if ($arCurl['CODE'] == 200) {
					
					$propertyCodes = [];

					$strPage = str_replace(array("\n", "\r"), "", $arCurl["DATA"]);

					//self::AnzheeUpdatePhoto($arItem['ID'], $url, $strPage);

					preg_match_all("/<option price=\"(.*?)\" name_v=\".*?\" old_price=\".*?\" articul=\"(.*?)\" sale=\".*?\" stock=\"(.*?)\" value=\".*?\">(.*?)<\/option>/i", $strPage, $arModificationMatches);

					if ($arModificationMatches[1]) {
						
						$modificationPhotos = self::AnzheeGetPhoto($url, $strPage);
						$modificationPreviewPicture = array_shift($modificationPhotos); // $modificationPhotos[0];

						foreach ($arModificationMatches[1] as $i => $v) {
							
							$sku = $arModificationMatches[2][$i];
							$name = $arModificationMatches[4][$i];

							$name = trim(htmlspecialchars_decode($name));

							if (empty($name)) {
								continue;
							}

							$xmlId = trim(ToLower(CUtil::translit(ESUtils::Transliterator($name), 'ru', [
								'replace_space' => '-',
								'replace_other' => '-',
							])), '-');

							if (!$xmlId) {
								continue;
							}

							if (!isset($arPropOffers['MODIFICATION'][$xmlId])) {
								$arEnum = [
									'PROPERTY_ID' => ID_MODIFICATION_PROPERTY,
									'XML_ID' => $xmlId,
									'VALUE' => $name,
								];

								$arEnum['ID'] = CIBlockPropertyEnum::Add($arEnum);

								$arPropOffers['MODIFICATION'][$xmlId] = $arEnum;
							}

							$modificationName = $arItem['NAME'] . ' (' . $name . ')';

							$arModifications[$xmlId] = [
								'NAME' => $modificationName,
								'OFFER_NAME' => $name,
								'PRICE' => 0,
								'ARTNUMBER' => $sku,
								'QUANTITY' => 0,
								'MODIFICATION' => $arPropOffers['MODIFICATION'][$xmlId]['ID'],
								'PREVIEW_PICTURE' => $modificationPreviewPicture,
								'PHOTO' => $modificationPhotos,
							];
							
						}
						
					}

					foreach ($arModifications as $modification) {

						$arCheck = CIBlockElement::GetList([], [
							'PROPERTY_ES_NAME_SEARCH' => $modification['NAME'],
							'IBLOCK_ID' => 33,
						], false, false, [
							'ID',
							'NAME',
							'ACTIVE'
						])->Fetch();

						if ($arCheck['ID'] > 0) {
							$id = $arCheck['ID'];
						} else {
							$id = $preEl->Add([
								'NAME' => $modification['NAME'],
								'IBLOCK_ID' => 33,
								'ACTIVE' => 'Y',
								'PREVIEW_PICTURE' => $modification['PREVIEW_PICTURE'],
								'DETAIL_PICTURE' => $modification['PREVIEW_PICTURE'],
								'PROPERTY_VALUES' => [
									'CML2_LINK' => $arItem['ID'],
									'CML2_ARTICLE' => $modification['ARTNUMBER'],
									'ES_NAME_SEARCH' => $modification['NAME'],
									'PICTURES_SKU' => $modification['PHOTO'],
									'MODIFICATION' => $modification['MODIFICATION'],
								],
							]);
						}

					}

					
				} else { 
										
					if ($arItem['ACTIVE'] == 'Y') {
						$errorStatusElements[] = $arItem['NAME']. ' - '. $arItem['PROPERTY_UPLOADED_FROM_PAGE_VALUE']. ': status '. $arCurl['CODE'];
					}
					
				} 

				if (!empty($errorStatusElements)) {
					
					 ESUtils::SaveOption("errors-page", array(
						"ID" => "Anzhee",
						"PAGE" => $errorStatusElements,
					));
					
				}

				$arLog = array();
				$arLog["DATE"] = time();
				$arLog["LINK"] = '<a href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=32&type=catalog_new&ID=' . $arItem["ID"] . '&lang=ru&find_section_section=' . intval($arItem["IBLOCK_SECTION_ID"]) . '&WF=Y">' . $arItem["NAME"] . '</a>';
				$arLog["URL"] = $url;
				$arLog["HTTP_CODE"] = $arCurl["CODE"];
				$arLog["STATUS"] = 'new items';
				$arLog["PRICE_LIST"] = '';
				$arStatus["LOG_ANZHEE"][] = $arLog;

				ESUtils::SaveOption("status-run", array(
					"ID" => "anzhee.ru",
					"URL" => $url,
					"CNT" => $ind . " / " . $cnt,
				));

			}
		}


        ESUtils::SaveOption("status-run", array(
            "ID" => "anzhee.ru",
            "URL" => '',
            "CNT" => '...',
        ));
        
    }

    public static function AnzheeGetPhoto($url, $strPage = "") {
		
        if ($strPage == "") {
            $arCurl = ESUtils::CurlGet($url);
            if ($arCurl["CODE"] == 200) $strPage = str_replace(array("\n", "\r"), "", $arCurl["DATA"]);
        }

        // Photos
        preg_match_all('#rel="fancybox-thumb.*?"><img src="(.*?)"#ui', $strPage, $photos);

        $arPhotos = [];

        foreach ($photos[1] as $photo) {
            $arPhotos[] = self::MakeFileArray('https://anzhee.ru' . $photo);
        }

        return $arPhotos;
    }

    public static function AnzheeUpdatePhoto($id, $url, $strPage = "") {
		
        $arPhotos = self::AnzheeGetPhoto($url, $strPage);

        if (count($arPhotos) > 0) {
            $preEl = new CIBlockElement;
            $arElement = ESIBlock::GetByID($id);

            if (intval($arPhotos[0]["size"]) > 0 && intval($arElement["PREVIEW_PICTURE"]["ID"]) == 0 && intval($arElement["DETAIL_PICTURE"]["ID"]) == 0) {
                $preEl->Update($id, array("PREVIEW_PICTURE" => $arPhotos[0], "DETAIL_PICTURE" => $arPhotos[0]));
            }

            unset($arPhotos[0]);

            if (count($arPhotos) > 0 && intval($arElement["PROPERTIES"]["MORE_PHOTO"]["FILE_VALUE"]["ID"]) == 0) {
                CIBlockElement::SetPropertyValueCode($id, 32 , "MORE_PHOTO", $arPhotos);
            }
        }
    }

    public static function AnzheePriceListArray($arColumns) {
		

        $arPriceList = array();

        //$f = $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/energosoft.utils/tmp/al_price";
		$csvAnzhee = ESUtils::CurlGet('https://backoffice24.ru:1010/anzhee-stock.csv');
		$f = __DIR__ .'/anzhee-stock.csv'; 
		if (!empty($csvAnzhee)) {
			file_put_contents($f, $csvAnzhee);
		}		

        if (file_exists($f)) { 
            $handle = fopen($f, "r");
            while (($arRow = fgetcsv($handle, 10000, ";")) !== false) {
				
				$GUID = !empty($arRow[$arColumns["GUID_TP"]]) ? $arRow[$arColumns["GUID_TP"]] : $arRow[$arColumns["GUID"]];  

                $PRICE = (float)$arRow[$arColumns["PRICE"]];  

                $QUANTITY = (int)$arRow[$arColumns["QUANTITY"]];

                $ACTIVE_ = trim($arRow[$arColumns["ACTIVE"]]);
				// 16-07-2025 внезапно в прайсе поставщика активность стала на русском... Да/ нет вместо yes/no
				$ACTIVE = (self::iconvp($ACTIVE_,true) == "Да" || $ACTIVE_ == "Да" || $ACTIVE_ == "Yes") ? "Y" : "N";				

                $NAME = trim($arRow[$arColumns["NAME"]]); 
				$NAME_TP = trim($arRow[$arColumns["NAME_TP"]]); 

                if (!empty($NAME) && !empty($PRICE)) {
					
					if (!empty($NAME_TP) && $NAME_TP !== '?') {
						$NAME .= ' ('. $NAME_TP .')';
					}
                    //$NAME = ToLower($NAME);

                    $arPriceList[$GUID] = array("N" => $NAME, "P" => $PRICE, "Q" => $QUANTITY, "G" => $GUID, "A" => $ACTIVE, "AN" => $ACTIVE_.'_'.self::iconvp($ACTIVE_,true));
                }
            } 

            fclose($handle);
        }
        return $arPriceList;
    }

    public static function AnzheePriceList() {
		
        CModule::IncludeModule("currency");
        
        //порядок считываемых столбцов
        $arColumns["NAME"] = 3;
        $arColumns["NAME_TP"] = 4;
        $arColumns["PRICE"] = 12;
        $arColumns["QUANTITY"] = 15;
        $arColumns["GUID"] = 0;
        $arColumns["GUID_TP"] = 1;        
		$arColumns["ACTIVE"] = 11; 

        $arPriceList = self::AnzheePriceListArray($arColumns); 

        return $arPriceList;
    }

    /*public static function AnzheePriceListColumns($usd = false)
    {
        if ($usd) {
            $f = $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/energosoft.utils/tmp/al_price_usd";
        } else {
            $f = $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/energosoft.utils/tmp/al_price";
        }

        return self::priceListColumns($f, $usd ? 2 : 1);
    }*/
	
	/*slami*/

    public static function Slami(&$arStatus = null) {
        sendAlarmTG('🏁 /bitrix/modules/energosoft.utils/classes/general/es-parser.php. Запускается функция Slami Update');

        return Slami::update($arStatus);

    }

    public static function SlamiGetCategories($html, &$categories, &$stop_count) {
		
        $categories_urls = $html->find('a[class="catalog"]');
        if (!empty($categories_urls)) {
            foreach ($categories_urls as $value) {
                $href = $value->href;

                $stop_count++;
                if ($stop_count > 1000) return; //чтоб не зациклилось

                $arCurl = ESUtils::CurlGet($GLOBALS['SLAMI_SERVER'] . $href);
                if ($arCurl['CODE'] == 200) {
                    $html = HtmlDomParser::str_get_html($arCurl['DATA']);
                    if ($html->find('.goods_plitka', 0)) {
                        $categories[] = $href;
                        //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/cron/logs_slami.txt' , date("Y-m-d H:i:s").' category='.$href.PHP_EOL , FILE_APPEND);
                    }
                    else if ($html->find('a[class="catalog"]', 0)) {
                        self::SlamiGetCategories($html, $categories, $stop_count);
                    }
                }
            }
        }
    }

    public static function SlamiAdd() {
		sendAlarmTG('🏁 /bitrix/modules/energosoft.utils/classes/general/es-parser.php. Запускается Slami Add');	
		
        $GLOBALS['SLAMI_SERVER'] = 'https://slami.ru';
        $url_catalog = 'https://slami.ru/netcat/modules/catalog/';
        $url_brands = 'https://slami.ru/netcat/modules/catalog/brands/';

        $categories = [];
        $stop_count = 0;

        $arCurl = ESUtils::CurlGet($url_catalog);
        if ($arCurl['CODE'] == 200) {
			
            $html = HtmlDomParser::str_get_html($arCurl['DATA']);
            self::SlamiGetCategories($html, $categories, $stop_count);
        }

        /* --- Парсим также по страницам брендов, потому что не хватало товаров (похоже не все товары в категориях) --- */
        $arCurl = ESUtils::CurlGet($url_brands);
        if ($arCurl['CODE'] == 200) {
			
            $arCurl['DATA'] = iconv("Windows-1251", "UTF-8", $arCurl['DATA']);
            preg_match_all('#<div class="brands-cloumns-wrapper">(.+?)</div>#is', $arCurl['DATA'], $arr);
            preg_match_all('#<a href="(.+?)">#is', $arr[1][0], $arr2);
            
            $brands_pages = $arr2[1];
            foreach ($brands_pages AS $brand) {
                $arBrand = ESUtils::CurlGet($GLOBALS['SLAMI_SERVER'].$brand);
                if ($arBrand['CODE'] == 200) {
					
                    $html = HtmlDomParser::str_get_html($arBrand['DATA']);
                    if ($html->find('.goods_plitka', 0)) {
                        $categories[] = $brand;
                    }
                    $stop_count = 0;
                    self::SlamiGetCategories($html, $categories, $stop_count);
					
                }
            }
        }
        /* --- // --- */

        $categories = array_unique($categories);  
        if (!empty($categories)) {

            $f = self::SlamiGetPriceListFile();
            $arr_pricelist = self::SlamiPriceList($f);

            $arr_categories = [];
            $arr_goods = [];

            foreach ($categories as $value) {

                $category_url = $GLOBALS['SLAMI_SERVER'] . $value;

                $page_max = 1;
                $arCurl = ESUtils::CurlGet($category_url);
                if ($arCurl["CODE"] == 200) {
                    $arCurl['DATA'] = iconv("Windows-1251", "UTF-8", $arCurl['DATA']);
                    preg_match_all('#<ul class="pages">(.+?)</ul>#is', $arCurl['DATA'], $arr);
                    preg_match_all('#href="\?page=(.+?)">#is', $arr[1][0], $arr2);
                    $page_max = max($arr2[1]);
                }
                else {
                    continue;
                }

                if (empty($page_max)) $page_max = 1;

                //цикл по страницам
                for ($j = 1; $j <= $page_max; $j++) {
                    $category_url_page = $category_url.'?page='.$j;

                    //Ссылки на товары
                    $arCurl = ESUtils::CurlGet($category_url_page);
                    if ($arCurl["CODE"] == 200) {
                        preg_match_all('#<div class="name">(.+?)</div>#is', $arCurl['DATA'], $arr3);
                        foreach ($arr3[1] AS $item) {
                            preg_match_all('#<a href="(.+?)">#is', $item, $arr4);
                            $item_link = strip_tags($arr4[1][0]);
                            if (!empty($item_link)) {
                                $arr_goods[] = $GLOBALS['SLAMI_SERVER'].$item_link;
                            }
                        }
                    }
                }
            }

            //$arr_goods = ['https://slami.ru/netcat/modules/catalog/CNT38763'];

            $arr_goods = array_unique($arr_goods);
            foreach ($arr_goods AS $url) {
				
                $arCurl = ESUtils::CurlGet($url, false, 'itemsPerPage=all');
                if ($arCurl["CODE"] == 200) {
					
                    $arCurl['DATA'] = iconv("Windows-1251", "UTF-8", $arCurl['DATA']);
                    $html = HtmlDomParser::str_get_html($arCurl['DATA']);
                    if ($html) {
                        $arnumber = $html->find('span.code', 0)->innertext;
                        $clean_arnumber = trim($arnumber);
                        $clean_arnumber = ltrim($clean_arnumber,'0'); //чтобы фиксить такие артикулы 09915

                        //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/cron/logs_slami.txt' , date("Y-m-d h:i:sa").' '.$url.PHP_EOL , FILE_APPEND );

                        if (isset($arr_pricelist[$clean_arnumber]) && !empty($arr_pricelist[$clean_arnumber])) {

                            $el = new CIBlockElement;

                            $obElement = CIBlockElement::GetList(array(), array(
                            'IBLOCK_ID' => 32,
                            'PROPERTY_UPLOADED_FROM_PAGE' => $url ,
                            ), false, false,
                            array('ID', 'NAME', 'ACTIVE', 'IBLOCK_ID', 'DETAIL_PICTURE', 'PROPERTY_UPLOADED_FROM_PAGE'));

                            $num = $obElement->SelectedRowsCount();

                            /* --- NAME --- */
                            $name = $html->find('h1', 0)->innertext;
                            $name = str_replace('amp;', '', $name);
                            $h1 = trim($name);
                            $preview_text = $html->find('.preview-text', 0)->innertext;
                            $description = $html->find('.description', 0);
                            foreach ($description->find('h2') as $value3){
                                $description->removeChild($value3);
                            }
                            $description->removeChild($description->find('.alsosimilar', 0));

                            //код + краткое описание = название - попросили
                            $name = trim($name).' '.trim($preview_text);
                            /* --- // --- */

                            //Добавление товара
                            if ($num == 0) {
                                //Добавляем только если еще нет товара с таким названием
                                $obElement2 = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 32, 'NAME' => $h1.'%', '!PROPERTY_UPLOADED_FROM_PAGE' => '%slami.ru%'), false, false, array('ID'));
                                $num2 = $obElement2->SelectedRowsCount();
                                if (empty($num2)) {
                                    $obElement3 = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 32, 'NAME' => $name), false, false, array('ID'));
                                    $num3 = $obElement3->SelectedRowsCount();
                                    if (empty($num3)) {

                                        $description = $html->find('.description', 0);
                                        foreach ($description->find('h2') as $value3){
                                            $description->removeChild($value3);
                                        }
                                        $preview_text = $html->find('.preview-text', 0)->innertext;
                                        $price = $arr_pricelist[$clean_arnumber]['PRICE'];
                                        $image = $html->find('.photo img', 0)->src;

                                        $CML2_ARTICLE = 'S-'.$clean_arnumber; //попросили во всех случаях S-
                                        $PROPS = array(
                                            "UPLOADED_FROM_PAGE" => $url,
                                            'CML2_ARTICLE' => $CML2_ARTICLE,
                                            'ES_NAME_SEARCH' => $name
                                        );

                                        $CODE = CUtil::translit(ESUtils::Transliterator($name), "ru", array("replace_space" => "-", "replace_other" => "-"));

                                        $arFields = array(
                                            "MODIFIED_BY" => 1, // элемент изменен текущим пользователем
                                            "IBLOCK_SECTION_ID" => 3577,          // элемент лежит в корне раздела
                                            "IBLOCK_ID" => 32,
                                            "PROPERTY_VALUES" => $PROPS,
                                            "NAME" => $name,
                                            "CODE" => $CODE,
                                            "ACTIVE" => "N",
                                            "PREVIEW_TEXT" => $preview_text ?? '',
                                            "DETAIL_TEXT" => $description ?? ''
                                        );

                                        if (!empty($image)) {
                                            $image = $GLOBALS['SLAMI_SERVER'] . $image;
                                            $arFields['PREVIEW_PICTURE'] = $arFields['DETAIL_PICTURE'] = CFile::MakeFileArray($image);
                                        }

                                        if ($PRODUCT_ID = $el->Add($arFields)) echo "New ID: " . $PRODUCT_ID . "<br>";

                                        if ($price) CPrice::SetBasePrice($PRODUCT_ID, $price, 'RUB');

                                        //Остаток
                                        $QUANTITY = (int)$arr_pricelist[$clean_arnumber]['QUANTITY'];
                                        CCatalogStoreProduct::UpdateFromForm([ 
                                            'PRODUCT_ID' => $PRODUCT_ID,
                                            'STORE_ID' => 5, //Удаленный склад
                                            'AMOUNT' => $QUANTITY
                                        ]);
                                    }
                                }
                            }
                            else { //Обновление товара
                                $obElement = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 32, 'PROPERTY_UPLOADED_FROM_PAGE' => $url), false, false, array('ID', 'NAME', 'PROPERTY_UPDATE_DETAIL_TEXT_STATUS','PROPERTY_UPDATE_PREVIEW_TEXT_STATUS'));
                                $arItem = $obElement->Fetch();

                                $PRODUCT_ID = $arItem['ID'];

                                $arFields = array(
                                    "NAME" => $name
                                );

                                if (!$arItem['PROPERTY_UPDATE_DETAIL_TEXT_STATUS_VALUE'] && $arItem['PROPERTY_UPDATE_DETAIL_TEXT_STATUS_VALUE'] <> 'да') {
                                    $arFields["DETAIL_TEXT"] = $description ?? '';
                                }

                                if ($el->Update($PRODUCT_ID, $arFields)) echo "UPDATE: " . $PRODUCT_ID . "<br>";

                                //Остаток
                                $QUANTITY = (int)$arr_pricelist[$clean_arnumber]['QUANTITY'];
                                CCatalogStoreProduct::UpdateFromForm([ 
                                    'PRODUCT_ID' => $PRODUCT_ID,
                                    'STORE_ID' => 5, //Удаленный склад
                                    'AMOUNT' => $QUANTITY
                                ]);
                            }
                        }
                    }
                }
            }

            fclose($f);
        }
    }	

    public static function SlamiGetPriceListFile() {
		
        $filename = $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/energosoft.utils/tmp/sl_price.csv";
        $f = fopen($filename, "w");
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => "https://dealer.slami.ru/api/getcsv/?token=08e0c0203de54515a9e121dc001d90df",
            CURLOPT_FILE => $f
        ]);
        curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($http_code == 200) {
            $file_data = file_get_contents($filename);
            $utf8_file_data = iconv("Windows-1251", "UTF-8", $file_data);
            $utf8_filename = $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/energosoft.utils/tmp/sl_price_utf8.csv";
            file_put_contents($utf8_filename, $utf8_file_data);
            fclose($f);

            $f = fopen($utf8_filename, "r");
            return $f;
        } else {
            fclose($f);
            return false;
        }
    }

    //файл который дали сами ustage чтобы обновлялись только эти товары
    public static function SlamiPriceUstage() {
		
        $filename = $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/energosoft.utils/tmp/sl_price_ustage.csv";
        $file_data = file_get_contents($filename);
        $utf8_file_data = iconv("Windows-1251", "UTF-8", $file_data);
        $utf8_filename = $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/energosoft.utils/tmp/sl_price_ustage_utf8.csv";
        file_put_contents($utf8_filename, $utf8_file_data);
        fclose($f);
        $f = fopen($utf8_filename, "r");

        $arr_pricelist = [];
        $i = 0;
        while (($arRow = fgetcsv($f, 10000, ";")) !== false) {
            if (++$i == 1) continue;

            $arnumber = trim($arRow[12]);

            $arr_pricelist[$arnumber]['PRICE'] = $arRow[8];
            $arr_pricelist[$arnumber]['NAME'] = $arRow[7];
        }

        return $arr_pricelist;
    }

    public static function SlamiPriceList($f) {
		
        $arr_pricelist_ustage = self::SlamiPriceUstage(); //файл который дали ustage статичный

        $arr_pricelist = [];
        $i = 0;
        while (($arRow = fgetcsv($f, 10000, ";")) !== false) {
            if (++$i == 1) continue;

            $arnumber = trim($arRow[12]);

            //теперь добавляются и обновляются только товары из файла который дали они, но разница в ценах и процент из актуального файла
            if (!isset($arr_pricelist_ustage[$arnumber]) || empty($arr_pricelist_ustage[$arnumber])) {
                continue;
            }

            $PERCENT = (float)1 - ($arRow[10] / $arRow[8]);
            $PERCENT = round($PERCENT, 2);

            if ($PERCENT >= 0.2) {
                $arr_pricelist[$arnumber]['PRICE'] = $arRow[8];
                $arr_pricelist[$arnumber]['NAME'] = $arRow[7];
                $arr_pricelist[$arnumber]['PERCENT'] = $PERCENT;
                $arr_pricelist[$arnumber]['QUANTITY'] = $arRow[11];
            }
        }

        return $arr_pricelist;
    }

    public static function SlamiPriceListArray($arColumns) {
		
        $arPriceList = array();

        $f = $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/energosoft.utils/tmp/sl_price.csv";

        if (file_exists($f)) {
            $handle = fopen($f, "r");
            $i = 1;
            while (($arRow = fgetcsv($handle, 10000, ";")) !== false) {

                $PRICE = $arRow[$arColumns["PRICE"]];
                $NAME = $arRow[$arColumns["NAME"]];

                if (!empty($NAME) && !empty($PRICE)) {
                    $arPriceList[$NAME] = array("P" => $PRICE);
                }

                $i++;
            }

            fclose($handle);
        }
        return $arPriceList;
    }

    public static function SlamiPriceListColumns() {
		
        $f = fopen($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/energosoft.utils/tmp/sl_price.csv", "w");

        return self::priceListColumns($f, 6);
    }	

    //OknaAudio	

    public static function OknoAudioDownloadPriceList() {
		
        sendAlarmTG('🏁 /bitrix/modules/energosoft.utils/classes/general/es-parser.php. Запускается функция OknoAudioDownloadPriceList');

        $tmpPath = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/energosoft.utils/tmp';

        $zipPath = $tmpPath . '/price.zip';
        $unzippedXlsPath = $tmpPath . '/Price.xls';
        $xlsPath = $tmpPath . '/price.xls';

        $zip = file_get_contents('https://price.okno-audio.ru/Price.zip', false, stream_context_create([
            'http' => [
                'ignore_errors' => true,
            ],
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ]));

        if (!$zip) {
            return false;
        }

        file_put_contents($zipPath, $zip);

        if (!file_exists($zipPath)) {
            return false;
        }

        $zippy = Zippy::load();

        $zip = $zippy->open($zipPath);
        $zip->extract($tmpPath);

        if (!file_exists($unzippedXlsPath)) {
            return false;
        }

        rename($unzippedXlsPath, $xlsPath);

        sendAlarmTG('/bitrix/modules/energosoft.utils/classes/general/es-parser.php. Завершается функция OknoAudioDownloadPriceList 🔚');

        return true;
    }	
	
    public static function OknaAudio(&$arStatus) {
		sendAlarmTG('🏁 /bitrix/modules/energosoft.utils/classes/general/es-parser.php. Запускается OknaAudio Update');
		
        $el = new CIBlockElement;
        $arStatus["LOG_OKNAAUDIO"] = array();

        $priceCompareArticlesList = [
            'F4851', 'F1921', 'F5021', 'F5022', 'F4718', 'F4847', 'F4701',
            'F5259', 'F4855', 'F4939', 'F4886', 'F4858', 'F1923', 'G1593',
            'F5075', 'F1918', 'F7420', 'F1764', 'F1917', 'F1934', 'F1933',
            'F5061', 'F5055', 'F1924', 'F5062', 'F1931', 'F5069', 'F1920',
            'F1916', 'F1929', 'F1930', 'F5112', 'F1023', 'F1025', 'F1914',
            'F5068', 'F5076', 'F1554', 'F5042', 'F1031',
        ];

        \Bitrix\Main\Loader::IncludeModule("highloadblock");
        $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getById(2)->fetch();
        $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
        $stEntityDataClass = $entity->getDataClass();
        $rsEntityDataClass = $stEntityDataClass::getList(array(
            'select' => array('*'),
            'order' => array('ID' => 'ASC'),
            'filter' => array(),
        ));
        $arProducer = array();
        while ($arEntityDataClass = $rsEntityDataClass->fetch()) $arProducer[] = $arEntityDataClass;

        $ind = 0;
        $obElement = CIBlockElement::GetList(array(), array(
            // array(
            //     "LOGIC" => "OR",
            //     array("ID" => 19354),
            //     array("ID" => 18045)
            // ),
            //'ID' => 16493,
            'IBLOCK_ID' => 32, 
            'PROPERTY_UPLOADED_FROM_PAGE' => '%okno-audio.ru%', 
            '!SECTION_ID' => 3528
            ), 
            false, 
            false, 
            array('ID', 'NAME', 'ACTIVE', 'XML_ID', 'IBLOCK_SECTION_ID', 'IBLOCK_ID', 'DETAIL_PICTURE', 'PROPERTY_UPLOADED_FROM_PAGE', 'CATALOG_GROUP_1', 'PROPERTY_CML2_ARTICLE', 'DETAIL_TEXT', 'PROPERTY_UPDATE_DETAIL_TEXT_STATUS', 'PROPERTY_UPDATE_PREVIEW_TEXT_STATUS', 'PROPERTY_PRIORITY_PARSER', 'PROPERTY_EMPTY_PRIORITY_PARSER', 'PROPERTY_PRICE_FROZEN')
        );
        while ($arItem = $obElement->Fetch()) {
			
			$errorStatusElements = [];
            
			$isPriceFrozen = $arItem['PROPERTY_PRICE_FROZEN_VALUE'] !== null;

            $ind++;
            $url = $arItem['PROPERTY_UPLOADED_FROM_PAGE_VALUE'];

            $stLog = "Q:0, P:0";
            $stLogOffers = array();
            $arCurl = ESUtils::CurlGet($url);
            
            if ($arCurl["CODE"] == 200) {

                $searchPage = str_replace(array("\n", "\r", "\t"), "", $arCurl["DATA"]);

                //article
                $arArticle = array();
                preg_match_all("/<div class=\"art\">Артикул: ([^<]+)<\/div>/imu", $searchPage, $arArticle);

                $article = $arArticle[1][0];
                //обновление артикула если пустой
                if (!empty($article) && empty($arItem['PROPERTY_CML2_ARTICLE_VALUE'])) {
                    CIBlockElement::SetPropertyValueCode($arItem["ID"], "CML2_ARTICLE", $article);
                }

                //name
                $arName = array();
                preg_match_all("/<h1>(.*?)<\/h1>/im", $searchPage, $arName);

                $name = trim(strip_tags($arName[1][0]));

                //short
                $arShort = array();
                preg_match_all("/<div class=\"block__slogan detail-new__el_name\">(.*?)<\/div>/im", $searchPage, $arShort);

                $short = trim(strip_tags($arShort[1][0]));

                $names = $short;
                $names = str_replace($name, '', $names);

                //text
                $arText = array();
                preg_match_all("/<article>(.*?)<\/article>/im", $searchPage, $arText);
                $text = $arText[1][0];

                if (!empty($name)) {
                    $name = html_entity_decode($name);
                    $name = html_entity_decode($name);

                    $nameLength = mb_strlen($name);

                    if ($nameLength > 256) {
                        $names = mb_substr($name, 0, 256);
                    } else {
                        $short = html_entity_decode($short);
                        $shortLength = mb_strlen($short);

                        $namesLength = $nameLength + $shortLength;

                        if ($namesLength > 256) {
                            $names = $name;
                        } else {
                            $names = $name . ' ' . $short;
                        }
                    }
                }

                $arInStock = explode('<div class="in-stock-status">', $searchPage);
                $arInStock = explode('</i><span>', $arInStock[1]);
                $inStock = mb_strpos($arInStock[0], 'status-yes') !== false;
                
                $prev_arr = [];

                if (
                    (
                        (!$arItem['PROPERTY_PRIORITY_PARSER_ENUM_ID'] || $arItem['PROPERTY_PRIORITY_PARSER_ENUM_ID'] == 1728)
                        && (!$arItem['PROPERTY_EMPTY_PRIORITY_PARSER_ENUM_ID'] || $arItem['PROPERTY_EMPTY_PRIORITY_PARSER_ENUM_ID'] == 1730) //1730 - в наличии
                    )
                    || $arItem['PROPERTY_EMPTY_PRIORITY_PARSER_ENUM_ID'] == 1729
 //                   || !$arItem['PROPERTY_EMPTY_PRIORITY_PARSER_ENUM_ID']
                ){ //1728 - okna

                    if ($inStock) { // товар в наличии
                        CIBlockElement::SetPropertyValueCode($arItem["ID"], "PRIORITY_PARSER", 1728);
                        CIBlockElement::SetPropertyValueCode($arItem["ID"], "EMPTY_PRIORITY_PARSER", 1730);
                    }
                    else { //отсутствие товара

                        $arProdFields = array(
                            "PRODUCT_ID" => $arItem['ID'],
                            "STORE_ID" => 5,
                            "AMOUNT" => 0,
                        );
                        CCatalogStoreProduct::UpdateFromForm($arProdFields);
                        CIBlockElement::SetPropertyValueCode($arItem["ID"], "EMPTY_PRIORITY_PARSER", 1729);
                        
                        // CIBlockElement::SetPropertyValueCode($arItem["ID"], "PRIORITY_PARSER", 1727);
                        continue;
                    }
                }
                else {
                    continue;
                }          
				
				//обновление артикула если есть в наличии в окнах
                if (!empty($article)) {
                    CIBlockElement::SetPropertyValueCode($arItem["ID"], "CML2_ARTICLE", $article);
                }

                /* // vremenno ubrali vse obnovleniya krome cen i kol-va
                if (!empty($names) && $arItem['NAME'] <> $names) {
                    $element = new CIBlockElement;
                    $prev_arr[] = ["NAME" => $names];
                    if (!$arItem['PROPERTY_UPDATE_PREVIEW_TEXT_STATUS_VALUE'])
                        $prev_arr['PREVIEW_TEXT'] = html_entity_decode($names);
                    $element->Update($arItem['ID'], $prev_arr);
                }

                if (empty(strip_tags($arItem['DETAIL_TEXT']))) {
                    if ($text) {
                        $text = html_entity_decode($text);

                        $text = preg_replace('/<a\s.*?>(.*?)<\/a>/s', '$1', $text);
                        $text = preg_replace('/\s*©\s*ОКНО-АУДИО/siu', '', $text);

                        $element = new CIBlockElement;
                        if (!$arItem['PROPERTY_UPDATE_DETAIL_TEXT_STATUS_VALUE'] && $arItem['PROPERTY_UPDATE_DETAIL_TEXT_STATUS_VALUE'] <> 'да') {
                            $element->Update($arItem['ID'], ['DETAIL_TEXT' => $text]);
                        }
                    }
                }
                
                //img
                $arImage = array();
                preg_match_all('/class=\"fancyboxProd\" href=\"(.*?)\" data-fancybox=\"gallery1\"/i', $searchPage, $arImage);
                $urlImg = 'https://okno-audio.ru' . str_replace("\/", "/", $arImage[1][0]);

                // если нет доп.фоток загружает
                $more_photos = CIBlockElement::GetProperty(32, $arItem["ID"], "sort", "asc", array("CODE" => "MORE_PHOTO"));
                $count_photos = $more_photos->SelectedRowsCount();

                if (count($arImage[1]) >= 2 && $count_photos <= 1) {
                    foreach ($arImage[1] as $i => $img) {
                        $arFileImg = self::MakeFileArray('https://okno-audio.ru' . str_replace('\/', '/', $img));
                        CIBlockElement::SetPropertyValueCode($arItem['ID'], 'MORE_PHOTO', ['VALUE' => $arFileImg]);
                    }
                }

                // Brand
                preg_match("/<div class=\"product\_\_logo\"><a href=\"\/brands\/(.*?)\/\" class=\"prog\-ajaxLink\">.*?<\/div>/im", $searchPage, $arImg);
                $arBrand = explode("/", $arImg[1]);
                $brand = end($arBrand);

                foreach ($arProducer as $arItemBrand) {
                    if (ToLower(trim($arItemBrand["UF_XML_ID"])) == ToLower(trim($brand))) {
                        CIBlockElement::SetPropertyValueCode($arItem["ID"], "MANUFACTURER", $arItemBrand["UF_XML_ID"]);
                        break;
                    }
                }  
				*/					

                //if ($arItem['ACTIVE'] === 'Y') {
					
                    $html = HtmlDomParser::str_get_html($searchPage);
                    //$price = $html->find('.box__prices em', 0)->innertext;
					$price = $html->find('.box__prices', 0)->innertext;
                    // $arPrice = explode('<span class="box__prices"><em>', preg_replace('/\s+/', '', $searchPage));                 
                    // $arPrice = explode('<i class="rub-medium">', $arPrice[1]);
                    $price = intval(preg_replace('/[^0-9,.]/', '', $price));
					
					if ($price > 0) {
						$el->Update($arItem['ID'], ['ACTIVE' => 'Y']);		
					}						

                    if ($inStock) {
                        CIBlockElement::SetPropertyValueCode($arItem['ID'], 'ES_EXIST', 642);
                        $AMOUNT_UD = 1;

                        CCatalogStoreProduct::UpdateFromForm([
                            'PRODUCT_ID' => $arItem['ID'],
                            'STORE_ID' => 5, // Удаленный склад
                            'AMOUNT' => $AMOUNT_UD,
                        ]);
                    } else {
                        CIBlockElement::SetPropertyValueCode($arItem['ID'], 'ES_EXIST', false);
                        $AMOUNT_UD = 0;

                        //Наличие Okna
                        CIBlockElement::SetPropertyValueCode($arItem['ID'], "EXIST1", 0);

                        CCatalogStoreProduct::UpdateFromForm([
                            'PRODUCT_ID' => $arItem['ID'],
                            'STORE_ID' => 5, // Удаленный склад
                            'AMOUNT' => $AMOUNT_UD,
                        ]);
                    }

					if (!$isPriceFrozen) {
						// Сбросить цены
						//CPrice::SetBasePrice($arItem['ID'], 0, 'RUB');
						CPrice::SetBasePrice($arItem['ID'], $price, 'RUB');
						
						if (in_array($article, $priceCompareArticlesList, true)) {
							self::comparePrices($arItem['ID'], $arItem['NAME'], $arItem['PROPERTY_UPLOADED_FROM_PAGE_VALUE'], $arItem['CATALOG_PRICE_1'], $price, $arItem['PROPERTY_CML2_ARTICLE_VALUE']);
						}
					}

                    // Сбросить остатки
                    /*CCatalogStoreProduct::UpdateFromForm([
                        'PRODUCT_ID' => $arItem['ID'],
                        'STORE_ID' => 5, // Удаленный склад
                        'AMOUNT' => $AMOUNT_UD,
                    ]);*/	
					
                //}

                /*
				$arLoadProductArray = array(
                    "PREVIEW_PICTURE" => $arFile,
                    "DETAIL_PICTURE" => $arFile
                );

                if (intval($arItem["DETAIL_PICTURE"]) == 0) {

                    $arFile = array();
                    if ($arImage[1][0] != "") {
                        $arFile = self::MakeFileArray($urlImg);
                    }

                    if (count($arFile) > 0) {

                        $el->Update($arItem["ID"], $arLoadProductArray);
                    }
                }
                */							
                
            } else { // deactivate non 200
				
                CCatalogStoreProduct::UpdateFromForm([
                    'PRODUCT_ID' => $arItem['ID'],
                    'STORE_ID' => 5, // Удаленный склад
                    'AMOUNT' => 0,
                ]);
                CIBlockElement::SetPropertyValueCode($arItem["ID"], "EMPTY_PRIORITY_PARSER", 1729);
				
				if ($arItem['ACTIVE'] == 'Y') {
					$errorStatusElements[] = $arItem['NAME']. ' - '. $arItem['PROPERTY_UPLOADED_FROM_PAGE_VALUE']. ': status '. $arCurl['CODE'];
				}	
				$el->Update($arItem['ID'], ['ACTIVE' => 'N']);					
				
			}    

			if (!empty($errorStatusElements)) {
				
				ESUtils::SaveOption("errors-page", array(
					"ID" => "Okno-audio",
					"PAGE" => $errorStatusElements,
				));				
				
			}	

            $arLog = array();
            $arLog["DATE"] = time();
            $arLog["LINK"] = '<a href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=32&type=catalog_new&ID=' . $arItem["ID"] . '&lang=ru&find_section_section=' . intval($arItem["IBLOCK_SECTION_ID"]) . '&WF=Y">' . $arItem["NAME"] . '</a>';
            $arLog["URL"] = $url;
            $arLog["HTTP_CODE"] = $arCurl["CODE"];
            $arLog["STATUS"] = $stLog;
            $arStatus["LOG_OKNAAUDIO"][] = $arLog;

            self::updateMinMaxPrices($arItem['ID']);
            self::cleanCachedImages();

            ESUtils::SaveOption("status-run", array(
                "ID" => "okno-audio.ru",
                "URL" => $url,
                "CNT" => $ind . " / " . $obElement->SelectedRowsCount(),
            ));


        }

        //self::sendPrices('okno-audio.ru'); https://okno-audio.ru/brands/harman_professional/soundcraft/tsifrovye_1/optsionalnye_komponenty_vi_si_seriy/reki_keysy_chekhly_podsvetka/Soundcraft_Expression2_ACCKIT/
    }

    public static function OknaAudioAdd() {
		sendAlarmTG('🏁 /bitrix/modules/energosoft.utils/classes/general/es-parser.php. Запускается Rigger Add');
		
        global $DB;

        $server = 'https://okno-audio.ru';
        $server2 = 'https://www.okno-audio.ru';
        $server3 = 'http://okno-audio.ru';
        $server4 = 'http://www.okno-audio.ru';

        \Bitrix\Main\Loader::IncludeModule("highloadblock");
        $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getById(2)->fetch();
        $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
        $stEntityDataClass = $entity->getDataClass();
        $rsEntityDataClass = $stEntityDataClass::getList(array(
            'select' => array('*'),
            'order' => array('ID' => 'ASC'),
            'filter' => array(),
        ));
        $arProducer = array();
        while ($arEntityDataClass = $rsEntityDataClass->fetch()) $arProducer[] = $arEntityDataClass;

        $url = 'https://okno-audio.ru/brands/';
        $brands = '/brands/';

        $arCurl = ESUtils::CurlGet($url);

        if ($arCurl["CODE"] == 200) {
            $brandsPage = str_replace(array("\n", "\r", "\t"), "", $arCurl["DATA"]);

            $arBrands = array();
            $arr = array();
            preg_match_all("/<div class=\"footer__center\"(.*?)<!--footer end-->/im", $brandsPage, $arr);

            $center = $arr[1][0];

            preg_match_all("/<a href=\"\/brands\/(.*?)\">/im", $center, $arr2);

            foreach ($arr2[1] as $elem) {
                $elem = trim($elem);
                if (empty($elem)) continue;
                $arBrands[] = $url . $elem;
            }

            $arBrands = array_unique($arBrands);
            $products = array();
            foreach ($arBrands as $brandUrl) {
                $get = ESUtils::CurlGet($brandUrl);

                if ($get["CODE"] == 200) {
                    //навигацию
                    preg_match_all("/data-page=\"(.*?)\">/im", $get["DATA"], $arr);

                    $nav = $arr[1];

                    $max = (int)max($nav);
                    if (empty($max)) $max = 1;

                    for ($j = 1; $j <= $max; $j++) {
                        $page = ESUtils::CurlGet($brandUrl . '?page=' . $j);

                        if ($page["CODE"] == 200) {
                            preg_match_all("/<a href=\"\/brands\/(.*?)\" data-id=\"prog-ajaxLink productLink/im", $page["DATA"], $productArr);

                            foreach ($productArr[1] as $product) {

                                $link = $server . $brands . $product;

                                $products[] = $link;
                            }
                        }
                    }
                }
            }

            $products = array_unique($products);
            foreach ($products AS $link) {

                $link_http = trim(str_replace('https://', '', $link), '/');

                $tovar = ESUtils::CurlGet($link);
                if ($tovar["CODE"] == 200) {
                    $searchPage = str_replace(array("\n", "\r", "\t"), "", $tovar["DATA"]);

                    preg_match_all("/<div class=\"art\">Артикул: ([^<]+)<\/div>/imu", $searchPage, $arArticle);
                    $article = $arArticle[1][0];

                    $arSelect = ['ID', 'NAME', 'ACTIVE', 'IBLOCK_ID', 'IBLOCK_SECTION_ID', 'DETAIL_PICTURE', 'PROPERTY_UPLOADED_FROM_PAGE', 'PROPERTY_CML2_ARTICLE'];

                    // Есть ли уже в базе
                    $obElement = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 32, 'PROPERTY_UPLOADED_FROM_PAGE' => '%'.$link_http.'%', 'PROPERTY_CML2_ARTICLE' => $article), false, false, $arSelect);
                    $num = $obElement->SelectedRowsCount();
                    //$obElement = CIBlockElement::GetList(['id' => 'asc'], ['IBLOCK_ID' => 32, 'PROPERTY_CML2_ARTICLE' => $article], false, false, $arSelect);

                    $num = $obElement->SelectedRowsCount();

                    if ($num == 0) {
                        $nal_arr = explode('in-stock-status', $searchPage);
                        $nal_arr = explode('наличии</span>', $nal_arr[1]);
                        $nal = trim(strip_tags($nal_arr[0]));
                        if ($nal == '">в') $nalichie = 1;
                        else $nalichie = 0;

                        //name
                        $arName = array();
                        preg_match_all("/<h1>(.*?)<\/h1>/im", $searchPage, $arName);
                        $name = trim(strip_tags($arName[1][0]));

                        //short
                        $arShort = array();
                        preg_match_all("/<div class=\"block__slogan detail-new__el_name\">(.*?)<\/div>/im", $searchPage, $arShort);
                        $short = trim(strip_tags($arShort[1][0]));
                        $names = $short;
                        $names = str_replace($name, '', $names);
                        if (!empty($name)) $names = $name . ' ' . $short;

                        //text
                        $arText = array();
                        preg_match_all("/<article>(.*?)<\/article>/is", $searchPage, $arText);
                        $text = $arText[1][0];
                        $text = html_entity_decode($text);
                        $text = preg_replace('/<a.*?href=".*?okno-audio\.ru.*?".*?>(.*?)<\/a>/s', '$1', $text);

                        //img
                        $arImage = array();
                        preg_match_all('/class=\"fancyboxProd\" href=\"(.*?)\" data-fancybox=\"gallery1\"/i', $searchPage, $arImage);
                        $image = "https://okno-audio.ru" . str_replace("\/", "/", $arImage[1][0]);

                        // Brand
                        preg_match("/<div class=\"product\_\_logo\"><a href=\"\/brands\/(.*?)\/\" class=\"prog\-ajaxLink\">.*?<\/div>/im", $searchPage, $arImg);
                        $arBrand = explode("/", $arImg[1]);
                        $brand = end($arBrand);

                        // Price
                        //$arPrice = explode('<span class="box__prices"><em>', $searchPage);
                        //$arPrice = explode('<i class="rub-medium">', $arPrice[1]);
						$arPrice = explode('<span class="box__prices">', $searchPage);
						$arPrice = explode('<span class="rub">', $arPrice[1]);
                        $price = intval(preg_replace('/[^0-9,.]/', '', $arPrice[0]));

                        /* if ($brand === 'behringer') {
                            $price -= $price * .2;
                            $price -= $price * .05;
                            $price += $price * .1;
                        } */

                        //Добавляем
                        $el = new CIBlockElement;

                        $PROPS = array(
                            "UPLOADED_FROM_PAGE" => $link,
                        );

                        $CODE = CUtil::translit(ESUtils::Transliterator($names), "ru", array("replace_space" => "-", "replace_other" => "-"));

                        $arFields = array(
                            "MODIFIED_BY" => 1, // элемент изменен текущим пользователем
                            "IBLOCK_SECTION_ID" => 3528, // элемент лежит в корне раздела
                            "IBLOCK_ID" => 32,
                            "PROPERTY_VALUES" => $PROPS,
                            "NAME" => $names,
                            "CODE" => $CODE,
                            "ACTIVE" => "N",
                            "DETAIL_TEXT" => $text,
                            "PREVIEW_TEXT" => $names
                        );

                        if ($PRODUCT_ID = $el->Add($arFields)) {
                            //echo "New ID: " . $PRODUCT_ID . "<br>";

                            CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "CML2_ARTICLE", $article);

                            if (!empty($arImage[1][0])) {
                                $image_file = self::MakeFileArray($image);

                                $arFields['PREVIEW_PICTURE'] = $arFields['DETAIL_PICTURE'] = $image_file;
                            }

                            if (count($arImage[1]) >= 2) {
                                foreach ($arImage[1] as $i => $img) {
                                    $arFileImg = self::MakeFileArray('https://okno-audio.ru' . str_replace('\/', '/', $img));
                                    CIBlockElement::SetPropertyValueCode($PRODUCT_ID, 'MORE_PHOTO', ['VALUE' => $arFileImg]);
                                }
                            }

                            //Добавляем цену
                            CPrice::SetBasePrice($PRODUCT_ID, $price, 'RUB');
                        }

                        //Производитель
                        foreach ($arProducer as $arItemBrand) {
                            if (ToLower(trim($arItemBrand["UF_XML_ID"])) == ToLower(trim($brand))) {
                                CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "MANUFACTURER", $arItemBrand["UF_XML_ID"]);
                                break;
                            }
                        }

                        //В наличии
                        if (!empty($nalichie)) {
                            CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "ES_EXIST", 642);
                            $AMOUNT_UD = 5;
                            $AMOUNT = 5;
                            CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "EXIST1", 5);
                        } //Нет в наличии
                        else {
                            CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "ES_EXIST", false);
                            $AMOUNT_UD = 0;
                            $AMOUNT = 0;
                        }

                        //Удаленный
                        $arProdFields = array(
                            "PRODUCT_ID" => $PRODUCT_ID,
                            "STORE_ID" => 5,
                            "AMOUNT" => $AMOUNT_UD,
                        );
                        CCatalogStoreProduct::UpdateFromForm($arProdFields);

                    } elseif ($num > 1) {
                        $i = 0;

                        while ($arItem = $obElement->GetNext()) {
                            $i++;

                            // Удалять только из раздела OA_новое
                            if ((int)$arItem['IBLOCK_SECTION_ID'] !== 3528) {
                                continue;
                            }

                            if ($i === 1) {
                                // Не удалять первый товар
                                continue;
                            }

                            $DB->StartTransaction();

                            if (!CIBlockElement::Delete($arItem['ID'])) {
                                $DB->Rollback();
                            } else {
                                $DB->Commit();
                            }
                        }
                    } else {
                        $arItem = $obElement->Fetch();

                        //ESUtils::d($arItem);

                        CIBlockElement::SetPropertyValueCode($arItem['ID'], 'UPLOADED_FROM_PAGE', $link);

                        //Снимаем активность, если категория тестовая
                        if ($arItem['IBLOCK_SECTION_ID'] == 3528) {
                            //$el = new CIBlockElement;
                            //$el->Update($arItem["ID"], array("ACTIVE" => "N"));
                        }

                        if (empty($arItem["DETAIL_PICTURE"])) {
                            $searchPage = str_replace(array("\n", "\r", "\t"), "", $tovar["DATA"]);

                            //img
                            $arImage = array();
                            preg_match_all('/class=\"fancyboxProd\" href=\"(.*?)\" data-fancybox=\"gallery1\"/i', $searchPage, $arImage);
                            $image = trim("https://okno-audio.ru" . str_replace("\/", "/", $arImage[1][0]));

                            if (!empty($arImage[1][0])) {
                                $arFields = array();

                                $image_file = self::MakeFileArray($image);
                                $arFields['PREVIEW_PICTURE'] = $arFields['DETAIL_PICTURE'] = $image_file;

                                if (!empty($arFields['PREVIEW_PICTURE'])) {
                                    $el = new CIBlockElement;
                                    $el->Update($arItem["ID"], $arFields);
                                    //echo "UPDATE: " . $arItem['ID'] . "<br>";
                                }
                            }
                        }
                    }
                }
            }

            //self::cleanCachedImages();
        }
    }
	
	/*invask*/

    public static function InvaskGetProductsList() {
		
        $ch = curl_init();
        $array = [];
        $array['goods'] = [];
        $i = 0;

        while (true) {
            curl_setopt_array($ch, [
                CURLOPT_URL => 'https://invask.ru/api/client/v1/products?offset='.$i,
                CURLOPT_ENCODING => "",
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => array(
                    "authorization: Bearer PJqhIazH50G90P3djFYawuMWjXvk60FOSrFUAFWrBHwFxH65dRH2qjhYZf9WVe3m9nrcF0gueZfEex5Z",
                    "content-type: application/json"
                ),
            ]);

            $response = curl_exec($ch);
            $response = json_decode($response, true);

            if (!$response) break;

            $array['total'] = $response['total'];
            $array['goods'] = array_merge($array['goods'], $response['products']);

            $i += 3000;
        }

        curl_close($ch);


        return $array;
    }

    public static function Invask(&$arStatus) {
		sendAlarmTG('🏁 /bitrix/modules/energosoft.utils/classes/general/es-parser.php. Запускается Invask Update');
		
        $arStatus['LOG_INVASK'] = [];
        $ind = 1;
        $array = self::InvaskGetProductsList();

        //ESUtils::d($array); exit;

        if (!$array) return;

        $categories = self::InvaskCategory();

        $el = new CIBlockElement;

        foreach ($array['goods'] as $product){

            //if ($product['id'] <> 452920) continue;

            if (!in_array($product['category_id'], $categories)) continue;
            $good = null;

            //if (stripos($product['name'], 'Cordial CVI 5') === false) continue;

            $good = [
                'NAME' => $product['name'],
                'PRICE' => $product['regular_price'],
                'QUANTITY' => $product['quantityLabel'],
                'PROPERTY_VALUES' => [
                    'CML2_ARTICLE' => $product['cat_number'],
                    'EXIST2' => $product['quantityLabel'],
                    'UPLOADED_FROM_PAGE' => 'https://invask.ru/product/' . $product['cat_number'],
                    'BRAND' => $product['brand_name'],
                    'MODEL' => $product['model'],
                ]
            ];

            if ($image_url = $product['originalImageUrl'])
                $goods[$product['cat_number']]['PREVIEW_PICTURE'] = $goods[$product['cat_number']]['DETAIL_PICTURE'] = CFile::MakeFileArray($image_url);


            $okna = false;
            $obElement = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 32, 'PROPERTY_UPLOADED_FROM_PAGE' => $good['PROPERTY_VALUES']['UPLOADED_FROM_PAGE']), false, false, array('ID', 'NAME', 'ACTIVE', 'IBLOCK_ID', 'DETAIL_PICTURE', 'PROPERTY_UPLOADED_FROM_PAGE', 'CATALOG_GROUP_1', 'PROPERTY_CML2_ARTICLE', 'PROPERTY_PRICE_FROZEN', 'PROPERTY_EXIST1', 'SECTION_ID', 'PROPERTY_PRIORITY_PARSER', 'PROPERTY_EMPTY_PRIORITY_PARSER'));
            $num = $obElement->SelectedRowsCount();

            if ($num == 0) {
                $obElement = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 32, 'PROPERTY_UPLOADED_FROM_PAGE' => '%okno-audio%', 'NAME' => '%' . $good['PROPERTY_VALUES']['BRAND'].' '.$good['PROPERTY_VALUES']['MODEL'] . ' %'), false, false, array('ID', 'NAME', 'ACTIVE', 'IBLOCK_ID', 'DETAIL_PICTURE', 'PROPERTY_UPLOADED_FROM_PAGE', 'CATALOG_GROUP_1', 'PROPERTY_CML2_ARTICLE', 'PROPERTY_PRICE_FROZEN', 'PROPERTY_EXIST1', 'SECTION_ID', 'PROPERTY_PRIORITY_PARSER', 'PROPERTY_EMPTY_PRIORITY_PARSER'));
                $num = $obElement->SelectedRowsCount();

                if ($num > 0) $okna = true;
            }

            if ($num == 0 && !$okna){
				
                $good['CODE'] = CUtil::translit(ESUtils::Transliterator($good['NAME']), "ru", array("replace_space" => "-", "replace_other" => "-"));
                $good["MODIFIED_BY"] = 1; // элемент изменен текущим пользователем
                $good["IBLOCK_SECTION_ID"] = 3576;          // элемент лежит в корне раздела
                $good["IBLOCK_ID"] = 32;
                $good["ACTIVE"] = 'N';

                if ($PRODUCT_ID = $el->Add($good)) {
                    echo "New ID: " . $PRODUCT_ID . "<br>";

                    CPrice::SetBasePrice($PRODUCT_ID, $good['PRICE'], 'RUB');
                }
				
            } else {
				
                $arItem = $obElement->Fetch();
				
				$isPriceFrozen = $arItem['PROPERTY_PRICE_FROZEN_VALUE'] !== null;

                if ($okna) {

                    if ($arItem['PROPERTY_PRIORITY_PARSER_ENUM_ID'] == 1727 || $arItem['PROPERTY_EMPTY_PRIORITY_PARSER_ENUM_ID'] == 1729 || !$arItem['PROPERTY_EMPTY_PRIORITY_PARSER_ENUM_ID']) { //1727 - Invask
                        if ($good['PROPERTY_VALUES']['EXIST2']) { // товар в наличии
                            CIBlockElement::SetPropertyValueCode($arItem["ID"], "PRIORITY_PARSER", 1727);
                            CIBlockElement::SetPropertyValueCode($arItem["ID"], "EMPTY_PRIORITY_PARSER", 1730);
                        } else { //отсутствие товара

                            CIBlockElement::SetPropertyValueCode($arItem["ID"], "EXIST2", $good['PROPERTY_VALUES']['EXIST2']);
                            $arProdFields = array(
                                "PRODUCT_ID" => $arItem["ID"],
                                "STORE_ID" => 5,
                                "AMOUNT" => $good['PROPERTY_VALUES']['EXIST2']
                            );
                            CCatalogStoreProduct::UpdateFromForm($arProdFields);
                            CIBlockElement::SetPropertyValueCode($arItem["ID"], "EMPTY_PRIORITY_PARSER", 1729);
                            CIBlockElement::SetPropertyValueCode($arItem["ID"], "CML2_ARTICLE", $good['PROPERTY_VALUES']['CML2_ARTICLE']);
                           // CIBlockElement::SetPropertyValueCode($arItem["ID"], "PRIORITY_PARSER", 1728);
                            continue;
                        }
                    } else continue;
                }

                CIBlockElement::SetPropertyValueCode($arItem["ID"], "CML2_ARTICLE", $good['PROPERTY_VALUES']['CML2_ARTICLE']);
                CIBlockElement::SetPropertyValueCode($arItem["ID"], "ES_EXIST", $good['PROPERTY_VALUES']['ES_EXIST']);

                unset($good['PROPERTY_VALUES']);
                //$el->Update($arItem["ID"], $good); // vremenno ubrali vse obnovleniya krome cen i kol-va

				if (!$isPriceFrozen) {
					CPrice::SetBasePrice($arItem["ID"], $good['PRICE'], 'RUB');
					self::updateMinMaxPrices($arItem["ID"]);
				}

                //Удаленный склад
                $arProdFields = array(
                    "PRODUCT_ID" => $arItem["ID"],
                    "STORE_ID" => 5,
                    "AMOUNT" => $good['QUANTITY'],
                );
                CCatalogStoreProduct::UpdateFromForm($arProdFields);

                $stLog = "Q:" . $good['QUANTITY'] . ", P:" . $good['PRICE'];

                echo "UPDATE: " . $arItem['ID'] . "<br>";

                $arLog = array();
                $arLog["DATE"] = time();
                $arLog["LINK"] = '<a href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=32&type=catalog_new&ID=' . $arItem['ID'] . '&lang=ru&find_section_section=32&WF=Y">' . $good['NAME'] . '</a>';
                $arLog["URL"] = $arItem['PROPERTY_UPLOADED_FROM_PAGE_VALUE'];
                $arLog["HTTP_CODE"] = 200;
                $arLog["STATUS"] = $stLog;


                $arStatus["LOG_INVASK"][] = $arLog;

                ESUtils::SaveOption("status-run", array(
                    "ID" => "invask.ru",
                    "URL" => $arItem['PROPERTY_UPLOADED_FROM_PAGE_VALUE'],
                    "CNT" => $ind . " / " . $array['total']
                ));

                $ind++;
				
            }
        }
    }

    public static function InvaskOld(&$arStatus) {
		
        $arStatus["LOG_INVASK"] = array();

        $csv = self::InvaskCsv();
        if (empty($csv)) return;

        $ind = 1;
        $count_csv = count($csv);
        foreach ($csv as $item) {

            $catNumber = (int)trim($item[0]);
            $isAvailable = trim($item[1]);
            $price = trim($item[2]);
            $modelName = trim($item[3]);
            $itemName = trim($item[4]);
            $imagePath = trim($item[5]);
            $categoryName = trim($item[6]);
            $brandName = trim($item[7]);
            $categoryId = trim($item[8]);
            $description = trim($item[9]);
            $stockCnt = trim($item[10]);
            $brandId = trim($item[11]);
            $isNew = trim($item[12]);

            if (empty($catNumber) || $catNumber == 'catNumber') continue;

            //if ($catNumber <> '447432') continue;

            /*
          $catNumber = '445867';
          $isAvailable = true;
          $price = '21990';
          $modelName = 'QX1204USB';
          $itemName = 'BEHRINGER QX1204USB - микшер,4 микрофонных предусилителя XENYX, 2 Aux посыла, 2 стерео Aux возврата';
          $imagePath = 'https://invask.ru/resources/catalog/images/regulars/thumbs/445867-1_b.webp';
          $categoryName = 'Микшеры аналоговые';
          $brandName = 'BEHRINGER';
          $categoryId = '9';
          $description = "";
          $stockCnt = '>5';
          $brandId = '115';
          $isNew = '0';
          */

            $article = $catNumber;

            $name = trim($brandName . ' ' . $modelName);
            if (empty($name)) continue;
            if (empty($itemName)) continue;


            $stockCnt = (int)str_replace(array('<', '>'), '', $stockCnt);
            $allCnt = $stockCnt;

            $okna = false;

            $product_link = 'https://invask.ru/product/' . $catNumber;

            $obElement = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 32, 'PROPERTY_UPLOADED_FROM_PAGE' => $product_link), false, false, array('ID', 'NAME', 'ACTIVE', 'IBLOCK_ID', 'DETAIL_PICTURE', 'PROPERTY_UPLOADED_FROM_PAGE', 'CATALOG_GROUP_1', 'PROPERTY_CML2_ARTICLE', 'PROPERTY_PRICE_FROZEN', 'PROPERTY_EXIST1', 'SECTION_ID', 'PROPERTY_PRIORITY_PARSER', 'PROPERTY_EMPTY_PRIORITY_PARSER'));
            $num = $obElement->SelectedRowsCount();

            //поиск по названию, т.к. товары из OknaAudio могут совпадать
            if ($num == 0) {
                $obElement = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 32, 'PROPERTY_UPLOADED_FROM_PAGE' => '%okno-audio%', 'NAME' => '%' . $name . ' %'), false, false, array('ID', 'NAME', 'ACTIVE', 'IBLOCK_ID', 'DETAIL_PICTURE', 'PROPERTY_UPLOADED_FROM_PAGE', 'CATALOG_GROUP_1', 'PROPERTY_CML2_ARTICLE', 'PROPERTY_PRICE_FROZEN', 'PROPERTY_EXIST1', 'SECTION_ID', 'PROPERTY_PRIORITY_PARSER', 'PROPERTY_EMPTY_PRIORITY_PARSER'));
                $num = $obElement->SelectedRowsCount();
                if ($num > 0) $okna = true;
            }


            if ($num == 0) { //Добавляем

                $el = new CIBlockElement;

                $PROPS = array(
                    "UPLOADED_FROM_PAGE" => $product_link,
                );

                $CODE = CUtil::translit(ESUtils::Transliterator($itemName), "ru", array("replace_space" => "-", "replace_other" => "-"));

                $SECTION_ID = 3576;

                $arFields = array(
                    "MODIFIED_BY" => 1, // элемент изменен текущим пользователем
                    "IBLOCK_SECTION_ID" => $SECTION_ID,          // элемент лежит в корне раздела
                    "IBLOCK_ID" => 32,
                    "PROPERTY_VALUES" => $PROPS,
                    "NAME" => $itemName,
                    "CODE" => $CODE,
                    "ACTIVE" => "N",
                    "PREVIEW_TEXT" => $itemName,
                    "DETAIL_TEXT" => $description
                );

                if (!empty($imagePath)) {
                    $image = CFile::MakeFileArray($imagePath);
                    $arFields['PREVIEW_PICTURE'] = $image;
                    $arFields['DETAIL_PICTURE'] = $image;
                }

                if ($PRODUCT_ID = $el->Add($arFields)) {
                    echo "New ID: " . $PRODUCT_ID . "<br>";

                    //Добавление артикула
                    CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "CML2_ARTICLE", $article);

                    if ($price) { //Обновление цены
                        $isPriceFrozen = $arItem['PROPERTY_PRICE_FROZEN_VALUE'] !== null;

                        if (!$isPriceFrozen) {
                            CPrice::SetBasePrice($PRODUCT_ID, $price, 'RUB');
                        }
                    }
                }
            } else {
                $arItem = $obElement->Fetch();

                $PRODUCT_ID = $arItem['ID'];
                $SECTION_ID = $arItem['SECTION_ID'];


                if ($okna) {
                    if ($arItem['PROPERTY_PRIORITY_PARSER_ENUM_ID'] == 1727 || $arItem['PROPERTY_EMPTY_PRIORITY_PARSER_ENUM_ID'] == 1729 || !$arItem['PROPERTY_EMPTY_PRIORITY_PARSER_ENUM_ID']) { //1727 - Invask
                        if ($allCnt) { // товар в наличии
                            if ($arItem['PROPERTY_EMPTY_PRIORITY_PARSER_ENUM_ID'] == 1729)
                                CIBlockElement::SetPropertyValueCode($arItem["ID"], "PRIORITY_PARSER", 1728);

                            CIBlockElement::SetPropertyValueCode($arItem["ID"], "EMPTY_PRIORITY_PARSER", 1730);
                        } else { //отсутсвие товара
                            CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "EXIST2", $stockCnt);
                            $arProdFields = array(
                                "PRODUCT_ID" => $PRODUCT_ID,
                                "STORE_ID" => 5,
                                "AMOUNT" => $allCnt,
                            );
                            CCatalogStoreProduct::UpdateFromForm($arProdFields);
                            CIBlockElement::SetPropertyValueCode($arItem["ID"], "EMPTY_PRIORITY_PARSER", 1729);
                            CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "CML2_ARTICLE", $article);
                            continue;
                        }
                    } else continue;
                }
                //Обновляем фотку
                if (empty($arItem['DETAIL_PICTURE'])) {
                    $arFields = array();
                    if (!empty($imagePath)) {
                        $image = CFile::MakeFileArray($imagePath);
                        $arFields['PREVIEW_PICTURE'] = $image;
                        $arFields['DETAIL_PICTURE'] = $image;
                    }
                    $el = new CIBlockElement;

                    $el->Update($PRODUCT_ID, $arFields);

                }

                //Обновление артикула
                if (empty($arItem['PROPERTY_CML2_ARTICLE']) || $stockCnt > 0) {
                    CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "CML2_ARTICLE", $article);
                }

                echo "UPDATE: " . $PRODUCT_ID . "<br>";

                $EXIST1 = trim($arItem['PROPERTY_EXIST1_VALUE']);
                $EXIST1 = trim($EXIST1, '<');
                $EXIST1 = (int)trim($EXIST1, '>');

                if ($okna) { //Если товар еще и в Окна-Аудио суммируем кол-во
                    $allCnt = $stockCnt + $EXIST1;
                }

                //Обновление цены
                if ($price && $SECTION_ID <> 3576) {
                    $isPriceFrozen = $arItem['PROPERTY_PRICE_FROZEN_VALUE'] !== null;

                    if (!$isPriceFrozen) {

                        $basePrice = CPrice::GetBasePrice($PRODUCT_ID);
                        if ($stockCnt > 0 || empty($basePrice) || !$okna || empty($allCnt)) {
                            CPrice::SetBasePrice($PRODUCT_ID, $price, 'RUB');
                        }
                    }
                }
            }

            //В наличии
            if ($allCnt > 0) {
                CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "ES_EXIST", 642);
                $AMOUNT = $allCnt;
            } //Нет в наличии
            else {
                CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "ES_EXIST", false);
                $AMOUNT = 0;
            }
            CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "EXIST2", $stockCnt); //Наличие Invask

            //Удаленный склад
            $arProdFields = array(
                "PRODUCT_ID" => $PRODUCT_ID,
                "STORE_ID" => 5,
                "AMOUNT" => $AMOUNT,
            );
            CCatalogStoreProduct::UpdateFromForm($arProdFields);

            self::updateMinMaxPrices($PRODUCT_ID);

            $stLog = "Q:" . intval($AMOUNT) . ", P:" . floatval($price);

            $arLog = array();
            $arLog["DATE"] = time();
            $arLog["LINK"] = '<a href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=32&type=catalog_new&ID=' . $PRODUCT_ID . '&lang=ru&find_section_section=32&WF=Y">' . $name . '</a>';
            $arLog["URL"] = $product_link;
            $arLog["HTTP_CODE"] = 200;
            $arLog["STATUS"] = $stLog;
            $arStatus["LOG_INVASK"][] = $arLog;

            ESUtils::SaveOption("status-run", array(
                "ID" => "invask.ru",
                "URL" => $product_link,
                "CNT" => $ind . " / " . $count_csv,
            ));

            $ind++;
        }
    }

    protected static function InvaskCsv() {
		
        $array = array();

        $link = 'https://invask.ru/csvitems';

        $tmpPath = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/energosoft.utils/tmp';
        $csvPath = $tmpPath . '/items.csv';

        $csv = file_get_contents($link, false, stream_context_create([
            'http' => [
                'ignore_errors' => true,
            ],
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ]));
        if (empty($csv)) return;
        file_put_contents($csvPath, $csv);
        if (!file_exists($csvPath)) return $array;

        $category = self::InvaskCategory();

        $array = array();
        $handle = fopen($csvPath, "r");
        $i = 1;
        while (($row = fgetcsv($handle, 10000, ";")) !== false) {

            $categoryId = trim($row[8]);
            if (in_array($categoryId, $category)) { //нужны только определенные категории
                $array[] = $row;
            }
            $i++;
        }
        return $array;
    }

    public static function InvaskCategory() {
		
        /*$f = __DIR__ . '/invask/category.csv';
      $array = array();
      if(file_exists($f))
      {
        $handle = fopen($f, "r");
        $i = 1;
        while(($row = fgetcsv($handle, 10000, ";")) !== false) {
            $item = trim($row[0]);
            $array[] = mb_strtolower($item);
        }
      }*/

        $array1 = array('68', '475', '67', '66', '173', '188', '341', '342', '113', '391', '976', '425', '487', '26', '972', '894', '243', '351', '236', '457', '875');
        $array2 = array('458', '876', '239', '954', '38', '132', '131', '436', '386', '138', '29', '471', '465', '495', '519', '147', '520', '887', '431', '56');
        $array3 = array('56', '943', '967', '942', '285', '151', '153', '220', '152', '231', '329', '330', '331', '332', '333', '971', '334', '335', '106', '952', '336');
        $array4 = array('168', '945', '948', '946', '947', '169', '170', '443', '355', '880', '474', '116', '871', '247', '121', '122', '112', '111', '502', '969');
        $array5 = array('456', '354', '356', '30', '260', '385', '174', '160', '940', '442', '441', '235', '175', '182', '915', '437', '185', '51', '944', '190', '858');
        $array6 = array('512', '193', '517', '137', '448', '14', '346', '24', '55', '246', '446', '447', '953', '348', '497', '349', '350', '490', '455', '469', '200', '9');
        $array7 = array('50', '383', '201', '965', '950', '202', '476', '885', '883', '430', '429', '432', '428', '427', '207', '4', '240', '186', '210', '324', '123');
        $array8 = array('873', '127', '955', '128', '157', '158', '159', '213', '215', '392', '219', '496', '221', '974', '344', '61', '225', '227', '364', '879', '886');
        $array9 = array('884', '881', '882', '488', '958', '377', '124', '957', '126', '956', '378', '960', '117', '951', '337', '232', '28', '264', '265', '23');
        $array10 = array('73', '389', '962', '257', '489', '872', '916', '466', '37', '515', '516', '514', '492', '416', '415', '262', '191', '263', '451', '937', '266');
        $array11 = array('968', '513', '400', '509', '25', '339', '275', '276', '142', '913', '15', '92', '8', '91', '861', '472', '57', '859', '860', '3', '401', '450');
        $array12 = array('166', '941', '395', '280', '281', '486');

        //Втулки, Звукосниматели
        $array = array_merge($array1, $array2, $array3, $array4, $array5, $array6, $array7, $array8, $array9, $array10, $array11, $array12);

        return $array;
    }
	
	/*LTM*/

    public static function LTMGetPriceListFile() {
		
        $filename = $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/energosoft.utils/tmp/ltm_price.xls";
        $f = fopen($filename, "w");
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => "https://ltm-music.ru/upload/excel/ostatki_retail.xls?1676962838",
            CURLOPT_FILE => $f
        ]);
        curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        fclose($f);

        return $http_code == 200 ? $filename : false;
    }	


    public static function LTMGetQuantity($row) {
		
        $quantity = 0;

        if ($row[11]) $quantity += (int)str_replace('(', '', $row[11]); //Москва остаток
        if ($row[12]) $quantity -= (int)str_replace('(', '', $row[12]); //Москва резерв
        if ($row[13]) $quantity += (int)str_replace('(', '', $row[13]); // Новосибирск остаток
        if ($row[14]) $quantity -= (int)str_replace('(', '', $row[14]); // Новосибирск резерв
        if ($row[15]) $quantity += (int)str_replace('(', '', $row[15]); // Псков остаток
        if ($row[16]) $quantity -= (int)str_replace('(', '', $row[16]); // Псков резерв

        return $quantity;
    }

    public static function LTMGetGoodsArray($filename){
		
		$colPRICE = 10;
		
        $array = [];
        if ($xls = PHPExcel_IOFactory::load($filename)){
            $sheet = $xls->getActiveSheet();

            $skip = false;
            foreach ($sheet->getRowIterator() as $i => $row ){			
				
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(FALSE);

                $j = 0;
                foreach ($cellIterator as $cell) {
                    $value = $cell->getValue();

                    if ($j == 8){
                        preg_match("/=HYPERLINK\(\"(.*)\",/im", $value, $url);
                        $value = $url[1];
                    }

                    if ($value == 'Музыкальные инструменты') $skip = true;
                    if ($value == 'Стойки') $skip = false;

                    if (!$skip)
                        $array[$i][] = $value;
                    $j++;
                }

                if ($array[$i][$colPRICE] === null || $array[$i][$colPRICE] === '' || !preg_match('~[0-9]+~', $array[$i][$colPRICE]))
                    unset($array[$i]);
                else
                    $array[$i] = [
                        'NAME' => $array[$i][0],
                        'MANUFACTURER' => $array[$i][5],
                        'QUANTITY' => self::LTMGetQuantity($array[$i]),
                        'PRICE' => $array[$i][$colPRICE],
                        'PROPERTY_VALUES' => [
                            'CML2_ARTICLE' => $array[$i][7],
                            'UPLOADED_FROM_PAGE' => str_replace(['=HYPERLINK("', '","На сайт")'], '', $array[$i][8])
                        ]
                    ];
            }
        }

        return $array;
    }

    public static function LTMphotos($images, &$good, $id=null){
		
        $LTM_SERVER = 'https://ltm-music.ru';
        $good['PROPERTY_VALUES']['MORE_PHOTO'] = [];
        if (!empty($images)) {
            foreach ($images as $i => $image) {
                if ($i == 0) {
                    $good['PREVIEW_PICTURE'] = CFile::MakeFileArray($LTM_SERVER . $image->src);
                    $good['DETAIL_PICTURE'] = $good['PREVIEW_PICTURE'];
                }
                $good['PROPERTY_VALUES']['MORE_PHOTO'][] = CFile::MakeFileArray($LTM_SERVER . $image->src);
            }
            if ($id) {
                CIBlockElement::SetPropertyValuesEx($id, 32 , ['MORE_PHOTO' => $good['PROPERTY_VALUES']['MORE_PHOTO']]);
                unset($good['PROPERTY_VALUES']['MORE_PHOTO']);
            }
        }
    }

    public static function LTMGetGoodsLinks($html, &$goods_links, &$counter=0){
		
        $elements = $html->find('.catalog-sections > *');
        $skip = false;

        $breadcrumbs = $html->find('.breadcrumb a span');
        foreach ($breadcrumbs as $breadcrumb)
            if ($breadcrumb->innertext=='Музыкальные инструменты')
                return;

        if (!empty($elements)) {
            foreach ($elements as $element) {
                if ($element->tag == 'h2') {
                    if ($element->find('a', 0)->innertext == 'Музыкальные инструменты')
                        $skip = true;
                }
                elseif ($element->class == 'catalog-sections__cards') {
                    if ($skip) {
                        $skip = false;
                        continue;
                    }

                    $categories_cards = $element->find('.catalog-sections__card');
                    if (!empty($categories_cards))
                        foreach ($categories_cards as $categories_card) {
                            if ($categories_card) {
                                $link = $categories_card->find('a.catalog-sections__card-link', 0)->href;
                                $arCurl = ESUtils::CurlGet($GLOBALS['LTM_SERVER'] . $link . '?SHOWALL_1=1');

                                if ($arCurl['CODE'] != 200) continue;

                                $category_html = HtmlDomParser::str_get_html($arCurl['DATA']);
                                if ($category_html) {
                                    self::LTMGetGoodsLinks($category_html, $goods_links, $counter);
                                }
                            }
                        }
                }
            }
        }
        else{
           $catalog_cards = $html->find('.catalog-item');
           if (!empty($catalog_cards)) {
               foreach ($catalog_cards as $catalog_card)
                   if ($catalog_card) {
                       if ($link = $catalog_card->find('.name a', 0)->href) {
                           $goods_links[] =  $GLOBALS['LTM_SERVER'].$link;
                       }
                   }
           }
        }
    }

    public static function LTMAdd() {		
		
        $GLOBALS['LTM_SERVER'] = 'https://ltm-music.ru';
        $filename = self::LTMGetPriceListFile();
        $pricelist_goods = self::LTMGetGoodsArray($filename);
		
        $arCurl = ESUtils::CurlGet($GLOBALS['LTM_SERVER'].'/catalog/');
        if ($arCurl['CODE'] != 200) return false;
		
        $html = HtmlDomParser::str_get_html($arCurl['DATA']);
        self::LTMGetGoodsLinks($html, $goods_links);
        $goods_links = array_unique($goods_links);

        $cml2 = [];
        $el = new CIBlockElement;

        foreach ($goods_links as $goods_link) {
			
            $good = null;
            $arCurl = ESUtils::CurlGet($goods_link);

            if ($arCurl['CODE'] != 200) continue;

            $html = HtmlDomParser::str_get_html($arCurl['DATA']);

            $breadcrumbs = $html->find('.breadcrumb a span');
            foreach ($breadcrumbs as $breadcrumb) {
                if ($breadcrumb->innertext=='Музыкальные инструменты') {
                    continue 2;
				}
			}

            $code = $html->find('.product__code', 0)->innertext;
            $code = preg_replace('/\D/', '', $code);

            foreach ($pricelist_goods as $pricelist_good) {
                if ($pricelist_good['PROPERTY_VALUES']['CML2_ARTICLE'] == $code) {
                    $good = $pricelist_good;
                    break;
                }
			}

            if (!$good) {
				$good = self::LTMGoodByHTML($html, $goods_link);
			}

            if (in_array($good['PROPERTY_VALUES']['CML2_ARTICLE'], $cml2)) {
                continue;
            } else {
                $cml2[] = $good['PROPERTY_VALUES']['CML2_ARTICLE'];
			}
			
			$obElement = CIBlockElement::GetList(
				array(), 
				array(
					'IBLOCK_ID' => 32,
					//'IBLOCK_SECTION_ID' => 3669,
					'PROPERTY_UPLOADED_FROM_PAGE' => $good['PROPERTY_VALUES']['UPLOADED_FROM_PAGE']
				), 
				false, 
				false
			);
			$arItem = $obElement->Fetch();
			$PRODUCT_ID = !empty($arItem['ID']) ? $arItem['ID'] : 0;			

            if ($PRODUCT_ID == 0) {
				
				self::LTMphotos($html->find('.gallery-list .gallery-item > a > img'), $good);

                $good['DETAIL_TEXT'] = $html->find('.product__text > .text > .text-in', 0) ?? '';

                $good["MODIFIED_BY"] = 1;
                $good["IBLOCK_SECTION_ID"] = 3669;
                $good["IBLOCK_ID"] = 32;
                $good['ACTIVE'] = 'N';
                $good['CODE'] = CUtil::translit(ESUtils::Transliterator($good['NAME']), "ru", array("replace_space" => "-", "replace_other" => "-"));

                $PRODUCT_ID = $el->Add($good);
				if ($PRODUCT_ID) {
					echo "New ID: " . $PRODUCT_ID . "<br>";				
				}

            } 			

			if ($PRODUCT_ID) {

				echo "Update ID: " . $PRODUCT_ID . "<br>";

				if ($good['PRICE']) {
					CPrice::SetBasePrice($PRODUCT_ID, (int)$good['PRICE'], 'RUB');
				}

				//Остаток
				CCatalogStoreProduct::UpdateFromForm([
					'PRODUCT_ID' => $PRODUCT_ID,
					'STORE_ID' => 5, //Удаленный склад
					'AMOUNT' => (int)$good['QUANTITY']
				]);
			}			

        }
    }

    public static function LTM(&$arStatus){
		sendAlarmTG('🏁 /bitrix/modules/energosoft.utils/classes/general/es-parser.php. Запускается LTM Update');
		
        $LTM_SERVER = 'https://ltm-music.ru';

        $filename = self::LTMGetPriceListFile();
        $goods = self::LTMGetGoodsArray($filename);  print_r($goods);
		
		$errorStatusElements = [];

        $goods_link = array();
        foreach ($goods as $item){
            $key = $item['PROPERTY_VALUES']['UPLOADED_FROM_PAGE'];
            if (empty($key)) continue;
            $goods_link[$key] = $item;
        }

        $el = new CIBlockElement();

        $arStatus["LOG_LTM"] = [];

        $obElement = CIBlockElement::GetList(array(), array(
            'IBLOCK_ID' => 32,
            //'IBLOCK_SECTION_ID' => 3669
           'PROPERTY_UPLOADED_FROM_PAGE' => '%ltm-music.ru%'
        ), false, false, array('ID', 'NAME', 'ACTIVE', "IBLOCK_SECTION_ID", 'XML_ID', 'IBLOCK_ID', 'PROPERTY_UPLOADED_FROM_PAGE', 'CATALOG_GROUP_1', 'DETAIL_TEXT', 'PROPERTY_CML2_ARTICLE', 'PROPERTY_UPDATE_DETAIL_TEXT_STATUS','PROPERTY_UPDATE_PREVIEW_TEXT_STATUS', 'PROPERTY_PRICE_FROZEN'));

		
        while ($arItem = $obElement->Fetch()){
            $good = null;
			
			$isPriceFrozen = $arItem['PROPERTY_PRICE_FROZEN_VALUE'] !== null;
            
            foreach ($goods as $item){
                /*if ($item['PROPERTY_VALUES']['UPLOADED_FROM_PAGE'] == $arItem['PROPERTY_UPLOADED_FROM_PAGE_VALUE']) {
                    $good = $item;
                    break;
                }*/
				
				if ($item['PROPERTY_VALUES']['CML2_ARTICLE'] == $arItem['PROPERTY_CML2_ARTICLE_VALUE']) {
                    $good = $item;
                    break;
                }
            }		

            $arCurl = ESUtils::CurlGet($arItem['PROPERTY_UPLOADED_FROM_PAGE_VALUE'], false, false, true);

            if ($arCurl['CODE'] != 200) {
				
				if ($arItem['ACTIVE'] == 'Y') {
					$errorStatusElements[] = $arItem['NAME']. ' - '. $arItem['PROPERTY_UPLOADED_FROM_PAGE_VALUE']. ': status '. $arCurl['CODE'];
				}
				$el->Update($arItem['ID'], ['ACTIVE' => 'N']);	
				
				
			} else {				

				$html = HtmlDomParser::str_get_html($arCurl['DATA']);

				if (empty($good)) $good = self::LTMGoodByHTML($html, $arItem['PROPERTY_UPLOADED_FROM_PAGE_VALUE']);
				if (empty($good)) continue;		

				/*
				if (!$arItem['PROPERTY_UPDATE_DETAIL_TEXT_STATUS_VALUE'] && $arItem['PROPERTY_UPDATE_DETAIL_TEXT_STATUS_VALUE'] <> 'да' && empty(strip_tags($arItem['DETAIL_TEXT']))) {                  

					//$DETAIL_TEXT = $html->find('.text-block > .text > .text-in', 0);

					preg_match_all("/<div class=\"text-in\">(.*?)<\/div>/im", $html, $arr);
					$DETAIL_TEXT = trim($arr[1][0]);
					$good['DETAIL_TEXT'] = $DETAIL_TEXT;
				}

				self::LTMphotos($html->find('.product-block  .photo > a > img'), $good, $arItem['ID']);

				unset($good['PROPERTY_VALUES']);
				if ($el->update($arItem['ID'], $good)) echo "UPDATE ".$arItem['ID']; // vremenno ubrali vse obnovleniya krome cen i kol-va
				*/

				//Остаток
				CCatalogStoreProduct::UpdateFromForm([
					'PRODUCT_ID' => $arItem['ID'],
					'STORE_ID' => 5, //Удаленный склад
					'AMOUNT' => (int)$good['QUANTITY']
				]);

				if (!$isPriceFrozen) {
					CPrice::SetBasePrice($arItem['ID'], $good['PRICE'], 'RUB');
					self::updateMinMaxPrices($arItem['ID']);
				}
				
				if ((int)$good['PRICE'] > 0){
					$el->Update($arItem['ID'], ['ACTIVE' => 'Y']);	
				}
				
			}         

            $arLog = array();
            $arLog["DATE"] = time();
            $arLog["LINK"] = '<a href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=32&type=catalog_new&ID=' . $arItem["ID"] . '&lang=ru&find_section_section=' . intval($arItem["IBLOCK_SECTION_ID"]) . '&WF=Y">' . $arItem["NAME"] . '</a>';
            $arLog["URL"] = $arItem['PROPERTY_UPLOADED_FROM_PAGE_VALUE'];
            $arLog["HTTP_CODE"] = $arCurl["CODE"];
            $arLog["STATUS"] = 'Прайс';
            $arLog["PRICE_LIST"] = 'P:'.$good['PRICE'].' Q:'.$good['QUANTITY'];
            $arStatus["LOG_LTM"][] = $arLog;

            ESUtils::SaveOption("status-run", array(
                "ID" => "ltm-music.ru",
                "URL" => $arItem['PROPERTY_UPLOADED_FROM_PAGE_VALUE'],
                "CNT" => $good['QUANTITY'],
            ));
        }		

		if (!empty($errorStatusElements)) {
			//mail('diz55@mail.ru', 'ustage LMT update', 'Товары с ошибочными статусами: '. PHP_EOL . implode(PHP_EOL, $errorStatusElements)); 

            ESUtils::SaveOption("errors-page", array(
                "ID" => "LTM",
                "PAGE" => $errorStatusElements,
            ));
			
		}			

        ESUtils::SaveOption("status-run", array(
            "ID" => "ltm-music.ru",
            "URL" => '',
            "CNT" => '...',
        ));	

    }

    public static function LTMGoodByHTML($html, $link) {
		
        $good['NAME'] = $html->find('h1', 0)->innertext;

        $good['QUANTITY'] = 0;
        $available_blocks = $html->find('.product__available-column > .product__available-item');
        foreach ($available_blocks as $available_block) {
            if ($available_block->find('.isset', 0) || $available_block->find('.limited', 0)){
                $good['QUANTITY'] = 6;
                break;
            }
        }
		
        $code = $html->find('.product__code', 0)->innertext;
        $code = preg_replace('/\D/', '', $code);
        
		$good['PRICE'] = $html->find('.product .product-price > .product-price__value', 0)->innertext;
        $good['PRICE'] = (float)preg_replace('/\s+/', '', $good['PRICE']);
		
        $good['PROPERTY_VALUES']['CML2_ARTICLE'] = $code;
        $good['PROPERTY_VALUES']['UPLOADED_FROM_PAGE'] = $link;


        return $good;
    }   
	
	/*rigger*/
	
    public static function Rigger(&$arStatus) {
        sendAlarmTG('🏁 /bitrix/modules/energosoft.utils/classes/general/es-parser.php. Запускается Rigger Update');

       //return Rigger::update($arStatus, 32, null, 9959);
        return Rigger::update($arStatus);
                
    }	

    public static function RiggerAdd() {
		 sendAlarmTG('🏁 /bitrix/modules/energosoft.utils/classes/general/es-parser.php. Запускается Rigger Add');

        $server = 'https://riggershop.ru';
        $server2 = 'http://www.riggershop.ru';
        $server3 = 'http://riggershop.ru';
        $server4 = 'https://www.riggershop.ru';

        $url = 'https://riggershop.ru/catalog/';

        $arCurl = ESUtils::CurlGet($url);

        if ($arCurl["CODE"] == 200) {
			
            $searchPage = str_replace(array("\n", "\r", "\t"), "", $arCurl["DATA"]);
            $searchPage = preg_replace('/<!---.*?--->/ui', "", $searchPage);

            $arCats = array();
            $arProducts = array();
            preg_match_all("/<div class=\"layout-main\">(.*?)data-stickyfooter/im", $searchPage, $arr);

            preg_match_all("/<a href=\"\/catalog\/(.*?)\" class=\"main-sections-item/im", $arr[1][0], $arr2);

            foreach ($arr2[1] as $item) {
                $item = trim($item);
                if (empty($item)) continue;
                $arCats[] = $server . '/catalog/' . $item;
            }

            $i = 1;
            $arCats = array_unique($arCats);
            foreach ($arCats as $cat) {

                //if ($i > 1) break;

                $getCat = ESUtils::CurlGet($cat);
                if ($getCat["CODE"] == 200) {

                    preg_match_all("/PAGEN_1=(.*?)\">/im", $getCat["DATA"], $arr3);

                    $pagen = 1;
                    foreach ($arr3[1] as $item) {
                        if ($item > $pagen) $pagen = $item;
                    }
                    $pagen = (int)$pagen;
                    if (empty($pagen)) $pagen = 1;

                    for ($i = 1; $i <= $pagen; $i++) {
                        $get = ESUtils::CurlGet($cat . '?PAGEN_1=' . $i);
                        if ($get["CODE"] == 200) {

                            $arr4 = explode('<div id="products-list"', $get['DATA']);
                            $arr5 = explode('data-stickyfooter', $arr4[1]);

                            preg_match_all("/<a href=\"\/catalog\/(.*?)\" title/im", $arr5[0], $arr6);

                            foreach ($arr6[1] as $prod) {
                                $arProducts[] = '/catalog/' . $prod;
                            }
                        }
                        //break;
                    }
                }

                $i++;
            }

            $arProducts = array_unique($arProducts);
            foreach ($arProducts as $product) {

                $link = $server . $product;
                $link2 = $server2 . $product;
                $link3 = $server3 . $product;
                $link4 = $server4 . $product;

                $page = ESUtils::CurlGet($link);
                if ($page["CODE"] == 200) {

                    $link_http = trim(str_replace('https://', '', $link), '/');

                    $searchPage = str_replace(array("\n", "\r"), "", $page["DATA"]);
                    $searchPage = str_replace("\'", "@@@", $searchPage);

                    //name
                    preg_match("#<div class=\"product-title\">(.*?)<\/div>#i", $searchPage, $arr7);
                    $name = trim(strip_tags($arr7[1]));

                    //Артикул
                    $tovar_arr = explode('<div class="product-specs-list-title">Артикул</div>', $searchPage);
                    $tovar_arr = explode('product-specs-list-data">', $tovar_arr[1]);
                    $tovar_arr = explode('</div>', $tovar_arr[1]);
                    $art = trim(strip_tags($tovar_arr[0]));

                    //Цена
                    preg_match("#<div class=\"product-price\"(.*?)<\/div>#i", $searchPage, $arr8);
                    $price_arr = explode('>', $arr8[1]);
                    $price = trim(strip_tags($price_arr[1]));
                    $price = intval(preg_replace('/[^0-9,.]/', '', $price));

                    //Наличие
                    preg_match("#<div class=\"product-available-storage\" style=\"display: ;\">(.*?)</span>#i", $searchPage, $arr9);
                    $avail_arr = explode('">', $arr9[1]);
                    $avail_arr = explode('</span>', $avail_arr[1]);
                    $avail = $avail_arr[0];

                    //Текст
                    preg_match("#<div class=\"product-info-text\"(.*?)<\/div>#i", $searchPage, $arr10);
                    $text_arr = explode('">', $arr10[1]);
                    $text_arr = explode('</div>', $text_arr[1]);
                    $text = $text_arr[0];

                    preg_match("#<div class=\"product-image\"(.*?)<\/div>#i", $searchPage, $arr11);
                    $img_arr = explode('src="', $arr11[1]);
                    $img_arr = explode('"', $img_arr[1]);
                    $image = trim($img_arr[0]);
                    if (!empty($image)) $image = $server . $image;


                    $obElement = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 32, 'PROPERTY_UPLOADED_FROM_PAGE' => '%'.$link_http.'%'), false, false, array('ID', 'NAME', 'ACTIVE', 'IBLOCK_ID', 'DETAIL_PICTURE', 'PROPERTY_UPLOADED_FROM_PAGE'));
                    $num = $obElement->SelectedRowsCount();
                    if ($num == 0 && !empty($name)) {
                        //Добавляем
                        $el = new CIBlockElement;

                        $PROPS = array(
                            "UPLOADED_FROM_PAGE" => $link,
                        );

                        $CODE = CUtil::translit(ESUtils::Transliterator($name), "ru", array("replace_space" => "-", "replace_other" => "-"));

                        $arFields = array(
                            "MODIFIED_BY" => 1, // элемент изменен текущим пользователем
                            "IBLOCK_SECTION_ID" => 3533,
                            "IBLOCK_ID" => 32,
                            "PROPERTY_VALUES" => $PROPS,
                            "NAME" => $name,
                            "CODE" => $CODE,
                            "ACTIVE" => "N",
                            "DETAIL_TEXT" => $text
                        );

                        if (!empty($image)) {
                            $arFields['PREVIEW_PICTURE'] = $arFields['DETAIL_PICTURE'] = CFile::MakeFileArray($image);
                        }

                        if ($PRODUCT_ID = $el->Add($arFields)) {
                            echo "New ID: " . $PRODUCT_ID . "<br>";

                            CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "CML2_ARTICLE", $art);
                        }
                    } /*else {
                        $arItem = $obElement->Fetch();
                        $PRODUCT_ID = $arItem['ID'];
                        echo "UPDATE: " . $PRODUCT_ID . "<br>";
                    }*/
					
					if (!empty($PRODUCT_ID)) {
						
						//В наличии
						if (!empty($avail)) {
							CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "ES_EXIST", 642);
						} //Нет в наличии
						else {
							CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "ES_EXIST", false);
						}

						//Удаленный склад
						$arProdFields = array(
							"PRODUCT_ID" => $PRODUCT_ID,
							"STORE_ID" => 5,
							"AMOUNT" => (int)$avail,
						);
						CCatalogStoreProduct::UpdateFromForm($arProdFields);

						//Цену
						if (!empty($price)) {
							// цена не зафиксирована
							CPrice::SetBasePrice($PRODUCT_ID, $price, 'RUB');
						}
					
					}
                }

                //break;
            }
        }
    }
	
	/*GlobalEffects*/	

    public static function GlobalEffectsAdd() {
		 sendAlarmTG('🏁 /bitrix/modules/energosoft.utils/classes/general/es-parser.php. Запускается GlobalEffects Add');

        $server = 'https://globaleffects.ru/';
        $server2 = 'http://globaleffects.ru/';

        $url = 'https://globaleffects.ru/';

        $arCurl = ESUtils::CurlGet($url);

        if ($arCurl["CODE"] == 200) {
			
            $searchPage = str_replace(array("\n", "\r", "\t"), "", $arCurl["DATA"]);
            $searchPage = preg_replace('/<!---.*?--->/ui', "", $searchPage);

            $arCats = array();
            $arProducts = array();
            preg_match_all("#<a href=\"/category\/(.*?)\">#im", $searchPage, $arr);

            foreach ($arr[1] as $cat) {
                $arr_cat = explode('"', $cat);
                $cat = $arr_cat[0];

                if (empty($cat)) continue;
                else $cat = $server . 'category/' . $cat;

                $arCats[] = $cat;
            }
            $arCats = array_unique($arCats);

            foreach ($arCats as $cat) {

                $arCat = ESUtils::CurlGet($cat);
                if ($arCat["CODE"] == 200) {

                    preg_match_all("#<a href=\"/product\/(.*?)\">#im", $arCat["DATA"], $arr2);

                    foreach ($arr2[1] as $link) {

                        if (empty($link)) continue;
                        else {
                            $link = 'product/' . $link;
                            $arProducts[] = $link;
                        }
                    }
                }
                //break;
            }

            $arProducts = array_unique($arProducts);
            foreach ($arProducts as $product) {

                $link = $server . $product;
                $link2 = $server2 . $product;

                $get = ESUtils::CurlGet($link);
                if ($get["CODE"] == 200) {

                    $link_http = trim(str_replace('https://', '', $link), '/');

                    $searchPage = str_replace(array("\n", "\r", "\t"), "", $get["DATA"]);
                    $searchPage = preg_replace('/<!---.*?--->/ui', "", $searchPage);

                    //name
                    preg_match("#<h1 class=\"title\" itemprop=\"name\">(.*?)<\/h1>#i", $searchPage, $arr3);
                    $name = trim(strip_tags($arr3[1]));

                    //price
                    $tovar_arr = explode('<span itemprop="price"', $searchPage);
                    $tovar_arr = explode('content="', $tovar_arr[1]);
                    $tovar_arr = explode('">', $tovar_arr[1]);
                    $price = trim(strip_tags($tovar_arr[1]));
                    $price = intval(preg_replace('/[^0-9,.]/', '', $price));

                    //img
                    $img_arr = explode('<div class="img-block">', $searchPage);
                    $img_arr = explode('<img src="', $img_arr[1]);
                    $img_arr = explode('" alt=', $img_arr[1]);
                    $image = trim($img_arr[0]);

                    //текст
                    preg_match("#<div class=\"col-xs-12 col-sm-12\" itemprop=\"description\">(.*?)<\/div>#i", $searchPage, $arr5);
                    $text = trim($arr5[1]);

                    $obElement = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 32, 'PROPERTY_UPLOADED_FROM_PAGE' => '%'.$link_http.'%'), false, false, array('ID', 'NAME', 'ACTIVE', 'IBLOCK_ID', 'DETAIL_PICTURE', 'PROPERTY_UPLOADED_FROM_PAGE'));
                    $num = $obElement->SelectedRowsCount();
                    if ($num == 0 && !empty($name)) {
                        //Добавляем
                        $el = new CIBlockElement;

                        $PROPS = array(
                            "UPLOADED_FROM_PAGE" => $link,
                            "UPLOADED_PHOTO" => $image
                        );

                        $CODE = CUtil::translit(ESUtils::Transliterator($name), "ru", array("replace_space" => "-", "replace_other" => "-"));

                        $arFields = array(
                            "MODIFIED_BY" => 1, // элемент изменен текущим пользователем
                            "IBLOCK_SECTION_ID" => 3534,
                            "IBLOCK_ID" => 32,
                            "PROPERTY_VALUES" => $PROPS,
                            "NAME" => $name,
                            "CODE" => $CODE,
                            "ACTIVE" => "N",
                            "DETAIL_TEXT" => $text
                        );

                        if (!empty($image)) {
                            $arFields['PREVIEW_PICTURE'] = $arFields['DETAIL_PICTURE'] = CFile::MakeFileArray($image);
                        }

                        if ($PRODUCT_ID = $el->Add($arFields)) {
                            echo "New ID: " . $PRODUCT_ID . "<br>";

                            // CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "CML2_ARTICLE", $article);
                        }
                    } else {
                        $arItem = $obElement->Fetch();
                        $PRODUCT_ID = $arItem['ID'];
                        echo "UPDATE: " . $PRODUCT_ID . "<br>";
                    }

                    //Цену
                    if (!empty($price)) {
                        CPrice::SetBasePrice($PRODUCT_ID, $price, 'RUB');
                    }
                }
            }
			
        }
    }
	
	public static function GlobalEffects(&$arStatus) {
		sendAlarmTG('🏁 /bitrix/modules/energosoft.utils/classes/general/es-parser.php. Запускается GlobalEffects Update');
		
        $sec = new CIBlockSection;
        $preEl = new CIBlockElement;
        $ibp = new CIBlockProperty;
        $arStatus["LOG_GLOBALEFFECTS"] = array();

        $arSiteMap = array();
        $arCurl = ESUtils::CurlGet("http://globaleffects.ru/sitemap.xml");
        if ($arCurl["CODE"] == 200) {
			
            $xml = (array)simplexml_load_string($arCurl["DATA"]);
            foreach ($xml["url"] as $obLink) {
                $arLink = (array)$obLink;
                if (stripos($arLink["loc"], '/product/') === false) continue;
                $arLink["loc"] = ToLower($arLink["loc"]);
                $arSiteMap[$arLink["loc"]] = false;
            }

            $arElements = array();
            if (count($arSiteMap) > 0) {
                $obElement = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 32, 'PROPERTY_UPLOADED_FROM_PAGE' => '%globaleffects%'), false, false, array('ID', 'NAME', 'ACTIVE', "IBLOCK_SECTION_ID", 'XML_ID', 'IBLOCK_ID', 'PROPERTY_UPLOADED_FROM_PAGE', 'CATALOG_GROUP_1', 'PROPERTY_CML2_ARTICLE' , 'PROPERTY_UPDATE_DETAIL_TEXT_STATUS', 'PROPERTY_UPDATE_PREVIEW_TEXT_STATUS', 'PROPERTY_PRICE_FROZEN'));
                while ($arItem = $obElement->Fetch()) {
                    if ($arItem['ID'] === 23621 && time() < 1622149260) {
                        continue;
                    }

                    $url = ToLower($arItem['PROPERTY_UPLOADED_FROM_PAGE_VALUE']);
                    if ($url != "" && stripos($url, '://globaleffects.ru/') !== false) $arElements[$url] = $arItem;
                }
            }

            if (count($arSiteMap) > 0 || count($arElements) > 0) {
				
                $ind = 0;
                $cnt = count($arSiteMap) + count($arElements);
				
				$errorStatusElements = [];

                foreach ($arElements as $url => $arItem) {
					
                    $ind++;
                    unset($arSiteMap[$url]);
					
					$isPriceFrozen = $arItem['PROPERTY_PRICE_FROZEN_VALUE'] !== null;

                    $arCurl = array();
                    $stLog = "Q:0, P:0";

                    $arCurl = ESUtils::CurlGet($url);
                    if ($arCurl["CODE"] == 200) {
						
                        $strPage = str_replace(array("\n", "\r", "\t"), "", $arCurl["DATA"]);
                        //preg_match('#<div class="price.*?"><span>(.*?)</span>.*?</div>#iu', $strPage, $match);
                        preg_match('#<div class="price.*?"><span.*?>(.*?)</span>.*?</div>#iu', $strPage, $match);
                        $price = intval(preg_replace('/[^0-9,.]/', '', $match[1]));

                        /*// detail_text
						preg_match_all('#<section class="product-desc">(.*?)</section>#ui', $strPage, $match);
						$match[1][0] = preg_replace('/<a.*?\/a>/ui', "", $match[1][0]);
						$arFields = array();
						$arFields['DETAIL_TEXT'] = $match[1][0];
						$arFields['DETAIL_TEXT'] = strip_tags($arFields['DETAIL_TEXT']);
						$arFields['DETAIL_TEXT'] = trim(preg_replace("/\&nbsp\;/", " ", $arFields['DETAIL_TEXT']));
						$arFields['DETAIL_TEXT'] = trim(preg_replace("/  /", " ", $arFields['DETAIL_TEXT']));
						$arFields['DETAIL_TEXT'] = trim(preg_replace("/  /", " ", $arFields['DETAIL_TEXT']));
						$arFields['DETAIL_TEXT'] = trim(preg_replace("/  /", " ", $arFields['DETAIL_TEXT']));
						$arFields['DETAIL_TEXT'] = trim(preg_replace("/  /", " ", $arFields['DETAIL_TEXT']));
						$arFields['DETAIL_TEXT'] = trim(preg_replace("/  /", " ", $arFields['DETAIL_TEXT']));
						$arFields['DETAIL_TEXT'] = trim(preg_replace("/  /", " ", $arFields['DETAIL_TEXT']));
						$arFields['DETAIL_TEXT'] = trim(preg_replace("/  /", " ", $arFields['DETAIL_TEXT']));
						$arFields['DETAIL_TEXT'] = trim(preg_replace("/  /", " ", $arFields['DETAIL_TEXT']));
						$arFields['DETAIL_TEXT'] = trim(preg_replace("/Посетите наш шоу-рум и получите консультацию от наших специалистов./i", "", $arFields['DETAIL_TEXT']));
						$arFields['DETAIL_TEXT'] = trim(preg_replace("/По запросу проконсультируем вас в онлайн чате на сайте или в WhatsApp \(для регионов в рабочие часы по МСК\)./i", "", $arFields['DETAIL_TEXT']));
						$arFields['DETAIL_TEXT_TYPE'] = "html";
						$preEl->Update($arItem['ID'], $arFields);
						*/

                        /*
                        $arProdFields = array(
                            "ID" => $arItem['ID'],
                            "VAT_INCLUDED" => "Y",
                            "QUANTITY" => 0,
                        );
                        CCatalogProduct::Add($arProdFields);
                        $arProdFields = Array(
                            "PRODUCT_ID" => $arItem['ID'],
                            "STORE_ID" => 5,
                            "AMOUNT" => 0,
                        );
                        CCatalogStoreProduct::UpdateFromForm($arProdFields);
                        */
						
						if (!$isPriceFrozen) {
							CPrice::SetBasePrice($arItem['ID'], $price, 'RUB');
							$stLog = "Q:0, P:" . $price;

							if ($arItem['ACTIVE'] === 'Y') {
								self::comparePrices($arItem['ID'], $arItem['NAME'], $arItem['PROPERTY_UPLOADED_FROM_PAGE_VALUE'], $arItem['CATALOG_PRICE_1'], $price, $arItem['PROPERTY_CML2_ARTICLE_VALUE']);
							}
							
							self::updateMinMaxPrices($arItem['ID']);
						}
						
                    } else {
						
						if ($arItem['ACTIVE'] == 'Y') {
							$errorStatusElements[] = $arItem['NAME']. ' - '. $arItem['PROPERTY_UPLOADED_FROM_PAGE_VALUE']. ': status '. $arCurl['CODE'];
						}
						$preEl->Update($arItem['ID'], ['ACTIVE' => 'N']);							
						
					}

                    if (!empty($errorStatusElements)) {

						ESUtils::SaveOption("errors-page", array(
							"ID" => "Globaleffects",
							"PAGE" => $errorStatusElements,
						));

                    }

                    $arLog = array();
                    $arLog["DATE"] = time();
                    $arLog["LINK"] = '<a href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=32&type=catalog_new&ID=' . $arItem["ID"] . '&lang=ru&find_section_section=' . intval($arItem["IBLOCK_SECTION_ID"]) . '&WF=Y">' . $arItem["NAME"] . '</a>';
                    $arLog["URL"] = $url;
                    $arLog["HTTP_CODE"] = $arCurl["CODE"];
                    $arLog["STATUS"] = $stLog;
                    $arStatus["LOG_GLOBALEFFECTS"][] = $arLog;

                    ESUtils::SaveOption("status-run", array(
                        "ID" => "globaleffects.ru",
                        "URL" => $url,
                        "CNT" => $ind . " / " . $cnt,
                    ));
                }

                foreach ($arSiteMap as $url => $v) {
                    $ind++;
                    $stLog = "Q:0, P:0";
                    $stLink = "";

                    $arCurl = ESUtils::CurlGet($url);
                    if ($arCurl["CODE"] == 200) {
						
                        //$DONOR_SECTION = 3125; //OLD
                        $DONOR_SECTION = 3534;

                        $PROPS = array(
                            "UPLOADED_FROM_PAGE" => $url,
                        );
                        $arFields = array(
                            'IBLOCK_ID' => 32,
                            'ACTIVE' => 'N',
                        );

                        $strPage = str_replace(array("\n", "\r", "\t"), "", $arCurl["DATA"]);
                        preg_match_all('#<li class=".*?active"><a href=".*?">(.*?)</a>.*?</li>#ui', $strPage, $matches);

                        foreach ($matches[1] as $section) {
                            $sectionName = trim($section);
                            $arSection = CIBlockSection::GetList(array(), array('IBLOCK_ID' => 32, 'NAME' => $sectionName, 'SECTION_ID' => $DONOR_SECTION))->Fetch();
                            if ($arSection['ID'] > 0) $sectionId = $arSection['ID'];
                            else {
                                $sectionCode = CUtil::translit(ESUtils::Transliterator($sectionName), "ru", array("replace_space" => "-", "replace_other" => "-"));
                                $arSecFields = array(
                                    'IBLOCK_ID' => 32,
                                    'NAME' => $sectionName,
                                    "CODE" => "ge-" . $sectionCode,
                                    "ACTIVE" => 'N',
                                    "IBLOCK_SECTION_ID" => $DONOR_SECTION,
                                );
                                $sectionId = $sec->Add($arSecFields);
                            }
                            if ($sectionId) $DONOR_SECTION = $sectionId;
                        }

                        if ($DONOR_SECTION > 0) {
                            $arFields['IBLOCK_SECTION_ID'] = $DONOR_SECTION;

                            // Price
                            preg_match('#<div class="price.*?"><span.*?>(.*?)</span>.*?</div>#iu', $strPage, $match);
                            $price = intval(preg_replace('/[^0-9,.]/', '', $match[1]));

                            // name
                            preg_match('#<h1 class="title(.*?)</h1>#ui', $strPage, $match);
                            $arNames = explode('>', $match[1]);
                            $NAME = strip_tags($arNames[1]);
                            if (empty($NAME)) $NAME = strip_tags($arNames[1]);
                            $arFields['NAME'] = $NAME;
                            $trans = CUtil::translit(str_replace("+", " ", ESUtils::Transliterator($arFields['NAME'])), "ru", array("replace_space" => "-", "replace_other" => "-"));
                            $arFields['CODE'] = $trans;

                            /*// detail_text
                            if (!$arItem['PROPERTY_UPDATE_DETAIL_TEXT_STATUS_VALUE'] && $arItem['PROPERTY_UPDATE_DETAIL_TEXT_STATUS_VALUE'] <> 'да') {
                                preg_match_all('#<section class="product-desc">(.*?)</section>#ui', $strPage, $match);
                                $match[1][0] = preg_replace('/<a.*?\/a>/ui', "", $match[1][0]);
                                $arFields['DETAIL_TEXT'] = $match[1][0];
                                $arFields['DETAIL_TEXT'] = strip_tags($arFields['DETAIL_TEXT']);
                                $arFields['DETAIL_TEXT'] = trim(preg_replace("/\&nbsp\;/", " ", $arFields['DETAIL_TEXT']));
                                $arFields['DETAIL_TEXT'] = trim(preg_replace("/  /", " ", $arFields['DETAIL_TEXT']));
                                $arFields['DETAIL_TEXT'] = trim(preg_replace("/  /", " ", $arFields['DETAIL_TEXT']));
                                $arFields['DETAIL_TEXT'] = trim(preg_replace("/  /", " ", $arFields['DETAIL_TEXT']));
                                $arFields['DETAIL_TEXT'] = trim(preg_replace("/  /", " ", $arFields['DETAIL_TEXT']));
                                $arFields['DETAIL_TEXT'] = trim(preg_replace("/  /", " ", $arFields['DETAIL_TEXT']));
                                $arFields['DETAIL_TEXT'] = trim(preg_replace("/  /", " ", $arFields['DETAIL_TEXT']));
                                $arFields['DETAIL_TEXT'] = trim(preg_replace("/  /", " ", $arFields['DETAIL_TEXT']));
                                $arFields['DETAIL_TEXT'] = trim(preg_replace("/  /", " ", $arFields['DETAIL_TEXT']));
                                $arFields['DETAIL_TEXT'] = trim(preg_replace("/Посетите наш шоу-рум и получите консультацию от наших специалистов./i", "", $arFields['DETAIL_TEXT']));
                                $arFields['DETAIL_TEXT'] = trim(preg_replace("/По запросу проконсультируем вас в онлайн чате на сайте или в WhatsApp \(для регионов в рабочие часы по МСК\)./i", "", $arFields['DETAIL_TEXT']));
                                $arFields['DETAIL_TEXT_TYPE'] = "html";
                            }

                            $arFields['PROPERTY_VALUES'] = $PROPS;*/

                            if (!empty($arFields['NAME'])) {

                                /*$newId = $preEl->Add($arFields);
                                if($newId > 0)
                                {
                                    $arProdFields = array(
                                        "ID" => $newId,
                                        "VAT_INCLUDED" => "Y",
                                        "QUANTITY" => 0,
                                    );
                                    CCatalogProduct::Add($arProdFields);

                                    //$arProdFields = Array(
                                    //  "PRODUCT_ID" => $newId,
                                    //  "STORE_ID" => 5,
                                    //  "AMOUNT" => $q,
                                    //);
                                    //CCatalogStoreProduct::UpdateFromForm($arProdFields);

                                    CPrice::SetBasePrice($newId, $price, 'RUB');

									self::updateMinMaxPrices($newId);
                                }*/

                                $stLog = "Q:0, P:" . $price;

                                $stLink = '<a href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=32&type=catalog_new&ID=' . $newId . '&lang=ru&find_section_section=' . intval($arFields["IBLOCK_SECTION_ID"]) . '&WF=Y">' . $arFields["NAME"] . '</a>';
                            }
                        }
                    }

                    $arLog = array();
                    $arLog["DATE"] = time();
                    $arLog["LINK"] = $stLink;
                    $arLog["URL"] = $url;
                    $arLog["HTTP_CODE"] = $arCurl["CODE"];
                    $arLog["STATUS"] = $stLog;
                    $arStatus["LOG_GLOBALEFFECTS"][] = $arLog;

                    ESUtils::SaveOption("status-run", array(
                        "ID" => "globaleffects.ru",
                        "URL" => $url,
                        "CNT" => $ind . " / " . $cnt,
                    ));
                }
            }
        }

        ESUtils::SaveOption("status-run", array(
            "ID" => "globaleffects.ru",
            "URL" => '',
            "CNT" => '...',
        ));

        //self::sendPrices('globaleffects.ru');
    }

	/*Showatelier*/

    public static function ShowatelierAdd() {
		sendAlarmTG('🏁 /bitrix/modules/energosoft.utils/classes/general/es-parser.php. Запускается Showatelier Add');

        \Bitrix\Main\Loader::IncludeModule("highloadblock");
        $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getById(2)->fetch();
        $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
        $stEntityDataClass = $entity->getDataClass();
        $rsEntityDataClass = $stEntityDataClass::getList(array(
            'select' => array('*'),
            'order' => array('ID' => 'ASC'),
            'filter' => array(),
        ));
        $arProducer = array();
        while ($arEntityDataClass = $rsEntityDataClass->fetch()) $arProducer[] = $arEntityDataClass;

        $server = 'https://showatelier.ru/';
        $server2 = 'http://showatelier.ru/';
        $server3 = 'https://www.showatelier.ru/';
        $server4 = 'http://www.showatelier.ru/';

        $url = 'https://showatelier.ru/katalog/';

        for ($i = 1; $i <= 100; $i++) {
            $page = $url . '?page=' . $i;
            $arCurl = ESUtils::CurlGet($page);

            if ($arCurl["CODE"] == 200) {
				
                $searchPage = str_replace(array("\n", "\r", "\t"), "", $arCurl["DATA"]);
                $searchPage = preg_replace('/<!---.*?--->/ui', "", $searchPage);

                $arCats = array();
                $arProducts = array();

                preg_match_all("#<div class=\"item_name\">(.*?)<\/div>#im", $searchPage, $arr);
                foreach ($arr[1] as $item) {
                    preg_match_all("#<a href=\"katalog(.*?)\"#im", $item, $arr);

                    $tovar = $arr[1][0];
                    if (!empty($tovar)) $tovar = 'katalog' . $tovar;

                    $arProducts[] = $tovar;
                }
            }

            $arProducts = array_unique($arProducts);
            foreach ($arProducts as $product) {

                $link = $server . $product;
                $link2 = $server2 . $product;
                $link3 = $server3 . $product;
                $link4 = $server4 . $product;

                $get = ESUtils::CurlGet($link);
                if ($arCurl["CODE"] == 200) {

                    $link_http = trim(str_replace('https://', '', $link), '/');

                    $searchPage = str_replace(array("\n", "\r", "\t"), "", $get["DATA"]);
                    $searchPage = preg_replace('/<!---.*?--->/ui', "", $searchPage);

                    //name
                    preg_match_all("#<div class=\"product_name\">(.*?)<\/div>#im", $searchPage, $arName);
                    $name = trim($arName[1][0]);

                    // brand
                    $arBrand = array();
                    preg_match_all("/<div class=\"product_brand\">.*?<a href=\".*?\" title=\".*?\">(.*?)<\/a>.*?<\/div>/im", $searchPage, $arBrand);
                    $brand = CUtil::translit($arBrand[1][0], "ru");
                    $brand = trim($brand);
                    $brand = ToLower($brand);

                    // article
                    $arArticle = array();
                    preg_match_all("/<div class=\"product_artikul\">.*?<span>(.*?)<\/span>.*?<\/div>/im", $searchPage, $arArticle);
                    $article = trim($arName[1][0]);

                    // price
                    $arPrice = array();
                    preg_match_all("/<div class=\"current_price\">.*?([ 0-9,.]+).*?<\/div>/im", $searchPage, $arPrice);
                    $price = $arPrice[1][0];
                    $price = str_replace(",", ".", $price);
                    $price = str_replace(" ", "", $price);
                    $price = intval(preg_replace('/[^0-9,.]/', '', $price));

                    // preview_text
                    $arPreview = array();
                    preg_match_all('#<div class="product_desc">(.*?)</div>#ui', $searchPage, $arPreview);
                    $text = $arPreview[1][0];
                    $text = strip_tags($text);
                    $text = trim($text);

                    // pictures
                    $arPictures = array();
                    preg_match_all('#<a data-fancybox="slides".*?href="(.*?)">#ui', $searchPage, $arPictures);
                    $image = $arPictures[1][0];
                    if (!empty($image)) $image = 'https://showatelier.ru' . $image;

                    $obElement = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 32, 'PROPERTY_UPLOADED_FROM_PAGE' => '%'.$link_http.'%'), false, false, array('ID', 'NAME', 'ACTIVE', 'IBLOCK_ID', 'DETAIL_PICTURE', 'PROPERTY_UPLOADED_FROM_PAGE'));
                    $num = $obElement->SelectedRowsCount();
                    if ($num == 0 && !empty($name)) {
                        //Добавляем
                        $el = new CIBlockElement;

                        $PROPS = array(
                            "UPLOADED_FROM_PAGE" => $link,
                            "UPLOADED_PHOTO" => $image
                        );

                        $CODE = CUtil::translit(ESUtils::Transliterator($name), "ru", array("replace_space" => "-", "replace_other" => "-"));

                        $arFields = array(
                            "MODIFIED_BY" => 1, // элемент изменен текущим пользователем
                            "IBLOCK_SECTION_ID" => 3535,
                            "IBLOCK_ID" => 32,
                            "PROPERTY_VALUES" => $PROPS,
                            "NAME" => $name,
                            "CODE" => $CODE,
                            "ACTIVE" => "N",
                            "DETAIL_TEXT" => $text
                        );

                        if (!empty($image)) {
                            $arFields['PREVIEW_PICTURE'] = $arFields['DETAIL_PICTURE'] = CFile::MakeFileArray($image);
                        }

                        if ($PRODUCT_ID = $el->Add($arFields)) {
                            echo "New ID: " . $PRODUCT_ID . "<br>";

                            CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "CML2_ARTICLE", $article);
                        }

                        //BRAND
                        $brandFind = false;
                        foreach ($arProducer as $arItemBrand) {
                            if (ToLower(trim($arItemBrand["UF_XML_ID"])) == $brand) {
                                CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "MANUFACTURER", $arItemBrand["UF_XML_ID"]);
                                $brandFind = true;
                                break;
                            }
                        }
                        if (!$brandFind && $brand != "") {
                            $arAddMan = array(
                                "UF_NAME" => $arBrand[1][0],
                                "UF_SORT" => 500,
                                "UF_XML_ID" => $brand,
                                "UF_DEF" => 0,
                            );
                            $res = $stEntityDataClass::add($arAddMan);
                            if ($res->isSuccess()) {
                                CIBlockElement::SetPropertyValueCode($PRODUCT_ID, "MANUFACTURER", $brand);
                                $arProducer[] = $arAddMan;
                            }
                        }

                    } else {
                        $arItem = $obElement->Fetch();
                        $PRODUCT_ID = $arItem['ID'];
                        echo "UPDATE: " . $PRODUCT_ID . "<br>";
                    }

                    //Цену
                    if (!empty($price)) {
                        CPrice::SetBasePrice($PRODUCT_ID, $price, 'RUB');
                    }
                }

                //break;
            }
        }
    }
	
	public static function Showatelier(&$arStatus) {
		sendAlarmTG('🏁 /bitrix/modules/energosoft.utils/classes/general/es-parser.php. Запускается Showatelier Update');
		
        $el = new CIBlockElement;
        $arStatus["LOG_SHOWATELIER"] = array();
		
		$errorStatusElements = [];

        \Bitrix\Main\Loader::IncludeModule("highloadblock");
        $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getById(2)->fetch();
        $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
        $stEntityDataClass = $entity->getDataClass();
        $rsEntityDataClass = $stEntityDataClass::getList(array(
            'select' => array('*'),
            'order' => array('ID' => 'ASC'),
            'filter' => array(),
        ));
        $arProducer = array();
        while ($arEntityDataClass = $rsEntityDataClass->fetch()) $arProducer[] = $arEntityDataClass;

        $ind = 0;
        $obElement = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 32, 'PROPERTY_UPLOADED_FROM_PAGE' => '%showatelier.ru%'), false, false, array('ID', 'NAME', 'ACTIVE', 'XML_ID', 'IBLOCK_ID', 'DETAIL_PICTURE', 'PROPERTY_UPLOADED_FROM_PAGE', 'CATALOG_GROUP_1', 'PROPERTY_CML2_ARTICLE', 'PROPERTY_UPDATE_DETAIL_TEXT_STATUS', 'PROPERTY_UPDATE_PREVIEW_TEXT_STATUS', 'PROPERTY_PRICE_FROZEN'));
        while ($arItem = $obElement->Fetch()) {
            $ind++;
            $url = $arItem['PROPERTY_UPLOADED_FROM_PAGE_VALUE'];
			
			if ($arItem['PROPERTY_PRICE_FROZEN_VALUE'] !== null) {
				continue;
			}			

            $arCurl = ESUtils::CurlGet($url);
            if ($arCurl["CODE"] == 200) {
				
                $searchPage = str_replace(array("\n", "\r", "\t"), "", $arCurl["DATA"]);
                $searchPage = preg_replace('/<!---.*?--->/ui', "", $searchPage);

                /*// brand
                $arBrand = array();
                preg_match_all("/<div class=\"product_brand\">.*?<a href=\".*?\" title=\".*?\">(.*?)<\/a>.*?<\/div>/im", $searchPage, $arBrand);

                // article
                $arArticle = array();
                preg_match_all("/<div class=\"product_artikul\">.*?<span>(.*?)<\/span>.*?<\/div>/im", $searchPage, $arArticle);*/

                // price
                $arPrice = array();
                preg_match_all("/<div class=\"current_price\">.*?([ 0-9,.]+).*?<\/div>/im", $searchPage, $arPrice);
                $arPrice[1][0] = str_replace(",", ".", $arPrice[1][0]);
                $arPrice[1][0] = str_replace(" ", "", $arPrice[1][0]);

                /*// preview_text
                $arPreview = array();
                preg_match_all('#<div class="product_desc">(.*?)</div>#ui', $searchPage, $arPreview);
                $arPreview[1][0] = strip_tags($arPreview[1][0]);
                $arPreview[1][0] = trim($arPreview[1][0]);

                // detail_text
				$arDetail = array();
				preg_match_all('#<div class="product_tab_view">(.*?)</div>#ui', $searchPage, $arDetail);
				$arDetail[1][0] = trim($arDetail[1][0]);
				$arDetail[1][0] = preg_replace('/<a.*?\/a>/ui', "", $arDetail[1][0]);
				$arDetail[1][0] = preg_replace('/<div.*?>/ui', "", $arDetail[1][0]);
				$arDetail[1][0] = preg_replace('/<iframe.*?\/iframe>/ui', "", $arDetail[1][0]);
				$arDetail[1][0] = preg_replace('/Подробности на сайте - /ui', "", $arDetail[1][0]);
				$arDetail[1][0] = trim($arDetail[1][0]);

                // pictures
                $arPictures = array();
                preg_match_all('#<a data-fancybox="slides".*?href="(.*?)">#ui', $searchPage, $arPictures);

                $arImg = self::MakeFileArray("https://showatelier.ru" . $arPictures[1][0]);
                $arImg["del"] = "Y";
                unset($arPictures[1][0]);

                $arFields = array(
                    "DETAIL_PICTURE" => $arImg
                );

                if (!$arItem['PROPERTY_UPDATE_DETAIL_TEXT_STATUS_VALUE'] && $arItem['PROPERTY_UPDATE_DETAIL_TEXT_STATUS_VALUE'] <> 'да') {
                    $arFields['DETAIL_TEXT'] = html_entity_decode($arDetail[1][0]);
                    $arFields['DETAIL_TEXT_TYPE'] = 'html';
                }

                if (!$arItem['PROPERTY_UPDATE_PREVIEW_TEXT_STATUS_VALUE']){
                    $arFields['PREVIEW_TEXT'] = html_entity_decode($arPreview[1][0]);
                    $arFields['PREVIEW_TEXT_TYPE'] = 'text';
                }*/

                //$el->Update($arItem["ID"], $arFields, false, true, true); // vremenno ubrali vse obnovleniya krome cen i kol-va

                /*$brand = CUtil::translit($arBrand[1][0], "ru");
                $brand = trim($brand);
                $brand = ToLower($brand);
                $brandFind = false;
                foreach ($arProducer as $arItemBrand) {
                    if (ToLower(trim($arItemBrand["UF_XML_ID"])) == $brand) {
                        CIBlockElement::SetPropertyValueCode($arItem["ID"], "MANUFACTURER", $arItemBrand["UF_XML_ID"]);
                        $brandFind = true;
                        break;
                    }
                }
                if (!$brandFind && $brand != "") {
                    $arAddMan = array(
                        "UF_NAME" => $arBrand[1][0],
                        "UF_SORT" => 500,
                        "UF_XML_ID" => $brand,
                        "UF_DEF" => 0,
                    );
                    $res = $stEntityDataClass::add($arAddMan);
                    if ($res->isSuccess()) {
                        CIBlockElement::SetPropertyValueCode($arItem["ID"], "MANUFACTURER", $brand);
                        $arProducer[] = $arAddMan;
                    }
                }

                CIBlockElement::SetPropertyValueCode($arItem["ID"], "CML2_ARTICLE", $arArticle[1][0]);

                $arFiles = array();
                foreach ($arPictures[1] as $src) {
                    $arFiles[] = self::MakeFileArray("https://showatelier.ru" . $src);
                }
                $rsMultiple = CIBlockElement::GetProperty(32, $arItem["ID"], "sort", "asc", array("CODE" => "MORE_PHOTO"));
                while ($pp = $rsMultiple->GetNext()) $arFiles[$pp["PROPERTY_VALUE_ID"]] = array("VALUE" => array("del" => "Y"));
                CIBlockElement::SetPropertyValueCode($arItem["ID"], "MORE_PHOTO", $arFiles);*/

                CPrice::SetBasePrice($arItem["ID"], floatval($arPrice[1][0]), 'RUB');

                $arLog = array();
                $arLog["DATE"] = time();
                $arLog["URL"] = $url;
                $arLog["HTTP_CODE"] = $arCurl["CODE"];
                $arLog["STATUS"] = "Q:0, P:" . floatval($arPrice[1][0]);
                $arStatus["LOG_SHOWATELIER"][] = $arLog;

                // self::comparePrices($arItem['ID'], $arItem['NAME'], $arItem['PROPERTY_UPLOADED_FROM_PAGE_VALUE'], $arItem['CATALOG_PRICE_1'], floatval($arPrice[1][0]), $arItem['PROPERTY_CML2_ARTICLE_VALUE']);
				
            } else { // deactivate non 200

				if ($arItem['ACTIVE'] == 'Y') {
					$errorStatusElements[] = $arItem['NAME']. ' - '. $arItem['PROPERTY_UPLOADED_FROM_PAGE_VALUE']. ': status '. $arCurl['CODE'];
				}
				$el->Update($arItem['ID'], ['ACTIVE' => 'N']);		
				
			}

            if (!empty($errorStatusElements)) {

				ESUtils::SaveOption("errors-page", array(
					"ID" => "Showatelier",
					"PAGE" => $errorStatusElements,
				));

            }

            self::updateMinMaxPrices($arItem['ID']);

            ESUtils::SaveOption("status-run", array(
                "ID" => "showatelier.ru",
                "URL" => $url,
                "CNT" => $ind . " / " . $obElement->SelectedRowsCount(),
            ));
        }

        ESUtils::SaveOption("status-run", array(
            "ID" => "showatelier.ru",
            "URL" => '',
            "CNT" => '...',
        ));

        // self::sendPrices('showatelier.ru');
    }	
	
    

    // Calc
    public static function Calc() {
		
        $arElements = array();
        $obElements = CIBlockElement::GetList(array("ID" => "ASC"), array("IBLOCK_ID" => 32, "ACTIVE" => "Y"), false, false, array("ID", "CATALOG_TYPE"));
        while ($arItem = $obElements->Fetch()) $arElements[] = $arItem;

        foreach ($arElements as $arElement) {
            //Для обычных товаров
            if ($arElement["CATALOG_TYPE"] == 1) {
                $isExist = false;
                $rsStore = CCatalogStoreProduct::GetList(array("ID" => "ASC"), array("STORE_ID" => array(5, 6, 7), "PRODUCT_ID" => $arElement["ID"]), false, false, array("PRODUCT_ID", "STORE_ID", "AMOUNT"));
                while ($arStore = $rsStore->Fetch()) {
                    if (intval($arStore["AMOUNT"]) > 0) {
                        $isExist = true;
                        break;
                    }
                }
                if ($isExist)
                    CIBlockElement::SetPropertyValueCode($arElement["ID"], "ES_EXIST", 642);
                else
                    CIBlockElement::SetPropertyValueCode($arElement["ID"], "ES_EXIST", false);
            }
            //Для торговых предложений
            if ($arElement["CATALOG_TYPE"] == 3) {
                $arOffers = array();
                $rsOffers = CIBlockElement::GetList(array("ID" => "ASC"), array("IBLOCK_ID" => 33, "PROPERTY_CML2_LINK" => $arElement["ID"]), false, false, array("ID"));
                while ($arItem = $rsOffers->GetNext()) $arOffers[] = $arItem;

                $isExist = false;
                foreach ($arOffers as $arOffer) {
                    $rsStore = CCatalogStoreProduct::GetList(array("ID" => "ASC"), array("STORE_ID" => array(5, 6), "PRODUCT_ID" => $arOffer["ID"]), false, false, array("PRODUCT_ID", "STORE_ID", "AMOUNT"));
                    while ($arStore = $rsStore->Fetch()) {
                        if (intval($arStore["AMOUNT"]) > 0) {
                            $isExist = true;
                            break;
                        }
                    }
                }
                if ($isExist)
                    CIBlockElement::SetPropertyValueCode($arElement["ID"], "ES_EXIST", 642);
                else
                    CIBlockElement::SetPropertyValueCode($arElement["ID"], "ES_EXIST", false);
            }
        }
    }	
	
	/*helpers*/

    protected static function getPropCodeByName($propName) {
		
        $propName = trim($propName);

        $propCode = trim(ToUpper(CUtil::translit(ESUtils::Transliterator($propName), 'ru', [
            'replace_space' => '_',
            'replace_other' => '_',
        ])), '_');

        if (strlen($propCode) > 49) {
            $propCode = substr($propCode, 0, 49);
        }

        $firstChar = substr($propCode, 0, 1);

        if ($firstChar == '0' || (int)$firstChar > 0) {
            $propCode = 'F' . $propCode;
        }

        $arPropResult = CIBlockProperty::GetList([
            'id' => 'desc',
        ], [
            'IBLOCK_ID' => ID_IBLOCK_CATALOG,
            'NAME' => $propName,
        ]);

        $arPropCount = $arPropResult->SelectedRowsCount();

        if ($arPropCount >= 2) {
            $lastPropIndex = $arPropCount - 1;

            for ($i = 0; $arProp = $arPropResult->Fetch(); ++$i) {
                if ($lastPropIndex === $i) {
                    // Update CODE for the last property
                    $property = new CIBlockProperty();
                    $property->Update($arProp['ID'], [
                        'CODE' => $propCode,
                    ]);
                } else {
                    CIBlockProperty::Delete($arProp['ID']);
                }
            }
        }

        $arProp = CIBlockProperty::GetList([], [
            'IBLOCK_ID' => ID_IBLOCK_CATALOG,
            'CODE' => $propCode,
        ])->Fetch();

        if ($arProp['ID'] > 0) {
            return $arProp['CODE'];
        }

        if (strlen($propCode) <= 1) {
            return false;
        }

        $arPropFields = [
            'NAME' => $propName,
            'ACTIVE' => 'Y',
            'SORT' => 15000,
            'CODE' => $propCode,
            'PROPERTY_TYPE' => 'S',
            'IBLOCK_ID' => ID_IBLOCK_CATALOG,
        ];

        $property = new CIBlockProperty();
        $arPropId = $property->Add($arPropFields);

        PropertyFeature::setFeatures($arPropId, [[
            'MODULE_ID' => 'iblock',
            'IS_ENABLED' => 'Y',
            'FEATURE_ID' => 'DETAIL_PAGE_SHOW',
        ]]);

        return $propCode;
    }

    protected static function cleanProperties($productId, $propertyCodes) {
		
        $productProperties = CIBlockProperty::GetList([
            'sort' => 'desc',
        ], [
            'ACTIVE' => 'Y',
            'IBLOCK_ID' => ID_IBLOCK_CATALOG,
        ]);
		
		$propTypeUnset = ['UPDATE_PREVIEW_TEXT_STATUS', 'UPDATE_DETAIL_TEXT_STATUS', 'NOUPDATEPHOTO'];

        while ($arProp = $productProperties->Fetch()) {
            if ($arProp['SORT'] > 15000) {
                continue;
            }

            $propCode = $arProp['CODE'];

            if (!in_array($propCode, $propertyCodes) && !in_array($propCode, $propTypeUnset)) {
                $propValue = CIBlockElement::GetProperty(ID_IBLOCK_CATALOG, $productId, 'sort', 'desc', [
                    'CODE' => $propCode,
                ])->Fetch();

                if ($propValue && $propValue['VALUE']) {
                    CIBlockElement::SetPropertyValueCode($productId, $propCode, '');
                }
            }

            if ($arProp['SORT'] < 15000) {
                break;
            }
        }
    }

    protected static function comparePrices($id, $name, $uploadedFrom, $oldPrice = null, $newPrice = null, $article = null) {
		
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
        } elseif ($uploadedFrom) {
            $arFilter['PROPERTY_UPLOADED_FROM_PAGE'] = $uploadedFrom;
        } else {
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
        } else {
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

    protected static function updateMinMaxPrices($id) {
		
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

		$minPrice = $minPrice == 0 ? '' : number_format($minPrice, 2, '.', ''); 
		$maxPrice = $maxPrice == 0 ? '' : number_format($maxPrice, 2, '.', '');

        CIBlockElement::SetPropertyValueCode($id, 'MINIMUM_PRICE', $minPrice);
        CIBlockElement::SetPropertyValueCode($id, 'MAXIMUM_PRICE', $maxPrice);
    }

    public static function sendPrices($parserDomain = '') {
		
        $isMonday = (int)date('N') === 1;
        $isBeforeMidday = date('a') === 'am';

        if (!$isMonday || !$isBeforeMidday) {
            return;
        }

        global $DB;

        $subject = '[Обновление цен] ';

        if ($parserDomain) {
            $subject .= $parserDomain;
        } else {
            $subject .= 'USTAGE GROUP';
        }

        $body = '<style>
        .table {
            display: table;
            max-width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            border: 0;
        }

        .table__td,
        .table__th {
            padding: 2px 8px;
            text-align: left;
            border: 1px solid #e7e7e8;
        }

        .table__th {
            font-weight: 500;
            text-align: center;
        }
        </style>';

        $body .= '<table class="table">';
        $body .= '<thead>';

        $body .= '<tr>';
        $body .= '<th class="table__th">№</th>';
        $body .= '<th class="table__th">Название</th>';
        $body .= '<th class="table__th">Артикул</th>';
        $body .= '<th class="table__th">Предыдущая цена</th>';
        $body .= '<th class="table__th">Текущая цена</th>';
        $body .= '</tr>';

        $body .= '</thead>';
        $body .= '<tbody>';

        $arFilter = [
            'IBLOCK_ID' => 59,
        ];

        if ($parserDomain) {
            $arFilter['PROPERTY_UPLOADED_FROM_PAGE'] = '%' . $parserDomain . '%';
        }

        $obElement = CIBlockElement::GetList([
            'name' => 'asc'
        ], $arFilter, false, false, [
            'ID',
            'NAME',
            'PROPERTY_UPLOADED_FROM_PAGE',
            'PROPERTY_CML2_ARTICLE',
            'PROPERTY_OLD_PRICE',
            'PROPERTY_NEW_PRICE',
        ]);

        $number = 0;

        while ($arItem = $obElement->Fetch()) {
            $body .= '<tr>';
            $body .= '<td class="table__td">' . ++$number . '</td>';

            if ($arItem['PROPERTY_UPLOADED_FROM_PAGE_VALUE']) {
                $body .= '<td class="table__td"><a href="' . $arItem['PROPERTY_UPLOADED_FROM_PAGE_VALUE'] . '" target="_blank" rel="noopener">' . $arItem['NAME'] . '</a></td>';
            } else {
                $body .= '<td class="table__td">' . $arItem['NAME'] . '</td>';
            }

            $body .= '<td class="table__td">' . $arItem['PROPERTY_CML2_ARTICLE_VALUE'] . '</td>';
            $body .= '<td class="table__td">' . $arItem['PROPERTY_OLD_PRICE_VALUE'] . '</td>';
            $body .= '<td class="table__td">' . $arItem['PROPERTY_NEW_PRICE_VALUE'] . '</td>';
            $body .= '</tr>';

            $DB->StartTransaction();

            if (!CIBlockElement::Delete($arItem['ID'])) {
                $DB->Rollback();
            } else {
                $DB->Commit();
            }
        }

        $body .= '</tbody>';
        $body .= '</table>';

        $mail = new PHPMailer();

        $mail->setLanguage('ru');

        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        $mail->setFrom('sale@ustage-group.ru', 'USTAGE GROUP');

        $mail->addBCC('diz55@mail.ru');

        $mail->addAddress('kunicina@ustage-group.ru');
        $mail->addAddress('zubareva@ustage-group.ru');

        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPDebug = 0;

        $mail->Host = 'ssl://smtp.yandex.ru';
        $mail->Port = 465;

        $mail->Username = 'sale@ustage-group.ru';
        $mail->Password = 'zetfhmyvzmmjzuln';

        $mail->isHTML(true);

        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
    }	

    public static function MakeFileArray($image) {
		
        if (empty($image)) {
            return false;
        }

        $pathInfo = pathinfo($image);
        $extension = strtolower($pathInfo['extension']);

        do {
            $filename = 'tmp. ' . md5(mt_rand());
            $cachedImagePath = BX_TEMPORARY_FILES_DIRECTORY . DIRECTORY_SEPARATOR . $filename;

            if ($extension) {
                $cachedImagePath .= '.' . $extension;
            }
        } while (file_exists($cachedImagePath));

        $response = file_get_contents($image, false, stream_context_create([
            'http' => [
                'ignore_errors' => true,
            ],
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ]));

        if (!$response) {
            return false;
        }

        file_put_contents($cachedImagePath, $response);

        self::$cachedImages[] = $cachedImagePath;

        return CFile::MakeFileArray($cachedImagePath);
    }

    public static function cleanCachedImages() {
		
        foreach (self::$cachedImages as $imagePath) {
            if (!file_exists($imagePath)) {
                continue;
            }

            unlink($imagePath);
        }

        self::$cachedImages = [];
    }	

    public static function run($methodName, &$arStatus) {
		
        try {
            forward_static_call([__CLASS__, $methodName], $arStatus);
        } catch (Exception $exception) {
            echo $exception->getMessage();
            return false;
        }

        return true;
    }

    public static function priceListColumns($f, $headerRow) {
		
        $arColumns = array();

        if (file_exists($f)) {
            $row = 0;
            $handle = fopen($f, "r");
            while (($arRow = fgetcsv($handle, 10000, ";")) !== false) {
                if ($row == $headerRow) {
                    $arColumns = $arRow;
                    break;
                }

                $row++;
            }
            fclose($handle);
        }
        return $arColumns;
    }	

    public static function clean($directory = null, $maxFileLifetime = 86400) { 
	
        if (!defined('BX_TEMPORARY_FILES_DIRECTORY') || !BX_TEMPORARY_FILES_DIRECTORY) {
            return false;
        }

        if ($directory === null) {
            $directory = BX_TEMPORARY_FILES_DIRECTORY;
        }

        if (strpos($directory, BX_TEMPORARY_FILES_DIRECTORY) !== 0) {
            return false;
        }

        $files = scandir($directory);
        $time = time();

        foreach ($files as $value) {
            $path = realpath($directory . DIRECTORY_SEPARATOR . $value);

            if ($value === '.' || $value === '..') {
                continue;
            }

            if (is_dir($path)) {
                self::clean($path, $maxFileLifetime);

                $subDirFiles = scandir($path);
                $isSubDirEmpty = true;

                foreach ($subDirFiles as $subDirValue) {
                    if ($subDirValue !== '.' && $subDirValue !== '..') {
                        $isSubDirEmpty = false;
                        break;
                    }
                }

                if ($isSubDirEmpty) {
                    rmdir($path);
                }

                continue;
            }

            $fileChangeTime = filectime($path);
            $fileLifetime = $time - $fileChangeTime;

            if ($fileLifetime >= $maxFileLifetime) {
                unlink($path);

                echo $path . '<br>';
            }
        }

        return true;
    }
	
	
    public static function nameClear($name) {
		
        $name = str_replace(array('(', ')', '[', ']'), '', $name);
        return $name;
    }

    public static function nameClearAll($name) {
		
        $arName = explode(",", $name);
        $name = trim($arName[0]);

        $arName = explode("(", $name);
        $name = trim($arName[0]);

        $arName = explode("[", $name);
        $name = trim($arName[0]);

        return $name;
    }

    public static function cleanResizeCache($directory = null) {
		
        if ($directory === null) {
            $directory = $_SERVER['DOCUMENT_ROOT'] . '/upload/resize_cache/iblock';
        }

        if (strpos($directory, $_SERVER['DOCUMENT_ROOT'] . '/upload/resize_cache/iblock') !== 0) {
            return false;
        }

        $files = scandir($directory);

        foreach ($files as $value) {
            $path = realpath($directory . DIRECTORY_SEPARATOR . $value);

            if ($value === '.' || $value === '..') {
                continue;
            }

            if (is_dir($path)) {
                self::cleanResizeCache($path);

                $subDirFiles = scandir($path);
                $isSubDirEmpty = true;

                foreach ($subDirFiles as $subDirValue) {
                    if ($subDirValue !== '.' && $subDirValue !== '..') {
                        $isSubDirEmpty = false;
                        break;
                    }
                }

                if ($isSubDirEmpty) {
                    rmdir($path);
                }

                continue;
            }

            if (filesize($path) === 0) {
                unlink($path);

                echo $path . '<br>';
            }
        }

        return true;
    }
	
    public static function iconvp($str, $reverse = false) {
		if (!$reverse) {
			return iconv("UTF-8", "CP1251", $str);
		} else {
			return iconv("CP1251", "UTF-8", $str);
		}
	}	


}



// Настройки телеграм-уведомления
defined('TG_BOT_TOKEN') || define('TG_BOT_TOKEN', '6603974711:AAHYfO7DaXj5qfbCw6GlV87iEKf80w7wL78');
defined('TG_API_URL') || define('TG_API_URL', 'https://api.telegram.org/bot' . TG_BOT_TOKEN . '/');
defined('TG_CHAT_ID') || define('TG_CHAT_ID', -4145833312); // Ustage-Group Log

if (!function_exists("sendAlarmTG")) {
    function sendAlarmTG($text) {
        try {
            $reply = urlencode(
                $text . 
                PHP_EOL
                // '$_SERVER[\'HTTP_X_FORWARDED_FOR\'] = ' . $_SERVER['HTTP_X_FORWARDED_FOR'] //. PHP_EOL .
                // '$_SERVER[\'REMOTE_ADDR\'] = ' . $_SERVER['REMOTE_ADDR']
            );
            $sendto = TG_API_URL . 'sendmessage?chat_id=' . TG_CHAT_ID . '&text=' . $reply;
            file_get_contents($sendto);
        } catch (Exception $e) {
            // nothing
        }
    }
}

if (!function_exists("sendFileTG")) {
    function sendFileTG($file_path, $url) {
        try {
            $arrayQuery = array(
                'chat_id' => TG_CHAT_ID,
                'caption' => 'Лог работы скрипта ' . $url,
                'document' => new \CURLFile($file_path)
            );      
            $ch = curl_init(TG_API_URL . 'sendDocument');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $arrayQuery);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
            $res = curl_exec($ch);
            curl_close($ch);
        } catch (Exception $e) {
            // nothing
        }
    }
}
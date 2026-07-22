<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/cookie_consent.php';

include $_SERVER["DOCUMENT_ROOT"] . "/bitrix/php_interface/include/b24/b24.php";

/* AddEventHandler("main", "OnEndBufferContent", "ChangeMyContent");

function ChangeMyContent(&$content) {
    $content = str_replace("Под заказ", "Уточняйте наличие", $content);
    return $content;
} */

use Bitrix\Sale\Internals\OrderPropsValueTable;

//AddEventHandler("sale", "OnOrderNewSendEmail", "bxModifySaleMails");
function bxModifySaleMails($orderID, &$eventName, &$arFields)
{
    $arOrder = CSaleOrder::GetByID($orderID);

	$phone = "";
	$email = "";
	$index = "";
	$country_name = "";
	$city_name = "";
	$address = "";

    $order_props = CSaleOrderPropsValue::GetOrderProps($orderID);
    while($arProps = $order_props->Fetch())
    {
        if($arProps["CODE"] == "PHONE") $phone = htmlspecialchars($arProps["VALUE"]);
        if($arProps["CODE"] == "EMAIL") $email = htmlspecialchars($arProps["VALUE"]);
        if($arProps["CODE"] == "FIO") $username = htmlspecialchars($arProps["VALUE"]);
        if($arProps["CODE"] == "LOCATION")
        {
            $arLocs = CSaleLocation::GetByID($arProps["VALUE"]);
            $country_name = $arLocs["COUNTRY_NAME_ORIG"];
            $city_name = $arLocs["CITY_NAME_ORIG"];
        }
        if($arProps["CODE"] == "INDEX") $index = $arProps["VALUE"];
        if($arProps["CODE"] == "ADDRESS") $address = $arProps["VALUE"];
    }

    $full_address = $index.", ".$country_name."-".$city_name.", ".$address;

    $arDeliv = CSaleDelivery::GetByID($arOrder["DELIVERY_ID"]);
    $delivery_name = "";
    if($arDeliv) $delivery_name = $arDeliv["NAME"];

    $arPaySystem = CSalePaySystem::GetByID($arOrder["PAY_SYSTEM_ID"]);
    $pay_system_name = "";
    if($arPaySystem) $pay_system_name = $arPaySystem["NAME"];

    $arPersType = CSalePersonType::GetByID($arOrder["PERSON_TYPE_ID"]);

    $orderProps = OrderPropsValueTable::getList([
      'filter' => [
        'ORDER_ID' => $orderID,
      ],
    ]);

    $bonusCardNumber = '';
    $giftCardNumber = '';

    while ($orderProp = $orderProps->fetch()) {
      if ($orderProp['CODE'] === 'BONUS_CARD_NUMBER') {
        $bonusCardNumber = $orderProp['VALUE'];
      }

      if ($orderProp['CODE'] === 'GIFT_CARD_NUMBER') {
        $giftCardNumber = $orderProp['VALUE'];
      }
    }

    $arFields["ORDER_DESCRIPTION"] = $arOrder["USER_DESCRIPTION"];
    $arFields["USER_NAME"] = $username;	
    $arFields["PHONE"] = $phone;
    if (!empty($email)) $arFields["EMAIL"] = $email;
    $arFields["DELIVERY_NAME"] = $delivery_name;
    $arFields["PAY_SYSTEM_NAME"] = $pay_system_name;
    $arFields["FULL_ADDRESS"] = $full_address;
    $arFields["PERSON_TYPE"] = $arPersType["NAME"];
    $arFields["BONUS_CARD_NUMBER"] = $bonusCardNumber;
    $arFields["GIFT_CARD_NUMBER"] = $giftCardNumber;
    $arFields["LAST_USER_PAGE_URL"] = $_SERVER['HTTP_REFERER'];

    $arFields["ORDER_ID"] = $orderID;

	CModule::IncludeModule("energosoft.utils");
	CModule::IncludeModule('highloadblock');

	$arHLColors = array();
	$arHLBlock = Bitrix\Highloadblock\HighloadBlockTable::getById(1)->fetch();
	$obEntity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
	$strEntityDataClass = $obEntity->getDataClass();
	$rsData = $strEntityDataClass::getList(array('select'=>array('ID','UF_NAME','UF_XML_ID'),'order'=>array('ID'=>'ASC')));
	while($arItem = $rsData->Fetch()) $arHLColors[$arItem["UF_XML_ID"]] = $arItem;

	$strOrderList = "";
	$baseLangCurrency = \CSaleLang::GetLangCurrency(SITE_ID);

	$arBasket = array();
	$dbBasketTmp = \CSaleBasket::GetList(
		array("SET_PARENT_ID" => "DESC", "TYPE" => "DESC", "NAME" => "ASC"),
		array("ORDER_ID" => $orderID),
		false,
		false,
		array("ID", "PRODUCT_ID", "PRICE", "QUANTITY", "NAME", "MEASURE_NAME")
	);
	while($arBasketTmp = $dbBasketTmp->GetNext()) $arBasket[] = $arBasketTmp;

	$sumPrice = 0;
	foreach($arBasket as $val)
	{
		$arProp = array();
		$arProduct = ESIBlock::GetByID($val["PRODUCT_ID"]);
		if($arHLColors[$arProduct["PROPERTIES"]["COLOR"]["VALUE"]]["UF_NAME"] != "")
		{
			$arProp[] = $arProduct["PROPERTIES"]["COLOR"]["NAME"].": ".$arHLColors[$arProduct["PROPERTIES"]["COLOR"]["VALUE"]]["UF_NAME"];
		}
		if($arProduct["PROPERTIES"]["SIZE"]["VALUE_ENUM"] != "")
		{
			$arProp[] = $arProduct["PROPERTIES"]["SIZE"]["NAME"].": ".$arProduct["PROPERTIES"]["SIZE"]["VALUE_ENUM"];
		}

		$strProps = "";
		if(count($arProp) > 0) $strProps = " (".implode(", ", $arProp).")";

		$strOrderList .= $val["NAME"] . $strProps . " - " . $val["QUANTITY"] . " " . $val["MEASURE_NAME"] . " x " . SaleFormatCurrency($val["PRICE"], $baseLangCurrency);
		$strOrderList .= "<br/>";
		
		$sumPrice += $val["PRICE"]*$val["QUANTITY"];
	}
	$arFields["ORDER_LIST"] = $strOrderList;
	$arFields["PRICE"] = $sumPrice;
	$arFields["ORDER_DATE"] = date('d.m.Y');
}

include 'crm.php';


function clearBXCache() {
	
	BXClearCache(true);
	 
	if (class_exists('\Bitrix\Main\Data\ManagedCache')) {
		(new \Bitrix\Main\Data\ManagedCache())->cleanAll();
		echo 'clear ManagedCache';
	}
	 
	if (class_exists('\CStackCacheManager')) {
		(new \CStackCacheManager())->CleanAll();
		echo 'clear CStackCache';
	}
	 
	if (class_exists('\Bitrix\Main\Data\StaticHtmlCache')) {
		\Bitrix\Main\Data\StaticHtmlCache::getInstance()->deleteAll();
		echo 'clear StaticHtmlCache';
	}

	\Bitrix\Main\Data\CacheEngineFiles::delayedDelete(1000);

	mail('e.mihaltsova@altera-media.com', 'ustage clear cache', 'ustage clear cache'); 
	
	return "clearBXCache();"; 
	
}

AddEventHandler('main', 'OnEpilog', array('SeoHandlers', 'OnEpilogHandler'));
class SeoHandlers {
	
	public static function checkSmartFilterLink($props, $section=[]) {
		
		$filterLink = 'filter/'.strtolower($props["CODE"]).'-is-'.(!empty($props["VALUE_XML_ID"]) ? $props["VALUE_XML_ID"] : $props["VALUE"]).'/apply/';
		$sectionFilterUrl = $section["SECTION_PAGE_URL"].$filterLink;
		
		foreach ($section['PATH'] as $path) {
			
			$dbItem = \Bitrix\Iblock\Elements\ElementMetasmartTable::getList([
				'select' => ['ID', 'IBLOCK_ID', 'NAME', 'CODE', 'IBLOCK_SECTION_ID'],
				'filter' => [
					'IBLOCK_ID' => 66, 
					'ACTIVE' => 'Y',
					'=NAME' => $path['SECTION_PAGE_URL'].$filterLink,
				],
				'limit' => 1,
				'order' => ['SORT' => 'ASC'], 
				'cache' => ['ttl' => 3600]
			])->fetch();	
			if (!empty($dbItem['ID'])) {
				$sectionFilterUrl = $path['SECTION_PAGE_URL'].$filterLink;
				break;
			}
			
		}
		
		return $sectionFilterUrl;
		
	}

    public static function OnEpilogHandler() {
        global $APPLICATION; 

		if (!empty($_SERVER['QUERY_STRING'])) { 
		
			/*$queryStrAr = explode('&', $_SERVER['QUERY_STRING']);			
			if (preg_match("/\?PAGEN/i", $_SERVER['REQUEST_URI']) && is_array($queryStrAr) && count($queryStrAr) == 1 && !preg_match("/\/filter\//i", $_SERVER['REQUEST_URI'])) {			
				$APPLICATION->AddHeadString('<link rel="canonical" href="https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '">');				
			} else {			
				$APPLICATION->AddHeadString('<link rel="canonical" href="https://' . $_SERVER['HTTP_HOST'] . $APPLICATION->GetCurPage() . '">');
			}*/
			$APPLICATION->AddHeadString('<link rel="canonical" href="https://' . str_replace(':443', '', $_SERVER['HTTP_HOST']) . $APPLICATION->GetCurPage() . '">');
			
		} 
		
		if (preg_match("/\/filter\//i", $_SERVER['REQUEST_URI'])) {
			
			//$APPLICATION->AddHeadString('<link rel="canonical" href="https://' . $_SERVER['HTTP_HOST'] . $APPLICATION->GetCurPage() . '">');
			
			if (!empty($APPLICATION->GetPageProperty('SF_URL'))) {
			   
			   if (!empty($APPLICATION->GetPageProperty('SF_TITLE'))) {
				   $APPLICATION->SetPageProperty('title', $APPLICATION->GetPageProperty('SF_TITLE'));
			   }
			   if (!empty($APPLICATION->GetPageProperty('SF_DESCRIPTION'))) {
				   $APPLICATION->SetPageProperty('description', $APPLICATION->GetPageProperty('SF_DESCRIPTION'));
			   }
			    
			} else {
				
				if (
					empty($APPLICATION->GetPageProperty('smarty-brand')) || 
					( !empty($APPLICATION->GetPageProperty('smarty-brand')) && (
							 $APPLICATION->GetPageProperty('smarty-count-props') > 1 || 
							 $APPLICATION->GetPageProperty('smarty-count-brand') > 1)
					)					
				) {
					
					$APPLICATION->AddHeadString('<meta name="robots" content="noindex" />');
					
				}
				
				if (!empty($APPLICATION->GetPageProperty('smarty-brand'))) { 
					
					$APPLICATION->SetPageProperty('title', $APPLICATION->GetPageProperty('smarty-brand') .' купить в Санкт-Петербурге по низкой цене');
					$APPLICATION->SetPageProperty('description', $APPLICATION->GetPageProperty('smarty-brand') .' по низкой цене ✔Возможность бесплатного тестирования оборудования ✔Проектирование, монтаж и настройка ✔Бесплатная доставка ✔Собственный сервисный центр');
				
				} 
				
			}
			
			if (
				$APPLICATION->GetCurPage(false) === '/catalog/lampy-raznogo-tipa/filter/manufacturer-is-fotonlighting/apply/' ||
				$APPLICATION->GetCurPage(false) === '/catalog/lampy-raznogo-tipa/filter/manufacturer-is-osram/apply/' ||
				$APPLICATION->GetCurPage(false) === '/catalog/lampy-fary-par/filter/manufacturer-is-osram/apply/' ||
				$APPLICATION->GetCurPage(false) === '/catalog/lampy-fary-par/filter/manufacturer-is-ge/apply/'
			) {
				$APPLICATION->SetPageProperty('robots', 'noindex');
			}
			
		}
		
		
		if ($page = preg_grep("/PAGEN_(.*)/i", array_keys($_REQUEST))) {
			$page = intval($_REQUEST[reset($page)]);
			if ($page > 1) {
				
				//title
				$metaTitle = $APPLICATION->GetPageProperty('title');
				$APPLICATION->SetPageProperty('title', $metaTitle . '. | Страница ' . $page);
				
				//description
				$metaDescription = $APPLICATION->GetPageProperty('description');
				$APPLICATION->SetPageProperty('description', $metaDescription . '. | Страница ' . $page . '.');
				
			} 
		}
		
		$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
		$currentUri = new \Bitrix\Main\Web\Uri($request->getRequestUri());

		if ($currentUri->getPath() == '/product/' && empty($currentUri->getQuery())) {
			LocalRedirect('/catalog/', false, '301 Moved permanently');
		}
		
   }
   
	public static function mb_lcfirst($str) {
		$str = trim($str);
		return mb_strtolower(mb_substr($str, 0, 1)) . mb_substr($str, 1);
	}

	public static function mb_ucfirst($str) {
		$str = trim($str);
		return mb_strtoupper(mb_substr($str, 0, 1)) . mb_substr($str, 1);
	}
	
	/**/
	public static function getElementSection($elementID) { 
		
		$sectionId = false;
		
		$element = \Bitrix\Iblock\ElementTable::getList([
			'filter' => ['ID' => $elementID],
			'select' => ['ID', 'IBLOCK_ID', 'IBLOCK_SECTION_ID']
		])->fetch();
		if ($element) { 
			
			$sectionId = $element['IBLOCK_SECTION_ID'];

		} 
		
		return $sectionId;
		
	}
	
	
	public static function checkProductsForLinksInCart($elementID, $sectionId = 3621, $iblockId = 32, $count = 4) { 

		$products = [
			'SECTION' => [],
			'PARENT_SECTION' => [],
		];
		$prodIdFull = false;
		$prodIdUpFull = false;	
		$parentSectionId = false;

		/* from IB*/	
		$resPropSame = CIBlockElement::GetProperty($iblockId, $elementID, [], ['CODE' => 'SAME_PLINK']);
		while ($ob = $resPropSame->GetNext()) { 			
			if (!empty($ob['VALUE'])) { 
			
				$products['SECTION'][] = $ob['VALUE'];  
				$prodIdFull = true;
				
			}		
		} 		

		$resPropPersonal = CIBlockElement::GetProperty($iblockId, $elementID, [], ['CODE' => 'PERSONAL_PLINK']);
		while ($ob = $resPropPersonal->GetNext()) {		
			if (!empty($ob['VALUE'])) { 
			
				$products['PARENT_SECTION'][] = $ob['VALUE'];
				$prodIdUpFull = true;
				
			}			
		}	

		if (!$prodIdFull && !$prodIdUpFull) { 		
		
			$sections = [];
			$sectionsSub = [];
				
			$arPrice = CCatalogProduct::GetOptimalPrice($elementID);
			$price = !empty($arPrice['DISCOUNT_PRICE']) ? $arPrice['DISCOUNT_PRICE'] : 10000;			

			/*hierarchy*/
			$nav = CIBlockSection::GetNavChain($iblockId, $sectionId, ['ID', 'IBLOCK_SECTION_ID'], true);
			foreach ($nav as $navi) { 
				
				if ($navi['ID'] == $sectionId) {
					$parentSectionId = $navi['IBLOCK_SECTION_ID'];
				}
			
				if (!empty($navi['ID'])) {
					
					$sections[] = $navi['ID'];
					
					$subSections = CIBlockSection::GetList([], ['SECTION_ID' => $navi['ID'], 'ACTIVE' => 'Y'], false, ['ID']); 
					while ($arSub = $subSections->GetNext()) {
						$sectionsSub[$navi['ID']][] = $arSub['ID'];
					}
					
				}
			}
			$sections = array_reverse($sections); 	

			if (!$prodIdFull) {
				$products['SECTION'] = SeoHandlers::getProductsForLinksInCart($elementID, $sectionId, $sections, $sectionsSub, $price, [$elementID]);
			}
			
			if (!$prodIdUpFull) {
				
				$products['PARENT_SECTION'] = SeoHandlers::getProductsForLinksInCart($elementID, $parentSectionId, $sections, $sectionsSub, $price, $products['SECTION']);
				
				if (!empty($products['SECTION'])) {
					$products['PARENT_SECTION'] = array_diff($products['PARENT_SECTION'], $products['SECTION']);
				}
				
			}
		
		} 
		
		return $products;
		
	}
	
	public static function getProductsForLinksInCart($elementID, $sectionId, $sections, $sectionsSub, $price, $expID, $iblockId = 32, $count = 4) {
		
		$prodIds = [];
		if (!empty($expID)) {
			$expID = array_merge([$elementID], $expID);
		} else {
			$expID = [$elementID];
		}
		
		foreach ($sections as $section) { 			
			
			if (!empty($prodIds)) {				
				$expID = array_merge($expID, $prodIds);				
			}	
			
			$sectionList = [$section];		
			if (isset($sectionsSub[$section])) {
				$sectionList = array_merge($sectionList, $sectionsSub[$section]);
			} 
			$sectionList_ = implode(', ', $sectionList); 		
			
			if ($section == $sectionId) { /*current category*/

				/*one category*/
				$prodIdSql = SeoHandlers::sqlProductsForLinksInCart($section, $iblockId, $count, $price, $expID); /*avail*/
				if (!empty($prodIdSql)) { 
					$prodIds = array_merge($prodIds, $prodIdSql);
					$expID = array_merge($expID, $prodIds);
				}	
				
				if (empty($prodIds) || count($prodIds) < $count) {
					$prodIdSqlNoAvail = SeoHandlers::sqlProductsForLinksInCart($section, $iblockId, $count, $price, $expID, true); /*no avail*/					
					if (!empty($prodIdSqlNoAvail)) {
						$prodIds = array_merge($prodIds, $prodIdSqlNoAvail);
						$expID = array_merge($expID, $prodIdSqlNoAvail);
					}
				}
				
				/*category with sub*/
				if (count($sectionList) > 1) {
					if (empty($prodIds) || count($prodIds) < $count) {
						$prodIdSqlOther = SeoHandlers::sqlProductsForLinksInCart($sectionList_, $iblockId, $count, $price, $expID); /*avail*/					
						if (!empty($prodIdSqlOther)) {
							$prodIds = array_merge($prodIds, $prodIdSqlOther);
							$expID = array_merge($expID, $prodIdSqlOther);
						}
					}
					
					if (empty($prodIds) || count($prodIds) < $count) {
						$prodIdSqlOtherNoAvail = SeoHandlers::sqlProductsForLinksInCart($sectionList_, $iblockId, $count, $price, $expID, true); /*no avail*/						
						if (!empty($prodIdSqlOtherNoAvail)) {
							$prodIds = array_merge($prodIds, $prodIdSqlOtherNoAvail);
							$expID = array_merge($expID, $prodIdSqlOtherNoAvail);
						}
					}
				}
				
			} else { /*category from hierarchy*/		

				if (empty($prodIds) || count($prodIds) < $count) {
					$prodIdSqlOther = SeoHandlers::sqlProductsForLinksInCart($sectionList_, $iblockId, $count, $price, $expID);  /*avail*/
					if (!empty($prodIdSqlOther)) { 
						$prodIds = array_merge($prodIds, $prodIdSqlOther);
						$expID = array_merge($expID,  $prodIdSqlOther);
					}	
				}

				if (empty($prodIds) || count($prodIds) < $count) {
					$prodIdSqlOtherNoAvail = SeoHandlers::sqlProductsForLinksInCart($sectionList_, $iblockId, $count, $price, $expID, true); /*no avail*/
					if (!empty($prodIdSqlOtherNoAvail)) {
						$prodIds = array_merge($prodIds, $prodIdSqlOtherNoAvail);
						$expID = array_merge($expID,  $prodIdSqlOtherNoAvail);
					}	
				}				
				
			} 							
			
			if (!empty($prodIds) && count($prodIds) >= $count) {
				break;
			}		
			
		}	

		return $prodIds;
		
	}
	
	public static function sqlProductsForLinksInCart($sectionList_ = 3621, $iblockId = 32, $count = 2, $price, $expID, $unavailabale = false) {
		
		$prodIDs = [];
		
		$expID = implode(', ', $expID);
		
		$connection = \Bitrix\Main\Application::getConnection(); 
		
		$sql = "
			(
				SELECT b_iblock_element.ID
				FROM b_iblock_element
				INNER JOIN b_catalog_price
					ON b_iblock_element.ID = b_catalog_price.PRODUCT_ID
				INNER JOIN b_catalog_product
					ON b_iblock_element.ID = b_catalog_product.ID 
				WHERE b_iblock_element.ACTIVE='Y'
					AND IBLOCK_SECTION_ID IN (". $sectionList_ .")
					AND IBLOCK_ID = ". $iblockId ."
					AND b_catalog_price.PRICE > 0
					AND b_catalog_price.PRICE >= ". $price ."
					AND b_iblock_element.ID NOT IN (". $expID .")
					AND b_catalog_product.QUANTITY ".(!$unavailabale ? '>' : '=')." 0					
				ORDER BY b_catalog_price.PRICE ASC
				LIMIT ". $count/2 ."
			)
			UNION 
			(
				SELECT b_iblock_element.ID
				FROM b_iblock_element
				INNER JOIN b_catalog_price
					ON b_iblock_element.ID = b_catalog_price.PRODUCT_ID
				INNER JOIN b_catalog_product
					ON b_iblock_element.ID = b_catalog_product.ID 
				WHERE b_iblock_element.ACTIVE='Y'
					AND IBLOCK_SECTION_ID IN (". $sectionList_ .")
					AND IBLOCK_ID = ". $iblockId ."
					AND b_catalog_price.PRICE > 0
					AND b_catalog_price.PRICE <= ". $price ."
					AND b_iblock_element.ID NOT IN (". $expID .")
					AND b_catalog_product.QUANTITY ".(!$unavailabale ? '>' : '=')." 0	
				ORDER BY b_catalog_price.PRICE DESC
				LIMIT ". $count/2 ."
			)
		";  
		$recordset = $connection->query($sql); 
		while ($record = $recordset->fetch()){ 
			
			$prodIds[] = $record['ID']; 	
			
		}	
			
		return $prodIds;
		
	}
	
}


$eventManager = \Bitrix\Main\EventManager::getInstance();
$eventManager->addEventHandler('', 'ManufacturerOnBeforeAdd', 'OnBeforeAdd');
 
/**
 *
 * @param \Bitrix\Main\Entity\Event $event
 * @return \Bitrix\Main\Entity\EventResult
 */
function OnBeforeAdd(\Bitrix\Main\Entity\Event $event) {
    $entity = $event->getEntity();
    $arFields = $event->getParameter("fields"); 
    $result = new \Bitrix\Main\Entity\EventResult();
 
//модификация данных
    if (empty($arFields['UF_DESCRIPTION'])) {
        $arFields['UF_DESCRIPTION'] = 'Компания Ustage Group предлагает товары бренда '.$arFields['UF_NAME'].' на выгодных условиях ✔Доставка по Санкт-Петербургу и всей России ✔Тестирование оборудования на вашей площадке ✔Гарантийное обслуживание';
        $result->modifyFields($arFields);
    }

    if (empty($arFields['UF_TITLE'])) {
        $arFields['UF_TITLE'] = $arFields['UF_NAME'].' - музыкальное, световое, сценическое оборудование купить в СПб';
        $result->modifyFields($arFields);
    }
 

    if (empty($arFields['UF_NAME'])) {
        $arErrors = Array();
        $arErrors[] = new \Bitrix\Main\Entity\FieldError($entity->getField("UF_NAME"), "Ошибка в поле UF_NAME. Поле не должно быть пустым!");
        $result->setErrors($arErrors);
    }
 
    return $result;
}

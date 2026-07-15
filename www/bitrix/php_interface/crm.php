<?php
require_once('crest.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/energosoft.utils/classes/utility/Log.php');

use Bitrix\Sale\Internals\OrderPropsValueTable;

function debug_log($text) {
    if (empty($text)) return;
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/debug_log.txt' , date("Y-m-d H:i:s").' '.$text.PHP_EOL , FILE_APPEND );
}

function OnSaleOrderSavedHandler($orderID, &$eventName, &$arFields)
{
    $arOrder = CSaleOrder::GetByID($orderID);

	$phone = "";
	$email = "";
	$index = "";
	$country_name = "";
	$city_name = "";
	$address = "";

    $arFields = [
        'TITLE' => 'ЗАКАЗ №'.$orderID,
        'COMMENTS' => $arOrder['USER_DESCRIPTION'],
    ];
    
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
        if($arProps["CODE"] == "UTM_SOURCE") $arFields['UTM_SOURCE'] = htmlspecialchars($arProps["VALUE"]);
        if($arProps["CODE"] === "FIELD_OF_ACTIVITY"){//9773
            $arFields['FIELD_OF_ACTIVITY'] = $arFofA_Value[$arProps["VALUE"]];
        }
    }

    $full_address = $index.", ".$country_name."-".$city_name.", ".$address;

    $arDeliv = CSaleDelivery::GetByID($arOrder["DELIVERY_ID"]);
    $delivery_name = "";
    if (!empty($arDeliv)) {
        $delivery_name = $arDeliv["NAME"];
        $arFields['DELIVERY'] = $arDeliv["NAME"];
	}

    $arPayment = CSalePaySystem::GetByID($arOrder["PAY_SYSTEM_ID"]);
	if (!empty($arPayment)) {
		$arFields['PAYMENT'] = $arPayment["NAME"];
	}
  

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

        $arFields['PRODUCTS_FOR_DEAL'][] = array(
			"PRODUCT_ID" => $val["PRODUCT_XML_ID"],
			"PRODUCT_NAME" => $val["NAME"],
			"PRODUCT_URL" => $val["DETAIL_PAGE_URL"],
			"PRICE" => $val["PRICE"],
			"QUANTITY" => $val["QUANTITY"],
			"ARTICLE" => $arProduct['PROPERTIES']['CML2_ARTICLE']['VALUE'],
		);

        if (!empty($arProduct['PROPERTIES']['MODIFICATION']['VALUE_ENUM'])){
            $arFields['COMMENTS_ITEM'].="!УКАЗАНО! ".$arProduct['PROPERTIES']['MODIFICATION']['NAME']. " ". $arProduct['PROPERTIES']['MODIFICATION']['VALUE_ENUM']."\n";
        }
         if (!empty($arProduct['PROPERTIES']['SIZE']['VALUE_ENUM'])){
            $arFields['COMMENTS_ITEM'].="!УКАЗАНО! ".$arProduct['PROPERTIES']['SIZE']['NAME']. " ". $arProduct['PROPERTIES']['SIZE']['VALUE_ENUM']."\n";
        }

	}
	$arFields["ORDER_LIST"] = $strOrderList;
	$arFields["PRICE"] = $sumPrice;
	$arFields["ORDER_DATE"] = date('d.m.Y');


    $arFields['order'] = 'y';
	
    \Bitrix\Main\Diag\Debug::writeToFile($arFields, '', '_orderData.log');   
	\Bitrix\Main\Diag\Debug::writeToFile('start send data to b24 - '.$orderID, '', '_orderData.log');
	
	//sendRequests($arFields);
	\Bitrix\Main\Diag\Debug::writeToFile(postB24($arFields), '', '_orderData.log');
		
	/**/
	require_once($_SERVER["DOCUMENT_ROOT"]."/import/formData.php");
	usFormData::insert($arFields);
	/**/
}

/*function OnSaleOrderSavedHandler($orderID, &$eventName, &$arFields) { 
    CModule::IncludeModule("sale");
    CModule::IncludeModule("energosoft.utils");
    CModule::IncludeModule('highloadblock');

    //debug_log(2);

    $arOrder = CSaleOrder::GetByID($orderID);
    $order_props = CSaleOrderPropsValue::GetOrderProps($orderID);

    $arBasket = array();
    $dbBasketTmp = \CSaleBasket::GetList(
        array("SET_PARENT_ID" => "DESC", "TYPE" => "DESC", "NAME" => "ASC"),
        array("ORDER_ID" => $orderID),
        false,
        false,
        array(
            "ID",
            "PRODUCT_ID",
            "PRICE",
            "QUANTITY",
            "NAME",
            "MEASURE_NAME",
            'PRODUCT_XML_ID',
            'DETAIL_PAGE_URL',
            'PROPERTY_CML2_ARTICLE',
        )
    );
    while($arBasketTmp = $dbBasketTmp->GetNext()){
        $arBasket[] = $arBasketTmp;
    }

    $arFields = [
        'TITLE' => 'ЗАКАЗ №'.$orderID,
        'COMMENTS' => $arOrder['USER_DESCRIPTION'],
    ];
    foreach($arBasket as $i => $val)
    {
        $arProduct = ESIBlock::GetByID($val["PRODUCT_ID"]);
		
		$arFields['PRODUCTS_FOR_DEAL'][] = array(
			"PRODUCT_ID" => $val["PRODUCT_XML_ID"],
			"PRODUCT_NAME" => $val["NAME"],
			"PRODUCT_URL" => $val["DETAIL_PAGE_URL"],
			"PRICE" => $val["PRICE"],
			"QUANTITY" => $val["QUANTITY"],
			"ARTICLE" => $arProduct['PROPERTIES']['CML2_ARTICLE']['VALUE'],
		);

        if (!empty($arProduct['PROPERTIES']['MODIFICATION']['VALUE_ENUM'])){
            $arFields['COMMENTS_ITEM'].="!УКАЗАНО! ".$arProduct['PROPERTIES']['MODIFICATION']['NAME']. " ". $arProduct['PROPERTIES']['MODIFICATION']['VALUE_ENUM']."\n";
        }
         if (!empty($arProduct['PROPERTIES']['SIZE']['VALUE_ENUM'])){
            $arFields['COMMENTS_ITEM'].="!УКАЗАНО! ".$arProduct['PROPERTIES']['SIZE']['NAME']. " ". $arProduct['PROPERTIES']['SIZE']['VALUE_ENUM']."\n";
        }

    }

    $arFofA_Value=array( //9773
        'equipment_rental_companies' => 'Прокатчики оборудования',
        'event_hosts' => 'Ведущие мероприятий',
        'sound_engineers' => 'Звукорежиссеры',
        'light_operators' => 'Светоператоры',
        'lighting_artists' => 'Художники по свету',
        'film_industry_editing' => 'Киноиндустрия Монтаж',
        'government_institutions' => 'Государственные учреждения: Театры, школы и пр.',
        'cafes_bars' => 'Кафе, бары, рестораны, бизнес-центры',
        'other_field_of_activity' => 'Другая сфера деятельности',
    );

    while($arProps = $order_props->Fetch())
    {
        if($arProps["CODE"] == "PHONE") $arFields['PHONE'] = htmlspecialchars($arProps["VALUE"]);
        if($arProps["CODE"] == "FIO") $arFields['NAME'] = htmlspecialchars($arProps["VALUE"]);
        if($arProps["CODE"] == "EMAIL") $arFields['EMAIL'] = htmlspecialchars($arProps["VALUE"]);
        if($arProps["CODE"] == "ADDRESS") $arFields['ADDRESS'] = htmlspecialchars($arProps["VALUE"]);
        if($arProps["CODE"] == "BONUS_CARD_NUMBER") $arFields['BONUS_CARD_NUMBER'] = htmlspecialchars($arProps["VALUE"]);   
        if($arProps["CODE"] === "FIELD_OF_ACTIVITY"){//9773
            $arFields['FIELD_OF_ACTIVITY'] = $arFofA_Value[$arProps["VALUE"]];
        }
		if($arProps["CODE"] == "UTM_SOURCE") $arFields['UTM_SOURCE'] = htmlspecialchars($arProps["VALUE"]);
    }

    $arDeliv = CSaleDelivery::GetByID($arOrder["DELIVERY_ID"]);
	if (!empty($arDeliv)) {
		$arFields['DELIVERY'] = $arDeliv["NAME"];
	}
	
	$arPayment = CSalePaySystem::GetByID($arOrder["PAY_SYSTEM_ID"]);
	if (!empty($arPayment)) {
		$arFields['PAYMENT'] = $arPayment["NAME"];
	}

	$arFields['order'] = 'y';
	
    \Bitrix\Main\Diag\Debug::writeToFile($arFields, '', '_orderData.log');   
	\Bitrix\Main\Diag\Debug::writeToFile('start send data to b24 - '.$orderID, '', '_orderData.log');
	
	//sendRequests($arFields);
	\Bitrix\Main\Diag\Debug::writeToFile(postB24($arFields), '', '_orderData.log');

}*/

function initData(&$arFields){
    $properties = CIBlockElement::GetProperty($arFields['IBLOCK_ID'], $arFields['ID']);
    $codes = [
        'name' =>  ['NAME', 'USER_NAME'],
        'phone' => ['PHONE', 'USER_PHONE'],
        'comment' =>  ['COMMENT', 'USER_COMMENT', 'ANSWER', 'USER_COMMENT_AREA2', 'USER_COMMENT_AREA'],
        'email' => ['EMAIL', 'USER_MAIL'],
        'products' => ['TRADE_NAME_HIDDEN'],
		'utm_source' => ['UTM_SOURCE_HIDDEN'],
    ];

    while ($property=$properties->Fetch()){
        if (in_array($property['CODE'], $codes['name']))
            $arFields['NAME'] = $arFields['PROPERTY_VALUES'][$property['ID']];
        if (in_array($property['CODE'], $codes['phone'] ))
            $arFields['PHONE'] = $arFields['PROPERTY_VALUES'][$property['ID']];
        if (in_array($property['CODE'], $codes['comment']))
            $arFields['COMMENTS'] = $arFields['PROPERTY_VALUES'][$property['ID']];
        if (in_array($property['CODE'], $codes['email']))
            $arFields['EMAIL'] = $arFields['PROPERTY_VALUES'][$property['ID']];
        if (in_array($property['CODE'], $codes['products']))
            $arFields['PRODUCTS'] = [$arFields['PROPERTY_VALUES'][$property['ID']]];
        if (in_array($property['CODE'], $codes['utm_source']))
            $arFields['UTM_SOURCE'] = $arFields['PROPERTY_VALUES'][$property['ID']];
    }
}

function crmDeals(&$arFields){ 
    //$forms = [7, 9, 64, 57, 63, 61, 58, 57, 8, 10, 34];
    $forms = [7, 9, 64, 57, 63, 61, 58, 57, 10, 34];
    
    if (in_array($arFields['IBLOCK_ID'], $forms)) {
		
        initData($arFields);
        
		//sendRequests($arFields);
		\Bitrix\Main\Diag\Debug::writeToFile($arFields, '', '_orderData.log');   
		\Bitrix\Main\Diag\Debug::writeToFile('start send data to b24 - form'.$arFields['IBLOCK_ID'], '', '_orderData.log');
		
		//sendRequests($arFields);
		\Bitrix\Main\Diag\Debug::writeToFile(postB24($arFields), '', '_orderData.log');		
		
    }
}

function postB24($arFields) {
	
	$curl = curl_init();
	curl_setopt_array($curl, [
		CURLOPT_URL => 'https://b24rest.ustage-group.ru/app/ustage_v1/form_site.php?XDEBUG_SESSION=PHPSTORM',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => http_build_query($arFields)
	]);
	$response = curl_exec($curl);
	curl_close($curl);

	return "response: ".$response;
	
}

AddEventHandler("iblock", "OnAfterIBlockElementAdd", "crmDeals");
//AddEventHandler('sale', 'OnSaleOrderBeforeSaved', 'OnSaleOrderSavedHandler');
AddEventHandler('sale', 'OnOrderNewSendEmail', 'OnSaleOrderSavedHandler');
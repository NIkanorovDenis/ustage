<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
use Bitrix\Highloadblock as HL,
    Bitrix\Main\Loader,
    Bitrix\Currency;

include_once 'functions.php';

$ratio_settings = COption::GetOptionString('alexkova.market2', "ratio_settings","none");
$bxr_ratio_prop_code = COption::GetOptionString('alexkova.market2', "bxr_ratio_prop_code");

$arDetail = explode($arParams["OFFER_MASK"]."/", $arResult["DETAIL_PAGE_URL"]);
$arResult["DETAIL_PAGE_URL"] = $arDetail[0];
$bxr_use_links_sku_sef = COption::GetOptionString("alexkova.market2", "bxr_use_links_sku_sef", "N");
$bxr_use_links_sku_sef_code = COption::GetOptionString("alexkova.market2", "bxr_use_links_sku_sef_code", "N");

foreach($arParams["PREVIEW_DETAIL_PROPERTY_CODE"] as $propertyCode)
{
    $arResult["DISPLAY_PREVIEW_PROPERTIES"][$propertyCode] = $arResult["DISPLAY_PROPERTIES"][$propertyCode];

    if ($arParams["HIDE_PREVIEW_PROPS_INLIST"] == 'Y'):
        unset($arResult["DISPLAY_PROPERTIES"][$propertyCode]);
    endif;
}

/*start set min price to product with offers*/
$arOffersID = array();
if (!empty($arResult["OFFERS"])) {
    $arNewOffers = array();
    foreach ($arResult["OFFERS"] as $offer) {
        $arOffersID[] = $offer["ID"];
        
        if(isset($arParams["USE_BXR_STORES"]) && $arParams["USE_BXR_STORES"] === "Y") {
            $offer["CATALOG_QUANTITY"] = 0;
            $offer["~CATALOG_QUANTITY"] = 0;
            $offer["PRODUCT"]["QUANTITY"] = 0;
        }
        
        $canBuy = ($offer["CATALOG_QUANTITY"] <= 0 && $offer["CATALOG_CAN_BUY_ZERO"] == "N") ? false : true;
        $offer["DETAIL_PAGE_URL"] = ($bxr_use_links_sku_sef == "Y") ? (($bxr_use_links_sku_sef_code == "Y") ? $arResult["DETAIL_PAGE_URL"].$arParams["OFFER_MASK"]."/".$offer["CODE"]."/" : $arResult["DETAIL_PAGE_URL"].$arParams["OFFER_MASK"]."/".$offer["ID"]."/") : $arResult["DETAIL_PAGE_URL"]."?".$arParams["OFFER_REQUEST_MASK"]."=".$offer["ID"];
        if ($canBuy && (empty($arResult["ITEM_PRICES"]) || $arResult["ITEM_PRICES"][0]["PRICE"] > $offer["ITEM_PRICES"][0]["PRICE"]) ) 
            $arResult["ITEM_PRICES"] = $offer["ITEM_PRICES"];        
        if ($canBuy && (empty($arResult["PRICES"]) || current($arResult["PRICES"])["VALUE"] > current($offer["PRICES"])["VALUE"]) ) 
            $arResult["PRICES"] = $offer["PRICES"];
        CIBlockPriceTools::setRatioMinPrice($offer, false);
        $arNewOffers[$offer['ID']] = $offer;
    }
    $arResult["OFFERS"] = $arNewOffers;
    unset($arNewOffers);
}
/*end set min price to product with offers*/

if(isset($arParams["USE_BXR_STORES"]) && $arParams["USE_BXR_STORES"] === "Y" && ( !isset($arParams["SHOW_MAX_QUANTITY"]) || $arParams["SHOW_MAX_QUANTITY"] != "N" ) ) {
    $arProductsStore = array();
    if (!empty($arResult["OFFERS"])) {

        $obStoreProduct = CCatalogStoreProduct::GetList(array("STORE_ID" => "ASC"), array("PRODUCT_ID" => $arOffersID), false, false, array("ID", "PRODUCT_ID", "STORE_ID","AMOUNT"));

        while ($arStoreProduct = $obStoreProduct->Fetch()) {
            $arProductsStore[$arStoreProduct["PRODUCT_ID"]][$arStoreProduct["STORE_ID"]] = $arStoreProduct;
        }
        
        if(!empty($arParams["STORES"]) && is_array($arParams["STORES"]) && !empty($arProductsStore) && is_array($arProductsStore) ) {

            foreach ($arProductsStore as $k => $v) {
                foreach ($arParams["STORES"] as $kk => $vv) {
                    $arResult["OFFERS"][$k]["CATALOG_QUANTITY"] += $v[$vv]["AMOUNT"];
                    $arResult["OFFERS"][$k]["~CATALOG_QUANTITY"] += $v[$vv]["AMOUNT"];
                    $arResult["OFFERS"][$k]["PRODUCT"]["QUANTITY"] += $v[$vv]["AMOUNT"];
                    
                }
            }
        }
    }
    else {
        $obStoreProduct = CCatalogStoreProduct::GetList(array("STORE_ID" => "ASC"), array("PRODUCT_ID" => $arResult['ID']), false, false, array("ID", "PRODUCT_ID", "STORE_ID","AMOUNT"));

        while ($arStoreProduct = $obStoreProduct->Fetch()) {
            $arProductsStore[$arStoreProduct["PRODUCT_ID"]][$arStoreProduct["STORE_ID"]] = $arStoreProduct;
        }
        
        $quantity = 0;
        
        if(!empty($arParams["STORES"]) && is_array($arParams["STORES"]) ) {
            foreach ($arParams["STORES"] as $k => $v) {
                if(isset($arProductsStore[$arResult['ID']][$v])) {
                    $quantity += $arProductsStore[$arResult['ID']][$v]["AMOUNT"];
                }
            }
        }
        
        $arResult["CATALOG_QUANTITY"] = $quantity;
        $arResult["~CATALOG_QUANTITY"] = $quantity;
        $arResult["PRODUCT"]["QUANTITY"] = $quantity;
    }
}

/*start basket props*/
$arResult["REAL_SECTION_ID"] = getRealSectionId($arParams["SECTION_ID"],$arParams["SECTION_CODE"],$arResult["ID"], $arResult["IBLOCK_SECTION_ID"]);
$arResult["BASKET_PROPS"] = getSectionBasketProps($arResult["REAL_SECTION_ID"], $arResult["IBLOCK_ID"]);
if(is_array($arResult["BASKET_PROPS"]["REQUIRED"])) {
    foreach ($arResult["BASKET_PROPS"]["REQUIRED"] as $pCode) {
        $arProp = $arResult["PROPERTIES"][$pCode];
        if ($arProp["MULTIPLE"] == "Y" && $arProp["VALUE"])
            $arResult["BASKET_PROPS"]["REQUIRED_CHECK"][$pCode] = array(
                "ID" => $arProp["ID"],
                "CODE" => $arProp["CODE"],
                "NAME" => $arProp["NAME"],
                "SORT" => $arProp["SORT"],
                "VALUE" => $arProp["VALUE"]
            );
    }
}

if(is_array($arResult["BASKET_PROPS"]["OPTIONAL"])) {
    foreach ($arResult["BASKET_PROPS"]["OPTIONAL"] as $pCode) {
        $arProp = $arResult["PROPERTIES"][$pCode];
        if ($arProp["MULTIPLE"] == "Y" && $arProp["VALUE"])
            $arResult["BASKET_PROPS"]["OPTIONAL_CHECK"][$pCode] = array(
                "ID" => $arProp["ID"],
                "CODE" => $arProp["CODE"],
                "NAME" => $arProp["NAME"],
                "SORT" => $arProp["SORT"],
                "VALUE" => $arProp["VALUE"]
            );
    }
}
/*end basket props*/

/*sku props start*/
$arSKUPropList = array();
if ($arResult['MODULES']['catalog'])
{
    if (!$boolConvert)
            $strBaseCurrency = CCurrency::GetBaseCurrency();

    $arSKU = CCatalogSKU::GetInfoByProductIBlock($arParams['IBLOCK_ID']);
    $boolSKU = !empty($arSKU) && is_array($arSKU);
    if ($boolSKU && !empty($arParams['OFFER_TREE_PROPS']))
    {
            $arSKUPropList = CIBlockPriceTools::getTreeProperties(
                    $arSKU,
                    $arParams['OFFER_TREE_PROPS'],
                    array(
                            'PICT' => $arEmptyPreview,
                            'NAME' => '-'
                    )
            );
            $arSKUPropIDs = array_keys($arSKUPropList);
    }
}
$arResult['OFFERS_IBLOCK'] = $arSKU['IBLOCK_ID'];
    
if (!empty($arResult['OFFERS'])) {

    $arNeedValues = array();
    foreach ($arResult['OFFERS'] as $val) {
        foreach ($val['PROPERTIES'] as $vCell => $vProp){
            if (in_array($vCell, $arParams['OFFER_TREE_PROPS'])) {
                if ($vProp['PROPERTY_TYPE'] == 'S' && strlen($vProp['VALUE']) > 0) {
                    if (!is_array($arNeedValues[$vProp["ID"]]) || !in_array($vProp['VALUE'], $arNeedValues[$vProp["ID"]])) {
                        $arNeedValues[$vProp["ID"]][] = $vProp['VALUE'];
                    }
                }
                if ($vProp['PROPERTY_TYPE'] == 'L' && $vProp['VALUE_ENUM_ID'] > 0) {
                    if (!is_array($arNeedValues[$vProp["ID"]]) || !in_array($vProp['VALUE_ENUM_ID'], $arNeedValues[$vProp["ID"]])) {
                        $arNeedValues[$vProp["ID"]][] = $vProp['VALUE_ENUM_ID'];
                    }
                }
            }
        }
    }
    if ($arResult['MODULES']['catalog'] && isset($arResult['OFFERS']) && !empty($arResult['OFFERS'])) 
        CIBlockPriceTools::getTreePropertyValues($arSKUPropList, $arNeedValues);

    $arResult['SKU_PROPS'] = $arSKUPropList;

    $nav = CIBlockSection::GetNavChain(false, $arResult["IBLOCK_SECTION_ID"]);
    while($section = $nav->Fetch()){
        $sectionIds[] = $section["ID"];
    }

    $ufCodes = array();
    $filter = array('IBLOCK_ID' => $arParams['IBLOCK_ID'], "ID" => $sectionIds);
    $select = array('IBLOCK_ID', 'ID', 'NAME', 'UF_SKU_TYPE');
    $rsSect = CIBlockSection::GetList(array('id' => 'desc'), $filter, false, $select);
    while ($arSect = $rsSect->GetNext())
    {
        if($arSect["UF_SKU_TYPE"] > 0 && !array_key_exists($arSect["UF_SKU_TYPE"], $ufCodes)) {
            $rsEnum = CUserFieldEnum::GetList(array(), array("ID" => $arSect["UF_SKU_TYPE"]));
            $arUf = $rsEnum->GetNext();
            $ufCodes[$arSect["UF_SKU_TYPE"]] = $arUf["XML_ID"];
        }
        $arSect["UF_SKU_TYPE_VALUE"] = $ufCodes[$arSect["UF_SKU_TYPE"]];
        $sections[] = $arSect;
    }


    $skuView = $arResult["PROPERTIES"]["SKU_TYPE"]["VALUE_XML_ID"];
    if (strlen($skuView) <= 0) {
        foreach ($sections as $section) {
            if (strlen($section["UF_SKU_TYPE_VALUE"]) > 0) {
                $skuView = $section["UF_SKU_TYPE_VALUE"];
                break;
            }
        }
    }

    if (strlen($skuView) > 0)
        $arParams["OFFERS_VIEW"] = $skuView;
    if ($arParams["OFFERS_VIEW"] == "CHOISE") {
        $sku_props = array();

        foreach ($arResult['SKU_PROPS'] as $key => $prop) {
            $sku_props[$key] = array(
                "ID" => $prop["ID"],
                "CODE" => $prop["CODE"],
                "NAME" => $prop["NAME"],
                "SORT" => $prop["SORT"],
                "PROPERTY_TYPE" => $prop["PROPERTY_TYPE"],
                "LINK_IBLOCK_ID" => $prop["LINK_IBLOCK_ID"],
                "VALUES" => array()
            );

            $sku_props_code[] = $key; 
        }

		$elem_link = array();
		$elem_hl = array();

        foreach ($arResult['OFFERS'] as $key => $offer) {
            foreach ($offer["PROPERTIES"] as $propCode => $prop) {
                if (in_array($propCode, $sku_props_code)) {
                    if ($prop["PROPERTY_TYPE"] == "L") {
                        if ($prop["VALUE_ENUM_ID"] > 0)
                            $sku_props[$propCode]["VALUES"][$prop["VALUE_ENUM_ID"]] = array(
                                "ID" => $prop["VALUE_ENUM_ID"],
                                "NAME" => $prop["VALUE"],
                                "SORT" => $prop["VALUE_SORT"]
                            );
                     }
                    if ($prop["PROPERTY_TYPE"] == "E") {
                        $elem_link[$propCode]["IBLOCK_ID"] = $prop["LINK_IBLOCK_ID"];
                        if (!in_array($prop["VALUE"], $elem_link[$propCode]["VALUES"]))
                            $elem_link[$propCode]["VALUES"][] = $prop["VALUE"];
                    }
					if ($prop["PROPERTY_TYPE"] == "S") {
						$elem_hl[$propCode]["TABLE_NAME"] = $prop["USER_TYPE_SETTINGS"]["TABLE_NAME"];
						if (!empty($elem_hl[$propCode]["VALUES"]) && !in_array($prop["VALUE"], $elem_hl[$propCode]["VALUES"]))
							$elem_hl[$propCode]["VALUES"][] = $prop["VALUE"];
					}
                }
            }
        }

        foreach ($elem_link as $propCode => $arElem) {
            $values = array();
            $arFilter = array("IBLOCK_ID" => $arElem["IBLOCK_ID"], "ID" => $arElem["VALUES"]);
            $arSelect = array("ID", "NAME", "SORT");
            $res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, $arSelect);
            while($ar_fields = $res->GetNext())
            {
                if ($ar_fields["ID"] > 0)
                    $values[$ar_fields["ID"]] = array(
                        "ID" => $ar_fields["ID"],  
                        "NAME" => $ar_fields["NAME"],  
                        "SORT" => $ar_fields["SORT"],  
                    );
            }

            $sku_props[$propCode]["VALUES"] = $values;
        }


        foreach ($elem_hl as $propCode => $arElem) {
            $values = array();
            CModule::IncludeModule('highloadblock');
            $rsData = \Bitrix\Highloadblock\HighloadBlockTable::getList(array('filter'=>array('TABLE_NAME' => $arElem['TABLE_NAME'])));
            if ($arData = $rsData->fetch()){
                $hlblock_id = $arData["ID"];

                $hlblock = HL\HighloadBlockTable::getById($hlblock_id)->fetch();

                $entity = HL\HighloadBlockTable::compileEntity($hlblock);
                $entity_data_class = $entity->getDataClass();
                $entity_table_name = $hlblock['TABLE_NAME'];

                $arFilter = array("UF_XML_ID" => $arElem["VALUES"]);

                $sTableID = 'tbl_'.$entity_table_name;
                $rsData = $entity_data_class::getList(array(
                        "select" => array('*'),
                        "filter" => $arFilter,
                        "order" => array("UF_SORT"=>"ASC")
                ));
                $rsData = new CDBResult($rsData, $sTableID);
                while($ar_fields = $rsData->Fetch()){
                    if ($ar_fields["ID"] > 0)
                        $values[$ar_fields["ID"]] = array(
                            "ID" => $ar_fields["ID"],  
                            "NAME" => $ar_fields["UF_NAME"],  
                            "XML_ID" => $ar_fields["UF_XML_ID"],  
                            "DESCRIPTION" => $ar_fields["UF_DESCRIPTION"],  
                            "SORT" => $ar_fields["UF_SORT"],  
                            "FILE" => CFile::GetPath($ar_fields["UF_FILE"]),  
                        );
                }


                $sku_props[$propCode]["VALUES"] = $values;
            };
        }


        foreach ($sku_props as $key => $prop) {
            if (count($prop["VALUES"]) == 0)
                unset ($sku_props[$key]);
        }

        foreach ($sku_props as $key => $prop) {
            if (count($sku_props[$key]["VALUES"]) > 1)
                $sku_props[$key]["VALUES"] = isort($prop["VALUES"], "SORT");
        }    

        $arResult["SKU_PROPS_LIST"] = $sku_props;
    }

    $arResult["FIRST_SKU_SELECT"] = 0;

    foreach($arResult["OFFERS"] as $offer){
        if($arResult["FIRST_SKU_SELECT"] == 0 && intval($offer["CATALOG_QUANTITY"]) > 0)
            $arResult["FIRST_SKU_SELECT"] = $offer["ID"];  
    }

    reset($arResult["OFFERS"]);

    if($arResult["FIRST_SKU_SELECT"] == 0 && !empty($arResult["OFFERS"])) {
        $firstSKU = current($arResult["OFFERS"]);
        $arResult["FIRST_SKU_SELECT"] = $firstSKU["ID"];
    }

    $arResult["OFFERS_VIEW"] = $arParams["OFFERS_VIEW"];
}
/*sku props end*/

/*strat more photo*/
$productSlider = getSliderForItem(
    $arResult, 
    $arParams['ADD_PICT_PROP'], 
    'Y' == $arParams['ADD_DETAIL_TO_SLIDER'], 
    false, 
    ($arParams["ADD_DETAIL_TO_SLIDER_SKU"] == "Y") ? true : false,
    ($arParams["ADDITIONAL_SKU_PIC_2_SLIDER"] == "Y") ? true : false
);
if (empty($productSlider))
{
	$productSlider = array(
		0 => $arEmptyPreview
	);
}
$productSliderCount = count($productSlider);
$arResult['SHOW_SLIDER'] = true;
$arResult['MORE_PHOTO'] = $productSlider;
$arResult['MORE_PHOTO_COUNT'] = count($productSlider);
if (!empty($arResult['OFFERS'])) {
    foreach ($arResult["OFFERS"] as &$arOffer) {
        $arOffer['MORE_PHOTO'] = array();
        $arOffer['MORE_PHOTO_COUNT'] = 0;
        $offerSlider = getSliderForItem(
                $arOffer, 
                $arParams['OFFER_ADD_PICT_PROP'], 
                'Y' == $arParams['ADD_DETAIL_TO_SLIDER'], 
                $arParams["OFFER_TREE_PROPS"],
                ($arParams["ADD_DETAIL_TO_SLIDER_SKU"] == "Y") ? true : false,
                ($arParams["ADDITIONAL_SKU_PIC_2_SLIDER"] == "Y") ? true : false
        );
        if (empty($offerSlider))
        {
            $offerSlider = $productSlider;
        } else {
            //add offers photo to general slider
            $arResult['MORE_PHOTO'] = array_merge($arResult['MORE_PHOTO'], $offerSlider);
        }
        $arOffer['MORE_PHOTO'] = $offerSlider;
        $arOffer['MORE_PHOTO_COUNT'] = count($offerSlider);
    }
} 
foreach ($arResult['MORE_PHOTO'] as $key => $arPhoto)  {
    if (!is_array($arPhoto))
        unset($arResult['MORE_PHOTO'][$key]);
};
/*end more photo*/

/*start ratio*/
$arResult["QTY_MAX"] = ($arResult["CATALOG_CAN_BUY_ZERO"] == "Y") ? 0 : $arResult["CATALOG_QUANTITY"];

$arResult["RATIO"] = 1;
if($ratio_settings == "own_prop" && strlen($bxr_ratio_prop_code)>0 
        && isset($arResult["PROPERTIES"][$bxr_ratio_prop_code]["VALUE"]) && is_numeric($arResult["PROPERTIES"][$bxr_ratio_prop_code]["VALUE"]))
    $arResult["RATIO"] = $arResult["PROPERTIES"][$bxr_ratio_prop_code]["VALUE"];
elseif($ratio_settings == "base") {
	if(!isset($arResult["ITEM_MEASURE_RATIOS"]) && empty($arResult["CATALOG_MEASURE_RATIO"]))
		$arResult["CATALOG_MEASURE_RATIO"] = 1;
    $arResult["RATIO"] = ($arResult["CATALOG_MEASURE_RATIO"]) ? $arResult["CATALOG_MEASURE_RATIO"] : current($arResult["ITEM_MEASURE_RATIOS"])["RATIO"];
}

$arResult["START_QTY"] = ($arResult["RATIO"] > $arResult["CATALOG_QUANTITY"] && $arResult["CATALOG_QUANTITY"]>0) ? $arResult["CATALOG_QUANTITY"] : $arResult["RATIO"];
/*end ratio*/

$arParams["~OFFERS_PROPERTY_CODE"] = is_array($arParams["~OFFERS_PROPERTY_CODE"]) ? $arParams["~OFFERS_PROPERTY_CODE"] : array();
$arResult["OFFERS_PROP"] = is_array($arResult["OFFERS_PROP"]) ? $arResult["OFFERS_PROP"] : array();

/*start offers props*/
foreach ($arResult["OFFERS"] as $key => &$offer) :
    $arResult["CATALOG_QUANTITY"] += $offer["CATALOG_QUANTITY"];
    $arResult["CATALOG_MEASURE_NAME"] = $offer["CATALOG_MEASURE_NAME"];
    
    $offer["QTY_MAX"] = ($offer["CATALOG_CAN_BUY_ZERO"] == "Y") ? 0 : $offer["CATALOG_QUANTITY"];
        
    $offer["RATIO"] = 1;
    if($ratio_settings == "own_prop" && strlen($bxr_ratio_prop_code)>0 
            && isset($offer["PROPERTIES"][$bxr_ratio_prop_code]["VALUE"]) && is_numeric($offer["PROPERTIES"][$bxr_ratio_prop_code]["VALUE"]))
        $offer["RATIO"] = $offer["PROPERTIES"][$bxr_ratio_prop_code]["VALUE"];
    elseif($ratio_settings == "base")
        $offer["RATIO"] = ($offer["CATALOG_MEASURE_RATIO"]) ? $offer["CATALOG_MEASURE_RATIO"] : current($offer["ITEM_MEASURE_RATIOS"])["RATIO"];

    $offer["START_QTY"] = ($offer["RATIO"] > $offer["CATALOG_QUANTITY"] && $offer["CATALOG_QUANTITY"]>0) ? $offer["CATALOG_QUANTITY"] : $offer["RATIO"];
    
    $propsStr = "";
    if(is_array($offer["PROPERTIES"])){
        foreach($offer["PROPERTIES"] as $propCode => $arProp):
            $printValue = "";
            if (array_key_exists($propCode, $arResult["OFFERS_PROP"]) || in_array($arProp["CODE"], $arParams["~OFFERS_PROPERTY_CODE"])): 
                $sPropId = $arResult["SKU_PROPS"][$propCode]["XML_MAP"][$arProp["VALUE"]];
                if ($arProp["PROPERTY_TYPE"] == "E" && strlen($arResult["SKU_PROPS"][$propCode]["VALUES"][$arProp["VALUE"]]["NAME"]) > 0) {
                    $printValue = $arProp["NAME"].": ".$arResult["SKU_PROPS"][$propCode]["VALUES"][$arProp["VALUE"]]["NAME"];
                } else if ($arProp["PROPERTY_TYPE"] == "S" && strlen($arResult["SKU_PROPS"][$propCode]["VALUES"][$sPropId]["NAME"]) > 0) {
                    $printValue = $arProp["NAME"].": ".$arResult["SKU_PROPS"][$propCode]["VALUES"][$sPropId]["NAME"];
                } else if ($arProp["PROPERTY_TYPE"] == "L" && $arProp["MULTIPLE"] == "Y" && $arProp["VALUE"]) {
                        $printValue = $arProp["NAME"].": ";
                        $valueCount = count($arProp["VALUE"])-1;
                        foreach ($arProp["VALUE"] as $key => $value)
                        {
                            $printValue .= $value;
                            if ($key!=$valueCount) $printValue .= ',';
                        }
                } else if (is_string($arProp["VALUE"]) && strlen($arProp["VALUE"]) > 0) {
                        $printValue = $arProp["NAME"].": ".$arProp["VALUE"];
                }

                    if(!empty($printValue))
                        $propsStr .= $printValue.", ";

            endif;
        endforeach;
    }
    $propsStr = rtrim($propsStr, ", ");
    $offer["OFFER_PROPS_TEXT"] = $propsStr;
    $offer["MSG"] = str_replace("#TRADE_NAME#", htmlspecialchars($offer["NAME"],ENT_QUOTES, SITE_CHARSET), GetMessage('OFFER_REQUEST_MSG'));
    $offer["MSG"] = str_replace("#PARAMS#", htmlspecialchars($propsStr,ENT_QUOTES, SITE_CHARSET), $offer["MSG"]);
endforeach;
/*end offers props*/

/*start show timer*/
$discount_period_from = strtotime($arResult["PROPERTIES"]["BXR_DISCOUNT_PERIOD_FROM"]["VALUE"]);
$arResult["DISCOUNT_PERIOD_TO"] = $discount_period_to = strtotime($arResult["PROPERTIES"]["BXR_DISCOUNT_PERIOD_TO"]["VALUE"]);
$date = strtotime(date($DB->DateFormatToPHP(CLang::GetDateFormat("FULL"))));
$discount_active = ((!$discount_period_from && !$discount_period_to) || ($date >= $discount_period_from && $date <= $discount_period_to) || ($date >= $discount_period_from && !$discount_period_to)) ? true : false;
$arResult["SHOW_TIMER"] = ($arResult["PROPERTIES"]["BXR_DISCOUNT_TIMER"]["VALUE"] == "Y" && $discount_active) ? true : false;
/*end show timer*/

$cp = $this->__component; 

if (is_object($cp))
{
	$cp->arResult['MY_TITLE'] = GetMessage("MY_TITLE");
	$cp->arResult['IS_OBJECT'] = 'Y';
	$arResult["ACCESSORIES"] = $arResult["PROPERTIES"][$arParams["LINK_PROPERTY_SID"]]["VALUE"];

	$cp->SetResultCacheKeys(
		array(
                        "PROPERTIES",
                        "DETAIL_PAGE_URL",
			"DISPLAY_PROPERTIES",
			"ID",
			"DETAIL_TEXT",
			"ACCESSORIES",
			"OFFERS",
                        "OFFERS_PROP",
                        "SKU_PROPS",
                        "SKU_PROPS_LIST",
                        "CACHED_TPL",
                        "FIRST_SKU_SELECT",
                        "OFFERS_VIEW",
                        "SCHEMES",
                        "TABS",
                        "SECTION",
                        "SHOW_TIMER"
		)
	);
}
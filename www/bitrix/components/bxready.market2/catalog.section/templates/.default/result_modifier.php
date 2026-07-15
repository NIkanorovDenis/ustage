<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 * @var array $arParams 
 * @var array $arResult 
 */

use Bitrix\Main\Type\Collection;
use Bitrix\Currency\CurrencyTable;
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

if (!\Bitrix\Main\Loader::includeModule('alexkova.market2')) return;

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

if (\Bitrix\Main\Loader::includeModule('alexkova.bxready2')){
	$bxrParams = Alexkova\Bxready2\Component::$relatedParameters;

	$allPrefix = array(
		'_STANDART', '_BIG', '_SMALL'
	);

	foreach ($arParams as $cell=>$val){
		foreach ($allPrefix as $prefix){
			if (substr($cell, strlen($cell)-strlen($prefix), strlen($prefix)) == $prefix){
				$arParams['BXR'.$prefix][substr($cell, 0, strlen($cell)-strlen($prefix))] =  $val;
			}
		}
	}
}

$module_id = "alexkova.market2";



$ratio_settings = COption::GetOptionString($module_id, "ratio_settings","none");
$bxr_ratio_prop_code = COption::GetOptionString($module_id, "bxr_ratio_prop_code");

foreach ($arResult['ITEMS'] as $key => $arItem)
{
    if ($arItem['CATALOG'] && isset($arItem['OFFERS']) && !empty($arItem['OFFERS'])) 
    {
        if ('Y' == $arParams['PRODUCT_DISPLAY_MODE'])
        {
            $arItem["MORE_PHOTO_SLIDER"] = $arItem["MORE_PHOTO"];
            foreach ($arItem['OFFERS'] as $keyOffer => &$arOffer)
            {
                /*set min price*/
                if (empty($arItem['MIN_PRICE']) && $arOffer['CAN_BUY'])
                {
                    $arItem['MIN_PRICE'] = $arOffer['MIN_PRICE'];
                    $arItem['MIN_BASIS_PRICE'] = $arOffer['MIN_PRICE'];
                } elseif (isset($arItem['MIN_PRICE']) && $arOffer['CAN_BUY'] && $arItem['MIN_PRICE']['VALUE'] > $arOffer['MIN_PRICE']['VALUE']) {
                    $arItem['MIN_PRICE'] = $arOffer['MIN_PRICE'];
                    $arItem['MIN_BASIS_PRICE'] = $arOffer['MIN_PRICE'];
                }

                foreach ($arOffer["PRICES"] as $offerPriceIndex => $offerPrice) {
                    if (empty($arItem['MIN_PRICE']) && $arOffer['CAN_BUY'])
                    {
                        $arItem['MIN_PRICE'] = $offerPrice;
                    } elseif ($arOffer['CAN_BUY']) {
                        $arItem['MIN_PRICE'] = ($offerPrice['VALUE'] < $arItem['MIN_PRICE']['VALUE']) ? $offerPrice : $arItem['MIN_PRICE'];
                    }
                }
                /*end min price*/
                
                
                /*start ratio*/
                $arOffer["QTY_MAX"] = ($arOffer["CATALOG_CAN_BUY_ZERO"] == "Y") ? 0 : $arOffer["CATALOG_QUANTITY"];

                $arOffer["RATIO"] = 1;
                if($ratio_settings == "own_prop" && strlen($bxr_ratio_prop_code)>0 
                        && isset($arOffer["PROPERTIES"][$bxr_ratio_prop_code]["VALUE"]) && is_numeric($arOffer["PROPERTIES"][$bxr_ratio_prop_code]["VALUE"]))
                    $arOffer["RATIO"] = $arOffer["PROPERTIES"][$bxr_ratio_prop_code]["VALUE"];
                elseif($ratio_settings == "base") {
					if(!isset($arOffer["ITEM_MEASURE_RATIOS"]) && empty($arOffer["CATALOG_MEASURE_RATIO"]))
						$arOffer["CATALOG_MEASURE_RATIO"] = 1;
                    $arOffer["RATIO"] = ($arOffer["CATALOG_MEASURE_RATIO"]) ? $arOffer["CATALOG_MEASURE_RATIO"] : current($arOffer["ITEM_MEASURE_RATIOS"])["RATIO"];
				}

                $arOffer["START_QTY"] = ($arOffer["RATIO"] > $arOffer["CATALOG_QUANTITY"] && $arOffer["CATALOG_QUANTITY"]>0) ? $arOffer["CATALOG_QUANTITY"] : $arOffer["RATIO"];
                /*end ratio*/

                /*start sku slider*/
                foreach ($arOffer["MORE_PHOTO"] as &$photo) {
                    $photo["ITEM_ID"] = $arOffer["ID"];
                }
                $arItem["MORE_PHOTO_SLIDER"] = array_merge($arItem["MORE_PHOTO_SLIDER"], $arOffer["MORE_PHOTO"]);
                /*end sku slider*/
            }

			$arUniquePhoto = array();
			foreach ($arItem["MORE_PHOTO_SLIDER"] as $kMP => $vMP) {
				if(!isset($arUniquePhoto[$vMP["SRC"]])){
					$arUniquePhoto[$vMP["SRC"]] = true;
				}
				else {
					unset($arItem["MORE_PHOTO_SLIDER"][$kMP]);
				}
			}
			unset($arUniquePhoto);
        }
    }

    /*start ratio*/
    $arItem["QTY_MAX"] = ($arItem["CATALOG_CAN_BUY_ZERO"] == "Y") ? 0 : $arItem["CATALOG_QUANTITY"];

    $arItem["RATIO"] = 1;
    if($ratio_settings == "own_prop" && strlen($bxr_ratio_prop_code)>0 
            && isset($arItem["PROPERTIES"][$bxr_ratio_prop_code]["VALUE"]) && is_numeric($arItem["PROPERTIES"][$bxr_ratio_prop_code]["VALUE"]))
        $arItem["RATIO"] = $arItem["PROPERTIES"][$bxr_ratio_prop_code]["VALUE"];
    elseif($ratio_settings == "base") {
		if(!isset($arItem["ITEM_MEASURE_RATIOS"]) && empty($arItem["CATALOG_MEASURE_RATIO"]))
			$arItem["CATALOG_MEASURE_RATIO"] = 1;
        $arItem["RATIO"] = ($arItem["CATALOG_MEASURE_RATIO"]) ? $arItem["CATALOG_MEASURE_RATIO"] : current($arItem["ITEM_MEASURE_RATIOS"])["RATIO"];
	}

    $arItem["START_QTY"] = ($arItem["RATIO"] > $arItem["CATALOG_QUANTITY"] && $arItem["CATALOG_QUANTITY"]>0) ? $arItem["CATALOG_QUANTITY"] : $arItem["RATIO"];
    /*end ratio*/
    
    /*start show timer*/
    global $DB;
    $discount_period_from = strtotime($arItem["PROPERTIES"]["BXR_DISCOUNT_PERIOD_FROM"]["VALUE"]);
    $arItem["DISCOUNT_PERIOD_TO"] = $discount_period_to = strtotime($arItem["PROPERTIES"]["BXR_DISCOUNT_PERIOD_TO"]["VALUE"]);
    $date = strtotime(date($DB->DateFormatToPHP(CLang::GetDateFormat("FULL"))));
    $discount_active = ((!$discount_period_from && !$discount_period_to) || ($date >= $discount_period_from && $date <= $discount_period_to) || ($date >= $discount_period_from && !$discount_period_to)) ? true : false;
    $arItem["SHOW_TIMER"] = ($arItem["PROPERTIES"]["BXR_DISCOUNT_TIMER"]["VALUE"] == "Y" && $discount_active) ? true : false;
    /*end show timer*/
    
    $arNewItemsList[$key] = $arItem;
    $arIds[] = $arItem['ID'];
}

$arResult['ITEMS'] = $arNewItemsList;

/*start modifier bprops*/
if (!empty($arIds)) 
{
    $arSectionBasketProps = Alexkova\Market2\Basket::getSectionsBasketProps($arIds, $arParams["IBLOCK_ID"]);
    $arBasketProps = $arSectionBasketProps["BASKET_PROPS"];
    $arRealSectionIds = $arSectionBasketProps["REAL_SECTION_ID"];

    foreach ($arResult['ITEMS'] as &$arItem) {
        $arReq = $arBasketProps[$arRealSectionIds[$arItem["ID"]]]["REQUIRED"];
        if(is_array($arReq)) {
            foreach ($arReq as $pCode) {
                $arProp = $arItem["PROPERTIES"][$pCode];
                if ($arProp["MULTIPLE"] == "Y" && $arProp["VALUE"])
                    $arItem["BASKET_PROPS"]["REQUIRED_CHECK"][$pCode] = array(
                        "ID" => $arProp["ID"],
                        "CODE" => $arProp["CODE"],
                        "NAME" => $arProp["NAME"],
                        "SORT" => $arProp["SORT"],
                        "VALUE" => $arProp["VALUE"]
                    );
            }
        }
        
        $arOpt = $arBasketProps[$arRealSectionIds[$arItem["ID"]]]["OPTIONAL"];
        if(is_array($arOpt)) {
            foreach ($arOpt as $pCode) {
                $arProp = $arItem["PROPERTIES"][$pCode];
                if ($arProp["MULTIPLE"] == "Y" && $arProp["VALUE"])
                    $arItem["BASKET_PROPS"]["OPTIONAL_CHECK"][$pCode] = array(
                        "ID" => $arProp["ID"],
                        "CODE" => $arProp["CODE"],
                        "NAME" => $arProp["NAME"],
                        "SORT" => $arProp["SORT"],
                        "VALUE" => $arProp["VALUE"]
                    );
            }
        }
    }        

}
/*end modifier bprops*/

$use_seo_pagenavigation = COption::GetOptionString("alexkova.market2", "use_seo_pagenavigation", "N");
if($use_seo_pagenavigation == "Y") {
	$cp = $this->__component;
	if (is_object($cp))
	{
		$dbresult =& $arResult["NAV_RESULT"];

		$cp->arResult['CURRENT_PAGE'] = $dbresult->NavPageNomer;
		$cp->arResult['MAX_PAGE'] = $dbresult->NavPageCount;
		$cp->arResult['NAV_NUM'] = $dbresult->NavNum;

		$cp->SetResultCacheKeys(array('CURRENT_PAGE','MAX_PAGE', 'SECTION_PAGE_URL', 'NAV_NUM'));

		$arResult['CURRENT_PAGE'] = $cp->arResult['CURRENT_PAGE'];
		$arResult['MAX_PAGE'] = $cp->arResult['MAX_PAGE'];
		$arResult['NAV_NUM'] = $cp->arResult['NAV_NUM'];
	}
}
?>

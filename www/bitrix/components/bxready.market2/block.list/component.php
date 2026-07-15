<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Alexkova\Bxready\Core;

if (!CModule::IncludeModule('alexkova.bxready2')) return false;

if (intval($arParams["IBLOCK_ID"])<=0){
	return false;
}

if(empty($arParams["FILTER_NAME"]))
    $arParams["FILTER_NAME"] = "arrFilter";


$prepareParamsName = "bxready.market2:block.list";
    \Alexkova\Bxready2\Component::prepareParams($arParams, $prepareParamsName);

if(isset($arParams["BXR_PROMO_PREPARE_ID"]) && strlen($arParams["BXR_PROMO_PREPARE_ID"])>0 )
    $prepareParamsName .= ".".$arParams["BXR_PROMO_PREPARE_ID"];

\Alexkova\Bxready2\Component::prepareParams($arParams, $prepareParamsName);

if(!empty($arParams["REGION_CONTENT"])) {
    if(!empty($arParams["FILTER_NAME"]))
       global ${$arParams["FILTER_NAME"]}; 

    if( empty(${$arParams["FILTER_NAME"]}) ) {
        ${$arParams["FILTER_NAME"]} = array(
            array("PROPERTY_BXR_REGION" => array($arParams["REGION_CONTENT"], false)),
        );
    }
    else {
        ${$arParams["FILTER_NAME"]} = array_merge(${$arParams["FILTER_NAME"]}, array (array("PROPERTY_BXR_REGION" => array($arParams["REGION_CONTENT"], false))));
    }
}

global $unicumID;
if ($unicumID<=0) {$unicumID = 1;} else {$unicumID++;}

$this->IncludeComponentTemplate();
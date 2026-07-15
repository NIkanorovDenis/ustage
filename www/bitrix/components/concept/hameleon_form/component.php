<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

/** @global CIntranetToolbar $INTRANET_TOOLBAR */


use Bitrix\Main\Context,
	Bitrix\Main\Type\DateTime,
	Bitrix\Main\Loader,
	Bitrix\Iblock;

global $DB_cham;
  
if(!CModule::IncludeModule("iblock"))
	return false;
    
    $arResult = array();

    $arFilter = Array('IBLOCK_CODE' => $arParams["IBLOCK_CODE"], "ID" => $arParams["CURRENT_FORM"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false);

    while($ob = $res->GetNextElement())
    {
        $arItem = $ob->GetFields();  
        $arItem["PROPERTIES"] = $ob->GetProperties();
        $arResult = $arItem;
    }
    $res = "";

    $iblockIdLand = 0;
    $res = CIBlockSection::GetByID($arParams["CURRENT_LAND"]);

    if($ar_res = $res->GetNext())
        $iblockIdLand = $ar_res['IBLOCK_ID'];

    $res="";
    if(strlen($arParams["ELEMENT_ID"])>0)
    {

        if($arParams["ELEMENT_TYPE"] == "CTL")
            $arSelect = array("NAME", "ID");

        if($arParams["ELEMENT_TYPE"] == "SRV")
            $arSelect = array("PROPERTY_SERVICE_NAME", "ID");

        if($arParams["ELEMENT_TYPE"]=="TRF")
            $arSelect = array("PROPERTY_TARIFF_NAME", "ID");

        $arFilter1 = Array("ID" => $arParams["ELEMENT_ID"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
        $res1 = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter1, false, false, $arSelect);



        while($ob1 = $res1->GetNextElement())
        {
            $arItem = $ob1->GetFields();  
            $arItem["PROPERTIES"] = $ob1->GetProperties();

            if($arParams["ELEMENT_TYPE"] == "SRV")
                $arItem["NAME"] = $arItem["~PROPERTY_SERVICE_NAME_VALUE"];

            if($arParams["ELEMENT_TYPE"]=="TRF")
                $arItem["NAME"] = $arItem["~PROPERTY_TARIFF_NAME_VALUE"];

            
            $arResult["ELEMENT"] = $arItem;
        }
        $res1 = "";
    }

	$rsSections = CIBlockSection::GetList(Array("SORT"=>"ASC"), array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ID"=>$arParams["CURRENT_LAND"]), false, array("UF_CHAM_AGREEMENTS", "UF_CHAM_AGREEMENTS_Y", "UF_CHAM_AGREE_TEXT", "ID", "UF_CHAM_PAY", "UF_CHAM_DELIV", "UF_CHAM_PAY_TITLE", "UF_CHAM_DELIV_TITLE", "UF_CHAM_UNITS", "UF_CH_BAS_CURENCIES"));
    $ar_section = $rsSections->GetNext();


    $arResult["UF_CHAM_AGREEMENTS_Y"] = $ar_section["UF_CHAM_AGREEMENTS_Y"];
    $arResult["UF_CHAM_AGREE_TEXT"] = $ar_section["~UF_CHAM_AGREE_TEXT"];

    $arResult["UF_CHAM_PAY_TITLE"] = $ar_section["~UF_CHAM_PAY_TITLE"];
    $arResult["UF_CHAM_DELIV_TITLE"] = $ar_section["~UF_CHAM_DELIV_TITLE"];

    if(!empty($ar_section["UF_CHAM_AGREEMENTS"]))
    {
        foreach($ar_section["UF_CHAM_AGREEMENTS"] as $arAgreement)
        {
            $arSelect = Array("SORT", "ID", "IBLOCK_ID", "NAME", "PREVIEW_TEXT", "PROPERTY_*");
            $arFilter = Array("ID"=>IntVal($arAgreement), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
            $res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, $arSelect);
            while($ob = $res->GetNextElement()){ 
                $arFields = $ob->GetFields();  
                $arFields["PROPERTIES"] = $ob->GetProperties();  
                $arResult["AGREEMENTS"][] = $arFields;
            }
        }
        sort($arResult["AGREEMENTS"]);
    }

    $res = "";

    global $DB_cham;
    $arResult["UF_CHAM_PAY_ENUM"] = array();
    if(!empty($ar_section["UF_CHAM_PAY"]))
    {
        foreach ($ar_section["UF_CHAM_PAY"] as $value)
        {
            if($DB_cham["PAYMENT"]["ITEMS"][$value]["ACTIVE"] == "Y")
                $arResult["UF_CHAM_PAY_ENUM"][] = $DB_cham["PAYMENT"]["ITEMS"][$value];
        }
    }
    $arResult["UF_CHAM_DELIV_ENUM"] = array();
    if(!empty($ar_section["UF_CHAM_DELIV"]))
    {
        foreach ($ar_section["UF_CHAM_DELIV"] as $value){
            if($DB_cham["DELIVERY"]["ITEMS"][$value]["ACTIVE"] == "Y")
            {
                $arItem = array();
                $arItem = $DB_cham["DELIVERY"]["ITEMS"][$value];
                $arItem["PRICE_FORMAT"] = "+ ".CHam_format::convertMain($DB_cham["DELIVERY"]["ITEMS"][$value]["PRICE"], $DB_cham["DELIVERY"]["ITEMS"][$value]["CURRENCY"], $ar_section["UF_CH_BAS_CURENCIES"]);

                $arResult["UF_CHAM_DELIV_ENUM"][] = $arItem;
           }
        }
    }

$this->includeComponentTemplate();
?>

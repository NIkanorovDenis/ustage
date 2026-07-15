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

use Bitrix\Main\Loader,
	Bitrix\Main,
	Bitrix\Iblock;

/*************************************************************************
	Processing of received parameters
*************************************************************************/
if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 36000000;

$arParams["IBLOCK_TYPE"] = trim($arParams["IBLOCK_TYPE"]);
$arParams["IBLOCK_ID"] = intval($arParams["IBLOCK_ID"]);



$arParams["TOP_DEPTH"] = intval($arParams["TOP_DEPTH"]);
if($arParams["TOP_DEPTH"] <= 0)
	$arParams["TOP_DEPTH"] = 2;
    

$arResult["SECTIONS"]=array();

/*************************************************************************
			Work with cache
*************************************************************************/
//if($this->startResultCache())
//{
	if(!Loader::includeModule("iblock"))
	{
		$this->abortResultCache();
		ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
		return;
	}
	$arFilter = array(
		"ACTIVE" => "",
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"CNT_ACTIVE" => "Y",
	);

	$arSelect = array();

    $arSelect[] = "UF_*";
	

	$arResult["SECTION"] = false;
	$intSectionDepth = 0;
    
	if($arParams["SECTION_ID"]>0)
	{
		$arFilter["ID"] = $arParams["SECTION_ID"];
		$rsSections = CIBlockSection::GetList(array("SORT"=>"ASC", "ID"=>"ASC"), $arFilter, $arParams["COUNT_ELEMENTS"], $arSelect);
		$rsSections->SetUrlTemplates("", $arParams["SECTION_URL"]);
		$arResult["SECTION"] = $rsSections->GetNext();
	}
	elseif('' != $arParams["SECTION_CODE"])
	{
		$arFilter["=CODE"] = $arParams["SECTION_CODE"];
		$rsSections = CIBlockSection::GetList(array("SORT"=>"ASC", "ID"=>"ASC"), $arFilter, $arParams["COUNT_ELEMENTS"], $arSelect);
		$rsSections->SetUrlTemplates("", $arParams["SECTION_URL"]);
		$arResult["SECTION"] = $rsSections->GetNext();
	}

	if(is_array($arResult["SECTION"]))
	{
		unset($arFilter["ID"]);
		unset($arFilter["=CODE"]);
		$arFilter["LEFT_MARGIN"]=$arResult["SECTION"]["LEFT_MARGIN"]+1;
		$arFilter["RIGHT_MARGIN"]=$arResult["SECTION"]["RIGHT_MARGIN"];
		$arFilter["<="."DEPTH_LEVEL"]=$arResult["SECTION"]["DEPTH_LEVEL"] + $arParams["TOP_DEPTH"];

		$ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues($arResult["SECTION"]["IBLOCK_ID"], $arResult["SECTION"]["ID"]);
		$arResult["SECTION"]["IPROPERTY_VALUES"] = $ipropValues->getValues();

		$arResult["SECTION"]["PATH"] = array();
		$rsPath = CIBlockSection::GetNavChain(
			$arResult["SECTION"]["IBLOCK_ID"],
			$arResult["SECTION"]["ID"],
			array(
				"ID", "CODE", "XML_ID", "EXTERNAL_ID", "IBLOCK_ID",
				"IBLOCK_SECTION_ID", "SORT", "NAME", "ACTIVE",
				"DEPTH_LEVEL", "SECTION_PAGE_URL"
			)
		);
		$rsPath->SetUrlTemplates("", $arParams["SECTION_URL"]);
		while($arPath = $rsPath->GetNext())
		{
			if ($arParams["ADD_SECTIONS_CHAIN"])
			{
				$ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues($arParams["IBLOCK_ID"], $arPath["ID"]);
				$arPath["IPROPERTY_VALUES"] = $ipropValues->getValues();
			}
			$arResult["SECTION"]["PATH"][]=$arPath;
		}
	}
	else
	{
		$arResult["SECTION"] = array("ID"=>0, "DEPTH_LEVEL"=>0);
		$arFilter["<="."DEPTH_LEVEL"] = $arParams["TOP_DEPTH"];
	}
	$intSectionDepth = $arResult["SECTION"]['DEPTH_LEVEL'];

	//ORDER BY
	$arSort = array(
        "SORT"=>"ASC", 
        "ID"=>"ASC"
		//"left_margin"=>"asc",
	);
	//EXECUTE
	$rsSections = CIBlockSection::GetList($arSort, $arFilter, $arParams["COUNT_ELEMENTS"], $arSelect);
	$rsSections->SetUrlTemplates("", $arParams["SECTION_URL"]);
	while($arSection = $rsSections->GetNext())
	{
		$ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues($arSection["IBLOCK_ID"], $arSection["ID"]);
		$arSection["IPROPERTY_VALUES"] = $ipropValues->getValues();

		if ($boolPicture)
		{
			Iblock\Component\Tools::getFieldImageData(
				$arSection,
				array('PICTURE'),
				Iblock\Component\Tools::IPROPERTY_ENTITY_SECTION,
				'IPROPERTY_VALUES'
			);
		}
		$arSection['RELATIVE_DEPTH_LEVEL'] = $arSection['DEPTH_LEVEL'] - $intSectionDepth;

		$arButtons = CIBlock::GetPanelButtons(
			$arSection["IBLOCK_ID"],
			0,
			$arSection["ID"],
			array("SESSID"=>false, "CATALOG"=>true)
		);
		$arSection["EDIT_LINK"] = $arButtons["edit"]["edit_section"]["ACTION_URL"];
		$arSection["DELETE_LINK"] = $arButtons["edit"]["delete_section"]["ACTION_URL"];

		$arResult["SECTIONS"][]=$arSection;
	}

	$arResult["SECTIONS_COUNT"] = count($arResult["SECTIONS"]);



	// forms


	$code_form = 'concept_hameleon_forms';

	$arSelect = Array("SORT", "ID", "NAME", "IBLOCK_SECTION_ID", "IBLOCK_ID");
	$arFilter = Array("IBLOCK_CODE"=> $code_form);
	$res = CIBlockElement::GetList(Array("sort"=>"asc"), $arFilter, false, false, $arSelect);
	while($ob = $res->GetNextElement())
	{

		$arFields = $ob->GetFields();

		if(strlen($arResult["FORMS_ELEMENTS_IBLOCK_ID"])<=0)
			$arResult["FORMS_ELEMENTS_IBLOCK_ID"] = $arFields['IBLOCK_ID'];


		$arResult["FORMS_ELEMENTS"][] = $arFields;

		if(strlen($arFields["IBLOCK_SECTION_ID"])<=0)
			$arResult["FORMS_ELEMENTS_NO_SECTION"][] = $arFieldsModal;

	}

	$arSelect = Array("SORT", "ID", "NAME", "IBLOCK_ID");
	$dbResSect = CIBlockSection::GetList(
	   Array("SORT"=>"ASC"),
	   Array("IBLOCK_CODE"=> $code_form),
	   false,
	   $arSelect
	);

	//Получаем разделы и собираем в массив
	while($sectRes = $dbResSect->GetNext())
	{
		$arSections[] = $sectRes;
	}

	//Собираем  массив из Разделов и элементов
    if(!empty($arSections))
    {
        foreach($arSections as $arSection){  
		
    		foreach($arResult["FORMS_ELEMENTS"] as $key=>$arItem){
    			
    			 if($arItem['IBLOCK_SECTION_ID'] == $arSection['ID']){
    				$arSection['ELEMENTS'][] =  $arItem;
    			 }
    		}
    		asort($arSection['ELEMENTS']);
    		
    		$arElementGroups[] = $arSection;
    	}
  
    	$arResult["FORMS_IN_SECTION"] = $arElementGroups;
    }


	



	// modals
	$code_modal = 'concept_hameleon_site_modal';

	$arSelect = Array("SORT", "ID", "NAME", "IBLOCK_SECTION_ID", "IBLOCK_ID");
	$arFilterModal = Array("IBLOCK_CODE"=> $code_modal);
	$resModal = CIBlockElement::GetList(Array("sort"=>"asc"), $arFilterModal, false, false, $arSelect);
	while($obModal = $resModal->GetNextElement())
	{

		$arFieldsModal = $obModal->GetFields();

		if(strlen($arResult["MODALS_ELEMENTS_IBLOCK_ID"])<=0)
			$arResult["MODALS_ELEMENTS_IBLOCK_ID"] = $arFieldsModal['IBLOCK_ID'];

		
		$arResult["MODALS_ELEMENTS"][] = $arFieldsModal;

		if(strlen($arFieldsModal["IBLOCK_SECTION_ID"]) <= 0)
			$arResult["MODALS_ELEMENTS_NO_SECTION"][] = $arFieldsModal;

	}




	$arSelect = Array("SORT", "ID", "NAME", "IBLOCK_ID");
	$dbResSectModal = CIBlockSection::GetList(
	   Array("SORT"=>"ASC"),
	   Array("IBLOCK_CODE"=> $code_modal),
	   false,
	   $arSelect
	);

	//Получаем разделы и собираем в массив
	while($sectResModal = $dbResSectModal->GetNext())
	{
		$arSectionsModal[] = $sectResModal;
	}

	//Собираем  массив из Разделов и элементов

	if(!empty($arSectionsModal) && is_array($arSectionsModal))
	{


		foreach($arSectionsModal as $arSectionModal){  

			if(!empty($arResult["MODALS_ELEMENTS"]) && is_array($arResult["MODALS_ELEMENTS"]))
			{
				foreach($arResult["MODALS_ELEMENTS"] as $key=>$arItem){
				
				 if($arItem['IBLOCK_SECTION_ID'] == $arSectionModal['ID']){
						$arSectionModal['ELEMENTS'][] =  $arItem;
					 }
				}

			}

			asort($arSectionModal['ELEMENTS']);

			$arElementGroupsModal[] = $arSectionModal;
		}

	}

	$arResult["MODALS_IN_SECTION"] = $arElementGroupsModal;




	$this->setResultCacheKeys(array(
		"SECTIONS_COUNT",
		"SECTION",
	));

	$this->includeComponentTemplate();
//}

?>
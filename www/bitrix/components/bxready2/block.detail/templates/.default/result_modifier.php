<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

if(strlen($arResult["DATE_ACTIVE_FROM"])>0)
	$arResult["DISPLAY_ACTIVE_FROM"] = CIBlockFormatProperties::DateFormat($arParams["ACTIVE_DATE_FORMAT"], MakeTimeStamp($arResult["DATE_ACTIVE_FROM"], CSite::GetDateFormat()));
else
	$arResult["DISPLAY_ACTIVE_FROM"] = "";

if(strlen($arResult["DATE_ACTIVE_TO"])>0)
	$arResult["DISPLAY_ACTIVE_TO"] = CIBlockFormatProperties::DateFormat($arParams["ACTIVE_DATE_FORMAT"], MakeTimeStamp($arResult["DATE_ACTIVE_TO"], CSite::GetDateFormat()));
else
	$arResult["DISPLAY_ACTIVE_TO"] = "";

if (
	$arParams['SKU']['SKU_MODE'] == "Y"
	&& intval($arParams['SKU']['SKU_IBLOCK_ID'])>0
){
	foreach($arParams['SKU']['SKU_PROPERTY_CODE'] as $cell=>$val){
		if (strlen($val) <= 0){
			unset($arParams['SKU']['SKU_PROPERTY_CODE'][$cell]);
		}else{
			$arParams['SKU']['SKU_PROPERTY_CODE'][$cell] = 'PROPERTY_'.$val;
		}
	}

	$arFields = array_merge($arParams['SKU']['SKU_FIELD_CODE'], $arParams['SKU']['SKU_PROPERTY_CODE']);
	foreach($arFields as $cell=>$val){
		if (strlen($val) <= 0){
			unset($arFields[$cell]);
		}
	}

	if (count($arFields)>0){

		$arFilter = Array(
			"IBLOCK_ID"=>intval($arParams['SKU']['SKU_IBLOCK_ID']),
			"ACTIVE_DATE"=>"Y",
			"ACTIVE"=>"Y",
			"PROPERTY_CML2_LINK" => $arResult['ID']
		);
                

                $arFields[] = "ID";
                $arFields[] = "IBLOCK_ID";
                

		$res = CIBlockElement::GetList(Array('sort'=>'asc'), $arFilter, false, Array("nPageSize"=>50), $arFields);
		while($ob = $res->GetNextElement())
		{
                    $arFields = $ob->GetFields();
                    
                    /*EDIT_LINK*/
                    $arButtons = CIBlock::GetPanelButtons(
                        $arFilter["IBLOCK_ID"],
                        $arFields["ID"],
                        0,
                        array("SECTION_BUTTONS"=>false, "SESSID"=>false)
                    );                    
                    $arFields["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"];
                    /*END EDIT_LINK*/       
                    
                    $arFields["PROPERTIES"] = $ob->GetProperties();                    
                    $arResult['OFFERS'][] = $arFields;
		}
	}
}

$arTabs = array(
	'TABS'=>array(
		'DETAIL' => 1,
                'SKU' => 2,
		'PROPERTIES' => 3,
		'SCHEMES' => 4,
		'FILES' => 5,
		'VIDEO' => 6,
		'INC' => 7,
		'SMARTPRICE'=>8
	),
	'DETAIL'=>array(

	)
);


if(isset($arParams['SKU']['SKU_MODE']) && $arParams['SKU']['SKU_MODE']=="Y")
    $arParams["BXR_DETAIL_TABS"]["BXR_DETAIL_TAB_SKU"] = "Y";

foreach($arTabs['TABS'] as $cell=>$val){

	if ($cell != 'DETAIL'){
		if ($arParams["BXR_DETAIL_TABS"]['BXR_DETAIL_TAB_'.$cell] == "Y"){
			foreach($arParams['BXR_DETAIL_TABS'] as $cell2=>$val2){
				if (substr($cell2,0,15+strlen($cell)) == 'BXR_DETAIL_TAB_'.$cell){
					$caption = str_replace('BXR_DETAIL_TAB_'.$cell.'_','', $cell2);
					str_replace('BXR_DETAIL_TAB_'.$cell,'', $caption);
					$arTabs['DETAIL'][$cell][$caption] = $val2;
					if ($caption == 'SORT'){
						$arTabs['TABS'][$cell] = intval($val2);
					}
				}
			}
		}else{
			unset($arTabs['TABS'][$cell]);
		}
	}else{

		if ($arParams['BXR_DETAIL_TABS']['BXR_DETAIL_TAB_TEXT'] != 'tabs'){
			unset($arTabs['TABS']['DETAIL']);
		}else{

			$arTabs['DETAIL']['DETAIL'] = array(
				'CAPTION'=>$arParams['BXR_DETAIL_TABS']['BXR_DETAIL_TAB_TEXT_CAPTION'],
				'LINK'=>$arParams['BXR_DETAIL_TABS']['BXR_DETAIL_TAB_TEXT_LINK'],
				'GLYPH'=>$arParams['BXR_DETAIL_TABS']['BXR_DETAIL_TAB_TEXT_GLYPH'],
			);
		}
	}
}

if (count($arTabs['TABS'])>0){
	asort($arTabs['TABS']);
}

$excludeProperties = array(
	'FILES',
	'BXR_RELATED',
	'MORE_PHOTO',
	'BXR_VIDEO',

	'BXR_PRICE',
	'BXR_UNIT_PRICE',
	'BXR_DISCOUNT_PRICE',
	'BXR_DISCOUNT_PERIOD_FROM',
	'BXR_DISCOUNT_PERIOD_TO',
	'BXR_DISCOUNT_TIMER',
	'BXR_OFFER_DETAIL',
	'BXR_FILES',
	'BXR_SCHEMES',

);

$arSmartLink = array();

if (!is_array($arParams["DETAIL_FIELD_CODE"])) $arParams["DETAIL_FIELD_CODE"] = array();

if(substr_count($arResult["DETAIL_TEXT"], "#CONTENT_INNER_BUFFER#")>0){
	$arResult["DETAIL_TEXT"] = str_replace('#CONTENT_INNER_BUFFER#', '', $arResult["DETAIL_TEXT"]);
}


if (
	$arParams['BXR_PICTURE']['BXR_DETAIL_PICTURE_TYPE'] == 'slider'
	|| $arParams['BXR_PICTURE']['BXR_DETAIL_PICTURE_TYPE'] == 'fullsize_slider'
){
	$productSlider = array();
	if (is_array($arResult["DETAIL_PICTURE"])){
		$productSlider[] = $arResult["DETAIL_PICTURE"];
	}

	if (is_array($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"])
		&& is_array($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"])
		&& count($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"])>0){

		foreach($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $val){
			$productSlider[] = CFile::GetFileArray($val);
		}
	}
	$arResult['IMAGES'] = $productSlider;

	$sizeMatrix = $arParams['BXR_PICTURE']['BXR_DETAIL_PICTURE_TYPE'] == 'fullsize_slider' ? array('width'=>900, 'height'=>$arParams['BXR_PICTURE']['BXR_SLIDER_HEIGHT']) : array('width'=>500, 'height'=>375);

	foreach($arResult["IMAGES"] as &$image){
		$tmb = CFile::ResizeImageGet($image["ID"], $sizeMatrix, BX_RESIZE_IMAGE_PROPORTIONAL, true);
		foreach ($tmb as $cell=>$val){
			$image["TMB"][strtoupper($cell)] = $val;
		}
	}
}

$arResult["BXR_FILES"] = array();

if ($arParams["BXR_DETAIL_TABS"]['BXR_DETAIL_TAB_FILES'] == "Y"){

    if (CModule::IncludeModule('alexkova.business')){
        $ufProperty = \Alexkova\Business\Core::getUfSection($arParams["IBLOCK_ID"], $arResult["IBLOCK_SECTION_ID"], "UF_FILES");

        if(is_array($ufProperty) && !empty($ufProperty)) {            
            if(!empty($arResult['PROPERTIES']['BXR_FILES']['VALUE']))
                $arResult["PROPERTIES"]["BXR_FILES"]["VALUE"] = array_merge($arResult["PROPERTIES"]["BXR_FILES"]["VALUE"], $ufProperty);
            else
                $arResult["PROPERTIES"]["BXR_FILES"]["VALUE"] =  $ufProperty;
        }
    }
    
	if (is_array($arResult['PROPERTIES']['BXR_FILES']['VALUE']) && count($arResult['PROPERTIES']['BXR_FILES']['VALUE'])>0){
		foreach($arResult['PROPERTIES']['BXR_FILES']['VALUE'] as $cell => $val){
			$arFileData = CFile::GetFileArray($val);
			$arFileData['DESCRIPTION'] = $arResult['PROPERTIES']['BXR_FILES']['DESCRIPTION'][$cell];
			$arResult["FILES"][] = $arFileData;
		};
		if (strlen($arParams["BXR_DETAIL_TABS"]["BXR_DETAIL_TAB_FILES_LINK"]) > 0){
			$arSmartLink['FILES'] = array(
				"NAME" => $arParams["BXR_DETAIL_TABS"]["BXR_DETAIL_TAB_FILES_LINK"],
				"LINK" => "FILES",
				"TYPE" => "tab"
			);
		}
	}else{
		unset($arTabs['TABS']['FILES']);
	}
}

$arResult["SCHEMES"] = array();



if ($arParams["BXR_DETAIL_TABS"]['BXR_DETAIL_TAB_SCHEMES'] == "Y"){

    if (CModule::IncludeModule('alexkova.business')){
        $ufProperty = \Alexkova\Business\Core::getUfSection($arParams["IBLOCK_ID"], $arResult["IBLOCK_SECTION_ID"], "UF_SCHEMES");

        if(is_array($ufProperty) && !empty($ufProperty)) {            
            if(!empty($arResult['PROPERTIES']['BXR_SCHEMES']['VALUE']))
                $arResult["PROPERTIES"]["BXR_SCHEMES"]["VALUE"] = array_merge($arResult["PROPERTIES"]["BXR_SCHEMES"]["VALUE"], $ufProperty);
            else
                $arResult["PROPERTIES"]["BXR_SCHEMES"]["VALUE"] =  $ufProperty;
        }
    }

	if (is_array($arResult['PROPERTIES']['BXR_SCHEMES']['VALUE']) && count($arResult['PROPERTIES']['BXR_SCHEMES']['VALUE'])>0){
		foreach($arResult['PROPERTIES']['BXR_SCHEMES']['VALUE'] as $cell => $val){
			$arResult["SCHEMES"][] = CFile::GetFileArray($val);
		};
		if (strlen($arParams["BXR_DETAIL_TABS"]["BXR_DETAIL_TAB_SCHEMES_LINK"]) >0){
			$arSmartLink['SCHEMES'] = array(
				"NAME" => $arParams["BXR_DETAIL_TABS"]["BXR_DETAIL_TAB_SCHEMES_LINK"],
				"LINK" => "SCHEMES",
				"TYPE" => "tab"
			);
		}
	}else{
		unset($arTabs['TABS']['SCHEMES']);
	}
}

$arResult["VIDEO"] = array();



if ($arParams["BXR_DETAIL_TABS"]['BXR_DETAIL_TAB_VIDEO'] == "Y"){
    
    if (CModule::IncludeModule('alexkova.business')){
        $ufProperty = \Alexkova\Business\Core::getUfSection($arParams["IBLOCK_ID"], $arResult["IBLOCK_SECTION_ID"], "~UF_VIDEO");

        if(is_array($ufProperty) && !empty($ufProperty)) {
            foreach ($ufProperty as $k => $v) {
                $ufProperty[$k] = unserialize($v);

            }
            if(!empty($arResult['PROPERTIES']['BXR_VIDEO']['VALUE']))
                $arResult["PROPERTIES"]["BXR_VIDEO"]["VALUE"] = array_merge($arResult["PROPERTIES"]["BXR_VIDEO"]["VALUE"], $ufProperty);
            else
                $arResult["PROPERTIES"]["BXR_VIDEO"]["VALUE"] =  $ufProperty;
        }
    }

	if (is_array($arResult['PROPERTIES']['BXR_VIDEO']['VALUE']) && count($arResult['PROPERTIES']['BXR_VIDEO']['VALUE'])>0){
		foreach($arResult['PROPERTIES']['BXR_VIDEO']['VALUE'] as $cell => $val){
			$arResult["VIDEO"][] = $val;
		};
		if (strlen($arParams["BXR_DETAIL_TABS"]["BXR_DETAIL_TAB_VIDEO_LINK"])>0){
			$arSmartLink['VIDEO'] = array(
				"NAME" => $arParams["BXR_DETAIL_TABS"]["BXR_DETAIL_TAB_VIDEO_LINK"],
				"LINK" => "VIDEO",
				"TYPE" => "tab"
			);
		}
	}else{
		unset($arTabs['TABS']['VIDEO']);
	}
}


foreach ($arResult['DISPLAY_PROPERTIES'] as $cell=>$val){
	if (in_array($cell, $excludeProperties)){
		unset($arResult['DISPLAY_PROPERTIES'][$cell]);
	}
}


if ($arParams["BXR_DETAIL_TABS"]["BXR_DETAIL_TAB_PROPERTIES"] == "Y"){
	if (count($arResult['DISPLAY_PROPERTIES'])>0){
		if (strlen($arParams["BXR_DETAIL_TABS"]["BXR_DETAIL_TAB_PROPERTIES_LINK"]) >0){
			$arSmartLink['PROPERTIES'] = array(
				"NAME" => $arParams["BXR_DETAIL_TABS"]["BXR_DETAIL_TAB_PROPERTIES_LINK"],
				"LINK" => "PROPERTIES",
				"TYPE" => "tab"
			);
		}
	}else{
		unset($arTabs['TABS']['PROPERTIES']);
	}
}

if ($arParams["BXR_DETAIL_TABS"]["BXR_DETAIL_TAB_SKU"] == "Y"){
	if (count($arResult['OFFERS'])>0){
		if (strlen($arParams["BXR_DETAIL_TABS"]["BXR_DETAIL_TAB_SKU_LINK"]) >0){
			$arSmartLink['SKU'] = array(
				"NAME" => $arParams["BXR_DETAIL_TABS"]["BXR_DETAIL_TAB_SKU_LINK"],
				"LINK" => "SKU",
				"TYPE" => "tab"
			);
		}
	}else{
		unset($arTabs['TABS']['SKU']);
	}
}

if ($arParams["BXR_DETAIL_TABS"]["BXR_DETAIL_TAB_INC"] == "Y"){
    if (strlen($arParams["BXR_DETAIL_TABS"]["BXR_DETAIL_TAB_INC_LINK"]) >0){ 
	$arSmartLink['INC'] = array(
		"NAME" => $arParams["BXR_DETAIL_TABS"]["BXR_DETAIL_TAB_INC_LINK"],
		"LINK" => "INC",
		"TYPE" => "tab"
	);
    }
}


$arResult['TABS'] = $arTabs;

if (count($arSmartLink)>0){

	$arSmarts = array(
		'DETAIL'=>array(
			"NAME" => $arParams["BXR_DETAIL_TABS"]["BXR_DETAIL_TAB_TEXT_LINK"],
			"LINK" => "DETAIL",
			"TYPE" => $arParams["BXR_DETAIL_TABS"]["BXR_DETAIL_TAB_TEXT"] == 'detail' ? "all" : "tab"
		)
	);

	foreach ($arTabs['TABS'] as $cell=>$val){
		if (isset($arSmartLink[$cell])){
			$arSmarts[$cell] = array(
				"NAME" => $arSmartLink[$cell]["NAME"],
				"LINK" => $arSmartLink[$cell]["LINK"]
			);
		}

	}


	$cp = $this->__component;

	if (is_object($cp))
	{
		$cp->arResult['SMART_LINK'] = $arSmarts;

		$cp->SetResultCacheKeys(array('SMART_LINK'));

		if (!isset($arResult['SMART_LINK']))
		{
			$arResult['SMART_LINK'] = $cp->arResult['SMART_LINK'];
		}
	}
}
?>

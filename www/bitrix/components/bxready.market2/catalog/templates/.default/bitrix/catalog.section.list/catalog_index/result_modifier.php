<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arViewModeList = array('LIST', 'LINE', 'TEXT', 'TILE');

$arDefaultParams = array(
	'VIEW_MODE' => 'LIST',
	'SHOW_PARENT_NAME' => 'Y',
	'HIDE_SECTION_NAME' => 'N'
);

if(isset($arResult["SECTION"]["IPROPERTY_VALUES"]) && is_array($arResult["SECTION"]["IPROPERTY_VALUES"])) {
    $arResult["SECTION"]["IPROPERTY_VALUES"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["SECTION"]["IPROPERTY_VALUES"]);
}

if(isset($arResult["SECTIONS"]) && is_array($arResult["SECTIONS"])) {
    foreach ($arResult["SECTIONS"] as $k => $v) {

        if(isset($v["NAME"]) && !empty($v["NAME"])) {
            $arResult["SECTIONS"][$k]["NAME"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["SECTIONS"][$k]["NAME"]);
            $arResult["SECTIONS"][$k]["~NAME"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["SECTIONS"][$k]["~NAME"]);
        }
        
        if(isset($v["PICTURE"]) && is_array($v["PICTURE"])) {
            if(isset($v["PICTURE"]["ALT"]) && !empty($v["PICTURE"]["ALT"])) {
                $arResult["SECTIONS"][$k]["PICTURE"]["ALT"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["SECTIONS"][$k]["PICTURE"]["ALT"] );
            }
            
            if(isset($v["PICTURE"]["TITLE"]) && !empty($v["PICTURE"]["TITLE"])) {
                $arResult["SECTIONS"][$k]["PICTURE"]["TITLE"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["SECTIONS"][$k]["PICTURE"]["TITLE"] );
            }
        }
        
        if(isset($v["DESCRIPTION"]) && !empty($v["DESCRIPTION"])) {
            $arResult["SECTIONS"][$k]["DESCRIPTION"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["SECTIONS"][$k]["DESCRIPTION"]);        
            $arResult["SECTIONS"][$k]["~DESCRIPTION"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["SECTIONS"][$k]["~DESCRIPTION"]);
        }
        
        if(isset($v["SEARCHABLE_CONTENT"]) && !empty($v["SEARCHABLE_CONTENT"])) {
            $arResult["SECTIONS"][$k]["SEARCHABLE_CONTENT"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["SECTIONS"][$k]["SEARCHABLE_CONTENT"]);        
            $arResult["SECTIONS"][$k]["~SEARCHABLE_CONTENT"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["SECTIONS"][$k]["~SEARCHABLE_CONTENT"]);
        }
        
        if(isset($v["IPROPERTY_VALUES"]) && is_array($v["IPROPERTY_VALUES"])) {
            $arResult["SECTIONS"][$k]["IPROPERTY_VALUES"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["SECTIONS"][$k]["IPROPERTY_VALUES"]);
        }
    }
}

if(isset($arResult["SECTION"]["PATH"]) && is_array($arResult["SECTION"]["PATH"])) {
    foreach ($arResult["SECTION"]["PATH"] as $k => $v) {
        if(isset($v["IPROPERTY_VALUES"]) && is_array($v["IPROPERTY_VALUES"])) {
            $arResult["SECTION"]["PATH"][$k]["IPROPERTY_VALUES"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["SECTION"]["PATH"][$k]["IPROPERTY_VALUES"]);
        }
    }
}

$arParams = array_merge($arDefaultParams, $arParams);

if (!in_array($arParams['VIEW_MODE'], $arViewModeList))
	$arParams['VIEW_MODE'] = 'LIST';
if ('N' != $arParams['SHOW_PARENT_NAME'])
	$arParams['SHOW_PARENT_NAME'] = 'Y';
if ('Y' != $arParams['HIDE_SECTION_NAME'])
	$arParams['HIDE_SECTION_NAME'] = 'N';

$arResult['VIEW_MODE_LIST'] = $arViewModeList;

if (0 < $arResult['SECTIONS_COUNT'])
{
	if ('LIST' != $arParams['VIEW_MODE'])
	{
		$boolClear = false;
		$arNewSections = array();
		foreach ($arResult['SECTIONS'] as &$arOneSection)
		{
			if (1 < $arOneSection['RELATIVE_DEPTH_LEVEL'])
			{
				$boolClear = true;
				continue;
			}
			$arNewSections[] = $arOneSection;
		}
		unset($arOneSection);
		if ($boolClear)
		{
			$arResult['SECTIONS'] = $arNewSections;
			$arResult['SECTIONS_COUNT'] = count($arNewSections);
		}
		unset($arNewSections);
	}
}

if (0 < $arResult['SECTIONS_COUNT'])
{
	$boolPicture = false;
	$boolDescr = false;
	$arSelect = array('ID');
	$arMap = array();
	if ('LINE' == $arParams['VIEW_MODE'] || 'TILE' == $arParams['VIEW_MODE'])
	{
		reset($arResult['SECTIONS']);
		$arCurrent = current($arResult['SECTIONS']);
		if (!isset($arCurrent['PICTURE']))
		{
			$boolPicture = true;
			$arSelect[] = 'PICTURE';
		}
		if ('LINE' == $arParams['VIEW_MODE'] && !array_key_exists('DESCRIPTION', $arCurrent))
		{
			$boolDescr = true;
			$arSelect[] = 'DESCRIPTION';
			$arSelect[] = 'DESCRIPTION_TYPE';
		}
	}
	if ($boolPicture || $boolDescr)
	{
		foreach ($arResult['SECTIONS'] as $key => $arSection)
		{
			$arMap[$arSection['ID']] = $key;
		}
		$rsSections = CIBlockSection::GetList(array(), array('ID' => array_keys($arMap)), false, $arSelect);
		while ($arSection = $rsSections->GetNext())
		{
			if (!isset($arMap[$arSection['ID']]))
				continue;
			$key = $arMap[$arSection['ID']];
			if ($boolPicture)
			{
				$arSection['PICTURE'] = intval($arSection['PICTURE']);
				$arSection['PICTURE'] = (0 < $arSection['PICTURE'] ? CFile::GetFileArray($arSection['PICTURE']) : false);
				$arResult['SECTIONS'][$key]['PICTURE'] = $arSection['PICTURE'];
				$arResult['SECTIONS'][$key]['~PICTURE'] = $arSection['~PICTURE'];
			}
			if ($boolDescr)
			{
				$arResult['SECTIONS'][$key]['DESCRIPTION'] = $arSection['DESCRIPTION'];
				$arResult['SECTIONS'][$key]['~DESCRIPTION'] = $arSection['~DESCRIPTION'];
				$arResult['SECTIONS'][$key]['DESCRIPTION_TYPE'] = $arSection['DESCRIPTION_TYPE'];
				$arResult['SECTIONS'][$key]['~DESCRIPTION_TYPE'] = $arSection['~DESCRIPTION_TYPE'];
			}
		}
	}
}
?>
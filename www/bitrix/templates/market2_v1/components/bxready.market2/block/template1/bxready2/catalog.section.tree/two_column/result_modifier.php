<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arResult['ELEMENTS'] = array();

if(isset($arResult["SECTION"]["IPROPERTY_VALUES"]) && is_array($arResult["SECTION"]["IPROPERTY_VALUES"])) {
    $arResult["SECTION"]["IPROPERTY_VALUES"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["SECTION"]["IPROPERTY_VALUES"]);
}

if(isset($arResult["SECTIONS"]) && is_array($arResult["SECTIONS"])) {
    foreach ($arResult["SECTIONS"] as $k => $v) {
        if(isset($v["IPROPERTY_VALUES"]) && is_array($v["IPROPERTY_VALUES"])) {
            $arResult["SECTIONS"][$k]["IPROPERTY_VALUES"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["SECTIONS"][$k]["IPROPERTY_VALUES"]);
        }
        $arResult["SECTIONS"][$k]["DESCRIPTION"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["SECTIONS"][$k]["DESCRIPTION"]);
    }
}

if(isset($arResult["SECTION"]["PATH"]) && is_array($arResult["SECTION"]["PATH"])) {
    foreach ($arResult["SECTION"]["PATH"] as $k => $v) {
        if(isset($v["IPROPERTY_VALUES"]) && is_array($v["IPROPERTY_VALUES"])) {
            $arResult["SECTION"]["PATH"][$k]["IPROPERTY_VALUES"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult["SECTION"]["PATH"][$k]["IPROPERTY_VALUES"]);
        }
    }
}

foreach ($arResult['SECTION_TREE']['CHILD'] as $cell=>$val){
    
        if(isset($val["IPROPERTY_VALUES"]) && is_array($val["IPROPERTY_VALUES"])) {
            $arResult['SECTION_TREE']['CHILD'][$cell]["IPROPERTY_VALUES"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult['SECTION_TREE']['CHILD'][$cell]["IPROPERTY_VALUES"]);
        }
            
        $arResult['SECTION_TREE']['CHILD'][$cell]["DESCRIPTION"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult['SECTION_TREE']['CHILD'][$cell]["DESCRIPTION"]);
        $arResult['SECTION_TREE']['CHILD'][$cell]["~DESCRIPTION"] = \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($arResult['SECTION_TREE']['CHILD'][$cell]["~DESCRIPTION"]);
        $val["DESCRIPTION"] =  \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($val["DESCRIPTION"]);
        $val["~DESCRIPTION"] =  \Alexkova\Market2\Bxmarket::replaceRegionMegaTags($val["~DESCRIPTION"]);

	$arSection = array(
		"NAME" => $arResult['SECTIONS'][$cell]["NAME"],
		"DETAIL_PAGE_URL" => $arResult['SECTIONS'][$cell]["SECTION_PAGE_URL"]
	);

	if ($arParams['COUNT_ELEMENTS'] == "Y" && intval($arResult['SECTIONS'][$cell]['ELEMENT_CNT'])>0){
		$arSection['NAME'] .= ' ('.$arResult['SECTIONS'][$cell]['ELEMENT_CNT'].')';
	}

	if (is_array($val["PICTURE"]) && strlen($val["PICTURE"]['SRC'])>0){
		$arSection['PREVIEW_PICTURE'] = $val["PICTURE"];
	}

	if (strlen($val["DESCRIPTION"])>0){
		if (substr_count($val["DESCRIPTION"], '#STEXT#')){
			$arDesc = explode('#STEXT#', $val['DESCRIPTION']);
			$val['DESCRIPTION'] = $arDesc[0];
		}
		$arSection['PREVIEW_TEXT'] = $val["DESCRIPTION"];
	}

	if (count($val['CHILD'])>0){
		foreach ($val['CHILD'] as $cell2=>$child){
			$arChild = array(
				'NAME' => $child["NAME"],
				'DETAIL_PAGE_URL' => $child['SECTION_PAGE_URL']
			);

			if ($arParams['COUNT_ELEMENTS'] == "Y" && intval($arResult['SECTIONS'][$cell2]['ELEMENT_CNT'])>0){
				$arChild['NAME'] .= ' ('.$arResult['SECTIONS'][$cell2]['ELEMENT_CNT'].')';
			}

			$arSection['CHILD'][$cell2] = $arChild;
		}
	}

	$arResult["ELEMENTS"][$cell] = $arSection;
}
?>
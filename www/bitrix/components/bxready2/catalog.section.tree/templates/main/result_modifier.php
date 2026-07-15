<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!empty($arParams["IBLOCK_ID"]) && (isset($arParams["SHOW_SECTION_NAME"]) && $arParams["SHOW_SECTION_NAME"]=="Y")
  ||(isset($arParams["SHOW_SECTION_DESCRIPTION"]) && $arParams["SHOW_SECTION_DESCRIPTION"]=="Y")) {
    $res = CIBlock::GetByID($arParams["IBLOCK_ID"]);
    if($ar_res = $res->GetNext()) {
        $arResult['IB']['NAME'] = $ar_res['NAME'];
        $arResult['IB']['DESCRIPTION'] = $ar_res['DESCRIPTION'];
    }
}

$arResult['ELEMENTS'] = array();

foreach ($arResult['SECTION_TREE']['CHILD'] as $cell=>$val){

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
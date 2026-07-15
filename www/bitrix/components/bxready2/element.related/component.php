<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arResult = array();

if (!CModule::IncludeModule('alexkova.bxready2')) return;

$elementID = 0;

if (intval($arParams["ELEMENT_ID"])>0){
	$elementID = intval($arParams["ELEMENT_ID"]);
}elseif(intval($arParams["IBLOCK_ELEMENT_ID_VARIABLE"])>0)
{
	$elementID = intval($arParams["IBLOCK_ELEMENT_ID_VARIABLE"]);
}else{
	return;
}

if ($this->StartResultCache()){

	$related = \Alexkova\Bxready2\Related::getRelatedElements($elementID, \Alexkova\Bxready2\Component::getRelatedIblockList($arParams));

	if (is_array($related)){
		$arResult['RELATED'] = $related;
		$arResult["RELATED_SECTIONS"] = \Alexkova\Bxready2\Component::prepareRelatedParams($arParams);
	}else{
		$this->AbortResultCache();
	}
}

$this->IncludeComponentTemplate($templatePage);

?>
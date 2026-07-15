<?
$arTabs = $arResult['TABS'];
$coreIncludePath = $_SERVER['DOCUMENT_ROOT'].$this->GetFolder()."/include/tabs/";

if (count($arTabs['TABS'])>0){

	$tabType = $arParams['BXR_DETAIL_TABS']['BXR_DETAIL_TAB_TYPE'];

	foreach ($arTabs['TABS'] as $cell=>$val){
		$elementarArea = \Alexkova\Bxready2\Elementars::getArea('catalog.element','element.tab.'.strtolower($cell));
		$arTabs['DETAIL'][$cell]['PATH'] = (strlen($elementarArea) > 0) ? $elementarArea : $coreIncludePath."/tab.".strtolower($cell).".php";
	}

	$elementarArea = \Alexkova\Bxready2\Elementars::getArea('catalog.element','element.tabs.'.$tabType);
	if (strlen($elementarArea) > 0)
		include($elementarArea);
	else
		include ('tabs/'.$tabType.'.php');
}
?>
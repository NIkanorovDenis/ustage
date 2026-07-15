<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if (count($arResult['SMART_LINK'])>0){
	global $arGlobalSmartLink;
	if (!isset($arGlobalSmartLink) || !is_array($arGlobalSmartLink)){
		$arGlobalSmartLink = $arResult['SMART_LINK'];
	}
}else{
    if(!empty($arResult['SMART_LINK']))
	foreach ($arResult['SMART_LINK'] as $cell=>$val){
		$arGlobalSmartLink[$cell] = $val;
	}
}

if (is_array($arParams['BXR_FORMS']) && count($arParams['BXR_FORMS'])>0){

	$arParams['BXR_FORMS']["EVENT_CLASS"] = 'bxr-color-button';
	$arParams['BXR_FORMS']["COMPONENT_TEMPLATE"] = "request_product";

	$arParams['BXR_FORMS']['EVENT_CLASS'] .= ' hidden-lg hidden-md hidden-sm hidden-xs';

	$APPLICATION->IncludeComponent(
		"alexkova.business:form.iblock",
		"request_product",
		$arParams['BXR_FORMS'],
		false,
		array('HIDE_ICONS' => 'Y')
	);

}
?>
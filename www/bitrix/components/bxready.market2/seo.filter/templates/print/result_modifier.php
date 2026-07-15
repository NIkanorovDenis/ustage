<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$arResult['FILTER_SUMMARY'] = array();
$arResult['FILTER_ADD_STRING'] = '';
foreach ($arResult['ITEMS'] as $cell=>$val) {
	foreach($val['VALUES'] as $item) {
		$checkItem = substr($item['CONTROL_ID'], strlen($arParams['FILTER_NAME']), strlen($item['CONTROL_ID']) - strlen($arParams['FILTER_NAME']));
		if ($arResult['SHORT_CHECK'][$checkItem] == "Y") {
			$arResult['FILTER_SUMMARY'][$cell]["ITEMS"][] = $item;
			$arResult['FILTER_ADD_STRING'] .= '&'.$item['CONTROL_ID'].'=Y';
		}
	}
	if (isset($arResult['FILTER_SUMMARY'][$cell]["ITEMS"]) && count($arResult['FILTER_SUMMARY'][$cell]["ITEMS"]) > 0) {
		$items = $arResult['FILTER_SUMMARY'][$cell]["ITEMS"];
		$arResult['FILTER_SUMMARY'][$cell] = $val;
		unset($arResult['FILTER_SUMMARY'][$cell]['VALUES']);
		$arResult['FILTER_SUMMARY'][$cell]["ITEMS"] = $items;
	}
}
if (count($arResult['FILTER_SUMMARY'])) {
	$arResult['FILTER_ADD_STRING'] .= '&set_filter=y';
}
?>
<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>
<?
$arTabs = $arResult['TABS'];

if (count($arTabs['TABS'])>0){

	if ($arParams['BXR_DETAIL_TABS']['BXR_DETAIL_TAB_TYPE'] == 'tabs'){
		include ('tabs/tabs.php');
	}

	if ($arParams['BXR_DETAIL_TABS']['BXR_DETAIL_TAB_TYPE'] == 'list'){
		include ('tabs/list.php');
	}
}
?>
<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/************************************************************************************************************/
/*  SideBar Controller Component
/************************************************************************************************************/
if (!\Bitrix\Main\Loader::includeModule('alexkova.market2')) return ;

$io = CBXVirtualIo::GetInstance();

if ($_REQUEST['ajax_mode'] == "yes"){

	$this->initCore();


	$sFileSectionName = $arParams['BXR_SIDEBAR_ID'];
	$sSidebarFileName = $arParams['BXR_SIDEBAR_FILENAME'];
	$sSidebarExtFileName = $arParams['BXR_SIDEBAR_EXT_FILENAME'];
	$bFileFound = $io->FileExists($_SERVER['DOCUMENT_ROOT'].$sSidebarFileName);
	if ($bFileFound){
		$arResult["FILE"] = $io->GetPhysicalName($_SERVER["DOCUMENT_ROOT"].$sFilePath.$sFileName);
	}
	$arResult['AJAX_MODE'] = "Y";

}else{
	$sSidebarExtFileName = $arParams['BXR_SIDEBAR_EXT_FILENAME'];
	if ($arParams['BXR_SIDEBAR_EXT_FILENAME'] <> ''){

		$bExtFileFound = $io->FileExists($_SERVER['DOCUMENT_ROOT'].$sSidebarExtFileName);

		if ($bExtFileFound){
			$arResult['EXT_FILE'] = $io->GetPhysicalName($_SERVER["DOCUMENT_ROOT"].$sSidebarExtFileName);
		}
	}
}

$this->IncludeComponentTemplate();



?>
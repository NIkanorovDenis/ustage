<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (strlen($arParams["BUFFER_NAME"])>0){
	$APPLICATION->ShowViewContent($arParams["BUFFER_NAME"]);
}

?>
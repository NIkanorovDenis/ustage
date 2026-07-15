<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->addExternalCss("/bitrix/css/main/bootstrap.css");

$arParams['LEFTMENU_INDEX_SHOW'] = (!isset($arParams['LEFTMENU_INDEX_SHOW'])) ? "Y" : $arParams['LEFTMENU_INDEX_SHOW'];
$bxmarket = \Alexkova\Market2\Bxmarket::getInstance();
$bxmarket->setCoreData(array(
    'left_column' => "N",
    'left_menu' => $arParams["LEFTMENU_INDEX_SHOW"],
));

if ((!$isSidebar && ( $arParams['LEFTMENU_INDEX_SHOW']=="Y" || $arParams['LEFTMENU_INDEX_SHOW']=="T")) || ($isSidebar && $arParams['LEFTMENU_INDEX_SHOW']=="T")){
    include_once($_SERVER["DOCUMENT_ROOT"]."/".$this->GetFolder()."/top_left_menu.php");
}

if (isset($arParams['USE_COMMON_SETTINGS_BASKET_POPUP']) && $arParams['USE_COMMON_SETTINGS_BASKET_POPUP'] == 'Y')
{
	$basketAction = (isset($arParams['COMMON_ADD_TO_BASKET_ACTION']) ? $arParams['COMMON_ADD_TO_BASKET_ACTION'] : '');
}
else
{
	$basketAction = (isset($arParams['SECTION_ADD_TO_BASKET_ACTION']) ? $arParams['SECTION_ADD_TO_BASKET_ACTION'] : '');
}
?><?
	$elementarArea = \Alexkova\Bxready2\Elementars::getArea('catalog','catalog.search');
	if (strlen($elementarArea) > 0)
		include($elementarArea);
	else
		include('include/elementars/catalog.search.php');

?>
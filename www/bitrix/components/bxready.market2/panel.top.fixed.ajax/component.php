<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */
$this->setFrameMode(true);

\Alexkova\Bxready2\Component::prepareParams($arParams, "bxready.market2:panel.top.fixed.ajax");

if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
|| $_REQUEST['ajax_call'] == "Y"){
	echo "-";
}else{
        if (
	CModule::IncludeModule('alexkova.bxready2')
	&& strlen($arParams['FIXED_PANEL_CODE'])>0
	&& strlen($arParams['FIXED_PANEL_DEFAULT_VARIANT'])>0
        && isset($arParams['USE_FEXT_FILES']) && $arParams['USE_FEXT_FILES']=="Y"
	){
                $area = \Alexkova\Bxready2\Area::getAreaFileByCode($arParams['FIXED_PANEL_CODE'], $arParams['FIXED_PANEL_DEFAULT_VARIANT']);
		$ext = str_replace(".php", ".ext.php", $area);
                if(strlen($ext)>strlen($area) && file_exists($ext)) {
                    include_once $ext;
	}
	}
	$this->IncludeComponentTemplate();
}
?>
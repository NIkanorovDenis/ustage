<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arResult = array();
\Alexkova\Bxready2\Component::prepareParams($arParams, "bxready2:abmanager");

$backurl = false;

if (isset($_REQUEST['backurl']) && isset($_REQUEST['ajax_mode'])){
	$backurl = htmlspecialchars($_REQUEST['backurl']);
}

if (CModule::IncludeModule('advertising'))
{
	$templatePage = 'bitrix';
	if ($backurl != false){
		CAdvBanner_all::SetCurUri($backurl);
	}

}
elseif(CModule::IncludeModule('alexkova.rklite'))
{
	$templatePage = 'rklite';
	if ($backurl != false){
		CKuznica_rklite::SetCurPage($backurl);
	}
}
else return;

$prepareMode = isset($arParams['ADV_'.$arParams['BANTYPE']]) && strlen($arParams['ADV_'.$arParams['BANTYPE']])>0 ? $arParams['ADV_'.$arParams['BANTYPE']] : '';

if (strlen($prepareMode)>0){
	if ($prepareMode != 'none'){
		$this->setTemplateName($prepareMode);
	}else{
		return;
	}
}

$this->IncludeComponentTemplate($templatePage);
?>
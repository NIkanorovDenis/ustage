<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
$this->createFrame()->begin("");

$addClass='';
if ($arParams["USE_IN_LG_MODE"] != "Y") $addClass .= " hidden-ld";
if ($arParams["USE_IN_MD_MODE"] != "Y") $addClass .= " hidden-md";
if ($arParams["USE_IN_SM_MODE"] != "Y") $addClass .= " hidden-sm";
if ($arParams["USE_IN_XS_MODE"] != "Y") $addClass .= " hidden-xs";

$addClass .= " prm_".strtolower($arParams["BANTYPE"]);
?>

<div class="rk-fullwidth rk-fullwidth-static <?=$addClass?>"><div class="rk-fullwidth-canvas">
<?$APPLICATION->IncludeComponent("bitrix:advertising.banner", ".default", array(
	"TYPE" => $arParams["BANTYPE"],
	"NOINDEX" => "N",
	"CACHE_TYPE" => $arParams["CACHE_TYPE"],
	"CACHE_TIME" => $arParams["CACHE_TIME"]
	),
	false,
	array("HIDE_ICONS"=>"Y")
);?></div></div>

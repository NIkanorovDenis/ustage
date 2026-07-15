<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (\Bitrix\Main\Loader::includeModule('alexkova.bxready2')){
	$APPLICATION->IncludeComponent("bxready2:abmanager", 'full-responsive', array(
			"SHOW" => "BXR_SIDEBAR",
			"BANTYPE" => "BXR_SIDEBAR",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "0",
			"USE_IN_LG_MODE" => "Y",
			"USE_IN_MD_MODE" => "Y",
			"USE_IN_SM_MODE" => "N",
			"USE_IN_XS_MODE" => "N"
		),
		false,
		array(
			"ACTIVE_COMPONENT" => "Y",
			"HIDE_ICONS"=>"N"
		)
	);

};
?><br><br>
С помощью BXReady: Интернет магазин вы сможете организовать профессиональную торговлю в интернете.
<br><br><br>


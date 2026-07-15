<?
if (\Bitrix\Main\Loader::includeModule('alexkova.bxready2')){
	$APPLICATION->IncludeComponent("bxready2:abmanager", 'full-responsive', array(
			"SHOW" => "BXR_LEFT",
			"BANTYPE" => "BXR_LEFT",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "0",
			"USE_IN_LG_MODE" => "Y",
			"USE_IN_MD_MODE" => "N",
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
?>
<?global $APPLICATION, $BXRGeneral;?>
<?if(!isset($BXRGeneral['SETTINGS']["catalog_brandblock_show"]) || $BXRGeneral['SETTINGS']["catalog_brandblock_show"]!="N"):?>
    <?$APPLICATION->IncludeComponent("bxready.market2:catalog.brandblock", "brand_slider", array(
	"IBLOCK_TYPE" => "catalog_new",
		"IBLOCK_ID" => "32",
		"ELEMENT_ID" => $_REQUEST["ELEMENT_ID"],
		"ELEMENT_CODE" => $_REQUEST["ELEMENT_CODE"],
		"PROP_CODE" => array(
			0 => "MANUFACTURER",
			1 => "",
		),
		"WIDTH" => "120",
		"HEIGHT" => "50",
		"WIDTH_SMALL" => "120",
		"HEIGHT_SMALL" => "50",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000",
		"CACHE_GROUPS" => "Y",
		"COMPONENT_TEMPLATE" => "brand_slider",
		"SHOW_DEACTIVATED" => "N",
		"SINGLE_COMPONENT" => "Y",
		"ELEMENT_COUNT" => "15",
		"BRAND_SHUFFLE" => "N"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "N"
	)
);?>
<?endif;?>
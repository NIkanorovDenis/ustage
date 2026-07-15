<?global $BXRGeneral;?>








 <?$APPLICATION->IncludeComponent(
	"bxready2:buffer.content",
	"template.php",
	array(
	"BUFFER_NAME" => "sidebar",	// ID буффера из которого будет осуществлен вывод данных
	)
);?> <?if(!isset($BXRGeneral['SETTINGS']["main_page_promo_right_show"]) || $BXRGeneral['SETTINGS']["main_page_promo_right_show"]!="N"):?>
<div class="bxr-b20">
	 <?$APPLICATION->IncludeComponent(
	"bxready.market2:promo.controller", 
	".default", 
	array(
		"BXR_PROMO_BLOCK_HEIGHT" => "460",
		"BXR_PROMO_DISPLAY_TYPE" => "block",
		"BXR_PROMO_FIELD_CODE" => array(
			0 => "NAME",
			1 => "PREVIEW_PICTURE",
			2 => "DETAIL_PICTURE",
			3 => "",
		),
		"BXR_PROMO_HOVER_EFFECT" => "apollo_min",
		"BXR_PROMO_IBLOCK_ID" => "12",
		"BXR_PROMO_IBLOCK_TYPE" => "content",
		"BXR_PROMO_INCLUDE_SUBSECTIONS" => "N",
		"BXR_PROMO_NEWS_COUNT" => "10",
		"BXR_PROMO_PARENT_SECTION" => "13",
		"BXR_PROMO_PARENT_SECTION_CODE" => "right",
		"BXR_PROMO_PREPARE_ID" => "promo_right",
		"BXR_PROMO_PROPERTY_CODE" => array(
			0 => "PROMO_HIDE_NAME",
			1 => "PROMO_LINK",
			2 => "PROMO_LINK_OPEN_NEW",
			3 => "LG_COL_COUNT",
			4 => "MD_COL_COUNT",
			5 => "SM_COL_COUNT",
			6 => "XS_COL_COUNT",
			7 => "NAME_COLOR",
			8 => "TEXT_COLOR",
			9 => "NAME_BACK_COLOR",
			10 => "TEXT_BACK_COLOR",
			11 => "PROMO_NO_EFFECT",
			12 => "EFFECT_ADD_COLOR",
			13 => "",
		),
		"BXR_PROMO_VARIANT" => "v2",
		"BXR_SLIDER_IBLOCK_ID" => "15",
		"BXR_SLIDER_IBLOCK_TYPE" => "content",
		"BXR_SLIDER_SLIDER_AUTOPLAY" => "N",
		"BXR_SLIDER_SLIDER_AUTOPLAY_SPEED" => "3000",
		"BXR_SLIDER_SLIDER_FADE" => "N",
		"BXR_SLIDER_SLIDER_FULL_SCREEN" => "Y",
		"BXR_SLIDER_SLIDER_SPEED" => "1500",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"FIELD_CODE" => array(
			0 => "CODE",
			1 => "XML_ID",
			2 => "NAME",
			3 => "PREVIEW_PICTURE",
			4 => "DETAIL_TEXT",
			5 => "DETAIL_PICTURE",
			6 => "",
		),
		"IBLOCK_ID" => "12",
		"IBLOCK_TYPE" => "content",
		"INCLUDE_SUBSECTIONS" => "Y",
		"NEWS_COUNT" => "10",
		"PROMO_CONTROLLER_TYPE" => "aside",
		"PROPERTY_CODE" => array(
			0 => "PROMO_HIDE_NAME",
			1 => "PROMO_LINK",
			2 => "",
		),
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?>
</div>

<a href="/tenders/" > 
	<img alt="Участие в тендерах" src="/upload/yandex/bn_ustage_230x330.jpg" > 
</a>



<?endif;?>
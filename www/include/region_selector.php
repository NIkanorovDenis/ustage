<?$APPLICATION->IncludeComponent(
	"bxready.market2:region.selector", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_TYPE" => "additional",
		"IBLOCK_ID" => "11",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"COUNT_CITY" => "8",
		"FORM_MODE" => "SELECT",
		"CONSIDER_SHOW_FORM" => "Y",
		"USE_SEARCH_TITLE" => "Y",
		"REGION_INFO_TEXT" => "Если вашего города нет в списке, то воспользуйтесь поиском. Мы доставляем товары по всей России.",
		"COUNT_CITY_SELECT" => "6",
		"REGION_CURRENT_INFO_TEXT" => "От выбранного города зависит цена товара и его наличие.",
		"REGION_CORRECTLY" => "Y",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>
<?
$APPLICATION->IncludeComponent("visualteam:search.title", 
	"top", 
	Array(
		"COMPONENT_TEMPLATE" => ".default",
		"NUM_CATEGORIES" => "1",	// Количество категорий поиска (Использование более одной категории замедлит работу компонента, рекомендуемое значение - 1)
		"TOP_COUNT" => "5",	// Количество результатов в категории
		"ORDER" => "rank",	// Сортировка результатов
		"USE_LANGUAGE_GUESS" => "Y",	// Включить автоопределение раскладки клавиатуры
		"CHECK_DATES" => "Y",	// Искать только в активных по дате документах
		"SHOW_OTHERS" => "N",
		"PAGE" => "/product/",	// Страница выдачи результатов поиска (доступен макрос #SITE_DIR#)
		"SHOW_INPUT" => "Y",	// Показывать форму ввода поискового запроса
		"INPUT_ID" => "title-search-input-mobile",	// ID строки ввода поискового запроса
		"CONTAINER_ID" => "title-search-mobile",	// ID контейнера, по ширине которого будут выводиться результаты
		"CATEGORY_0_TITLE" => "",	// Название категории
		"CATEGORY_0" => array(	// Ограничение области поиска
			0 => "iblock_catalog_new",
		),
		"PRICE_CODE" => "",	// Тип цены
		"PRICE_VAT_INCLUDE" => "Y",	// Включать НДС в цену
		"PREVIEW_TRUNCATE_LEN" => "200",	// Максимальная длина анонса для вывода
		"SHOW_PREVIEW" => "Y",	// Показать картинку
		"CONVERT_CURRENCY" => "N",	// Показывать цены в одной валюте
		"PREVIEW_WIDTH" => "75",	// Ширина картинки
		"PREVIEW_HEIGHT" => "75",	// Высота картинки
		"CATEGORY_0_iblock_catalog" => array(
			0 => "12",
		),
		"CATEGORY_0_iblock_catalog_new" => array(	// Искать в информационных блоках типа "iblock_catalog_new"
			0 => "32",
		),
		"CATEGORY_0_iblock_offers_new" => array(
			0 => "all",
		),
		"CATEGORY_0_main" => ""
	),
	false
);?>

<?
$bxmarket = \Alexkova\Market2\Bxmarket::getInstance();
?>
<div class="hidden-sm hidden-xs">
	 <?$APPLICATION->IncludeComponent(
	"bxready.market2:menu",
	"version_v1",
	array(
	"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
		"CHILD_MENU_TYPE" => "left_catalog",	// Тип меню для остальных уровней
		"COLOR_MENU" => "light",	// Cтиль меню
		"DELAY" => "N",	// Откладывать выполнение шаблона меню
		"FONT_MENU" => "normal",	// Шрифт меню
		"HOVER_MENU_COL_LG" => "",
		"HOVER_MENU_COL_MD" => "",
		"HOVER_MENU_COL_SM" => "1",
		"HOVER_MENU_COL_XL" => "",
		"HOVER_MENU_COL_XS" => "1",
		"HOVER_MODAL_BACKDROP" => "N",	// Затенение сайта при hover
		"HOVER_SHOW_LEFT" => "N",
		"ICO_HOVER_MENU_COLOR_1" => "light",
		"ICO_HOVER_MENU_COLOR_2" => "light",
		"ICO_TOP_MENU" => "ICO",	// Иконки
		"ICO_TOP_MENU_COLOR_1" => "light",
		"ICO_TOP_MENU_COLOR_2" => "light",
		"INDENT_ITEMS_MENU" => "normal",	// Отступ пунктов меню
		"IS_FIRST_CATALOG" => "Y",	// Первый пункт - каталог
		"MAX_LEVEL" => "1",	// Уровень вложенности меню
		"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
		"MENU_CACHE_TIME" => "36000",	// Время кеширования (сек.)
		"MENU_CACHE_TYPE" => "A",	// Тип кеширования
		"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
		"PARAMETERS" => "",
		"PICTURE_CATEGARIES" => "",
		"PICTURE_SECTION" => "N",	// Картинка раздела
		"PICTURE_SECTION_HOVER" => "N",
		"ROOT_MENU_TYPE" => "top",	// Тип меню для первого уровня
		"SHOW_TOP" => "N",
		"SHOW_TREE" => "Y",
		"STRETCH_MENU" => "Y",	// Растягивать пункты меню
		"STYLE_MENU_HOVER" => "colored_light",	// Cтиль меню
		"TEMPLATE_MENU_HOVER" => "classic",	// Шаблон
		"TITLE_MENU" => "",
		"USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
	)
);?>
</div>
 <br>
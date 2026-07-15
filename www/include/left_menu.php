<?php
$bxmarket = \Alexkova\Market2\Bxmarket::getInstance();
$isHidden = "isHidden"; 

if (($bxmarket->getCoreData("left_column") == "Y" && $bxmarket->getCoreData("left_menu") == "T") ||
   ($bxmarket->getCoreData("left_column") == "N" && ($bxmarket->getCoreData("left_menu") == "T" || $bxmarket->getCoreData("left_menu") == "Y"))){

}
else {
    $isHidden = "";
}

?>
<div class="hidden-sm hidden-xs bxr-left-column-js bxr-b20 bxr-cloud-all bxr-cloud-all-br1-not bxr-cloud-all-br2-not <?=$isHidden;?>">
    <?$APPLICATION->IncludeComponent("bxready.market2:menu", "left_hover1", Array(
	"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
		"CHILD_MENU_TYPE" => "left_catalog",	// Тип меню для остальных уровней
		"DELAY" => "N",	// Откладывать выполнение шаблона меню
		"MAX_LEVEL" => "2",	// Уровень вложенности меню
		"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
		"MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
		"MENU_CACHE_TYPE" => "A",	// Тип кеширования
		"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
		"USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
		"COMPONENT_TEMPLATE" => "left_hover",
		"TITLE_MENU" => "",	// Заголовок меню
		"SHOW_TREE" => "Y",
		"PICTURE_CATEGARIES" => "N",
		"ICO_LEFT_MENU_COLOR_1" => "dark",	// Основной цвет иконки
		"ICO_LEFT_MENU_COLOR_2" => "light",	// Цвет иконки при наведении
		"ICO_LEFT_MENU_HOVER_COLOR_1" => "light",
		"ICO_LEFT_MENU_HOVER_COLOR_2" => "light",
		"HOVER_SHOW_LEFT" => "N",	// Раскрывать элементы влево
		"HOVER_MODAL_BACKDROP" => "Y",	// Затенение сайта при hover
		"SHOW_TOP" => "N",	// Раскрывать пункты без смещения
		"HOVER_MENU_COL_SM" => "1",
		"HOVER_MENU_COL_XS" => "1",
		"PARAMETERS" => "",
		"STYLE_MENU" => "colored_light_new",	// Cтиль меню
		"PICTURE_SECTION" => "ICO",	// Картинка раздела
		"HOVER_TEMPLATE" => "classic",	// Шаблон
		"STYLE_MENU_HOVER" => "colored_light_new",	// Cтиль hover меню
		"PICTURE_SECTION_HOVER" => "N",	// Картинка раздела для hover
		"HOVER_MENU_COL_XL" => "",
		"HOVER_MENU_COL_LG" => "",
		"HOVER_MENU_COL_MD" => "",
		"ROOT_MENU_TYPE" => "left2",	// Тип меню для первого уровня
	),
	false
);?>
</div>

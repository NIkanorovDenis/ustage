<?
$aMenu[] = array(
    "module_id" => "energosoft.utils",
    "parent_menu" => "global_menu_services",
    "sort" => 10,
    "text" => "Energosoft",
    "title" => "Energosoft",
    "items_id" => "energosoft.utils",
    "items" => array(
        array(
            "sort" => 10,
            "text" => "Парсинг торговых предложений",
            "title" => "Парсинг торговых предложений",
            "url" => "es-status.php?lang=".LANGUAGE_ID,
        ),
        array(
            "sort" => 15,
            "text" => "Обработка товаров",
            "title" => "Обработка товаров",
            "url" => "es-items.php?lang=".LANGUAGE_ID,
        ),
        array(
            "sort" => 20,
            "text" => "Переадресация",
            "title" => "Переадресация",
            "url" => "es-301.php?lang=".LANGUAGE_ID,
        ),
        array(
            "sort" => 1000,
            "text" => "Настройки",
            "title" => "Настройки",
            "url" => "es-options.php?lang=".LANGUAGE_ID,
        ),
    ),
);

return $aMenu;
?>
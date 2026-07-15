<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/*
Компонент "Список отзывов для товара" askaron:askaron.reviews.for.element

Страница модуля в Маркетплейс: http://marketplace.1c-bitrix.ru/solutions/askaron.reviews/
Описание в документации: http://askaron.ru/api_help/course1/lesson118/

Пример. Размещение отзывов внутри другого компонента

Напишите где-нибудь, где хотите выводить отзывы:

<?CAskaronInclude::IncludeFile(       
   "имя вашего включаемого файла, например, reviews.php",  
   array(  
      "ELEMENT_ID" => $ELEMENT_ID,  
   )  
);?>

$ELEMENT_ID - ID товара.

*/
?><?$APPLICATION->IncludeComponent(
	"askaron:askaron.reviews.for.element", 
	".default", 
	array(
		"ELEMENT_ID" => $arParams["ELEMENT_ID"],
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "86400",
		"PAGE_ELEMENT_COUNT" => 10,
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"PAGER_TEMPLATE" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"COMPONENT_TEMPLATE" => ".default",
		"NEW_REVIEW_FORM" => "Y",
		"AJAX_OPTION_ADDITIONAL" => "undefined"
	),
	false
);?>
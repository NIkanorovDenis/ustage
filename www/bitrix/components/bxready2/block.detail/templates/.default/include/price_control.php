<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>
<?
global $DB;
CModule::IncludeModule('alexkova.bxready2');
use Alexkova\Bxready2\Formatprice;

$arPrice = Formatprice::format($arResult);
$currency = $arPrice['currency'];
$price = $arPrice['price'];
$display_price = $arPrice['display_price'];
$discount_price = $arPrice['discount_price'];
$display_discount_price = $arPrice['display_discount_price'];
$discount_period_from = strtotime($arResult["PROPERTIES"]["BXR_DISCOUNT_PERIOD_FROM"]["VALUE"]);
$discount_period_to = strtotime($arResult["PROPERTIES"]["BXR_DISCOUNT_PERIOD_TO"]["VALUE"]);
$date = strtotime(date($DB->DateFormatToPHP(CLang::GetDateFormat("FULL"))));
$discount_active = ((!$discount_period_from && !$discount_period_to) || ($date >= $discount_period_from && $date <= $discount_period_to) || ($date >= $discount_period_from && !$discount_period_to)) ? true : false;
$show_timer = ($arResult["PROPERTIES"]["BXR_DISCOUNT_TIMER"]["VALUE"] == "Y" && $discount_active) ? true : false;
$discount_show_type = $arParams["BXR_OFFERS_BLOCK"]["BXR_DISCOUNT_SHOW_TYPE"];
$discount_diff = $arPrice['discount_diff'];

$check = strpos($arResult["PROPERTIES"]["BXR_UNIT_PRICE"]["VALUE"], '#');

if ($check !== false){
	$display_price = str_replace('#', $display_price, $arResult["PROPERTIES"]["BXR_UNIT_PRICE"]["VALUE"]);
	$display_discount_price = str_replace('#', $display_discount_price, $arResult["PROPERTIES"]["BXR_UNIT_PRICE"]["VALUE"]);
	$discount_diff = str_replace('#', $discount_diff, $arResult["PROPERTIES"]["BXR_UNIT_PRICE"]["VALUE"]);
}
?>
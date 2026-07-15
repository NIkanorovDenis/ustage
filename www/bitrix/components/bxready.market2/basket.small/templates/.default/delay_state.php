<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<i class="fa fa-heart"></i>
<? if (isset($arResult["BASKET_ITEMS"]) && !empty($arResult["BASKET_ITEMS"]["DELAY"])): ?>
	<?=GetMessage("DELAY_ICON")?>: <?=count($arResult["BASKET_ITEMS"]["DELAY"])?>
<? endif; ?>
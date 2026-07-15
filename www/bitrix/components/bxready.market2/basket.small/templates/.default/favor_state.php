<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<i class="fa fa-heart"></i>
<?if (!empty($arResult["FAVOR_ITEMS"]) && count($arResult["FAVOR_ITEMS"])) {?>
	<div class="basket-items-cnt bxr-color"><?=count($arResult["FAVOR_ITEMS"])?></div>
<?}?>
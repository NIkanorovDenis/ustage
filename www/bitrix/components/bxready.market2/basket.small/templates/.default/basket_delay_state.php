<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<i class="fa fa-shopping-basket" aria-hidden="true"></i>
<?
$basket_delay_cnt = 
	(!empty($arResult["BASKET_ITEMS"]["CAN_BUY"]) ? count($arResult["BASKET_ITEMS"]["CAN_BUY"]) : 0) 
	+ 
	(!empty($arResult["BASKET_ITEMS"]["DELAY"])   ? count($arResult["BASKET_ITEMS"]["DELAY"])   : 0)
;?>
<?if ($basket_delay_cnt) {?>
    <div class="basket-items-cnt bxr-color"><?=$basket_delay_cnt?></div>
<?}?>

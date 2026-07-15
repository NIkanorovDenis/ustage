<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>
<?if (in_array('DETAIL_TEXT', $arParams['FIELD_CODE'])):?>
	<div class="bxr-detail"  data-scroll="DETAIL"><?=$arResult['DETAIL_TEXT']?></div>
<?endif;?>
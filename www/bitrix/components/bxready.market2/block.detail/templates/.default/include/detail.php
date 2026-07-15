<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>
<?if (in_array('DETAIL_TEXT', $arParams['FIELD_CODE'])):?>
<div itemscope itemtype="https://schema.org/Article">
	<div style="display: none" itemprop="name"><?=$arResult['NAME']?></div>
	<div itemprop="articleBody" class="bxr-detail tb20"  data-scroll="DETAIL"><?=$arResult['DETAIL_TEXT']?></div>
</div>
<?endif;?>
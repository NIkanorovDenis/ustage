<?
$name = ($arItem["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]) ? $arItem["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"] : $arItem["NAME"];
$usLazyLoad = \Alexkova\Market2\Bxmarket::usLazyLoad(false, $arParams['BXR_LAZY_LOAD']);
?>
<figure class="effect-selena">
	<?if($usLazyLoad):?>
		<div class="bxr-promo-image lazy" data-bxr-lazy="<?=$arItem['DETAIL_PICTURE']['SRC']?>"></div>
	<?else:?>
		<div class="bxr-promo-image" style="background-image:url(<?=$arItem['DETAIL_PICTURE']['SRC']?>)"></div>
	<?endif;?>
	<figcaption>
		<?if ($arItem['PROPERTIES']['PROMO_HIDE_NAME']['VALUE']!='Y'):?>
			<div class="h2" style='background: <? echo ($arItem['PROPERTIES']['NAME_BACK_COLOR']['VALUE']) ? $arItem['PROPERTIES']['NAME_BACK_COLOR']['VALUE'] : 'transparent';?>;
				color: <? echo ($arItem['PROPERTIES']['NAME_COLOR']['VALUE']) ? $arItem['PROPERTIES']['NAME_COLOR']['VALUE'] : '#fff';?>;'>
				<?=$name?>
			</div>
		<?endif;?>
		<br>
		<?if ($arItem['PREVIEW_TEXT']):?>
			<p style='background: <? echo ($arItem['PROPERTIES']['TEXT_BACK_COLOR']['VALUE']) ? $arItem['PROPERTIES']['TEXT_BACK_COLOR']['VALUE'] : 'transparent';?>;
			   color: <? echo ($arItem['PROPERTIES']['TEXT_COLOR']['VALUE']) ? $arItem['PROPERTIES']['TEXT_COLOR']['VALUE'] : '#fff';?>;'>
				<?=$arItem['PREVIEW_TEXT']?>
			</p>
		<?endif;?>

		<a href="<?=$arItem['PROPERTIES']['PROMO_LINK']['VALUE']?>"<?echo ($arItem['PROPERTIES']['PROMO_LINK_OPEN_NEW']['VALUE']=='Y') ? ' target="_blank"' : ''?>>View more</a>
	</figcaption>
</figure>


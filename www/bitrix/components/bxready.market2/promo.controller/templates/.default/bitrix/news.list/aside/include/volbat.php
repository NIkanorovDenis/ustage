<?
$name = ($arItem["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]) ? $arItem["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"] : $arItem["NAME"];
$usLazyLoad = \Alexkova\Market2\Bxmarket::usLazyLoad(false, $arParams['BXR_LAZY_LOAD']);
?>
<figure class="effect-volbat" style='background: <? echo ($arItem['PROPERTIES']['EFFECT_ADD_COLOR']['VALUE']) ? $arItem['PROPERTIES']['EFFECT_ADD_COLOR']['VALUE'] : 'transparent';?>;'>
	<?if($usLazyLoad):?>
		<div data-bxr-lazy="<?=$arItem['DETAIL_PICTURE']['SRC']?>" class="bxr-promo-image lazy"></div>
	<?else:?>
		<div style="background-image:url(<?=$arItem['DETAIL_PICTURE']['SRC']?>)" class="bxr-promo-image"></div>
	<?endif;?>
	<figcaption>
		<?if ($arItem['PROPERTIES']['PROMO_HIDE_NAME']['VALUE']!='Y'):?>
			<div class="h2" style='background: <? echo ($arItem['PROPERTIES']['NAME_BACK_COLOR']['VALUE']) ? $arItem['PROPERTIES']['NAME_BACK_COLOR']['VALUE'] : 'transparent';?>;
				color: <? echo ($arItem['PROPERTIES']['NAME_COLOR']['VALUE']) ? $arItem['PROPERTIES']['NAME_COLOR']['VALUE'] : '#fff';?>;'>
				<?=$name?>
			</div>
		<?endif;?>

		<?if ($arItem['PREVIEW_TEXT']):?>
			<p>
				<?=$arItem['PREVIEW_TEXT']?>
			</p>
		<?endif;?>

		<a href="<?=$arItem['PROPERTIES']['PROMO_LINK']['VALUE']?>"<?echo ($arItem['PROPERTIES']['PROMO_LINK_OPEN_NEW']['VALUE']=='Y') ? ' target="_blank"' : ''?>>View more</a>
	</figcaption>
</figure>


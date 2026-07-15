<?
$name = ($arItem["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]) ? $arItem["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"] : $arItem["NAME"];
$usLazyLoad = \Alexkova\Market2\Bxmarket::usLazyLoad(false, $arParams['BXR_LAZY_LOAD']);
?>
<div class="bxr-approx-element">
    <a href="<?=$arItem['PROPERTIES']['PROMO_LINK']['VALUE']?>"<?echo ($arItem['PROPERTIES']['PROMO_LINK_OPEN_NEW']['VALUE']=='Y') ? ' target="_blank"' : ''?>>
		<?if($usLazyLoad):?>
			<div class="bxr-promo-image lazy" data-bxr-lazy="<?=$arItem['DETAIL_PICTURE']['SRC']?>"></div>
		<?else:?>
			<div class="bxr-promo-image" style="background-image:url(<?=$arItem['DETAIL_PICTURE']['SRC']?>)"></div>
		<?endif;?>
		<div class="bxr-promo-ribbon-info">
			<?if ($arItem['PROPERTIES']['PROMO_HIDE_NAME']['VALUE']!='Y'):?>
				<span class="bxr-promo-ribbon-name"
					  style='background-color:<? echo ($arItem['PROPERTIES']['NAME_BACK_COLOR']['VALUE']) ? $arItem['PROPERTIES']['NAME_BACK_COLOR']['VALUE'] : 'transparent';?>;
							 color:<? echo ($arItem['PROPERTIES']['NAME_COLOR']['VALUE']) ? $arItem['PROPERTIES']['NAME_COLOR']['VALUE'] : '#fff';?>;'
				>
						<?=$name?>
				</span><br>
			<?endif;?>

			<?if ($arItem['PREVIEW_TEXT']):?>
				<span class="bxr-promo-ribbon-text"
					  style='background-color:<? echo ($arItem['PROPERTIES']['TEXT_BACK_COLOR']['VALUE']) ? $arItem['PROPERTIES']['TEXT_BACK_COLOR']['VALUE'] : 'transparent';?>;
							 color:<? echo ($arItem['PROPERTIES']['TEXT_COLOR']['VALUE']) ? $arItem['PROPERTIES']['TEXT_COLOR']['VALUE'] : '#fff';?>;'
				>
					<?=$arItem['PREVIEW_TEXT']?>
				</span>
			<?endif;?>
		</div>
    </a>
</div>
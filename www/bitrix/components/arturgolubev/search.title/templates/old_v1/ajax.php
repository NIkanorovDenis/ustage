<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if (empty($arResult["CATEGORIES"]))
	return;

$themeClass = 'theme-'.COption::GetOptionString("arturgolubev.smartsearch", 'color_theme', 'blue');
?>
<div class="bx_smart_searche <?=$themeClass?>">
	<?
	if($arResult["DEBUG_INFO"]["SHOW_DEBUG"] == 'Y')
	{
		echo '<pre>';
			echo 'Type: '; print_r($arResult["DEBUG_INFO"]["SEARCH_TYPE"]); echo "\r\n";
			echo 'Cache: '; print_r($arResult["DEBUG_INFO"]["FROM_CACHE"]); echo "\r\n";
			echo 'Time: '; print_r($arResult["DEBUG_INFO"]["TIME"]); echo "\r\n";
			echo 'Max count: '; print_r($arResult["DEBUG_INFO"]["TOP_COUNT"]); echo "\r\n";
		echo '</pre>';
		
		echo '<pre>'; print_r($arResult["DEBUG_INFO"]["REQUESTS"]); echo '</pre>';
		// echo '<pre>'; print_r($arResult["DEBUG_INFO"]["TEST"]); echo '</pre>';
		// echo '<pre>'; print_r($arResult["DEBUG_INFO"]["FINDED"]); echo '</pre>';
		// echo '<pre>'; print_r($arResult["DEBUG_INFO"]["RESULT_WORDS"]); echo '</pre>';
	}
	?>
	<?foreach($arResult["CATEGORIES"] as $category_id => $arCategory):?>
		<?foreach($arCategory["ITEMS"] as $i => $arItem):?>
			<?if(isset($arResult["SECTIONS"][$arItem["ITEM_ID"]])):
				$arElement = $arResult["SECTIONS"][$arItem["ITEM_ID"]];?>
				<div class="bx_item_block">
					<div class="bx_item_element">
						<div class="bx_img_element">
							<?if (is_array($arElement["PICTURE"])):?>
								<a href="<?echo $arItem["URL"]?>"><img class="bx_image" src="<?echo $arElement["PICTURE"]["src"]?>" alt="" title=""/></a>
							<?else:?>
								<a href="<?echo $arItem["URL"]?>"><img class="bx_image" src="/bitrix/components/arturgolubev/search.title/templates/.default/images/noimg.png" alt="" title=""/></a>
							<?endif;?>
						</div>
						
						<div class="bx_info_wrap">
							<a href="<?echo $arItem["URL"]?>"><?echo $arItem["NAME"]?></a>
							
							<?if($arElement["DESCRIPTION"]):?>
								<div class="bx_item_preview_text"><?=strip_tags($arElement["DESCRIPTION"])?></div>
							<?endif;?>
						</div>
						<div style="clear:both;"></div>
					</div>
					<div class="bx_item_block_semiline_wrap"><div class="bx_item_block_semiline"></div></div>
				</div>
			<?endif;?>
		<?endforeach;?>
	<?endforeach;?>
	
	<?foreach($arResult["CATEGORIES"] as $category_id => $arCategory):?>
		<?foreach($arCategory["ITEMS"] as $i => $arItem):?>
			<?if(isset($arResult["ELEMENTS"][$arItem["ITEM_ID"]])):
				$arElement = $arResult["ELEMENTS"][$arItem["ITEM_ID"]];?>
				<div class="bx_item_block">
					<div class="bx_item_element">
						<div class="bx_img_element">
							<?if (is_array($arElement["PICTURE"])):?>
								<a href="<?echo $arItem["URL"]?>"><img class="bx_image" src="<?echo $arElement["PICTURE"]["src"]?>" alt="" title=""/></a>
							<?else:?>
								<a href="<?echo $arItem["URL"]?>"><img class="bx_image" src="/bitrix/components/arturgolubev/search.title/templates/.default/images/noimg.png" alt="" title=""/></a>
							<?endif;?>
						</div>
						
						<div class="bx_info_wrap">
							<a href="<?echo $arItem["URL"]?>"><?echo $arItem["NAME"]?></a>
							
							<?if($arElement["PREVIEW_TEXT"]):?>
								<div class="bx_item_preview_text"><?=strip_tags($arElement["PREVIEW_TEXT"])?></div>
							<?endif;?>
							
							
							<?
							foreach($arElement["PRICES"] as $code=>$arPrice)
							{
								if ($arPrice["MIN_PRICE"] != "Y")
									continue;

								if($arPrice["CAN_ACCESS"])
								{
									if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
										<div class="bx_price">
											<?=$arPrice["PRINT_DISCOUNT_VALUE"]?>
											<span class="old"><?=$arPrice["PRINT_VALUE"]?></span>
										</div>
									<?else:?>
										<div class="bx_price"><?=$arPrice["PRINT_VALUE"]?></div>
									<?endif;
								}
								if ($arPrice["MIN_PRICE"] == "Y")
									break;
							}
							?>
						</div>
						<div style="clear:both;"></div>
					</div>
					<div class="bx_item_block_semiline_wrap"><div class="bx_item_block_semiline"></div></div>
				</div>
			<?endif;?>
		<?endforeach;?>
	<?endforeach;?>

	<?foreach($arResult["CATEGORIES"] as $category_id => $arCategory):?>
		<?foreach($arCategory["ITEMS"] as $i => $arItem):?>
			<?//echo $arCategory["TITLE"]?>
			<?if($category_id === "all"):?>
				<div class="bx_item_block all_result">
					<div class="bx_item_element bx_item_element_all_result">
						<a class="all_result_button" href="<?echo $arItem["URL"]?>"><?echo $arItem["NAME"]?></a>
					</div>
					<div style="clear:both;"></div>
				</div>
			<?
			elseif(isset($arResult["ELEMENTS"][$arItem["ITEM_ID"]]) || isset($arResult["SECTIONS"][$arItem["ITEM_ID"]])):
				continue;
			else:?>
				<div class="bx_item_block others_result">
					<div class="bx_item_element">
						<div class="bx_img_element">
							<img class="bx_image" src="/bitrix/components/arturgolubev/search.title/templates/.default/images/noimg.png" alt="" title=""/>
						</div>
						
						<div class="bx_info_wrap">
							<a href="<?echo $arItem["URL"]?>"><?echo $arItem["NAME"]?></a>
						</div>
						
						<div style="clear:both;"></div>
					</div>
					<div class="bx_item_block_semiline_wrap"><div class="bx_item_block_semiline"></div></div>
				</div>
			<?endif;?>
		<?endforeach;?>
	<?endforeach;?>
</div>
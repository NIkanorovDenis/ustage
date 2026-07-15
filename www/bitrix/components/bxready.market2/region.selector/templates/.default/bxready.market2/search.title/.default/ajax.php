<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if (empty($arResult["CATEGORIES"]))
	return;
?>
<div class="bx_searche bx_searche_region  bxr-title-search-result">
<?foreach($arResult["CATEGORIES"] as $category_id => $arCategory):?>
	<?foreach($arCategory["ITEMS"] as $i => $arItem):?>
		<?if($category_id !== "all"):?>
			<div class="bx_item_block bx_item_block_el  all_result">
				<div class="bx_item_element">
					<span class="all_result_title"><a  href="<?=(isset($arParams["REGION_LIST_ID_LINK"][$arItem["ITEM_ID"]]))? htmlspecialchars_decode($arParams["REGION_LIST_ID_LINK"][$arItem["ITEM_ID"]]) : $arItem["URL"]?>"><?=$arItem["NAME"]?></a></span>
				</div>
				<div style="clear:both;"></div>
			</div>		
		<?endif;?>
	<?endforeach;?>
<?endforeach;?>
</div>
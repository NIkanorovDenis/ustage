<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);

$arParams["NEW_REVIEW_FORM"] = ($arParams["NEW_REVIEW_FORM"] != "N") ? "Y": "N";
$arParams["SCHEMA_ORG_INSIDE_PRODUCT"] = ($arParams["SCHEMA_ORG_INSIDE_PRODUCT"] != "Y") ? "N": "Y";
?>

<div class="askaron-reviews-for-element" >
	
	<?if ( $arParams["NEW_REVIEW_FORM"] == "Y" && count( $arResult["ITEMS"] ) > 0 ):?>
		<div class="ask-add">
			<a href="#new-review" ><?=GetMessage("ASKARON_REVIEWS_FOR_ELEMENT_T_NEW_REVIEW")?></a>
		</div>
	<?endif?>
	
	<?foreach ( $arResult["ITEMS"] as $arItem ):?>

		<div class="ask-review<?if ( $arItem["ACTIVE"] == "N" ) echo ' ask-not-active';?>">

			<div class="ask-name">
				<?=$arItem["DISPLAY_NAME"];?> <span><?=$arItem["DATE_SHORT"];?></span> 
				
				<?if ( $arParams["MODULE_RIGHT"] >= "R" ):?>
				
					<?if ( $arItem["ACTIVE"] !== "Y" ):?>
						<span><?=GetMessage("ASKARON_REVIEWS_FOR_ELEMENT_T_NOT_PUBLIC")?></span>
					<?endif?>
					
				<?endif?>
				
				<?if ( $arParams["MODULE_RIGHT"] >= "W" ):?>
					<div class="ask-edit-link-block">
						<?if ( $arItem["ACTIVE"] !== "Y" ):?>
							<?=$arItem["URL"]["SHOW"]?>
						<?else:?>
							<?=$arItem["URL"]["HIDE"]?>
						<?endif?>

						<?=$arItem["URL"]["EDIT"]?>
						<?=$arItem["URL"]["DELETE"]?>						
					</div>
				<?endif?>
				
			</div>

			<div class="ask-stars"><?
				for ( $i=1; $i<=5; $i++ )					
				{
					if( $arItem["GRADE"] >= $i )
					{
						?><img src="<?=$this->GetFolder()?>/images/icon-star-a.png" alt=""/><?
					}
					else
					{
						?><img src="<?=$this->GetFolder()?>/images/icon-star-e.png" alt=""/><?
					}
				}
			?><span><?=$arItem["GRADE_TEXT"]?></span></div>


			<?if ( strlen( $arItem["PRO"] ) > 0 ):?>
				<div class="ask-review-item">
					<div class="ask-title"><?=GetMessage("ASKARON_REVIEWS_FOR_ELEMENT_T_PRO")?></div>
					<div class="ask-text"><?=$arItem["PRO"]?></div>
				</div>
			<?endif?>

			<?if ( strlen( $arItem["CONTRA"] ) > 0 ):?>
				<div class="ask-review-item">
					<div class="ask-title"><?=GetMessage("ASKARON_REVIEWS_FOR_ELEMENT_T_CONTRA")?></div>
					<div class="ask-text"><?=$arItem["CONTRA"]?></div>
				</div>
			<?endif?>

			<?if ( strlen( $arItem["TEXT"] ) > 0 ):?>
				<div class="ask-review-item">
					<div class="ask-title"><?=GetMessage("ASKARON_REVIEWS_FOR_ELEMENT_T_TEXT")?></div>
					<div class="ask-text" ><?=$arItem["TEXT"]?></div>
				</div>
			<?endif?>

			<div style="display: none;" itemprop="review"

				<?if ($arParams["SCHEMA_ORG_INSIDE_PRODUCT"] == "Y"):?>
					itemprop="review"
				<?endif?>

				itemscope itemtype="http://schema.org/Review">

				<div itemprop="itemReviewed" itemscope itemtype="http://schema.org/Thing">
                    <meta itemprop="name" content="<?=$arResult["ELEMENT"]["NAME"];?>">
				</div>

				<div itemprop="author" itemscope itemtype="http://schema.org/Person">
					<meta itemprop="name" content="<?=$arItem["DISPLAY_NAME"];?>">
				</div>

				<meta itemprop="datePublished" content="<?=ConvertDateTime( $arItem["DATE"], "YYYY-MM-DD");?>">

				<?if ( $arItem["GRADE"] > 0):?>
					<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
						<meta itemprop="ratingValue" content = "<?=$arItem["GRADE"]?>">
						<meta itemprop="worstRating" content = "1">
						<meta itemprop="bestRating" content = "5">
					</div>
				<?endif?>

				<meta itemprop="reviewBody" content="
					<?if ( strlen( $arItem["PRO"] ) > 0 ):?>
						<?=GetMessage("ASKARON_REVIEWS_FOR_ELEMENT_T_PRO")?> <?=$arItem["PRO"]?>
					<?endif?>

					<?if ( strlen( $arItem["CONTRA"] ) > 0 ):?>
						<?=GetMessage("ASKARON_REVIEWS_FOR_ELEMENT_T_CONTRA")?> <?=$arItem["CONTRA"]?>
					<?endif?>

					<?if ( strlen( $arItem["TEXT"] ) > 0 ):?>
						<?=GetMessage("ASKARON_REVIEWS_FOR_ELEMENT_T_TEXT")?> <?=$arItem["TEXT"]?>
					<?endif?>
				">
			</div>
		</div>
	
	<?endforeach?>

	<?if ( $arParams["DISPLAY_BOTTOM_PAGER"] ):?>
		<?=$arResult["NAV_STRING"]?>
	<?endif?>
	
	<?if ( $arParams["NEW_REVIEW_FORM"] == "Y"):?>
	
		<?if ( count( $arResult["ITEMS"] ) > 0 ):?>
			<div class="ask-new-interval">&nbsp;</div>
		<?endif?>
	
		<a name="new-review"></a>
		
		<?$APPLICATION->IncludeComponent("askaron:askaron.reviews.new", "template1", Array(
	"ELEMENT_ID" => $arParams["ELEMENT_ID"],	// ID элемента
	),
	false
);?>		
		
	<?endif?>
</div>
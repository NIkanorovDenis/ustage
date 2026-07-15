<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->createFrame()->begin( GetMessage( "ASKARON_REVIEWS_NEW_LOADING" ) );
?>


<div class="askaron-reviews-new">
	
	<h3><?=GetMessage("ASKARON_REVIEWS_NEW_REVIEW_HEADER")?></h3>

	<?if( $arResult["NEW_ADDED"] ):?>
		<div class="ask-ok"><?=$arResult["NEW_ADDED_TEXT"]?></div>
		
		
		<?if( $arResult["PREMODERATE"] ):?>
			<div class="ask-ok"><?=$arResult["NEW_ADDED_PREMODERATE_TEXT"]?></div>
		<?endif?>
        <script>$(document).ready(function(){ $(".bxr-color-hover[data-tab=REVIEWS]").click(); });</script>
	<?else:?>

		<?if( count( $arResult["ERRORS"] ) > 0 ):?>
			<div class="ask-error">
				<?foreach ( $arResult["ERRORS"] as $error ):?>
					<?=$error?><br />
				<?endforeach ?>
			</div>
        <script>$(document).ready(function(){ $(".bxr-color-hover[data-tab=REVIEWS]").click(); });</script>
		<?endif;?>
	
	
		<form action="<?=POST_FORM_ACTION_URI?>" method="POST">
			<?=bitrix_sessid_post()?>
			<input type="hidden" name="new_review_added" value="" >
			
			<div class="ask-grade stars"><?=$arResult["FIELDS"]["GRADE"]["NAME"]?>:
				<div class="ask-grade-stars">
				<?for ( $i=5; $i >= 1; $i-- ):?>		
					<input 		
						id="askaron_reviews_grade_<?=$i?>" 
						type="radio"
						name="new_review[GRADE]"
						value="<?=$i?>"
						<?if ( $arResult["FIELDS"]["GRADE"]["VALUE"] == $i ):?>
							checked
						<?endif?>
					><label for="askaron_reviews_grade_<?=$i?>"><?=$i;?></label>&nbsp;&nbsp;
				<?endfor?>
				</div>
			</div>

			<div class="ask-field">
				<div><?=$arResult["FIELDS"]["PRO"]["NAME"]?></div>
				<textarea required name="new_review[PRO]"><?=$arResult["FIELDS"]["PRO"]["VALUE"]?></textarea>
			</div>

			<div class="ask-field">
				<div><?=$arResult["FIELDS"]["CONTRA"]["NAME"]?></div>
				<textarea required name="new_review[CONTRA]"><?=$arResult["FIELDS"]["CONTRA"]["VALUE"]?></textarea>
			</div>

			<div class="ask-field">
				<div><?=$arResult["FIELDS"]["TEXT"]["NAME"]?></div>
				<textarea class="ask-textarea-big" required  name="new_review[TEXT]"><?=$arResult["FIELDS"]["TEXT"]["VALUE"]?></textarea>
			</div>

			<?if ($arResult["FIELDS"]["AUTHOR_NAME"]):?>
				<div class="ask-field">
					<div><?=$arResult["FIELDS"]["AUTHOR_NAME"]["NAME"]?></div>
					<input type="text" required name="new_review[AUTHOR_NAME]" value="<?=$arResult["FIELDS"]["AUTHOR_NAME"]["VALUE"]?>">
				</div>
			<?endif?>

			<?if ($arResult["FIELDS"]["AUTHOR_EMAIL"]):?>
				<div class="ask-field">
					<div><?=$arResult["FIELDS"]["AUTHOR_EMAIL"]["NAME"]?></div>
					<input type="email" required name="new_review[AUTHOR_EMAIL]" value="<?=$arResult["FIELDS"]["AUTHOR_EMAIL"]["VALUE"]?>">
				</div>
			<?endif?>			

			<?if(!empty($arResult["CAPTCHA_CODE"])):?>
				<div class="ask-captcha">
					<div><?=GetMessage("ASKARON_REVIEWS_NEW_REVIEW_INPUT_CAPTCHA")?></div>

					<img alt="<?=GetMessage("CAPTCHA_ALT")?>" src="/bitrix/tools/captcha.php?captcha_code=<?=$arResult["CAPTCHA_CODE"]?>" /><input type="text" name="captcha_word" required>

					<input type="hidden" name="captcha_code" value="<?=$arResult["CAPTCHA_CODE"]?>">
				</div>
			<?endif;?>

			<div class="ask-button">				
				<input type="submit" name="new_review_form" value="<?=GetMessage("ASKARON_REVIEWS_NEW_REVIEW_SEND")?>">				
				<input type="hidden" name="new_review_form" value="Y">
			</div>
		</form>

		<div class="ask-note"><?=GetMessage("ASKARON_REVIEWS_NEW_REVIEW_ALL_FIELDS_REQUIRED")?></div>					

		<?if ( $arResult["PREMODERATE"] ):?>
			<div class="ask-note"><?=GetMessage("ASKARON_REVIEWS_NEW_PREMODERATE")?></div>
		<?endif?>
			
	<?endif?>
</div>
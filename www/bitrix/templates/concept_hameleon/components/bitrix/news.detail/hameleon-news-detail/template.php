<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<div class="modal-body-content blog-container">
				
	<div class="content no-margin-top-bot">

		<div class="top-wrap">
	        <div class="modal-title main1"><?=$arResult["~NAME"]?></div>
	    </div>

	    <div class="bot-wrap">

			<?if(strlen($arResult["~PREVIEW_TEXT"]) > 0):?>

		        <div class="text-content no-margin-top-bot">
		            <?=$arResult["~PREVIEW_TEXT"]?>
		        </div>

	        <?endif;?>

			<?if(!empty($arResult["PROPERTIES"]["NEWS_GALLERY"]["VALUE"])):?>

		        <div class="gallery <?if($arResult["PROPERTIES"]["NEWS_GALLERY_BORDER"]["VALUE"] == "Y"):?>border-on<?endif;?>">
		        	<?if(strlen($arResult["PROPERTIES"]["NEWS_GALLERY_TITLE"]["VALUE"]) > 0):?>
			            <div class="gallery-name main1">
			                <?=$arResult["PROPERTIES"]["NEWS_GALLERY_TITLE"]["~VALUE"]?>
			            </div>
		            <?endif;?>


		            <div class="row clearfix">

						<?foreach($arResult["PROPERTIES"]["NEWS_GALLERY"]["VALUE"] as $k => $arImages):?>

							<?$file_big = CFile::ResizeImageGet($arImages, array('width'=>1600, 'height'=>1600), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>

	                    	<?$file_min = CFile::ResizeImageGet($arImages, array('width'=>300, 'height'=>300), BX_RESIZE_IMAGE_EXACT, false, false, false, 75);?>


			                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
			                	<div class="img-wrap">

			                    	<a data-gallery="catalog<?=$arResult["ID"]?>" href="<?=$file_big["src"]?>" title="<?=$arResult["PROPERTIES"]["NEWS_GALLERY"]["~DESCRIPTION"][$k]?>" class="cursor-loop">

	                        		<img alt="<?=$arResult["NAME"]?>" class="img-responsive" src="<?=$file_min["src"]?>" /></a>
			                    </div>
			                </div>

			                <?if(($k+1) % 6 == 0):?>
			                	<span class="clearfix hidden-xs"></span>
			                <?endif;?>
			                <?if(($k+1) % 3 == 0):?>
			                	<span class="clearfix visible-xs"></span>
			                <?endif;?>


		                <?endforeach;?>

		            </div>
		        </div>

	        <?endif;?>

	    </div>
    </div>

</div>
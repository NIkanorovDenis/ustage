<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

	    <?if($arResult["LAST_ID"] > 0):?>
	    	<div class="prev btn-modal-open" data-main-catalog-id="<?=$arParams["CATALOG_ID"]?>" data-header = "<?=$arParams['CHAM_HEADER'];?>" data-section-id="<?=$arParams["CHAM_SECTION_ID"]?>" data-detail="<?=$arParams["NAME"]?>" data-all-id = "<?=$arParams['ALL_ID']?>" data-site-id='<?=$arParams['SITE_ID']?>' data-element-id="<?=$arResult['LAST_ID']?>" data-block-id="<?=$arParams["BLOCK_ID"]?>"></div>
	    <?endif;?>

	    
	    <?if($arResult["NEXT_ID"] > 0):?>
	        <div class="next btn-modal-open" data-main-catalog-id="<?=$arParams["CATALOG_ID"]?>" data-header = "<?=$arParams['CHAM_HEADER'];?>" data-section-id="<?=$arParams["CHAM_SECTION_ID"]?>" data-detail="<?=$arParams["NAME"]?>" data-all-id = "<?=$arParams['ALL_ID']?>" data-site-id='<?=$arParams['SITE_ID']?>' data-element-id="<?=$arResult["NEXT_ID"]?>" data-block-id="<?=$arParams["BLOCK_ID"]?>" ></div>

	    <?endif;?>

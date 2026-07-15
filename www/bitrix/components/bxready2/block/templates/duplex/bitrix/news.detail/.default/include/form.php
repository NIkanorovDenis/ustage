<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>

<?if (is_array($arParams['BXR_FORMS']) && count($arParams['BXR_FORMS'])>0):
	$arParams['BXR_FORMS']["EVENT_CLASS"] = 'bxr-color-button';
	$arParams['BXR_FORMS']["COMPONENT_TEMPLATE"] = "popup";
	//$arParams['BXR_FORMS']['EVENT_CLASS'] .= ' hidden-lg hidden-md hidden-sm hidden-sm';
	?>

	<div class="bxr-contact-form">
            <?if (substr_count($arParams['BXR_PICTURE']['BXR_DETAIL_PICTURE_TYPE'], 'fullsize')>0):?>
                <div class="col-xs-12 col-md-8 bxr-contact-form-fullscreen">
            <?endif;?>
		<div class='bxr-contact-form-content'>
			<?=$arParams['BXR_FORMS']['INITIAL_TEXT']?>
		</div>
            <?if (substr_count($arParams['BXR_PICTURE']['BXR_DETAIL_PICTURE_TYPE'], 'fullsize')>0):?>
                </div>
            <?endif;?>
            <?if (substr_count($arParams['BXR_PICTURE']['BXR_DETAIL_PICTURE_TYPE'], 'fullsize')>0):?>
                <div class="col-xs-12 col-md-4 bxr-contact-form-fullscreen">
            <?endif;?>
		<button class="<?=$arParams['BXR_FORMS']['EVENT_CLASS']?>" href="javascript:void(0);" data-toggle="modal" data-target="#<?=$arParams['BXR_FORMS']['BXR_FORM_ID']?>">

			<?if (strlen($arParams['BXR_FORMS']['BXR_FORM_SUBMIT_ICON'])>0):?>
				<span class="<?=$arParams['BXR_FORMS']['BXR_FORM_SUBMIT_ICON']?>"></span>
			<?endif;?>
			<?=$arParams['BXR_FORMS']["BUTTON_TEXT"]?>

		</button>
            <?if (substr_count($arParams['BXR_PICTURE']['BXR_DETAIL_PICTURE_TYPE'], 'fullsize')>0):?>
                </div>
                <div class="clearfix"></div>
            <?endif;?>
	</div>
<?endif;?>
<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/**	@var $this CBitrixComponentTemplate **/
$this->setFrameMode(true);
global $showModalForm, $BXR_FORM_COUNTER;
$useDouble = false;
if (is_array($showModalForm) && $showModalForm[$arParams["BXR_FORM_ID"]] == true){
	$useDouble = true;
}else{
	if (!is_array($showModalForm)) $showModalForm = array();
	$showModalForm[$arParams["BXR_FORM_ID"]] = true;
}
$eventClass = $arParams["EVENT_CLASS"]?$arParams["EVENT_CLASS"]:'';
?>
<?if(strlen($arParams["BUTTON_TEXT"])>0):?>
	<a class="<?=$eventClass?>" href="javascript:void (0);" data-toggle="modal" data-target="#<?=$arParams["BXR_FORM_ID"]?>">
		<?=$arParams["BUTTON_TEXT"]?>
	</a>
<?endif;?>

<?if(!$useDouble):?>

	<div class="modal bxr-form-modal" id="<?=$arParams["BXR_FORM_ID"]?>" tabindex="-1" role="dialog" aria-labelledby="<?=$arParams["BXR_FORM_ID"]?>Label">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header bxr-border-bottom-color">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<div class="h4 modal-title" id="<?=$arParams["BXR_FORM_ID"]?>Label"><?=$arParams["~FORM_TITLE"]?></div>
				</div>
				<div class="modal-body" id='ajaxFormContainer_<?=$arParams["IDENTITY"]?>' data-form="<?=$arParams["IDENTITY"]?>">
					<?$APPLICATION->IncludeComponent(
						"bxready.market2:iblock.element.add.form",
						"request_product",
						$arParams,
						false,
						array("HIDE_ICONS"=>"Y")
					);?>
				</div>
			</div>
		</div>
	</div>

<?endif;?>
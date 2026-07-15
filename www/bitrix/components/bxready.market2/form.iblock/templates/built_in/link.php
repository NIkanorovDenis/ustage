<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
global $BXR_FORM_COUNTER;
?>

<div id='ajaxFormContainer_<?=$arParams["IDENTITY"]?>'>
	<?$APPLICATION->IncludeComponent(
		"bxready.market2:iblock.element.add.form",
		"built_in",
		$arParams,
		$component,
		array("HIDE_ICONS"=>"Y")
	);?>
</div>


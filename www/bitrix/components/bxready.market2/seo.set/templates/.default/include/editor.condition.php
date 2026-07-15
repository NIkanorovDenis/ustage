<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if($arResult['SET_INFO']['EXT_PARAMS']['filter_type'] != 'parent') $arResult['SET_INFO']['EXT_PARAMS']['filter_type'] = 'none';?>
<div id="bxr-seo-cond-panel" <?if($arResult['SET_INFO']['DEST'] == 'F') echo 'style="display: none"'?>>

	<?
	$f_CONDITIONS = $arResult['SET_INFO']['DEST'] == 'C' ? $arResult['SET_INFO']['DESCR'] : array();
	if (empty($f_CONDITIONS)){
		$f_CONDITIONS = \CCatalogCondTree::GetDefaultConditions();
	}


	$obCond = new CCatalogCondTree();
	$boolCond = $obCond->Init(BT_COND_MODE_DEFAULT, BT_COND_BUILD_CATALOG, array('FORM_NAME' => $arResult['FORM_NAME'], 'CONT_ID' => 'cond_seoset', 'JS_NAME' => 'JSCatCond_seoset', 'PREFIX' => 'COND_seoset'));
	$listHTML = '';

	?>

	<div class="work-mode">
		<?=GetMessage('BXR_SEOSET_COND_RULE')?>
	</div>

	<div id="cond_seoset" name="cond_seoset">
		<input type="hidden" id="current_condition_seoset" name="current_condition_seoset" value='<?=$arReplace['COND_VALUE']?>'>
		<input type="hidden" id="current_condition_seoset" name="current_condition_seoset" value="<?=$arReplace['MD5_VALUE']?>">
	</div>
	<?

	if (!$boolCond)
	{
		if ($ex = $APPLICATION->GetException())
			echo $ex->GetString()."<br>";
	}
	else
	{
		$obCond->Show($f_CONDITIONS);
	}
	?>

	<div class="work-mode">
		<?=GetMessage('BXR_SEOSET_COND_FILTER_USE')?>
	</div>

	<div class="bxr-cond-filter radio-filter filter-type-radio">
		<label for="bxr-filter-type-parent">
			<input type="radio" id="bxr-filter-type-parent" name="bxr-cond-filter-type" value="parent" <?if($arResult['SET_INFO']['EXT_PARAMS']['filter_type'] == 'parent') echo "checked"?>>
			<?=GetMessage('BXR_SEOSET_COND_FILTER_USE_PARENT')?>
		</label>
		<label for="bxr-filter-type-none">
			<input type="radio" id="bxr-filter-type-none" name="bxr-cond-filter-type" value="none" <?if($arResult['SET_INFO']['EXT_PARAMS']['filter_type'] == 'none') echo "checked"?>>
			<?=GetMessage('BXR_SEOSET_COND_FILTER_USE_NONE')?>
		</label>
	</div>

</div>

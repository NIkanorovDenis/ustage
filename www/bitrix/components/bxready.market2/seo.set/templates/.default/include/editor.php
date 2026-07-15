<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$showPanel = (empty($arResult['SET_INFO']) || $arResult['SET_INFO']['ACTIVE'] == "Y") ? true : false;
$isSeo = $arResult['SET_INFO']['ACTIVE'] == "Y"? true : false;
$isNav = $arResult['SET_INFO']['EXT_PARAMS']['navigation'] == "Y"? true : false;

?>
<div class="body-selector radio-filter">
	<label class="switch" for="bxr-seo-selector">
		<input type="checkbox" id="bxr-seo-selector" value="on" <?if($isSeo) echo "checked"?>>
		<?=GetMessage('BXR_SEOSET_USE_SEO_SECTION')?>
	</label>
</div>

<div class="bxr-seo-set-body <?if($showPanel) echo " active"?>">
	<div class="radio-filter">
		<label class="switch">
			<input type="checkbox" id="bxr-seo-selector-nav" value="Y" <?if($isNav) echo "checked"?>>
			<?=GetMessage('BXR_SEOSET_USE_SEO_SECTION_NAVIGATION')?>
		</label>
	</div>

	<div class="work-mode">
		<?=GetMessage('BXR_SEOSET_MODE')?>
	</div>

	<div class="filter-type-radio radio-filter">

		<input type="radio" id="bxr-filter-type-filter" name="bxr-filter-type" value="filter" <?if($arResult['SET_INFO']['DEST'] == 'F') echo "checked"?>>
		<label for="bxr-filter-type-filter"> <?=GetMessage('BXR_SEOSET_SMFILTER_MODE')?>
		</label>

		<input type="radio" id="bxr-filter-type-cond" name="bxr-filter-type" value="condition" <?if($arResult['SET_INFO']['DEST'] == 'C') echo "checked"?>>
		<label for="bxr-filter-type-cond"> <?=GetMessage('BXR_SEOSET_CONDITION_MODE')?>
		</label>
	</div>



<?
include('editor.filter.php');
include('editor.condition.php');
if ($arResult['SEO_SET']['DEST'] == 'C') {
//	include('editor.condition.php');
} else {
//	include('editor.filter.php');
}


?>

<div class="bxr-control-panel">
	<input id="bxr-seoset-update" disabled type="button" class="button" name="update" id="save" value="<?=GetMessage('BXR_SEOSET_UPDATE')?>">
	<input id="bxr-seoset-delete" type="button" class="button" name="delete" id="save" value="<?=GetMessage('BXR_SEOSET_DELETE')?>">
</div>
	</div>


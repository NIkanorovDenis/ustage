<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
$arComponentParams = array(
	'IBLOCK_ID' => $_REQUEST['IBLOCK_ID'],
	'SECTION_ID' => $_REQUEST['ID'],
	"FILTER_NAME" => 'arrFilter'
);

if(
	$arComponentParams["FILTER_NAME"] == ''
	|| !preg_match("/^[A-Za-z_][A-Za-z01-9_]*$/", $arComponentParams["FILTER_NAME"])
)
{
	$arComponentParams["FILTER_NAME"] = "arrFilter";
}?>

<div id="bxr-seo-filter-panel" <?if($arResult['SET_INFO']['DEST'] == 'C' || empty($arResult['SET_INFO'])) echo 'style="display: none"'?>>
	<div class="filter-button">
		<input id="bxr-seoset-filter" type="button" class="button" name="update" id="save" value="<?=GetMessage('BXR_SEOSET_FILTER_BUTTON')?>">
	</div>
<?
$APPLICATION->IncludeComponent(
	"bxready.market2:seo.filter",
	"print",
	array(
		"IBLOCK_ID" => $arComponentParams["IBLOCK_ID"],
		"SECTION_ID" => $arResult["PARENT_SECTION"],
		"FILTER_NAME" => $arComponentParams["FILTER_NAME"],
		"DISPLAY_ELEMENT_COUNT" => "Y",
		"CACHE_TYPE" => "N",
		"SAVE_IN_SESSION" => "N",
		"NO_AJAX" => "Y"
	),
	false,
	array('HIDE_ICONS' => 'Y')
);
?>

</div>



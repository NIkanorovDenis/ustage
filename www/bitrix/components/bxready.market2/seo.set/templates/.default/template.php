<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
$signer = new \Bitrix\Main\Security\Sign\Signer;
$signedTemplate = $signer->sign($templateName, 'seoset');
$arResult['TRANSPORT_PARAMS'] = array();

if(is_array($arParams)) {
	foreach ($arParams as $cell=>$val){
		if (substr($cell, 0, 1) !=  "~")
			$arResult['TRANSPORT_PARAMS'][$cell] = $val;
	}
}

$signedParams = $signer->sign(base64_encode(serialize($arResult['TRANSPORT_PARAMS'])), 'seoset');
$ajaxModePostfix = '';
?>

<?if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == "yes"){
	$APPLICATION->RestartBuffer();
	$ajaxModePostfix = '-ajax';
}
?>

<?if (!$arResult['AJAX_MODE']):?>
<?
	CJSCore::Init('jquery');
?>
<div id="bxr-seo-set">

<?endif;?>
<?

$errorData = $APPLICATION->GetException();
if (strlen($errorData) > 0){
	include ('include/error.php');
}

include ('include/body.php');
$this->addExternalJs('https://code.jquery.com/ui/1.9.2/jquery-ui.min.js');
$this->addExternalCss('/bitrix/css/main/font-awesome.min.css');
?>

<?if (!$arResult['AJAX_MODE']):
$parentSection = $arResult['PARENT_SECTION'] > 0 ? $arResult['PARENT_SECTION'] : $arResult['ID'];
?>
	</div>
	<script>

		$(document).ready(function(){
			BXRSEOEditor = new BXRSEOEditor({
				postData: {
					siteId : '<?=SITE_ID?>',
					template : '<?=$signedTemplate?>',
					parameters : '<?=$signedParams?>',
					id: <?=$arParams['ID']?>
				},
				iblockId: <?=$arParams['IBLOCK_ID']?>,
				ajaxUrl: '<?=$arResult['AJAX_URL']?>',
				urlSmartFilter: '/bitrix/admin/alexkova.market2_seo.filter.php?IBLOCK_ID=<?=$arParams['IBLOCK_ID']?>&ID=<?=$parentSection?>&FILTER_NAME=arrFilter&opener=BXRSEOEditor',
				Messages: {
					'confirmDelete' : '<?=GetMessage('CONFIRM_SEOSET_DELETE_ANSWER')?>',
					'productInSection' : '<?=GetMessage('ALERT_PRODUCT_IN_SECTION')?>'
				},
				confirmMessage: '<?=GetMessage('CONFIRM_ELEMENT_SAVE_ANSWER')?>'
			});

			BXRSEOEditor.addValue = function(filter){
				this.addFilter(filter);
			};

			<?if (count($arResult['FILTER_ADD']) > 0):?>
			BXRSEOEditor.addFilter(<?=json_encode($arResult['FILTER_ADD'])?>);
			<?endif;?>

			BXRSEOEditor.init();
		});

</script>
<?endif;?>


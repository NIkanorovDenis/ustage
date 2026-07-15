<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if ($arResult['AJAX_MODE'] == "Y"):

	if($arResult["FILE"] <> ''):

		include($arResult["FILE"]);

	endif;

else:

	$this->setFrameMode(true);

	$signer = new \Bitrix\Main\Security\Sign\Signer;
	$signedTemplate = $signer->sign($templateName, 'sidebarcontroller');
	$sidebarID = $arParams["BXR_SIDEBAR_ID"];
	$backurl = $signer->sign($APPLICATION->GetCurUri(), 'sidebarcontroller');

	$arResult['TRANSPORT_PARAMS'] = array();

	foreach ($arParams as $cell=>$val){
		if (substr($cell, 0, 1) !=  "~")
			$arResult['TRANSPORT_PARAMS'][$cell] = $val;
	}


	$signedParams = $signer->sign(base64_encode(serialize($arResult['TRANSPORT_PARAMS'])), 'sidebarcontroller');

	if ($arResult['EXT_FILE']<>''){
		$arExtFiles = array();

		include ($arResult['EXT_FILE']);

		if (count($arExtFiles['JS'])>0){
			foreach ($arExtFiles['JS'] as $val){
				$this->addExternalJs($val);
			}
		}
		if (count($arExtFiles['JS'])>0){
			foreach ($arExtFiles['CSS'] as $val){
				$this->addExternalCSS($val);
			}
		}
	}
	?>

	<div class="sidebar-control sidebar-control-empty" data-item="<?=$arParams["BXR_SIDEBAR_ID"]?>"></div>

	<?$sideBarType = strlen($arParams['SIDEBAR_TYPE'])>0 ? $arParams['SIDEBAR_TYPE'] : 'all'?>

<script>
	$(document).ready(function(){
		if (typeof(BXReadySidebar) === 'object') {
			BXReadySidebar.pushAjax({
				sidebarName: '<?=$sidebarID?>',
				ajaxUrl: '<?=$this->GetFolder().'/ajax.php'?>',
				is_ajax : 'y',
				backurl : '<?=$backurl?>',
				siteId : '<?=SITE_ID?>',
				parameters : '<?=$signedParams?>',
				template: '<?=$signedTemplate?>'
			});
		}
	})
</script>

<?endif;?>


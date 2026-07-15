<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$this->setFrameMode(true);
global $APPLICATION;

$arParams["MAX_WIDTH"] = intval($arParams["MAX_WIDTH"])>0 ? intval($arParams["MAX_WIDTH"]) : 960;
?>

<?if(
	$arParams["USE_FIXED_PANEL"] == "Y"
	&& CModule::IncludeModule('alexkova.bxready2')
	&& strlen($arParams['FIXED_PANEL_CODE'])>0
	&& strlen($arParams['FIXED_PANEL_DEFAULT_VARIANT'])>0
):

	$signer = new \Bitrix\Main\Security\Sign\Signer;
	$signedTemplate = $signer->sign($templateName, 'top_fixed_panel_ajax');
	$arResult['TRANSPORT_PARAMS'] = array();

	foreach ($arParams as $cell=>$val) {
		if (substr($cell, 0, 1) !=  "~")
			$arResult['TRANSPORT_PARAMS'][$cell] = $val;
	}

	$signedParams = $signer->sign(base64_encode(serialize($arResult['TRANSPORT_PARAMS'])), 'top_fixed_panel_ajax');
        
        $bxmarket = \Alexkova\Market2\Bxmarket::getInstance();
        $signedBxMarket = $signer->sign(base64_encode(serialize($bxmarket->getCoreData())), 'top_fixed_panel_ajax');
       
	?>

        <?if(!$APPLICATION->GetShowIncludeAreas() || !isset($arParams["SHOW_DIRECTLY_IN_EDIT_MODE"]) || $arParams["SHOW_DIRECTLY_IN_EDIT_MODE"]!="Y"   ):?>
            <script>
                var panelFixed = new JCTopFixedPanelAjax({
                        'mWidth': <?=$arParams["MAX_WIDTH"]?>,
                        'siteId': '<?=SITE_ID?>',
                        'templateID': '<?=SITE_TEMPLATE_PATH?>',
                        'ajaxUrl': '<?=$this->GetFolder()?>/ajax.php',
                        'parameters': '<?=$signedParams?>',
                        'bxmarket': '<?=$signedBxMarket?>',
                });
            </script>
            <a id="bxr-top-fixed-panel-anker"></a><div id="bxr-top-fixed-panel"></div>
        <?else:?>
            <a id="bxr-top-fixed-panel-anker"></a>
            <div id="bxr-top-fixed-panel" class="bxr-top-fixed-panel-show">
                <?\Alexkova\Bxready2\Area::showArea($arParams['FIXED_PANEL_CODE'], $arParams['FIXED_PANEL_DEFAULT_VARIANT'], true);?>
            </div>
        <?endif;?>
<?endif;?>


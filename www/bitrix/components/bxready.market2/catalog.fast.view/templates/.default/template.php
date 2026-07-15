<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
if (!CModule::IncludeModule('alexkova.market2')) die();
$this->setFrameMode(true);

global $unicumID;
if ($unicumID <= 0) {$unicumID = 1;} else {$unicumID++;}
if (isset($_REQUEST["bxr_ajax"]) && $_REQUEST["bxr_ajax"] == "yes")
    $unicumID = "fv_".htmlspecialchars($_REQUEST["ID"]);

if ($arParams['SINGLE_MODE'] == 'Y') 
{
    $arParams['UNICUM_POSTFIX'] = $arResult['PARENT'];
    $elementarArea = \Alexkova\Bxready2\Elementars::getArea('catalog.fast.view','element.detail');
    if (strlen($elementarArea) > 0) {
        include($elementarArea);
    } else {
        include('include/elementars/element.detail.php');
    }
}
else
{    
    $signer = new \Bitrix\Main\Security\Sign\Signer;
    $signedTemplate = $signer->sign($templateName, 'fast_view');
    
    $arResult['TRANSPORT_PARAMS'] = array();
    
    foreach ($arParams as $cell => $val) {
        if (substr_count($cell, "TEXT") > 0 || substr_count($cell, "MESS") > 0) {
            $val = trim($val);
            $val = urlencode($val);
        }
        if (substr($cell, 0, 1) !=  "~")
            $arResult['TRANSPORT_PARAMS'][$cell] = $val;
    }

    unset($arResult['TRANSPORT_PARAMS']['PAGER_TITLE']);
    
    $signedParams = $signer->sign(base64_encode(serialize($arResult['TRANSPORT_PARAMS'])), 'fast_view');
    ?><script>
        $(document).ready(function(){
            var <?='fastView_'.$strMainID?> = new JCCatalogFastView({
                ajaxUrl: '<?=$this->GetFolder().'/ajax.php'?>',
                postData: {
                    siteId : '<?=SITE_ID?>',
                    template : '<?=$signedTemplate?>',
                    parameters : '<?=$signedParams?>'
                }
            });
        });
    </script><?
	if(file_exists($_SERVER["DOCUMENT_ROOT"]."/local/js/alexkova.market2/bxr-sku-script.js")) {
		$APPLICATION->AddHeadScript("/local/js/alexkova.market2/bxr-sku-script.js");
	}
	else {
		$APPLICATION->AddHeadScript("/bitrix/js/alexkova.market2/bxr-sku-script.js");
	}
    
    $APPLICATION->IncludeComponent(
        'bxready.market2:catalog.fast.view',
        'element',
        $arParams,
        false,
        array("HIDE_ICONS" => "Y")
    );
	?>
	<div class="modal fast-view-modal" id="fv_fastview" tabindex="-1" role="dialog" aria-labelledby="modal-<?=$strMainID?>Label">
		<div class="modal-dialog fast-view-modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header bxr-border-bottom-color">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<div class="modal-title" id="modal-<?=$strMainID?>Label"><?=GetMessage('FAST_VIEW_BTN_TEXT')?></div>
				</div>
				<div class="modal-body" id='ajaxFormContainer_fastview'>
					<div class="bxr-modal-loading">
						<i class="fa fa-circle-o-notch fa-spin bxr-font-color" aria-hidden="true"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
<?
}




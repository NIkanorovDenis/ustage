<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<?if ($arParams['AJAX_MODE'] != 'Y') {
    $signer = new \Bitrix\Main\Security\Sign\Signer;
    $signedTemplate = $signer->sign($templateName, 'one_click_order');

    $arResult['TRANSPORT_PARAMS'] = array();

    foreach ($arParams as $cell => $val) {
        if (substr_count($cell, "TEXT") > 0 || substr_count($cell, "MESS") > 0) {
            $val = trim($val);
            $val = urlencode($val);
        }
        if (substr($cell, 0, 1) !=  "~")
            $arResult['TRANSPORT_PARAMS'][$cell] = $val;
    }

    $signedParams = $signer->sign(base64_encode(serialize($arResult['TRANSPORT_PARAMS'])), 'one_click_order');?>
    <script>
        $(document).ready(function(){
            obOneClickOrderBasket = new JCOneClickOrderBasket({
                formId: 'bxr-one-click-order-form'
            });
        });
    </script>
    <div class="modal one-click-order-modal" id="bxr-one-click-order" tabindex="-1" role="dialog" aria-labelledby="modal-ocoLabel">
        <div class="modal-dialog one-click-order-modal-dialog" role="document">
            <div class="modal-content"><div class='bxr-form-body-container'>
                <div class="modal-header bxr-border-bottom-color">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="h4 modal-title" id="modal-ocoLabel"><?=($arParams["FORM_TITLE"])?:GetMessage("ONE_CLICK_ORDER_TITLE")?></div>
                </div>
                <div class="modal-body" id='ajaxFormContainer_oco' data-form="oco">
                    <form id="bxr-one-click-order-form" class="bxr-form-body" name="bxrOneClickOrderForm" action="<?=$this->GetFolder()?>/ajax.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="parameters" value="<?=$signedParams?>">
                        <input type="hidden" name="template" value="<?=$signedTemplate?>">
                        <input type="hidden" name="siteId" value="<?=SITE_ID?>">
                        <input type="hidden" name="formId" value="bxr-one-click-order-form">
                        
                        <span class="bxr-pr-name"><?=GetMessage("BXR_ONE_CLICK_ORDER_NAME")?></span><?if (in_array("USER_NAME", $arParams["BXR_FORM_REQUIRED_PROPS"])) {?> <span class="starrequired">*</span><?}?>
                        <input class="form-control" type="text" name="ORDER_FIELDS[USER_NAME]" size="25" value="<?=($arResult["ORDER_FIELDS"]["USER_NAME"])?:""?>" data-code="USER_NAME"<?=(in_array("USER_NAME", $arParams["BXR_FORM_REQUIRED_PROPS"]))?" required":""?>>
                        
                        <span class="bxr-pr-name"><?=GetMessage("BXR_ONE_CLICK_ORDER_PHONE")?></span><?if (in_array("USER_PHONE", $arParams["BXR_FORM_REQUIRED_PROPS"])) {?> <span class="starrequired">*</span><?}?>
                        <input class="form-control" type="text" name="ORDER_FIELDS[USER_PHONE]" size="25" value="<?=($arResult["ORDER_FIELDS"]["USER_PHONE"])?:""?>" data-code="USER_PHONE"<?=(in_array("USER_PHONE", $arParams["BXR_FORM_REQUIRED_PROPS"]))?" required":""?>>
                        
                        <span class="bxr-pr-name"><?=GetMessage("BXR_ONE_CLICK_ORDER_EMAIL")?></span><?if (in_array("USER_EMAIL", $arParams["BXR_FORM_REQUIRED_PROPS"])) {?> <span class="starrequired">*</span><?}?>
                        <input class="form-control" type="text" name="ORDER_FIELDS[USER_EMAIL]" size="25" value="<?=($arResult["ORDER_FIELDS"]["USER_EMAIL"])?:""?>" data-code="USER_EMAIL"<?=(in_array("USER_EMAIL", $arParams["BXR_FORM_REQUIRED_PROPS"]))?" required":""?>>
                        
                        <span class="bxr-pr-name"><?=GetMessage("BXR_ONE_CLICK_ORDER_COMMENT")?></span><?if (in_array("USER_COMMENT", $arParams["BXR_FORM_REQUIRED_PROPS"])) {?> <span class="starrequired">*</span><?}?>
                        <textarea class="form-control" name="ORDER_FIELDS[USER_COMMENT]" rows="5" data-code="USER_COMMENT" style="resize: none"<?=(in_array("USER_COMMENT", $arParams["BXR_FORM_REQUIRED_PROPS"]))?" required":""?>><?=($arResult["ORDER_FIELDS"]["USER_COMMENT"])?:""?></textarea>
                                                    
                        <?if ($arResult['USE_PERSONAL_ACCEPT']):?>
                            <div class="bxr-personal-accept bxr-checkbox">
                                <input type="checkbox" name="accept_personal" value="yes" id="accept_form_one_click_order" <?=($arResult["ORDER_FIELDS"]["ACCEPT_PERSONAL"] == "yes")? " checked" : ""?> required>
                                <label class="bxr-label" for="accept_form_one_click_order">Нажимая на кнопку, я соглашаюсь на обработку персональных данных (<a href="/processing-personal-data/" target="_blank">Согласие на обработку персональных данных</a>)</label>
                            </div>    
                            <div class="bxr-personal-accept bxr-checkbox">
                                <input type="checkbox" name="accept_personal2" value="yes" id="accept_form_one_click_order2" <?=($arResult["ORDER_FIELDS"]["ACCEPT_PERSONAL2"] == "yes")? " checked" : ""?> required>
                                <label class="bxr-label" for="accept_form_one_click_order2">Нажимая на кнопку, я соглашаюсь с  <a href="/privacy-policy/" target="_blank">политикой обработки персональных данных</a></label>
                            </div>        
			<?endif;?>
                            
                        <div class="bxr-button-group text-left">
                            <button onclick="obOneClickOrderBasket.load();return false;" class="bxr-color-button" id="submit-bxr-one-click-order-form">
                                <?=($arParams["BXR_FORM_SUBMIT_CAPTION"])?:GetMessage("BXR_ONE_CLICK_ORDER_SUBMIT")?>
                            </button>
                        </div>
                    </form>
                </div>
            </div></div>
        </div>
    </div>
<?} else {
    $APPLICATION->RestartBuffer();
    echo $arResult["ORDER_STATUS"];
    die();
}?>

<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="bxr-form-body bx-auth bxr-form-body-container">
    
     <?if (!empty($arParams["~AUTH_RESULT"])):?>
        <div class="bxr-form-errors"><?
            $arParams["~AUTH_RESULT"]["MESSAGE"] = explode("<br>", $arParams["~AUTH_RESULT"]["MESSAGE"]);
            foreach ($arParams["~AUTH_RESULT"]["MESSAGE"] as $k => $v) {
                if(!empty($v))
                    echo "<p><i class='fa fa-exclamation-triangle'></i> " . $v . "</p>";
            }        
            ?></div>	
    <?endif;?>
    
    <form name="bform" id="bxr-form-forgotpasswd" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
<?
if (strlen($arResult["BACKURL"]) > 0)
{
?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?
}
?>
	<input type="hidden" name="AUTH_FORM" value="Y">
	<input type="hidden" name="TYPE" value="SEND_PWD">
	<p>
	<?=GetMessage("AUTH_FORGOT_PASSWORD_1")?>
	</p>
        
        <span class="bxr-pr-name"><?=GetMessage("AUTH_LOGIN")?></span>
        <input class="form-control" type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["LAST_LOGIN"]?>" />
        
        <span class="bxr-pr-name"><?=GetMessage("AUTH_EMAIL")?></span>
        <input  class="form-control" type="text" name="USER_EMAIL" maxlength="255" />
            
        <?if($arResult["USE_CAPTCHA"]):?>
            <span class="bxr-pr-name"><?=GetMessage("system_auth_captcha");?> <span class="starrequired">*</span></span>
            <div class="captchaBlock">
                <div>
                    <input type="hidden" class="captchaSid" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
                    <div class="captchaImgContent">
                        <img class="captchaImg" src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA">
                    </div>
                    <i class="reloadCaptcha fa fa-refresh bxr-font-color"></i>
                </div>
                <div>
                    <input class="inputCaptcha form-control" type="text" name="captcha_word" maxlength="50" value="">
                </div>
             </div>
	<?endif?>
        
        <div class="bxr-button-group text-left bxr-m20">
            <input type="submit" class="bxr-color bxr-color-button"  name="send_account_info" value="<?=GetMessage("AUTH_SEND")?>" />
             <!--noindex--><span class="login-link">
                <a href="<?=$arResult["AUTH_AUTH_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_AUTH")?></a>
            </span><!--/noindex-->
        </div>
        
</form></div>
<script type="text/javascript">
document.bform.USER_LOGIN.focus();
</script>

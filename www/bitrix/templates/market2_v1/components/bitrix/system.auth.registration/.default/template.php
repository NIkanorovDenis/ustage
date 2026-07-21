<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<div class="bx-auth bxr-form-body-container">
<?
    if (!empty($arParams["~AUTH_RESULT"])):?>
    <div class="bxr-form-errors"><?
        $arParams["~AUTH_RESULT"]["MESSAGE"] = explode("<br>", $arParams["~AUTH_RESULT"]["MESSAGE"]);
        foreach ($arParams["~AUTH_RESULT"]["MESSAGE"] as $k => $v) {
            if(!empty($v))
                echo "<p><i class='fa fa-exclamation-triangle'></i> " . $v . "</p>";
        }        
        ?></div>	
<?endif;?>

<?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y" && is_array($arParams["AUTH_RESULT"]) &&  $arParams["AUTH_RESULT"]["TYPE"] === "OK"):?>
<p><?echo GetMessage("AUTH_EMAIL_SENT")?></p>
<?else:?>

<?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):?>
	<p><?echo GetMessage("AUTH_EMAIL_WILL_BE_SENT")?></p>
<?endif?>
<noindex>
<form class="bxr-form-body" id="bxr-form-register" method="post" action="<?=SITE_DIR?>auth/" name="bform" enctype="multipart/form-data">
<?
if (strlen($arResult["BACKURL"]) > 0)
{
?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?
}
?>
	<input type="hidden" name="AUTH_FORM" value="Y" />
	<input type="hidden" name="TYPE" value="REGISTRATION" />
        
        <span class="bxr-pr-name"><?=GetMessage("AUTH_NAME")?></span>
        <input type="text" name="USER_NAME" maxlength="50" value="<?=$arResult["USER_NAME"]?>" class="bx-auth-input form-control" />
        
        <span class="bxr-pr-name"><?=GetMessage("AUTH_LAST_NAME")?></span>
        <input type="text" name="USER_LAST_NAME" maxlength="50" value="<?=$arResult["USER_LAST_NAME"]?>" class="bx-auth-input form-control" />
        
        <span class="bxr-pr-name"><?=GetMessage("AUTH_LOGIN_MIN")?></span> <span class="starrequired">*</span>
        <input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["USER_LOGIN"]?>" class="bx-auth-input form-control" />
        
        <span class="bxr-pr-name"><?=GetMessage("AUTH_PASSWORD_REQ")?></span> <span class="starrequired">*</span>
        <input type="password" name="USER_PASSWORD" maxlength="50" value="<?=$arResult["USER_PASSWORD"]?>" class="bx-auth-input form-control" autocomplete="off" />

        <span class="bxr-pr-name"><?=GetMessage("AUTH_CONFIRM")?></span> <span class="starrequired">*</span>
        <input type="password" name="USER_CONFIRM_PASSWORD" maxlength="50" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" class="bx-auth-input form-control" autocomplete="off" />
        
        <span class="bxr-pr-name"><?=GetMessage("AUTH_EMAIL")?></span><?if($arResult["EMAIL_REQUIRED"]):?> <span class="starrequired">*</span><?endif?>
        <input type="text" name="USER_EMAIL" maxlength="255" value="<?=$arResult["USER_EMAIL"]?>" class="bx-auth-input form-control" />

        

        <?if ($arResult["USE_CAPTCHA"] == "Y"):?>
            <span class="bxr-pr-name"><?=GetMessage("CAPTCHA_REGF_TITLE")?> <span class="starrequired">*</span></span>
            <div class="captchaBlock">
                <div>
                    <input type="hidden" class="captchaSid" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>">
                    <div class="captchaImgContent">
                        <img class="captchaImg" src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
                    </div>
                    <i class="reloadCaptcha fa fa-refresh bxr-font-color"></i>
                </div>
                <div>
                    <input class="inputCaptcha form-control" type="text" name="captcha_word" maxlength="50" value="" />
                </div>
            </div>
        <?endif;?>

        <div class="bxr-personal-accept bxr-checkbox ">
            <input type="checkbox" name="accept_personal" required value="yes" id="accept_form_register">
            <label class="bxr-label" for="accept_form_register">Нажимая на кнопку, я соглашаюсь на обработку персональных данных (<a href="/processing-personal-data/" target="_blank">Согласие на обработку персональных данных</a>)</label>
        </div>
		<div class="bxr-personal-accept bxr-checkbox">
            <input type="checkbox" name="accept_personal2" required value="yes" id="accept_form_register2">
            <label class="bxr-label" for="accept_form_register2">Нажимая на кнопку, я соглашаюсь с  <a href="/privacy-policy/" target="_blank">политикой обработки персональных данных</a></label>
        </div>
            
        <div id="bxr-pers-reg"></div>
        
        <div class="bxr-button-group text-left">
            <input class="bxr-color bxr-color-button" type="submit" name="Register" value="<?=GetMessage("AUTH_REGISTER")?>" />
            <span class="login-link">
                <a href="<?=$arResult["AUTH_AUTH_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_AUTH")?></a>
            </span>
        </div>
</form></noindex>
<script type="text/javascript">
    document.bform.USER_NAME.focus();
</script>
<?endif?>
</div>

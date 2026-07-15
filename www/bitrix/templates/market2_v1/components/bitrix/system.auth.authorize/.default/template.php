<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<div class="bx-auth action-form-t bxr-form-body-container">
    <?if (!empty($arParams["~AUTH_RESULT"])):?>
        <div class="bxr-form-errors"><?
            $arParams["~AUTH_RESULT"]["MESSAGE"] = explode("<br>", $arParams["~AUTH_RESULT"]["MESSAGE"]);
            foreach ($arParams["~AUTH_RESULT"]["MESSAGE"] as $k => $v) {
                if(!empty($v))
                    echo "<p><i class='fa fa-exclamation-triangle'></i> " . $v . "</p>";
            }        
            ?></div>	
    <?endif;?>
    <form name="form_auth" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">

            <input type="hidden" name="AUTH_FORM" value="Y" />
            <input type="hidden" name="TYPE" value="AUTH" />
            
            <?if (strlen($arResult["BACKURL"]) > 0):?>
                <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
            <?endif?>
            
            <?foreach ($arResult["POST"] as $key => $value):?>
                <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
            <?endforeach?>
                
            <input placeholder="<?=GetMessage('AUTH_LOGIN');?>" class="input_text_style form-control" type="text" name="USER_LOGIN" maxlength="255" value="<?=$arResult["LAST_LOGIN"]?>" />
            <input placeholder="<?=GetMessage("AUTH_PASSWORD");?>" class="input_text_style form-control" type="password" name="USER_PASSWORD" maxlength="255" />
            
            <?if($arResult["CAPTCHA_CODE"]):?>
                <input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
                <img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
                <?echo GetMessage("AUTH_CAPTCHA_PROMT")?>:
                <input class="bx-auth-input" type="text" name="captcha_word" maxlength="50" value="" size="15" />
            <?endif;?>
                
            <div class="clear"></div>
            <div class="containter">
                <div class="bxr-checkbox">
                        <?if ($arResult["STORE_PASSWORD"] == "Y"):?>   
                            <input type="checkbox" name="USER_REMEMBER" value="Y" id="USER_REMEMBER" checked>
                            <label class="bxr-label" for="USER_REMEMBER"><?=GetMessage("AUTH_REMEMBER_ME")?></label>  
                        <?endif?>
                </div>
                <div class="bxr-m20">
                    <input type="submit" name="Login" class="bxr-color-button  bxr-corns" value="<?=GetMessage("AUTH_AUTHORIZE")?>" />
                    <?if ($arParams["NOT_SHOW_LINKS"] != "Y"):?>
                    <!--noindex--><span class="login-link">
                            <a href="<?=$arParams["AUTH_REGISTER_URL"] ? $arParams["AUTH_REGISTER_URL"] : $arResult["AUTH_REGISTER_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_REGISTER")?></a> /
                            <a href="<?=$arParams["AUTH_FORGOT_PASSWORD_URL"] ? $arParams["AUTH_FORGOT_PASSWORD_URL"] : $arResult["AUTH_FORGOT_PASSWORD_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></a>
                        </span><!--/noindex-->
                    <?endif?>   
                </div>
                <div class="clear"></div>
            </div>
    </form>
</div>

<script type="text/javascript">
<?if (strlen($arResult["LAST_LOGIN"])>0):?>
try{document.form_auth.USER_PASSWORD.focus();}catch(e){}
<?else:?>
try{document.form_auth.USER_LOGIN.focus();}catch(e){}
<?endif?>
</script>

<?if($arResult["AUTH_SERVICES"]):?>
<?
$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "",
	array(
		"AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
		"CURRENT_SERVICE" => $arResult["CURRENT_SERVICE"],
		"AUTH_URL" => $arResult["AUTH_URL"],
		"POST" => $arResult["POST"],
		"SHOW_TITLES" => $arResult["FOR_INTRANET"]?'N':'Y',
		"FOR_SPLIT" => $arResult["FOR_INTRANET"]?'Y':'N',
		"AUTH_LINE" => $arResult["FOR_INTRANET"]?'N':'Y',
	),
	$component,
	array("HIDE_ICONS"=>"Y")
);
?>
<?endif?>

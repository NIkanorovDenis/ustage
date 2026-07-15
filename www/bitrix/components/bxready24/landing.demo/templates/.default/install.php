<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
    die();
}
$APPLICATION->setTitle(GetMessage('STEP_INSTALL_TITLE_PAGE')); 
use \Bitrix\Landing\Manager;
use \Bitrix\Main\Page\Asset;
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\ModuleManager;
Loc::loadMessages(__FILE__);

if ($arResult['ERRORS'])
{
    foreach ($arResult['ERRORS'] as $code => $error)
    {
        echo '<p style="color: red;">' . $error . '</p>';
    }
}
CJSCore::Init('jquery');
?>
<div class="install-site">
    <?if($arResult['is_add_site']):?>
        <div class="wrp-instal-ok">
            <h3><?=GetMessage('STEP_INSTALL_TITLE_OK')?></h3>
            <small>
                <?=GetMessage('STEP_INSTALL_TITLE_OK_TEXT')?>
            </small>
        </div>
    <?else:?>
        <div class="form-wrp">
            <form name="install_site" method="post" action="<?=$arResult['CURL']?>">
                <input type="hidden" name="site_code" value="<?=$arResult['INSTALL']['ID']?>">
                <h3><?=GetMessage('k_step_install_title')?>: <?=$arResult['INSTALL']['TITLE']?></h3>
                <?if($arResult['SITES']):?>
                    <div class="install-item">
                        <label for="site_id"><?=GetMessage('k_step_select_site')?></label>
                        <select name="site_id" id="site_id">
                            <?foreach ($arResult['SITES'] as $site):?>
                                <option value="<?=$site['ID']?>"><?=$site['TITLE']?></option>
                            <?endforeach;?>
                        </select>
                    </div>
                <?else:?>
                    <div class="install_site_error">
                        <b><?=GetMessage('STEP__1_NO_SITE_ERROR')?></b><br>
                        <span>
                        <?=GetMessage('STEP__1_NO_SITE_DESC')?>
                   </span>
                    </div>
                <?endif;?>
                <div class="btns actions">                    
                    <span  class="btn-link" type="button" onclick="BX.SidePanel.Instance.close();"><?=GetMessage('k_step_install_btn_cancel')?></span>
                    <?if($arResult['SITES']):?>
                        <button onclick="showLoaderSite();" class="btn-install" name="install_btn"><?=GetMessage('k_step_install_btn_install')?></button>
                    <?endif;?>
                    <div style="clear: both;"></div>
                </div>
            </form>
            <div class="adm-info-message-wrap">
                <div class="adm-info-message">
                <span class="required">
                    <?=GetMessage('WAR_INSTALL_TEXT')?>
                </span>
                </div>
            </div>
        </div>

    <?endif;?>
</div>
<div id="loader" class="overlay-loader">
    <img class="loader-icon spinning-cog" src="<?=$templateFolder?>/images/cog21.svg" data-cog="cog21">
</div>


                

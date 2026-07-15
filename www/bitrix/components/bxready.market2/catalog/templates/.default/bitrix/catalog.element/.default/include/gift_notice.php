<?
//--gift notice block--
if ($arParams['USE_GIFTS_DETAIL'] == 'Y' && $arParams['SHOW_GIFTS_DETAIL_NOTICE'] == 'Y' && \Bitrix\Main\ModuleManager::isModuleInstalled("sale")){?>
<div class="bxr-gift-notice bxr-border-color">
    <div class="bxr-gift-notice-icon bxr-color-button">
        <span class="fa fa-gift"></span>
    </div>
    <div class="bxr-gift-notice-text">
        <a href="javascript:void(0);" class="bxr-gift-notice-main bxr-font-color bxr-font-color-hover"><?=GetMessage("BXR_GIFT_NOTICE_TITLE")?></a>
        <span class="bxr-gift-notice-add"><?=(strlen($arParams["BXR_GIFT_NOTICE_TEXT"])>0) ? $arParams["BXR_GIFT_NOTICE_TEXT"] : GetMessage("BXR_GIFT_NOTICE_TEXT")?></span>
    </div> 
    <div class="clearfix"></div>
</div>
<?}?>
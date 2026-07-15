<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>
<div class="bxr-share-block">
<div class="bxr-share-block-content pull-right">
    <?$APPLICATION->IncludeComponent(
        "bitrix:main.share",
        "flat_business",
        array(
                "HANDLERS" => $arParams["SHARE_HANDLERS"],
                "HIDE" => $arParams["HIDE_SHARE_PANEL"],
                "PAGE_TITLE" => "",
                "PAGE_URL" => $APPLICATION->GetCurPage(),
                "SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
                "SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"]
        ),
        false
    );?>
</div>
<div class="bxr-share-block-text pull-right"><?=$arParams["BXR_SHARE_BLOCK_TEXT"]?></div>
<div class="clearfix"></div>

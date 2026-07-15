<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>
<?if ('Y' == $arParams['USE_SHARE']) {?>
    <div class="bxr-share-wrap">
        <span class="bxr-share-title"><?=GetMessage("BXR_SHARE_TITLE")?></span>
        <?$APPLICATION->IncludeComponent(
            "bitrix:main.share",
            "element_detail",
            Array(
                "COMPONENT_TEMPLATE" => ".default",
                "HANDLERS" => $arParams["HANDLERS"],
                "HIDE" => "N",
                "PAGE_TITLE" => $arResult["NAME"],
                "PAGE_URL" => $APPLICATION->GetCurPage(),
                "SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
                "SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"]
            ),
            false,
            array("HIDE_ICONS" => "Y")
        );?>
    </div>
<?}?>
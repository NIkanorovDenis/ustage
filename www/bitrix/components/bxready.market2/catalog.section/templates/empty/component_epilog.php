<?
if ($arParams["BXREADY_LIST_SLIDER_LISTPAGE"] == "Y"){
    $APPLICATION->AddHeadScript('/bitrix/js/alexkova.bxready2/slick/slick.js');
    $APPLICATION->SetAdditionalCSS('/bitrix/js/alexkova.bxready2/slick/slick.css', false);
}

if ($arParams["USE_FAST_VIEW"] == "Y") {
    $APPLICATION->AddHeadScript("/bitrix/js/alexkova.market2/bxr-sku-script.js");
    $APPLICATION->AddHeadScript("/bitrix/js/alexkova.bxready2/jquery.loupe.min.js");
    $APPLICATION->AddHeadScript('/bitrix/js/alexkova.bxready2/slick/slick.js');
    $APPLICATION->SetAdditionalCSS('/bitrix/js/alexkova.bxready2/slick/slick.css', false);
    $APPLICATION->AddHeadScript('/bitrix/js/alexkova.bxready2/countdown/countdown.js', true);
    $APPLICATION->SetAdditionalCSS('/bitrix/js/alexkova.bxready2/countdown/countdown.css', false);
    $APPLICATION->SetAdditionalCSS("/bitrix/components/bxready.market2/catalog.product.subscribe/templates/.default/style.css");
    $APPLICATION->AddHeadScript("/bitrix/components/bxready.market2/catalog.product.subscribe/templates/.default/script.js");
    
    $APPLICATION->AddHeadScript('/bitrix/components/bxready.market2/catalog.fast.view/templates/.default/script.js');
    $APPLICATION->SetAdditionalCSS('/bitrix/components/bxready.market2/catalog.fast.view/templates/.default/style.css', false);
    $APPLICATION->AddHeadScript('/bitrix/components/bxready.market2/catalog.fast.view/templates/element/script.js');
    $APPLICATION->SetAdditionalCSS('/bitrix/components/bxready.market2/catalog.fast.view/templates/element/style.css', false);
};
?>
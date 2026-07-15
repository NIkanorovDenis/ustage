<?
$APPLICATION->IncludeComponent("bxready2:abmanager",
    $arParams['BXR_ADV_BOTTOM_CONTENT_DETAIL'],
    array(
        "SHOW" => "BXR_CATALOG_BOTTOM",
        "BANTYPE" => "BXR_CATALOG_BOTTOM",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "0",
        "USE_IN_LG_MODE" => "Y",
        "USE_IN_MD_MODE" => "Y",
        "USE_IN_SM_MODE" => "N",
        "USE_IN_XS_MODE" => "N"
    ),
    false,
    array(
        "ACTIVE_COMPONENT" => "Y",
        "HIDE_ICONS"=>"Y"
    )
);
?>
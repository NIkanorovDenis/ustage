<div class="bxr-catalog-top-b">
    <?$APPLICATION->IncludeComponent("bxready2:abmanager",
        $arParams['BXR_ADV_TOP_CONTENT_SECTION'],
        array(
            "SHOW" => "BXR_CONTENT_TOP",
            "BANTYPE" => "BXR_CONTENT_TOP",
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
    );?>
</div>
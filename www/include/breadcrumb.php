<div class="bxr-cloud-all bxr-cloud-padding bxr-b20">
    <?if($APPLICATION->GetCurPage(true) != SITE_DIR.'index.php'){
        $APPLICATION->IncludeComponent(
            "bitrix:breadcrumb", 
            "bxr_market2", 
            array(
                "COMPONENT_TEMPLATE" => "bxr_market2",
                "PATH" => "",
                "SITE_ID" => "",
                "START_FROM" => "0"
            ),
            false
        );
    }
    ?>
</div>
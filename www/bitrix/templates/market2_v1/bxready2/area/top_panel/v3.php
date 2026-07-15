<? global $APPLICATION;
$bxmarket = \Alexkova\Market2\Bxmarket::getInstance();?>
<div class="bxr-upper-part bxr-cloud-all bxr-cloud-all-br3-not bxr-cloud-all-br4-not">
    <div class="row">
        <div class="col-xs-3">
            <div class="inline-block bxr-login-container">
                <?$authFrame = new \Bitrix\Main\Page\FrameHelper("bxr_login_frame");
                $authFrame->begin();?>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:system.auth.form", 
                    "popup", 
                    array(
                            "REGISTER_URL" => SITE_DIR."auth/",
                            "FORGOT_PASSWORD_URL" => SITE_DIR."auth/",
                            "PROFILE_URL" => SITE_DIR."personal/profile/",
                            "SHOW_ERRORS" => "Y",
                            "COMPONENT_TEMPLATE" => "popup"
                    ),
                    false
                );?>
                <?$authFrame->end();?>
            </div>
        </div>
        <div class="col-xs-9 text-right bxr-element-row-middle">          
            <div class="bxr-element-col-middle">                
                <div id="top-panel-menu-link" >
                    <?$APPLICATION->IncludeComponent("bxready.market2:menu", "top_panel", array(
	"COMPONENT_TEMPLATE" => "top_panel",
		"ROOT_MENU_TYPE" => "top",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "36000",
		"MENU_CACHE_USE_GROUPS" => "N",
		"MENU_CACHE_GET_VARS" => "",
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "service",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"CACHE_SELECTED_ITEMS" => false
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "N"
	)
);?>
                </div>
                <div id="top-panel-region-link" >
                    <?$APPLICATION->IncludeComponent(
                        "bxready.market2:main.include", 
                        "named_area", 
                        array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "inc",
                                "EDIT_TEMPLATE" => "",
                                "PATH" => SITE_DIR."include/region_selector.php",
                                "INCLUDE_PTITLE" => GetMessage("GHANGE_REGION"),
                                "COMPONENT_TEMPLATE" => "named_area",
                                "FLOAT" => "NONE",
                                "STYLE" => "small"
                        ),
                        false
                    );?>
                </div>
            </div>
            <div class="bxr-element-col-middle bxr-socnet-container">
                <?$APPLICATION->IncludeComponent(
                    "bxready.market2:main.include",
                    "named_area",
                    Array(
                        "AREA_FILE_SHOW" => "file",
                        "AREA_FILE_SUFFIX" => "inc",
                        "EDIT_TEMPLATE" => "",
                        "PATH" => SITE_DIR."include/socnet.php",
                        "INCLUDE_PTITLE" => GetMessage("GHANGE_FOOTER_SOCNET")
                    ),
                    false
                );?>
            </div>
        </div>
    </div>
</div>
<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/bxready2/area/top_panel/v3/style.css", true);?>
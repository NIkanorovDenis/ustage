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
                    <?$APPLICATION->IncludeComponent(
                        "bxready.market2:menu", 
                        "top_panel", 
                        array(
                                "COMPONENT_TEMPLATE" => "top_panel",
                                "ROOT_MENU_TYPE" => "topline",
                                "MENU_CACHE_TYPE" => "A",
                                "MENU_CACHE_TIME" => "36000",
                                "MENU_CACHE_USE_GROUPS" => "N",
                                "MENU_CACHE_GET_VARS" => array(
                                ),
                                "MAX_LEVEL" => "2",
                                "CHILD_MENU_TYPE" => "service",
                                "USE_EXT" => "N",
                                "DELAY" => "N",
                                "ALLOW_MULTI_SELECT" => "N",
                                "CACHE_SELECTED_ITEMS" => false,
                        ),
                        false
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
            <div class="bxr-element-col-middle bxr-search-container visible-xl-table-cell hidden-lg hidden-md hidden-xs hidden-sm">
                <?$APPLICATION->IncludeComponent(
                    "bxready.market2:search.title", 
                    "", 
                    array(
                        "COMPONENT_TEMPLATE" => "",
                        "NUM_CATEGORIES" => "1",
                        "TOP_COUNT" => "5",
                        "ORDER" => "date",
                        "USE_LANGUAGE_GUESS" => "Y",
                        "CHECK_DATES" => "N",
                        "SHOW_OTHERS" => "N",
                        "PAGE" => "/catalog/",
                        "SHOW_INPUT" => "Y",
                        "INPUT_ID" => "title-search-input-in-top-panel",
                        "CONTAINER_ID" => "title-search-in-top-panel",
                        "CATEGORY_0_TITLE" => "",
                        "CATEGORY_0" => array(
                                0 => "no",
                        ),
                        "PRICE_CODE" => array(
                                0 => "BASE",
                        ),
                        "PRICE_VAT_INCLUDE" => "Y",
                        "PREVIEW_TRUNCATE_LEN" => "200",
                        "SHOW_PREVIEW" => "Y",
                        "CONVERT_CURRENCY" => "N",
                        "PREVIEW_WIDTH" => "75",
                        "PREVIEW_HEIGHT" => "75",
                        "CATEGORY_0_iblock_catalog" => array(
                                0 => "12",
                        )
                    ),
                    false
                );?>
            </div>
        </div>        
    </div>
</div>
<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/bxready2/area/top_panel/v5/style.css", true);?>
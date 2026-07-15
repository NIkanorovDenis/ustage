<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $APPLICATION;
$bxmarket = \Alexkova\Market2\Bxmarket::getInstance();
?>
<div class="bxr-full-width bxr-color-line footer-head-v0 footer-head-v2 container bxr-bg-container <?=$bxmarket->getCoreData("xl_class");?>">
    <div class="row">
        <div class="col-xs-12"><div class="bxr-cloud-all bxr-cloud-padding bxr-cloud-all-br4-not bxr-cloud-all-br3-not">
            <div class="container-fluid footer-head bxr-dark-flat footer-head hidden-sm hidden-xs">
                <div class="row">
                    <div class="col-xl-4 col-lg-3 col-md-3 hidden-sm hidden-xs">
                        <?$APPLICATION->IncludeComponent(
                            "bxready.market2:main.include",
                            "named_area",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "inc",
                                "EDIT_TEMPLATE" => "",
                                "PATH" => SITE_DIR."include/footer_name_1.php",
                            ),
                            false
                        );?>
                    </div>
                    <div class="col-xl-3 col-lg-2 col-md-2 hidden-sm hidden-xs">
                        <?$APPLICATION->IncludeComponent(
                            "bxready.market2:main.include",
                            "named_area",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "inc",
                                "EDIT_TEMPLATE" => "",
                                "PATH" => SITE_DIR."include/footer_name_2.php",
                            ),
                            false
                        );?>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-3 hidden-sm hidden-xs">
                        <?$APPLICATION->IncludeComponent(
                            "bxready.market2:main.include",
                            "named_area",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "inc",
                                "EDIT_TEMPLATE" => "",
                                "PATH" => SITE_DIR."include/footer_name_3.php",
                            ),
                            false
                        );?>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-4 hidden-sm hidden-xs pull-right">
                         <?$APPLICATION->IncludeComponent(
                            "bxready.market2:main.include",
                            "named_area",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "inc",
                                "EDIT_TEMPLATE" => "",
                                "PATH" => SITE_DIR."include/footer_name_4.php",
                            ),
                            false
                        );?>                    
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row footerline">
                        <div class="hidden-lg hidden-md col-sm-12 col-xs-12 mobile-footer-menu-tumbl">
                            <?$APPLICATION->IncludeComponent(
                                "bxready.market2:main.include",
                                "named_area",
                                Array(
                                    "AREA_FILE_SHOW" => "file",
                                    "AREA_FILE_SUFFIX" => "inc",
                                    "EDIT_TEMPLATE" => "",
                                    "PATH" => SITE_DIR."include/footer_name_1.php",
                                    "INCLUDE_PTITLE" => GetMessage("GHANGE_FOOTER_CATALOG")
                                ),
                                false
                            );?>
                            <i class="fa fa-chevron-down"></i>
                        </div>
                        <div class="col-xl-4 col-lg-3 col-md-3 col-sm-12 col-xs-12 toggled-item">
                            <?
                            $APPLICATION->IncludeComponent(
                                "bxready.market2:menu",
                                "footer_cols",
                                Array(
                                    "ROOT_MENU_TYPE" => "footer_1",
                                    "MAX_LEVEL" => "1",
                                    "CHILD_MENU_TYPE" => "left",
                                    "USE_EXT" => "Y",
                                    "DELAY" => "N",
                                    "ALLOW_MULTI_SELECT" => "N",
                                    "MENU_CACHE_TYPE" => "A",
                                    "MENU_CACHE_TIME" => "36000",
                                    "MENU_CACHE_USE_GROUPS" => "N",
                                    "MENU_CACHE_GET_VARS" => "",
                                    "COLS" => array("xs" => 1, "sm" => 1, "md" => 1, "lg" => 1, "xl" => 2),
                                    "CACHE_SELECTED_ITEMS" => false
                                ),
                                false
                            );
                            ?>
                        </div>
                        <div class="hidden-lg hidden-md col-sm-12 col-xs-12 mobile-footer-menu-tumbl">
                            <?$APPLICATION->IncludeComponent(
                                "bxready.market2:main.include",
                                "named_area",
                                Array(
                                    "AREA_FILE_SHOW" => "file",
                                    "AREA_FILE_SUFFIX" => "inc",
                                    "EDIT_TEMPLATE" => "",
                                    "PATH" => SITE_DIR."include/footer_name_2.php",
                                    "INCLUDE_PTITLE" => GetMessage("GHANGE_FOOTER_MENU")
                                ),
                                false
                            );?>
                            <i class="fa fa-chevron-down"></i>
                        </div>
                        <div class="col-xl-3 col-lg-2 col-md-2 col-sm-12 col-xs-12 toggled-item">
                            <?
                            $APPLICATION->IncludeComponent(
                                "bxready.market2:menu",
                                "footer_cols",
                                Array(
                                    "ROOT_MENU_TYPE" => "footer_2",
                                    "MAX_LEVEL" => "1",
                                    "CHILD_MENU_TYPE" => "left",
                                    "USE_EXT" => "Y",
                                    "DELAY" => "N",
                                    "ALLOW_MULTI_SELECT" => "N",
                                    "MENU_CACHE_TYPE" => "A",
                                    "MENU_CACHE_TIME" => "36000",
                                    "MENU_CACHE_USE_GROUPS" => "N",
                                    "MENU_CACHE_GET_VARS" => "",
                                    "COLS" => array("xs" => 1, "sm" => 1, "md" => 1, "lg" => 1, "xl" => 2),
                                    "CACHE_SELECTED_ITEMS" => false
                                ),
                                false
                            );
                            ?>
                        </div>
                        <div class="hidden-lg hidden-md col-sm-12 col-xs-12 mobile-footer-menu-tumbl">
                            <?$APPLICATION->IncludeComponent(
                                "bxready.market2:main.include",
                                "named_area",
                                Array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "inc",
                                "EDIT_TEMPLATE" => "",
                                "PATH" => SITE_DIR."include/footer_name_3.php",
                                "INCLUDE_PTITLE" => GetMessage("GHANGE_FOOTER_MENU")
                              ),
                              false
                            );?>
                            <i class="fa fa-chevron-down"></i>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-3 col-sm-12 col-xs-12 toggled-item">
                            <?
                                $APPLICATION->IncludeComponent(
                                "bxready.market2:menu",
                                "footer_cols",
                                Array(
                                    "ROOT_MENU_TYPE" => "footer_3",
                                    "MAX_LEVEL" => "1",
                                    "USE_EXT" => "Y",
                                    "DELAY" => "N",
                                    "ALLOW_MULTI_SELECT" => "N",
                                    "MENU_CACHE_TYPE" => "A",
                                    "MENU_CACHE_TIME" => "36000",
                                    "MENU_CACHE_USE_GROUPS" => "N",
                                    "MENU_CACHE_GET_VARS" => "",
                                    "COLS" => "1",
                                    "CACHE_SELECTED_ITEMS" => false
                                  ),
                                  false
                                );
                            ?>
                            <a data-toggle="modal" data-target="#bxr-new-year-popup">Информация о новогодних праздниках</a>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-xs-12 footer-about-company">
                            <?$APPLICATION->IncludeComponent(
                                "bxready.market2:main.include",
                                "named_area",
                                Array(
                                    "AREA_FILE_SHOW" => "file",
                                    "AREA_FILE_SUFFIX" => "inc",
                                    "EDIT_TEMPLATE" => "",
                                    "PATH" => SITE_DIR."include/footer_about_company.php",
                                    "INCLUDE_PTITLE" => GetMessage("GHANGE_FOOTER_INFO")
                                ),
                                false
                            );?>                            
                            <div class="clearfix"></div>
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
        </div></div>
    </div>
</div>
<?
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/bxready2/area/footer/v2/style.css", true);
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/bxready2/area/footer/v2/script.js");
?>
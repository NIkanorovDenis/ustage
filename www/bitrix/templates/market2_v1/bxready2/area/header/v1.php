<? global $APPLICATION;
$bxmarket = \Alexkova\Market2\Bxmarket::getInstance();?>
<div class="bxr-header-panel bxr-header-panel-v1 ">
    <div class="bxr-top-panel-header-container">
        <?\Alexkova\Bxready2\Area::showArea("top_panel", "v1");?>
    </div>
    <div class="bxr-lower-part container-fluid bxr-cloud-all bxr-cloud-all-br1-not bxr-cloud-all-br2-not bxr-cloud-all-br4-not <?=($bxmarket->getCoreData("top_menu"))? "bxr-cloud-all-br3-not" : "";?>">
        <div class="row">
            <div class="col-xl-<?=($bxmarket->getCoreData("xl_mode"))?2:3?> bxr-show-left-menu<?=($bxmarket->getCoreData("top_menu"))? "-conteiner" : "";?> col-md-3 col-sm-4 col-xs-12 bxr-element-row-middle">
                <div class="bxr-logo-top-panel bxr-element-col-middle">
                    <?$APPLICATION->IncludeComponent(
                        "bxready.market2:main.include",
                        "named_area",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "EDIT_TEMPLATE" => "",
                            "PATH" => SITE_DIR."include/logo.php",
                            "INCLUDE_PTITLE" => GetMessage("GHANGE_LOGO")
                        ),
                        false
                    );?>
                    <?if(!$bxmarket->getCoreData("top_menu")):?>
                        <div class="bar-menu-rotate">
                           <i class="fa fa-angle-up bxr-font-color"></i>
                           <i class=" fa bxr-font-dark fa-fw fa fa-bars bxr-font-color"></i>
                       </div>
                    <?endif;?>
                </div>
                <?if(!$bxmarket->getCoreData("top_menu")):?>
                    <div id="button_menu_container" class="bxr-show-left-menu bxr-is-header">
                        <?if($bxmarket->getCoreData("isCatalog") != "Y" &&
                            (($bxmarket->getCoreData("left_column") == "Y" && $bxmarket->getCoreData("left_menu") == "T") ||
                             ($bxmarket->getCoreData("left_column") == "N" && ($bxmarket->getCoreData("left_menu") == "T" || $bxmarket->getCoreData("left_menu") == "Y"))
                        )):?>
                            <?$APPLICATION->IncludeComponent(
                                "bxready.market2:main.include",
                                "named_area",
                                Array(
                                    "AREA_FILE_SHOW" => "file",
                                    "AREA_FILE_SUFFIX" => "inc",
                                    "EDIT_TEMPLATE" => "",
                                    "PATH" => SITE_DIR."include/left_menu.php",
                                ),
                                false
                            );?>
                        <?endif;?>
                    </div>
                <?endif;?>
            </div>
            <div class="col-xl-<?=($bxmarket->getCoreData("min_content_buttons_action"))? "6" : "5";?> col-lg-<?=($bxmarket->getCoreData("min_content_buttons_action"))? "8" : "6";?> col-xs-<?=($bxmarket->getCoreData("min_content_buttons_action"))? "8" : "6";?> bxr-element-row-middle hidden-sm hidden-xs">
                <div id="search_title_container" class="bxr-element-col-middle"><div>
                    <?
                        $APPLICATION->IncludeComponent(
	"bxready.market2:search.title", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"NUM_CATEGORIES" => "1",
		"TOP_COUNT" => "5",
		"ORDER" => "date",
		"USE_LANGUAGE_GUESS" => "Y",
		"CHECK_DATES" => "N",
		"SHOW_OTHERS" => "N",
		"PAGE" => "/product/",
		"SHOW_INPUT" => "Y",
		"INPUT_ID" => "title-search-input-in-top",
		"CONTAINER_ID" => "title-search-in-top",
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
                </div></div>
            </div>
            <div class="col-xl-<?=($bxmarket->getCoreData("min_content_buttons_action") && ($bxmarket->getCoreData("right_column")!="T"))? "4" : "3";?> visible-xl-table hidden-lg hidden-md col-xs-8 hidden-xs bxr-element-row-middle">
                <div class="bxr-element-col-middle bxr-el-slogan <?=( $bxmarket->getCoreData("right_column")!="T" && $bxmarket->getCoreData("xl_mode") ? "text-right" : "")?> ">
                    <?$APPLICATION->IncludeComponent(
                        "bxready.market2:main.include",
                        "named_area",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "EDIT_TEMPLATE" => "",
                            "PATH" => SITE_DIR."include/slogan.php",
                            "INCLUDE_PTITLE" => GetMessage("GHANGE_SLOGAN")
                        ),
                        false
                    );?>
                </div>
            </div>
            <div class="col-xl-<?=($bxmarket->getCoreData("min_content_buttons_action"))? ($bxmarket->getCoreData("right_column")!="T") ? "0" :"1 bxr-rpbtn-margin-min" : "2";?> col-sm-<?=($bxmarket->getCoreData("min_content_buttons_action"))? "1 bxr-rpbtn-margin-min" : "3";?> col-xs-<?=($bxmarket->getCoreData("min_content_buttons_action"))? "1 bxr-rpbtn-margin-min" : "4";?> bxr-element-row-middle hidden-sm hidden-xs">
                <div id="basket_container" class="bxr-element-col-middle bxr-basket-container"><div> 
                    <div class="bxr-rpbtn-container">
                        <a href="#" class="login-line bxr-frame-btn">
                            <i class="fa fa-user-o"></i>
                        </a>
                    </div>
                        
                    <!--noindex-->                    
                    <?if($bxmarket->getCoreData("right_column")!="N"):?>
                        <div class="bxr-rpbtn-container <?=($bxmarket->getCoreData("xl_mode") && $bxmarket->getCoreData("right_column")=="Y")?'hidden-xl':'';?>">
                            <a class="bxr-right-panel-btn-on-top animation" data-state="minimized">
                                <i class="fa fa-diamond" aria-hidden="true"></i>
                            </a>
                        </div>
                    <?endif;?>
                    <!--/noindex-->
                    
                    <?$basketFrame = new \Bitrix\Main\Page\FrameHelper("bxr_small_basket");
                    $basketFrame->begin();?>
                    <?$APPLICATION->IncludeComponent(
                        "bxready.market2:basket.small", 
                        "", 
                        array(
                                "COMPONENT_TEMPLATE" => "",
                                "PATH_TO_BASKET" => SITE_DIR."personal/basket/",
                                "PATH_TO_ORDER" => SITE_DIR."personal/order/make/",
                                "USE_COMPARE" => "Y",
                                "IBLOCK_TYPE" => "catalog_new",
                                "IBLOCK_ID" => "32",
                                "USE_DELAY" => "Y",
                                "PRODUCT_PROVIDER_CLASS" => "",
                                "STYLE" => $bxmarket->getCoreData("basket_style"),
                                "USE_HEART" => "Y",
                                "BXR_COMPARE_LINK" => SITE_DIR."catalog/compare.php",
                                "BXR_FAVORITES_LINK" => SITE_DIR."personal/favorites/"
                        ),
                        false
                    );?>
                    <?$basketFrame->end();?>
                </div></div>
            </div>     
        </div>
    </div>
    <?if($bxmarket->getCoreData("top_menu")):?>
        <div class="bxr-top-panel-topmenu-container">
            <div class="row">
                <div class="col-xs-12">
                    <?$APPLICATION->IncludeComponent(
                        "bxready.market2:main.include",
                        "named_area",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "EDIT_TEMPLATE" => "",
                            "PATH" => SITE_DIR."include/top_menu.php",
                        ),
                        false
                    );?>
                </div>
            </div>
        </div>
        <div class="container-fluid container-fluid-for-menu">
            <div class="row">
                <div class="col-xl-<?=($bxmarket->getCoreData("xl_mode"))?2:3?> col-md-3 col-sm-4 col-xs-12 bxr-element-row-middle">
                    <div id="button_menu_container" class="bxr-is-header">
                        <?if($bxmarket->getCoreData("isCatalog") != "Y" &&
                            (($bxmarket->getCoreData("left_column") == "Y" && $bxmarket->getCoreData("left_menu") == "T") ||
                             ($bxmarket->getCoreData("left_column") == "N" && ($bxmarket->getCoreData("left_menu") == "T" || $bxmarket->getCoreData("left_menu") == "Y"))
                                )):?><div class="bxr-show-left-menu">
                            <?$APPLICATION->IncludeComponent(
                                "bxready.market2:main.include",
                                "named_area",
                                Array(
                                    "AREA_FILE_SHOW" => "file",
                                    "AREA_FILE_SUFFIX" => "inc",
                                    "EDIT_TEMPLATE" => "",
                                    "PATH" => SITE_DIR."include/left_menu.php",
                                ),
                                false
                                    );?></div>
                        <?endif;?>
                    </div>
                </div>
            </div>
        </div>
    <?endif;?>
</div>
<script>
    $(document).ready(function() {
        $('.bxr-show-left-menu .bxr-left-column-js.isHidden').prependTo( '#button_menu_container' );
        $('#basket_container .login-line').attr("href", $('#login-line + a').attr("href")).attr("onclick", $('#login-line + a').attr("onclick"));
    });
</script>
<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/bxready2/area/header/v1/style.css", true);?>
<?
    if(!$bxmarket->getCoreData("top_menu"))
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/bxready2/area/header/v1/style_ntm.css", true);
?>

<? global $APPLICATION;
$bxmarket = \Alexkova\Market2\Bxmarket::getInstance();
?>
<div class="top_fixed_panel top_fixed_panel_v1">
    <div class="bxr-full-width bxr-container-headline">
        <div class="container <?=$bxmarket->getCoreData("xl_class");?>">
            <div class="row">
                <div class="col-xl-2 bxr-show-left-menu col-md-3 col-sm-4 col-xs-12 bxr-element-row-middle">
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
                        <div class="bar-menu-rotate">
                            <i class="fa fa-angle-up bxr-font-color"></i>
                            <i class=" fa bxr-font-dark fa-fw fa fa-bars bxr-font-color"></i>
                        </div>
                    </div>
                    <div id="fixed_button_menu_container"></div>
                </div>
                <div class="col-xl-<?=($bxmarket->getCoreData("min_content_buttons_action"))? "6" : "6";?> col-lg-<?=($bxmarket->getCoreData("min_content_buttons_action"))? "4" : "3";?> col-xs-5 bxr-element-row-middle visible-xl-table  hidden-md hidden-sm hidden-xs">
                    <div id="fixed_search_title" class="bxr-element-col-middle"></div>
                </div>
                <div class="col-xl-2 col-lg-<?=($bxmarket->getCoreData("min_content_buttons_action"))? "3" : "3";?> col-md-<?=($bxmarket->getCoreData("min_content_buttons_action"))? "6" : "4";?> col-xs-8 bxr-element-row-middle hidden-xs">
                    <div class="bxr-element-col-middle text-right bxr-phone-container">
                        <?$APPLICATION->IncludeComponent(
                            "bxready.market2:main.include", 
                            "include_phone", 
                            array(
                                    "AREA_FILE_SHOW" => "file",
                                    "AREA_FILE_SUFFIX" => "inc",
                                    "EDIT_TEMPLATE" => "",
                                    "PATH" => SITE_DIR."include/phone_list.php",
                                    "INCLUDE_PTITLE" => GetMessage("GHANGE_PHONE"),
                                    "STYLE" => "big",
                            ),
                            false
                        );?>
                    </div>
                </div>
                <div class="bxr-rpbtn-margin-min col-xl-<?=($bxmarket->getCoreData("min_content_buttons_action"))? "2" : "2";?> col-lg-<?=($bxmarket->getCoreData("min_content_buttons_action"))? "2" : "3";?> col-xs-<?=($bxmarket->getCoreData("min_content_buttons_action"))? "3" : "5";?> bxr-element-row-middle hidden-sm hidden-xs">
                    <div id="fixed_basket" class="bxr-element-col-middle bxr-basket-container"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<script>

    if($(".bxr-left-column-js").hasClass("isHidden")) {
        $('.bar-menu-rotate').show();
    }

    $(document).on(
        'onShowFixedPanel',
        '#bxr-top-fixed-panel',
        function(e){
            $('#basket_container > div').prependTo( '#fixed_basket' );
            $('#search_title_container > div').prependTo( '#fixed_search_title' );
            $('#button_menu_container > div').prependTo( '#fixed_button_menu_container' );
            h = $(".top_fixed_panel").height();
            window.BXReady.lScroll.p = h;
            window.BXReady.dScroll.p = h+10;
        }
    );

    $(document).on(
        'onHideFixedPanel',
        '#bxr-top-fixed-panel',
        function(e){
            $('#fixed_basket > div').prependTo( '#basket_container' );
            $('#fixed_search_title > div').prependTo( '#search_title_container' );
            $('#fixed_button_menu_container > div').prependTo( '#button_menu_container' );
        }
    );
</script>
<?
    include dirname(__FILE__)."/v1.ext.php";
?>
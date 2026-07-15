<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $APPLICATION;
$bxmarket = \Alexkova\Market2\Bxmarket::getInstance();?>
<div class="bxr-full-width container bxr-bg-container <?=$bxmarket->getCoreData("xl_class");?>">
    <div class="row">
        <div class="col-xs-12">
            <div class="container-fluid bxr-under-footer-v1 bxr-color-flat">            
                    <div class="row bxr-cloud-padding ">
                        <div class="col-lg-2 col-md-3 col-sm-3 hidden-sm hidden-xs bxr-element-row-middle"><div class="bxr-element-col-middle">
                            <?$APPLICATION->IncludeComponent("bxready.market2:main.include", "named_area1", Array(
	"AREA_FILE_SHOW" => "file",	// Показывать включаемую область
		"AREA_FILE_SUFFIX" => "inc",	// Суффикс имени файла включаемой области
		"EDIT_TEMPLATE" => "",	// Шаблон области по умолчанию
		"PATH" => SITE_DIR."include/logo_footer.php",
		"INCLUDE_PTITLE" => GetMessage("GHANGE_LOGO"),	// Персональное название для области
	),
	false
);?>
                        </div></div>
                        <div class="col-md-5 col-sm-7 col-xs-12 bxr-element-row-middle"><div class="bxr-element-col-middle">
                            <?$APPLICATION->IncludeComponent(
                                    "bxready.market2:main.include",
                                    "named_area",
                                    Array(
                                        "AREA_FILE_SHOW" => "file",
                                        "AREA_FILE_SUFFIX" => "inc",
                                        "EDIT_TEMPLATE" => "",
                                        "PATH" => SITE_DIR."include/footer_forms.php",
                                        "INCLUDE_PTITLE" => GetMessage("FOOTER_COPYRIGHT")
                                    ),
                                    false
                            );?>            
                        </div></div>
                        <div class="col-md-4 col-sm-5 col-xs-12 text-right pull-right bxr-element-row-middle">
                            <span class="copyright bxr-element-col-middle"><?$APPLICATION->IncludeComponent(
                                "bxready.market2:main.include",
                                "named_area",
                                Array(
                                    "AREA_FILE_SHOW" => "file",
                                    "AREA_FILE_SUFFIX" => "inc",
                                    "EDIT_TEMPLATE" => "",
                                    "PATH" => SITE_DIR."include/footer_copyright.php",
                                    "INCLUDE_PTITLE" => GetMessage("FOOTER_COPYRIGHT")
                                ),
                                false
                            );?></span>
                        </div>
                    </div>
                
            </div>
        </div>
    </div>
</div>
<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/bxready2/area/footer/under_v1/style.css", true);?>
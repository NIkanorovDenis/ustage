<?php 
$bxmarket = \Alexkova\Market2\Bxmarket::getInstance(); 
$bxready2 = \Alexkova\Bxready2\Bxready::getInstance(); 
IncludeTemplateLangFile(__FILE__); ?>

            </div>

<?php 
if ($APPLICATION->GetCurPage(true) == SITE_DIR . 'index.php'):
    \Alexkova\Bxready2\Area::showArea('main_page_footer', $bxready2::getAreaByCode('main_page_footer'));
    include $_SERVER["DOCUMENT_ROOT"] . "/include/vp.php";
endif;

if ($APPLICATION->GetDirProperty("isCatalog") != "Y") { ?>
    </div><?php 
} 

if ($bxmarket->getCoreData("right_column") != "N"): ?>
    <div class="bxr-right-panel-xl" data-sticky-style="" data-scroll-style="" data-scroll-wrapper="" data-scroll-content="">
        <div class="bxr-right-panel-xl-first">
            <div class="bxr-right-panel-xl-second">
                <div class="bxr-right-panel-xl-third">
                    <?php \Alexkova\Bxready2\Area::showArea('right_panel', $bxready2::getAreaByCode('right_panel')); ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

        </div>
    </div>
</div>

<div class="bxr-full-width">
    <div class="container bxr-bg-container xl">
        <div class="row">
            <div class="col-xs-12">
                <?php if (\Bitrix\Main\Loader::includeModule('alexkova.bxready2')) {
                    $APPLICATION->IncludeComponent(
                        "bxready2:abmanager",
                        'full-responsive',
                        array(
                            "SHOW" => "BXR_BOTTOM",
                            "BANTYPE" => "BXR_BOTTOM",
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
                            "HIDE_ICONS" => "N"
                        )
                    );
                } ?>
            </div>
        </div>
    </div>
</div>

<script>
    if (typeof category_btn === 'function') {
        category_btn();
    }
</script>

<footer class="bxr-full-width">

    <?php \Alexkova\Bxready2\Area::showArea('footer', $bxready2::getAreaByCode('footer')); ?>

</footer>

<!--noindex-->

	<?$APPLICATION->IncludeComponent(
		"bxready.market2:main.include",
		"named_area",
		Array(
			"AREA_FILE_SHOW" => "file",
			"AREA_FILE_SUFFIX" => "inc",
			"EDIT_TEMPLATE" => "",
			"PATH" => SITE_DIR."include/footer_modal-info.php"
		),
		false
	);?>

	<?$APPLICATION->IncludeComponent(
		"bxready.market2:main.include",
		"named_area",
		Array(
			"AREA_FILE_SHOW" => "file",
			"AREA_FILE_SUFFIX" => "inc",
			"EDIT_TEMPLATE" => "",
			"PATH" => SITE_DIR."include/footer_tg-widget.php"
		),
		false
	);?>

	<?php
	$formParams = include $_SERVER['DOCUMENT_ROOT'] . '/include/forms/params.php';	
	
	Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("iblock_form_question");
	$APPLICATION->IncludeComponent(
		"bxready.market2:form.iblock",
		$formParams['PHONE_POPUP']['COMPONENT_TEMPLATE'],
		$formParams['PHONE_POPUP'],
		false
	);
	Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("iblock_form_question", ""); 
	
	Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("iblock_form_phone"); 
	$APPLICATION->IncludeComponent(
		"bxready.market2:form.iblock",
		$formParams['FEEDBACK_POPUP']['COMPONENT_TEMPLATE'],
		$formParams['FEEDBACK_POPUP'],
		false
	);
	Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("iblock_form_phone", ""); 
	
	Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("iblock_form_project"); 
	$APPLICATION->IncludeComponent(
		"bxready.market2:form.iblock",
		$formParams['PROJECT_POPUP']['COMPONENT_TEMPLATE'],
		$formParams['PROJECT_POPUP'],
		false
	);
	Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("iblock_form_project", ""); 
	
	Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("iblock_form_oneclick"); 
	$APPLICATION->IncludeComponent(
		"bxready.market2:form.iblock",
		$formParams['1CLICK_POPUP']['COMPONENT_TEMPLATE'],
		$formParams['1CLICK_POPUP'],
		false
	);
	Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("iblock_form_oneclick", ""); 
	
	Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("iblock_form_one_click_buy"); 
	$APPLICATION->IncludeComponent(
		"bxready.market2:form.iblock",
		$formParams['REQUEST_PRODUCT']['COMPONENT_TEMPLATE'],
		$formParams['REQUEST_PRODUCT'],
		false
	);
	Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("iblock_form_one_click_buy", ""); 
	
	Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("iblock_form_tender"); 
	$APPLICATION->IncludeComponent(
		"bxready.market2:form.iblock",
		$formParams['TENDER_POPUP']['COMPONENT_TEMPLATE'],
		$formParams['TENDER_POPUP'],
		false
	);
	Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("iblock_form_tender", ""); 
	
	Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("iblock_form_partnership"); 
	$APPLICATION->IncludeComponent(
		"bxready.market2:form.iblock",
		$formParams['PARTNERSHIP_POPUP']['COMPONENT_TEMPLATE'],
		$formParams['PARTNERSHIP_POPUP'],
		false
	);
	Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("iblock_form_partnership", ""); 

	$OneClickOrderFrame = new \Bitrix\Main\Page\FrameHelper("one_click_order");
	$OneClickOrderFrame->begin(); 
	$bxr_one_click_order_basket = COption::GetOptionString('alexkova.market2', "bxr_one_click_order_basket", "N");
	if ($bxr_one_click_order_basket == "Y") { 
		$APPLICATION->IncludeComponent(
			"bxready.market2:one.click.order.basket",
			".default",
			array(
				"COMPONENT_TEMPLATE" => ".default",
				"LIST_PROPERTY_CODE" => array(
					0 => "NAME",
					1 => "EMAIL",
				),
				"FORM_TITLE" => GetMessage("BXR_ONE_CLICK_BUY_TITLE"),
				"BXR_FORM_SUBMIT_CAPTION" => GetMessage("BXR_FORM_SUBMIT_CAPTION"),
				"PERSONAL_DATA" => "Y",
				"PERSONAL_DATA_TEXT" => GetMessage("PERSONAL_DATA_TEXT"),
				"PERSONAL_DATA_CAPTION" => GetMessage("PERSONAL_DATA_CAPTION"),
				"PERSONAL_DATA_URL" => "/privacy-policy/",
				"PERSONAL_DATA_ERROR" => GetMessage("PERSONAL_DATA_ERROR"),
				"BXR_FORM_REQUIRED_PROPS" => array(
					0 => "USER_NAME",
					1 => "USER_PHONE",
					2 => "USER_EMAIL",
				)
			),
			false
		); 
	} 
	$OneClickOrderFrame->end(); 

	Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("iblock_form_check_exist"); 
	$APPLICATION->IncludeComponent(
		"bxready.market2:form.iblock",
		$formParams['CHECK_EXIST']['COMPONENT_TEMPLATE'],
		$formParams['CHECK_EXIST'],
		false
	);
	Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("iblock_form_check_exist", ""); 
	
	Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("iblock_form_check_price"); 
	$APPLICATION->IncludeComponent(
		"bxready.market2:form.iblock",
		$formParams['CHECK_PRICE']['COMPONENT_TEMPLATE'],
		$formParams['CHECK_PRICE'],
		false
	);
	Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("iblock_form_check_price", ""); 
	
	Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("iblock_form_prodconsult"); 
	$APPLICATION->IncludeComponent(
		"bxready.market2:form.iblock",
		$formParams['CONSULT_POPUP']['COMPONENT_TEMPLATE'],
		$formParams['CONSULT_POPUP'],
		false
	);
	Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("iblock_form_prodconsult", ""); 		
	
	Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("iblock_form_service"); 
	$APPLICATION->IncludeComponent(
		"bxready.market2:form.iblock",
		$formParams['SERVICE_POPUP']['COMPONENT_TEMPLATE'],
		$formParams['SERVICE_POPUP'],
		false
	);
	Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("iblock_form_service", ""); 			

	$APPLICATION->IncludeComponent(
		"bxready.market2:buttonUp",
		".default",
		array(
			"BUTTON_UP_HORIZONTALLY_INDENT" => "10",
			"BUTTON_UP_SPEED" => "150",
			"BUTTON_UP_TOP_SHOW" => "150",
			"BUTTON_UP_VERTICAL_INDENT" => "10",
			"LOCATION_HORIZONTALLY" => "rigth",
			"COMPONENT_TEMPLATE" => ".default"
		),
		false
	); ?>

	<div class="modal-backdrop in"></div>

	<?$APPLICATION->IncludeComponent(
		"bxready.market2:main.include",
		"named_area",
		Array(
			"AREA_FILE_SHOW" => "file",
			"AREA_FILE_SUFFIX" => "inc",
			"EDIT_TEMPLATE" => "",
			"PATH" => SITE_DIR."include/footer_cookie.php"
		),
		false
	);?>
	
<!--/noindex-->

<?$APPLICATION->IncludeComponent(
	"bxready.market2:main.include",
	"named_area",
	Array(
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_SUFFIX" => "inc",
		"EDIT_TEMPLATE" => "",
		"PATH" => SITE_DIR."include/footer_counters.php"
	),
	false
);?>

</body>

</html>
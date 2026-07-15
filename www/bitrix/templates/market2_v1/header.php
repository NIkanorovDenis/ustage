<?IncludeTemplateLangFile(__FILE__);?><?

if (!CModule::IncludeModule('alexkova.market2')) return;
if (!CModule::IncludeModule('alexkova.bxready2')) return;

global $BXRGeneral;

$bxmarket = \Alexkova\Market2\Bxmarket::getInstance();
$bxmarket->setCoreData(array(
	'lg_breakpoint' => 1919,
	'md_breakpoint' => 1199,
	'sm_breakpoint' => 991,
	'xs_breakpoint' => 761,
	'left_column' => (strlen($APPLICATION->GetDirProperty("BxrLeftColumn"))>0) ? $APPLICATION->GetDirProperty("BxrLeftColumn") : "N",
        'left_menu' => (strlen($APPLICATION->GetDirProperty("BxrLeftMenu"))>0) ? $APPLICATION->GetDirProperty("BxrLeftMenu") : "Y",
        'isCatalog' => (strlen($APPLICATION->GetDirProperty("isCatalog"))>0) ? $APPLICATION->GetDirProperty("isCatalog") : "N",
        'right_column' => (strlen($APPLICATION->GetDirProperty("BxrRightColumn"))>0) ? $APPLICATION->GetDirProperty("BxrRightColumn") : "N",
        'xl_mode' => ( strlen($APPLICATION->GetDirProperty("BxrXlMode"))>0 && $APPLICATION->GetDirProperty("BxrXlMode")=="Y" ) ? true : false,
));

$bxmarket->setCoreData(array(
        'xl_class' => ($bxmarket->getCoreData("xl_mode")) ? "xl" : "",
));
    
$arDefaultArea = array(
    'header' => 'v1',
    'top_panel' => 'v1',
    'right_panel' => 'v1',
    'mobile_menu' => 'mobile_menu_v1',
    'footer' => 'v1',
    'top_fixed_panel' => 'v1',
    'promo_area' => 'v1',
    'main_page' => 'v1',
    'main_page_footer' => 'v1',
);

$bxready2 = \Alexkova\Bxready2\Bxready::getInstance();
$bxready2::setArea($arDefaultArea);

$bodyClass = (isset($_GET['bitrix_include_areas']) &&  strtoupper($_GET['bitrix_include_areas'])=='Y') ? "bx_inc_areas" : ""; 
$atsClass =  (isset($_COOKIE['ats']) and $_COOKIE['ats'] === 'true') ? 'ats-body' : '';

$dynamicAreaReg = new \Bitrix\Main\Page\FrameStatic("region_controller");
$dynamicAreaReg->setAnimation(false);
$dynamicAreaReg->setStub("");
$dynamicAreaReg->setContainerID(false);
$dynamicAreaReg->startDynamicArea();
    $APPLICATION->IncludeComponent(
            "bxready.market2:region.controller", 
            ".default", 
            array(
                    "COMPONENT_TEMPLATE" => ".default",
                    "IBLOCK_TYPE" => "additional",
                    "IBLOCK_ID" => "11",
                    "REGION_PROPERTIES" => array(
                            0 => "BXR_PRED_NAME",
                            1 => "DEFAULT_REGION",
                            2 => "BXR_SHOW_FORM",
                            3 => "BXR_GEOIP_REGION",
                            4 => "BXR_GEOIP_DISTRICT",
                            5 => "BXR_GEOIP_CITY",
                            6 => "BXR_YANDEX_REGION",
                            7 => "BXR_GROUP_USER",
                            8 => "BXR_STORE",
                            9 => "BXR_LOCATION",
                    ),
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "36000000"
            ),
            false,
            array("HIDE_ICONS"=>"Y")
    );
$dynamicAreaReg->finishDynamicArea();
?>
<!DOCTYPE html>
<html itemscope itemtype="http://schema.org/WebPage" xml:lang="<?=LANGUAGE_ID?>" lang="<?=LANGUAGE_ID?>">
<head>
    <title><?$APPLICATION->ShowTitle();?></title>
    <link rel="icon" href="https://ustage-group.ru/favicon.ico" type="image/x-icon">
    <link rel="icon" href="https://ustage-group.ru/favicon.svg" type="image/svg+xml"  >
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.2">
    <?$APPLICATION->ShowMeta("robots")?>

	<?$APPLICATION->ShowMeta("description");?>
	<?$APPLICATION->ShowCSS()?>
	<?$APPLICATION->ShowHeadStrings()?>
	<?$APPLICATION->ShowHeadScripts()?>

    <?$APPLICATION->AddHeadScript('/bitrix/js/alexkova.bxready2/jquery-2.1.4.js');?>
    <?$APPLICATION->AddHeadScript('/bitrix/js/alexkova.bxready2/jquery.lazyload.js');?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/script.js');?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/goals.js');?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/rpanel.js');?>
    <?$APPLICATION->SetAdditionalCSS("/bitrix/css/main/bootstrap.css");?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/library/bootstrap/js/bootstrap.min.js');?>
    <?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/library/bootstrap/css/grid10_column.css', true);?>
    <?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/font-awesome.min.css");?>
    <?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/rpanel_style.css");?>
    <?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/library/less/less.css", true);?>    
 
    <?if($bxmarket->getCoreData("xl_mode"))
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/bootstrap_expansion.css");
    ?>
    <?$APPLICATION->AddHeadScript('/bitrix/js/alexkova.bxready2/scrollbar/jquery.scrollbar.js');?>
    <?$APPLICATION->SetAdditionalCSS("/bitrix/js/alexkova.bxready2/scrollbar/jquery.scrollbar.css");?>
    <?$APPLICATION->AddHeadScript('/bitrix/js/alexkova.bxready2/detectmobilebrowser.js');?>
    <?$APPLICATION->AddHeadScript('/bitrix/templates/market2_v1/js/jquery.maskedinput.js');?>

    <?$APPLICATION->IncludeComponent(
        "bxready.market2:main.include",
        "named_area",
        Array(
            "AREA_FILE_SHOW" => "file",
            "AREA_FILE_SUFFIX" => "inc",
            "EDIT_TEMPLATE" => "",
            "PATH" => SITE_DIR."include/schema_og.php"
        ),
        false
    );?>

	<meta property="og:image" content="<? $APPLICATION->ShowProperty("og:image", 'https://ustage-group.ru/logo.svg') ?>" />
	<meta property="og:title" content="<?$APPLICATION->ShowTitle()?>">
	<meta property="og:url" content="https://ustage-group.ru<?= $_SERVER['REQUEST_URI']; ?>">
	<meta property="og:type" content="website">

</head>
<body class="<?=$bodyClass;?> <?=$atsClass?>" data-uri="<?= $_SERVER['REQUEST_URI'] ?>">
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5W5DNWW4" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
    
    <? /*
    <script type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src="https://vk.com/js/api/openapi.js?166",t.onload=function(){VK.Retargeting.Init("VK-RTRG-451470-dYwKx"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-451470-dYwKx" style="position:fixed; left:-999px;" alt=""/></noscript> */ ?>

    <div id="panel"><?$APPLICATION->ShowPanel();?></div>

    <script type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src='https://vk.com/js/api/openapi.js?169',t.onload=function(){VK.Retargeting.Init("VK-RTRG-1344447-2eNnx"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-1344447-2eNnx" style="position:fixed; left:-999px;" alt=""/></noscript>

    <?$APPLICATION->IncludeComponent(
        "bxready.market2:main.include",
        "named_area",
        Array(
            "AREA_FILE_SHOW" => "file",
            "AREA_FILE_SUFFIX" => "inc",
            "EDIT_TEMPLATE" => "",
            "PATH" => SITE_DIR."include/schema.php"
        ),
        false
    );?>
    <?$bxmarket->setJsCoreData();?>
    
    <div class="bxr-full-width">
        <div class="container bxr-bg-container xl">
            <div class="row"><div class="col-xs-12">
			
			<? if (\Bitrix\Main\Loader::includeModule('alexkova.bxready2')){
				$APPLICATION->IncludeComponent(
					"bxready2:abmanager", 
					"full-static", 
					array(
							"SHOW" => "BXR_TOP",
							"BANTYPE" => "BXR_TOP",
							"CACHE_TYPE" => "A",
							"CACHE_TIME" => "0",
							"USE_IN_LG_MODE" => "Y",
							"USE_IN_MD_MODE" => "Y",
							"USE_IN_SM_MODE" => "N",
							"USE_IN_XS_MODE" => "N",
							"COMPONENT_TEMPLATE" => "full-static"
					),
					false,
					array(
							"ACTIVE_COMPONENT" => "Y",
							"HIDE_ICONS" => "N"
					)
				);
			}; ?>
            </div></div>
        </div>
    </div>

    <div class="sticky-mobile-header hidden-md hidden-lg container bxr-bg-container <?=$bxmarket->getCoreData("xl_class");?>">        
        <div class="row">
            <div class="col-xs-12">
                <? \Alexkova\Bxready2\Area::showArea('mobile_menu', $bxready2::getAreaByCode('mobile_menu'));?>
            </div>
        </div>
    </div>

    <header class="bxr-full-width header">

        <?\Alexkova\Bxready2\Area::showArea('header', $bxready2::getAreaByCode('header'));?>      

        <?$APPLICATION->IncludeComponent(
            "bxready.market2:panel.top.fixed.ajax", 
            ".default", 
            array(
                "COMPONENT_TEMPLATE" => ".default",
                "USE_FIXED_PANEL" => "N",
                "MAX_WIDTH" => "900",
                "FIXED_PANEL_CODE" => "top_fixed_panel",
                "FIXED_PANEL_DEFAULT_VARIANT" => "v1",
                "USE_FEXT_FILES" => "Y",
                "SHOW_DIRECTLY_IN_EDIT_MODE" => "Y"
            ),
            false,
            array(
                "ACTIVE_COMPONENT" => "Y"
            )
        );?>
    </header>

    <div class="bxr-full-width bxr-work-area-container start-body-container">
        <div class="container bxr-bg-container <?=$bxmarket->getCoreData("xl_class");?>"> 
            <div class="row bxr-page-content" id="bxr-page-content">
                
				<?if($bxmarket->getCoreData("isCatalog")=="Y"):?>
                    
					<?if($bxmarket->getCoreData("right_column")=="Y"):?>
                        <div class="bxr-b20 col-xl-<?=($bxmarket->getCoreData("xl_mode"))?10:12?> col-xs-12">
                    <?else:?>
                        <div class="bxr-b20 col-xs-12">
                    <?endif;?>
					
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
                        }?>
                    </div>
					
                <?else:?>
				
                    <?if($bxmarket->getCoreData("left_column") == "Y"):?>
                        <div class="col-xl-<?=($bxmarket->getCoreData("xl_mode"))?2:3?> col-md-3 col-xs-12 hidden-sm hidden-xs">
                            <?if($bxmarket->getCoreData("left_menu") == "Y"):?>
								<?$APPLICATION->IncludeComponent(
									"bxready.market2:main.include", 
									"named_area1", 
									array(
										"AREA_FILE_SHOW" => "file",
										"AREA_FILE_SUFFIX" => "inc",
										"EDIT_TEMPLATE" => "",
										"PATH" => SITE_DIR."include/left_menu.php",
										"COMPONENT_TEMPLATE" => "named_area1",
										"INCLUDE_PTITLE" => ""
									),
									false
								);?>
                            <?endif;?>

                            <?$APPLICATION->IncludeComponent(
                                "bxready.market2:main.include", 
                                "named_area", 
                                array(
                                        "AREA_FILE_SHOW" => "sect",
                                        "AREA_FILE_SUFFIX" => "left_column",
                                        "EDIT_TEMPLATE" => "",
                                        "COMPONENT_TEMPLATE" => "named_area",
                                        "INCLUDE_PTITLE" => GetMessage("LEFT_COL"),
                                        "AREA_FILE_RECURSIVE" => "Y"
                                ),
                                false
                            );?>
                        </div>
                    <?endif;?>
					
					<?if(($bxmarket->getCoreData("left_column") == "N" || $bxmarket->getCoreData("left_column") == "F")  && ($bxmarket->getCoreData("right_column") == "N" || $bxmarket->getCoreData("right_column") == "T" )):?>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<?endif;?>
							
					<?if(($bxmarket->getCoreData("left_column") == "Y")  && ($bxmarket->getCoreData("right_column") == "N" || $bxmarket->getCoreData("right_column") == "T" )):?>
						<div class="col-xl-<?=($bxmarket->getCoreData("xl_mode"))?10:9?> col-lg-9 col-md-9 col-sm-12 col-xs-12">
					<?endif;?>
							
					<?if($bxmarket->getCoreData("left_column") == "Y"  && $bxmarket->getCoreData("right_column") == "Y" ):?>
						<div class="col-xl-<?=($bxmarket->getCoreData("xl_mode"))?8:9?> col-lg-9 col-md-9 col-sm-12 col-xs-12">
					<?endif;?>
							
					<?if(($bxmarket->getCoreData("left_column") == "N" || $bxmarket->getCoreData("left_column") == "F")  && ($bxmarket->getCoreData("right_column") == "Y" )):?>
						<div class="col-xl-<?=($bxmarket->getCoreData("xl_mode"))?10:12?> col-xs-12">
					<?endif;?>

					<?if ($APPLICATION->GetCurPage(true) != SITE_DIR.'index.php'):?>
						<div class="bxr-cloud-all bxr-cloud-padding bxr-b20">
							<?$APPLICATION->IncludeComponent(
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
							?>
						</div>
					<?endif;?>
					
					<?if ($APPLICATION->GetCurPage(true) == SITE_DIR.'index.php'):?>
					
						<?$APPLICATION->IncludeComponent(
							"bxready.market2:main.include",
							"named_area",
							Array(
								"AREA_FILE_SHOW" => "file",
								"AREA_FILE_SUFFIX" => "inc",
								"EDIT_TEMPLATE" => "",
								"PATH" => SITE_DIR."include/header_blackday.php"
							),
							false
						);?>

						<?\Alexkova\Bxready2\Area::showArea('promo_area', $bxready2::getAreaByCode('promo_area'));?>
						
					<?endif;?>
													
					<?if ($APPLICATION->GetCurPage(true) == SITE_DIR.'index.php'):?>
						<?\Alexkova\Bxready2\Area::showArea('main_page', $bxready2::getAreaByCode('main_page'));?>
					<?endif;?>

					<?/* if ($APPLICATION->GetCurDir() != "/" && !CSite::InDir("/catalog/")):?>
						<a href="/services/servisnoe-obslyzhivanie/"><img class="service-banner" src="/images/services.jpeg" border="0"/></a>
					<?endif; */?>
					
					<div class="bxr-template-container bxr-cloud-all bxr-cloud-padding bxr-b20">
						<?if ($APPLICATION->GetCurPage(true) != SITE_DIR.'index.php'):?>
							<?if (\Bitrix\Main\Loader::includeModule('alexkova.bxready2')){
								$APPLICATION->IncludeComponent("bxready2:abmanager", 'full-responsive', array(
												"SHOW" => "BXR_CATALOG_TOP",
												"BANTYPE" => "BXR_CATALOG_TOP",
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
												"HIDE_ICONS"=>"N"
										)
								);
							};?>
						<?endif;?>
						
                    <h1 class="bxr-h1"><?$APPLICATION->ShowTitle(false)?></h1>
					
                <?endif;?>

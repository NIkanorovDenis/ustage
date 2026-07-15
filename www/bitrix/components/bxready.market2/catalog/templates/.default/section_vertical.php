<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;
?>
<div class="row">
<?if ($isFilter || $isSidebar): ?>
    <?
        $cl = " col-xl-2 col-lg-3 col-md-12 col-sm-12 col-xs-12" ;
        
        if(isset($arParams['FILTER_HIDE_ON_MOBILE']) && $arParams['FILTER_HIDE_ON_MOBILE'] === 'Y')
            $cl .=  ' hidden-xs ';
        
        if($bxmarket->getCoreData("right_column")=="Y")
            $cl .= " bxr-col-20 ";

    ?>
    <div class="<?=$cl;?>">
        <div class="bx-sidebar-block">
			<?if (is_array($arCurSection['SEO_DATA']) && $arCurSection['SEO_DATA']["DEST"] == 'C' && $arCurSection['SEO_DATA']["EXT_PARAMS"]['filter_type'] != 'parent') {
				$isFilter = false;
				//$isSeoFilter = true;
			}?>
            <? if ($isFilter && $showElementsFilters): ?>
            <div class="bxr-b20 bxr-cloud-all">
                <?
                $elementarArea = \Alexkova\Bxready2\Elementars::getArea('catalog','smart.filter.vertical');
                if (strlen($elementarArea) > 0)
                    include($elementarArea);
                else
                    include('include/elementars/smart.filter.vertical.php');
                ?>
            </div>
            <?endif;?>
            <?if ($arParams['LEFTMENU_INDEX_SHOW']=="Y"):
                include_once($_SERVER["DOCUMENT_ROOT"]."/".$this->GetFolder()."/top_left_menu.php");                
            endif;?>            
        </div>
        <?
        /*bestsallers*/
        if (Loader::includeModule("sale"))
	{
            $arRecomData = array();
            $recomCacheID = array('IBLOCK_ID' => $arParams['IBLOCK_ID']);
            $obCache = new CPHPCache();
            if ($obCache->InitCache(36000, serialize($recomCacheID), "/sale/bestsellers"))
            {
                $arRecomData = $obCache->GetVars();
            }
            elseif ($obCache->StartDataCache())
            {
                if (Loader::includeModule("catalog"))
                {
                    $arSKU = CCatalogSKU::GetInfoByProductIBlock($arParams['IBLOCK_ID']);
                    $arRecomData['OFFER_IBLOCK_ID'] = (!empty($arSKU) ? $arSKU['IBLOCK_ID'] : 0);
                }
                $obCache->EndDataCache($arRecomData);
            }
        };
    
        /*viewed products*/
        if (Loader::includeModule("catalog")) {
            $basketUserId = (int)CSaleBasket::GetBasketUserID(true);
            $siteId = Bitrix\Main\Application::getInstance()->getContext()->getSite();
            $viewedIterator = Bitrix\Catalog\CatalogViewedProductTable::GetList(array(
                'select' => array('PRODUCT_ID', 'ELEMENT_ID'),
                'filter' => array('FUSER_ID' => $basketUserId, 'SITE_ID' => $siteId, '!PRODUCT_ID' => $GLOBALS["CURRENT_ELEMENT_ID"]),
                'order' => array('DATE_VISIT' => 'DESC'),
                'limit' => $arParams["VIEWED_PRODUCTS_CNT"],
            ));
            
            $viewedProductIds = array();
            while ($viewedProduct = $viewedIterator->fetch())
                $viewedProductIds[] = $viewedProduct["PRODUCT_ID"];    
        };
    
        $blockSort = array(
            $arParams["VIEWED_PRODUCTS_SORT"] => "viewed",
            $arParams["BESTSALLERS_SORT"] => "bestsaller",
        );
        ksort($blockSort);
        
        foreach ($blockSort as $sortBlock => $blockType) {
            if ($blockType == "viewed") {
                if($viewedProductIds && (!isset($arParams['VIEWED_PRODUCTS_SHOW']) || $arParams['VIEWED_PRODUCTS_SHOW'] != 'N') 
                    && $arParams["VIEWED_PRODUCTS_WERE_SHOW"] == "left" && ModuleManager::isModuleInstalled("catalog")):
                    global $viewedFilter;
                    $viewedFilter = array(
                        "ID" => $viewedProductIds
                    );                    
                    global $viewedGrid;
                    $viewedGrid = 'col';
                    ?><div class="row">
                        <div class="col-xs-12 hidden-xs">
                            <?$elementarArea = \Alexkova\Bxready2\Elementars::getArea('catalog','viewed.products');
                            if (strlen($elementarArea) > 0)
                                include($elementarArea);
                            else
                                include('include/elementars/viewed.products.php');
                        ?></div>
                    </div><?
                endif;
            } elseif ($blockType == "bestsaller") {
                if (!empty($arRecomData)) {
                    if ((!isset($arParams['USE_SALE_BESTSELLERS']) || $arParams['USE_SALE_BESTSELLERS'] != 'N') 
                            && $arParams['BESTSALLERS_WERE_SHOW'] == "left" && ModuleManager::isModuleInstalled("sale")) {
                        global $bestsallersGrid;
                        $bestsallersGrid = 'col';
                        ?><div class="row">
                            <div class="col-xs-12 hidden-xs">
                                <?$elementarArea = \Alexkova\Bxready2\Elementars::getArea('catalog','bestsallers.products');
                                if (strlen($elementarArea) > 0)
                                    include($elementarArea);
                                else
                                    include('include/elementars/bestsallers.products.php');
                            ?></div>
                        </div><?
                    }
                }
            }
        }
    
	if ($isAdditionalSideBar):
            $APPLICATION->IncludeComponent(
                "bxready.market2:main.include",
                "",
                Array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => $arParams["SIDEBAR_PATH"],
                    "AREA_FILE_RECURSIVE" => "N",
                    "EDIT_MODE" => "html",
                ),
                false,
                Array('HIDE_ICONS' => 'Y')
            );
	else:
		$APPLICATION->IncludeComponent(
			"bxready.market2:main.include",
			"named_area",
			array(
				"AREA_FILE_SHOW" => "sect",
				"AREA_FILE_SUFFIX" => "left_column",
				"EDIT_TEMPLATE" => "",
				"COMPONENT_TEMPLATE" => "named_area",
				"AREA_FILE_RECURSIVE" => "Y"
			),
			false
		);
	endif?>        
    </div>
<?endif?>
<?
    $bxmarket = \Alexkova\Market2\Bxmarket::getInstance();

    $cl = " col-xs-12 ";
    
    if($isFilter || $isSidebar)
        $cl .= " col-xl-10 col-lg-9 col-md-12 col-sm-12 ";
    
    if($bxmarket->getCoreData("right_column")=="Y")
        $cl .= " bxr-col-80 ";
?>
<div class="<?=$cl;?>">

    <div class="row bxr-list">
        <div class="col-xs-12 bxr-container-catalog-section">
            <div class="bxr-cloud-all bxr-cloud-padding">
				<?
				if (\Bitrix\Main\Loader::includeModule('alexkova.bxready2')){
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

				};
				?>

                <h1><?$APPLICATION->ShowTitle(false)?></h1>
                <?
                if(!empty($arRecomData) && $arParams['USE_GIFTS_SECTION'] === 'Y' && $arParams['GIFTS_PLACE'] === 'TOP' && false)
                {
                    $elementarArea = \Alexkova\Bxready2\Elementars::getArea('catalog','gift.section');
                    if (strlen($elementarArea) > 0)
                        include($elementarArea);
                    else
                        include('include/elementars/gift.section.php');
                }

                $intSectionID = 0;
                $arDesc = explode("#STEXT#", $arCurSection["DESCRIPTION"]);
                $sectionDesc = $arDesc[0];
                $showSeo = ($arParams["SHOW_SECTION_SEO"] == "Y") ? true : false;
                $seoText = $arDesc[1];

                if ($sectionDesc && $arParams["SHOW_SECTION_DESC"] == "top" && (!isset($_GET['PAGEN_1']) || intval($_GET['PAGEN_1']) <= 1)):
                    $elementarArea = \Alexkova\Bxready2\Elementars::getArea('catalog','section.desc');
                    if (strlen($elementarArea) > 0) {
                        include($elementarArea);
                    } else {
                        include('include/elementars/section.desc.php');
                    }
                endif;

                $elementarArea = \Alexkova\Bxready2\Elementars::getArea('catalog','section.list');
                if (strlen($elementarArea) > 0)
                    include($elementarArea);
                else
                    include('include/elementars/section.list.php');

                if($showElementsFilters):
                    $elementarArea = \Alexkova\Bxready2\Elementars::getArea('catalog','sort.panel');
                    if (strlen($elementarArea) > 0)
                        include($elementarArea);
                    else
                        include('include/elementars/sort.panel.php');                    
                endif;

                if (isset($_SESSION["USER_SORTPANEL"]) && is_array($_SESSION["USER_SORTPANEL"]))
                {
                    foreach ($_SESSION["USER_SORTPANEL"] as $cell=>$val)
                    {
                        $_REQUEST[$cell] = $val;
                    }
                }
                
                $elementarArea = \Alexkova\Bxready2\Elementars::getArea('catalog','section');
                if (strlen($elementarArea) > 0)
                    include($elementarArea);
                else
                    include('include/elementars/section.php');
                ?>

                <?
                if(!empty($arRecomData) && $arParams['USE_GIFTS_SECTION'] === 'Y' && $arParams['GIFTS_PLACE'] === 'BOTTOM' && false)
                {
                    $elementarArea = \Alexkova\Bxready2\Elementars::getArea('catalog','gift.section');
                    if (strlen($elementarArea) > 0)
                        include($elementarArea);
                    else
                        include('include/elementars/gift.section.php');
                }

                $GLOBALS['CATALOG_CURRENT_SECTION_ID'] = $intSectionID;
                unset($basketAction);
                ?>

                <?foreach ($blockSort as $sortBlock => $blockType) {
                    if ($blockType == "viewed") {
                        if($viewedProductIds && (!isset($arParams['VIEWED_PRODUCTS_SHOW']) || $arParams['VIEWED_PRODUCTS_SHOW'] != 'N')
                            && $arParams["VIEWED_PRODUCTS_WERE_SHOW"] == "bottom" && ModuleManager::isModuleInstalled("catalog")):
                            global $viewedFilter;
                            $viewedFilter = array(
                                "ID" => $viewedProductIds
                            );
                            global $viewedGrid;
                            $viewedGrid = 'row';
                            $elementarArea = \Alexkova\Bxready2\Elementars::getArea('catalog','viewed.products');
                            if (strlen($elementarArea) > 0)
                                include($elementarArea);
                            else
                                include('include/elementars/viewed.products.php');
                        endif;
                    } elseif ($blockType == "bestsaller") {
                        if (!empty($arRecomData)) {
                            if ((!isset($arParams['USE_SALE_BESTSELLERS']) || $arParams['USE_SALE_BESTSELLERS'] != 'N')
                                && $arParams['BESTSALLERS_WERE_SHOW'] == "bottom" && ModuleManager::isModuleInstalled("sale")) {
                                 global $bestsallersGrid;
                                $bestsallersGrid = 'row';
                                $elementarArea = \Alexkova\Bxready2\Elementars::getArea('catalog','bestsallers.products');
                                if (strlen($elementarArea) > 0)
                                    include($elementarArea);
                                else
                                    include('include/elementars/bestsallers.products.php');
                            }
                        }
                    }
                }?>  
                <?if ($sectionDesc && $arParams["SHOW_SECTION_DESC"] == "bottom" && (!isset($_GET['PAGEN_1']) || intval($_GET['PAGEN_1']) <= 1)):
                    $elementarArea = \Alexkova\Bxready2\Elementars::getArea('catalog','section.desc');
                    if (strlen($elementarArea) > 0) {
                        include($elementarArea);
                    } else {
                        include('include/elementars/section.desc.php');
                    }
                endif;

                if (strlen($seoText)>0 && $showSeo && (!isset($_GET['PAGEN_1']) || intval($_GET['PAGEN_1']) <= 1)):
                    $elementarArea = \Alexkova\Bxready2\Elementars::getArea('catalog','section.seo');
                    if (strlen($elementarArea) > 0) {
                        include($elementarArea);
                    } else {
                        include('include/elementars/section.seo.php');
                    }
                endif;?>
                <?if (ModuleManager::isModuleInstalled("sale"))
                {
                    if (!empty($arRecomData))
                    {
                        if (!isset($arParams['USE_BIG_DATA']) || $arParams['USE_BIG_DATA'] != 'N')
                        {
                        ?>
                            <div class="row">
                                <div class="col-xs-12">
                                    <?
                                    $elementarArea = \Alexkova\Bxready2\Elementars::getArea('catalog','bigdata.products');
                                    if (strlen($elementarArea) > 0) 
                                        include($elementarArea);
                                    else
                                        include('include/elementars/bigdata.products.php');
                                    ?>
                                </div>
                            </div>
                        <?
                        }
                    }
                }?>

				<?
				if (\Bitrix\Main\Loader::includeModule('alexkova.bxready2')){
					$APPLICATION->IncludeComponent("bxready2:abmanager", 'full-responsive', array(
							"SHOW" => "BXR_CATALOG_BOTTOM",
							"BANTYPE" => "BXR_CATALOG_BOTTOM",
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

				};
				?>

            </div>
        </div>
    </div>
</div></div>
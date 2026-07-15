<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

$this->setFrameMode(true);
$this->addExternalCss("/bitrix/css/main/bootstrap.css");

$module_id = "alexkova.market2";

if(isset($arParams["SEF_MODE"]) && $arParams["SEF_MODE"]=="Y") {
   $APPLICATION->AddChainItem($APPLICATION->GetTitle(), $arParams["SEF_FOLDER"].$arParams["SEF_URL_TEMPLATES"]["sections"]);
}

$arParams['LEFTMENU_DETAIL_SHOW'] = (!isset($arParams['LEFTMENU_DETAIL_SHOW'])) ? "Y" : $arParams['LEFTMENU_DETAIL_SHOW'];
$bxmarket = \Alexkova\Market2\Bxmarket::getInstance();
$bxmarket->setCoreData(array(
    'left_column' => "N",
    'left_menu' => $arParams["LEFTMENU_DETAIL_SHOW"],
));

$managment_element_mode = COption::GetOptionString($module_id, "managment_element_mode", "N");

$bxr_use_links_sku_sef_section = COption::GetOptionString($module_id, "bxr_use_links_sku_sef_section", "");
$offerMask = ($bxr_use_links_sku_sef_section != "") ? $bxr_use_links_sku_sef_section : 'offer';

$bxr_use_links_sku_sef_request = COption::GetOptionString($module_id, "bxr_use_links_sku_sef_request", "");
$offerRequestMask = ($bxr_use_links_sku_sef_request != "") ? $bxr_use_links_sku_sef_request : 'offer_id';

$bxr_use_links_sku_sef = COption::GetOptionString($module_id, "bxr_use_links_sku_sef", "N");
$bxr_use_links_sku_sef_code = COption::GetOptionString($module_id, "bxr_use_links_sku_sef_code", "N");

$arResult["VARIABLES"]["OFFER_ID"] = ($bxr_use_links_sku_sef == "Y") ? $arResult["VARIABLES"]["OFFER_ID"] : intval($_REQUEST[$offerRequestMask]);
$cache_id = SITE_ID."|".$APPLICATION->GetCurPage()."|".intval($arResult["VARIABLES"]["OFFER_ID"])."|".intval($arResult["VARIABLES"]["OFFER_CODE"])."|".$USER->GetGroups();
$obCache = new CPHPCache;
if ($obCache->InitCache($arParams['CACHE_TIME'], $cache_id, '/'))
{
    $vars = $obCache->GetVars(); 
    $offerId = $vars['offerId'];     
} elseif ($obCache->StartDataCache()) { 
    if ($arResult["VARIABLES"]["OFFER_CODE"] && $bxr_use_links_sku_sef_code == "Y" || $arResult["VARIABLES"]["OFFER_ID"]) {
        $offers = CCatalogSKU::GetInfoByProductIBlock($arParams["IBLOCK_ID"]);
        if (!$arResult["VARIABLES"]["ELEMENT_ID"] && $arResult["VARIABLES"]["ELEMENT_CODE"]) {
            $filter = array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"]);
            $select = array("ID");
            $res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $filter, false, false, $select);
            if ($arElem = $res->GetNext())
                $arResult["VARIABLES"]["ELEMENT_ID"] = $arElem["ID"];
        }
        $filter = array("IBLOCK_ID" => $offers["IBLOCK_ID"], "PROPERTY_CML2_LINK" => $arResult["VARIABLES"]["ELEMENT_ID"]);
        if ($bxr_use_links_sku_sef == "Y" && $bxr_use_links_sku_sef_code == "Y")
            $filter["CODE"] = $arResult["VARIABLES"]["OFFER_CODE"];
        else 
            $filter["ID"] = $arResult["VARIABLES"]["OFFER_ID"];
        $select = array("ID");
        $res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $filter, false, false, $select);
        if ($arOffer = $res->GetNext())
            $offerId = $arOffer["ID"];
    }

    $obCache->EndDataCache(array( 
      'offerId' => $offerId, 
    ));
}
/*
$bxr_use_links_sku = COption::GetOptionString($module_id, "bxr_use_links_sku", "N");
if (!$offerId && ($arResult["VARIABLES"]["OFFER_ID"] || $arResult["VARIABLES"]["OFFER_CODE"]) || $bxr_use_links_sku != "Y" && (isset($arResult["VARIABLES"]["OFFER_ID"]) || isset($arResult["VARIABLES"]["OFFER_CODE"]))) {
    $GLOBALS["APPLICATION"]->RestartBuffer();
    include   $_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/'.SITE_TEMPLATE_ID.'/header.php';
    require   ($_SERVER['DOCUMENT_ROOT'].'/404.php');
    die();
}*/

if (isset($arParams['USE_COMMON_SETTINGS_BASKET_POPUP']) && $arParams['USE_COMMON_SETTINGS_BASKET_POPUP'] == 'Y')
    $basketAction = (isset($arParams['COMMON_ADD_TO_BASKET_ACTION']) ? array($arParams['COMMON_ADD_TO_BASKET_ACTION']) : array());
else
    $basketAction = (isset($arParams['DETAIL_ADD_TO_BASKET_ACTION']) ? $arParams['DETAIL_ADD_TO_BASKET_ACTION'] : array());

$isSidebar = ($arParams["SIDEBAR_DETAIL_SHOW"] == "Y" && isset($arParams["SIDEBAR_PATH"]) && !empty($arParams["SIDEBAR_PATH"]));

foreach ($arParams as $cell=>$val){
    if (substr($cell,0,15) == 'BXR_DETAIL_TAB_'){
        $extractTabsParams[$cell] = $val;
    }
}
?>
<?if ((!$isSidebar && ( $arParams['LEFTMENU_DETAIL_SHOW']=="Y" || $arParams['LEFTMENU_DETAIL_SHOW']=="T")) || ($isSidebar && $arParams['LEFTMENU_DETAIL_SHOW']=="T")){
    include_once($_SERVER["DOCUMENT_ROOT"]."/".$this->GetFolder()."/top_left_menu.php");
}?>
<div class="row">
    <div class="col-xl-12 col-xs-12 bxr-container-catalog-element" itemscope="" itemtype="http://schema.org/Product">
        <div class="bxr-cloud-all">
            <h1 itemprop="name"><?$APPLICATION->ShowTitle(false)?></h1>
        <?
		// Include BXREADY elementar area
		$includeAreaName = 'detail';
		include('include_handler.php');

		$content_data = $export_data = array(
			'content_type' => 'catalog_element',
			'content_item' => $ElementID,
			'content_iblock' => $arParams["IBLOCK_ID"],
		);
		$marketRegistry = \Alexkova\Market2\Bxmarket::getInstance();
		$marketRegistry->setContentData($content_data);
		$marketRegistry->setExportData($export_data);
		$marketRegistry->setAjaxContent();

		$contentData = $marketRegistry->getContentData();

		if ($contentData['collection'] != "Y" && Bitrix\Main\Loader::includeModule("alexkova.sets") && $ElementID > 0){

			if ($arParams['BXR_USE_CROSS_SELL'] == "Y") {

				$includeAreaName = 'cross.sell';
				include('include_handler.php');

			}
		}

        ?>

        <?
        if ($ElementID > 0)
        {
            $arRecomData = array();
            $recomCacheID = array('IBLOCK_ID' => $arParams['IBLOCK_ID']);
            $obCache = new CPHPCache();
            if ($obCache->InitCache(36000, serialize($recomCacheID), "/catalog/recommended"))
            {
                $arRecomData = $obCache->GetVars();
            }
            elseif ($obCache->StartDataCache())
            {
                if (\Bitrix\Main\Loader::includeModule("catalog"))
                {
                    $arSKU = CCatalogSKU::GetInfoByProductIBlock($arParams['IBLOCK_ID']);
                    $arRecomData['OFFER_IBLOCK_ID'] = (!empty($arSKU) ? $arSKU['IBLOCK_ID'] : 0);
                    $arRecomData['IBLOCK_LINK'] = '';
                    $arRecomData['ALL_LINK'] = '';
                    $rsProps = CIBlockProperty::GetList(
                        array('SORT' => 'ASC', 'ID' => 'ASC'),
                        array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'PROPERTY_TYPE' => 'E', 'ACTIVE' => 'Y')
                    );
                    $found = false;
                    while ($arProp = $rsProps->Fetch())
                    {
                        if ($found)
                            break;
                        if ($arProp['CODE'] == '')
                            $arProp['CODE'] = $arProp['ID'];
                        $arProp['LINK_IBLOCK_ID'] = intval($arProp['LINK_IBLOCK_ID']);
                        if ($arProp['LINK_IBLOCK_ID'] != 0 && $arProp['LINK_IBLOCK_ID'] != $arParams['IBLOCK_ID'])
                            continue;
                        if ($arProp['LINK_IBLOCK_ID'] > 0)
                        {
                            if ($arRecomData['IBLOCK_LINK'] == '')
                            {
                                $arRecomData['IBLOCK_LINK'] = $arProp['CODE'];
                                $found = true;
                            }
                        }
                        else
                        {
                            if ($arRecomData['ALL_LINK'] == '')
                                $arRecomData['ALL_LINK'] = $arProp['CODE'];
                        }
                    }
                    if ($found)
                    {
                        if(defined("BX_COMP_MANAGED_CACHE"))
                        {
                            global $CACHE_MANAGER;
                            $CACHE_MANAGER->StartTagCache("/catalog/recommended");
                            $CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);
                            $CACHE_MANAGER->EndTagCache();
                        }
                    }
                }
                $obCache->EndDataCache($arRecomData);
            }

            if($arParams["USE_ALSO_BUY"] == "Y" && \Bitrix\Main\ModuleManager::isModuleInstalled("sale") && !empty($arRecomData))
            {?>
                <div class="row">
                    <div class="col-xl-9 col-lg-8 col-md-12 col-sm-12 col-xs-12 bxr-detail-product-list-col">
                        <div class="bxr-detail-col">
                            <?
							$includeAreaName = 'recommended.products';
							include('include_handler.php');
                            ?>
                        </div>
                    </div>
                </div>
            <?}
        }
        ?>



        <?
        if($arParams["USE_BIGDATA_DETAIL"] == "Y"){
            if ($managment_element_mode == "Y") {
                $ownOptElementLib = COption::GetOptionString($module_id, "own_catalog_list_element_type_".SITE_TEMPLATE_ID, "ecommerce.m2.v1");
                if (strlen($ownOptElementLib) > 0) {
                    $elementLibrary = trim($ownOptElementLib);
                } else {
                    $optElementLib = COption::GetOptionString($module_id, "catalog_list_element_type_".SITE_TEMPLATE_ID, "ecommerce.m2.v1");
                    if (strlen($optElementLib) > 0) {
                        $elementLibrary = $optElementLib;
                    } else {
                        $elementLibrary = "ecommerce.m2.v1";
                    }
                }
                $arResponsiveParams["LG"] = COption::GetOptionString($module_id, "catalog_list_element_count_lg_".SITE_TEMPLATE_ID, 4);
                $arResponsiveParams["MD"] = COption::GetOptionString($module_id, "catalog_list_element_count_md_".SITE_TEMPLATE_ID, 6);
                $arResponsiveParams["SM"] = COption::GetOptionString($module_id, "catalog_list_element_count_sm_".SITE_TEMPLATE_ID, 6);
                $arResponsiveParams["XS"] = COption::GetOptionString($module_id, "catalog_list_element_count_xs_".SITE_TEMPLATE_ID, 12);
            } else {
                $elementLibrary = "ecommerce.m2.v1";
                $arResponsiveParams["LG"] = 4;
                $arResponsiveParams["MD"] = 4;
                $arResponsiveParams["SM"] = 6;
                $arResponsiveParams["XS"] = 12;
            }
            global $unicumID;
            if ($unicumID<=0) {$unicumID = 1;} else {$unicumID++;}?>
            <div class="row">
                <div class="col-xl-9 col-lg-8 col-md-12 col-sm-12 col-xs-12 bxr-detail-product-list-col">
                    <div class="bxr-detail-col">
                        <?
						$includeAreaName = 'bigdata.products.detail';
						include('include_handler.php');
                        ?>
                    </div>
                </div>
            </div>
        <?}?>


			<?
			/// Insert Related System

			if (CModule::IncludeModule('alexkova.bxready2') && $ElementID > 0){
				$obCache = new CPHPCache();

				$arCacheArray = $arParams;
				$arCacheArray['ELEMENT_ID'] = $ElementID;
				if ($obCache->InitCache($arParams['CACHE_TIME'], serialize($arCacheArray), "/iblock/related"))
				{
					$arCurRelated = $obCache->GetVars();
				}
				elseif ($obCache->StartDataCache())
				{
					$arCurRelated = array();

					$related = \Alexkova\Bxready2\Related::getRelatedElements($ElementID, \Alexkova\Bxready2\Component::getRelatedIblockList($arParams));

					$sections = $arResult["RELATED_SECTIONS"] = \Alexkova\Bxready2\Component::prepareRelatedParams($arParams, array(
						'sidebar' => 'sidebar',
						//'content' => 'content',
						'bottom' => 'bottom'
					));

					$arCurRelated["SECTIONS"] = $sections;
					$arCurRelated["RELATED"] = $related;

					if(defined("BX_COMP_MANAGED_CACHE"))
					{
						global $CACHE_MANAGER;
						$CACHE_MANAGER->StartTagCache("/iblock/related");

						$CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);

						$CACHE_MANAGER->EndTagCache();
					}

					$obCache->EndDataCache($arCurRelated);
				}



				if (isset($arCurRelated))
				{
					$related = $arCurRelated['RELATED'];
					$sections = $arCurRelated['SECTIONS'];

					if (count($sections['order']['sidebar'])>0):
						foreach ($sections['order']['sidebar'] as $cell=>$val):
							$iblockID = $sections['iblocks'][$cell]['BXR_RELATED_IBLOCK_ID'];

							if ($iblockID>0 && count($related[$iblockID])>0){
								$this->SetViewTarget('sidebar', $val);
								$currentParams = $sections['iblocks'][$cell];
								global $arrRelatedFilter;
								$arrRelatedFilter = array ('ID' => $related[$iblockID]);

								$includeAreaName = 'related.sidebar';
								include('include_handler.php');

								$this->EndViewTarget();

							}
						endforeach;
					endif;

					if (count($sections['order']['bottom'])>0):
						foreach ($sections['order']['bottom'] as $cell=>$val):
							$iblockID = $sections['iblocks'][$cell]['BXR_RELATED_IBLOCK_ID'];

							if ($iblockID>0 && count($related[$iblockID])>0){
								$currentParams = $sections['iblocks'][$cell];
								global $arrRelatedFilter;
								$arrRelatedFilter = array ('ID' => $related[$iblockID]);

								$includeAreaName = 'related';
								include('include_handler.php');
							}
						endforeach;
					endif;

				}
			}
			?>

        </div>
    </div>
</div>


<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc
	, Alexkova\Bxready2\Draw
	, Alexkova\Market2\Bxmarket;
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 */

$this->setFrameMode(true);
$this->addExternalCss('/bitrix/css/main/bootstrap.css');
$coreData = Bxmarket::getInstance()->getCoreData();

$coreData['lg_breakpoint'] = intval($coreData['lg_breakpoint'])>0 ? $coreData['lg_breakpoint'] : 1919;
$coreData['md_breakpoint'] = intval($coreData['md_breakpoint'])>0 ? $coreData['md_breakpoint'] : 1199;
$coreData['sm_breakpoint'] = intval($coreData['sm_breakpoint'])>0 ? $coreData['sm_breakpoint'] : 991;
$coreData['xs_breakpoint'] = intval($coreData['xs_breakpoint'])>0 ? $coreData['xs_breakpoint'] : 761;

if (!empty($arResult['NAV_RESULT']))
{
    $navParams =  array(
        'NavPageCount' => $arResult['NAV_RESULT']->NavPageCount,
        'NavPageNomer' => $arResult['NAV_RESULT']->NavPageNomer,
        'NavNum' => $arResult['NAV_RESULT']->NavNum
    );
}
else
{
    $navParams = array(
        'NavPageCount' => 1,
        'NavPageNomer' => 1,
        'NavNum' => $this->randString()
    );
}

$showTopPager = false;
$showBottomPager = false;
$showLazyLoad = false;
$sliderMode = ($arParams["BXREADY_LIST_SLIDER_LISTPAGE"] == "Y") ? true : false; 

if ($arParams['PAGE_ELEMENT_COUNT'] > 0 && $navParams['NavPageCount'] > 1)
{
    $showTopPager = $arParams['DISPLAY_TOP_PAGER'];
    $showBottomPager = $arParams['DISPLAY_BOTTOM_PAGER'];
    $showLazyLoad = $arParams['LAZY_LOAD'] === 'Y' && $navParams['NavPageNomer'] != $navParams['NavPageCount'] && !$sliderMode;
}

$templateLibrary = array('popup', 'ajax', 'fx');
$currencyList = '';

if (!empty($arResult['CURRENCIES']))
{
    $templateLibrary[] = 'currency';
    $currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
    'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
    'TEMPLATE_LIBRARY' => $templateLibrary,
    'CURRENCIES' => $currencyList
);
unset($currencyList, $templateLibrary);

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
$elementDeleteParams = array('CONFIRM' => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));

$arParams['MESS_BTN_BUY'] = $arParams['MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_BUY');
$arParams['MESS_BTN_DETAIL'] = $arParams['MESS_BTN_DETAIL'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_DETAIL');
$arParams['MESS_BTN_COMPARE'] = $arParams['MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_COMPARE');
$arParams['MESS_BTN_SUBSCRIBE'] = $arParams['MESS_BTN_SUBSCRIBE'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_SUBSCRIBE');
$arParams['MESS_BTN_ADD_TO_BASKET'] = $arParams['MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_ADD_TO_BASKET');
$arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE'] ?: Loc::getMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE');
$arParams['MESS_SHOW_MAX_QUANTITY'] = $arParams['MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCS_CATALOG_SHOW_MAX_QUANTITY');
$arParams['MESS_RELATIVE_QUANTITY_MANY'] = $arParams['MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCS_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['MESS_RELATIVE_QUANTITY_FEW'] = $arParams['MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCS_CATALOG_RELATIVE_QUANTITY_FEW');

global $unicumID;

if ($unicumID<=0) {$unicumID = 1;} else {$unicumID++;}

if (strlen(strval($arParams['UNICUM_POSTFIX']))>0){
	$unicumID = strval($unicumID).strval($arParams['UNICUM_POSTFIX']);
}

$thisUncumId =  ($arParams["THIS_UNIC_ID"]) ?: $unicumID;
$arParams["THIS_UNIC_ID"] = $thisUncumId;

$generalParams = array(
    'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
    'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
    'SHOW_MAX_QUANTITY' => $arParams['BXR_SHOW_MAX_QUANTITY'],
    'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
    'MESS_SHOW_MAX_QUANTITY' => $arParams['MESS_SHOW_MAX_QUANTITY'],
    'MESS_RELATIVE_QUANTITY_MANY' => $arParams['MESS_RELATIVE_QUANTITY_MANY'],
    'MESS_RELATIVE_QUANTITY_FEW' => $arParams['MESS_RELATIVE_QUANTITY_FEW'],
    'QUANTITY_IN_STOCK' => $arParams['QUANTITY_IN_STOCK'],
    'QUANTITY_OUT_STOCK' => $arParams['QUANTITY_OUT_STOCK'],
    'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
    'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
    'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
    'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
    'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
    'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
    'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'],
    'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
    'COMPARE_PATH' => $arParams['COMPARE_PATH'],
    '~ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
    '~BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE'],
    '~COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
    'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
    'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
    'MESS_BTN_COMPARE' => $arParams['MESS_BTN_COMPARE'],
    'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
    'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
    'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],
    'UNICUM_ID' => $thisUncumId,
    'SLIDER_MODE' => $sliderMode,
    'OFFERS_PROPERTY_CODE' => $arParams['OFFERS_PROPERTY_CODE'],
    'BXR_PRESENT_SETTINGS' => $arParams['BXR_LISTPAGE'],
    'BXREADY_USER_TYPES' => $arParams['BXR_LISTPAGE']['BXREADY_USER_TYPES'],
    'BXREADY_USER_TYPE_VARIANT' => $arParams['BXR_LISTPAGE']['BXREADY_USER_TYPE_VARIANT'],
	"BXR_LAZY_LOAD" => $arParams['BXR_LAZY_LOAD']
);

$colToElem = array();
$bootstrapGridCount = $arParams["BXREADY_LIST_BOOTSTRAP_GRID_STYLE"] ?: 12;
if ($bootstrapGridCount>0){
	for($i=1; $i<=$bootstrapGridCount; $i++){
		if (($bootstrapGridCount % $i) == 0){
			$colToElem[$bootstrapGridCount / $i] = $i;
		}
	}
}


/* --- Если выбран фильтр "В наличии" то не выводим лишние товары  --- */

//параметры адресной строки (чтобы проверить фильтр по наличию)
$uri = $_SERVER['REQUEST_URI'];
$params = explode('/', $uri);
$es_exist_is_yes = 0;
foreach ($params AS $param) {
    if ($param == 'es_exist-is-yes') {
        $es_exist_is_yes = 1;
    }
}

/* --- // --- */


//СПИСОК КАТАЛОГА
if (!empty($arResult['ITEMS'])):
    if ($showTopPager && !$sliderMode)
    {?>
        <div class="bxr-top-pager" data-pagination-num="<?=$navParams['NavNum']?>">
            <!-- pagination-container -->
            <?=$arResult['NAV_STRING']?>
            <!-- pagination-container -->
        </div>
    <?
    }

    if ($arParams['HIDE_SECTION_DESCRIPTION'] !== 'Y' && !$sliderMode && $navParams['NavPageNomer'] < 2){
        ?><div class="bx-section-desc">
                <p class="bx-section-desc-post"><?=$arResult['DESCRIPTION']?></p>
        </div><?
    }
    ?>

    <?if ($arParams["PAGE_BLOCK_TITLE"] != "" && !empty($arResult['ITEMS'])) {?>
        <div class="bxr-product-block-title"><?=$arParams["PAGE_BLOCK_TITLE"]?></div>
    <?}?>
    <div class="row" data-entity="container-<?=$navParams['NavNum']?>">
        <?//if (!empty($arResult['ITEMS'])) {?>
        <?$elementDraw = \Alexkova\Bxready2\Draw::getInstance($this);
        $elementDraw->setCurrentTemplate($this);
        $areaIds = array();

        $arParams["BXREADY_LIST_XLG_CNT_LISTPAGE"] = ($arParams["BXREADY_LIST_XLG_CNT_LISTPAGE"]) ? $arParams["BXREADY_LIST_XLG_CNT_LISTPAGE"] : 12;
        $arParams["BXREADY_LIST_LG_CNT_LISTPAGE"] = ($arParams["BXREADY_LIST_LG_CNT_LISTPAGE"]) ? $arParams["BXREADY_LIST_LG_CNT_LISTPAGE"] : 12;
        $arParams["BXREADY_LIST_MD_CNT_LISTPAGE"] = ($arParams["BXREADY_LIST_MD_CNT_LISTPAGE"]) ? $arParams["BXREADY_LIST_MD_CNT_LISTPAGE"] : 12;
        $arParams["BXREADY_LIST_SM_CNT_LISTPAGE"] = ($arParams["BXREADY_LIST_SM_CNT_LISTPAGE"]) ? $arParams["BXREADY_LIST_SM_CNT_LISTPAGE"] : 12;
        $arParams["BXREADY_LIST_XS_CNT_LISTPAGE"] = ($arParams["BXREADY_LIST_XS_CNT_LISTPAGE"]) ? $arParams["BXREADY_LIST_XS_CNT_LISTPAGE"] : 12;
        ?>
        <!-- items-container -->
        <?if ($sliderMode) {?>
            <div id="sl_<?=$thisUncumId?>" class="bxr-slick-section">
        <?}?>
        <?foreach ($arResult['ITEMS'] as $itemKey => $item)
        {

            if (!empty($_GET['test2'])) {
                //echo '<pre>';print_r($item['OFFERS']);echo '</pre>';
                //exit;
                //unset($arResult['ITEMS']['OFFERS'][$itemKey][0]);
                //unset($arResult['ITEMS']['JS_OFFERS'][$itemKey][0]);
                //unset($item['OFFERS'][0]);
                //unset($item['JS_OFFERS'][0]);
            }

            $uniqueId = $item['ID'].'_'.md5($this->randString().$component->getAction());
            $areaIds[$item['ID']] = $this->GetEditAreaId($uniqueId);
            $this->AddEditAction($uniqueId, $item['EDIT_LINK'], $elementEdit);
            $this->AddDeleteAction($uniqueId, $item['DELETE_LINK'], $elementDelete, $elementDeleteParams);
            $generalParams['AREA_IDS'] = $areaIds;

            if ($_REQUEST['action'] == "showMore")
                $generalParams['LAZY_LOAD'] = true;
        ?>
            <div class="t_<?=$thisUncumId?> col-xl-<?=$arParams["BXREADY_LIST_XLG_CNT_LISTPAGE"]?> col-lg-<?=$arParams["BXREADY_LIST_LG_CNT_LISTPAGE"]?> col-md-<?=$arParams["BXREADY_LIST_MD_CNT_LISTPAGE"]?> col-sm-<?=$arParams["BXREADY_LIST_SM_CNT_LISTPAGE"]?> col-xs-<?=$arParams["BXREADY_LIST_XS_CNT_LISTPAGE"]?>" data-entity="items-row">
                <? $elementDraw->showElement("elements", $arParams['BXR_LISTPAGE']["BXREADY_ELEMENT_DRAW"], $item, $generalParams + array('SKU_PROPS' => $arResult['SKU_PROPS'][$item['IBLOCK_ID']]));?>
            </div>
        <?
        }
        unset($generalParams);
        ?>
        <!-- items-container -->
    <?
//    }
    ?>
    </div>
    <?if ($sliderMode) {
        $mainId = $this->GetEditAreaId($navParams['NavNum']);
        $obSlName = 'obSl'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);
    ?>
        </div>
        <script>
            $(document).ready(function() {
                var <?=$obSlName?> = new JCCatalogSectionSlider({
                    uniqId: '<?=$thisUncumId?>',
                    dots: <?=($arParams["BXREADY_LIST_SLIDER_MARKERS_LISTPAGE"] == "Y") ? 'true' : 'false'?>,
                    speed: <?=intval($arParams["BXREADY_LIST_SLIDER_SCROLLSPEED_LISTPAGE"])>0 ? intval($arParams["BXREADY_LIST_SLIDER_SCROLLSPEED_LISTPAGE"]) :  200?>,
                    autoPlay: <?=($arParams["BXREADY_LIST_SLIDER_AUTOSCROLL_LISTPAGE"] == "Y") ? 'true' : 'false'?>,
                    autoPlaySpeed: <?=intval($arParams["BXREADY_LIST_SLIDER_AUTOPLAY_SPEEDD_LISTPAGE"])>0 ? intval($arParams["BXREADY_LIST_SLIDER_AUTOPLAY_SPEEDD_LISTPAGE"]) :  2000?>,
                    verticalMode: <?=($arParams["BXREADY_LIST_VERTICAL_SLIDER_MODE_LISTPAGE"] == "Y") ? 'true' : 'false'?>,
                    hideDesktop: <?=($arParams["BXREADY_LIST_HIDE_SLIDER_ARROWS_LISTPAGE"] == "Y") ? 'true' : 'false'?>,
                    hideMobile: <?=($arParams["BXREADY_LIST_HIDE_MOBILE_SLIDER_ARROWS_LISTPAGE"] == "Y") ? 'true' : 'false'?>,
                    XLG_CNT: <?=$colToElem[$arParams["BXREADY_LIST_XLG_CNT_LISTPAGE"]]?>,
                    LG_CNT: <?=$colToElem[$arParams["BXREADY_LIST_LG_CNT_LISTPAGE"]]?>,
                    MD_CNT: <?=$colToElem[$arParams["BXREADY_LIST_MD_CNT_LISTPAGE"]]?>,
                    SM_CNT: <?=$colToElem[$arParams["BXREADY_LIST_SM_CNT_LISTPAGE"]]?>,
                    XS_CNT: <?=$colToElem[$arParams["BXREADY_LIST_XS_CNT_LISTPAGE"]]?>,
                    LG_BREAKPOINT: <?=$coreData['lg_breakpoint']?>,
                    MD_BREAKPOINT: <?=$coreData['md_breakpoint']?>,
                    SM_BREAKPOINT: <?=$coreData['sm_breakpoint']?>,
                    XS_BREAKPOINT: <?=$coreData['xs_breakpoint']?>
                });
            });
        </script>
    <?}

    if ($showLazyLoad && !$sliderMode)
    {
    ?>
        <div class="row">
            <div class="bxr-color-button bxr-list-show-more<?=($_REQUEST["view"] == "table")?" bxr-t20":""?>"
            data-use="show-more-<?=$navParams['NavNum']?>">
                <?=$arParams['MESS_BTN_LAZY_LOAD']?>
            </div>
        </div>
    <?
    }

    if ($showBottomPager && !$sliderMode)
    {
    ?>
        <div data-pagination-num="<?=$navParams['NavNum']?>">
            <!-- pagination-container -->
            <?=$arResult['NAV_STRING']?>
            <!-- pagination-container -->
        </div>
    <?
    }

    $arResult['ORIGINAL_PARAMETERS']["THIS_UNIC_ID"] = $thisUncumId;
    $signer = new \Bitrix\Main\Security\Sign\Signer;
    $signedTemplate = $signer->sign($templateName, 'catalog.section');
    $signedParams = $signer->sign(base64_encode(serialize($arResult['ORIGINAL_PARAMETERS'])), 'catalog.section');
    $mainId = $this->GetEditAreaId($navParams['NavNum']);
    $obName = 'ob'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);
    ?>
    <script>
        BX.message({
            BTN_MESSAGE_BASKET_REDIRECT: '<?=GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_BASKET_REDIRECT')?>',
            BASKET_URL: '<?=$arParams['BASKET_URL']?>',
            ADD_TO_BASKET_OK: '<?=GetMessageJS('ADD_TO_BASKET_OK')?>',
            TITLE_ERROR: '<?=GetMessageJS('CT_BCS_CATALOG_TITLE_ERROR')?>',
            TITLE_BASKET_PROPS: '<?=GetMessageJS('CT_BCS_CATALOG_TITLE_BASKET_PROPS')?>',
            TITLE_SUCCESSFUL: '<?=GetMessageJS('ADD_TO_BASKET_OK')?>',
            BASKET_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCS_CATALOG_BASKET_UNKNOWN_ERROR')?>',
            BTN_MESSAGE_SEND_PROPS: '<?=GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_SEND_PROPS')?>',
            BTN_MESSAGE_CLOSE: '<?=GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_CLOSE')?>',
            BTN_MESSAGE_CLOSE_POPUP: '<?=GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_CLOSE_POPUP')?>',
            COMPARE_MESSAGE_OK: '<?=GetMessageJS('CT_BCS_CATALOG_MESS_COMPARE_OK')?>',
            COMPARE_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCS_CATALOG_MESS_COMPARE_UNKNOWN_ERROR')?>',
            COMPARE_TITLE: '<?=GetMessageJS('CT_BCS_CATALOG_MESS_COMPARE_TITLE')?>',
            PRICE_TOTAL_PREFIX: '<?=GetMessageJS('CT_BCS_CATALOG_PRICE_TOTAL_PREFIX')?>',
            RELATIVE_QUANTITY_MANY: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_MANY'])?>',
            RELATIVE_QUANTITY_FEW: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_FEW'])?>',
            BTN_MESSAGE_COMPARE_REDIRECT: '<?=GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT')?>',
            BTN_MESSAGE_LAZY_LOAD: '<?=$arParams['MESS_BTN_LAZY_LOAD']?>',
            BTN_MESSAGE_LAZY_LOAD_WAITER: '<?=GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_LAZY_LOAD_WAITER')?>',
            SITE_ID: '<?=SITE_ID?>'
        });
        var <?=$obName?> = new JCCatalogSectionComponent({
            siteId: '<?=CUtil::JSEscape(SITE_ID)?>',
            componentPath: '<?=CUtil::JSEscape($componentPath)?>',
            navParams: <?=CUtil::PhpToJSObject($navParams)?>,
            deferredLoad: false, // enable it for deferred load
            bigData: <?=CUtil::PhpToJSObject($arResult['BIG_DATA'])?>,
            lazyLoad: !!'<?=$showLazyLoad?>',
            loadOnScroll: !!'<?=($arParams['LOAD_ON_SCROLL'] === 'Y')?>',
            template: '<?=CUtil::JSEscape($signedTemplate)?>',
            ajaxId: '<?=CUtil::JSEscape($arParams['AJAX_ID'])?>',
            parameters: '<?=CUtil::JSEscape($signedParams)?>'
        });
    </script>

<? endif;
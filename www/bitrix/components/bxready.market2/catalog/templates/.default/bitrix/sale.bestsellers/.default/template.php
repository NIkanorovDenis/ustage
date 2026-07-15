<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */
$this->setFrameMode(true);
use Alexkova\Bxready2\Draw, Alexkova\Market2\Bxmarket;
if (count($arResult['ITEMS'])>0) {
    $sliderMode = ($arParams['BXR_SALELEADER']["BXREADY_LIST_SLIDER"] == "Y") ? true : false;
    ?><div class="bxr-product-block-title"><?=$arParams["PAGE_BLOCK_TITLE"]?></div>
    <div class="row bxr-list">
        <div class="clearfix"></div>

        <?
        global $unicumID;

        if ($unicumID<=0) {$unicumID = 1;} else {$unicumID++;}

        if (strlen($arParams['UNICUM_POSTFIX'])>0){
                $unicumID = strval($unicumID).strval($arParams['UNICUM_POSTFIX']);
        }

        $thisUncumId =  ($arParams["THIS_UNIC_ID"]) ?: $unicumID;
        $arParams["THIS_UNIC_ID"] = $thisUncumId;
        
        $coreData = Bxmarket::getInstance()->getCoreData();

        $coreData['lg_breakpoint'] = intval($coreData['lg_breakpoint'])>0 ? $coreData['lg_breakpoint'] : 1919;
        $coreData['md_breakpoint'] = intval($coreData['md_breakpoint'])>0 ? $coreData['md_breakpoint'] : 1199;
        $coreData['sm_breakpoint'] = intval($coreData['sm_breakpoint'])>0 ? $coreData['sm_breakpoint'] : 991;
        $coreData['xs_breakpoint'] = intval($coreData['xs_breakpoint'])>0 ? $coreData['xs_breakpoint'] : 761;
        
        $colToElem = array();
        $bootstrapGridCount = $arParams["BXREADY_LIST_BOOTSTRAP_GRID_STYLE"] ?: 12;
        if ($bootstrapGridCount>0){
                for($i=1; $i<=$bootstrapGridCount; $i++){
                        if (($bootstrapGridCount % $i) == 0){
                                $colToElem[$bootstrapGridCount / $i] = $i;
                        }
                }
        }
        
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
            'BXR_PRESENT_SETTINGS' => $arParams['BXR_SALELEADER'],
            'BXREADY_USER_TYPES' => $arParams['BXR_SALELEADER']['BXREADY_USER_TYPES'],
            'BXREADY_USER_TYPE_VARIANT' => $arParams['BXR_SALELEADER']['BXREADY_USER_TYPE_VARIANT']
        );
        $elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
        $elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
        $elementDeleteParams = array('CONFIRM' => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));
        
        $elementDraw = \Alexkova\Bxready2\Draw::getInstance($this);
        $elementDraw->setCurrentTemplate($this);
        $areaIds = array();
        
        if ($sliderMode) {?>
            <div id="sl_<?=$thisUncumId?>" class="bxr-slick-section">
        <?}
        ?>
        <?foreach ($arResult['ITEMS'] as $key => $arItem){
            $uniqueId = $arItem['ID'].'_'.md5($this->randString());
            $areaIds[$arItem['ID']] = $this->GetEditAreaId($uniqueId);
            $this->AddEditAction($uniqueId, $arItem['EDIT_LINK'], $elementEdit);
            $this->AddDeleteAction($uniqueId, $arItem['DELETE_LINK'], $elementDelete, $elementDeleteParams);
            $generalParams['AREA_IDS'] = $areaIds;
        ?>
            <div id="<?=$thisUncumId?>" class="t_<?=$unicumID?> col-xl-<?=$arParams['BXR_SALELEADER']["BXREADY_LIST_XLG_CNT"]?> col-lg-<?=$arParams['BXR_SALELEADER']["BXREADY_LIST_LG_CNT"]?> col-md-<?=$arParams['BXR_SALELEADER']["BXREADY_LIST_MD_CNT"]?> col-sm-<?=$arParams['BXR_SALELEADER']["BXREADY_LIST_SM_CNT"]?> col-xs-<?=$arParams['BXR_SALELEADER']["BXREADY_LIST_XS_CNT"]?>">
                <?$elementDraw->showElement("elements", $arParams['BXR_SALELEADER']["BXREADY_ELEMENT_DRAW"], $arItem, $generalParams + array('SKU_PROPS' => $arResult['SKU_PROPS'][$arItem['IBLOCK_ID']]));?>
            </div>
        <?}?>

        <?if ($sliderMode) {
            $mainId = $this->GetEditAreaId($arParams["THIS_UNIC_ID"])."_bestsallers";
            $obSlName = 'obSl'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);
        ?>
            </div>
            <script>
                $(document).ready(function() {
                    var <?=$obSlName?> = new JCCatalogSectionSlider({
                        uniqId: '<?=$thisUncumId?>',
                        dots: <?=($arParams['BXR_SALELEADER']["BXREADY_LIST_SLIDER_MARKERS"] == "Y") ? 'true' : 'false'?>,
                        speed: <?=intval($arParams['BXR_SALELEADER']["BXREADY_LIST_SLIDER_SCROLLSPEED"])>0 ? intval($arParams['BXR_SALELEADER']["BXREADY_LIST_SLIDER_SCROLLSPEED"]) :  200?>,
                        autoPlay: <?=($arParams['BXR_SALELEADER']["BXREADY_LIST_SLIDER_AUTOSCROLL"] == "Y") ? 'true' : 'false'?>, 
                        autoPlaySpeed: <?=intval($arParams['BXR_SALELEADER']["BXREADY_LIST_SLIDER_AUTOPLAY_SPEEDD"])>0 ? intval($arParams['BXR_SALELEADER']["BXREADY_LIST_SLIDER_AUTOPLAY_SPEEDD"]) :  2000?>,
                        verticalMode: <?=($arParams['BXR_SALELEADER']["BXREADY_LIST_VERTICAL_SLIDER_MODE"] == "Y") ? 'true' : 'false'?>,
                        hideDesktop: <?=($arParams['BXR_SALELEADER']["BXREADY_LIST_HIDE_SLIDER_ARROWS"] == "Y") ? 'true' : 'false'?>, 
                        hideMobile: <?=($arParams['BXR_SALELEADER']["BXREADY_LIST_HIDE_MOBILE_SLIDER_ARROWS"] == "Y") ? 'true' : 'false'?>, 
                        XLG_CNT: <?=$colToElem[$arParams['BXR_SALELEADER']["BXREADY_LIST_XLG_CNT"]]?>,
                        LG_CNT: <?=$colToElem[$arParams['BXR_SALELEADER']["BXREADY_LIST_LG_CNT"]]?>,
                        MD_CNT: <?=$colToElem[$arParams['BXR_SALELEADER']["BXREADY_LIST_MD_CNT"]]?>,
                        SM_CNT: <?=$colToElem[$arParams['BXR_SALELEADER']["BXREADY_LIST_SM_CNT"]]?>,
                        XS_CNT: <?=$colToElem[$arParams['BXR_SALELEADER']["BXREADY_LIST_XS_CNT"]]?>,
                        LG_BREAKPOINT: <?=$coreData['lg_breakpoint']?>,
                        MD_BREAKPOINT: <?=$coreData['md_breakpoint']?>,
                        SM_BREAKPOINT: <?=$coreData['sm_breakpoint']?>,
                        XS_BREAKPOINT: <?=$coreData['xs_breakpoint']?>
                    });
                });
            </script>
        <?}?>
    </div>
<?}?>




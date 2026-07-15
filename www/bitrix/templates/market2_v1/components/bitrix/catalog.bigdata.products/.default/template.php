<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */
if (!CModule::IncludeModule('alexkova.bxready2')) return;
use Alexkova\Bxready2\Draw
    , Alexkova\Market2\Bxmarket;
$frame = $this->createFrame()->begin("");

$injectId = 'bigdata_recommeded_products_'.rand();
?>

<script type="text/javascript">
	BX.cookie_prefix = '<?=CUtil::JSEscape(COption::GetOptionString("main", "cookie_name", "BITRIX_SM"))?>';
	BX.cookie_domain = '<?=$APPLICATION->GetCookieDomain()?>';
	BX.current_server_time = '<?=time()?>';

	BX.ready(function(){
		bx_rcm_recommendation_event_attaching(BX('<?=$injectId?>_items'));
	});

</script>

<?

if (isset($arResult['REQUEST_ITEMS']))
{
	CJSCore::Init(array('ajax'));

	// component parameters
	$signer = new \Bitrix\Main\Security\Sign\Signer;
	$signedParameters = $signer->sign(
		base64_encode(serialize($arResult['_ORIGINAL_PARAMS'])),
		'bx.bd.products.recommendation'
	);
	$signedTemplate = $signer->sign($arResult['RCM_TEMPLATE'], 'bx.bd.products.recommendation');

	?>

	<span id="<?=$injectId?>" class="bigdata_recommended_products_container"></span>

	<script type="text/javascript">
		BX.ready(function(){
			bx_rcm_get_from_cloud(
				'<?=CUtil::JSEscape($injectId)?>',
				<?=CUtil::PhpToJSObject($arResult['RCM_PARAMS'])?>,
				{
					'parameters':'<?=CUtil::JSEscape($signedParameters)?>',
					'template': '<?=CUtil::JSEscape($signedTemplate)?>',
					'site_id': '<?=CUtil::JSEscape(SITE_ID)?>',
					'rcm': 'yes'
				}
			);
		});
	</script>

	<?
	$frame->end();
	return;
}
if (!empty($arResult['ITEMS']))
{
	?><script type="text/javascript">
	BX.message({
		CBD_MESS_BTN_BUY: '<? echo ('' != $arParams['MESS_BTN_BUY'] ? CUtil::JSEscape($arParams['MESS_BTN_BUY']) : GetMessageJS('CVP_TPL_MESS_BTN_BUY')); ?>',
		CBD_MESS_BTN_ADD_TO_BASKET: '<? echo ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? CUtil::JSEscape($arParams['MESS_BTN_ADD_TO_BASKET']) : GetMessageJS('CVP_TPL_MESS_BTN_ADD_TO_BASKET')); ?>',

		CBD_MESS_BTN_DETAIL: '<? echo ('' != $arParams['MESS_BTN_DETAIL'] ? CUtil::JSEscape($arParams['MESS_BTN_DETAIL']) : GetMessageJS('CVP_TPL_MESS_BTN_DETAIL')); ?>',

		CBD_MESS_NOT_AVAILABLE: '<? echo ('' != $arParams['MESS_BTN_DETAIL'] ? CUtil::JSEscape($arParams['MESS_BTN_DETAIL']) : GetMessageJS('CVP_TPL_MESS_BTN_DETAIL')); ?>',
		CBD_BTN_MESSAGE_BASKET_REDIRECT: '<? echo GetMessageJS('CVP_CATALOG_BTN_MESSAGE_BASKET_REDIRECT'); ?>',
		BASKET_URL: '<? echo $arParams["BASKET_URL"]; ?>',
		CBD_ADD_TO_BASKET_OK: '<? echo GetMessageJS('CVP_ADD_TO_BASKET_OK'); ?>',
		CBD_TITLE_ERROR: '<? echo GetMessageJS('CVP_CATALOG_TITLE_ERROR') ?>',
		CBD_TITLE_BASKET_PROPS: '<? echo GetMessageJS('CVP_CATALOG_TITLE_BASKET_PROPS') ?>',
		CBD_TITLE_SUCCESSFUL: '<? echo GetMessageJS('CVP_ADD_TO_BASKET_OK'); ?>',
		CBD_BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CVP_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
		CBD_BTN_MESSAGE_SEND_PROPS: '<? echo GetMessageJS('CVP_CATALOG_BTN_MESSAGE_SEND_PROPS'); ?>',
		CBD_BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CVP_CATALOG_BTN_MESSAGE_CLOSE') ?>'
	});
	</script>
	<span id="<?=$injectId?>_items" class="bigdata_recommended_products_items">
	<input type="hidden" name="bigdata_recommendation_id" value="<?=htmlspecialcharsbx($arResult['RID'])?>">
	<?

	$arSkuTemplate = array();
	if(is_array($arResult['SKU_PROPS']))
	{
		foreach ($arResult['SKU_PROPS'] as $iblockId => $skuProps)
		{
			$arSkuTemplate[$iblockId] = array();
			foreach ($skuProps as &$arProp)
			{
				ob_start();
				if ('TEXT' == $arProp['SHOW_MODE'])
				{
					if (5 < $arProp['VALUES_COUNT'])
					{
						$strClass = 'bx_item_detail_size full';
						$strWidth = ($arProp['VALUES_COUNT'] * 20) . '%';
						$strOneWidth = (100 / $arProp['VALUES_COUNT']) . '%';
						$strSlideStyle = '';
					}
					else
					{
						$strClass = 'bx_item_detail_size';
						$strWidth = '100%';
						$strOneWidth = '20%';
						$strSlideStyle = 'display: none;';
					}
					?>
				<div class="<? echo $strClass; ?>" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_cont">
					<span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?></span>

					<div class="bx_size_scroller_container">
						<div class="bx_size">
							<ul id="#ITEM#_prop_<? echo $arProp['ID']; ?>_list" style="width: <? echo $strWidth; ?>;"><?
								foreach ($arProp['VALUES'] as $arOneValue)
								{
									?>
								<li
									data-treevalue="<? echo $arProp['ID'] . '_' . $arOneValue['ID']; ?>"
									data-onevalue="<? echo $arOneValue['ID']; ?>"
									style="width: <? echo $strOneWidth; ?>;"
									><i></i><span class="cnt"><? echo htmlspecialcharsex($arOneValue['NAME']); ?></span>
									</li><?
								}
								?></ul>
						</div>
						<div class="bx_slide_left" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
						<div class="bx_slide_right" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
					</div>
					</div><?
				}
				elseif ('PICT' == $arProp['SHOW_MODE'])
				{
					if (5 < $arProp['VALUES_COUNT'])
					{
						$strClass = 'bx_item_detail_scu full';
						$strWidth = ($arProp['VALUES_COUNT'] * 20) . '%';
						$strOneWidth = (100 / $arProp['VALUES_COUNT']) . '%';
						$strSlideStyle = '';
					}
					else
					{
						$strClass = 'bx_item_detail_scu';
						$strWidth = '100%';
						$strOneWidth = '20%';
						$strSlideStyle = 'display: none;';
					}
					?>
				<div class="<? echo $strClass; ?>" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_cont">
					<span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?></span>

					<div class="bx_scu_scroller_container">
						<div class="bx_scu">
							<ul id="#ITEM#_prop_<? echo $arProp['ID']; ?>_list" style="width: <? echo $strWidth; ?>;"><?
								foreach ($arProp['VALUES'] as $arOneValue)
								{
									?>
								<li
									data-treevalue="<? echo $arProp['ID'] . '_' . $arOneValue['ID'] ?>"
									data-onevalue="<? echo $arOneValue['ID']; ?>"
									style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>;"
									><i title="<? echo htmlspecialcharsbx($arOneValue['NAME']); ?>"></i>
							<span class="cnt"><span class="cnt_item"
													style="background-image:url('<? echo $arOneValue['PICT']['SRC']; ?>');"
													title="<? echo htmlspecialcharsbx($arOneValue['NAME']); ?>"
									></span></span></li><?
								}
								?></ul>
						</div>
						<div class="bx_slide_left" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
						<div class="bx_slide_right" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
					</div>
					</div><?
				}
				$arSkuTemplate[$iblockId][$arProp['CODE']] = ob_get_contents();
				ob_end_clean();
				unset($arProp);
			}
		}
	}

	?>
    <div class="h3"><?=$arParams["BLOCK_TITLE"]?></div>
	<div class="row bxr-list">
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
        
        $sliderMode = ($arParams['BXR_BIGDATA']["BXREADY_LIST_SLIDER"] == "Y") ? true : false; 
        
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
            'OFFERS_PROPERTY_CODE' => $arParams["PROPERTY_CODE_".$arParams['OFFERS_IBLOCK_ID']],
            'BXR_PRESENT_SETTINGS' => $arParams['BXR_BIGDATA'],
            'BXREADY_USER_TYPES' => $arParams['BXR_BIGDATA']['BXREADY_USE_ELEMENTCLASS'],
            'BXREADY_USER_TYPE_VARIANT' => $arParams['BXR_BIGDATA']['BXREADY_USER_TYPE_VARIANT']
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
	foreach ($arResult['ITEMS'] as $key => $arItem)
	{
                
            $uniqueId = $arItem['ID'].'_'.md5($this->randString());
            $areaIds[$arItem['ID']] = $this->GetEditAreaId($uniqueId);
            $this->AddEditAction($uniqueId, $arItem['EDIT_LINK'], $elementEdit);
            $this->AddDeleteAction($uniqueId, $arItem['DELETE_LINK'], $elementDelete, $elementDeleteParams);
            $generalParams['AREA_IDS'] = $areaIds;

            $arItemIDs = array(
                'ID' => $strMainID,
                'PICT' => $strMainID . '_pict',
                'SECOND_PICT' => $strMainID . '_secondpict',
                'MAIN_PROPS' => $strMainID . '_main_props',

                'QUANTITY' => $strMainID . '_quantity',
                'QUANTITY_DOWN' => $strMainID . '_quant_down',
                'QUANTITY_UP' => $strMainID . '_quant_up',
                'QUANTITY_MEASURE' => $strMainID . '_quant_measure',
                'BUY_LINK' => $strMainID . '_buy_link',
                'BASKET_ACTIONS' => $strMainID.'_basket_actions',
                'NOT_AVAILABLE_MESS' => $strMainID.'_not_avail',
                'SUBSCRIBE_LINK' => $strMainID . '_subscribe',

                'PRICE' => $strMainID . '_price',
                'DSC_PERC' => $strMainID . '_dsc_perc',
                'SECOND_DSC_PERC' => $strMainID . '_second_dsc_perc',

                'PROP_DIV' => $strMainID . '_sku_tree',
                'PROP' => $strMainID . '_prop_',
                'DISPLAY_PROP_DIV' => $strMainID . '_sku_prop',
                'BASKET_PROP_DIV' => $strMainID . '_basket_prop'
            );

		$strObName = 'ob' . preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
		
		?>            
            <div id="<?=$thisUncumId?>" class="t_<?=$unicumID?> col-xl-<?=$arParams['BXR_BIGDATA']["BXREADY_LIST_XLG_CNT"]?> col-lg-<?=$arParams['BXR_BIGDATA']["BXREADY_LIST_LG_CNT"]?> col-md-<?=$arParams['BXR_BIGDATA']["BXREADY_LIST_MD_CNT"]?> col-sm-<?=$arParams['BXR_BIGDATA']["BXREADY_LIST_SM_CNT"]?> col-xs-<?=$arParams['BXR_BIGDATA']["BXREADY_LIST_XS_CNT"]?>">
                <?$elementDraw->showElement("elements", $arParams['BXR_BIGDATA']["BXREADY_ELEMENT_DRAW"], $arItem, $generalParams + array('SKU_PROPS' => $arResult['SKU_PROPS'][$arItem['IBLOCK_ID']]));?>
            </div>
            <?
            $arJSParams = array(
                    'PRODUCT_TYPE' => 1,
                    'SHOW_QUANTITY' => false,
                    'SHOW_ADD_BASKET_BTN' => false,
                    'SHOW_BUY_BTN' => true,
                    'SHOW_ABSENT' => true,
                    'PRODUCT' => array(
                            'ID' => $arItem['ID'],
                            'NAME' => $arItem['~NAME'],
                            'PICT' => ('Y' == $arItem['SECOND_PICT'] ? $arItem['PREVIEW_PICTURE_SECOND'] : $arItem['PREVIEW_PICTURE']),
                            'CAN_BUY' => $arItem["CAN_BUY"],
                            'SUBSCRIPTION' => ('Y' == $arItem['CATALOG_SUBSCRIPTION']),
                            'CHECK_QUANTITY' => $arItem['CHECK_QUANTITY'],
                            'MAX_QUANTITY' => $arItem['CATALOG_QUANTITY'],
                            'STEP_QUANTITY' => $arItem['CATALOG_MEASURE_RATIO'],
                            'QUANTITY_FLOAT' => is_double($arItem['CATALOG_MEASURE_RATIO']),
                            'ADD_URL' => $arItem['~ADD_URL'],
                            'SUBSCRIBE_URL' => $arItem['~SUBSCRIBE_URL']
                    ),
                    'BASKET' => array(
                            'ADD_PROPS' => ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET']),
                            'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                            'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
                            'EMPTY_PROPS' => $emptyProductProperties
                    ),
                    'VISUAL' => array(
                            'ID' => $arItemIDs['ID'],
                            'PICT_ID' => $arItemIDs['PICT'],
                            'QUANTITY_ID' => $arItemIDs['QUANTITY'],
                            'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
                            'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
                            'PRICE_ID' => $arItemIDs['PRICE'],
                            'BUY_ID' => $arItemIDs['BUY_LINK'],
                            'BASKET_PROP_DIV' => $arItemIDs['BASKET_PROP_DIV'],
                            'BASKET_FORM' => $arItemIDs['BASKET_FORM'],
                    ),
                    'LAST_ELEMENT' => $arItem['LAST_ELEMENT'],
                    'HAS_OFFERS' => isset($arItem["OFFERS"]) && !empty($arItem["OFFERS"])?'Y':''
            );
            ?>
            <script type="text/javascript">
                var <? echo $strObName; ?> =
                new JCCatalogBigdataProducts(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
            </script>
        <?
	}
	?>        
        </div>
        <?if ($sliderMode) {
            $mainId = $this->GetEditAreaId($arParams["THIS_UNIC_ID"])."_bigData";
            $obSlName = 'obSl'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);
        ?>
            </div>
            <script>
                $(document).ready(function() {
                    var <?=$obSlName?> = new JCCatalogSectionSlider({
                        uniqId: '<?=$thisUncumId?>',
                        dots: <?=($arParams['BXR_BIGDATA']["BXREADY_LIST_SLIDER_MARKERS"] == "Y") ? 'true' : 'false'?>,
                        speed: <?=intval($arParams['BXR_BIGDATA']["BXREADY_LIST_SLIDER_SCROLLSPEED"])>0 ? intval($arParams['BXR_BIGDATA']["BXREADY_LIST_SLIDER_SCROLLSPEED"]) :  200?>,
                        autoPlay: <?=($arParams['BXR_BIGDATA']["BXREADY_LIST_SLIDER_AUTOSCROLL"] == "Y") ? 'true' : 'false'?>, 
                        autoPlaySpeed: <?=intval($arParams['BXR_BIGDATA']["BXREADY_LIST_SLIDER_AUTOPLAY_SPEEDD"])>0 ? intval($arParams['BXR_BIGDATA']["BXREADY_LIST_SLIDER_AUTOPLAY_SPEEDD"]) :  2000?>,
                        verticalMode: <?=($arParams['BXR_BIGDATA']["BXREADY_LIST_VERTICAL_SLIDER_MODE"] == "Y") ? 'true' : 'false'?>,
                        hideDesktop: <?=($arParams['BXR_BIGDATA']["BXREADY_LIST_HIDE_SLIDER_ARROWS"] == "Y") ? 'true' : 'false'?>, 
                        hideMobile: <?=($arParams['BXR_BIGDATA']["BXREADY_LIST_HIDE_MOBILE_SLIDER_ARROWS"] == "Y") ? 'true' : 'false'?>, 
                        XLG_CNT: <?=$colToElem[$arParams['BXR_BIGDATA']["BXREADY_LIST_XLG_CNT"]]?>,
                        LG_CNT: <?=$colToElem[$arParams['BXR_BIGDATA']["BXREADY_LIST_LG_CNT"]]?>,
                        MD_CNT: <?=$colToElem[$arParams['BXR_BIGDATA']["BXREADY_LIST_MD_CNT"]]?>,
                        SM_CNT: <?=$colToElem[$arParams['BXR_BIGDATA']["BXREADY_LIST_SM_CNT"]]?>,
                        XS_CNT: <?=$colToElem[$arParams['BXR_BIGDATA']["BXREADY_LIST_XS_CNT"]]?>,
                        LG_BREAKPOINT: <?=$coreData['lg_breakpoint']?>,
                        MD_BREAKPOINT: <?=$coreData['md_breakpoint']?>,
                        SM_BREAKPOINT: <?=$coreData['sm_breakpoint']?>,
                        XS_BREAKPOINT: <?=$coreData['xs_breakpoint']?>
                    });
                });
            </script>
        <?}?>
    </span>
<?
}
$frame->end();?>
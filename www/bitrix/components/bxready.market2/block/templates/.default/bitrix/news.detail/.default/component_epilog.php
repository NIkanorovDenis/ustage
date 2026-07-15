<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
        <div class="col-xs-12">
            <a href="<?=$arResult['SECTION_URL']?>" class="bxr-color-button bxr-color-button-small bxr-element-get-back">
                <i class="fa fa-angle-left"></i>
                <?=GetMessage('GET_BACK')?>
            </a>
            <?include ('include/share.php');?>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<?if (!is_array($arResult['SMART_LINK'])) $arResult['SMART_LINK'] = array();

if (count($arResult['SMART_LINK'])>0){
	global $arGlobalSmartLink;
	if (!isset($arGlobalSmartLink) || !is_array($arGlobalSmartLink)){
		$arGlobalSmartLink = $arResult['SMART_LINK'];
	}
}else{
    if(isset($arResult['SMART_LINK']))
	foreach ($arResult['SMART_LINK'] as $cell=>$val){
		$arGlobalSmartLink[$cell] = $val;
	}
}

if (is_array($arParams['BXR_FORMS']) && count($arParams['BXR_FORMS'])>0){

	$arParams['BXR_FORMS']["EVENT_CLASS"] = 'bxr-color-button';
	$arParams['BXR_FORMS']["COMPONENT_TEMPLATE"] = "popup";

	$arParams['BXR_FORMS']['EVENT_CLASS'] .= ' hidden-lg hidden-md hidden-sm hidden-xs';

	$APPLICATION->IncludeComponent(
		"bxready.market2:form.iblock",
		"popup",
		$arParams['BXR_FORMS'],
		false,
		array('HIDE_ICONS' => 'Y')
	);

}

?>


<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use \Bitrix\Main\Localization\Loc;
Loc::loadLanguageFile(__FILE__);?>
        <div class="col-xs-12">
            <div class="bxr-detail-epilog">
                <a href="<?=($arResult['SECTION_URL']) ? $arResult['SECTION_URL'] : $arParams['SECTION_URL']?>" class="bxr-color-button bxr-element-get-back">
                    <i class="fa fa-angle-left"></i><?=GetMessage('GET_BACK')?>
                </a>
                <?include ('include/share.php');?>
                <div class="clearfix"></div>
            </div>
        </div>
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
        $formTemplate = ($arParams["BXR_PTYPE"] == 'catalog') ? "request_product" : "popup";
	$arParams['BXR_FORMS']["EVENT_CLASS"] = 'bxr-color-button';
	$arParams['BXR_FORMS']["COMPONENT_TEMPLATE"] = $formTemplate;
	$arParams['BXR_FORMS']['EVENT_CLASS'] .= ' hidden-xl hidden-lg hidden-md hidden-sm hidden-xs';

	$APPLICATION->IncludeComponent(
		"bxready.market2:form.iblock",
		$formTemplate,
		$arParams['BXR_FORMS'],
		false,
		array('HIDE_ICONS' => 'Y')
	);

}

?>


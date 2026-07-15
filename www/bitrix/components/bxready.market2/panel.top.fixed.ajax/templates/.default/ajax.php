<?
define('STOP_STATISTICS', true);

$siteId = isset($_REQUEST['siteId']) && is_string($_REQUEST['siteId']) ? $_REQUEST['siteId'] : '';
$siteId = substr(preg_replace('/[^a-z0-9_]/i', '', $siteId), 0, 2);
if (!empty($siteId) && is_string($siteId))
	define('SITE_ID', $siteId);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){

	global $ajaxReferer,$APPLICATION;

	$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
	$request->addFilter(new \Bitrix\Main\Web\PostDecodeFilter);

	$signer = new \Bitrix\Main\Security\Sign\Signer;
	try
	{
		$paramString = $signer->unsign($request->get('parameters'), 'top_fixed_panel_ajax');
                $arBxMarket = $signer->unsign($request->get('bxmarket'), 'top_fixed_panel_ajax');
	}
	catch (\Bitrix\Main\Security\Sign\BadSignatureException $e)
	{
		die();
	}

	$arParams = unserialize(base64_decode($paramString));
        $arBxMarket = unserialize(base64_decode($arBxMarket));


	$ajaxReferer = $_SERVER["HTTP_REFERER"];
        $pos = stripos($_SERVER["HTTP_REFERER"], $_SERVER["HTTP_HOST"]);
        if($pos !== false) {
            $APPLICATION->SetCurPage(substr($_SERVER["HTTP_REFERER"], ($pos+strlen($_SERVER["HTTP_HOST"]))/*, strlen($_SERVER["HTTP_REFERER"])*/));
        }

	if (
	CModule::IncludeModule('alexkova.bxready2')
	&& CModule::IncludeModule('alexkova.market2')
	&& strlen($arParams['FIXED_PANEL_CODE'])>0
	&& strlen($arParams['FIXED_PANEL_DEFAULT_VARIANT'])>0
	){
            $bxmarket = \Alexkova\Market2\Bxmarket::getInstance();
            $bxmarket->setCoreData($arBxMarket);

            $regionData = $bxmarket->getRegionData();

            if(empty($regionData) && isset($arParams["BXR_AJAX_REGION_INFO"]) && !empty($arParams["BXR_AJAX_REGION_INFO"]) ) {
                $bxmarket->setRegionData(array("region_detail"=>$arParams["BXR_AJAX_REGION_INFO"]));
                $regionData = $bxmarket->getRegionData();
            }

            \Alexkova\Bxready2\Area::showArea($arParams['FIXED_PANEL_CODE'], $arParams['FIXED_PANEL_DEFAULT_VARIANT'], true);
	}
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>



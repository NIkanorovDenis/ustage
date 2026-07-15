<?
define('STOP_STATISTICS', true);

$siteId = isset($_REQUEST['siteId']) && is_string($_REQUEST['siteId']) ? $_REQUEST['siteId'] : '';
$siteId = substr(preg_replace('/[^a-z0-9_]/i', '', $siteId), 0, 2);
if (!empty($siteId) && is_string($siteId)) {
    define('SITE_ID', $siteId);
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$request->addFilter(new \Bitrix\Main\Web\PostDecodeFilter);

if (!\Bitrix\Main\Loader::includeModule('iblock'))
    return;

$signer = new \Bitrix\Main\Security\Sign\Signer;

try {
    $template = $signer->unsign($request->get('template'), 'regions');
    $paramString = $signer->unsign($request->get('parameters'), 'regions');
} catch (\Bitrix\Main\Security\Sign\BadSignatureException $e) {
    die();
}

$parameters = unserialize(base64_decode($paramString));

/*$bxmarket = \Alexkova\Market2\Bxmarket::getInstance();
$bxmarket->setCoreData($arBxMarket);

$regionData = $bxmarket->getRegionData();

if(empty($regionData) && isset($parameters["BXR_AJAX_REGION_INFO"]) && !empty($parameters["BXR_AJAX_REGION_INFO"]) ) {
    $bxmarket->setRegionData($parameters["BXR_AJAX_REGION_INFO"]);
    $regionData = $bxmarket->getRegionData();
}*/

if (isset($parameters['PARENT_NAME'])) {
    $parent = new CBitrixComponent();
    $parent->InitComponent($parameters['PARENT_NAME'], $parameters['PARENT_TEMPLATE_NAME']);
    $parent->InitComponentTemplate($parameters['PARENT_TEMPLATE_PAGE']);
} else {
    $parent = false;
}

$parameters['FORM_MODE'] = 'STATIC';

$APPLICATION->IncludeComponent(
    "bxready.market2:region.selector",
    $template,
    $parameters,
    false,
    array(
        "HIDE_ICONS"=>"Y"
    )
);
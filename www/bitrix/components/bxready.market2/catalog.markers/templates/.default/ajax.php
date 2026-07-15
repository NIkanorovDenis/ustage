<?
/** @global \CMain $APPLICATION */
define('STOP_STATISTICS', true);

$siteId = isset($_REQUEST['siteId']) && is_string($_REQUEST['siteId']) ? $_REQUEST['siteId'] : '';
$siteId = substr(preg_replace('/[^a-z0-9_]/i', '', $siteId), 0, 2);
if (!empty($siteId) && is_string($siteId))
    define('SITE_ID', $siteId);

require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$request->addFilter(new \Bitrix\Main\Web\PostDecodeFilter);

if (!\Bitrix\Main\Loader::includeModule('iblock'))
    return;

$signer = new \Bitrix\Main\Security\Sign\Signer;
try
{
    $template = $signer->unsign($request->get('template'), 'markers');
    $paramString = $signer->unsign($request->get('parameters'), 'markers');
}
catch (\Bitrix\Main\Security\Sign\BadSignatureException $e)
{
    die();
}

$parameters = unserialize(base64_decode($paramString));
if (isset($parameters['PARENT_NAME']))
{
    $parent = new CBitrixComponent();
    $parent->InitComponent($parameters['PARENT_NAME'], $parameters['PARENT_TEMPLATE_NAME']);
    $parent->InitComponentTemplate($parameters['PARENT_TEMPLATE_PAGE']);
}
else
{
    $parent = false;
}

$parameters['SINGLE_MODE'] = "Y";
$parameters['DISPLAY_TOP_PAGER'] = "N";
$parameters['DISPLAY_BOTTOM_PAGER'] = "N";

if (!CModule::IncludeModule('alexkova.market2')) return;

$marketRegistry = \Alexkova\Market2\Bxmarket::getInstance();
$regionData = $marketRegistry->getRegionData();

if(empty($regionData) && isset($parameters["BXR_AJAX_REGION_INFO"]) && !empty($parameters["BXR_AJAX_REGION_INFO"]) ) {
    $marketRegistry->setRegionData(array("region_detail"=>$parameters["BXR_AJAX_REGION_INFO"]));
    $regionData = $marketRegistry->getRegionData();
}

$APPLICATION->IncludeComponent(
    'bxready.market2:catalog.markers',
    $template,
    $parameters,
    false,
    array('HIDE_ICONS'=>'Y')
);
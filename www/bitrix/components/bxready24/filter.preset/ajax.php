<?
/** @global \CMain $APPLICATION */
define('STOP_STATISTICS', true);

$siteId = isset($_REQUEST['siteId']) && is_string($_REQUEST['siteId']) ? $_REQUEST['siteId'] : '';
$siteId = substr(preg_replace('/[^a-z0-9_]/i', '', $siteId), 0, 2);
/*if (!empty($siteId) && is_string($siteId))
    define('SITE_ID', $siteId);*/

require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$request->addFilter(new \Bitrix\Main\Web\PostDecodeFilter);

if (
!\Bitrix\Main\Loader::includeModule('iblock')
|| !\Bitrix\Main\Loader::includeModule('alexkova.bxready24')
|| !\Bitrix\Main\Loader::includeModule('catalog')
)    return;

$signer = new \Bitrix\Main\Security\Sign\Signer;
try
{
    $template = $signer->unsign($request->get('template'), 'bxready24filter');
    $paramString = $signer->unsign($request->get('parameters'), 'bxready24filter');
	$bidString = intval($request->get('BID'));
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
$parameters['FILTER_PRESET_ID'] = $bidString;
echo "333<pre>"; print_r($_REQUEST); echo "</pre>";
echo "333<pre>"; print_r($parameters); echo "</pre>";

$APPLICATION->IncludeComponent(
    'bxready24:filter.preset',
    $template,
    $parameters,
    false,
    array('HIDE_ICONS'=>'Y')
);
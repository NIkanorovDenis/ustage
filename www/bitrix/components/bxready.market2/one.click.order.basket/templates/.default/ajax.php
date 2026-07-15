<?
/** @global \CMain $APPLICATION */
define('STOP_STATISTICS', true);

$siteId = isset($_REQUEST['siteId']) && is_string($_REQUEST['siteId']) ? $_REQUEST['siteId'] : '';
$siteId = substr(preg_replace('/[^a-z0-9_]/i', '', $siteId), 0, 2);
if (!empty($siteId) && is_string($siteId))
    define('SITE_ID', $siteId);

require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
CJSCore::Init();
$APPLICATION->ShowHead();
$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
if (!\Bitrix\Main\Loader::includeModule('iblock'))
    return;

$signer = new \Bitrix\Main\Security\Sign\Signer;
try
{
    $template = $signer->unsign($request->get('template'), 'one_click_order');
    $paramString = $signer->unsign($request->get('parameters'), 'one_click_order');
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

$parameters['AJAX_MODE'] = "Y";
$parameters['AJAX_OPTION_HISTORY'] = "N";

foreach ($parameters as $cell => &$val) {
    if (substr_count($cell, "TEXT") > 0 || substr_count($cell, "MESS") > 0) {
        $val = urldecode($val);
        $val = trim($val);
    }
}


$APPLICATION->IncludeComponent(
    'bxready.market2:one.click.order.basket',
    $template,
    $parameters,
    false
);

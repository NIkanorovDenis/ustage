<?
/** @global \CMain $APPLICATION */
define('STOP_STATISTICS', true);
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])  || empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
	return false;
}

/*$siteId = isset($_REQUEST['siteId']) && is_string($_REQUEST['siteId']) ? $_REQUEST['siteId'] : '';
$siteId = substr(preg_replace('/[^a-z0-9_]/i', '', $siteId), 0, 2);
if (!empty($siteId) && is_string($siteId))
	define('SITE_ID', $siteId);*/

require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$request->addFilter(new \Bitrix\Main\Web\PostDecodeFilter);

if (!\Bitrix\Main\Loader::includeModule('iblock'))
	return;

$signer = new \Bitrix\Main\Security\Sign\Signer;
try
{
	$template = $signer->unsign($request->get('template'), 'seoset');
	$paramString = $signer->unsign($request->get('parameters'), 'seoset');
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

?>
<?if (!isset($_REQUEST['ajax']) || $_REQUEST['ajax'] != "yes"){
	die();
}

$APPLICATION->IncludeComponent('bxready.market2:seo.set', $template, $parameters);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
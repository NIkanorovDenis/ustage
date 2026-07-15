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
//$request->addFilter(new \Bitrix\Main\Web\PostDecodeFilter);
if (!check_bitrix_sessid()) {
	$APPLICATION->RestartBuffer();
	echo 'error';
	die();
}

if (!\Bitrix\Main\Loader::includeModule('iblock'))
	return;

$signer = new \Bitrix\Main\Security\Sign\Signer;
try
{
	$template = $signer->unsign($request->get('template'), 'settingspanel');
	$paramString = $signer->unsign($request->get('parameters'), 'settingspanel');
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
<?if (!isset($_REQUEST['ajax_mode']) || $_REQUEST['ajax_mode'] != "yes"){
	die();
} else {
	$parameters['FROM_AJAX'] = true;
}

if (!defined('SITE_TEMPLATE_ID') && isset($_REQUEST['siteTemplate'])) {
	define('SITE_TEMPLATE_ID', htmlspecialchars($_REQUEST['siteTemplate']));
}

$APPLICATION->IncludeComponent('bxready2:settings.panel', $template, $parameters);


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
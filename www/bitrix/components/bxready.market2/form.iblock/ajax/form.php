<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$formParamsList = include $_SERVER['DOCUMENT_ROOT'] . '/include/forms/params.php';

$formId = strval($_REQUEST["FORM_ID_FULL"]); 
$params = isset($formParamsList[$formId]) ? $formParamsList[$formId] : [];

/*
if(!$_REQUEST["strIMessage"] && (strlen($formId)<=0 || !is_array($params) || empty($params)))
	die("Error form id");
*/

$params["AJAX"] = 'Y';
$params["FIRST"] = htmlspecialcharsbx($_REQUEST["first"]);

global $BXR_FORM_COUNTER;
$BXR_FORM_COUNTER = $params['IDENTITY'];

if ($_REQUEST["TARGET_URL"]) {
	$params["TARGET_URL"] = htmlspecialcharsbx($_REQUEST["TARGET_URL"]);
}

$template = strlen($params['COMPONENT_TEMPLATE'])>0 ? $params['COMPONENT_TEMPLATE'] : '';
$params["DATA_ATTR"] = (array) json_decode($_REQUEST["DATA"]);

file_put_contents($_SERVER['DOCUMENT_ROOT'].'/cron/logs_form.txt' , print_r($_REQUEST, true));

?>

<?$APPLICATION->IncludeComponent(
	"bxready.market2:iblock.element.add.form",
	$template,
	$params,
	false,
        array("HIDE_ICONS"=>"Y")
);?>

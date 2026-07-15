<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

$this->setFrameMode(true);

$this->addExternalCss('/bitrix/css/bxready24/blocks.css');

if (in_array(
	$arResult['PAGE'],
	array(
		'/bitrix/admin/landing_view.php',
		'/bitrix/tools/landing/ajax.php'
	))) {

	include ('include/editor.php');

}


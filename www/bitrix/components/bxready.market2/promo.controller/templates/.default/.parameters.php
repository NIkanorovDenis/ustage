<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?
/** @var array $arCurrentValues */
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

$arPromoTypes = array(
	'promo' => GetMessage('PROMO_CONTROLLER_TYPE_PROMO'),
	'slider' => GetMessage('PROMO_CONTROLLER_TYPE_SLIDER'),
	'complex' => 'complex',
  'aside' => 'aside',
);

if (strlen($arCurrentValues['PROMO_CONTROLLER_TYPE'])<=0){
	$arCurrentValues['PROMO_CONTROLLER_TYPE'] = 'promo';
}

$arTemplateParameters = array(
	"PROMO_CONTROLLER_TYPE" => array(
		"PARENT" => "COMPONENT_TEMPLATE",
		"NAME" => GetMessage("PROMO_CONTROLLER_TYPE"),
		"TYPE" => "LIST",
		"VALUES" => $arPromoTypes,
		"REFRESH" => "Y",
	)
);

include ('.'.$arCurrentValues['PROMO_CONTROLLER_TYPE'].'.parameters.php');

<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?

$paramPrefix = 'BXR_PROMO_';

include('.prepare.params.php');

$prepareParams['SET_TITLE'] = 'N';
$prepareParams["SET_BROWSER_TITLE"] = 'N';
$prepareParams["SET_META_DESCRIPTION"] = 'N';
$prepareParams["SET_META_KEYWORDS"] = 'N';
$prepareParams["ADD_SECTIONS_CHAIN"] = 'N';
$prepareParams["INCLUDE_IBLOCK_INTO_CHAIN"] = 'N';



$APPLICATION->IncludeComponent(
        "bitrix:news.list",
        "aside",
		$prepareParams,
        $component,
	array('HIDE_ICONS'=>'Y')
);


<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var string $componentPath
 * @var string $componentName
 * @var array $arCurrentValues
 */

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Web\Json;

if (!Loader::includeModule('iblock'))
	return;

$arTemplateParameters['SHOW_FAVORITES_PAGE'] = array(
	'PARENT' => 'BASE',
	'NAME' => GetMessage('SHOW_FAVORITES_PAGE'),
	'TYPE' => 'CHECKBOX',
	'REFRESH' => 'Y',
	'DEFAULT' => 'N',
    'SORT' => 20
);

$arTemplateParameters["PATH_TO_FAVORITES"] = array(
    "NAME" => GetMessage("SPS_PATH_TO_FAVORITES"),
    "TYPE" => "STRING",
    "MULTIPLE" => "N",
    "DEFAULT" => "/personal/favorites/",
    "COLS" => 25,
    "PARENT" => "URL_TEMPLATES",
);
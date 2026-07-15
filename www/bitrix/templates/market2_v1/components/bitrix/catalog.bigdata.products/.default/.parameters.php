<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arTemplateParameters['LINE_ELEMENT_COUNT'] = array(
	"PARENT" => "VISUAL",
	"NAME" => GetMessage("CVP_LINE_ELEMENT_COUNT"),
	"TYPE" => "STRING",
	"DEFAULT" => "3",
);

$arThemes = array();
if (\Bitrix\Main\ModuleManager::isModuleInstalled('bitrix.eshop'))
{
	$arThemes['site'] = GetMessage('CVP_TPL_THEME_SITE');
}
$arThemesList = array(
	'blue' => GetMessage('CVP_TPL_THEME_BLUE'),
	'green' => GetMessage('CVP_TPL_THEME_GREEN'),
	'red' => GetMessage('CVP_TPL_THEME_RED'),
	'wood' => GetMessage('CVP_TPL_THEME_WOOD'),
	'yellow' => GetMessage('CVP_TPL_THEME_YELLOW'),
	'black' => GetMessage('CVP_TPL_THEME_BLACK')

);
$arCols = array("1" => 12,"2" => 6,"3" => 4,"4" => 3,"6" => 2,"12" => 1);
$bxrTheme = array(
"ecommerce.v1.lite" => "ecommerce.v1.lite",
"ecommerce.m2.v1" => "ecommerce.m2.v1",
"ecommerce.v3.lite" => "ecommerce.v3.lite",
"ecommerce.v3.lite.color" => "ecommerce.v3.lite.color",
"ecommerce.v4.effect" => "ecommerce.v4.effect"
);
$dir = trim(preg_replace("'[\\\\/]+'", "/", dirname(__FILE__)."/themes/"));
if (is_dir($dir))
{
	foreach ($arThemesList as $themeID => $themeName)
	{
		if (!is_file($dir.$themeID.'/style.css'))
			continue;
		$arThemes[$themeID] = $themeName;
	}
}

$arTemplateParameters['TEMPLATE_THEME'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage("CVP_TPL_TEMPLATE_THEME"),
	'TYPE' => 'LIST',
	'VALUES' => $arThemes,
	'DEFAULT' => 'blue',
	'ADDITIONAL_VALUES' => 'Y'
);
$arTemplateParameters['BXREADY_LIST_LG_CNT'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage("BXR_COUNT_LG"),
	'TYPE' => 'LIST',
	'VALUES' => $arCols,
	'DEFAULT' => '4',
);
$arTemplateParameters['BXREADY_LIST_MD_CNT'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage("BXR_COUNT_MD"),
	'TYPE' => 'LIST',
	'VALUES' => $arCols,
	'DEFAULT' => '3',
	'ADDITIONAL_VALUES' => 'Y'
);
$arTemplateParameters['BXREADY_LIST_SM_CNT'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage("BXR_COUNT_SM"),
	'TYPE' => 'LIST',
	'VALUES' => $arCols,
	'DEFAULT' => '2',
	'ADDITIONAL_VALUES' => 'Y'
);
$arTemplateParameters['BXREADY_LIST_XS_CNT'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage("BXR_COUNT_XS"),
	'TYPE' => 'LIST',
	'VALUES' => $arCols,
	'DEFAULT' => '1',
	'ADDITIONAL_VALUES' => 'Y'
);	
$arTemplateParameters['BXREADY_ELEMENT_DRAW'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage("BXR_ELEMENT_TYPE"),
	'TYPE' => 'LIST',
	"VALUES" => $bxrTheme,
	'DEFAULT' => "ecommerce.m2.v1",
	'ADDITIONAL_VALUES' => 'Y'
);
<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

$arStyleMenu = array(
    "colored_light" => GetMessage("LIGHT_STYLE_MENU"),
    "colored_dark" => GetMessage("DARK_STYLE_MENU"),
    "colored_color" => GetMessage("COLOR_STYLE_MENU"),
);

$arTemplateParameters = array(
    'BXR_MOBILE_SHOW_SEARCH_FORM' => array(
	'NAME' => GetMessage('BXR_MOBILE_SHOW_SEARCH_FORM'),
	'PARENT' => 'VISUAL',
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'Y',
    ),
    'BXR_MOBILE_SHOW_ANSWER_FORM' => array(
	'NAME' => GetMessage('BXR_MOBILE_SHOW_ANSWER_FORM'),
	'PARENT' => 'VISUAL',
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'Y',
    ),
    'BXR_MOBILE_SHOW_PHONE_FORM' => array(
        'NAME' => GetMessage('BXR_MOBILE_SHOW_PHONE_FORM'),
        'PARENT' => 'VISUAL',
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'Y',
    ),
    'BXR_MOBILE_SHOW_USER_FORM' => array(
        'NAME' => GetMessage('BXR_MOBILE_SHOW_USER_FORM'),
        'PARENT' => 'VISUAL',
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'Y',
    ),
    'BXR_MOBILE_SHOW_CHART_FORM' => array(
        'NAME' => GetMessage('BXR_MOBILE_SHOW_CHART_FORM'),
        'PARENT' => 'VISUAL',
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'Y',
        "REFRESH" => "Y",
    ),
    'BXR_MOBILE_SHOW_HEART_FORM' => array(
        'NAME' => GetMessage('BXR_MOBILE_SHOW_HEART_FORM'),
        'PARENT' => 'VISUAL',
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'Y',
        "REFRESH" => "Y",
    ),
    'BXR_MOBILE_SHOW_BASKET_FORM' => array(
        'NAME' => GetMessage('BXR_MOBILE_SHOW_BASKET_FORM'),
        'PARENT' => 'VISUAL',
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'Y',
        "REFRESH" => "Y",
    ),
    "STYLE_MENU" => array(
        "PARENT" => "MENU_BLOCKS",
        "NAME" => GetMessage("STYLE_MENU"),
        "TYPE" => "LIST",
        "VALUES" => $arStyleMenu,
        "DEFAULT" => "colored_light",
    ),     
);

if(isset($arCurrentValues["BXR_MOBILE_SHOW_USER_FORM"]) && $arCurrentValues["BXR_MOBILE_SHOW_USER_FORM"] === "Y")
{
    $arTemplateParameters["BXR_USER_LINK"] = array(
        "PARENT" => "MENU_USER",
        "NAME" => GetMessage("BXR_USER_LINK"),
        "TYPE" => "STRING ",
        "DEFAULT" => "/personal/profile/",
    );
}
        
if(isset($arCurrentValues["BXR_MOBILE_SHOW_CHART_FORM"]) && $arCurrentValues["BXR_MOBILE_SHOW_CHART_FORM"] === "Y")
{
    $arTemplateParameters["BXR_COMPARE_LINK"] = array(
        "PARENT" => "MENU_COMPARE",
        "NAME" => GetMessage("BXR_COMPARE_LINK"),
        "TYPE" => "STRING ",
        "DEFAULT" => "/catalog/compare.php",
    );
}

if(isset($arCurrentValues["BXR_MOBILE_SHOW_HEART_FORM"]) && $arCurrentValues["BXR_MOBILE_SHOW_HEART_FORM"] === "Y")
{
    $arTemplateParameters["BXR_FAVORITES_LINK"] = array(
        "PARENT" => "MENU_FAVORITES",
        "NAME" => GetMessage("BXR_FAVORITES_LINK"),
        "TYPE" => "STRING ",
        "DEFAULT" => "/personal/favorites/",
    );
}

if(isset($arCurrentValues["BXR_MOBILE_SHOW_BASKET_FORM"]) && $arCurrentValues["BXR_MOBILE_SHOW_BASKET_FORM"] === "Y")
{
    $arTemplateParameters["BXR_BASKET_LINK"] = array(
        "PARENT" => "MENU_BASKET",
        "NAME" => GetMessage("BXR_BASKET_LINK"),
        "TYPE" => "STRING ",
        "DEFAULT" => "/personal/basket/",
    );
}

?>
<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

$arBtnType = array(
    'BTN' => GetMessage('BTN'),
    'LINK' => GetMessage('LINK'),
);

$float = array(
    'NONE' => GetMessage('FLOAT_NONE'),
    'LEFT' => GetMessage('FLOAT_LEFT'),
    'RIGHT' => GetMessage('FLOAT_RIGHT')
);

$arTemplateParameters = array(
        'INCLUDE_PTITLE' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage('INCLUDE_PTITLE'),
            'TYPE' => 'STRING',
            'DEFAULT' => ''
        ),
        'FLOAT' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage('FLOAT'),
            'TYPE' => 'LIST',
            'VALUES' => $float
        ),
        'SHOW_BTN' => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("SHOW_BTN"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
            "REFRESH" => "Y",
        ),
);
        
if($arCurrentValues["SHOW_BTN"] === "Y")
{
    $arTemplateParameters["BTN_TYPE"] = array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("BTN_TYPE"),
        "TYPE" => "LIST",
        "VALUES" => $arBtnType,
        "REFRESH" => "Y",
    );  
}

if($arCurrentValues["BTN_TYPE"] === "LINK")
{
    $arTemplateParameters["LINK_TEXT"] = array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("LINK_TEXT"),
        "TYPE" => "STRING",
        "DEFAULT" => GetMessage("BTN_TEXT"),
        "REFRESH" => "Y",
    );
}
?>
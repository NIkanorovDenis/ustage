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

$style = array(
    'big' => GetMessage('STYLE_BIG'),
    'small' => GetMessage('STYLE_SMALL'),
    'big_several' => GetMessage('STYLE_BIG_SEVERAL'),
    'small_several' => GetMessage('STYLE_SMALL_SEVERAL')
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
        'STYLE' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage('STYLE'),
            'TYPE' => 'LIST',
            'VALUES' => $style,
            'DEFAULT' => 'small'
        ),
        
);
        
?>
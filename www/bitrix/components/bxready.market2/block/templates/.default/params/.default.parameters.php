<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters["INDEX_SHOW_DESCRIPTION"] = array(
    "PARENT" => "INDEX_SETTINGS",
    "NAME" => GetMessage("INDEX_SHOW_DESCRIPTION"),
    "TYPE" => "CHECKBOX",
    'REFRESH'=>'N',
    'SORT' => 110
);

$arTemplateParameters["INDEX_SHOW_COUNT"] = array(
    "PARENT" => "INDEX_SETTINGS",
    "NAME" => GetMessage("INDEX_SHOW_COUNT"),
    "TYPE" => "CHECKBOX",
    'REFRESH'=>'N',
    'SORT' => 120
);

$arTemplateParameters["INDEX_MAX_LEVEL"] = array(
    "PARENT" => "INDEX_SETTINGS",
    "NAME" => GetMessage("INDEX_MAX_LEVEL"),
    "TYPE" => "STRING",
    "DEFAULT" => 3,
    'SORT' => 130
);

$arTemplateParameters["INDEX_PAGE_TYPE"] = array(
    "PARENT" => "INDEX_SETTINGS",
    "NAME" => GetMessage("INDEX_PAGE_TYPE"),
    "TYPE" => "LIST",
    "VALUES" => array(
        '.default'=>GetMessage("INDEX_PAGE_TYPE_DEFAULT"),
        'two_column'=>GetMessage("INDEX_PAGE_TYPE_TWO_COLUMN")
    ),
    'SORT' => 140
);

$arTemplateParameters["INDEX_ELEMENT_DRAW"] = array(
    "PARENT" => "INDEX_SETTINGS",
    "NAME" => GetMessage("INDEX_ELEMENT_TYPE"),
    "TYPE" => "LIST",
    "VALUES" => array(
        'section.horizontal.v1' => 'section.horizontal.v1'
    ),
    'SORT' => 150
);






<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

switch ($arCurrentValues["BXR_TEMPLATE_TYPE"]) {
    case 'default':
        include ('.default.parameters.php');
        break;
    case 'duplex':
        include ('.duplex.parameters.php');
        break;
    case 'list':
        include ('.list.parameters.php');
        break;
}
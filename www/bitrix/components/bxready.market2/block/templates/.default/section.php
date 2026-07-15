<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Loader,
	Bitrix\Iblock\InheritedProperty;
$this->setFrameMode(true);

$includeAreaName = '';
$includeType = strlen($arParams["BXR_TEMPLATE_TYPE"])>0 ? $arParams["BXR_TEMPLATE_TYPE"] : 'default';

switch ($arParams["BXR_TEMPLATE_TYPE"]) {
    case 'default':
		$includeAreaName = '.default.block.section';
        break;
    case 'duplex':
		$includeAreaName = '.duplex.block.section';
        break;
    case 'list':
		$includeAreaName = '';
        break;
}

if (strlen($includeAreaName)>0){
	include('include_handler.php');
}
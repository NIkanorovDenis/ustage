<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Alexkova\Bxready\Core;

if (intval($arParams["IBLOCK_ID"])<=0){
	return false;
}

global $unicumID;
if ($unicumID<=0) {$unicumID = 1;} else {$unicumID++;}

if (!CModule::IncludeModule('alexkova.bxready2')) return false;

$this->IncludeComponentTemplate();
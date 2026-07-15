<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(\Bitrix\Main\Loader::includeModule("alexkova.bxready2"))
    \Alexkova\Bxready2\Component::prepareParams($arParams, "bxready.market2:menu.hover");
$this->IncludeComponentTemplate();
return $this->__template->__folder;
?>
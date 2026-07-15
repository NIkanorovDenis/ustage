<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!CModule::IncludeModule('alexkova.market2')) return false;

\Alexkova\Bxready2\Component::prepareParams($arParams, "bxready.market2:promo.controller.".$arParams["PROMO_CONTROLLER_TYPE"].".".$arParams["BXR_PROMO_PREPARE_ID"]);

$this->IncludeComponentTemplate();
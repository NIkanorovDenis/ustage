<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<? 
    $APPLICATION->IncludeComponent( 
        "bitrix:catalog.section.list", 
        "index", 
        $arParams, 
        $component 
    );
?>
<? if ($arParams["SHOW_INDEX_ELEMENTS"] == "Y"):?>
    <?$APPLICATION->IncludeComponent( 
        "bitrix:news.list", 
        "", 
        $arParams, 
        $component 
    );?>
<?endif;?> 
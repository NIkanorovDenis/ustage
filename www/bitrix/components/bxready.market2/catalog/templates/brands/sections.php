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
use Alexkova\Market2\Core;

if (isset($arResult["VARIABLES"]["SECTION_CODE"]) && strlen($arResult["VARIABLES"]["SECTION_CODE"])>0)
{
    global $arrFilter;
    $arrFilter["PROPERTY_".$arParams['DETAIL_BRAND_PROP_CODE'][0]] = strval($arResult["VARIABLES"]["SECTION_CODE"]);
}
?>

<?$APPLICATION->IncludeComponent(
    "bxready.market2:catalog.brandblock",
    "brandpage",
    array(
            "IBLOCK_TYPE" => "catalog",
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "ELEMENT_ID" => $arResult["ELEMENT_ID"],
            "ELEMENT_CODE" => $arResult["ELEMENT_CODE"],
            "PROP_CODE" => $arParams["DETAIL_BRAND_PROP_CODE"][0],
            "WIDTH" => "150",
            "HEIGHT" => "80",
            "WIDTH_SMALL" => "150",
            "HEIGHT_SMALL" => "80",
            "CACHE_TYPE" => "N",
            "CACHE_TIME" => "3600",
            "CACHE_GROUPS" => "Y"
    ),
    false,
    array('HIDE_ICONS'=>"Y")
);?>


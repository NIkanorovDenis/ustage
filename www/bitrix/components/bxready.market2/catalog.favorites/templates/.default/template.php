<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$this->setFrameMode(true);

$arParams['FILTER_NAME'] = 'arFavoritesFilter';

if(empty($arResult['FAVORITES_ITEMS']))
{
    ?>
        <p><font class="notetext">В Вашем разделе «Избранное» еще нет сохраненных товаров.</font></p>
    <?
    return false;
}

global $arFavoritesFilter;
$arFavoritesFilter = array('ID' => $arResult['FAVORITES_ITEMS']);

$APPLICATION->IncludeComponent(
    'bxready.market2:catalog.section',
    'bxready',
    $arParams,
    false,
    array('HIDE_ICONS'=>'Y')
);

$elementDraw = \Alexkova\Bxready2\Draw::getInstance($this);
$elementDraw->setCurrentTemplate($this);
$elementDraw->showElement("elements", $arParams['BXR_PRESENT_SETTINGS']["BXREADY_ELEMENT_DRAW"], $arItem, $arParams, true);
$elementDraw->showElement("markers", $arParams['BXR_PRESENT_SETTINGS']["BXREADY_LIST_MARKER_TYPE"], array(), array(), true);
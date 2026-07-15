<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
use Alexkova\Bxready2\Draw;
$elementDraw = \Alexkova\Bxready2\Draw::getInstance($this);

if (isset($arParams["BXREADY_DETAIL_MARKER_TYPE"]) && strlen($arParams["BXREADY_DETAIL_MARKER_TYPE"])>0)
    $markerCollection = $arParams["BXREADY_DETAIL_MARKER_TYPE"];
if (isset($arParams["BXREADY_DETAIL_OWN_MARKER_USE"]) && $arParams["BXREADY_DETAIL_OWN_MARKER_USE"] == "Y"
        && isset($arParams["BXREADY_DETAIL_OWN_MARKER_TYPE"]) && strlen($arParams["BXREADY_DETAIL_OWN_MARKER_TYPE"])>0)
    $markerCollection = $arParams["BXREADY_DETAIL_OWN_MARKER_TYPE"];
if (strlen($markerCollection) > 0)
    $elementDraw->setMarkerCollection($markerCollection);
$elementDraw->showMarkerGroup(array(), true);

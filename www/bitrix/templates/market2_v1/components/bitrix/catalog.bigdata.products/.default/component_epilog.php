<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $templateData */
/** @var @global CMain $APPLICATION */
if (!CModule::IncludeModule('alexkova.bxready2')) return;
use Alexkova\Bxready2\Draw;

global $APPLICATION;
if (isset($templateData['TEMPLATE_THEME']))
{
	$APPLICATION->SetAdditionalCSS($templateData['TEMPLATE_THEME']);
}
CJSCore::Init(array("popup"));

$elementDraw = \Alexkova\Bxready2\Draw::getInstance($this);
$elementDraw->setCurrentTemplate($this->__template);
$elementDraw->showElement("elements", $arParams['BXR_BIGDATA']["BXREADY_ELEMENT_DRAW"], $arItem, $arParams, true);

global $bxreadyMarkers;
$bxreadyMarkers = $arParams['BXR_BIGDATA']["BXREADY_LIST_MARKER_TYPE"];
if (isset($bxreadyMarkers) && strlen($bxreadyMarkers)>0)
	$elementDraw->setMarkerCollection($bxreadyMarkers);
$elementDraw->showMarkerGroup(array(), true);
?>
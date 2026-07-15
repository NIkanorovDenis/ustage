<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>
<?foreach ($arResult['VIDEO'] as $cell=>$val):?>
    <?$elementDraw->showElement('elements', 'video.iframe.list.f3', $val, $arResult["PROPERTIES"]["BXR_VIDEO"]["USER_TYPE_SETTINGS"]);?>
<?endforeach;?>
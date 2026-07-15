<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>
<div class="row">
    <?foreach ($arResult['VIDEO'] as $cell=>$val):?>
        <?
            $elementDraw->showElement('elements', 'video.iframe.table.f3', $val, $arResult["PROPERTIES"]["BXR_VIDEO"]["USER_TYPE_SETTINGS"]);
        ?>
    <?endforeach;?>
</div>
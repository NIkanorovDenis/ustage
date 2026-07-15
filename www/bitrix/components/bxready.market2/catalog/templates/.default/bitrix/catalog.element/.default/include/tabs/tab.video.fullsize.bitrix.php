<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>
<div class="row">
    <?foreach ($arResult['VIDEO'] as $cell=>$val):?>
        <?
            $arResult["PROPERTIES"]["BXR_VIDEO"]["USER_TYPE_SETTINGS"]["fullSize"] = true;
            $elementDraw->showElement('elements', 'video.bitrix.table', $val, $arResult["PROPERTIES"]["BXR_VIDEO"]["USER_TYPE_SETTINGS"]);
        ?>
    <?endforeach;?>
</div>
<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

if($arResult["FILE"] <> '') {?>
    <?
    $floatClass = 'pull-center';
    if ($arParams["FLOAT"] == "RIGHT") $floatClass = 'pull-right'; elseif ($arParams["FLOAT"] == "LEFT") $floatClass = 'pull-left';
    ?>
    <div class="bxr-phone-number <?=$floatClass?>">
        <?$addClass = ($arParams["BTN_TYPE"] == "BTN") ? "bxr-include-with-btn" : "bxr-include-with-link";?>
        <?if ($arParams["SHOW_BTN"] == "Y") {?><div class="<?=$addClass?>"><?}?>
            <?include($arResult["FILE"]);?>
        <?if ($arParams["SHOW_BTN"] == "Y") {?></div><?}?>
        <?if ($arParams["SHOW_BTN"] == "Y" && $arParams["BTN_TYPE"] == "BTN") {?>
            <span class="bxr-color bxr-bg-hover-light fa fa-phone open-answer-form bxr-recall-btn"></span>
        <?}?>
        <?if ($arParams["SHOW_BTN"] == "Y" && $arParams["BTN_TYPE"] == "LINK") {?>
            <div class="clearfix"></div>
            <a class="bxr-font-color bxr-recall-link open-answer-form"><?=$arParams["LINK_TEXT"]?></a>
        <?}?>
    </div>
<?}

if(strlen($arParams["INCLUDE_PTITLE"])>0){
	$t = $component->getIncludeAreaIcons();
	$t[0]["TITLE"] = htmlspecialcharsEx(trim($arParams["INCLUDE_PTITLE"]));
	$component->addIncludeAreaIcons($t);
}

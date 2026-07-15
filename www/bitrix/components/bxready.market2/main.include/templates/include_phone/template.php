<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<?
    $style = "phone-small";
    switch ($arParams["STYLE"]){
        case "big": $style = "phone-big"; break;
        case "small": $style = "phone-small"; break;
        case "big_several": $style = "phone-big phone-several"; break;
        case "small_several": $style = "phone-small phone-several"; break;
    }
?>
<ul class="bxr-phone-block <?=$style;?>">
    <li>
        <?if($arResult["FILE"] <> '') include($arResult["FILE"]);?>
    </li>
</ul>
<?if(strlen($arParams["INCLUDE_PTITLE"])>0){
	$t = $component->getIncludeAreaIcons();
	$t[0]["TITLE"] = htmlspecialcharsEx(trim($arParams["INCLUDE_PTITLE"]));
	$component->addIncludeAreaIcons($t);
}?>
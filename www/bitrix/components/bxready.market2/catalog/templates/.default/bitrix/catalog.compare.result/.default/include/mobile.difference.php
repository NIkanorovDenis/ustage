<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$diffHref = ($arResult["DIFFERENT"]) ? htmlspecialcharsbx($APPLICATION->GetCurPageParam("DIFFERENT=N",array("DIFFERENT"))) : htmlspecialcharsbx($APPLICATION->GetCurPageParam("DIFFERENT=Y",array("DIFFERENT")));
$diffText = ($arResult["DIFFERENT"]) ? GetMessage("CATALOG_ALL_CHARACTERISTICS") : GetMessage("CATALOG_ONLY_DIFFERENT");
?>
<div class="bxr-compare-difference-wrap">
    <a class="bxr-compare-diff" href="<?=$diffHref?>">
        <span class="bxr-compare-checkbox bxr-font-color">
            <?=($arResult["DIFFERENT"]) ? '<i class="fa fa-check" aria-hidden="true"></i>' : '';?>
        </span>
        <?=GetMessage("CATALOG_ONLY_DIFFERENT")?>
    </a>
</div>

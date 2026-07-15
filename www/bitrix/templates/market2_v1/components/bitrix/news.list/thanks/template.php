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
?>
<div class="bl_list">
<ul>
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>

<li id="<?=$this->GetEditAreaId($arItem['ID']);?>">
	
        <a class="img-popup-th" rel="thanks" href="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>">
            <img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?echo $arItem["NAME"]?>" />
        </a>
	
</li>
<?endforeach;?>
</ul>
</div>
<script>
    $(document).ready(function(){
        $(".img-popup-th").fancybox();
    });
</script>
<div class="clearfix"></div>
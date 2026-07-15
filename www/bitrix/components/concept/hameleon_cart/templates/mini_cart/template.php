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



<div class="open-box <?if($arResult["COUNT"] > 0):?>no-empty<?else:?>box-empty<?endif;?> box-show">

	<div class="before_pulse"></div>
	<div class="after_pulse"></div>

    <span class="count"><?=$arResult["COUNT"]?></span>
    <span class="desc-empty"><?=GetMessage('HAM_BOX_EMPTY')?></span>
    <span class="desc-no-empty"><?=GetMessage('HAM_BOX_NO_EMPTY')?></span>

    <?if($arResult["COUNT"] <= 0 && $arParams["LINK_EMPTY_BOX"]):?>
		<a class="box_link scroll" href="<?=$arParams["LINK_EMPTY_BOX"]?>"></a>
	<?endif;?>

</div>



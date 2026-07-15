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


<div class="open-box-mob <?if($arResult["COUNT"] > 0):?>no-empty<?else:?>box-empty<?endif;?>">
	<div class="bg-color"></div>
	<div class="wrap-img-count">
		<table>
			<tr>
				<td><span class="icon"></span></td>
				<td><span class="count"><?=$arResult["COUNT"]?></span></td>
			</tr>
		</table>
    </div>
    <?if($arResult["COUNT"] > 0):?>
		<a class = "box-show"></a>
	<?else:?>
		<a class="box_link <?if(strlen($arParams["LINK_EMPTY_BOX"])>0):?>scroll<?endif;?>" <?if(strlen($arParams["LINK_EMPTY_BOX"])>0):?> href="<?=$arParams["LINK_EMPTY_BOX"]?>"<?endif;?>></a>
	<?endif;?>

	
</div>



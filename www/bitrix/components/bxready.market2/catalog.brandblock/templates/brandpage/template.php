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

if (empty($arResult["BRAND_BLOCKS"]))
	return;

?>

<div class="row brand-list bxr-m20">
    <?foreach ($arResult["BRAND_BLOCKS"] as $arBrand):
            if (strlen($arBrand["LINK"])>0 && $arBrand["ACTIVE"]){
            ?>
            <div class="col-lg-2 col-lg-3 col-md-3 col-sm-4 col-xs-6 brand-cart">
                <a href="<?=str_replace("//","/", SITE_DIR.$arBrand["LINK"])?>" class="brand-image"><div>
                    <img src="<?=$arBrand["PICT"]["SRC"]?>" alt="<?=$arBrand["NAME"]?>" title="<?=$arBrand["NAME"]?>">
                </div></a>
            </div>
    <?
    }
    endforeach;?>
</div>
<div class="clearfix"></div>

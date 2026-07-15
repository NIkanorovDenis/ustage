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

if ($APPLICATION->GetCurPage() == '/articles/') {
    $title = 'Статьи';
} else {
    $title = '<a href="/articles/">Статьи</a>';
} ?>

<div class="h2"><?= $title ?></div>
    <div class="articles__list">
    <?foreach($arResult["ITEMS"] as $arItem):?>
        <?
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        
        $articlesTumb = $arItem['PREVIEW_PICTURE']['ID'];
        $articlesTumbSrc = CFile::ResizeImageGet($articlesTumb, array("width" => 228, "height" => 130), BX_RESIZE_IMAGE_PROPORTIONAL, false, array());
        ?>
            <div class="articles__item t_3 bxr-auto-height item_pr" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                <div class="articles__item-img bxr-element-img">
                    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img class="preview_picture" src="<?= $articlesTumbSrc['src']; ?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>" title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
                    /></a>
                </div>
                <div class="articles__item-title bxr-element-name bxr-children-color-hover">
                    <a class="bxr-gray-content bxr-font-color-hover" href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a>
                </div>
            </div>
    <?endforeach;?>
    </div>

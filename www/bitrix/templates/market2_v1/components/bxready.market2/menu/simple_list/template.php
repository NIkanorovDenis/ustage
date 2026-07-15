<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);
global $USER, $containerXlClass;?>

<?if (!empty($arResult)):?>

    <ul id="bxr-multilevel-menu" data-child="0">
<?
        $previousLevel = 0;
        $isPreviousParent = false;

        foreach($arResult as $cell=>$arItem):?>
            <?
            $normalizedLevel = $arItem['DEPTH_LEVEL'];

            if ($previousLevel) {
                if ($isPreviousParent) {
                if ($normalizedLevel > $previousLevel && ($normalizedLevel - $previousLevel) > 1) {
                    $normalizedLevel = $previousLevel + 1;
                }
                } elseif ($normalizedLevel > $previousLevel) {
                $normalizedLevel = $previousLevel;
                }
            }
            ?>

            <?if ($previousLevel && $normalizedLevel < $previousLevel): ?>
                <?=str_repeat("</ul></li>", ($previousLevel - $normalizedLevel));?>
            <?endif?>

            <?if ($arItem["IS_PARENT"]):
                $oldparent = $cell;
                $parent = $cell++;
            ?>
            
                <li class="parent 1 " data-depth="<?= $normalizedLevel ?>" data-parent="<?=$parent?>" data-child="<?=$oldparent?>">
                    <? if ($arItem["PARAMS"]["ico_dark"]): ?>
                        <span class='444 bxr-ico-left-hover-menu'>
                            <? $img = CFile::ResizeImageGet($arItem["PARAMS"]["ico_dark"], array('width'=>32, 'height'=>32), BX_RESIZE_IMAGE_PROPORTIONAL, true); ?>
                            <img  src='<?=$img['src']?>' alt='<?=$arItem["TEXT"]?>'>
                        </span>
                    <? endif; ?>
                        <a href="<?=$arItem["LINK"]?>" class="link-text"><?=$arItem["TEXT"]?> </a>
                    <span class="direction fa fa-chevron-right"></span>
                

          
                    <ul class="content-child" data-parent="<?=$parent?>"  data-child="<?=$oldparent?>">

            <?else:?>
                <li data-depth="<?= $normalizedLevel ?>"><a href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?>root-item-selected<?else:?>root-item<?endif?>"><? if ($arItem["PARAMS"]["ico_dark"]): ?><span class='555 bxr-ico-left-hover-menu'><? $img = CFile::ResizeImageGet($arItem["PARAMS"]["ico_dark"], array('width'=>32, 'height'=>32), BX_RESIZE_IMAGE_PROPORTIONAL, true); ?><img  src='<?=$img['src']?>' alt='<?=$arItem["TEXT"]?>'></span><? endif; ?> <?=$arItem["TEXT"]?></a></li>
            <?endif?>

            <?$previousLevel = $normalizedLevel;?>
            <?$isPreviousParent = $arItem["IS_PARENT"];?>
        <?endforeach?>

        <?if ($previousLevel > 1)://close last item tags?>
                <?=str_repeat("</ul>", ($previousLevel-1) );?>
        <?endif?>
    </ul>
    </li>
            
<?endif?>


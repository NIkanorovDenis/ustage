<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?if (!empty($arResult)):?>
    <?$previousLevel = 0;?>
    <ul class="bxr-topline-menu">
        <?foreach($arResult as $arItem):
	$hiddenClass = ($arItem["PARAMS"]["hidden-md"] == "Y") ? "hidden-md" : "";
        
            if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
                continue;
        
            if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):
		echo str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));
            endif;
            
            if ($arItem["IS_PARENT"]):?>
                <li class="bxr-children <?=$hiddenClass?>">
                    <a href="<?=$arItem["LINK"]?>" class="<?=($arItem["SELECTED"] == "1")?"selected":""?> bxr-font-color-hover bxr-font-color-light"><?=$arItem["TEXT"]?></a>
                <ul>                
            <?else:?>
                <?if ($arItem["PERMISSION"] > "D"):?>
                    <li class="<?=$hiddenClass?>">
                        <a href="<?=$arItem["LINK"]?>" class="<?=($arItem["SELECTED"] == "1")?"selected":""?> bxr-font-color-hover bxr-font-color"><?=$arItem["TEXT"]?></a>
                    </li>
		<?endif?>
            <?endif;?>                    
            <?$previousLevel = $arItem["DEPTH_LEVEL"];?>
        <?endforeach?>
                    
        <?if ($previousLevel > 1):?>
            <?=str_repeat("</ul></li>", ($previousLevel-1) );?>
        <?endif?>                    
                    
    </ul>
    <div class="clearfix"></div>
<?endif?>
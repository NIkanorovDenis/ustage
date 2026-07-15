<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>
<div class="row">
    <?$firstTab = true;?>
    <div class="col-xs-12">
        <?foreach ($arTabs['TABS'] as $cell=>$val):
            if (in_array($cell, $arResult["TABS"]["EPILOG"])) continue;
            if ($arResult["TABS"]["ECHO"][$cell])
                echo $arResult["TABS"]["ECHO"][$cell];?>
            <?$tab=$arTabs['DETAIL'][$cell]['PATH'];?>
            <?if (file_exists($tab)):?>
                <div class="bxr-detail-tab-title bxr-detail<?=($cell == "GIFT")?" bxr-hidden":""?>" data-scroll="<?=$cell?>">
                    <?if (strlen($arTabs['DETAIL'][$cell]['GLYPH'])>0):?>
                        <span class="<?=$arTabs['DETAIL'][$cell]['GLYPH']?>"></span>
                    <?endif;?>
                    <?=$arTabs['DETAIL'][$cell]['CAPTION']?>
                </div>
                <div class="bxr-detail-tab bxr-detail-tab-list" data-tab="<?=$cell?>">
                    <?include($tab);?>
                </div>
            <?endif;?>
        <?endforeach;?>
    </div>
</div>
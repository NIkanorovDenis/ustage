<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->createFrame()->begin("");
global $arSortGlobal;

$numShow = ('Y' == $arParams["PAGE_ELEMENT_COUNT_SHOW"]);
$viewShow = ('Y' == $arParams["CATALOG_VIEW_SHOW"]);
$sortOrderHelp = ($arSortGlobal["sort_order"] == 'asc') ? GetMessage('SORT_ASC') : GetMessage('SORT_DESC');
$sortToOrderHelp = ($arSortGlobal["sort_order"] == 'desc') ? GetMessage('SORT_ASC') : GetMessage('SORT_DESC');
?>
<div class="h4 bxr-hidden-mobile-btn visible-xs"><span><?=GetMessage("SHOW_SORT")?></span><i class="fa fa-angle-down"></i></div>
<div class="bxr-sort-panel">
    <div class="row">
        <div class="col-xs-12 col-sm-<?=$numShow?'5':'6'?> col-md-4 col-xl-3 text-xs-right text-md-left">
			<span class="hidden-sm hidden-lg hidden-md bxr-sort-title"><?=GetMessage("SORT_ORDER_TITLE")?></span>
            <div class="bxr-sort-direction-wrap bxr-bordered">
                <span class="bxr-current-sort"><?=$arResult["SORT_PROPS"][$arSortGlobal["sort"]][2]?><?=$sortOrderHelp?></span>
                <i class="bxr-direction-wrap-open fa fa-angle-down"></i>
                <div class="bxr-sort-type-wrap">
                    <?foreach ($arResult["SORT_PROPS"] as $key => $val):
                        $className = ($arSortGlobal["sort"] == $val[0]) ? ' active' : '';
                        $icon = "";
                        if ($className){
                            $className .= ($arSortGlobal["sort_order"] == 'asc') ? ' asc' : ' desc';
                            $icon = ($arSortGlobal["sort_order"] == 'asc') ? '<i class="fa fa-angle-up"></i>' : ' <i class="fa fa-angle-down"></i>';
                        }
                        if (strlen($val[3])>0)
                            $className .= " ".$val[3];
                        $newSort = ($arSortGlobal["sort"] == strtoupper($val[0])) ? ($arSortGlobal["sort_order"] == 'desc' ? 'asc' : 'desc') : 'asc';
                        ?>
                        <a href="<?=$APPLICATION->GetCurPageParam('sort='.$key.'&order='.$newSort, array('sort', 'order'))?>"
                       class="bxr-sortbutton<?=$className?> <?if(number_key($arResult["SORT_PROPS"], $key) == count($arResult["SORT_PROPS"])) echo "last";?>" rel="nofollow">
                            <?=$val[2]?><?=($arSortGlobal["sort"] == strtoupper($val[0]))?$sortToOrderHelp:GetMessage('SORT_ASC')?>
                        </a>
                    <?endforeach;?>
                </div>
            </div>
        </div>
        <?if ($numShow):?>
            <div class="col-xs-12 col-sm-<?=$viewShow?'4':'4'?> col-md-<?=$viewShow?'5':'7'?> col-xl-6">
                <span class="bxr-sort-title"><?=GetMessage("KZNC_SORT_COUNT_NAME")?></span>
                <div class="bxr-sort-num-direction-wrap bxr-bordered">
                    <?=$arSortGlobal["num"]?>
                    <i class="bxr-direction-wrap-open fa fa-angle-down"></i>
                    <div class="bxr-sort-num-wrap">
                        <? foreach ($arParams["PAGE_ELEMENT_COUNT_LIST"] as $val) :?>
                            <?if ($val > 0):?>
                                <a href="<?=$APPLICATION->GetCurPageParam('num='.$val,array('num'));?>" title="<?=GetMessage('KZNC_VIEW_BY')." ".$val." ".GetMessage('KZNC_ITEM_NAME').NumberWordEndingsEx($val)?>" class="bxr-sort-num<?=($arSortGlobal["num"] == $val) ? ' active' : '';?>">
                                    <?=$val;?>
                                </a>
                            <?endif;?>
                        <?endforeach;?>
                    </div>
                </div>
            </div>
        <?endif;?>
        <?if ($viewShow):?>
            <div class="col-xs-12 col-sm-<?=$numShow?'3':'6'?> col-md-<?=$numShow?'3':'8'?> col-xl-<?=$numShow?'3':'9'?> text-right">
                <span class="hidden-sm hidden-lg hidden-md bxr-sort-title"><?=GetMessage("KZNC_SORT_VIEW_NAME")?></span>
                <a href="<?=$APPLICATION->GetCurPageParam('view=title',array('view'));?>" title="<?=GetMessage('KZNC_VIEW_PLITKA')?>" class="bxr-view-mode bxr-border-color-hover bxr-font-color-hover<?=($arSortGlobal['view'] == 'title' || !$arSortGlobal['view']) ? ' active bxr-color' : '';?>">
                    <i class="fa fa-th"></i>
                </a>
                <a href="<?=$APPLICATION->GetCurPageParam('view=list',array('view'));?>" title="<?=GetMessage('KZNC_VIEW_LIST')?>" class="bxr-view-mode bxr-border-color-hover bxr-font-color-hover<?=($arSortGlobal['view'] == 'list') ? ' active bxr-color' : '';?>">
                    <i class="fa fa-th-list"></i>
                </a>
                <a href="<?=$APPLICATION->GetCurPageParam('view=table',array('view'));?>" title="<?=GetMessage('KZNC_VIEW_TABLE')?>" class="bxr-view-mode bxr-border-color-hover bxr-font-color-hover<?=($arSortGlobal['view'] == 'table') ? ' active bxr-color' : '';?>">
                    <i class="fa fa-align-justify"></i>
                </a>
            </div>
        <?endif;?>
    </div>
</div>
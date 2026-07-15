<?if (count($arResult['SMART_LINK'])) {
    $isList = ($arParams['BXR_DETAIL_TABS']['BXR_DETAIL_TAB_TYPE'] == 'list') ? true : false;?>
    <div id="bxr-left-col" class="bxr-detail-smart-links hidden-xs">
        <ul>
            <?  
            $firstLink = true;
            foreach ($arResult['SMART_LINK'] as $arLink) {
                if ($arLink["LINK"] == "" || $arLink["GLYPH"] == "") continue;?>
                <li data-tab="<?=$arLink["LINK"]?>" class="bxr-color-hover<?=($firstLink)?' active':''?>"<?=($isList)?' data-type="all"':''?>>
                    <i class="<?=$arLink["GLYPH"]?>"></i>
                    <span class="bxr-color-dark bxr-smart-link-tooltip"><?=$arLink["NAME"]?></span>
                </li>
            <?            
                $firstLink = false;
            }?>
            <li class="clearfix"></li>
        </ul>
    </div>
<?}?>

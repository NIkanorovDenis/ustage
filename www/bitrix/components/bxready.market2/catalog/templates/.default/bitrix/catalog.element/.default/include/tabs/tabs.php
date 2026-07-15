<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>
<div class="row">
    <?$firstTab = true;?>
    <div class="col-xs-12 hidden-xs">
        <?$additionalTabClass = ($arParams['BXR_DETAIL_TABS']['BXR_DETAIL_TAB_VIEW'] == 'tabs') ? " bxr-detail-tabs-slider" : "";
        $additionalTabClass .= ($arParams['BXR_DETAIL_TABS']['BXR_DETAIL_TAB_VIEW'] == 'tabs' && $arParams['BXR_DETAIL_TABS']['BXR_DETAIL_TAB_VIEW_TABS_COLOR'] == 'light') ? " bxr-detail-tabs-slider-light" : ""?>
        <div class="bxr-detail-tabs<?=$additionalTabClass?>">
            <?foreach ($arTabs['TABS'] as $cell=>$val):?>
                <?$tab=$arTabs['DETAIL'][$cell]['PATH'];?>
                <?if (file_exists($tab)):?>
					<div  data-tab="<?=$cell?>" class="bxr-detail-tab-div <?=($firstTab) ? 'active' : ''?>
                         <?=($arParams['BXR_DETAIL_TABS']['BXR_DETAIL_TAB_VIEW'] == 'tabs' && $arParams['BXR_DETAIL_TABS']['BXR_DETAIL_TAB_VIEW_TABS_COLOR'] == 'color')?" bxr-color bxr-color-dark-hover":" bxr-border-color-hover bxr-font-color-hover"?>">
                        <?if (strlen($arTabs['DETAIL'][$cell]['GLYPH'])>0):?>
                            <span class="<?=$arTabs['DETAIL'][$cell]['GLYPH']?>"></span>
                        <?endif;?>
						<?if ($arTabs['DETAIL'][$cell]['CAPTION']):?>
                        	<?=$arTabs['DETAIL'][$cell]['CAPTION']?>
						<?else:?>
							<?=GetMessage($cell)?>
						<?endif;?>
                    </div>
                <?endif;?>
                <?if ($firstTab) $firstTab = false;?>
            <?endforeach;?>
        </div>
    </div>

    <?$firstTab = true;?>
    <div class="col-xs-12<?=($arParams['BXR_DETAIL_TABS']['BXR_DETAIL_TAB_VIEW'] == 'tabs')?" bxr-initial":""?>">
        <?if ($arParams['BXR_DETAIL_TABS']['BXR_DETAIL_TAB_VIEW'] == 'tabs') {?><hr class="bxr-detail-tab-hr"><?}?>
        <?foreach ($arTabs['TABS'] as $cell=>$val):
            if (in_array($cell, $arResult["TABS"]["EPILOG"])) continue;
            if ($arResult["TABS"]["ECHO"][$cell])
                echo $arResult["TABS"]["ECHO"][$cell];?>
            <?$tab=$arTabs['DETAIL'][$cell]['PATH'];?>
            <?if (file_exists($tab)):?>
                <div class="bxr-detail-tab<?=($arParams['BXR_DETAIL_TABS']['BXR_DETAIL_TAB_VIEW'] == 'tabs')?" bxr-detail-tab-shadow":""?>" data-tab="<?=$cell?>"<?if($firstTab) echo 'style="display: block"'?>>
                    <div class="bxr-detail-tab-title hidden-sm hidden-md hidden-lg">
                        <?if (strlen($arTabs['DETAIL'][$cell]['GLYPH'])>0):?>
                            <span class="<?=$arTabs['DETAIL'][$cell]['GLYPH']?>"></span>
                        <?endif;?>
                        <?=$arTabs['DETAIL'][$cell]['CAPTION']?>
                    </div>
                    <div class="bxr-detail-tab-content">
                        <?include($tab);?>
                    </div>
                </div>
            <?endif;?>
            <?if ($firstTab) $firstTab = false;?>
        <?endforeach;?>
    </div>
</div>
<?if ($arParams['BXR_DETAIL_TABS']['BXR_DETAIL_TAB_VIEW'] == 'tabs' || $arParams['BXR_DETAIL_TABS']['BXR_DETAIL_TAB_VIEW'] == 'links') {?>
    <script>
    $(document).ready(function() {
        var maxLength = parseInt($('.bxr-detail-tabs').css('width'));
        var curLength = 0; var tabCnt = 0;
        for (i=$('.bxr-detail-tab-div').length-1;i>-1;i--) {
            curLength += (parseInt($($('.bxr-detail-tab-div')[i]).css('width')));
            tabCnt++;
            if (curLength >= maxLength) {
				tabCnt--;
				break;
			}
        }
        prevBtn = '<button type="button" class="slick-prev slick-arrow slick-tabs-arrow slick-tabs-arrow-prev <?=($arParams["BXR_DETAIL_TABS"]["BXR_DETAIL_TAB_VIEW"] == 'tabs')?" bxr-color bxr-color-dark-hover":" bxr-border-color-hover bxr-font-color-hover"?> fa fa-chevron-left"></button>';
        nextBtn = '<button type="button" class="slick-prev slick-arrow slick-tabs-arrow slick-tabs-arrow-next <?=($arParams["BXR_DETAIL_TABS"]["BXR_DETAIL_TAB_VIEW"] == 'tabs')?" bxr-color bxr-color-dark-hover":" bxr-border-color-hover bxr-font-color-hover"?> fa fa-chevron-right"></button>';
        $('.bxr-detail-tabs').slick({
                dots: false,
                infinite: false,
                speed: 300,
                slidesToShow: tabCnt,
                centerMode: false,
                variableWidth: true,
                prevArrow: prevBtn,
                nextArrow: nextBtn,
//                slide: 'li'
        });
    });
    </script>
<?}?>
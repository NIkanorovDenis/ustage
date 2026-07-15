<?if(isset($arParams["USE_VOTE_RATING"]) && $arParams["USE_VOTE_RATING"]=="Y"):?>
<div class="bxr-rating-detail"<?=($arResult["PROPERTIES"]["rating"]["VALUE"] > 0)?' itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating"':''?>>
    <?if($arResult["PROPERTIES"]["rating"]["VALUE"] > 0) :

        if($arParams["VOTE_DISPLAY_AS_RATING"] == "vote_avg")
        {
                if(!empty($arResult["PROPERTIES"]["vote_count"]["VALUE"]) && $arResult["PROPERTIES"]["vote_count"]["VALUE"]>0 && $arResult["PROPERTIES"]["vote_count"]["VALUE"])
                        $votesValue = round($arResult["PROPERTIES"]["vote_sum"]["VALUE"]/$arResult["PROPERTIES"]["vote_count"]["VALUE"], 2);
                else
                        $votesValue = 0;
        }
        else
        {
                $votesValue = round($arResult["PROPERTIES"]["rating"]["VALUE"]);
        }        
        
        ?>
        <meta itemprop="ratingValue" content="<?=$votesValue;?>">
        <meta itemprop="ratingCount" content="<?=$arResult["PROPERTIES"]["vote_count"]["VALUE"]?>">
    <?	endif;?>
    <?$APPLICATION->IncludeComponent(
        "bitrix:iblock.vote",
        "stars",
        array(
                "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
                "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                "ELEMENT_ID" => $arResult['ID'],
                "ELEMENT_CODE" => "",
                "MAX_VOTE" => "5",
                "VOTE_NAMES" => array("1", "2", "3", "4", "5"),
                "SET_STATUS_404" => "N",
                "DISPLAY_AS_RATING" => $arParams['VOTE_DISPLAY_AS_RATING'],
                "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                "CACHE_TIME" => $arParams['CACHE_TIME']
        ),
        $component,
        array("HIDE_ICONS" => "Y")
    );?>
</div>
<?endif;?>
<?if ($arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]) {?>
    <div class="bxr-article">
        <?=GetMessage("BXR_CML2_ARTICLE").$arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]?>
    </div>
<?}?>
<div class="clearfix"></div>
<table class="bxr-compare-props-table<?=($arResult["DIFFERENT"])?" bxr-compare-only-diff":""?>">
    <tbody>
        <?foreach($arResult["SHOW_PROPERTIES"] as $code=>$field):
            $arCompare = Array();
            foreach($arResult["ITEMS"] as $arElement)
            {
                $arPropertyValue = $arElement["DISPLAY_PROPERTIES"][$code]["VALUE"];
                if(is_array($arPropertyValue))
                {
                    sort($arPropertyValue);
                    $arPropertyValue = implode(" / ", $arPropertyValue);
                }
                $arCompare[] = $arPropertyValue;
            }
            $diff = (count(array_unique($arCompare)) > 1 ? true : false);
            if($diff || !$arResult["DIFFERENT"]):?>
                <tr class="bxr-compare-property-name-tr">
                    <td colspan="2" class="bxr-compare-property-name"><?=$field["NAME"]?></td>
                </tr>
                <tr class="bxr-compare-property-value-tr">
                    <td class="bxr-compare-property-value-td bxr-compare-property-value-td-left<?=(count($arResult["ITEMS"]) == 1)?" bxr-compare-property-value-td-one":""?>">
                        <?foreach($arResult["ITEMS"] as $arElement):?>
                            <div class="bxr-compare-property-value" data-item="<?=$arElement["ID"]?>">
                                <?if(is_array($arElement["PROPERTIES"][$code]["VALUE"])) $arElement["PROPERTIES"][$code]["VALUE"] = implode(', ',$arElement["PROPERTIES"][$code]["VALUE"]);?>

                                <?if ($arElement["PROPERTIES"][$code]["USER_TYPE"] === "HTML"):?>
                                    <?=($arElement["PROPERTIES"][$code]["~VALUE"]["TEXT"])?:'—'?>
                                <?else:?>
                                    <?if (is_array($arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])):?>
                                        <?foreach($arElement["DISPLAY_PROPERTIES"][$code]["DESCRIPTION"] as $propKey => $propDescription):?>
                                            <p><?=($arElement["DISPLAY_PROPERTIES"][$code]['WITH_DESCRIPTION'] == "Y" ? "<b>".$propDescription." : </b>" : "")?><?=$arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"][$propKey]?></p>
                                        <?endforeach;?>
                                    <?else:?>
                                        <?=($arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])?:'—'?>
                                    <?endif?>
                                <?endif?>
                            </div>
                        <?endforeach;?>
                    </td>
                    <?if (count($arResult["ITEMS"]) > 1) {?>
                        <td class="bxr-compare-property-value-td bxr-compare-property-value-td-right">
                            <?foreach($arResult["ITEMS"] as $arElement):?>
                                <div class="bxr-compare-property-value" data-item="<?=$arElement["ID"]?>">
                                    <?if(is_array($arElement["PROPERTIES"][$code]["VALUE"])) $arElement["PROPERTIES"][$code]["VALUE"] = implode(', ',$arElement["PROPERTIES"][$code]["VALUE"]);?>

                                    <?if ($arElement["PROPERTIES"][$code]["USER_TYPE"] === "HTML"):?>
                                        <?=($arElement["PROPERTIES"][$code]["~VALUE"]["TEXT"])?:'—'?>
                                    <?else:?>
                                        <?if (is_array($arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])):?>
                                            <?foreach($arElement["DISPLAY_PROPERTIES"][$code]["DESCRIPTION"] as $propKey => $propDescription):?>
                                                <p><?=($arElement["DISPLAY_PROPERTIES"][$code]['WITH_DESCRIPTION'] == "Y" ? "<b>".$propDescription." : </b>" : "")?><?=$arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"][$propKey]?></p>
                                            <?endforeach;?>
                                        <?else:?>
                                            <?=($arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])?:'—'?>
                                        <?endif?>
                                    <?endif?>
                                </div>
                            <?endforeach;?>
                        </td>
                    <?}?>
                </tr>
            <?endif?>
        <?endforeach;?>
    </tbody>
</table>
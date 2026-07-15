<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (is_array($arResult["FAVOR_ITEMS"]) && count($arResult["FAVOR_ITEMS"])>0){?>
    <div class="basket-body-title">
        <span class="basket-body-title-h tab-favor bxr-font-color"><?=GetMessage('FAVOR_TITLE')?>
            <?if(count($arResult["FAVOR_ITEMS"])>0):?>
                <span class="bxr-basket-cnt bxr-color"><?=count($arResult["FAVOR_ITEMS"])?></span>
            <?endif;?>
        </span>
        <div class="clearfix"></div>
    </div>
    <div class="bxr-content-scroll" data-tab="favor">
        <table>
            <tr>
                <th colspan="2" class="first" ><?=GetMessage('BASKET_TD_NAME')?></th>
                <th class="last">&nbsp;</th>
            </tr>
            <?foreach($arResult["FAVOR_ITEMS"] as $arFavorItem):

                $pictureID = (!empty($arResult["CATALOG"][$arFavorItem["ID"]]["PREVIEW_PICTURE"])) ? $arResult["CATALOG"][$arFavorItem["ID"]]["PREVIEW_PICTURE"] : "";
                $pictureID = (empty($pictureID) && !empty($arResult["CATALOG"][$arFavorItem["ID"]]["DETAIL_PICTURE"])) ? $arResult["CATALOG"][$arFavorItem["ID"]]["DETAIL_PICTURE"] : $pictureID;

                if (!empty($pictureID)){
                    $metrics = array('width' => 54, 'height' => 54) ;
                    $resizedImage = \CFile::ResizeImageGet($pictureID, $metrics, BX_RESIZE_IMAGE_PROPORTIONAL, true);
                    if (strlen($resizedImage["src"])>0) 
                        $img = $resizedImage["src"];
                    else
                        $img = $arFavorItem["PICTURE"];
                } 
                else {
                    $img = $arFavorItem["PICTURE"];
                }

                $img = (strlen($img)>0)
                    ? '<a href="'.$arFavorItem["URL"].'"
                            style="background: url('.$img.') no-repeat center center;
                            background-size: contain;
                            " title="'.$arFavorItem["NAME"].'" alt="'.$arFavorItem["NAME"].'"></a>'
                    : "&nbsp;";                    
                ?>
                <tr>
                    <td class="basket-image first"><?=$img?></td>
                    <td class="basket-name xs-hide"><a href="<?=$arFavorItem["URL"]?>" class="bxr-font-hover-light"><?=$arFavorItem["NAME"]?></a></td>
                    <td class="basket-action-row last">
                        <form class="bxr-basket-action bxr-basket-group" action="">
                            <button class="bxr-indicator-item bxr-basket-favor-delete icon-button-delete" data-item="<?=$arFavorItem["ID"]?>" tabindex="0" title="<?=GetMessage("SALE_DELETE")?>">
                                <span class="fa fa-close"></span>
                            </button>
                            <input type="hidden" name="item" value="<?=$arFavorItem["ID"]?>" tabindex="0">
                            <input type="hidden" name="action" value="favor" tabindex="0">
                            <input type="hidden" name="favor" value="yes" tabindex="0">
                        </form>
                    </td>
                </tr>
            <?endforeach;?>
        </table>
    </div>
    <div class="basket-footer">
        <div><a href="<?=$arParams["BXR_FAVORITES_LINK"]?>" class="bxr-color-button"><?=GetMessage('BXR_FAVORITES_NAME')?></a></div>
    </div>
<?}else{?>
    <p class="bxr-helper bg-info">
        <?=GetMessage('FAVOR_EMPTY')?>
    </p>
<?}?>
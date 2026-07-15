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
if (isset($_REQUEST['ajaxbuy']) && $_REQUEST['ajaxbuy'] == "yes"){$APPLICATION->RestartBuffer();}

//$this->setFrameMode(true);
$containerId = "bxr-counter-compare-new";
$addClass = 'class="display:none"';
$_SESSION["BXR_COMPARE_PARAMS"] = $arParams;
?>
<?if (!isset($_REQUEST['ajaxbuy']) || $_REQUEST['ajaxbuy'] != "yes"):?>
	<?$containerId = "bxr-counter-compare";?>
	<?$addClass = '';?>
<?else:?>
	<?$containerId = "bxr-counter-compare-new";?>
<?endif;?>
<a href="javascript:void(0)" class="bxr-basket-indicator compare-button-group bxr-font-hover-light bxr-compare-label" id="<?=$containerId?>" <?=$addClass?> data-child="bxr-compare-body" title="<?=GetMessage("COMPARE_TITLE")?>">
    <i class="fa fa-bar-chart"></i>
    <?if (!empty($arResult["ITEMS"])) {?>
        <div class="basket-items-cnt bxr-color">
            <?=count($arResult["ITEMS"])?>
        </div>
    <?}?>
</a>
<?if (!isset($_REQUEST['ajaxbuy']) || $_REQUEST['ajaxbuy'] != "yes"):?>
    <div id="bxr-compare-body" class="basket-body-container"  data-group="basket-group">
<?endif;?>
        <div id="bxr-compare-jdata" style="display: none"><?=json_encode($arResult["JSON"])?></div>
		<?if (!empty($arResult["ITEMS"])) {?>
            <div class="basket-body-title">
                <span class="basket-body-title-h tab-favor bxr-font-color"><?=GetMessage('COMPARE_TITLE')?>
                    <?if(count($arResult["ITEMS"])>0):?>
                        <span class="bxr-basket-cnt bxr-color"><?=count($arResult["ITEMS"])?></span>
                    <?endif;?>
                </span>
                <div class="clearfix"></div>
            </div>
            <div class="basket-body-table">
                <div class="bxr-content-scroll">
                    <table>
                        <?foreach($arResult["ITEMS"] as $arBasketItem):
                            
                            $pictureID = (!empty($arResult["DATA"][$arBasketItem["ID"]]["PREVIEW_PICTURE"])) ? $arResult["DATA"][$arBasketItem["ID"]]["PREVIEW_PICTURE"] : "";
                            $pictureID = (empty($pictureID) && !empty($arResult["DATA"][$arBasketItem["ID"]]["DETAIL_PICTURE"])) ? $arResult["DATA"][$arBasketItem["ID"]]["DETAIL_PICTURE"] : $pictureID;

                            if (!empty($pictureID)){
                                $metrics = array('width' => 54, 'height' => 54) ;
                                $resizedImage = \CFile::ResizeImageGet($pictureID, $metrics, BX_RESIZE_IMAGE_PROPORTIONAL, true);
                                if (strlen($resizedImage["src"])>0) 
                                    $img = $resizedImage["src"];
                            } 

                            $img = (strlen($img)>0)
                                ? '<a href="'.$arBasketItem["DETAIL_PAGE_URL"].'"
                                        style="background: url('.$img.') no-repeat center center;
                                        background-size: contain;
                                        " title="'.$arBasketItem["NAME"].'" alt="'.$arBasketItem["NAME"].'"></a>'
                                : "&nbsp;";

                            ?>
                            <tr>
                                <td class="basket-image first"><?=$img?></td>
                                <td class="basket-name xs-hide"><a href="<?=$arBasketItem["DETAIL_PAGE_URL"]?>" class="bxr-font-hover-light"><?=$arBasketItem["NAME"]?></a></td>
                                <td class="basket-action last">
                                    <button id="button-delay-<?=$arBasketItem["ID"]?>" class="compare-button-delete bxr-indicator-item icon-button-delete" value="" data-item="<?=$arBasketItem["ID"]?>" title="<?=GetMessage("SALE_DELETE")?>">
                                        <span class="fa fa-close" ></span>
                                    </button>
                                </td>
                            </tr>
                        <?endforeach;?>
                    </table>
                </div>
            </div>
            <div class="basket-footer">
                <div><a href="<?=$arParams["COMPARE_URL"]?>" class="bxr-color-button"><?=GetMessage('COMPARE_STATE_NAME')?></a></div>
            </div>
        <?}else{?>
            <p class="bxr-helper bg-info"><?=GetMessage('COMPARE_EMPTY')?></p>
        <?}?>
<?if (isset($_REQUEST['ajaxbuy']) && $_REQUEST['ajaxbuy'] == "yes"){die();}?>
    </div>
<script>
    $(document).ready(function(){
        BXRCompare = window.BXReady.Market.Compare;
        BXRCompare.ajaxURL = '<?=$templateFolder;?>/ajax/bxr_compare.php';
        BXRCompare.messList = '<?=GetMessage('CT_BCE_CATALOG_COMPARE_LIST')?>';
        BXRCompare.mess = '<?=GetMessage('CT_BCE_CATALOG_COMPARE')?>';
        BXRCompare.iblockID = '<?=$arParams['IBLOCK_ID']?>';
        BXRCompare.startDataCompare = <?=json_encode($arResult["JSON"])?>;
        BXRCompare.init();
    });
</script>
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?

use Alexkova\Bxready2\Draw
    , Alexkova\Market2\Bxmarket;

$elementDraw = \Alexkova\Bxready2\Draw::getInstance($this);
$elementDraw->setCurrentTemplate($this);

$this->setFrameMode(true);

$elementTemplate = ".default";

global $unicumID;
if ($unicumID<=0) {$unicumID = 1;} else {$unicumID++;}

$thisUncumId =  $unicumID.'_related';

$arParams["UNICUM_ID"] = $thisUncumId;

$colToElem = array();
$bootstrapGridCount = $arParams["BXREADY_LIST_BOOTSTRAP_GRID_STYLE"];
if ($bootstrapGridCount>0) {
	for($i=1; $i<=$bootstrapGridCount; $i++) {
		if (($bootstrapGridCount % $i) == 0)
			$colToElem[$bootstrapGridCount / $i] = $i;
	}
}

if(!isset($arParams["BXREADY_LIST_BOOTSTRAP_GRID_STYLE"]))
    $arParams["BXREADY_LIST_BOOTSTRAP_GRID_STYLE"] = 12;

$coreData = Bxmarket::getInstance()->getCoreData();

$coreData['lg_breakpoint'] = intval($coreData['lg_breakpoint'])>0 ? $coreData['lg_breakpoint'] : 1919;
if ($arParams["md_breakpoint"]):
    $coreData['md_breakpoint'] = $arParams["md_breakpoint"];
else:
    $coreData['md_breakpoint'] = intval($coreData['md_breakpoint'])>0 ? $coreData['md_breakpoint'] : 1199;
endif; 
$coreData['sm_breakpoint'] = intval($coreData['sm_breakpoint'])>0 ? $coreData['sm_breakpoint'] : 991;
$coreData['xs_breakpoint'] = intval($coreData['xs_breakpoint'])>0 ? $coreData['xs_breakpoint'] : 761;
?>
<?if (count($arResult["ITEMS"]) > 0):?>
    <?if ($arParams["DISPLAY_TOP_PAGER"] == "Y")
        echo $arResult["NAV_STRING"];?>
	<div class="row bxr-list">
		<?if (strlen($arParams["BXREADY_LIST_PAGE_BLOCK_TITLE"]) > 0):?>
			<div class="col-xs-12">
                <div class="h2">
                    <?if (strlen($arParams["BXREADY_LIST_PAGE_BLOCK_TITLE_GLYPHICON"]) > 0):?>
                        <i class="<?=$arParams["BXREADY_LIST_PAGE_BLOCK_TITLE_GLYPHICON"]?>"></i>
                    <?endif;?>
                    <?=$arParams["BXREADY_LIST_PAGE_BLOCK_TITLE"]?>
                </div>
            </div>
		<?endif;?>
		<div class="clearfix"></div>

        <?if (strlen($arParams["PAGE_BLOCK_TITLE"])>0):
            $addClass = '';
            if (strlen($arParams["PAGE_BLOCK_TITLE_GLYPHICON"])>0)
                $addClass = 'glyphicon glyphicon-pad '.$arParams["PAGE_BLOCK_TITLE_GLYPHICON"];
            ?>
            <div class="h2 <?=$addClass?>"><?=$arParams["PAGE_BLOCK_TITLE"]?></div>
        <?endif;?>

        <?if ($arParams["BXREADY_LIST_SLIDER"] == "Y") {?>
            <div class="slick-list" id="sl_<?=$thisUncumId?>">
        <?}
		$addElementClass = "";
		if (strlen($arParams["BXREADY_ELEMENT_ADDCLASS"])>0)
			$addElementClass = " ".$arParams["BXREADY_ELEMENT_ADDCLASS"];

        $i = 1;

        if ($arResult['CODE'] == 'services') { ?>

            <div class="services-list-flex">

                <? foreach ($arResult["ITEMS"] as $cell => $arItem) { ?>

                    <?$elementDraw->showElement($arParams["BXREADY_LIST_TYPES"], $arParams["BXREADY_ELEMENT_DRAW"], $arItem, $arParams);?>

                <? } ?>

            </div>

        <? } else { ?>

    		<? foreach ($arResult["ITEMS"] as $cell => $arItem):
    			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    			$strMainID = $this->GetEditAreaId($arItem['ID']);

    			$addElementClassExt = $addElementClass;
    			if ($arParams["BXREADY_USE_ELEMENTCLASS"] == "Y" && isset($arItem["PROPERTIES"]["BXR_ADDCLASS"]) && strlen($arItem["PROPERTIES"]["BXR_ADDCLASS"]["VALUE"])>0)
    				$addElementClassExt .= " ".$arItem["PROPERTIES"]["BXR_ADDCLASS"]["VALUE"];
    			?>
    			<div id="<?=$strMainID?>" class="t_<?=$unicumID?> bxr-auto-height item_pr col-xl-<?=$arParams["BXREADY_LIST_XLG_CNT"]?> col-lg-<?=$arParams["BXREADY_LIST_LG_CNT"]?> col-md-<?=$arParams["BXREADY_LIST_MD_CNT"]?> col-sm-<?=$arParams["BXREADY_LIST_SM_CNT"]?> col-xs-<?=$arParams["BXREADY_LIST_XS_CNT"]?><?=$addElementClassExt?>">
                    <?$elementDraw->showElement($arParams["BXREADY_LIST_TYPES"], $arParams["BXREADY_ELEMENT_DRAW"], $arItem, $arParams);?>
    			</div>
                <?if ($arParams["BXREADY_LIST_SLIDER"] != "Y"):?>
                    <?if(is_int($i/($arParams["BXREADY_LIST_BOOTSTRAP_GRID_STYLE"]/$arParams["BXREADY_LIST_XLG_CNT"]))) {?>
                        <div class="clearfix visible-xlg"></div>
                    <?}?>
                    <?if(is_int($i/($arParams["BXREADY_LIST_BOOTSTRAP_GRID_STYLE"]/$arParams["BXREADY_LIST_LG_CNT"]))) {?>
                        <div class="clearfix visible-lg hidden-xl"></div>
                    <?}?>
                    <?if(is_int($i/($arParams["BXREADY_LIST_BOOTSTRAP_GRID_STYLE"]/$arParams["BXREADY_LIST_MD_CNT"]))) {?>
                        <div class="clearfix visible-md"></div>
                    <?}?>
                    <?if(is_int($i/($arParams["BXREADY_LIST_BOOTSTRAP_GRID_STYLE"]/$arParams["BXREADY_LIST_SM_CNT"]))) {?>
                        <div class="clearfix visible-sm"></div>
                    <?}?>
                    <?if(is_int($i/($arParams["BXREADY_LIST_BOOTSTRAP_GRID_STYLE"]/$arParams["BXREADY_LIST_XS_CNT"]))) {?>
                        <div class="clearfix visible-xs"></div>
                    <?}?>
                    <?++$i;?>
                <?endif;?>
    		<? endforeach; ?>
        <? } ?>
	</div>

    <?if ($arParams["BXREADY_LIST_SLIDER"] == "Y") {?>
        </div>

        <script>
            $(document).ready(function() {
                var <?='ob'.$thisUncumId?> = new JCCatalogBlockSlider({
                    uniqId: '<?=$thisUncumId?>',
                    dots: <?=($arParams["BXREADY_LIST_SLIDER_MARKERS"] == "Y") ? 'true' : 'false'?>,
                    infinite: true,
                    speed: <?=intval($arParams["BXREADY_LIST_SLIDER_SCROLLSPEED"])>0 ? intval($arParams["BXREADY_LIST_SLIDER_SCROLLSPEED"]) : 300?>,
                    autoPlay: <?=($arParams["BXREADY_LIST_SLIDER_AUTOSCROLL"] == "Y") ? 'true' : 'false'?>,
                    autoPlaySpeed: <?=(intval($arParams["BXREADY_LIST_SLIDER_AUTOPLAY_SPEEDD"]) > 0) ? intval($arParams["BXREADY_LIST_SLIDER_AUTOPLAY_SPEEDD"]) :  2500?>,
                    verticalMode: <?=($arParams["BXREADY_LIST_VERTICAL_SLIDER_MODE"] == "Y") ? 'true' : 'false'?>,
                    verticalSwiping: <?=($arParams["BXREADY_LIST_VERTICAL_SLIDER_MODE"] == "Y") ? 'true' : 'false'?>,
                    hideDesktop: <?=($arParams["BXREADY_LIST_HIDE_SLIDER_ARROWS"] == "Y") ? 'true' : 'false'?>,
                    hideMobile: <?=($arParams["BXREADY_LIST_HIDE_MOBILE_SLIDER_ARROWS"] == "Y") ? 'true' : 'false'?>,
                    XLG_CNT: <?=$colToElem[$arParams["BXREADY_LIST_XLG_CNT"]]?>,
                    LG_CNT: <?=$colToElem[$arParams["BXREADY_LIST_LG_CNT"]]?>,
                    MD_CNT: <?=$colToElem[$arParams["BXREADY_LIST_MD_CNT"]]?>,
                    SM_CNT: <?=$colToElem[$arParams["BXREADY_LIST_SM_CNT"]]?>,
                    XS_CNT: <?=$colToElem[$arParams["BXREADY_LIST_XS_CNT"]]?>,
                    LG_BREAKPOINT: <?=$coreData['lg_breakpoint']?>,
                    MD_BREAKPOINT: <?=$coreData['md_breakpoint']?>,
                    SM_BREAKPOINT: <?=$coreData['sm_breakpoint']?>,
                    XS_BREAKPOINT: <?=$coreData['xs_breakpoint']?>
                });
            });
        </script>
    <?} else {
        if ($arParams["DISPLAY_BOTTOM_PAGER"])
            echo $arResult["NAV_STRING"];
        if ($arParams["PAGER_SHOW_ALL"]) {?>
            <a href="<?=str_replace("#SITE_DIR#", SITE_DIR, $arResult["LIST_PAGE_URL"])?>"><?=str_replace("#CATEGORIES#", $arParams["PAGER_TITLE"], GetMessage("BXR_SHOW_ALL"))?></a>
        <?}?>
    <?}?>
<?endif;?>





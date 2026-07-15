<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?

use Alexkova\Bxready2\Draw;

$elementDraw = \Alexkova\Bxready2\Draw::getInstance($this);
$elementDraw->setCurrentTemplate($this);

//print_r($arResult["ITEMS"]); print_r(67);


$this->setFrameMode(true);


$elementTemplate = ".default";

global $unicumID;
if ($unicumID<=0) {$unicumID = 1;} else {$unicumID++;}

$arParams["UNICUM_ID"] = $unicumID;

$colToElem = array();
$bootstrapGridCount = $arParams["BXREADY_LIST_BOOTSTRAP_GRID_STYLE"];
if ($bootstrapGridCount>0){
	for($i=1; $i<=$bootstrapGridCount; $i++){
		if (($bootstrapGridCount % $i) == 0){
			$colToElem[$bootstrapGridCount / $i] = $i;
		}
	}
}

if(!isset($arParams["BXREADY_LIST_BOOTSTRAP_GRID_STYLE"]))
    $arParams["BXREADY_LIST_BOOTSTRAP_GRID_STYLE"] = 12;
?>
<?if (count($arResult["ITEMS"])>0):?>

	<div class="row bxr-list bxr-list__mobile_hidden 2">

		<?if (strlen($arParams["BXREADY_LIST_PAGE_BLOCK_TITLE"])>0):?>
			<div class="col-xs-12">
			<h2>
				<?if (strlen($arParams["BXREADY_LIST_PAGE_BLOCK_TITLE_GLYPHICON"])>0):?>
					<i class="<?=$arParams["BXREADY_LIST_PAGE_BLOCK_TITLE_GLYPHICON"]?>"></i>
				<?endif;?>
				<?=$arParams["BXREADY_LIST_PAGE_BLOCK_TITLE"]?></h2></div>
		<?endif;?>
		<div class="clearfix"></div>

	<?if (strlen($arParams["PAGE_BLOCK_TITLE"])>0):
		$addClass = '';
		if (strlen($arParams["PAGE_BLOCK_TITLE_GLYPHICON"])>0){
			$addClass = 'glyphicon glyphicon-pad '.$arParams["PAGE_BLOCK_TITLE_GLYPHICON"];
		}
		?>
		<h2 class="<?=$addClass?>"><?=$arParams["PAGE_BLOCK_TITLE"]?></h2>
	<?endif;?>

	<?if ($arParams["BXREADY_LIST_SLIDER"] == "Y") {?>
	<div class="slick-list" id="sl_<?=$unicumID?>">
		<?}
		else{
			if ($arParams["DISPLAY_TOP_PAGER"] == "Y")
			{
				?><? echo $arResult["NAV_STRING"]; ?><?
			}
		}?>
		<?

		$addElementClass = "";
		if (strlen($arParams["BXREADY_ELEMENT_ADDCLASS"])>0){
			$addElementClass = " ".$arParams["BXREADY_ELEMENT_ADDCLASS"];
		}

                $i = 1;
		foreach ($arResult["ITEMS"] as $cell => $arItem):?>
			<?

			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			$strMainID = $this->GetEditAreaId($arItem['ID']);
			?>

			<?
			$addElementClassExt = $addElementClass;
			if ($arParams["BXREADY_USE_ELEMENTCLASS"] == "Y" && isset($arItem["PROPERTIES"]["BXR_ADDCLASS"]) && strlen($arItem["PROPERTIES"]["BXR_ADDCLASS"]["VALUE"])>0){
				$addElementClassExt .= " ".$arItem["PROPERTIES"]["BXR_ADDCLASS"]["VALUE"];
			}
			?>

			<div id="<?=$strMainID?>" class="t_<?=$unicumID?> bxr-auto-height col-lg-<?=$arParams["BXREADY_LIST_LG_CNT"]?> col-md-<?=$arParams["BXREADY_LIST_MD_CNT"]?> col-sm-<?=$arParams["BXREADY_LIST_SM_CNT"]?> col-xs-<?=$arParams["BXREADY_LIST_XS_CNT"]?><?=$addElementClassExt?>">
                            <?
                                $elementDraw->showElement($arParams["BXREADY_LIST_TYPES"], $arParams["BXREADY_ELEMENT_DRAW"], $arItem, $arParams);
                            ?>
			</div>
                        <?if ($arParams["BXREADY_LIST_SLIDER"] != "Y"):?>
                            <?if(is_int($i/($arParams["BXREADY_LIST_BOOTSTRAP_GRID_STYLE"]/$arParams["BXREADY_LIST_LG_CNT"]))){?>
                                <div class="clearfix visible-lg"></div>
                            <?}?>
                            <?if(is_int($i/($arParams["BXREADY_LIST_BOOTSTRAP_GRID_STYLE"]/$arParams["BXREADY_LIST_MD_CNT"]))){?>
                                <div class="clearfix visible-md"></div>
                            <?}?>
                            <?if(is_int($i/($arParams["BXREADY_LIST_BOOTSTRAP_GRID_STYLE"]/$arParams["BXREADY_LIST_SM_CNT"]))){?>
                                <div class="clearfix visible-sm"></div>
                            <?}?>
                            <?if(is_int($i/($arParams["BXREADY_LIST_BOOTSTRAP_GRID_STYLE"]/$arParams["BXREADY_LIST_XS_CNT"]))){?>
                                <div class="clearfix visible-xs"></div>
                            <?}?>
                            <?++$i;?>
                        <?endif;?>
		<? endforeach; ?>
	</div>


		<?if ($arParams["BXREADY_LIST_SLIDER"] == "Y") {?>
	</div>

	<script>
            function isTouchDevice() {
              try {
                document.createEvent('TouchEvent');
                return true;
              }
              catch(e) {
                return false;
              }
            }
            <?if ($arParams["HIDE_SLIDER_ARROWS"] == "Y" || !isset($arParams["HIDE_SLIDER_ARROWS"])) {?>
                if (!isTouchDevice()) {
                    prevBtn = '<button type="button" class="bxr-color-button slick-prev hidden-arrow"></button>';
                    nextBtn = '<button type="button" class="bxr-color-button slick-next hidden-arrow"></button>';
                }
            <?} else {?>
                if (!isTouchDevice()) {
                    prevBtn = '<button type="button" class="bxr-color-button slick-prev"></button>';
                    nextBtn = '<button type="button" class="bxr-color-button slick-next"></button>';
                }
            <?}?>
            <?if ($arParams["HIDE_MOBILE_SLIDER_ARROWS"] == "Y") {?>
                if (isTouchDevice()) {
                    prevBtn = '<button type="button" class="bxr-color-button slick-prev hidden-arrow"></button>';
                    nextBtn = '<button type="button" class="bxr-color-button slick-next hidden-arrow"></button>';
                }
            <?} else {?>
                if (isTouchDevice()) {
                    prevBtn = '<button type="button" class="bxr-color-button slick-prev"></button>';
                    nextBtn = '<button type="button" class="bxr-color-button slick-next"></button>';
                }
            <?}?>
		$('#sl_'+<?=$unicumID?>).slick({
                        <?if ($arParams["BXREADY_LIST_SLIDER_MARKERS"] == "Y"):?>
                            dots: true,
                        <?else:?>
                            dots: false,
                        <?endif?>
			infinite: true,
			speed: 300,
                        <?if ($arParams["VERTICAL_SLIDER_MODE"] == "Y") {?>
                            vertical: true,
                        <?}?>
			slidesToShow: <?=$colToElem[$arParams["BXREADY_LIST_LG_CNT"]]?>,
			slidesToScroll: 1,
                        prevArrow: prevBtn,
                        nextArrow: nextBtn,
			responsive: [
				{
					breakpoint: 1199,
					settings: {
						slidesToShow: <?=$colToElem[$arParams["BXREADY_LIST_MD_CNT"]]?>,
						slidesToScroll: 1
					}
				},
				{
					breakpoint: 991,
					settings: {
						slidesToShow: <?=$colToElem[$arParams["BXREADY_LIST_SM_CNT"]]?>,
						slidesToScroll: 1
					}
				},
				{
					breakpoint: 767,
					settings: {
						slidesToShow: <?=$colToElem[$arParams["BXREADY_LIST_XS_CNT"]]?>,
						slidesToScroll: 1
					}
				},
			]
		});



	</script>
<?}
else{
	if ($arParams["DISPLAY_BOTTOM_PAGER"])
	{
		?><? echo $arResult["NAV_STRING"]; ?><?
	}
}
	?>

<?endif;?>





<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>

<?
if ($arParams['BXR_SMARTPRICE']['USE_SMARTPRICE'] == 'Y' && $arParams['BXR_SMARTPRICE']['BXR_BUSINESS_SMARTPRICE_IBLOCK_ID']>0){
	$arResult['SMARTPRICE_SECTIONS'] = $SmartPrice = \Alexkova\Business\Smartprice::getElementSections($arResult['ID'], $arParams['IBLOCK_ID']);
}

?>

<div class="bxr-element-detail tb20-bottom">
    <div class="row">
		<div class="col-xs-12">
                <?include ('include/shorts.php');?>
        </div>
<?include ('include/price_control.php');?>
<?
    $preview_text = false;
    if (in_array("PREVIEW_TEXT", $arParams["FIELD_CODE"]) && strlen($arResult["PREVIEW_TEXT"]) > 0)
        $preview_text = true;
    
    $preview_date = false;
    if ($arResult['DATE_ACTIVE_FROM'] && in_array("DATE_ACTIVE_FROM", $arParams["FIELD_CODE"]) || $arResult['DATE_ACTIVE_TO'] && in_array("DATE_ACTIVE_TO", $arParams["FIELD_CODE"]))
       $preview_date = true;

    $block_price = false;
    if($price > 0 || $show_timer)
        $block_price = true;
?>
<?
    if(isset($arParams["BXR_FORM_SIDEBAR"]) &&  $arParams["BXR_FORM_SIDEBAR"]== "Y" ) {
        $this->SetViewTarget('sidebar', $val);
        include ('include/form.php');
        $this->EndViewTarget();
    }
?>
<?if (substr_count($arParams['BXR_PICTURE']['BXR_DETAIL_PICTURE_TYPE'], 'fullsize')>0):?>

	<div class="col-xs-12">
		<?include ('include/slider.php');?>
	</div>
	<div class="col-xs-12">
            <?if($preview_text || $preview_date || $block_price):?>
                <div class="bxr-anounce-block">
                    <?if($preview_date || $preview_text):?>
                        <div class="col-xs-12 <?if($block_price) echo " col-md-7";?> bxr-anounce-col">
                            <?if($preview_date):?>
                                <div class="pull-left bxr-element-date-wrap"><?include ('include/date.php');?></div>
                                <div class="clearfix"></div>
                            <?endif;?>
                            <?include ('include/preview_text.php');?>
                        </div>
                    <?endif;?>
                    <?if($block_price):?>
                        <div class="col-xs-12 <?if($preview_date || $preview_text) echo " col-md-5 ";?> bxr-price-col">                    
                            <?include ('include/price.php');?>                    
                        </div>
                    <?endif;?>
                    <div class="clearfix"></div>
                </div>
            <?endif;?>
            <?
                if(!isset($arParams["BXR_FORM_SIDEBAR"]) ||  $arParams["BXR_FORM_SIDEBAR"] != "Y" ) {
                    include ('include/form.php');
                }
            ?>
            <?if ($arParams["BXR_OFFERS_BLOCK"]["BXR_SHOW_OFFERS"] == "Y")  include ('include/offer.php');?>
	</div>
<?else:?>

	<div class="col-xs-12 col-md-7">
		<?include ('include/slider.php');?>
	</div>
	<div class="col-xs-12 col-md-5 bxr-element-right-col">
                <?if($preview_date):?>
                    <div class="pull-left bxr-element-date-wrap"><?include ('include/date.php');?></div>
                    <div class="clearfix"></div>
                <?endif;?>
		<?include ('include/price.php');?>
		<?include ('include/preview_text.php');?>
        <?
        if (CModule::IncludeModule('alexkova.startsale')) {
            include ('include/basket_btn.php');
        }
        ?>
		<?if ($arParams["BXR_OFFERS_BLOCK"]["BXR_SHOW_OFFERS"] == "Y")  include ('include/offer.php');?>
                <?
                    if(!isset($arParams["BXR_FORM_SIDEBAR"]) ||  $arParams["BXR_FORM_SIDEBAR"] != "Y" ) {
                        include ('include/form.php');
                    }
                ?>
		<? //include ('include/preview_props.php');?>

	</div>

<?endif;?>



<?if($arParams['BXR_DETAIL_TABS']['BXR_DETAIL_TAB_TEXT'] == 'detail'):?>
		<div class="col-xs-12">
				<?include ('include/detail.php');?>
		</div>
<?endif;?>

		 <div class="col-xs-12">
                <?include ('include/tabs.php');?>
        </div>

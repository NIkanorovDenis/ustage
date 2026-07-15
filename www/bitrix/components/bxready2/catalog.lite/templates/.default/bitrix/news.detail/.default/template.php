<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>

<div class="bxr-element-detail tb20">
    <div class="row">

		<div class="col-xs-12">
                <?include ('include/shorts.php');?>
        </div>

<?if (substr_count($arParams['BXR_PICTURE']['BXR_DETAIL_PICTURE_TYPE'], 'fullsize')>0):?>

	<div class="col-xs-12">
		<?include ('include/slider.php');?>
	</div>
	<div class="col-xs-12">
            <div class="bxr-anounce-block">
                <div class="col-xs-12 col-md-7 bxr-anounce-col">                    
                    <div class="pull-left bxr-element-date-wrap"><?include ('include/date.php');?></div>
                    <div class="clearfix"></div>
                    <?include ('include/preview_text.php');?>
                </div>
                <div class="col-xs-12 col-md-5 bxr-price-col">                    
                    <?include ('include/price.php');?>
                </div>
                <div class="clearfix"></div>
            </div>
            <?include ('include/form.php');?>
            <?if ($arParams["BXR_OFFERS_BLOCK"]["BXR_SHOW_OFFERS"] == "Y")  include ('include/offer.php');?>
	</div>

<?else:?>

	<div class="col-xs-12 col-md-7">
		<?include ('include/slider.php');?>
	</div>
	<div class="col-xs-12 col-md-5 bxr-element-right-col">
		<div class="pull-left bxr-element-date-wrap"><?include ('include/date.php');?></div>
		<div class="clearfix"></div>
		<?include ('include/price.php');?>
		<?include ('include/preview_text.php');?>
		<?if ($arParams["BXR_OFFERS_BLOCK"]["BXR_SHOW_OFFERS"] == "Y")  include ('include/offer.php');?>
		<?include ('include/form.php');?>
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

        <div class="col-xs-12">
            <a href="<?=$arResult['SECTION_URL']?>" class="bxr-color-button bxr-color-button-small bxr-element-get-back">
                <i class="fa fa-angle-left"></i>
                <?=GetMessage('GET_BACK')?>
            </a>
            <?include ('include/share.php');?>
        </div>

        <div class="clearfix"></div>
    </div>
</div>

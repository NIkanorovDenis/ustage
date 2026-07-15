<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>

<div class="bxr-element-detail tb20-bottom">
    <div class="row">
		<div class="col-xs-12">
                <?include ('include/shorts.php');?>
        </div>
        <?include ('include/price_propery.php');?>
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
            $elementarArea = \Alexkova\Bxready2\Elementars::getArea('block.detail','form');
            if (strlen($elementarArea) > 0)
                include($elementarArea);
            else
                include 'include/form.php';
            $this->EndViewTarget();
        }
        ?>
        <?if (substr_count($arParams['BXR_PICTURE']['BXR_DETAIL_PICTURE_TYPE'], 'fullsize')>0):?>
            <div class="col-xs-12">
                <?
                $elementarArea = \Alexkova\Bxready2\Elementars::getArea('block.detail','slider');
                if (strlen($elementarArea) > 0)
                    include($elementarArea);
                else
                    include 'include/slider.php';
                ?>
            </div>
            <div class="col-xs-12">
                    <?if($preview_text || $preview_date || $block_price):?>
                        <div class="bxr-anounce-block">
                            <?if($preview_date || $preview_text):?>
                                <div class="col-xs-12 <?if($block_price) echo " col-md-7";?> bxr-anounce-col">
                                    <?if($preview_date):?>
                                        <div class="pull-left bxr-element-date-wrap">
                                            <?
                                            $elementarArea = \Alexkova\Bxready2\Elementars::getArea('block.detail','date');
                                            if (strlen($elementarArea) > 0)
                                                include($elementarArea);
                                            else
                                                include 'include/date.php';
                                            ?>
                                        </div>
                                        <div class="clearfix"></div>
                                    <?endif;?>
                                    <?
                                    $elementarArea = \Alexkova\Bxready2\Elementars::getArea('block.detail','preview_text');
                                    if (strlen($elementarArea) > 0)
                                        include($elementarArea);
                                    else
                                        include 'include/preview_text.php';
                                    ?>
                                </div>
                            <?endif;?>
                            <?if($block_price):?>
                                <div class="col-xs-12 <?if($preview_date || $preview_text) echo " col-md-5 ";?> bxr-price-col">
                                    <?
                                    $elementarArea = \Alexkova\Bxready2\Elementars::getArea('block.detail','price');
                                    if (strlen($elementarArea) > 0)
                                        include($elementarArea);
                                    else
                                        include 'include/price.php';
                                    ?>
                                </div>
                            <?endif;?>
                            <div class="clearfix"></div>
                        </div>
                    <?endif;?>
                    <?
                        if(!isset($arParams["BXR_FORM_SIDEBAR"]) ||  $arParams["BXR_FORM_SIDEBAR"] != "Y" ) {
                            $elementarArea = \Alexkova\Bxready2\Elementars::getArea('block.detail','form');
                            if (strlen($elementarArea) > 0)
                                include($elementarArea);
                            else
                                include 'include/form.php';
                        }
                    ?>
                    <?if ($arParams["BXR_OFFERS_BLOCK"]["BXR_SHOW_OFFERS"] == "Y") {
                        $elementarArea = \Alexkova\Bxready2\Elementars::getArea('block.detail','offer');
                        if (strlen($elementarArea) > 0)
                            include($elementarArea);
                        else
                            include 'include/offer.php';
                    }?>
            </div>
        <?else:?>

            <div class="col-xs-12<?=(!empty($arResult["IMAGES"]) && count($arResult["IMAGES"]) > 0 || !empty($arResult["DETAIL_PICTURE"])) ? " col-md-7" : ""?>">
                <?
                $elementarArea = \Alexkova\Bxready2\Elementars::getArea('block.detail','slider');
                if (strlen($elementarArea) > 0)
                    include($elementarArea);
                else
                    include 'include/slider.php';
                ?>
            </div>
            <div class="col-xs-12<?=(!empty($arResult["IMAGES"]) && count($arResult["IMAGES"]) > 0 || !empty($arResult["DETAIL_PICTURE"])) ? " col-md-5" : ""?> bxr-element-right-col">
                        <?if($preview_date):?>
                            <div class="pull-left bxr-element-date-wrap">
                                <?
                                $elementarArea = \Alexkova\Bxready2\Elementars::getArea('block.detail','date');
                                if (strlen($elementarArea) > 0)
                                    include($elementarArea);
                                else
                                    include 'include/date.php';
                                ?>
                            </div>
                            <div class="clearfix"></div>
                        <?endif;?>
                <?
                $elementarArea = \Alexkova\Bxready2\Elementars::getArea('block.detail','price');
                if (strlen($elementarArea) > 0)
                    include($elementarArea);
                else
                    include 'include/price.php';
                ?>
                <?
                $elementarArea = \Alexkova\Bxready2\Elementars::getArea('block.detail','preview_text');
                if (strlen($elementarArea) > 0)
                    include($elementarArea);
                else
                    include 'include/preview_text.php';
                ?>
                <?if ($arParams["BXR_OFFERS_BLOCK"]["BXR_SHOW_OFFERS"] == "Y") {
                    $elementarArea = \Alexkova\Bxready2\Elementars::getArea('block.detail','offer');
                    if (strlen($elementarArea) > 0)
                        include($elementarArea);
                    else
                        include 'include/offer.php';
                }?>
                <?
                    if(!isset($arParams["BXR_FORM_SIDEBAR"]) ||  $arParams["BXR_FORM_SIDEBAR"] != "Y" ) {
                        $elementarArea = \Alexkova\Bxready2\Elementars::getArea('block.detail','form');
                        if (strlen($elementarArea) > 0)
                            include($elementarArea);
                        else
                            include 'include/form.php';
                    }
                ?>
            </div>

        <?endif;?>
        <?if($arParams['BXR_DETAIL_TABS']['BXR_DETAIL_TAB_TEXT'] == 'detail'):?>
            <div class="col-xs-12">
                <?
                $elementarArea = \Alexkova\Bxready2\Elementars::getArea('block.detail','detail');
                if (strlen($elementarArea) > 0)
                    include($elementarArea);
                else
                    include 'include/detail.php';
                ?>
            </div>
        <?endif;?>
        <div class="col-xs-12">
            <?include 'include/tabs.php';?>
        </div>

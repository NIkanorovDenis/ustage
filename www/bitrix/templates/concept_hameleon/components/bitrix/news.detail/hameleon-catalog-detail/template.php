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
$this->setFrameMode(true);
global $DB_cham;
?>
<?if($arParams["BLOCK_ID"] > 0):?>
    <?$sect = GetIBlockElement($arParams["BLOCK_ID"]);?>
<?endif;?>

<div class="catalog-body">
    <div class="title main1">
        <?=$arResult['~NAME']?>
    </div>

	<?$active = 0;?>
    <div class="content">
        <div class="row clearfix">
        	<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
				<div class="images-content">
	            	<?if(!empty($arResult["PROPERTIES"]["PICTURES"]["VALUE"])):?>

		                <div class="image-main">

							<?foreach($arResult["PROPERTIES"]["PICTURES"]["VALUE"] as $k => $arImages):?>
			                    <div class="image-child <?if($k == 0):?>active<?endif;?>">
			                    	<?$file_big = CFile::ResizeImageGet($arImages, array('width'=>1600, 'height'=>1200), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
			                    	<?$file_min = CFile::ResizeImageGet($arImages, array('width'=>1600, 'height'=>1200), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
			                        <a data-gallery="catalog<?=$arResult["ID"]?>" href="<?=$file_big["src"]?>" title="<?=$arResult["PROPERTIES"]["PICTURES"]["~DESCRIPTION"][$k]?>" class="cursor-loop">
			                        <img alt="<?=$arResult["NAME"]?>" class="img-responsive" src="<?=$file_min["src"]?>" /></a>
			                    </div>
		                    <?endforeach;?>

		                </div>
		
						<?$count = count($arResult["PROPERTIES"]["PICTURES"]["VALUE"]);?>
						<?if($count > 1):?>
			                <div class="row">
			                    <div class="image-dots clearfix">

									<?foreach($arResult["PROPERTIES"]["PICTURES"]["VALUE"] as $k => $arImages):?>
				                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 image-wrap-dot <?if($k == 0):?>active"<?endif;?>">
				                            <div class="image-dot">

				                                <div class="image-child mainColor">
				                                	<?$file_min = CFile::ResizeImageGet($arImages, array('width'=>95, 'height'=>75), BX_RESIZE_IMAGE_EXACT , false, false, false, 85);?>
				                                	<img alt="<?=$arResult["NAME"]?>" class="img-responsive center-block" src="<?=$file_min["src"]?>">

				                                </div>

				                            </div>
				                        </div>

			                        <?endforeach;?>
			                    </div>
			                </div>
		                <?endif;?>
	                <?endif;?>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
				<div class="wrap-in-content">
	                <div class="tabs-modal tab-parent">

		                <?if(strlen($arResult["DETAIL_TEXT"]) > 0 || !empty($arResult["PROPERTIES"]["CHARACTERISTICS"]["VALUE"]) || strlen($arResult["PREVIEW_TEXT"]) > 0):?>
		                    <ul class="tab-child hidden-xs">

								<?if(strlen($arResult["DETAIL_TEXT"]) > 0):?>
		                       		<li <?if($active==0):?>class="active"<?endif;?>><?=GetMessage('HAM_MODAL_CTL_DESC')?><div class="primary"></div></li>
		                       		<?$active = 1;?>
		                        <?endif;?>
								<?if(!empty($arResult["PROPERTIES"]["CHARACTERISTICS"]["VALUE"])):?>
			                        <li <?if($active==0):?>class="active"<?endif;?>><?=GetMessage('HAM_MODAL_CTL_CHAR')?><div class="primary"></div></li>
			                        <?$active = 1;?>
			                    <?endif;?>

								<?if(strlen($arResult["PREVIEW_TEXT"]) > 0):?>
			                        <li <?if($active==0):?>class="active"<?endif;?>><?=GetMessage('HAM_MODAL_CTL_COMPLECT')?><div class="primary"></div></li>
			                        <?$active = 1;?>
			                    <?endif;?>

		                    </ul>
	                    <?endif;?>

	                    <?$active = 0;?>
	                    <div class="tabs-content no-margin-top-bot <?if(strlen($arResult["DETAIL_TEXT"]) > 0 || !empty($arResult["PROPERTIES"]["CHARACTERISTICS"]["VALUE"]) || strlen($arResult["PREVIEW_TEXT"]) > 0):?>line<?endif;?>">

							<?if(strlen($arResult["DETAIL_TEXT"]) > 0 || !empty($arResult["PROPERTIES"]["CHARACTERISTICS"]["VALUE"]) || strlen($arResult["PREVIEW_TEXT"]) > 0):?>

								<?if(strlen($arResult["DETAIL_TEXT"]) > 0):?>
			                        <div class="tab-content parent-slide-show<?if($active==0):?> active<?endif;?>">
			                            <div class="mob-title click-slide-show <?if($active==0):?>active<?endif;?>">
			                                <?=GetMessage('HAM_MODAL_CTL_DESC')?>
			                                <div class="primary"></div>
			                            </div>
			                            <div class="mob-show content-slide-show <?if($active==0):?>active<?endif;?>">
			                                <div class="text">
			                                    <?=$arResult["~DETAIL_TEXT"]?>
			                                </div>
			                            </div>
			                        </div>
			                        <?$active = 1;?>
			                    <?endif;?>

								<?if(!empty($arResult["PROPERTIES"]["CHARACTERISTICS"]["VALUE"])):?>
			                        <div class="tab-content parent-slide-show <?if($active==0):?>active<?endif;?>">
			                            <div class="mob-title click-slide-show <?if($active==0):?>active<?endif;?>">
			                                <?=GetMessage('HAM_MODAL_CTL_CHAR')?>
			                                <div class="primary"></div>
			                            </div>

			                            <div class="mob-show content-slide-show <?if($active==0):?>active<?endif;?>">
			                                <ul class="list">
												<?foreach($arResult["PROPERTIES"]["CHARACTERISTICS"]["~VALUE"] as $k => $arChar):?>
			                                    	<li class="clearfix"><span class="left bold"><?=$arChar?></span> <span class="right"><?=$arResult["PROPERTIES"]["CHARACTERISTICS"]["~DESCRIPTION"][$k]?></span></li>
												<?endforeach;?>
			                                </ul>
			                            </div>
			                        </div>
			                        <?$active = 1;?>
		                        <?endif;?>

								<?if(strlen($arResult["PREVIEW_TEXT"]) > 0):?>
			                        <div class="tab-content parent-slide-show <?if($active==0):?>active<?endif;?>">
			                            <div class="mob-title click-slide-show <?if($active==0):?>active<?endif;?>">
			                                <?=GetMessage('HAM_MODAL_CTL_COMPLECT')?>
			                                <div class="primary"></div>
			                            </div>
			                            <div class="mob-show content-slide-show <?if($active==0):?>active<?endif;?>">
			                                <div class="text">
			                                    <?=$arResult["~PREVIEW_TEXT"]?>
			                                </div>
			                            </div>
			                        </div>
			                        <?$active = 1;?>
		                        <?endif;?>
							<?endif;?>

							<?if(strlen($arResult["PROPERTIES"]["CUR_OLD_PRICE"]["VALUE"])>0 || strlen($arResult["PROPERTIES"]["CUR_PRICE"]["VALUE"])>0):?>
								<div class="price-wrap">
								
									<?if(strlen($arResult["PROPERTIES"]["CUR_OLD_PRICE"]["VALUE"])>0 && $arResult["PROPERTIES"]["REQUEST_PRICE"]["VALUE"] != "Y"):?>
			                            <div class="old-price main2">
			                                <?=$arResult["PROPERTIES"]["CUR_OLD_PRICE"]["VALUE"]?>
			                            </div>
		                            <?endif;?>

									<?if(strlen($arResult["PROPERTIES"]["CUR_PRICE"]["VALUE"])>0 || $arResult["PROPERTIES"]["REQUEST_PRICE"]["VALUE"] == "Y"):?>
			                            <div class="price">
			                                <?=$arResult["PROPERTIES"]["CUR_PRICE"]["VALUE"];?>
			                            </div>
		                            <?endif;?>
		                        </div>

	                        <?endif;?>

							<?if(!empty($arResult["PROPERTIES"]["OTHER_COMPLECT"]["VALUE"])):?>
		                        <div class="price-radio">

									<?foreach($arResult["PROPERTIES"]["OTHER_COMPLECT"]["~VALUE"] as $k => $arComplect):?>
			                            <label class="<?if($k == 0):?>active<?endif;?> mainColor">
				                            <div class="price-radio-wrap">
				                               <input <?if($k == 0):?> checked="checked"<?endif;?> name="other_complect" type="radio" value='<?=$k?>'> <span class="icon"></span> <span class="price main1"><?=$arResult["PROPERTIES"]["OTHER_COMPLECT"]["~DESCRIPTION"][$k]?></span> <span class="descript"><?=$arComplect?></span>
				                            </div>
			                            </label>
		                            <?endforeach;?>
		                          
		                        </div>
	                        <?endif;?>

							<?if($arResult["PROPERTIES"]["SHOW_FORM"]["VALUE"] == "Y" || ($arResult["SECTION_MAIN"]["UF_CH_BOX_ON"] && $arResult["PROPERTIES"]["BOX_ADD"]["VALUE"] == "Y")):?>
		                        <div class="button-wrap">
		                        	<table class="mobile-break">
		                        		<tr>

		                        			<?if($arResult["SECTION_MAIN"]["UF_CH_BOX_ON"] && $arResult["PROPERTIES"]["BOX_ADD"]["VALUE"] == "Y"):?>
		                        				<td>
			                                        <a class="button-def primary big <?=$arResult["SECTION_MAIN"]["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?> click_box from_modal_cat <?if($arParams["ADDED"]=="Y") echo "added";?>" data-box-id="<?=$arResult["ID"]?>" data-box-step="<?=$arResult["PROPERTIES"]["BOX_PRICE_STEP"]["VALUE"]?>" data-box-action = "add">

			                                        	<span class="first">
			                                        		<?
				                                        		if(strlen($arResult["PROPERTIES"]["BOX_BUTTON_NAME"]["~VALUE"]) > 0)
				                                        			echo $arResult["PROPERTIES"]["BOX_BUTTON_NAME"]["~VALUE"];

				                                        		elseif(strlen($arResult["SECTION_MAIN"]["~UF_CH_BOX_BUTTONNAME"]) > 0)
				                                        			echo $arResult["SECTION_MAIN"]["~UF_CH_BOX_BUTTONNAME"];

				                                        		else
				                                        			echo GetMessage("HAM_MODAL_CTL_BUTTON_NAME");
			                                        		?>
			                                            </span>
			                                            <span class="second">
			                                            	<?
				                                            	if(strlen($arResult["PROPERTIES"]["BOX_BUTTON_NAME_ADDED"]["~VALUE"]) > 0)
				                                            		echo $arResult["PROPERTIES"]["BOX_BUTTON_NAME_ADDED"]["~VALUE"];

				                                            	elseif(strlen($arResult["SECTION_MAIN"]["~UF_CH_BOX_BTNNAME_AD"]) > 0)
				                                            		echo $arResult["SECTION_MAIN"]["~UF_CH_BOX_BTNNAME_AD"];

				                                            	else
				                                            		echo GetMessage("HAM_MODAL_CTL_BUTTON_NAME_ADDED");
			                                            	?>
			                                            </span>



			                                        </a> 
		                                        </td>
		                                    <?endif;?>

		                                    <?if($arResult["PROPERTIES"]["SHOW_FORM"]["VALUE"] == "Y"):?>
		                        				<td>
		                        					<?
				                                        $class_btn = "button-def primary big";
				                                        $view_btn = false;

				                                        if($arResult["SECTION_MAIN"]["UF_CH_BOX_ON"] && $arResult["PROPERTIES"]["BOX_ADD"]["VALUE"] == "Y" && strlen($arResult["PROPERTIES"]["BOX_PRICE"]["VALUE"])>0)
				                                        {
				                                        	$class_btn="modal_btn";
				                                        	$view_btn = true;
				                                        }

                                                        $form_id = $arResult["SECTION_MAIN"]["UF_CHAM_CATALOG_FRM"];

                                                        if($arResult["CATALOG"]["PROPERTIES"]["CATALOG_FORM"]["VALUE"])
                                                            $form_id = $arResult["CATALOG"]["PROPERTIES"]["CATALOG_FORM"]["VALUE"];
                                                        

                                                        if($arResult["PROPERTIES"]["ORDER_FORM"]["VALUE"] > 0)
                                                            $form_id = $arResult["PROPERTIES"]["ORDER_FORM"]["VALUE"];
                                                    ?>
				                                    <a class="<?=$class_btn?> more-modal-info <?=$arResult["SECTION_MAIN"]["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?> <?if(strlen($form_id)>0):?>call-modal callform<?endif;?> catalog from-modal from-tariff" data-element-id="<?=$arResult["ID"]?>" data-element-type ="CTL" data-call-modal="form<?=$form_id?>" data-header="<?=htmlspecialcharsEx(strip_tags(html_entity_decode($arParams["CHAM_HEADER"])))?>">

				                                    	<?if($view_btn):?><span class="bord"><?endif;?>

				                                    		<?
					                                    		if(strlen($arResult["PROPERTIES"]["BUTTON_NAME"]["~VALUE"]) > 0)
			                                                		echo $arResult["PROPERTIES"]["BUTTON_NAME"]["~VALUE"];

			                                                	elseif(strlen($arResult["CATALOG"]["PROPERTIES"]["CATALOG_BUTTON_NAME"]["~VALUE"])>0)
			                                                		echo $arResult["CATALOG"]["PROPERTIES"]["CATALOG_BUTTON_NAME"]["~VALUE"];

			                                                	elseif(strlen($arResult["SECTION_MAIN"]['UF_CHAM_CATAL_BTN_N2'])>0)
			                                                		echo $arSection['UF_CHAM_CATAL_BTN_N2'];

			                                                	else
			                                                		echo GetMessage("HAM_MODAL_CTL_BUTTON");

				                                    		?>

				                                        <?if($view_btn):?></span><?endif;?>
				                                    </a> 
			                        			</td>
		                        			<?endif;?>

		                        		</tr>
		                        	</table>
			                        <?/*
			                        	$priceFinish = '';
			                        	if(strlen($arResult["PROPERTIES"]["PRICE"]["~VALUE"])>0)
			                        		$priceFinish .= ', '.$arResult["PROPERTIES"]["PRICE"]["~VALUE"];

			                        	if(strlen($arResult["PROPERTIES"]["OLD_PRICE"]["~VALUE"])>0)
			                        		$priceFinish .= ', <strike>'.$arResult["PROPERTIES"]["OLD_PRICE"]["~VALUE"].'</strike>';
			                        */?>
	                        <?endif;?>
	                        
	                    </div>
	                </div>
                </div>
            </div>
        </div>
    </div>
</div>
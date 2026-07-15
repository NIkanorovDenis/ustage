<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
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
$this->setFrameMode(false); 
?>
<div class='bxr-form-body-container'>

	<? global $BXR_FORM_COUNTER;

	/*if (!empty($arResult["ERRORS"])):?>
	<div class="bxr-form-errors"><?
	foreach ($arResult["ERRORS"] as $k => $v) {
	echo "<p><i class='fa fa-exclamation-triangle'></i> " . $v . $k . "</p>";// ShowError($v);
	}        
	?></div>	
	<?endif;?>
	
	<div class="request-product">
		<?if ($arResult["ELEMENT"]["PICTURE"]) {?>
			<div class="request-product-img bxr-hidden">
				<img alt="" src="<?=$arResult["ELEMENT"]["PICTURE"]?>">
			</div>
		<?}?>
		<div class="request-product-name"><?=$arResult["ELEMENT"]["NAME"]?></div> 
	</div>
	<div class="clearfix"></div>
	*/?>
	
	<?if (strlen($arResult["MESSAGE"]) > 0):?>
		<div class="success-message"><?ShowNote($arResult["MESSAGE"])?></div>
		<?return false;?>	
	<?endif?>
	
	<form id="<?=$arParams['IDENTITY']?>" class='bxr-form-body roxy4' name="iblock_add" action="<?=$arParams["POST_FORM_URI"]?>" method="post" enctype="multipart/form-data">
	
		<input type="hidden" name="FORM_ID" value="<?=$arParams["IBLOCK_ID"]?>"/>
		<input type="hidden" name="FORM_ID_FULL" value="<?=$arParams['IDENTITY']?>"/>
		
		<?if($arParams["TARGET_URL"]):?>
			<input type="hidden" name="TARGET_URL" value="<?=!empty($arParams["REQUEST_LINK"]) ? $arParams["REQUEST_LINK"] : $arParams["TARGET_URL"]?>"/>
		<?endif;?>		
		<?=bitrix_sessid_post()?>
		<?if ($arParams["MAX_FILE_SIZE"] > 0):?>
			<input type="hidden" name="MAX_FILE_SIZE" value="<?=$arParams["MAX_FILE_SIZE"]?>" />
		<?endif?>
		
		<?if (is_array($arResult["PROPERTY_LIST"]) && !empty($arResult["PROPERTY_LIST"])):?>
		
			<? /*propeties list*/ ?>
			<?foreach ($arResult["PROPERTY_LIST"] as $propertyID):?>
			
				<? if (substr_count($arResult["PROPERTY_LIST_FULL"][$propertyID]["CODE"], 'HIDDEN') > 0) {
					$inputType = 'hidden';
				} elseif (substr_count($arResult["PROPERTY_LIST_FULL"][$propertyID]["CODE"], 'AREA') > 0) {
					$inputType = 'textarea';
				} else {
					$inputType = 'text';
				}?>
				
				<?if ($inputType != 'hidden'):?>
					
					<?if (intval($propertyID) > 0):?>
						<span class="bxr-pr-name"><?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["NAME"]?></span>
					<?else:?>
						<span class="bxr-pr-name"><?=!empty($arParams["CUSTOM_TITLE_".$propertyID]) ? $arParams["CUSTOM_TITLE_".$propertyID] : GetMessage("IBLOCK_FIELD_".$propertyID)?></span>
					<?endif?>
					
					<?if(in_array($propertyID, $arResult["PROPERTY_REQUIRED"])):?> 
						<span class="starrequired 1">*</span>
					<?endif?>
					
				<?endif?>
				
				<? if (intval($propertyID) > 0) {
				
					if (
					$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] == "T"
					&&
					$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"] == "1"
					)
					$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] = "S";
					elseif (
					(
					$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] == "S"
					||
					$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] == "N"
					)
					&&
					$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"] > "1"
					)
					$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] = "T";
				
				} elseif (($propertyID == "TAGS") && CModule::IncludeModule('search')) {
					
					$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] = "TAGS";
					
				}

				if ($arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE"] == "Y") {
					$inputNum = ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0) ? count($arResult["ELEMENT_PROPERTIES"][$propertyID]) : 0;
					$inputNum += $arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE_CNT"];
				} else {
					$inputNum = 1;
				}

				if($arResult["PROPERTY_LIST_FULL"][$propertyID]["GetPublicEditHTML"])
					$INPUT_TYPE = "USER_TYPE";
				else
					$INPUT_TYPE = $arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"];

				/*case type*/
				switch ($INPUT_TYPE):
				
					case "USER_TYPE":
						for ($i = 0; $i<$inputNum; $i++) {
							
							if ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0) {
								$value = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["~VALUE"] : $arResult["ELEMENT"][$propertyID];
								$description = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["DESCRIPTION"] : "";
							} elseif ($i == 0) {
								$value = intval($propertyID) <= 0 ? "" : $arResult["PROPERTY_LIST_FULL"][$propertyID]["DEFAULT_VALUE"];
								$description = "";
							} else {
								$value = "";
								$description = "";
							}
							
							echo call_user_func_array($arResult["PROPERTY_LIST_FULL"][$propertyID]["GetPublicEditHTML"],
							
							array(
								$arResult["PROPERTY_LIST_FULL"][$propertyID],
								array(
									"VALUE" => $value,
									"DESCRIPTION" => $description,
								),
								array(
									"VALUE" => "PROPERTY[".$propertyID."][".$i."][VALUE]",
									"DESCRIPTION" => "PROPERTY[".$propertyID."][".$i."][DESCRIPTION]",
									"FORM_NAME"=>"iblock_add",
								),
							));
						}
					break;
					
					case "TAGS":
						$APPLICATION->IncludeComponent(
							"bitrix:search.tags.input",
							"",
							array(
								"VALUE" => $arResult["ELEMENT"][$propertyID],
								"NAME" => "PROPERTY[".$propertyID."][0]",
								"TEXT" => 'size="'.$arResult["PROPERTY_LIST_FULL"][$propertyID]["COL_COUNT"].'"',
							), null, array("HIDE_ICONS"=>"Y")
						);
					break;
					
					case "HTML":
						$LHE = new CLightHTMLEditor;
						$LHE->Show(array(
							'id' => preg_replace("/[^a-z0-9]/i", '', "PROPERTY[".$propertyID."][0]"),
							'width' => '100%',
							'height' => '200px',
							'inputName' => "PROPERTY[".$propertyID."][0]",
							'content' => $arResult["ELEMENT"][$propertyID],
							'bUseFileDialogs' => false,
							'bFloatingToolbar' => false,
							'bArisingToolbar' => false,
							'toolbarConfig' => array(
							'Bold', 'Italic', 'Underline', 'RemoveFormat',
							'CreateLink', 'DeleteLink', 'Image', 'Video',
							'BackColor', 'ForeColor',
							'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyFull',
							'InsertOrderedList', 'InsertUnorderedList', 'Outdent', 'Indent',
							'StyleList', 'HeaderList',
							'FontList', 'FontSizeList',
							),
						));
					break;
					
					case "T":
						for ($i = 0; $i<$inputNum; $i++) {

							if ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0) {
								$value = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE"] : $arResult["ELEMENT"][$propertyID];
							} elseif ($i == 0) {
								$value = intval($propertyID) > 0 ? "" : $arResult["PROPERTY_LIST_FULL"][$propertyID]["DEFAULT_VALUE"];
							} else {
								$value = "";
							}
							?>
							
							<textarea class="form-control <? if ($arResult["ERRORS"][$propertyID]):?>error<?endif;?>" cols="<?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["COL_COUNT"]?>" rows="<?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"]?>" name="PROPERTY[<?=$propertyID?>][<?=$i?>]"><?=$value?></textarea>
							<? if ($arResult["ERRORS"][$propertyID]):?>
								<span class="error"><?=$arResult["ERRORS"][$propertyID]?></span>
							<? endif; ?>	
							
							<?
						}
					break;

					case "S":
					case "N":
						for ($i = 0; $i<$inputNum; $i++) {
							
							if ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0) {
								$value = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE"] : $arResult["ELEMENT"][$propertyID];
							} elseif ($i == 0) {
								$value = intval($propertyID) <= 0 ? "" : $arResult["PROPERTY_LIST_FULL"][$propertyID]["DEFAULT_VALUE"];
							} else {
								$value = "";
							}
							?>

							<?if ($inputType != 'textarea') {?>
							
								<input class="form-control <? if ($arResult["ERRORS"][$propertyID]):?>error<?endif;?>" type="<?=$inputType?>" name="PROPERTY[<?=$propertyID?>][<?=$i?>]" value="<?=$value?>" data-code="<?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["CODE"]?>"/>
								<? if ($arResult["ERRORS"][$propertyID]):?>
									<span class="error"><?=$arResult["ERRORS"][$propertyID]?></span>
								<? endif; ?>
								
								<?if ($inputType != 'hidden') {?>

								<?}?>
								
							<?} else {?>
							
								<textarea  class="form-control <? if ($arResult["ERRORS"][$propertyID]):?>error<?endif;?>" name="PROPERTY[<?=$propertyID?>][<?=$i?>]" rows="5" data-code="<?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["CODE"]?>" style="resize: none"><?=trim($value)?></textarea>
							<?}?>
							
							<?if($arResult["PROPERTY_LIST_FULL"][$propertyID]["USER_TYPE"] == "DateTime"):?>
								<? $APPLICATION->IncludeComponent(
									'bitrix:main.calendar',
									'',
										array(
										'FORM_NAME' => 'iblock_add',
										'INPUT_NAME' => "PROPERTY[".$propertyID."][".$i."]",
										'INPUT_VALUE' => $value,
									),
									null,
									array('HIDE_ICONS' => 'Y')
								); ?>
								<small><?=GetMessage("IBLOCK_FORM_DATE_FORMAT")?><?=FORMAT_DATETIME?></small>
							<? endif;?>
							
						<? }
					break;

					case "F":
					
						for ($i = 0; $i<$inputNum; $i++) {
							
							$value = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE"] : $arResult["ELEMENT"][$propertyID]; ?>
							<input type="hidden" name="PROPERTY[<?=$propertyID?>][<?=$arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] : $i?>]" value="<?=$value?>" />
							<input type="file" size="<?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["COL_COUNT"]?>"  name="PROPERTY_FILE_<?=$propertyID?>_<?=$arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] : $i?>" />
							
							<? if (!empty($value) && is_array($arResult["ELEMENT_FILES"][$value])){?>
							
								<input type="checkbox" name="DELETE_FILE[<?=$propertyID?>][<?=$arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] : $i?>]" id="file_delete_<?=$propertyID?>_<?=$i?>" value="Y" /><label for="file_delete_<?=$propertyID?>_<?=$i?>"><?=GetMessage("IBLOCK_FORM_FILE_DELETE")?></label>
								<? if ($arResult["ELEMENT_FILES"][$value]["IS_IMAGE"]) {?>
									<img src="<?=$arResult["ELEMENT_FILES"][$value]["SRC"]?>" height="<?=$arResult["ELEMENT_FILES"][$value]["HEIGHT"]?>" width="<?=$arResult["ELEMENT_FILES"][$value]["WIDTH"]?>" border="0" />
								<? } else { ?>
									<?=GetMessage("IBLOCK_FORM_FILE_NAME")?>: <?=$arResult["ELEMENT_FILES"][$value]["ORIGINAL_NAME"]?>
									<?=GetMessage("IBLOCK_FORM_FILE_SIZE")?>: <?=$arResult["ELEMENT_FILES"][$value]["FILE_SIZE"]?> b
									[<a href="<?=$arResult["ELEMENT_FILES"][$value]["SRC"]?>"><?=GetMessage("IBLOCK_FORM_FILE_DOWNLOAD")?></a>]
								<? }
								
							}
						}

					break;
					
					case "L":

						if ($arResult["PROPERTY_LIST_FULL"][$propertyID]["LIST_TYPE"] == "C")
							$type = $arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE"] == "Y" ? "checkbox" : "radio";
						else
							$type = $arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE"] == "Y" ? "multiselect" : "dropdown";

						/*case l-type*/
						switch ($type):
						
							case "checkbox":
							case "radio":
							
								foreach ($arResult["PROPERTY_LIST_FULL"][$propertyID]["ENUM"] as $key => $arEnum) {
									
									$checked = false;
									
									if ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0) {
										if (is_array($arResult["ELEMENT_PROPERTIES"][$propertyID])) {
											foreach ($arResult["ELEMENT_PROPERTIES"][$propertyID] as $arElEnum) {
												if ($arElEnum["VALUE"] == $key) {
													$checked = true;
													break;
												}
											}
										}
									} else {
										if ($arEnum["DEF"] == "Y") $checked = true;
									} ?>
									
										<div class="bxr-<?=$type?>">
										<input type="<?=$type?>" name="PROPERTY[<?=$propertyID?>]<?=$type == "checkbox" ? "[".$key."]" : ""?>" value="<?=$key?>" id="property_<?=$key?>"<?=$checked ? " checked=\"checked\"" : ""?> />
										<label class="bxr-label" for="property_<?=$key?>"><?=$arEnum["VALUE"]?></label>
									</div>                                                                                        
								<? }
							break;

							case "dropdown":
							case "multiselect": ?>
							
								<select class="bxr-form-select form-control" name="PROPERTY[<?=$propertyID?>]<?=$type=="multiselect" ? "[]\" size=\"".$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"]."\" multiple=\"multiple" : ""?>">
									<option value=""><?echo GetMessage("CT_BIEAF_PROPERTY_VALUE_NA")?></option>
									
									<? if (intval($propertyID) > 0) $sKey = "ELEMENT_PROPERTIES";
									else $sKey = "ELEMENT";

									foreach ($arResult["PROPERTY_LIST_FULL"][$propertyID]["ENUM"] as $key => $arEnum) {
										
										$checked = false;
										
										if ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0) {
											foreach ($arResult[$sKey][$propertyID] as $elKey => $arElEnum) {
												if ($key == $arElEnum["VALUE"]) {
													$checked = true;
													break;
												}
											}
										} else {
											if ($arEnum["DEF"] == "Y") $checked = true;
										}
										?>
										<option value="<?=$key?>" <?=$checked ? " selected=\"selected\"" : ""?>><?=$arEnum["VALUE"]?></option>
									<? } ?>
									
								</select>
								<?
							break;

						endswitch;
						/*end case l-type*/
						
					break;
				
				endswitch;
				/*end case type*/
				?>
			
			<?endforeach;?>
			<? /*end propeties list*/ ?>

			<?$frame = $this->createFrame()->begin("");?>                                                                
			<?if($arParams["USE_CAPTCHA"] == "Y" && $arParams["ID"] <= 0):?>
			
				<span class="bxr-pr-name"><?=GetMessage("IBLOCK_FORM_CAPTCHA_TITLE")?> <span class="starrequired">*</span></span>
				<div class="captchaBlock">
					<div>
						<input type="hidden" class="captchaSid" name="captcha_sid" value="<?=$arResult['CAPTCHA_CODE']?>" />
						<div class="captchaImgContent">
							<img class="captchaImg" src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult['CAPTCHA_CODE']?>" width="180" height="40" alt="CAPTCHA" />
						</div>
						<i class="reloadCaptcha fa fa-refresh bxr-font-color" ></i>
					</div>
					<div>
						<input class="inputCaptcha form-control" type="text" name="captcha_word" maxlength="50" value="">
					</div>
				</div>
			<?endif?>
			
			<?$frame->end();?>

			<?if ($arResult['USE_PERSONAL_ACCEPT']):?>
				
				<div class="bxr-personal-accept bxr-checkbox <? if ($arResult["ERRORS"]["PERSONAL"]):?>error<?endif?>">
					<input type="checkbox" name="accept_personal" value="yes" <?=($_REQUEST["accept_personal"]== "yes")? " checked" : ""?> id="accept_form_<?=$arParams["IBLOCK_ID"]?>_<?=$BXR_FORM_COUNTER?>">
					<label class="bxr-label" data-name="accept_personal" for="accept_form_<?=$arParams["IBLOCK_ID"]?>_<?=$BXR_FORM_COUNTER?>">&nbsp;
						<? /* for seo ?>
						<?=$arResult['PERSONAL_SETTINGS']['CAPTION']?> (<a href="<?=$arResult['PERSONAL_SETTINGS']['URL']?>" target="_blank"><?=$arResult['PERSONAL_SETTINGS']['ACCEPT_DOCUMENT']?></a>)
						<? */ ?>
						<span data-part="1"></span> (<a href="<?=$arResult['PERSONAL_SETTINGS']['URL']?>" target="_blank"><span data-part="2"></span></a>)
					</label>
					<? if ($arResult["ERRORS"]["PERSONAL"]):?>
						<span class="error"><?=$arResult["ERRORS"]["PERSONAL"]?></span>
					<? endif; ?>
				</div>
				<div class="bxr-personal-accept bxr-checkbox <? if ($arResult["ERRORS"]["PERSONAL2"]):?>error<?endif?>">
					<input type="checkbox" name="accept_personal2" value="yes" <?=($_REQUEST["accept_personal2"]== "yes")? " checked" : ""?> id="accept_form_<?=$arParams["IBLOCK_ID"]?>_<?=$BXR_FORM_COUNTER?>2">
					<label class="bxr-label" data-name="accept_personal2" for="accept_form_<?=$arParams["IBLOCK_ID"]?>_<?=$BXR_FORM_COUNTER?>2">&nbsp;
						<? /* for seo ?>
						<?=$arResult['PERSONAL_SETTINGS']['CAPTION2']?> <a href="<?=$arResult['PERSONAL_SETTINGS']['URL2']?>" target="_blank"><?=$arResult['PERSONAL_SETTINGS']['ACCEPT_DOCUMENT2']?></a>
						<? */ ?>
						<span data-part="1"></span> <a href="<?=$arResult['PERSONAL_SETTINGS']['URL2']?>" target="_blank"><span data-part="2"></span></a>
					</label>
					<? if ($arResult["ERRORS"]["PERSONAL2"]):?>
						<span class="error"><?=$arResult["ERRORS"]["PERSONAL2"]?></span>
					<? endif; ?>
				</div>
				
			<?endif;?>
		
		<?endif?>
		
		<div class="bxr-button-group text-left">

			<button onclick="BXReady.Market.formRefresh('<?=$arParams['IDENTITY']?>');return false;" class="bxr-color bxr-color-button" id="submitForm_<?=$arParams['IDENTITY']?>">
				<?if(strlen($arParams["BXR_FORM_SUBMIT_ICON"]) > 0):?>
					<span class="<?=$arParams["BXR_FORM_SUBMIT_ICON"]?>"></span>
				<?endif;?>
				<?=strlen($arParams["BXR_FORM_SUBMIT_CAPTION"]) > 0 ? $arParams["BXR_FORM_SUBMIT_CAPTION"] : GetMessage("IBLOCK_FORM_SUBMIT")?>
			</button>
			
			<?if (strlen($arParams["LIST_URL"]) > 0):?>
				<input type="submit" name="iblock_apply" value="<?=GetMessage("IBLOCK_FORM_APPLY")?>" />
				<input
					type="button"
					name="iblock_cancel"
					value="<? echo GetMessage('IBLOCK_FORM_CANCEL'); ?>"
					onclick="location.href='<? echo CUtil::JSEscape($arParams["LIST_URL"])?>';"
				>
			<?endif?>
		</div>
		
	</form>

</div>

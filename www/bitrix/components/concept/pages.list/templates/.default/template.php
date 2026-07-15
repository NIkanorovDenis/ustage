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
?>

<?global $DB_cham;?>

<div class="hidden-sm hidden-xs">

    <div class="hameleon-main-setting">
        <div class="hameleon-btn mgo-widget-call_pulse">
            
        </div>
        <span><?=GetMessage("HAM_PUBLIC_SET_BUTTON_TIP")?></span>
    </div>

    <div class="hameleon-sets-list-wrap">

        <div class="hameleon-sets-list">

            <div class="hameleon-sets-list-table">
                <div class="hameleon-sets-list-cell">
                    <a class="hameleon-sets-list-item addpage hameleon-sets-open" data-open-set='addpage'>
                        <span class="set-icon"><?=GetMessage("HAM_PUBLIC_SET_ADDPAGE")?></span>
                    </a>
                    <div class="vertic-line"></div>
                </div>
                <div class="hameleon-sets-list-cell">
                    <a class="hameleon-sets-list-item edit-sets hameleon-sets-open" data-open-set='edit-sets'>
                        <span class="set-icon"><?=GetMessage("HAM_PUBLIC_SET_EDIT_SETS")?></span>
                    </a>
                </div>
                <div class="hameleon-sets-list-cell">
                   
                    <a class="hameleon-sets-list-item addblock" href='/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=<?=$arParams["IBLOCK_ID"]?>&type=<?=$arParams["IBLOCK_TYPE"]?>&ID=0&lang=ru&IBLOCK_SECTION_ID=<?=$arParams["CURRENT_SECTION_ID"]?>&find_section_section=<?=$arParams["CURRENT_SECTION_ID"]?>&from=iblock_list_admin' target='_blank'>
                        <span class="set-icon"><?=GetMessage("HAM_PUBLIC_SET_ADDBLOCK")?></span>
                    </a>
                </div>
                <div class="hameleon-sets-list-cell">
                    <a class="hameleon-sets-list-item seo hameleon-sets-open" data-open-set='seo'>
                        <span class="seo-name">SEO</span>
                        <span class="set-icon"><?=GetMessage("HAM_PUBLIC_SET_SEO")?></span>
                        <span class="status-seo seo-<?=$arResult["SEO_CLASS"]?>"></span>
                    </a>
                </div>
                <div class="hameleon-sets-list-cell">
                    <div class="hameleon-sets-list-close">
                        
                    </div>
                    <span><?=GetMessage("HAM_PUBLIC_SET_CLOSE_LIST_SET")?></span>
                </div>
            </div>
        </div>


        <div class="hameleon-sets-list-left">
           
            <a class="hameleon-sets-list-item hameleon-sets-open forms" data-open-set='forms'>
                <span class="set-icon"><?=GetMessage("HAM_PUBLIC_SET_FORMS")?></span>
            </a>
            <a class="hameleon-sets-list-item hameleon-sets-open modals" data-open-set='modals'>
                <span class="set-icon"><?=GetMessage("HAM_PUBLIC_SET_MODAL")?></span>
            </a>              
          
        </div>

    </div>


    <div class="sets-shadow"></div>
    
    
    <?foreach($arResult["SECTIONS"] as $arSection):?>
        
        <?if($arSection["ID"] == $GLOBALS["CURRENT_SECTION_ID"]):?>
        
            <div class="hameleon-setting edit-sets">
                <div class="inner">

                    <div class="hameleon-set-head">
                        <table>
                            <tr>
                                <td class="col-lg-2 col-md-2 col-sm-3 col-xs-3 hameleon-set-image"><div></div></td>
                                <td class="col-lg-8 col-md-8 col-sm-6 col-xs-6 hameleon-set-name bold"><?=GetMessage("HAM_PUBLIC_SET_EDIT_SETS")?></td>
                                <td class="col-lg-2 col-md-2 col-sm-3 col-xs-3"></td>
                            </tr>
                        </table>

                        <a class="hameleon-set-close"></a>
                        
                    </div>

                    <form action="/" class="form form-setting" enctype="multipart/form-data" method="post" role="form">
                        
                        <input type="hidden" name="server_url" value="<?=$arResult["SERVER_URL"]?>" />
                        <input type="hidden" name="site_id" id="site_id" value="<?=SITE_ID?>" />
                        
                        <input type="hidden" name="section_id" name="section_id" value="<?=$GLOBALS["CURRENT_SECTION_ID"]?>" />

                        <div class="hameleon-set-content">
                            <table class="sides">
                                <tr>
                                    <td class='set-side-left'>
                                        <ul class="set-tabs">
                                            <li class='active' data-set='instruct'><?=GetMessage("HAM_SETS_TAB_1")?></li>
                                            <li data-set='base'><?=GetMessage("HAM_SETS_TAB_2")?></li>
                                            <li data-set='contacts'><?=GetMessage("HAM_SETS_TAB_4")?></li>
                                            <li data-set='head'><?=GetMessage("HAM_SETS_TAB_3")?></li>
                                            <li data-set='footer'><?=GetMessage("HAM_SETS_TAB_5")?></li>
                                            <li data-set='domain'><?=GetMessage("HAM_SETS_TAB_6")?></li>
                                            <li data-set='services'><?=GetMessage("HAM_SETS_TAB_7")?></li>
                                            <li data-set='lids'><?=GetMessage("HAM_SETS_TAB_8")?></li>
                                            <li data-set='politic'><?=GetMessage("HAM_SETS_TAB_9")?></li>
                                            <li data-set='cart'><?=GetMessage("HAM_SETS_TAB_12")?></li>
                                            <li data-set='customs'><?=GetMessage("HAM_SETS_TAB_10")?></li>
                                            <li data-set='other'><?=GetMessage("HAM_SETS_TAB_11")?></li>
                                            
                                        </ul>
                                        <div class="other-li">
                                            <a href="/bitrix/admin/iblock_section_edit.php?IBLOCK_ID=<?=$arParams["IBLOCK_ID"]?>&type=<?=$arParams["IBLOCK_TYPE"]?>&ID=<?=$arSection["ID"]?>&lang=ru&find_section_section=0" target="_blank">
                                            <?=GetMessage("HAM_PUBLIC_SET_EDIT_SETS_EDIT_IN_ADMIN")?>
                                            </a>
                                        </div>
                                    </td>
                                    
                                    <td class='set-side-right'>

                                        <div class="set-content active" data-set='instruct'>
                                            <div class="clearfix">
                                                
                                                <div class="instruct">
                                                    <a target="_blank" href="https://goo.gl/5fup4U"><?=GetMessage("HAM_PUBLIC_SET_INSTRUCT1")?></a>
                                                </div>
                                                <div class="instruct">
                                                    <a target="_blank" href="https://goo.gl/8Sbk8W"><?=GetMessage("HAM_PUBLIC_SET_INSTRUCT7")?></a>
                                                </div>
                                                
                                                <div class="instruct">
                                                    <a target="_blank" href="https://goo.gl/FDFGuo"><?=GetMessage("HAM_PUBLIC_SET_INSTRUCT2")?></a>
                                                </div>
                                                
                                                <div class="instruct">
                                                    <a target="_blank" href="https://goo.gl/NezFV7"><?=GetMessage("HAM_PUBLIC_SET_INSTRUCT3")?></a>
                                                </div>
                                                
                                                <div class="instruct">
                                                    <a target="_blank" href="https://goo.gl/ffvH6d"><?=GetMessage("HAM_PUBLIC_SET_INSTRUCT4")?></a>
                                                </div>
                                                
                                                <div class="instruct">
                                                    <a target="_blank" href="https://goo.gl/sL2KKc"><?=GetMessage("HAM_PUBLIC_SET_INSTRUCT5")?></a>
                                                </div>

                                                <div class="instruct">
                                                    <a target="_blank" href="https://goo.gl/MJ9Dq8"><?=GetMessage("HAM_PUBLIC_SET_INSTRUCT8")?></a>
                                                </div>
                                                
                                                <div class="instruct">
                                                    <a target="_blank" href="https://concept360.ru/marketplace/icons/"><?=GetMessage("HAM_PUBLIC_SET_INSTRUCT6")?></a>
                                                </div>
                                                
                                                
                                            </div>
                                        </div>

                                        <div class="set-content" data-set='base'>

                                            <div class="input-wrap middle-sm">

                                                <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_LIST_PICTURES")?><span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAM_PUBLIC_SET_LIST_PICTURES_HINT")?>"></span></div>
                                                <div class="row clearfix">

                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="input to-right clearfile-parent">

                                                            <label class="file on-save<?if(strlen($arSection["LOGO_NAME"]) > 0):?> focus-anim<?endif;?>">
                                                            
                                                                <input type="hidden" name="imagelogotype" value="<?=$arSection["PICTURE"]?>">

                                                                <input type="hidden" class='hameleon_file_del' name="hameleon_logotype_del" value="">

                                                                <span class="ex-file-desc"><?=GetMessage("HAM_PUBLIC_SET_LOGO")?></span>
                                                                <span class="ex-file"><?=$arSection["LOGO_NAME"]?></span>
                                                                <input type="file" accept="image/*" class="hidden" id="hameleon_logotype" name="hameleon_logotype"/>
                                                            </label>

                                                            <div class="clearfile on-save<?if(strlen($arSection["LOGO_NAME"]) > 0):?> on<?endif;?>"></div>

                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="input to-left clearfile-parent">
                                                            <label class="file on-save<?if(strlen($arSection["FAVICON_NAME"]) > 0):?> focus-anim<?endif;?>">

                                                                <input type="hidden" name="imagefavicon" value="<?=$arSection["DETAIL_PICTURE"]?>">

                                                                <input type="hidden" class='hameleon_file_del' name="hameleon_favicon_del" value="">


                                                                <span class="ex-file-desc"><?=GetMessage("HAM_PUBLIC_SET_FAVICON")?></span>
                                                                <span class="ex-file"><?=$arSection["FAVICON_NAME"]?></span>
                                                                <input type="file" accept="image/*" class="hidden" id="hameleon_favicon" name="hameleon_favicon"/>
                                                            </label>

                                                            <div class="clearfile on-save<?if(strlen($arSection["FAVICON_NAME"]) > 0):?> on<?endif;?>"></div>

                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        
                                            <div class="input-wrap middle-sm">
                                                <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_FONTS")?></div>
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="input to-right in-focus">
                                                            <span class="desk"><?=GetMessage("HAM_PUBLIC_SET_FONT_TITLE")?></span>

                                                            <select name="hameleon_fontTitle" class='on-save'>
                                                                <?foreach($arResult["TITLE_FONTS"] as $arFont):?>
                                                                    <option <?if($arSection["UF_CHAM_TITLE_FONT_VAL"]["XML_ID"] == $arFont["XML_ID"]):?> selected <?endif;?> value="<?=$arFont["ID"]?>"><?=$arFont["VALUE"]?></option>
                                                                <?endforeach;?>
                                                            </select>
                                                        </div>
                                                        
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="input to-left in-focus">
                                                            <span class="desk"><?=GetMessage("HAM_PUBLIC_SET_FONT_TEXT")?></span>

                                                            <select name="hameleon_fontText" class='on-save'>

                                                                <?foreach($arResult["TEXT_FONTS"] as $arFont):?>
                                                                    <option <?if($arSection["UF_CHAM_TEXT_FONT_VAL"]["XML_ID"] == $arFont["XML_ID"]):?> selected <?endif;?> value="<?=$arFont["ID"]?>"><?=$arFont["VALUE"]?></option>
                                                                <?endforeach;?>
                                                            </select>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="input-wrap middle-sm">

                                                <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_COLOR")?></div>
                                                <div class="hameleon-color-row clearfix">
                                                    <?foreach($arResult["MAIN_COLOR"] as $cell => $arColor):?>
                                                        <div class="hameleon-color-col">
                                                            <label>
                                                                <input <?if($arSection["UF_CHAM_MAIN_COLOR_VAL"]["XML_ID"] == $arColor["XML_ID"]):?>checked="checked"<?endif;?> name="hameleon_set_color" type="radio" value="<?=$arColor["ID"]?>">
                                                                <span><span class='on-save <?=$arColor["XML_ID"]?>'></span></span>
                                                            </label>
                                                        </div>

                                                        <?if(($cell+1) % 7 == 0):?>
                                                            <div class="clearfix hidden-xs"></div>
                                                        <?endif;?>
                                                    <?endforeach;?>

                                                </div>
                                            </div>

                                            <div class="input-wrap middle clearfix">
                                          
                                                <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_MAIN_COLOR_USER")?><span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAM_PUBLIC_SET_MAIN_COLOR_USER_HINT")?>"></span></div>
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="input to-right parent-clearcolor">

                                                            <div class="bg"></div>                                        
                                                           

                                                            <?
                                                                $color = ' ';
                                                                if(strlen($arSection["UF_CH_USER_M_COLOR"])>0)
                                                                    $color = $arSection["UF_CH_USER_M_COLOR"];
                                                            ?>


                                                            <input id="picker_hameleon_user_color" class="picker_color on-save" name="hameleon_user_color" type="text" value="<?=$color?>">
                                                            <span class='call_picker on-save'></span>

                                                            <div class="picker-wrap">
                                                                <a class="picker-close"></a>
                                                                <div id="panel_hameleon_user_color" class='picker_panel'></div>
                                                            </div>

                                                            <div class="clearcolor on-save <?if(strlen($arSection["UF_CH_USER_M_COLOR"])>1):?> on<?endif;?>"></div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>



                                            <div class="input-wrap">
                                            
                                                <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_BUTTON_VIEW")?></div>


                                                <ul class='form-radio in-line clearfix'>

                                                    <?foreach($arResult["BUTTONS_VIEW"] as $arBtn):?>
                                                    
                                                        <li class='col-lg-4 col-md-4 col-sm-4 col-xs-12'>
                                                            <label>
                                                                <input class='on-save' <?if($arBtn["ID"] == $arSection["UF_CHAM_BUTTONS_TYPE"]):?> checked="checked"<?endif;?> name="hameleon_buttons_view" type="radio" value="<?=$arBtn["ID"]?>">          
                                                                <span></span>
                                                                <span class="button-def primary <?=$arBtn["XML_ID"]?>"><?=GetMessage("HAM_PUBLIC_SET_BTN_VIEW_NAME")?></span>
                                                            </label>
                                                        </li>

                                                    <?endforeach;?>

                                               </ul>
                                         
                                            </div>

                                            <div class="input-wrap">

                                                <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_CHOOSE_FORMS_TITLE")?> <a target = "_blank" href="/bitrix/admin/iblock_list_admin.php?IBLOCK_ID=<?=$arResult["FORMS_BLOCK"]['ID']?>&type=<?=$arParams["IBLOCK_TYPE"]?>&lang=ru&find_section_section=0" class="edit-icon" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAM_PUBLIC_SET_CHOOSE_FORMS_TITLE_HINT")?>"></a></div>
            
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="input to-right in-focus">
                                                            <span class="desk"><?=GetMessage("HAM_PUBLIC_SET_CHOOSE_FORMS_CALLBACK")?></span>
            
                                                            <select name="hameleon_callback_form" class='on-save'>
                                                                
                                                                <option <?if(strlen($arSection["UF_CHAM_CALLBACK_FRM"]) <= 0):?> selected <?endif;?> value=""><?=GetMessage("HAM_PUBLIC_SET_CHOOSE_FORM")?></option>
                                                                
                                                                <?foreach($arResult["FORMS"] as $k => $arForm):?>
                                                                    <option <?if($arForm["ID"] == $arSection["UF_CHAM_CALLBACK_FRM"]):?> selected <?endif;?> value="<?=$arForm["ID"]?>"><?=$arForm["NAME"]?></option>
                                                                <?endforeach;?>
                                                            </select>
                                                        </div>
                                                        
                                                    </div>
            
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="input to-right in-focus">
                                                            <span class="desk"><?=GetMessage("HAM_PUBLIC_SET_CHOOSE_FORMS_CATALOG")?></span>
            
                                                            <select name="hameleon_catalog_form" class='on-save'>
                                                                
                                                                <option <?if(strlen($arSection["UF_CHAM_CATALOG_FRM"]) <= 0):?> selected <?endif;?> value=""><?=GetMessage("HAM_PUBLIC_SET_CHOOSE_FORM")?></option>
                                                            
                                                                <?foreach($arResult["FORMS"] as $k => $arForm):?>
                                                                    <option <?if($arForm["ID"] == $arSection["UF_CHAM_CATALOG_FRM"]):?> selected <?endif;?> value="<?=$arForm["ID"]?>"><?=$arForm["NAME"]?></option>
                                                                <?endforeach;?>
                                                            </select>
                                                        </div>
                                                        
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="input-wrap">   

                                                <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_MASKS_TITLE")?><span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAM_PUBLIC_SET_MASKS_TITLE_HINT")?>"></span></div> 

                                                <div class="row clearfix">

                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="input to-right in-focus">
                                                            <span class="desk"><?=GetMessage("HAM_PUBLIC_SET_MASKS")?></span>

                                                            <select name="hameleon_mask" class='on-save'>
                                                                <?foreach($arResult["MASKS"] as $arItem):?>
                                                                    <option <?if($arSection["UF_CH_MASK_VAL"]["XML_ID"] == $arItem["XML_ID"]):?> selected <?endif;?> value="<?=$arItem["ID"]?>"><?=$arItem["VALUE"]?></option>
                                                                <?endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="input to-left <?if(strlen($arSection["UF_CH_USER_MASK"]) > 0):?>in-focus<?endif;?>">
                                                            <div class="bg"></div>
                                                            <span class="desc"><?=GetMessage("HAM_PUBLIC_SET_MASK_USER")?></span>       
                                                            <input type="text" class="focus-anim text on-save" name="hameleon_mask_user" value="<?=$arSection["UF_CH_USER_MASK"]?>">
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                            <div class="section-title"><?=GetMessage("HAM_PUBLIC_SET_SECT_LAND_BG")?></div>

                                            <div class="input-wrap middle clearfix">
                                                 <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_LAND_BG_CLR")?><span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAM_PUBLIC_SET_LAND_BG_CLR_HINT")?>"></span></div>
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        
                                                            <div class="input to-right parent-clearcolor">
                                                                <div class="bg"></div>
                                                               
                                                                <?
                                                                    $color = " ";
                                                                    
                                                                    if(strlen($arSection["UF_CH_BODY_BG_CLR"])>0)
                                                                        $color= $arSection["UF_CH_BODY_BG_CLR"];
                                                                ?>
                                                              

                                                                <input id="body_bg_clr" class="picker_color on-save" name="hameleon_body_bg_clr" type="text" value='<?=$color?>'>
                                                                <span class='call_picker on-save'></span>

                                                                <div class="picker-wrap">
                                                                    <a class="picker-close"></a>
                                                                    <div id="picker_body_bg_clr" class='picker_panel on-save'></div>
                                                                </div>

                                                                <div class="clearcolor on-save <?if(strlen($arSection['UF_CH_BODY_BG_CLR']) > 1):?> on<?endif;?>"></div>
                                                                
                                                                
                                                            </div>
                                                    </div>

                                                </div>

                                            </div>

                                            <div class="input-wrap middle clearfix">
                                                <div class="row">

                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="input to-right clearfile-parent">

                                                            <label class="file on-save<?if(strlen($arSection["BODY_BG"]) > 0):?> focus-anim<?endif;?>">
                                                            
                                                                <input type="hidden" name="imagebody_bg" value="<?=$arSection["UF_CH_BODY_BG"]?>">

                                                                <input type="hidden" class='hameleon_file_del' name="body_bg_del" value="">

                                                                <span class="ex-file-desc"><?=GetMessage("HAM_PUBLIC_SET_LAND_BG")?></span>
                                                                <span class="ex-file"><?=$arSection["BODY_BG"]?></span>
                                                                <input type="file" accept="image/*" class="hidden" name="body_bg" />
                                                            </label>

                                                            <div class="clearfile on-save<?if(strlen($arSection["BODY_BG"]) > 0):?> on<?endif;?>"></div>

                                                        </div>
                                                        
                                                    </div>

                                                </div>

                                            </div>

                                            <div class="input-wrap">
                                                <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_LAND_BG_POS")?></div>
                                                <ul class='form-radio'>

                                                    <?foreach($arResult["POS_BODY_BG"] as $arItem):?>

                                                        <li>
                                                            <label>
                                                                <input class='on-save' <?if($arItem["ID"] == $arSection["UF_CH_POS_BODY_BG"]):?> checked="checked"<?endif;?> name="hameleon_pos_body_bg" type="radio" value="<?=$arItem["ID"]?>">          
                                                                <span></span>
                                                                <span class="text"><?=$arItem["VALUE"]?></span>
                                                            </label>
                                                        </li>

                                                    <?endforeach;?>
                                               </ul>
                                            </div>

                                            <div class="input-wrap">
                                                <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_LAND_BG_VIEW")?></div>


                                                <?
                                                    $arEmpty[0] = array("ID" => "", "VALUE" => GetMessage("HAM_PUBLIC_SET_LAND_BG_VIEW_EMPTY"));
                                                    $arResult["BODY_REPEAT_BG"] = array_merge($arEmpty, $arResult["BODY_REPEAT_BG"]);
                                                ?>
                                                 
                                                 <?if(in_array($arSection["UF_CH_BODY_REPEAT_BG"], $arResult["BODY_REPEAT_BG_ID"])):?> <?endif;?>
                                                <ul class='form-radio'>



                                                    <?foreach($arResult["BODY_REPEAT_BG"] as $arItem):?>

                                                        <li>
                                                            <label>
                                                                <input class='on-save' <?if($arItem["ID"] == $arSection["UF_CH_BODY_REPEAT_BG"]):?> checked="checked"<?endif;?> name="hameleon_body_repeat_bg" type="radio" value="<?=$arItem["ID"]?>">          
                                                                <span></span>
                                                                <span class="text"><?=$arItem["VALUE"]?></span>
                                                            </label>
                                                        </li>

                                                    <?endforeach;?>
                                               </ul>
                                            </div>
                                        </div>

                    
                                        <div class="set-content" data-set='head'>

                                            <div class="input-wrap">
                                                <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_LOGOTYPE_POSITION")?></div>


                                                <ul class='form-radio'>
                                                
                                                    <li>
                                                        <label>
                                                            <input class='on-save' <?if($arSection["UF_CHAM_LOGOTYPE"] != 1):?>checked="checked"<?endif;?> name="hameleon_logotype_position" type="radio" value="0">          
                                                            <span></span>
                                                            <span class="text"><?=GetMessage("HAM_PUBLIC_SET_LOGO_LEFT")?></span>
                                                        </label>
                                                    </li>
                                                
                                                    <li>
                                                        <label>
                                                            <input class='on-save' <?if($arSection["UF_CHAM_LOGOTYPE"] == 1):?>checked="checked"<?endif;?> name="hameleon_logotype_position" type="radio" value="1">
                                                            <span></span>
                                                            <span class="text"><?=GetMessage("HAM_PUBLIC_SET_LOGO_CENTER")?></span>
                                                        </label>
                                                    </li>

                                               </ul>
                                         
                                            </div>

                                            <div class="input-wrap">
                                            
                                                <ul class="form-check">                                                
                                                    <li>
                                                        <label>
                                                            <input class='on-save' name="hameleon_callback" <?if($arSection["UF_CHAM_CALLBACK"]):?>checked<?endif;?> type="checkbox" value="1"><span></span><span class="text"><?=GetMessage("HAM_PUBLIC_SET_CALLBACK")?></span> 
                                                        </label>
                                                        
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="input-wrap middle clearfix">
                                                <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_DESCRIPTION")?><span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAM_PUBLIC_SET_DESCRIPTION_HINT")?>"></span></div>
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="input to-right">                                        
                                                            <input type="text" class="text on-save" name="hameleon_description" value="<?=$arSection["UF_CHAM_DESCRIPT"]?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <ul class="form-check alone">                                                
                                                            <li>
                                                                <label>
                                                                    <input class= 'on-save' name="hameleon_backdrop" <?if($arSection["UF_CHAM_DESCRIPT_BK"]):?> checked<?endif;?> type="checkbox" value="1"><span></span><span class="text"><?=GetMessage("HAM_PUBLIC_SET_DESCRIPTION_BACK")?></span>
                                                                </label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="input-wrap">
                                                <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_COLOR_SCHEME")?></div>


                                                <ul class='form-radio'>

                                                    <?foreach($arResult["COLOR_SCHEME"] as $arTone):?>

                                                        <li>
                                                            <label>
                                                                <input class='on-save' <?if($arTone["ID"] == $arSection["UF_CHAM_HEADER_CLR"]):?> checked="checked"<?endif;?> name="hameleon_color_scheme" type="radio" value="<?=$arTone["ID"]?>">          
                                                                <span></span>
                                                                <span class="text"><?=$arTone["VALUE"]?></span>
                                                            </label>
                                                        </li>

                                                    <?endforeach;?>

                                               </ul>
                                            </div>

                                            <div class="input-wrap">

                                                <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_COLOR_HEADER")?></div>

                                                <ul class='form-radio'>

                                                    <?foreach($arResult["COLOR_HEADER"] as $arItem):?>

                                                        <li>
                                                            <label>
                                                                <input class='on-save' <?if($arItem["ID"] == $arSection["UF_CH_COLOR_HEADER"]):?> checked="checked"<?endif;?> name="hameleon_color_header" type="radio" value="<?=$arItem["ID"]?>">          
                                                                <span></span>
                                                                <span class="text"><?=$arItem["VALUE"]?></span>
                                                            </label>
                                                        </li>

                                                    <?endforeach;?>

                                               </ul>

                                            </div>

                                            <div class="input-wrap none">
                                    
                                                
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_HEAD_BG_TITLE")?><span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAM_PUBLIC_SET_HEAD_BG_TITLE_HINT")?>"></span></div>
                                                        <div class="input to-right parent-clearcolor">
                                                            <div class="bg"></div>
                                                           
                                                            <?
                                                                $color = " ";
                                                                
                                                                if(strlen($arSection["UF_CHAM_HEADER_BACK"])>0)
                                                                    $color= $arSection["UF_CHAM_HEADER_BACK"];
                                                            ?>
                                                          

                                                            <input id="head_bg_color" class="picker_color on-save" name="hameleon_header_background" type="text" value='<?=$color?>'>
                                                            <span class='call_picker on-save'></span>

                                                            <div class="picker-wrap">
                                                                <a class="picker-close"></a>
                                                                <div id="picker_head_bg_color" class='picker_panel on-save'></div>
                                                            </div>

                                                            <div class="clearcolor on-save <?if(strlen($arSection['UF_CHAM_HEADER_BACK']) > 1):?> on<?endif;?>"></div>
                                                            
                                                            
                                                        </div>

                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_HEAD_BG_OP_TITLE")?><span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAM_PUBLIC_SET_BG_COLOR_OP_HINT")?>"></span></div>
                                                        <div class="input to-left">                                        
                                                            <input class='on-save' type="text" class="text" name="hameleon_header_background_opacity" value="<?=$arSection["UF_CHAM_HEADER_BK_O"]?>">
                                                        </div>
                                                    </div>

                                                   
                                                </div>
                                            </div>

                                            <div class="input-wrap">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="input to-right clearfile-parent">
                                                        
                                                            <label class="file on-save<?if(strlen($arSection["HEADER_IMG_NAME"]) > 0):?> focus-anim<?endif;?>">

                                                                <input type="hidden" name="imageheader_img" value="<?=$arSection["UF_CHAM_HEADER_IMG"]?>">

                                                                <input type="hidden" class='hameleon_file_del' name="hameleon_header_img_del" value="">


                                                                <span class="ex-file-desc"><?=GetMessage("HAM_PUBLIC_SET_HEADER_IMG")?></span>
                                                                <span class="ex-file"><?=$arSection["HEADER_IMG_NAME"]?></span>
                                                                <input type="file" accept="image/*" class="hidden" id="hameleon_header_img" name="hameleon_header_img" />
                                                            </label>

                                                            <div class="clearfile on-save<?if(strlen($arSection["HEADER_IMG_NAME"]) > 0):?> on<?endif;?>"></div>


                                                        </div>
                                                        
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <ul class="form-check alone">                                                
                                                            <li>
                                                                <label>
                                                                    <input class='on-save' name="hameleon_header_img_cover" <?if($arSection["UF_CHAM_HEADER_IMG_F"]):?> checked<?endif;?> type="checkbox" value="1"><span></span><span class="text"><?=GetMessage("HAM_PUBLIC_SET_HEADER_IMG_COVER")?></span>
                                                                </label>
                                                            </li>
                                                        </ul>
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                            

                                            <!-- MENU -->
                                            <div class="input-wrap big parent-more-option">
                                                <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_MENU_VIEW")?><span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAM_PUBLIC_SET_MENU_VIEW_HINT")?>"></span></div>
                                                <ul class='form-radio clearfix'>

                                                    <?foreach($arResult["MENU_TYPE"] as $k => $arMenuType):?>
                                                    
                                                        <li>
                                                            <label>
                                                                <input class="open_more_options on-save" <?if($arMenuType['XML_ID'] != 'first'):?>data-show-options="menu_type"<?endif;?> <?if($arSection["UF_CHAM_MENU_TYPE"] == $arMenuType["ID"]):?>checked="checked"<?endif;?> name="hameleon_menu_type" type="radio" value="<?=$arMenuType["ID"]?>">          
                                                                <span></span>
                                                                <span class="text"><?=$arMenuType["VALUE"]?></span>
                                                            </label>
                                                        </li>

                                                    <?endforeach;?>

                                               </ul>
                                            </div>

                                            <div class="more-options-wrap">
                                                <div class="more-option <?if($arSection['UF_CHAM_MENU_TYPE_ENUM']["XML_ID"] != '' && $arSection['UF_CHAM_MENU_TYPE_ENUM']["XML_ID"] != 'first'):?> on<?endif;?>" data-show-options='menu_type'>
                                                
                                                    <div class="input-wrap">
                                    
                                                        
                                                        <div class="row">
                                                            
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_MENU_BG_CLR")?><span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAM_PUBLIC_SET_MENU_BG_CLR_HINT")?>"></span></div>
                                                                <div class="input to-right parent-clearcolor">
                                                                    <div class="bg"></div>
                                                                   
                                                                    <?
                                                                        $color = " ";
                                                                        if(strlen($arSection['UF_CHAM_MENU_PLANK'])>0)
                                                                            $color= $arSection['UF_CHAM_MENU_PLANK'];
                                                                    ?>

                                                                    

                                                                    <input id="menu_bg_color" class="picker_color on-save" name="hameleon_menu_background" type="text" value='<?=$color?>'>
                                                                    <span class='call_picker on-save'></span>

                                                                    <div class="picker-wrap">
                                                                        <a class="picker-close"></a>
                                                                        <div id="menu_bg_color_panel" class='picker_panel on-save'></div>
                                                                    </div>

                                                                    <div class="clearcolor on-save <?if(strlen($arSection['UF_CHAM_MENU_PLANK']) > 1):?> on<?endif;?>"></div>
                                                                    
                                                                    
                                                                </div>

                                                            </div>

                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_MENU_BG_CLR_OPACITY")?><span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAM_PUBLIC_SET_MENU_BG_CLR_OPACITY_HINT")?>"></span></div>
                                                                <div class="input to-left">                                        
                                                                    <input class='on-save' type="text" class="text" name="hameleon_menu_background_opacity" value="<?=$arSection["UF_CHAM_MENU_PLANK_O"]?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    
                                                </div>
                                            </div>


                                            <div class="section-title"><?=GetMessage("HAM_PUBLIC_SET_SECT_SLIDEMENU")?></div>

                                            <div class="input-wrap middle">
                                            
                                                <ul class="form-check">                                                
                                                    <li>
                                                        <label>
                                                            <input class='open_more_options on-save' name="hameleon_slidemenu" data-show-options='slide_menu' <?if($arSection["UF_CHAM_SLIDEMENU"]):?>checked<?endif;?> type="checkbox" value="1"><span></span><span class="text"><?=GetMessage("HAM_PUBLIC_SET_SLIDEMENU")?></span> 
                                                        </label>
                                                        
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="more-option <?if($arSection["UF_CHAM_SLIDEMENU"]):?>on<?endif;?>" data-show-options='slide_menu'>

                                                <div class="input-wrap">
                                           
                                                    <ul class="form-check alone">                     
                                                        <li>
                                                            <label>
                                                                <input class= 'on-save' name="hameleon_scrl_cncts" <?if($arSection["UF_CHAM_SCRL_CNCTS"]):?> checked<?endif;?> type="checkbox" value="1"><span></span><span class="text"><?=GetMessage("HAM_PUBLIC_SET_SCRL_CNCTS")?></span>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                      
                                                </div>

                                                <div class="input-wrap">

                                                    <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_VIEW_SCRLL_MENU")?></div>

                                                    <ul class='form-radio'>

                                                        <?
                                                            $arEmpty[0] = array("ID" => "", "VALUE" => GetMessage("HAM_PUBLIC_SET_VIEW_SCRLL_MENU_EMPTY"));
                                                            $arResult["VIEW_SCRLL_MENU"] = array_merge($arEmpty, $arResult["VIEW_SCRLL_MENU"]);
                                                        ?>

                                                        <?foreach($arResult["VIEW_SCRLL_MENU"] as $arItem):?>

                                                            <li>
                                                                <label>
                                                                    <input class='on-save' <?if($arItem["ID"] == $arSection["UF_VIEW_SCRLL_MENU"]):?> checked="checked"<?endif;?> name="hameleon_view_scrll_menu" type="radio" value="<?=$arItem["ID"]?>">          
                                                                    <span></span>
                                                                    <span class="text"><?=$arItem["VALUE"]?></span>
                                                                </label>
                                                            </li>

                                                        <?endforeach;?>

                                                   </ul>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="set-content" data-set='contacts'>

                                            <div class="input-wrap">

                                                <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_CONTACTS_TITLE")?><span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAM_PUBLIC_SET_CONTACTS_TITLE_HINT")?>"></span></div>
                                                <div class="row">

                                                    
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="input to-right <?if(strlen($arSection["UF_CHAM_PHONE"]) > 0):?>in-focus<?endif;?>">
                                                            <div class="bg"></div>
                                                            <span class="desc"><?=GetMessage("HAM_PUBLIC_SET_CONTACTS")?></span>       
                                                            <input type="text" class="focus-anim text on-save" name="hameleon_phone1" value="<?=$arSection["UF_CHAM_PHONE"]?>">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="input to-left <?if(strlen($arSection["UF_CHAM_PHONECOMM1"]) > 0):?>in-focus<?endif;?>"> 
                                                            <div class="bg"></div>
                                                            <span class="desc"><?=GetMessage("HAM_PUBLIC_SET_CONTACTS_DESC")?></span>                                       
                                                            <input type="text" class="focus-anim text on-save" name="hameleon_phone_comm1" value="<?=$arSection["UF_CHAM_PHONECOMM1"]?>">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="input to-right <?if(strlen($arSection["UF_CHAM_PHONE2"]) > 0):?>in-focus<?endif;?>">
                                                            <div class="bg"></div>
                                                            <span class="desc"><?=GetMessage("HAM_PUBLIC_SET_CONTACTS")?></span>       
                                                            <input type="text" class="focus-anim text on-save" name="hameleon_phone2" value="<?=$arSection["UF_CHAM_PHONE2"]?>">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="input to-left <?if(strlen($arSection["UF_CHAM_PHONECOMM2"]) > 0):?>in-focus<?endif;?>"> 
                                                            <div class="bg"></div>
                                                            <span class="desc"><?=GetMessage("HAM_PUBLIC_SET_CONTACTS_DESC")?></span>                                       
                                                            <input type="text" class="focus-anim text on-save" name="hameleon_phone_comm2" value="<?=$arSection["UF_CHAM_PHONECOMM2"]?>">
                                                        </div>
                                                    </div>
                                                        

                                                    
                                                </div>
                                            </div>

                                            <div class="input-wrap">

                                                <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_EMAILS_TITLE")?></div>
                                                
                                                <div class="row">

                                                    
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="input to-right <?if(strlen($arSection["UF_CHAM_EMAIL"]) > 0):?>in-focus<?endif;?>">
                                                            <div class="bg"></div>
                                                            <span class="desc"><?=GetMessage("HAM_PUBLIC_SET_EMAILS")?></span>       
                                                            <input type="text" class="focus-anim text on-save" name="hameleon_email1" value="<?=$arSection["UF_CHAM_EMAIL"]?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="input to-left <?if(strlen($arSection["UF_CHAM_EMAILCOMM1"]) > 0):?>in-focus<?endif;?>"> 
                                                            <div class="bg"></div>
                                                            <span class="desc"><?=GetMessage("HAM_PUBLIC_SET_EMAILS_DESC")?></span>                                       
                                                            <input type="text" class="focus-anim text on-save" name="hameleon_email_comm1" value="<?=$arSection["UF_CHAM_EMAILCOMM1"]?>">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="input to-right <?if(strlen($arSection["UF_CHAM_EMAIL2"]) > 0):?>in-focus<?endif;?>">
                                                            <div class="bg"></div>
                                                            <span class="desc"><?=GetMessage("HAM_PUBLIC_SET_EMAILS")?></span>       
                                                            <input type="text" class="focus-anim text on-save" name="hameleon_email2" value="<?=$arSection["UF_CHAM_EMAIL2"]?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="input to-left <?if(strlen($arSection["UF_CHAM_EMAILCOMM2"]) > 0):?>in-focus<?endif;?>"> 
                                                            <div class="bg"></div>
                                                            <span class="desc"><?=GetMessage("HAM_PUBLIC_SET_EMAILS_DESC")?></span>                                       
                                                            <input type="text" class="focus-anim text on-save" name="hameleon_email_comm2" value="<?=$arSection["UF_CHAM_EMAILCOMM2"]?>">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            
                                            <div class="input-wrap">

                                                <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_SOCIALS_TITLE")?></div>
                                               
                                                <div class="input <?if(strlen($arSection['UF_CHAM_SOC_VK'])>0):?> in-focus<?endif;?>">
                                                    <div class="bg"></div>
                                                    <span class="desc"><?=GetMessage("HAM_PUBLIC_SET_SOCIALS_VK")?></span>
            
                                                    <input type="text" class='focus-anim on-save' name="hameleon_vk" value="<?=$arSection['UF_CHAM_SOC_VK']?>">
                                                    <div class="wrap-i"><i class="concept-vkontakte"></i></div>
                                                </div>
                                                <div class="input <?if(strlen($arSection['UF_CHAM_SOC_FB'])>0):?> in-focus<?endif;?>">  
                                                    <div class="bg"></div>
                                                    <span class="desc "><?=GetMessage("HAM_PUBLIC_SET_SOCIALS_FB")?></span>     
                                                    <input type="text" class='focus-anim on-save' name="hameleon_fb" value="<?=$arSection['UF_CHAM_SOC_FB']?>">
                                                    <div class="wrap-i"><i class="concept-facebook-1"></i></div>
                                                </div>
            
                                                <div class="input <?if(strlen($arSection['UF_CHAM_SOC_TW'])>0):?> in-focus<?endif;?>">
                                                    <div class="bg"></div>
                                                    <span class="desc"><?=GetMessage("HAM_PUBLIC_SET_SOCIALS_TW")?></span>    
                                                    <input type="text" class='focus-anim on-save' name="hameleon_tw" value="<?=$arSection['UF_CHAM_SOC_TW']?>">
                                                    <div class="wrap-i"><i class="concept-twitter-bird-1"></i></div>
                                                </div>
            
                                                <div class="input <?if(strlen($arSection['UF_CHAM_SOC_YT'])>0):?> in-focus<?endif;?>">     
                                                    <div class="bg"></div>
                                                    <span class="desc"><?=GetMessage("HAM_PUBLIC_SET_SOCIALS_YT")?></span>  
                                                    <input type="text" class='focus-anim on-save' name="hameleon_yt" value="<?=$arSection['UF_CHAM_SOC_YT']?>">
                                                    <div class="wrap-i">
                                                        <i class="concept-youtube-play"></i>
                                                    </div>
                                                </div>
            
                                                <div class="input <?if(strlen($arSection['UF_CHAM_SOC_IG'])>0):?> in-focus<?endif;?>">  
                                                    <div class="bg"></div>
                                                    <span class="desc"><?=GetMessage("HAM_PUBLIC_SET_SOCIALS_IG")?></span>  
                                                    <input type="text" class='focus-anim on-save' name="hameleon_ig" value="<?=$arSection['UF_CHAM_SOC_IG']?>">
                                                    <div class="wrap-i">
                                                        <i class="concept-instagram-4"></i>
                                                    </div>
                                                </div>

                                                <div class="input <?if(strlen($arSection['UF_CHAM_SOC_TLG'])>0):?> in-focus<?endif;?>">  
                                                    <div class="bg"></div>
                                                    <span class="desc"><?=GetMessage("HAM_PUBLIC_SET_SOC_TLG")?></span>  
                                                    <input type="text" class='focus-anim on-save' name="hameleon_tlg" value="<?=$arSection['UF_CHAM_SOC_TLG']?>">
                                                    <div class="wrap-i">
                                                        <i class="concept-paper-plane"></i>
                                                    </div>
                                                </div>
                                            
                                            </div>

                                            <div class="input-wrap">
                                            
                                                <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_SOCIALS_POSITION_SHOW")?></div>
                                                
                                                <ul class="form-check">

                                                    <?foreach($arResult["SOCIALS_POSITION"] as $key => $opt):?>

                                                        <li>

                                                            <label>
                                                                <input class='on-save' name="hameleon_socials_position[]" <?if(in_array($opt["ID"], $arSection["UF_CHAM_SOC_VIEW"])):?> checked<?endif;?> type="checkbox" value="<?=$opt["ID"]?>"><span></span><span><?=$opt["VALUE"]?></span> 
                                                            </label>
                                                           
                                                        </li>

                                                    <?endforeach;?>                                             
                                                    
                                                </ul>
                                            </div>
                                            
                                            <div class="input-wrap none">
                                                
                                                <div class="name bold"><?=GetMessage("HAMELEON_SHARE_TITLE")?></div>

                                                <ul class="form-check">                                                
                                                    <li>
                                                        <label>
                                                            <input class='on-save' name="hameleon_use_share" <?if($arSection["UF_CHAM_SHARE"] == 1):?>checked<?endif;?> type="checkbox" value="1"><span></span><span><?=GetMessage("HAMELEON_SHARE_NAME")?></span> 
                                                        </label>
                                                       
                                                    </li>
                                                </ul>
                                                
                                            </div>

                                            

                                            <div class="input-wrap middle-sm">

                                    
                                                <ul class="form-check alone">                                                
                                                    <li>
                                                        <label>
                                                            <input class= 'open_more_options on-save' data-show-options='call_phone_on' name="hameleon_call_phone_on" <?if($arSection["UF_CALL_PHONE_ON"]):?> checked<?endif;?> type="checkbox" value="1"><span></span><span class="text"><?=GetMessage("HAM_PUBLIC_SET_CALL_PHONE_ON")?></span>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="more-option <?if($arSection["UF_CALL_PHONE_ON"]):?>on<?endif;?>" data-show-options='call_phone_on'>

                                                <div class="input-wrap">

                                                    <div class="row clearfix">
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                            <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_CALL_PHONE_MOB")?><span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAM_PUBLIC_SET_CALL_PHONE_MOB_HINT")?>"></span></div>
                                                            <div class="input to-right">                 
                                                                <input type="text" class="text on-save" name="hameleon_call_phone_mob" value="<?=$arSection["UF_CALL_PHONE_MOB"]?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                            <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_CALL_PHN_MOB_DESC")?><span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAM_PUBLIC_SET_CALL_PHN_MOB_DESC_HINT")?>"></span></div>
                                                            <div class="input to-right">                 
                                                                <input type="text" class="text on-save" name="hameleon_call_phone_mob_desc" value="<?=$arSection["UF_CALL_PHN_MOB_DESC"]?>">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                         
         
                                        </div>


                                        <div class="set-content" data-set='footer'>
                                            <div class="input-wrap">
                                                <ul class="form-check">                                                
                                                    <li>
                                                        <label>
                                                            <input class="open_more_options on-save" data-show-options='footer_options' name="hameleon_show_footer" <?if(!$arSection["UF_CHAM_FOOTER_HIDE"]):?>checked<?endif;?> type="checkbox" value="0"><span></span><span><?=GetMessage("HAM_PUBLIC_SET_FOOTER_SHOW")?></span> 
                                                        </label>
                                                       
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="more-option <?if(!$arSection["UF_CHAM_FOOTER_HIDE"]):?>on<?endif;?>" data-show-options='footer_options'>
                                                <div class="input-wrap">

                                                    <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_FOOTER_DESC")?></div>
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                                            <div class="input">                                  
                                                                <input class='on-save' type="text" name="hameleon_footer_desc" value="<?=$arSection["UF_CHAM_FOOTER"]?>">
                                                            </div>
                                                        
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    
                                                    <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_FOOTER_REQS")?></div>
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        
                                                            <div class="input">                                  
                                                                <input class='on-save' type="text" name="hameleon_footer_reqs" value="<?=$arSection["UF_CHAM_FOOTER_REQS"]?>">
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                                <div class="section-title"><?=GetMessage("HAM_PUBLIC_SET_FTR_BG_TITLE")?></div>

                                                <div class="input-wrap none">
                                                    

                                                    <div class="row clearfix">
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                                                            <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_FTR_BG_CLR")?><span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAM_PUBLIC_SET_FTR_BG_CLR_HINT")?>"></span></div>
                                                            <div class="input to-right parent-clearcolor">
                                                                <div class="bg"></div>
                                                               
                                                                <?
                                                                    $color = " ";
                                                                    
                                                                    if(strlen($arSection["UF_CH_FOOTER_BG_CLR"])>0)
                                                                        $color= $arSection["UF_CH_FOOTER_BG_CLR"];
                                                                ?>
                                                              

                                                                <input id="footer_bg_clr" class="picker_color on-save" name="hameleon_footer_bg_clr" type="text" value='<?=$color?>'>
                                                                <span class='call_picker on-save'></span>

                                                                <div class="picker-wrap">
                                                                    <a class="picker-close"></a>
                                                                    <div id="picker_footer_bg_clr" class='picker_panel on-save'></div>
                                                                </div>

                                                                <div class="clearcolor on-save <?if(strlen($arSection['UF_CH_FOOTER_BG_CLR']) > 1):?> on<?endif;?>"></div>
                                                                
                                                                
                                                            </div>

                                                        </div>

                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                            <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_FTR_CLR_OPACTY")?><span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAM_PUBLIC_SET_FTR_CLR_OPACTY_HINT")?>"></span></div>
                                                            <div class="input to-left">                                        
                                                                <input type="text" class="text on-save" name="hameleon_ftr_clr_opacity" value="<?=$arSection["UF_CH_FTR_CLR_OPACTY"]?>">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="input-wrap">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                            <div class="input to-right clearfile-parent">

                                                                <label class="file on-save<?if(strlen($arSection["FTR_BG"]) > 0):?> focus-anim<?endif;?>">
                                                                
                                                                    <input type="hidden" name="imageftr_bg" value="<?=$arSection["UF_CH_FTR_BG"]?>">

                                                                    <input type="hidden" class='hameleon_file_del' name="hameleon_ftr_bg_del" value="">

                                                                    <span class="ex-file-desc"><?=GetMessage("HAM_PUBLIC_SET_FTR_BG")?></span>
                                                                    <span class="ex-file"><?=$arSection["FTR_BG"]?></span>
                                                                    <input type="file" accept="image/*" class="hidden" name="hameleon_ftr_bg"/>
                                                                </label>

                                                                <div class="clearfile on-save<?if(strlen($arSection["FTR_BG"]) > 0):?> on<?endif;?>"></div>

                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="section-title"><?=GetMessage("HAM_PUBLIC_SET_COPYRIGHT_SHOW_TITLE")?></div>


                                                <div class="input-wrap middle">
                                                    <ul class="form-check">                                                
                                                        <li>
                                                            <label>
                                                                <input class="open_more_options on-save" data-show-options='footer_author_show' name="hameleon_show_copyright" <?if(!$arSection["UF_CHAM_COPYRIGHT"]):?>checked<?endif;?> type="checkbox" value="0"><span></span><span><?=GetMessage("HAM_PUBLIC_SET_COPYRIGHT_SHOW")?></span> 
                                                            </label>
                                                            
                                                        
                                                        </li>

                                                    </ul>

                                                    <div class="more-option <?if(!$arSection["UF_CHAM_COPYRIGHT"]):?>on<?endif;?>" data-show-options='footer_author_show'>

                                                        <div class="input-wrap parent-more-option">

                                                            <ul class='form-radio clearfix'>

                                                                <li>
                                                                    <label>
                                                                        <input class="open_more_options on-save" data-show-options='' <?if($arResult["CHOOSECOPY"][0]["ID"] == $arSection["UF_CHAM_CHOOSECOPY"]):?>checked="checked"<?endif;?> name="hameleon_choose_copyright" type="radio" value="<?=$arResult["CHOOSECOPY"][0]["ID"]?>">          
                                                                        <span></span>
                                                                        <span class="text"><?=$arResult["CHOOSECOPY"][0]["VALUE"]?></span>
                                                                    </label>
                                                                </li>

                                                                <li>
                                                                    <label>
                                                                        <input class="open_more_options on-save" data-show-options='footer_author_type_user' <?if($arResult["CHOOSECOPY"][1]["ID"] == $arSection["UF_CHAM_CHOOSECOPY"]):?>checked="checked"<?endif;?> name="hameleon_choose_copyright" type="radio" value="<?=$arResult["CHOOSECOPY"][1]["ID"]?>">          
                                                                        <span></span>
                                                                        <span class="text"><?=$arResult["CHOOSECOPY"][1]["VALUE"]?></span>
                                                                    </label>
                                                                </li>

                                                           </ul>
                                                     
                                                        </div> 


                                                        <div class="more-options-wrap">
                                                            <div class="more-option <?if($arResult["CHOOSECOPY"][1]["ID"] == $arSection["UF_CHAM_CHOOSECOPY"]):?>on<?endif;?>" data-show-options='footer_author_type_user'>

                                                               <div class="input-wrap clearfix">

                                                                    <div class="row">
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                            <div class="input to-right <?if(strlen($arSection["UF_CHAM_LINK_TEXT"]) > 0):?> in-focus<?endif;?>">

                                                                                <span class="desc"><?=GetMessage("HAM_PUBLIC_SET_COPYRIGHT_TEXT")?></span>

                                                                                <input type="text" class="focus-anim on-save" name="hameleon_copyright_link_text" value="<?=$arSection["UF_CHAM_LINK_TEXT"]?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                            <div class="input to-left clearfile-parent">
                                                                            
                                                                            
                                                                                <label class="file on-save <?if(strlen($arSection["COPYRIGHT"]) > 0):?> focus-anim<?endif;?>">
                                                                                    
                                                                                    <input type="hidden" name="imagecopyright_img" value="<?=$arSection["UF_CHAM_COPYPICTURE"]?>">

                                                                                    <input type="hidden" class='hameleon_file_del' name="hameleon_copyright_picture_del" value="">
                                                                                
                                                                                    <span class="ex-file-desc"><?=GetMessage("HAM_PUBLIC_SET_COPYRIGHT_PICTURE")?></span>
                                                                                    <span class="ex-file"><?=$arSection["COPYRIGHT"]?></span>
                                                                                    <input type="file" accept="image/*" class="hidden" name="hameleon_copyright_picture" />
                                                                                </label>
                                                                                
                                                                                <div class="clearfile on-save<?if(strlen($arSection["UF_CHAM_COPYPICTURE"]) > 0):?> on<?endif;?>"></div>
                                                                                
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        
                                                                            <div class="input <?if(strlen($arSection["UF_CHAM_LINK"]) > 0):?>in-focus<?endif;?>">
                                                                            
                                                                                <span class="desc"><?=GetMessage("HAM_PUBLIC_SET_COPYRIGHT_LINK")?></span>
                                                                                
                                                                                <input type="text" class="focus-anim on-save" name="hameleon_copyright_link" value="<?=$arSection["UF_CHAM_LINK"]?>">
                                                                                
                                                                            
                                                                            </div>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                

                                            </div>

                                            
                                          
                                        </div>

                                        <div class="set-content" data-set='domain'>
                                        
                                            <div class="input-wrap">
                                                
                                                <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_SITENAME")?></div>
                                                
                                                <div class="input">
                                                    <div class="bg"></div>
                                                    
                                                    <input type="text" class="on-save" name="hameleon_name_site" value="<?=$arSection['NAME']?>">
                                                </div>
                                            
                                            </div>

                                            <div class="input-wrap clearfix">

                                                <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_ID_LAND")?><span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAM_PUBLIC_SET_ID_LAND_HINT")?>"></span></div>
                                                <div class="edit_land">
                                                    
                                                    <div class="input">

                                                        <div class="wrap-change on-save"><span class="change"><?=GetMessage("HAM_PUBLIC_SET_CHANGE")?></span></div>                
                                                        <input disabled="disabled" type="text" name="hameleon_code" value="<?=$arSection["CODE"]?>" >
                                                    </div>

                                                    <div class="domen">
                                                        <div class="arrow"></div>
                                                        <?=$arResult["SERVER_URL2"]?><?=SITE_DIR?><span class="new_url bold"><?=$arSection["CODE"]?></span><span class='backslash <?if(strlen($arSection["CODE"])==0):?>off<?endif;?>'>/</span>
                                                    </div>

                                                </div>
                                            </div>
                                            
                                            <div class="input-wrap">
                                            
                                                <ul class="form-check">                                                
                                                    <li>
                                                        <label>
                                                            <input class="open_more_options on-save" data-show-options='include_domen' name="hameleon_domen_on" <?if(strlen($arSection["UF_CHAM_URL"]) > 0):?> checked<?endif;?> type="checkbox" value=""><span></span><span ><?=GetMessage("HAM_PUBLIC_SET_INCLUDE_DOMEN")?></span> <!--span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAM_PUBLIC_SET_INCLUDE_DOMEN_HINT")?>"></span-->
                                                            
                                                        </label>
                                                       
                                                    </li>
                                                </ul>
                                                
            
                                                <div class="more-option <?if(strlen($arSection["UF_CHAM_URL"]) > 0):?>on<?endif;?>" data-show-options='include_domen'>
                                                    <div class="input <?if(strlen($arSection["UF_CHAM_URL"]) > 0):?>in-focus<?endif;?>">
                                                        <span class="desc"><?=GetMessage("HAM_PUBLIC_SET_INCLUDE_DOMEN_TITLE")?></span>
                                                        <input class='on-save focus-anim' type="text"  name="hameleon_domen" value="<?=$arSection["UF_CHAM_URL"]?>">
                                                    </div>
                                                    
                                                    
                                                    <div class="spec-comment italic no-line">
                                                        <?=GetMessage("HAM_PUBLIC_SET_INCLUDE_DOMEN_COMMENT")?>
                                                    </div>
            
                                                    <div class="instruct mt">
                                                        <a target="_blank" href="https://goo.gl/FDFGuo"><?=GetMessage("HAM_PUBLIC_SET_INCLUDE_DOMEN_INSTRUCT")?></a>
                                                    </div>
                                                </div>
                                                
                                            </div>
             
                                        </div>


                                        <div class="set-content" data-set='services'>
                                        
                                            <div class="input-wrap">
                                                
                                                
                                                <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_ANALYTICS")?><span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAM_PUBLIC_SET_ANALYTICS_HINT")?>"></span></div>
                                                
                                                <div class="row">
                                            
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        
                                                        <div class="input <?if(strlen($arSection["UF_CHAM_METRIKA"]) > 0):?>in-focus<?endif;?>">
                                                        
                                                            <span class="desc"><?=GetMessage("HAM_PUBLIC_SET_METRIKA")?></span>
                                                            
                                                            <input type="text" class="focus-anim on-save" name="hameleon_analytics_metrika" value="<?=$arSection["UF_CHAM_METRIKA"]?>">
                                                            
                                                        
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        
                                                        <div class="input <?if(strlen($arSection["UF_CHAM_GOOGLE"]) > 0):?>in-focus<?endif;?>">
                                                        
                                                            <span class="desc"><?=GetMessage("HAM_PUBLIC_SET_GA")?></span>
                                                            
                                                            <input type="text" class="focus-anim on-save" name="hameleon_analytics_ga" value="<?=$arSection["UF_CHAM_GOOGLE"]?>">
                                                            
                                                        
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        
                                                        <div class="input <?if(strlen($arSection["UF_CHAM_GTM"]) > 0):?>in-focus<?endif;?>">
                                                        
                                                            <span class="desc"><?=GetMessage("HAM_PUBLIC_SET_GTM")?></span>
                                                            
                                                            <input type="text" class="focus-anim on-save" name="hameleon_analytics_gtm" value="<?=$arSection["UF_CHAM_GTM"]?>">
                                                            
                                                        
                                                        </div>
                                                        
                                                    </div>
                                                
                                                </div>
                                                                    
                                            </div>
                                            
                                        
                                            <div class="input-wrap">

                                                <div class="section-title"><?=GetMessage("HAM_PUBLIC_SET_SERVICES_TITLE")?></div>

                                                <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_SERVICES1")?></div>
                                    
                                                <div class="textarea middle on-save">
                                                    <textarea name="hameleon_add_inhead"><?=$arSection["UF_CHAM_INHEAD"]?></textarea>
                                                </div>
                                                
                                                <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_SERVICES2")?></div>
                                                
                                                <div class="textarea middle on-save">
                                                    <textarea name="hameleon_add_inbody"><?=$arSection["UF_CHAM_INBODY"]?></textarea>
                                                </div>
                                                
                                                <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_SERVICES3")?></div>
                                                
                                                <div class="textarea middle on-save">
                                                    <textarea name="hameleon_add_inclosebody"><?=$arSection["UF_CHAM_INCLOSEBODY"]?></textarea>
                                                </div>
                                                
                                            </div>
                                                                                        
                                        </div>

                                        <div class="set-content" data-set='lids'>
                                        
                                            <div class="input-wrap middle">
                                            
                                                <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_ADMIN_EMAIL")?> <span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAM_PUBLIC_SET_ADMIN_EMAIL_HINT")?>"></span></div>
                                                <div class="row">
                                                
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                    
                                                        <div class="input to-right <?if(strlen($arSection["UF_CHAM_EMAIL_FROM"])>0):?> in-focus<?endif;?>">     
                                                            <span class="desc"><?=GetMessage("HAM_PUBLIC_SET_EMAIL_FROM")?></span>                                   
                                                            <input type="text" class="focus-anim email on-save" name="hameleon_email_from" value="<?=$arSection["UF_CHAM_EMAIL_FROM"]?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="input to-left <?if(strlen($arSection["UF_CHAM_EMAIL_TO"])>0):?> in-focus<?endif;?>"> 
                                                            <span class="desc"><?=GetMessage("HAM_PUBLIC_SET_EMAIL_TO")?></span>                                       
                                                            <input type="text" class="focus-anim email on-save" name="hameleon_email_to" value="<?=$arSection["UF_CHAM_EMAIL_TO"]?>">
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="input-wrap none">
                                                <ul class="form-check">                                                
                                                    <li>
                                                        <label>
                                                            <input class='on-save' name="hameleon_save_infoblock" <?if($arSection["UF_CHAM_INFOBLOCK"] == 1):?>checked<?endif;?> type="checkbox" value="1"><span></span><span class="text"><?=GetMessage("HAM_PUBLIC_SET_SAVE_INFOBLOCK")?></span> 
                                                        </label>
                                                        
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="input-wrap none">
                                                <ul class="form-check">                                                
                                                    <li>
                                                        <label>
                                                            <input class="open_more_options on-save" data-show-options='bx_options' name="hameleon_b24" <?if($arSection["UF_CHAM_B24"] == 1):?>checked<?endif;?> type="checkbox" value="1"><span></span><span><?=GetMessage("HAM_PUBLIC_SET_SAVE_B24")?></span> 
                                                        </label>
                                                        <span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAM_PUBLIC_SET_SAVE_B24_HINT")?>"></span>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="more-option <?if($arSection["UF_CHAM_B24"]):?>on<?endif;?>" data-show-options='bx_options'>

                                                <div class="input-wrap">

                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        
                                                            <div class="input <?if(strlen($arSection["UF_CHAM_B24_URL"])>0):?> in-focus<?endif;?>">   
                                                              
                                                                <span class="desc"><?=GetMessage("HAM_PUBLIC_SET_B24_URL")?></span></span>                                   
                                                                <input type="text" class="focus-anim on-save" name="hameleon_b24_url" value="<?=$arSection["UF_CHAM_B24_URL"]?>">
                                                            </div>
                                                            
                                                        </div>
                                                        
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                            <div class="input to-right <?if(strlen($arSection["UF_CHAM_B24_LOGIN"])>0):?> in-focus<?endif;?>">     
                                                                <span class="desc"><?=GetMessage("HAM_PUBLIC_SET_B24_LOGIN")?></span>                                   
                                                                <input type="text" class="focus-anim on-save" name="hameleon_b24_login" value="<?=$arSection["UF_CHAM_B24_LOGIN"]?>">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                            <div class="input to-left <?if(strlen($arSection["UF_CHAM_B24_PASSWORD"])>0):?>in-focus<?endif;?>"> 
                                                                
                                                                <span class="desc"><?=GetMessage("HAM_PUBLIC_SET_B24_PASSWORD")?></span>                                       
                                                                <input type="text" class="focus-anim on-save" name="hameleon_b24_password" value="<?=$arSection["UF_CHAM_B24_PASSWORD"]?>">
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="input-wrap">
                                                <ul class="form-check">                                                
                                                    <li>
                                                        <label>
                                                            <input class="open_more_options on-save" data-show-options='amo_options' name="hameleon_amo" <?if($arSection["UF_CHAM_AMO"] == 1):?>checked<?endif;?> type="checkbox" value="1"><span></span><span class='text'><?=GetMessage("HAM_PUBLIC_SET_SAVE_AMO")?></span> 
                                                        </label>
                                                        
                                                        <span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAM_PUBLIC_SET_SAVE_AMO_HINT")?>"></span>
                                                        
                                                    </li>
                                                </ul>

                                                <div class="more-option <?if($arSection["UF_CHAM_AMO"]):?>on<?endif;?>" data-show-options='amo_options'>

                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        
                                                            <div class="input <?if(strlen($arSection["UF_CHAM_AMO_URL"])>0):?> in-focus<?endif;?>">   
                                                              
                                                                <span class="desc"><?=GetMessage("HAM_PUBLIC_SET_AMO_URL")?></span></span>                                   
                                                                <input type="text" class="focus-anim on-save" name="hameleon_amo_url" value="<?=$arSection["UF_CHAM_AMO_URL"]?>">
                                                            </div>
                                                            
                                                        </div>
                                                        
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                            <div class="input to-right <?if(strlen($arSection["UF_CHAM_AMO_LOGIN"])>0):?> in-focus<?endif;?>">     
                                                                <span class="desc"><?=GetMessage("HAM_PUBLIC_SET_AMO_LOGIN")?></span>                                   
                                                                <input type="text" class="focus-anim on-save" name="hameleon_amo_login" value="<?=$arSection["UF_CHAM_AMO_LOGIN"]?>">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                            <div class="input to-left <?if(strlen($arSection["UF_CHAM_AMO_HASH"])>0):?>in-focus<?endif;?>"> 
                                                                
                                                                <span class="desc"><?=GetMessage("HAM_PUBLIC_SET_AMO_HASH")?></span>                                       
                                                                <input type="text" class="focus-anim on-save" name="hameleon_amo_hash" value="<?=$arSection["UF_CHAM_AMO_HASH"]?>">
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                               
                                                </div>
                                            </div>


                                            <div class="spec-comment italic">
                                                <?=GetMessage("HAM_PUBLIC_SET_COMMENT_LIDS")?>
                                            </div>
                                            
                                        </div>

                                        <div class="set-content" data-set='politic'>

            
                                            <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_AGREEMENT_TEXT")?> <span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAM_PUBLIC_SET_AGREEMENT_TEXT_HINT")?>"></span></div>

                                            <div class="textarea middle">
                                                <textarea class='on-save' name="hameleon_agreement_text"><?=$arSection["UF_CHAM_AGREE_TEXT"]?></textarea>
                                            </div>

                                            <div class="input-wrap">
                                                <ul class="form-check">                                                
                                                    <li>
                                                        <label>
                                                            <input class='on-save' name="hameleon_agreement_y" <?if($arSection["UF_CHAM_AGREEMENTS_Y"] == "1"):?>checked<?endif;?> type="checkbox" value="1"><span></span><span ><?=GetMessage("HAM_PUBLIC_SET_AGREEMENT_CHECK")?></span> 
                                                        </label>
                                                       
                                                    </li>
                                                </ul>
                                            </div>
                                            
                                            <div class="input-wrap">
                                                
                                                <div class="name bold"><?=GetMessage("HAMELEON_AGREEMENT_NAME")?></div>
                                                <?if(!empty($arResult["AGREEMENTS"])):?>

                                                    <ul class="political form-check">

                                                        <?foreach($arResult["AGREEMENTS"] as $key => $agr):?>

                                                            <li>
            
                                                                <label>
                                                                    <input class='on-save' name="hameleon_agreements[]" <?if(in_array($agr["ID"], $arSection["UF_CHAM_AGREEMENTS"])):?> checked<?endif;?> type="checkbox" value="<?=$agr["ID"]?>"><span></span><span><?=$agr["NAME"]?></span> 
                                                                </label>
                                                                
                                                                <a href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=<?=$arResult["AGREEMENT_BLOCK"]["ID"]?>&type=concept_hameleon&ID=<?=$agr['ID']?>&lang=ru&find_section_section=0&WF=Y" target='_blank'></a>
                                                               
                                                            </li>
            
                                                        <?endforeach;?>                                             
                                                        
                                                    </ul>
                                                <?endif;?>
                                                    
                                            </div>
                                            

                                            <div class="button-wrap">
                                                <a href='/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=<?=$arResult["AGREEMENT_BLOCK"]["ID"]?>&type=concept_hameleon&ID=0&lang=ru&IBLOCK_SECTION_ID=0&find_section_section=0&from=iblock_list_admin' target="_blank" class="plus"><?=GetMessage("HAM_PUBLIC_SET_CHOOSE_AGREEMENT_NEW")?></a>
                                            </div>

                                        </div>

                                        <div class="set-content" data-set='customs'>
                                        
                                            <div class="input-wrap no-margin-top-bot">
                                            
                                                <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_CUSTOMS_TITLE1")?><span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAM_PUBLIC_SET_CUSTOMS_TITLE1_HINT")?>"></span></div>
                                    
                                                <div class="textarea middle on-save">
                                                    <textarea name="hameleon_custom_css" placeholder=""><?=$arSection["UF_CHAM_CSS"]?></textarea>
                                                </div>
                                                    
                                                <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_CUSTOMS_TITLE2")?><span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAM_PUBLIC_SET_CUSTOMS_TITLE2_HINT")?>"></span></div>
                                                    
                                                <div class="textarea middle on-save">
                                                    <textarea name="hameleon_custom_js" placeholder=""><?=$arSection["UF_CHAM_SCRIPTS"]?></textarea>
                                                </div>

                                            </div>
                                            
                                        </div>

                                        <div class="set-content" data-set='other'>
                                            <div class="input-wrap">

                                                <div class="name bold"><?=GetMessage("HAM_PUBLIC_SET_SLIDER_TIME_TITLE")?> <span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAM_PUBLIC_SET_SLIDER_TIME_TITLE_HINT")?>"></span></div>
                                               
                                                <div class="input <?if(strlen($arSection['UF_CHAM_SLIDER_TIME'])>0):?> in-focus<?endif;?>">
                                                
                                                    <div class="bg"></div>
                                                    <span class="desc"><?=GetMessage("HAM_PUBLIC_SET_SLIDER_TIME")?></span>
            
                                                    <input type="text" class='focus-anim on-save' name="hameleon_slider_time" value="<?=$arSection['UF_CHAM_SLIDER_TIME']?>">
                                                    
                                                </div>
                                                
                                            </div>
                                            
                                            <div class="input-wrap middle clearfix">
                                            
                                            </div>
                                            
                                            <div class="input-wrap middle">
                                                
                                                <ul class="form-check">                                                
                                                    <li>
                                                        <label>
                                                            <input class='on-save' name="hameleon_show_edit" <?if($arSection["UF_CHAM_SHOW_EDIT"] == 1):?>checked<?endif;?> type="checkbox" value="1"><span></span><span><?=GetMessage("HAMELEON_SHOW_EDIT")?></span> 
                                                        </label>
                                                       
                                                    </li>
                                                    
                                                </ul>
                                            
                                            </div>
                                            
                                            <div class="input-wrap">
                                                
                                                <ul class="form-check">                                                
                                                    <li>
                                                        <label>
                                                            <input class='on-save' name="hameleon_hide_scroll" <?if($arSection["UF_CHAM_HIDESCROLL"] == 1):?>checked<?endif;?> type="checkbox" value="1"><span></span><span><?=GetMessage("HAMELEON_HIDE_SCROLL")?></span> 
                                                        </label>
                                                       
                                                    </li>
                                                    
                                                </ul>
                                            
                                            </div>

                                            <div class="input-wrap">

                                                <div class="name bold"><?=GetMessage("HAM_SET_QUALITY")?><span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAM_SET_QUALITY_HINT")?>"></span></div>
                                               

                                                <div class="row clearfix">
                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                        <div class="input to-right">                                        
                                                            <input type="text" class="text on-save" name="hameleon_quality_imgs" value="<?=$arSection["UF_QUAL_IMAGES"]?>">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            
                                            <div class="section-title"><?=GetMessage("HAMELEON_SET_OTHER_NAMES_TITLE")?></div>

                                            <div class="input-wrap middle-sm">
                                                <div class="input to-right <?if(strlen($arSection["UF_MORE_NAME_TRFF"]) > 0):?>in-focus<?endif;?>">
                                                    <div class="bg"></div>
                                                    <span class="desc"><?=GetMessage("HAMELEON_SET_MODAL_DESC_NAME_TRFF")?></span>       
                                                    <input type="text" class="focus-anim text on-save" name="hameleon_desc_name_trff" value="<?=$arSection["UF_MORE_NAME_TRFF"]?>">
                                                </div>

                                                <div class="input to-right <?if(strlen($arSection["UF_MORE_NAME_SRVC"]) > 0):?>in-focus<?endif;?>">
                                                    <div class="bg"></div>
                                                    <span class="desc"><?=GetMessage("HAMELEON_SET_MODAL_DESC_NAME_SRV")?></span>       
                                                    <input type="text" class="focus-anim text on-save" name="hameleon_desc_name_srv" value="<?=$arSection["UF_MORE_NAME_SRVC"]?>">
                                                </div>

                                                <div class="input to-right <?if(strlen($arSection["UF_CHAM_CATAL_BTN_N2"]) > 0):?>in-focus<?endif;?>">
                                                    <div class="bg"></div>
                                                    <span class="desc"><?=GetMessage("HAMELEON_SET_MODAL_DESC_NAME_CTL")?></span>       
                                                    <input type="text" class="focus-anim text on-save" name="hameleon_desc_name_ctl" value="<?=$arSection["UF_CHAM_CATAL_BTN_N2"]?>">
                                                </div>

                                                <div class="input to-right <?if(strlen($arSection["UF_MORE_NAME_CTLG"]) > 0):?>in-focus<?endif;?>">
                                                    <div class="bg"></div>
                                                    <span class="desc"><?=GetMessage("HAMELEON_SET_CART_MODAL_MAIN_NAME_FAST_ORDER")?></span>       
                                                    <input type="text" class="focus-anim text on-save" name="hameleon_desc_name_fast_order" value="<?=$arSection["UF_MORE_NAME_CTLG"]?>">
                                                </div>

                                            </div>
                                            
                                        </div>

                                        <div class="set-content" data-set='cart'>

                                            <div class="input-wrap clearfix">
                               
                                                <ul class="form-check alone">                                                
                                                    <li>
                                                        <label>
                                                            <input class= 'open_more_options on-save' data-show-options='cart_on' name="hameleon_box_on" <?if($arSection["UF_CH_BOX_ON"]):?> checked<?endif;?> type="checkbox" value="1"><span></span><span class="text"><?=GetMessage("HAMELEON_SET_CART_ON")?></span>
                                                        </label>
                                                    </li>
                                                </ul>

                                            </div>

                                            <div class="more-option <?if($arSection["UF_CH_BOX_ON"]):?>on<?endif;?>" data-show-options='cart_on'>

                                                <div class="section-title"><?=GetMessage("HAMELEON_SET_CART_BASE_TITLE")?></div>

                                                <div class="input-wrap middle-sm clearfix">

                                                    <div class="name bold"><?=GetMessage("HAMELEON_SET_CART_FORMS")?><a target = "_blank" href="/bitrix/admin/iblock_list_admin.php?IBLOCK_ID=<?=$arResult["FORMS_BLOCK"]['ID']?>&type=<?=$arParams["IBLOCK_TYPE"]?>&lang=ru&find_section_section=0" class="edit-icon" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAM_PUBLIC_SET_CHOOSE_FORMS_TITLE_HINT")?>"></a></div>
                                                        <div class="row clearfix">

                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <div class="input to-right in-focus">
                                                                    <span class="desk"><?=GetMessage("HAMELEON_SET_CART_FORM_FAST_ORDER")?></span>

                                                                    <select name="hameleon_form_fast_order" class='on-save'>
                                                                    
                                                                        <option <?if(strlen($arSection["UF_CH_BOX_ONE_CLICK"]) <= 0):?> selected <?endif;?> value=""><?=GetMessage("HAM_PUBLIC_SET_CHOOSE_FORM")?></option>
                                                                        
                                                                        <?foreach($arResult["FORMS"] as $k => $arForm):?>
                                                                            <option <?if($arForm["ID"] == $arSection["UF_CH_BOX_ONE_CLICK"]):?> selected <?endif;?> value="<?=$arForm["ID"]?>"><?=$arForm["NAME"]?></option>
                                                                        <?endforeach;?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <div class="input to-left in-focus">
                                                                    <span class="desk"><?=GetMessage("HAMELEON_SET_CART_FORM_ORDER")?></span>

                                                                    <select name="hameleon_form_order" class='on-save'>
                                                                    
                                                                        <option <?if(strlen($arSection["UF_CH_BOX_ORDER_FORM"]) <= 0):?> selected <?endif;?> value=""><?=GetMessage("HAM_PUBLIC_SET_CHOOSE_FORM")?></option>
                                                                        
                                                                        <?foreach($arResult["FORMS"] as $k => $arForm):?>
                                                                            <option <?if($arForm["ID"] == $arSection["UF_CH_BOX_ORDER_FORM"]):?> selected <?endif;?> value="<?=$arForm["ID"]?>"><?=$arForm["NAME"]?></option>
                                                                        <?endforeach;?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </div>

                                                </div>

                                                <div class="input-wrap middle-sm clearfix">

                                                    <div class="name bold"><?=GetMessage("HAMELEON_SET_CART_BAS_CURR_TITLE")?><a target = "_blank" href="/bitrix/admin/cham_shop_currency.php" class="edit-icon" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAMELEON_SET_CART_BAS_CURR_EDIT")?>"></a></div>
                                                    <div class="row clearfix">

                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                                                            <div class="input to-right in-focus">
                                                                <span class="desk"><?=GetMessage("HAMELEON_SET_CART_BAS_CURR")?></span>

                                                                <select name="hameleon_bas_curr" class='on-save'>
                                                                    <?foreach($DB_cham["CURRENCY"]["ITEMS"] as $arItem):?>s
                                                                        <option <?if($arSection["UF_CH_BAS_CURENCIES"] == $arItem["ID"]):?> selected <?endif;?> value="<?=$arItem["ID"]?>"><?=$arItem["NAME"]?></option>
                                                                    <?endforeach;?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="input-wrap">

                                                    <div class="name bold"><?=GetMessage("HAMELEON_SET_CART_UNITS")?><a target = "_blank" href="/bitrix/admin/cham_shop_units.php" class="edit-icon" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAMELEON_SET_CART_UNITS_EDIT")?>"></a></div>
                                                    <ul class="form-check">
                                                    

                                                        <?foreach($DB_cham["UNITS"]["ITEMS"] as $arItem):?>

                                                            <li>

                                                                <label>
                                                                    <input class='on-save' name="hameleon_cham_units[]" <?if(in_array($arItem["ID"],$arSection["UF_CHAM_UNITS"])):?> checked<?endif;?> type="checkbox" value="<?=$arItem["ID"]?>"><span></span><span><?=$arItem["NAME"]?></span> 
                                                                </label>
                                                               
                                                            </li>

                                                        <?endforeach;?>                                             
                                                        
                                                    </ul>

                                                </div>

                                                <div class="input-wrap">

                                                    <div class="name bold"><?=GetMessage("HAMELEON_SET_CART_PAY_LIST")?><a target = "_blank" href="/bitrix/admin/cham_shop_payment.php" class="edit-icon" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAMELEON_SET_CART_PAY_LIST_EDIT")?>"></a></div>
                                                    <ul class="form-check">
                                                    

                                                        <?foreach($DB_cham["PAYMENT"]["ITEMS"] as $arItem):?>

                                                            <li>

                                                                <label>
                                                                    <input class='on-save' name="hameleon_cham_pay[]" <?if(in_array($arItem["ID"],$arSection["UF_CHAM_PAY"])):?> checked<?endif;?> type="checkbox" value="<?=$arItem["ID"]?>"><span></span><span><?=$arItem["NAME"]?></span> 
                                                                </label>
                                                               
                                                            </li>

                                                        <?endforeach;?>                                             
                                                        
                                                    </ul>

                                                    <div class="input <?if(strlen($arSection["UF_CHAM_PAY_TITLE"]) > 0):?>in-focus<?endif;?>">
                                                        <div class="bg"></div>
                                                        <span class="desc"><?=GetMessage("HAMELEON_SET_CART_PAY_TITLE")?></span>       
                                                        <input type="text" class="focus-anim text on-save" name="hameleon_pay_title" value="<?=$arSection["UF_CHAM_PAY_TITLE"]?>">
                                                    </div>

                                                </div>


                                                <div class="input-wrap big">
                                                    <div class="name bold"><?=GetMessage("HAMELEON_SET_CART_DELIV_LIST")?><a target = "_blank" href="/bitrix/admin/cham_shop_delivery.php" class="edit-icon" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAMELEON_SET_CART_DELIV_LIST_EDIT")?>"></a></div>
                                                    <ul class="form-check">

                                                        <?foreach($DB_cham["DELIVERY"]["ITEMS"] as $opt):?>

                                                            <li>
                                                                <label>
                                                                    <input class='on-save' name="hameleon_cham_deliv[]" <?if(in_array($opt["ID"], $arSection["UF_CHAM_DELIV"])):?> checked<?endif;?> type="checkbox" value="<?=$opt["ID"]?>"><span></span><span><?=$opt["NAME"]?></span> 
                                                                </label>
                                                               
                                                            </li>

                                                        <?endforeach;?>                                             
                                                        
                                                    </ul>

                                                    <div class="input <?if(strlen($arSection["UF_CHAM_DELIV_TITLE"]) > 0):?>in-focus<?endif;?>">
                                                        <div class="bg"></div>
                                                        <span class="desc"><?=GetMessage("HAMELEON_SET_CART_DELIV_TITLE")?></span>       
                                                        <input type="text" class="focus-anim text on-save" name="hameleon_deliv_title" value="<?=$arSection["UF_CHAM_DELIV_TITLE"]?>">
                                                    </div>

                                                </div>

                                                <div class="section-title"><?=GetMessage("HAMELEON_SET_CART_DIZAIN_TITLE")?></div>

                                                <div class="input-wrap none">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                            <div class="input clearfile-parent">

                                                                <label class="file on-save<?if(strlen($arSection["CART_BG_HEAD"]) > 0):?> focus-anim<?endif;?>">
                                                                
                                                                    <input type="hidden" name="imagecart_bg_head" value="<?=$arSection["UF_CH_BOX_BG_HEAD"]?>">

                                                                    <input type="hidden" class='hameleon_file_del' name="hameleon_cart_bg_head_del" value="">

                                                                    <span class="ex-file-desc"><?=GetMessage("HAMELEON_SET_CART_BG_HEAD")?></span>
                                                                    <span class="ex-file"><?=$arSection["CART_BG_HEAD"]?></span>
                                                                    <input type="file" accept="image/*" class="hidden" id="hameleon_cart_bg_head" name="hameleon_cart_bg_head"/>
                                                                </label>

                                                                <div class="clearfile on-save<?if(strlen($arSection["CART_BG_HEAD"]) > 0):?> on<?endif;?>"></div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="input-wrap">

                                                    <div class="input <?if(strlen($arSection["UF_CH_BOX_TITLE"]) > 0):?>in-focus<?endif;?>">
                                                        <div class="bg"></div>
                                                        <span class="desc"><?=GetMessage("HAMELEON_SET_CART_TITLE")?></span>       
                                                        <input type="text" class="focus-anim text on-save" name="hameleon_cart_title" value="<?=$arSection["UF_CH_BOX_TITLE"]?>">
                                                    </div>

                                                </div>

                                                <div class="input-wrap">
                                                    <div class="name bold"><?=GetMessage("HAMELEON_SET_CART_TITLE_BTNS")?></div>
                              
                                                    <div class="input <?if(strlen($arSection["UF_CH_BOX_BUTTONNAME"]) > 0):?>in-focus<?endif;?>">
                                                        <div class="bg"></div>
                                                        <span class="desc"><?=GetMessage("HAMELEON_SET_CART_ADDCART")?></span>       
                                                        <input type="text" class="focus-anim text on-save" name="hameleon_addcart_btn_name" value="<?=$arSection["UF_CH_BOX_BUTTONNAME"]?>">
                                                    </div>
                                    
                                                    <div class="input <?if(strlen($arSection["UF_CH_BOX_BTNNAME_AD"]) > 0):?>in-focus<?endif;?>">
                                                        <div class="bg"></div>
                                                        <span class="desc"><?=GetMessage("HAMELEON_SET_CART_ADDEDCART")?></span>       
                                                        <input type="text" class="focus-anim text on-save" name="hameleon_added_cart_btn_name" value="<?=$arSection["UF_CH_BOX_BTNNAME_AD"]?>">
                                                    </div>

                                                    <div class="input <?if(strlen($arSection["UF_CH_BOX_BTN_NAME"]) > 0):?>in-focus<?endif;?>">
                                                        <div class="bg"></div>
                                                        <span class="desc"><?=GetMessage("HAMELEON_SET_CART_IN")?></span>       
                                                        <input type="text" class="focus-anim text on-save" name="hameleon_cart_in_btn_name" value="<?=$arSection["UF_CH_BOX_BTN_NAME"]?>">
                                                    </div>

                                                    <div class="input <?if(strlen($arSection["UF_CH_BOX_BTN_NAME_C"]) > 0):?>in-focus<?endif;?>">
                                                        <div class="bg"></div>
                                                        <span class="desc"><?=GetMessage("HAMELEON_SET_CART_FAST_ORDER")?></span>       
                                                        <input type="text" class="focus-anim text on-save" name="hameleon_cart_fast_order_btn_name" value="<?=$arSection["UF_CH_BOX_BTN_NAME_C"]?>">
                                                    </div>
                                                </div>

                                                <div class="input-wrap big">
                                                    <div class="name bold"><?=GetMessage("HAMELEON_SET_CART_COMMENT")?></div>
                                                    <div class="textarea on-save">
                                                        <textarea name="hameleon_cart_comment"><?=$arSection["UF_CH_BOX_COMMENT"]?></textarea>
                                                    </div>
                                                </div>

                                                <div class="section-title"><?=GetMessage("HAMELEON_SET_CART_MESSAGES_TITLE")?></div>

                                                <div class="input-wrap middle-sm">
                                                    <div class="name bold"><?=GetMessage("HAMELEON_SET_CART_MESSAGE_ADMIN_TIT")?></div>
                                                    <div class="input<?if(strlen($arSection["UF_CHAM_THEME_ADMIN"]) > 0):?> in-focus<?endif;?>">
                                                        <div class="bg"></div>
                                                        <span class="desc"><?=GetMessage("HAMELEON_SET_CART_THEME_ADMIN")?></span>       
                                                        <input type="text" class="focus-anim text on-save" name="hameleon_cart_theme_admin" value="<?=$arSection["UF_CHAM_THEME_ADMIN"]?>">
                                                    </div>
                                               
                                                </div>

                                                <div class="input-wrap middle-sm">
                                                    <div class="textarea focus-anim <?if(strlen($arSection["UF_CHAM_CART_ADMIN"])>0):?>in-focus<?endif;?> middle on-save">

                                                        <div class="bg"></div>

                                                        <span class="desc"><?=GetMessage("HAMELEON_SET_CART_MESSAGE_ADMIN")?></span>

                                                        <textarea class="focus-anim" name="hameleon_cart_message_admin" value="<?=$arSection["UF_CHAM_CART_ADMIN"]?>"><?=$arSection["UF_CHAM_CART_ADMIN"]?></textarea>
                                                    </div>
                                                </div>

                                                <div class="input-wrap middle-sm">
                                                    <div class="name bold"><?=GetMessage("HAMELEON_SET_CART_MESSAGE_USER_TIT")?></div>

                                                    <div class="input<?if(strlen($arSection["UF_CHAM_THEME_USER"]) > 0):?> in-focus<?endif;?>">
                                                        <div class="bg"></div>
                                                        <span class="desc"><?=GetMessage("HAMELEON_SET_CART_THEME_USER")?></span>       
                                                        <input type="text" class="focus-anim text on-save" name="hameleon_cart_theme_user" value="<?=$arSection["UF_CHAM_THEME_USER"]?>">
                                                    </div>
                                                </div>


                                                <div class="input-wrap">
                                                   
                                                    <div class="textarea focus-anim <?if(strlen($arSection["UF_CHAM_CART_USER"])>0):?>in-focus<?endif;?> middle on-save">

                                                        <div class="bg"></div>

                                                        <span class="desc"><?=GetMessage("HAMELEON_SET_CART_MESSAGE_USER")?></span>

                                                        <textarea class="focus-anim" name="hameleon_cart_message_user" value="<?=$arSection["UF_CHAM_CART_USER"]?>"><?=$arSection["UF_CHAM_CART_USER"]?></textarea>
                                                    </div>
                                                </div>

                                                <div class="input-wrap big">

                                                    <a href="/bitrix/admin/iblock_section_edit.php?IBLOCK_ID=<?=$arParams["IBLOCK_ID"]?>&type=<?=$arParams["IBLOCK_TYPE"]?>&ID=<?=$arSection["ID"]?>&lang=ru&find_section_section=0" target="_blank"><span class="bord"><?=GetMessage("HAMELEON_SET_CART_MESSAGE_COMMENT_LINK")?></span></a>

                                                    <div class="spec-comment no-line italic">
                                                        <?=GetMessage("HAMELEON_SET_CART_MESSAGE_COMMENT")?>
                                                    </div>

                                               </div>

                                                <div class="section-title"><?=GetMessage("HAMELEON_SET_CART_OTHER_TITLE")?></div>

                                                <div class="input-wrap middle-sm">

                                                    <div class="name bold"><?=GetMessage("HAMELEON_SET_CART_CONDIT")?><span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAMELEON_SET_CART_CONDIT_HINT")?>"></span></div>
                                                    <?if(!empty($arResult["AGREEMENTS"])):?>
                                                        <ul class='edit-style form-radio'>
                                                            <?foreach($arResult["AGREEMENTS"] as $arItem):?>

                                                                <li>
                                                           
                                                                    <label>
                                                                        <input class='on-save' <?if($arItem["ID"] == $arSection["UF_CH_CONDITIONS"]):?> checked="checked"<?endif;?> name="hameleon_cart_condition" type="radio" value="<?=$arItem["ID"]?>">          
                                                                        <span></span>
                                                                        <span class="text"><?=$arItem["NAME"]?></span>
                                                                    </label>

                                                                    <a href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=<?=$arResult["AGREEMENT_BLOCK"]["ID"]?>&type=concept_hameleon&ID=<?=$arItem['ID']?>&lang=ru&find_section_section=0&WF=Y" target='_blank' data-toggle="tooltip" data-placement="right" title="" data-original-title="<?=GetMessage("HAMELEON_SET_MAIN_EDIT")?>"></a>
                                                                </li>

                                                            <?endforeach;?>
                                                        </ul>

                                                    <?endif;?>

                                                </div>

                                                <div class="input-wrap middle-sm">
                                                    <div class="input <?if(strlen($arSection["UF_CH_CONDITIONS_USR"]) > 0):?>in-focus<?endif;?>">
                                                        <div class="bg"></div>
                                                        <span class="desc"><?=GetMessage("HAMELEON_SET_CART_CONDIT_LINK")?></span>       
                                                        <input type="text" class="focus-anim text on-save" name="hameleon_condition_link" value="<?=$arSection["UF_CH_CONDITIONS_USR"]?>">
                                                    </div>
                                                </div>

                                                <div class="input-wrap big">
                                                    <div class="input <?if(strlen($arSection["UF_CATALOG_DELIVERY"]) > 0):?>in-focus<?endif;?>">
                                                        <div class="bg"></div>
                                                        <span class="desc"><?=GetMessage("HAMELEON_SET_CART_CONDIT_BTN_NAME")?></span>       
                                                        <input type="text" class="focus-anim text on-save" name="hameleon_condition_btn_name" value="<?=$arSection["UF_CATALOG_DELIVERY"]?>">
                                                    </div>
                                                </div>

                                                <div class="input-wrap">
                                                    <div class="name bold"><?=GetMessage("HAMELEON_SET_CART_ADV_TITLE")?><a target = "_blank" href="/bitrix/admin/iblock_list_admin.php?IBLOCK_ID=<?=$arResult["ADV_BLOCK"]['ID']?>&type=<?=$arParams["IBLOCK_TYPE"]?>&lang=ru&find_section_section=0" class="edit-icon" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAMELEON_SET_CART_ADV_TITLE_HINT")?>"></a></div>
                                                    <ul class="form-check">



                                                        <?foreach($arResult["CART_ADV"] as $key => $arItem):?>

                                                            <li>

                                                                <label>
                                                                    <input class='on-save' name="hameleon_cart_advs[]" <?if(in_array($arItem["ID"], $arSection["UF_CH_BOX_ADV"])):?> checked<?endif;?> type="checkbox" value="<?=$arItem["ID"]?>"><span></span><span><?=$arItem["NAME"]?></span> 
                                                                </label>
                                                               
                                                            </li>

                                                        <?endforeach;?>                                             
                                                        
                                                    </ul>
                                                </div>

                                                <div class="input-wrap big">

                                                    <div class="name bold"><?=GetMessage("HAMELEON_SET_CART_EMPTY_TIT")?><span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAMELEON_SET_CART_EMPTY_TIT_HINT")?>"></span></div>

                                                    <div class="input to-right <?if(strlen($arSection["UF_LINK_EMPTY_BOX"]) > 0):?>in-focus<?endif;?>">
                                                        <div class="bg"></div>
                                                        <span class="desc"><?=GetMessage("HAMELEON_SET_CART_EMPTY_LINK")?></span>       
                                                        <input type="text" class="focus-anim text on-save" name="hameleon_cart_empty_link" value="<?=$arSection["UF_LINK_EMPTY_BOX"]?>">
                                                    </div>
                                                </div>

                                                <div class="input-wrap big">
                                                    <ul class="form-check alone">                                                
                                                        <li>
                                                            <label>
                                                                <input class= 'on-save' name="hameleon_cart_open" <?if($arSection["UF_CH_BOX_FCLICK_OPN"]):?> checked<?endif;?> type="checkbox" value="1"><span></span><span class="text"><?=GetMessage("HAMELEON_SET_CART_OPEN_CLICK")?></span>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                </div>

                                            </div>

                                        </div>
                                        
                                    </td>
                                </tr>
                            </table>
                            
                            
                        </div>
                        <div class="hameleon-set-foot off">
                            <table>
                                <tr>
                                    <td class='set-left'>
                                        <div class="load">
                                            <div class="xLoader form-preload set-load"><div class="audio-wave"><span></span><span></span><span></span><span></span><span></span></div></div>
                                        </div>
                                        <button class="active" id="form-submit" name="form-submit" type="submit" value=""><?=GetMessage("HAM_PUBLIC_SET_SAVE")?></button>
                                       </td>
                                    <td class='set-right'>
                                        <div class='hameleon-set-close'><?=GetMessage("HAM_PUBLIC_SET_CLOSE")?></iiv>
                                    </td>
                                </tr>
                            </table>
                            
                        </div>
                    </form>
                
                </div>
            </div>
        
        <?endif;?>
        
    <?endforeach;?>


    <div class="hameleon-setting addpage">
        <div class="inner">

            <div class="hameleon-set-head">
                <table>
                    <tr>
                        <td class="col-lg-3 col-md-3 col-sm-3 col-xs-3 hameleon-set-image"><div></div></td>
                        <td class="col-lg-6 col-md-6 col-sm-6 col-xs-6 hameleon-set-name bold"><?=GetMessage("HAM_PUBLIC_SET_ADDPAGE")?></td>
                        <td class="col-lg-3 col-md-3 col-sm-3 col-xs-3"></td>
                    </tr>
                </table>

                <a class="hameleon-set-close"></a>
                
            </div>

            <form action="/" class="form-page-list" enctype="multipart/form-data" method="post" role="form">
                
                <input type="hidden" name="site_id" id="site_id" value="<?=SITE_ID?>" />

                <?foreach($arResult["SECTIONS"] as $arSection):?>
                    <input type="hidden" name="page_active<?=$arSection['ID']?>" value='<?=$arSection['ACTIVE']?>'>
                <?endforeach;?>


                <div class="hameleon-set-content">
                    <ul class="list">
                    
                        <?foreach($arResult["SECTIONS"] as $key=>$arSection):?>
                            
                            <li>
                            
                                <?if($arSection["ID"] == $arParams["CURRENT_SECTION_ID"]):?>
                                    <div class="active" data-toggle="tooltip" data-placement="right" title="<?=GetMessage("HAM_PUBLIC_SET_CURRENT_PAGE")?>"></div>
                                <?endif;?>
                                
                                <?if($key == 0):?>
                                    <?$url = SITE_DIR;?>
                                <?else:?>
                                    <?$url = $arSection["SECTION_PAGE_URL"];?>
                                <?endif;?>
                                
                                <?if(strlen($arSection["UF_CHAM_URL"]) > 0):?>
                                    <?$url2 = $arSection["UF_CHAM_URL"];?>
                                    <?$url = "http://".$arSection["UF_CHAM_URL"];?>
                                <?else:?>
                                    <?$url2 = $arResult["SERVER_URL2"].$url;?>
                                    <?$url = $arResult["SERVER_URL"].$url;?>
                                <?endif;?>
                                


                                <span class="list-name">
                                    
                                    <?if($arSection["ID"] != $arParams["CURRENT_SECTION_ID"]):?>
                                        <a href="<?=$url?>"><?=$arSection["NAME"]?></a>
                                    <?else:?>
                                        <?=$arSection["NAME"]?>
                                    <?endif;?>
                                   
                                </span>


                                
                                <span class="icons-wrap parent_copy">
                                    
                                    <a data-clipboard-text="<?=$url?>" class="icon list-copy" data-toggle="tooltip" data-placement="top" title="<?=GetMessage("HAM_PUBLIC_SET_COPY")?>"></a>
                                    
                                    <span class="al copy-success"><?=GetMessage("HAM_PUBLIC_SET_ALL_SETTINGS_ALERT")?></span>
                                </span>
                                
                                <?if($arSection["ACTIVE"] != "Y"):?>
                                    <span class="icons-wrap parent_inactive">
                                        <div class="inactive"><?=GetMessage("HAM_PUBLIC_SET_ALL_SETTINGS_INACTIVE")?></div>
                                    </span>
                                <?endif;?>

                                <div class="more_set">
                                    <table class='more_set'>
                                        <tr>
                                            <td class='left_set'>
                                                <span><?=GetMessage("HAM_PUBLIC_SET_SORT")?></span>
                                                <input type="text" name = 'sort_<?=$arSection["ID"]?>' class="sort" value='<?=$arSection["SORT"]?>'>
                                            </td>
                                            <td class='right_set'>
                                                <div class="ignite<?if(strlen($arSection['ACTIVE']=='Y')):?> on<?endif;?>">
                                                    <span class="off"><?=GetMessage("HAM_PUBLIC_SET_PAGE_OFF")?></span>
                                                    <span class="on"><?=GetMessage("HAM_PUBLIC_SET_PAGE_ON")?></span>
                                                    <span class="toggle-indicator" data-page-id = '<?=$arSection["ID"]?>'>
                                                        <span class="toggle-icon"></span>
                                                        <span class="toggle-icon-overlay"></span>
                                                    </span> 
                                           
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                
                                <div class="clearfix"></div>
                                
                               
                                
                               <div class="domen">
                                    <div class="arrow"></div>
                                    <?=$url2?>
                                </div>
                                
                             
            
                            </li>
                        
                        <?endforeach;?>
                        
                    </ul>

                    <div class="button-wrap">
                        <a class="plus new_page" data-open-set='newpage'><?=GetMessage("HAM_PUBLIC_SET_ADD_BUTTON")?></a>
                        <a class="edit open_edit"><?=GetMessage("HAM_PUBLIC_SET_EDIT_SETS_EDIT_LIST")?></a>
                    </div>

                    <div class="more_edit">
                        <div class="load">
                            <div class="xLoader form-preload"><div class="audio-wave"><span></span><span></span><span></span><span></span><span></span></div></div>
                        </div>
                        <button class="active btn-green" id="form-submit" name="form-submit" type="submit" value=""><?=GetMessage("HAM_PUBLIC_SET_SAVE")?></button>

                        <a class="edit close_edit"><?=GetMessage("HAM_PUBLIC_SET_CANCEL")?></a>
                    </div>
                </div>
               
            </form>
        
        </div>
    </div>

    <div class="hameleon-setting newpage">
        <div class="inner">

            <div class="hameleon-set-head">
                <table>
                    <tr>
                        <td class="col-lg-6 col-md-6 col-sm-6 col-xs-6 hameleon-set-name bold"><?=GetMessage("HAM_PUBLIC_SET_NEWPAGE")?></td>
                        <td class="col-lg-3 col-md-3 col-sm-3 col-xs-3"></td>
                    </tr>
                </table>

                <a class="hameleon-set-close"></a>
                
            </div>

            <form action="/" class="form-add-page" enctype="multipart/form-data" method="post" role="form">
                
                <input type="hidden" name="server_url" value="<?=$arResult["SERVER_URL"]?>" />
                <input type="hidden" name="site_id" id="site_id" value="<?=SITE_ID?>" />
                <input type="hidden" name="iblock_id" id="iblock_id" value="<?=$arParams["IBLOCK_ID"]?>" />

                <div class="hameleon-set-content">

                    <div class="input-wrap">
                        <div class="name"><?=GetMessage("HAM_PUBLIC_SET_NEW_PAGE_NAME")?></div>

                        <div class="input">
                            <input type="text" class="name require" name="newpage_name" value="">
                        </div>

                    </div>

                    <div class="input-wrap">
                        <div class="name"><?=GetMessage("HAM_PUBLIC_SET_NEW_PAGE_ID")?> <span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAM_PUBLIC_SET_NEW_PAGE_ID_HINT")?>"></span></div>

                        <div class="input">
                            <input type="text" class="name require" name="newpage_id" value="">
                        </div>

                    </div>

                    <div class="input-wrap">
                        <div class="load">
                            <div class="xLoader form-preload"><div class="audio-wave"><span></span><span></span><span></span><span></span><span></span></div></div>
                        </div>
                        <button class="active btn-green" id="form-submit" name="form-submit" type="submit" value=""><?=GetMessage("HAM_PUBLIC_SET_NEW_PAGE_SAVE")?></button>
                    </div>

                </div>
               
            </form>
        
        </div>
    </div>

    <div class="hameleon-setting seo">
        <div class="inner">

            <div class="hameleon-set-head">
                <table>
                    <tr>
                        <td class="col-lg-2 col-md-2 col-sm-2 col-xs-3 hameleon-set-image"><div></div></td>
                        <td class="col-lg-8 col-md-8 col-sm-8 col-xs-6 hameleon-set-name bold"><?=GetMessage("HAMELEON_SEO_BLOCK_TITLE")?></td>
                        <td class="col-lg-2 col-md-2 col-sm-2 col-xs-3"></td>
                    </tr>
                </table>

                <a class="hameleon-set-close"></a>
                
            </div>
            
            <?foreach($arResult["SECTIONS"] as $arSection):?>
        
                <?if($arSection["ID"] == $GLOBALS["CURRENT_SECTION_ID"]):?>
                

                    <form action="/" class="form form-seo" enctype="multipart/form-data" method="post" role="form">
        
                        
                        <input type="hidden" name="server_url" value="<?=$arResult["SERVER_URL"]?>" />
                        <input type="hidden" name="site_id" id="site_id" value="<?=SITE_ID?>" />
                        
                        <input type="hidden" name="section_id" name="section_id" value="<?=$GLOBALS["CURRENT_SECTION_ID"]?>" />
                        
        
                        <div class="hameleon-set-top">
                            <div class="progress-wrap">
                                <div class="progress-top">
                                    <div class="progress-name seo-<?=$arResult["SEO_CLASS"]?>"><?=GetMessage("HAMELEON_SEO_".$arResult["SEO_STATUS"])?></div>
                                            
                                    <div class="points">(<?=$arResult["SEO_POINTS"]?> <?=GetMessage("HAMELEON_SEO_POINT")?> 100 <?=GetMessage("HAMELEON_SEO_POINTS")?>)</div>
                                    <div class="seo-more_info"><span class='show_info'><?=GetMessage("HAMELEON_SEO_SHOW_INFO")?></span><span class='hide_info'><?=GetMessage("HAMELEON_SEO_HIDE_INFO")?></span></div>
                                </div>
                                <div class="progress-bar-hameleon">
                                    <div class="progress-status" style='width: <?=$arResult["SEO_POINTS"]?>%;'></div>
                                </div>
                            </div>
                            <div class="progress-info">
                                <ul>
                                    <?foreach($arResult["SEO_MESSAGE"] as $arMess):?>
                                        <li class='seo-<?=$arMess["class"]?>'><?=GetMessage($arMess["TEXT"])?></li>
                                    <?endforeach;?>
                                </ul>
        
                                <div class="spec-comment italic">
                                    <?=GetMessage("HAMELEON_SEO_COMMENT")?>
                                </div>
                                
                            </div>
                        </div>
        
        
                        <div class="hameleon-set-content">
        
                            <table class="sides">
                                <tr>
                                    <td class='set-side-left'>
                                    
                                        <ul class="set-tabs">
                                            <li class='active' data-set='meta'><?=GetMessage("HAMELEON_SEO_META")?></li>
                                            <li data-set='og'><?=GetMessage("HAMELEON_SEO_SOC")?></li>
                                            <li data-set='other-meta'><?=GetMessage("HAMELEON_SEO_OTHER_META")?></li>
                                        </ul>
                                        
                                        <!-- <div class="instruct">
                                            <a href="https://goo.gl/uDNEPN" target="_blank"><?=GetMessage("HAMELEON_SEO_INSTRUCT")?></a>
                                        </div> -->
                                        
                                    </td>
                                    
                                    <td class='set-side-right'>
        
                                        <div class="set-content active" data-set='meta'>
                                        
                                            
                                            <div class="input-wrap">
                                        
                                                <ul class="form-check">                                                
                                                    <li>
                                                        <label>
                                                            <input class='on-save' name="hameleon_seo_noindex" <?if($arSection["UF_CHAM_NOINDEX"] == 1):?>checked<?endif;?> type="checkbox" value="1"><span></span><span><?=GetMessage("HAMELEON_SEO_NOINDEX")?></span> 
                                                        </label>
                                                        <span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAMELEON_SEO_HINT_1")?>"></span>
                                                       
                                                    </li>
                                                    
                                                </ul>
                                            
                                            </div>
                                        
                                        
                                            <div class="input-wrap middle clearfix">

                                                <div class="name bold">
                                                
                                                    <?=GetMessage("HAMELEON_SEO_TITLE")?> <span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAMELEON_SEO_HINT_2")?>"></span>
                                                
                                                    <?if(!empty($arResult["SEO_TITLE_MESSAGE"])):?>
                                                        
                                                        <span class="answ-seo seo-<?=$arResult["SEO_TITLE_MESSAGE"][0]["class"]?>" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?=GetMessage($arResult["SEO_TITLE_MESSAGE"][0]["TEXT"])?>"></span>
                                                    <?endif;?>
                                                    
                                                
                                                
                                                
                                                </div>
                                                
                                                <div class="row">
                                                
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    
                                                        <div class="textarea on-save">
                                                            
                                                            <?
                                                            $seo_title = $arSection["NAME"];
                                                            
                                                            if(strlen($arSection["IPROPERTY_VALUES"]["SECTION_META_TITLE"]) > 0)
                                                                $seo_title = $arSection["IPROPERTY_VALUES"]["SECTION_META_TITLE"];
                                                            ?>
                                                        
                                                            <textarea name="hameleon_seo_title"><?=$seo_title?></textarea>
                                                        </div>
                                                    
                                                    </div>
                                        
                                                </div>
                                                
                                            </div>
                                            
                                            <div class="input-wrap middle clearfix">

                                                <div class="name bold">
                                                    
                                                    <?=GetMessage("HAMELEON_SEO_DESCRIPTION")?> <span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAMELEON_SEO_HINT_3")?>"></span>
                                                    
                                                    <?if(!empty($arResult["SEO_DESCRIPTION_MESSAGE"])):?>
                                                        
                                                        <span class="answ-seo seo-<?=$arResult["SEO_DESCRIPTION_MESSAGE"][0]["class"]?>" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?=GetMessage($arResult["SEO_DESCRIPTION_MESSAGE"][0]["TEXT"])?>"></span>
                                                    <?endif;?>
                                                    
                                                </div>
                                                
                                                <div class="row">
                                                
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    
                                                        <div class="textarea on-save">
                                                        
                                                            <textarea name="hameleon_seo_description"><?=$arSection["IPROPERTY_VALUES"]["SECTION_META_DESCRIPTION"]?></textarea>
                                                        </div>
                                                    
                                                    </div>
                                        
                                                </div>
                                                
                                            </div>
                                            
                                            <div class="input-wrap middle clearfix">

                                                <div class="name bold">
                                                
                                                    <?=GetMessage("HAMELEON_SEO_KEYWORDS")?> <span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAMELEON_SEO_HINT_4")?>"></span>
                                                
                                                    
                                                    <?if(!empty($arResult["SEO_KEYWORDS_MESSAGE"])):?>
                                                        
                                                        <span class="answ-seo seo-<?=$arResult["SEO_KEYWORDS_MESSAGE"][0]["class"]?>" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?=GetMessage($arResult["SEO_KEYWORDS_MESSAGE"][0]["TEXT"])?>"></span>
                                                    <?endif;?>
                                                    
                                                </div>
                                                
                                                <div class="row">
                                                
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    
                                                        <div class="textarea on-save">
           
                                                            <textarea name="hameleon_seo_keywords"><?=$arSection["IPROPERTY_VALUES"]["SECTION_META_KEYWORDS"]?></textarea>
                                                        </div>
                                                    
                                                    </div>
                                        
                                                </div>
                                                
                                            </div>


                                            <div class="spec-comment italic">
                                            <?=GetMessage("HAMELEON_SEO_HINT_6")?></div>
                                            
                                            

                                        </div>
                                        
                                        
                                        <div class="set-content" data-set='og'>
                                        
                                            
                                            <div class="input-wrap middle clearfix">
                                                
                                                
                                                <div class="clearfix">
                                                    
                                                    <div class="row">
                                                    
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        
                                                            <div class="input to-right clearfile-parent">
            
                                                                <label class="file on-save <?if(strlen($arSection["OG_IMAGE"]) > 0):?>focus-anim<?endif;?>">
                                                                
                                                                    <input type="hidden" name="imageogimage" value="<?=$arSection["UF_CHAM_OG_IMAGE"]?>">
            
                                                                    <input type="hidden" class='hameleon_file_del' name="hameleon_seo_og_image_del" value="">
            
                                                                    <span class="ex-file-desc"><?=GetMessage("HAMELEON_SEO_OG_IMAGE")?></span>
                                                                    <span class="ex-file"><?=$arSection["OG_IMAGE"]?></span>
                                                                    <input type="file" accept="image/*" class="hidden" id="hameleon_seo_og_image" name="hameleon_seo_og_image"  />
                                                                </label>
            
                                                                <div class="clearfile on-save <?if(strlen($arSection["OG_IMAGE"]) > 0):?>on<?endif;?>"></div>
            
                                                            </div>
                                                            
                                                        </div>
                                                    
                                                    </div>
                                                
                                                </div>
                                                
                                                
                                                
      
                                                <div class="input <?if(strlen($arSection['UF_CHAM_OG_TITLE']) > 0):?>in-focus<?endif;?>">  
                                                    <div class="bg"></div>
                                                    <span class="desc"><?=GetMessage("HAMELEON_SEO_OG_TITLE")?></span>
                                                    <input type="text" class='focus-anim on-save' name="hameleon_seo_og_title" value="<?=$arSection['UF_CHAM_OG_TITLE']?>">
                                                
                                                </div>
                                            
                                            
                                                
                                                <div class="input <?if(strlen($arSection['UF_CHAM_OG_DESC']) > 0):?>in-focus<?endif;?>"> 
                                                 
                                                    <div class="bg"></div> 
                                                    <span class="desc"><?=GetMessage("HAMELEON_SEO_OG_DESCRIPTION")?></span>
                                                    <input type="text" class='focus-anim on-save' name="hameleon_seo_og_description" value="<?=$arSection['UF_CHAM_OG_DESC']?>">
                                                
                                                </div>
                                            
                                            
                                            
                                                
                                                
                                                <div class="input-wrap clearfix"></div>
                                                
                                                <div class="name bold"><?=GetMessage("HAMELEON_SEO_OG_NOT_NESSESARY")?></div>
                                                
                                                
                                                <div class="input <?if(strlen($arSection['UF_CHAM_OG_URL']) > 0):?>in-focus<?endif;?>">  
                                                    <div class="bg"></div>  
                                                    <span class="desc"><?=GetMessage("HAMELEON_SEO_OG_URL")?></span>
                                                    <input type="text" class='focus-anim on-save' name="hameleon_seo_og_url" value="<?=$arSection['UF_CHAM_OG_URL']?>">
                                                
                                                </div>
                       
                                                
                                                <div class="input <?if(strlen($arSection['UF_CHAM_OG_TYPE']) > 0):?>in-focus<?endif;?>">  
                                                    <div class="bg"></div>
                                                    <span class="desc"><?=GetMessage("HAMELEON_SEO_OG_TYPE")?></span>
                                                    <input type="text" class='focus-anim on-save' name="hameleon_seo_og_type" value="<?=$arSection['UF_CHAM_OG_TYPE']?>">
                                                
                                                </div>

                                                <div class="spec-comment italic">
                                        
                                                    <?=GetMessage("HAMELEON_SEO_HINT_7")?>
                                                        
                                                </div>
                                            
                                            
                                            </div>
                                            
                                        </div>
                                        
                                        
                                        <div class="set-content" data-set='other-meta'>
                                        
                                            
                                            <div class="name bold"><?=GetMessage("HAMELEON_SEO_OTHER_META")?><span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAMELEON_SEO_HINT_5")?>"></span></div>
                                            
                                            <div class="parent-row">
        
                                                <div class="empty-template">
                                                    <div class="input">                                       
                                                        <input type="text" class="text seo-name" name="hameleon_other_meta[n<?=count($arSection["UF_CHAM_META_TAGS"])?>]" value="">
                                                    </div>
                                                </div>
        
                                                <div class="area-for-clone">
                                                    
                                                    <?foreach($arSection["UF_CHAM_META_TAGS"] as $k=>$arTag):?>
                                                    
                                                        <div class="input">                                       
                                                            <input type="text" class="text seo-name" name="hameleon_other_meta[n<?=$k?>]" value="<?=$arTag?>" />
                                                        </div>
                                                    
                                                    <?endforeach;?>
                                                    
                                                </div>
                                             
        
                                                <div class="addrow-seo on-save">+ <span><?=GetMessage("HAMELEON_SEO_OTHER_ADD")?></span></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
        
                        </div>
        
                        <div class="hameleon-set-foot off">
                            <table>
                                <tr>
                                    <td class='set-left'>
                                        <div class="load">
                                            <div class="xLoader form-preload set-load"><div class="audio-wave"><span></span><span></span><span></span><span></span><span></span></div></div>
                                        </div>
                                        <button class="active" id="form-submit" name="form-submit" type="submit" value=""><?=GetMessage("HAM_PUBLIC_SET_SAVE")?></button>
                                       </td>
                                    <td class='set-right'>
                                        <div class='hameleon-set-close'><?=GetMessage("HAM_PUBLIC_SET_CLOSE")?></iiv>
                                    </td>
                                </tr>
                            </table>
                            
                        </div>
                    </form>
            
                <?endif;?>
            
            <?endforeach;?>
        
        </div>
    </div>


    <div class="hameleon-setting modals list-style">
        <div class="inner">

            <div class="hameleon-set-head">
                <table>
                    <tr>
                        <td class="col-lg-3 col-md-3 col-sm-3 col-xs-3 hameleon-set-image"><div></div></td>
                        <td class="col-lg-6 col-md-6 col-sm-6 col-xs-6 hameleon-set-name bold"><?=GetMessage("HAM_PUBLIC_SET_MODAL")?></td>
                        <td class="col-lg-3 col-md-3 col-sm-3 col-xs-3"></td>
                    </tr>
                </table>

                <a class="hameleon-set-close"></a>
                
            </div>

            <div class="hameleon-set-content">

                <div class="title-hint"><?=GetMessage("HAMELEON_MODAL_TITLE_HINT")?></div>


                <?if(!empty($arResult['MODALS_IN_SECTION'])):?>
                    <?foreach($arResult['MODALS_IN_SECTION'] as $arSectModal):?>

                        <div class="list-wrap">

                            <div class="list-title"><?=$arSectModal['NAME']?></div>

                            <ul class='list'>
                                <?if(!empty($arSectModal['ELEMENTS'])):?>
                                    <?foreach($arSectModal['ELEMENTS'] as $arModal):?>
                                        <li>
                                            <span class="list-name"><a class='call-modal callmodal from-set' data-call-modal="modal<?=$arModal['ID']?>"><span class="bord"><?=$arModal['NAME']?></span></a></span><a data-toggle="tooltip" data-placement="right" title="" data-original-title="<?=GetMessage("HAM_PUBLIC_SET_DEF_EDIT")?>" class='edit-list' href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=<?=$arModal['IBLOCK_ID']?>&type=<?=$arParams["IBLOCK_TYPE"]?>&ID=0&lang=ru&IBLOCK_SECTION_ID=<?=$arModal['IBLOCK_SECTION_ID']?>&find_section_section=<?=$arModal['IBLOCK_SECTION_ID']?>&from=iblock_list_admin" target="_blank"></a>
                                            
                                        </li>
                                    <?endforeach;?>
                                <?endif;?>
                              
                            </ul>

                        </div>

                    <?endforeach;?>
                <?endif;?>

                <?if(!empty($arResult['MODALS_ELEMENTS_NO_SECTION'])):?>
                    <div class="list-wrap">
                        <ul class='list'>
                            <?foreach($arResult['MODALS_ELEMENTS_NO_SECTION'] as $arModal):?>

                                <li>
                                    <span class="list-name"><a class='call-modal callmodal from-set' data-call-modal="modal<?=$arModal['ID']?>"><span class="bord"><?=$arModal['NAME']?></span></a></span><a data-toggle="tooltip" data-placement="right" title="" data-original-title="<?=GetMessage("HAM_PUBLIC_SET_DEF_EDIT")?>" class='edit-list' href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=<?=$arModal['IBLOCK_ID']?>&type=<?=$arParams["IBLOCK_TYPE"]?>&ID=<?=$arModal['ID']?>&lang=ru&find_section_section=0&WF=Y" target="_blank"></a>


                                </li>

                            <?endforeach;?>
                        </ul>
                    </div>
                <?endif;?>


                <div class="button-wrap">
                    <a class="plus" href='/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=<?=$arResult['MODALS_ELEMENTS_IBLOCK_ID']?>&type=<?=$arParams["IBLOCK_TYPE"]?>&ID=0&lang=ru&IBLOCK_SECTION_ID=0&find_section_section=0&from=iblock_list_admin' target="_blank"><?=GetMessage("HAMELEON_ADD_MODAL")?></a>
              
                </div>

            </div>

            
        
        </div>
    </div>


    <div class="hameleon-setting forms list-style">
        <div class="inner">

            <div class="hameleon-set-head">
                <table>
                    <tr>
                        <td class="col-lg-3 col-md-3 col-sm-3 col-xs-3 hameleon-set-image"><div></div></td>
                        <td class="col-lg-6 col-md-6 col-sm-6 col-xs-6 hameleon-set-name bold"><?=GetMessage("HAM_PUBLIC_SET_FORMS")?></td>
                        <td class="col-lg-3 col-md-3 col-sm-3 col-xs-3"></td>
                    </tr>
                </table>

                <a class="hameleon-set-close"></a>
                
            </div>

            <div class="hameleon-set-content">

                <div class="title-hint"><?=GetMessage("HAMELEON_FORM_TITLE_HINT")?></div>

                <?if(!empty($arResult['FORMS_IN_SECTION'])):?>
                    <?foreach($arResult['FORMS_IN_SECTION'] as $arSectForm):?>

                        <?if(empty($arSectForm['ELEMENTS'])) continue;?>

                        <div class="list-wrap">

                            <div class="list-title"><?=$arSectForm['NAME']?></div>

                            <ul class='list'>
                                <?if(!empty($arSectForm['ELEMENTS'])):?>
                                    <?foreach($arSectForm['ELEMENTS'] as $arForm):?>
                                        <li>
                                            <span class="list-name"><a class='call-modal callform from-set' data-call-modal="form<?=$arForm['ID']?>"><span class="bord"><?=$arForm['NAME']?></span></a></span><a data-toggle="tooltip" data-placement="right" title="" data-original-title="<?=GetMessage("HAM_PUBLIC_SET_DEF_EDIT")?>" class='edit-list' href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=<?=$arForm['IBLOCK_ID']?>&type=<?=$arParams["IBLOCK_TYPE"]?>&ID=<?=$arForm['ID']?>&lang=ru&find_section_section=<?=$arForm['IBLOCK_SECTION_ID']?>&WF=Y" target="_blank"></a>
                                        </li>
                                    <?endforeach;?>
                                <?endif;?>
                              
                            </ul>

                        </div>

                    <?endforeach;?>
                <?endif;?>

                <?if(!empty($arResult['FORMS_ELEMENTS_NO_SECTION'])):?>
                    <div class="list-wrap">
                        <ul class='list'>
                            <?foreach($arResult['FORMS_ELEMENTS_NO_SECTION'] as $arForm):?>

                                <li>
                                    <span class="list-name"><a data-toggle="tooltip" data-placement="right" title="" data-original-title="<?=GetMessage("HAM_PUBLIC_SET_DEF_EDIT")?>" class='call-modal callform from-set' data-call-modal="form<?=$arForm['ID']?>"><span class="bord"><?=$arForm['NAME']?></span></a></span><a class='edit-list' href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=<?=$arForm['IBLOCK_ID']?>&type=<?=$arParams["IBLOCK_TYPE"]?>&ID=<?=$arForm['ID']?>&lang=ru&find_section_section=0&WF=Y" target="_blank"></a>
                                </li>
                                
                            <?endforeach;?>
                        </ul>
                    </div>
                <?endif;?>

                <div class="button-wrap">
                    <a class="plus" href='/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=<?=$arResult['FORMS_ELEMENTS_IBLOCK_ID']?>&type=<?=$arParams["IBLOCK_TYPE"]?>&ID=0&lang=ru&IBLOCK_SECTION_ID=0&find_section_section=0&from=iblock_list_admin' target="_blank"><?=GetMessage("HAMELEON_ADD_FORM")?></a>
                    <a class="edit instr" href='https://goo.gl/ffvH6d' target="_blank"><?=GetMessage("HAMELEON_FORM_HINT")?></a>
                </div>

            </div>

            
        
        </div>
    </div>


</div>
<?
$site_id = trim($_REQUEST["site_id"]);
define("SITE_ID", $site_id);
?>

<?require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');?>

<?
CModule::IncludeModule("iblock");
$arResult["OK"] = "N";

if($_REQUEST["send"] == "Y")
{
    $bs = new CIBlockSection;

    $ID = intval(trim($_REQUEST["section_id"]));

    $arFields = Array();

    $arFields["UF_CHAM_DESCRIPT"] = trim($_REQUEST["hameleon_description"]);
    $arFields["UF_CHAM_DESCRIPT_BK"] = trim($_REQUEST["hameleon_backdrop"]);
    $arFields["UF_CHAM_TITLE_FONT"] = trim($_REQUEST["hameleon_fontTitle"]);
    $arFields["UF_CHAM_TEXT_FONT"] = trim($_REQUEST["hameleon_fontText"]);
    $arFields["UF_CHAM_HEADER_CLR"] = trim($_REQUEST["hameleon_color_scheme"]);
    $arFields["UF_CHAM_LOGOTYPE"] = trim($_REQUEST["hameleon_logotype_position"]);
    $arFields["UF_CHAM_BUTTONS_TYPE"] = trim($_REQUEST["hameleon_buttons_view"]);

    $arFields["UF_CHAM_HEADER_BACK"] = trim($_REQUEST["hameleon_header_background"]);

    if(trim($_REQUEST["hameleon_header_background"]) == "#")
        $arFields["UF_CHAM_HEADER_BACK"] = "";

    $arFields["UF_CHAM_HEADER_BK_O"] = trim($_REQUEST["hameleon_header_background_opacity"]); 
    $arFields["UF_CHAM_HEADER_IMG_F"] = trim($_REQUEST["hameleon_header_img_cover"]); 

    $arFields["UF_CHAM_SLIDEMENU"] = trim($_REQUEST["hameleon_slidemenu"]);
    $arFields["UF_CHAM_CALLBACK"] = trim($_REQUEST["hameleon_callback"]);


    $arFields["UF_CHAM_PHONE"] = trim($_REQUEST["hameleon_phone1"]);
    $arFields["UF_CHAM_PHONECOMM1"] = trim($_REQUEST["hameleon_phone_comm1"]);
    $arFields["UF_CHAM_PHONE2"] = trim($_REQUEST["hameleon_phone2"]);
    $arFields["UF_CHAM_PHONECOMM2"] = trim($_REQUEST["hameleon_phone_comm2"]);

    $arFields["UF_CHAM_EMAIL"] = trim($_REQUEST["hameleon_email1"]);
    $arFields["UF_CHAM_EMAILCOMM1"] = trim($_REQUEST["hameleon_email_comm1"]);
    $arFields["UF_CHAM_EMAIL2"] = trim($_REQUEST["hameleon_email2"]);
    $arFields["UF_CHAM_EMAILCOMM2"] = trim($_REQUEST["hameleon_email_comm2"]); 


    $arFields["UF_CHAM_SOC_VK"] = trim($_REQUEST["hameleon_vk"]); 
    $arFields["UF_CHAM_SOC_FB"] = trim($_REQUEST["hameleon_fb"]); 
    $arFields["UF_CHAM_SOC_TW"] = trim($_REQUEST["hameleon_tw"]); 
    $arFields["UF_CHAM_SOC_YT"] = trim($_REQUEST["hameleon_yt"]); 
    $arFields["UF_CHAM_SOC_IG"] = trim($_REQUEST["hameleon_ig"]);

    $arFields["UF_VIEW_SCRLL_MENU"] = trim($_REQUEST["hameleon_view_scrll_menu"]);


    $arFields["UF_CHAM_SOC_VIEW"] = $_REQUEST["hameleon_socials_position"];
    $arFields["UF_CHAM_PAY"] = $_REQUEST["hameleon_cham_pay"];
    $arFields["UF_CHAM_DELIV"] = $_REQUEST["hameleon_cham_deliv"];
    $arFields["UF_CHAM_UNITS"] = $_REQUEST["hameleon_cham_units"];
    $arFields["UF_CH_BOX_ADV"] = $_REQUEST["hameleon_cart_advs"];

    if(!isset($_REQUEST["hameleon_socials_position"]))
        $arFields["UF_CHAM_SOC_VIEW"] = array();

    if(!isset($_REQUEST["hameleon_cham_pay"]))
        $arFields["UF_CHAM_PAY"] = array();
    
    if(!isset($_REQUEST["hameleon_cham_deliv"]))
        $arFields["UF_CHAM_DELIV"] = array();

    if(!isset($_REQUEST["hameleon_cham_units"]))
        $arFields["UF_CHAM_UNITS"] = array();

    if(!isset($_REQUEST["hameleon_cart_advs"]))
        $arFields["UF_CH_BOX_ADV"] = array();


    $arFields["UF_CHAM_SHARE"] = trim($_REQUEST["hameleon_use_share"]);
    $arFields["UF_CHAM_MENU_TYPE"] = trim($_REQUEST["hameleon_menu_type"]); 
    $arFields["UF_CHAM_MENU_PLANK"] = trim($_REQUEST["hameleon_menu_background"]);

    if(trim($_REQUEST["hameleon_menu_background"]) == "#")
        $arFields["UF_CHAM_MENU_PLANK"] = "";
        
    $arFields["UF_CHAM_MENU_PLANK_O"] = trim($_REQUEST["hameleon_menu_background_opacity"]);

    if(trim($_REQUEST["hameleon_show_footer"]) != "0")
        $arFields["UF_CHAM_FOOTER_HIDE"] = 1;
    else
        $arFields["UF_CHAM_FOOTER_HIDE"] = 0;
        
    $arFields["UF_CHAM_FOOTER"] = trim($_REQUEST["hameleon_footer_desc"]);
    $arFields["UF_CHAM_FOOTER_REQS"] = trim($_REQUEST["hameleon_footer_reqs"]);


    if(trim($_REQUEST["hameleon_show_copyright"]) != "0")
        $arFields["UF_CHAM_COPYRIGHT"] = 1;
    else
        $arFields["UF_CHAM_COPYRIGHT"] = 0;
        
    $arFields["UF_CHAM_CHOOSECOPY"] = trim($_REQUEST["hameleon_choose_copyright"]);
    $arFields["UF_CHAM_LINK_TEXT"] = trim($_REQUEST["hameleon_copyright_link_text"]);
    $arFields["UF_CHAM_LINK"] = trim($_REQUEST["hameleon_copyright_link"]);

    $arFields["UF_CHAM_EMAIL_FROM"] = trim($_REQUEST["hameleon_email_from"]);
    $arFields["UF_CHAM_EMAIL_TO"] = trim($_REQUEST["hameleon_email_to"]);

    $arFields["UF_CHAM_INFOBLOCK"] = trim($_REQUEST["hameleon_save_infoblock"]);

    $arFields["UF_CHAM_B24"] = trim($_REQUEST["hameleon_b24"]);
    $arFields["UF_CHAM_B24_URL"] = trim($_REQUEST["hameleon_b24_url"]);
    $arFields["UF_CHAM_B24_LOGIN"] = trim($_REQUEST["hameleon_b24_login"]);
    $arFields["UF_CHAM_B24_PASSWORD"] = trim($_REQUEST["hameleon_b24_password"]);

    $arFields["UF_CHAM_AMO"] = trim($_REQUEST["hameleon_amo"]);
    $arFields["UF_CHAM_AMO_URL"] = trim($_REQUEST["hameleon_amo_url"]);
    $arFields["UF_CHAM_AMO_LOGIN"] = trim($_REQUEST["hameleon_amo_login"]);
    $arFields["UF_CHAM_AMO_HASH"] = trim($_REQUEST["hameleon_amo_hash"]);


    $arFields["UF_CHAM_METRIKA"] = trim($_REQUEST["hameleon_analytics_metrika"]);
    $arFields["UF_CHAM_GOOGLE"] = trim($_REQUEST["hameleon_analytics_ga"]);
    $arFields["UF_CHAM_GTM"] = trim($_REQUEST["hameleon_analytics_gtm"]);

    $arFields["UF_CHAM_INHEAD"] = trim($_REQUEST["hameleon_add_inhead"]);
    $arFields["UF_CHAM_INBODY"] = trim($_REQUEST["hameleon_add_inbody"]);
    $arFields["UF_CHAM_INCLOSEBODY"] = trim($_REQUEST["hameleon_add_inclosebody"]);


    $arFields["NAME"] = trim($_REQUEST["hameleon_name_site"]);

    if(strlen(trim($_REQUEST["hameleon_code"])) > 0)
        $arFields["CODE"] = trim($_REQUEST["hameleon_code"]);
        
    $arFields["UF_CHAM_URL"] = trim($_REQUEST["hameleon_domen"]);
    $arFields["UF_CHAM_AGREE_TEXT"] = trim($_REQUEST["hameleon_agreement_text"]);
    $arFields["UF_CHAM_AGREEMENTS_Y"] = trim($_REQUEST["hameleon_agreement_y"]);
    $arFields["UF_CHAM_AGREEMENTS"] = $_REQUEST["hameleon_agreements"];
    $arFields["UF_CHAM_CALLBACK_FRM"] = trim($_REQUEST["hameleon_callback_form"]);
    $arFields["UF_CHAM_CATALOG_FRM"] = trim($_REQUEST["hameleon_catalog_form"]);
    $arFields["UF_CHAM_SHOW_EDIT"] = trim($_REQUEST["hameleon_show_edit"]);
    $arFields["UF_CHAM_HIDESCROLL"] = trim($_REQUEST["hameleon_hide_scroll"]);
    $arFields["UF_CHAM_SLIDER_TIME"] = trim($_REQUEST["hameleon_slider_time"]);
    $arFields["UF_CHAM_CSS"] = trim($_REQUEST["hameleon_custom_css"]);
    $arFields["UF_CHAM_SCRIPTS"] = trim($_REQUEST["hameleon_custom_js"]);
    $arFields["UF_CHAM_MAIN_COLOR"] = trim($_REQUEST["hameleon_set_color"]);
    
    $arFields["UF_CH_USER_M_COLOR"] = trim($_REQUEST["hameleon_user_color"]);
    
    $arFields["UF_CHAM_PAY_TITLE"] = trim($_REQUEST["hameleon_pay_title"]);
    $arFields["UF_CHAM_DELIV_TITLE"] = trim($_REQUEST["hameleon_deliv_title"]);
    

    $arFields["UF_CH_BAS_CURENCIES"] = trim($_REQUEST["hameleon_bas_curr"]);

    $arFields["UF_CH_BOX_ON"] = trim($_REQUEST["hameleon_box_on"]);
    $arFields["UF_CH_BOX_TITLE"] = trim($_REQUEST["hameleon_cart_title"]);
    $arFields["UF_CH_BOX_COMMENT"] = trim($_REQUEST["hameleon_cart_comment"]);
    $arFields["UF_CH_BOX_BUTTONNAME"] = trim($_REQUEST["hameleon_addcart_btn_name"]);
    $arFields["UF_CH_BOX_BTNNAME_AD"] = trim($_REQUEST["hameleon_added_cart_btn_name"]);
    $arFields["UF_CH_BOX_BTN_NAME"] = trim($_REQUEST["hameleon_cart_in_btn_name"]);
    $arFields["UF_CH_BOX_BTN_NAME_C"] = trim($_REQUEST["hameleon_cart_fast_order_btn_name"]);
    $arFields["UF_CH_BOX_ONE_CLICK"] = trim($_REQUEST["hameleon_form_fast_order"]);
    $arFields["UF_CH_BOX_ORDER_FORM"] = trim($_REQUEST["hameleon_form_order"]);
    $arFields["UF_CH_BOX_FCLICK_OPN"] = trim($_REQUEST["hameleon_cart_open"]);

    $arFields["UF_CH_CONDITIONS"] = trim($_REQUEST["hameleon_cart_condition"]);
    $arFields["UF_CH_CONDITIONS_USR"] = trim($_REQUEST["hameleon_condition_link"]);

    $arFields["UF_CATALOG_DELIVERY"] = trim($_REQUEST["hameleon_condition_btn_name"]);
    $arFields["UF_LINK_EMPTY_BOX"] = trim($_REQUEST["hameleon_cart_empty_link"]);
    $arFields["UF_CHAM_THEME_ADMIN"] = trim($_REQUEST["hameleon_cart_theme_admin"]);
    $arFields["UF_CHAM_CART_ADMIN"] = trim($_REQUEST["hameleon_cart_message_admin"]);
    $arFields["UF_CHAM_THEME_USER"] = trim($_REQUEST["hameleon_cart_theme_user"]);
    $arFields["UF_CHAM_CART_USER"] = trim($_REQUEST["hameleon_cart_message_user"]);

    $arFields["UF_CH_BODY_BG_CLR"] = trim($_REQUEST["body_bg_clr"]);
    if($arFields["UF_CH_BODY_BG_CLR"] == "#")
        $arFields["UF_CH_BODY_BG_CLR"] = "";

    $arFields["UF_CH_POS_BODY_BG"] =  trim($_REQUEST["hameleon_cham_units"]);

    $arFields["UF_CH_MASK"] = trim($_REQUEST["hameleon_mask"]);
    $arFields["UF_CH_USER_MASK"] = trim($_REQUEST["hameleon_mask_user"]);
    $arFields["UF_CH_BODY_BG_CLR"] = trim($_REQUEST["hameleon_body_bg_clr"]);
    $arFields["UF_CH_POS_BODY_BG"] = trim($_REQUEST["hameleon_pos_body_bg"]);
    $arFields["UF_CH_BODY_REPEAT_BG"] = trim($_REQUEST["hameleon_body_repeat_bg"]);
    $arFields["UF_CHAM_SOC_TLG"] = trim($_REQUEST["hameleon_tlg"]);
    $arFields["UF_CALL_PHONE_ON"] = trim($_REQUEST["hameleon_call_phone_on"]);
    $arFields["UF_CALL_PHONE_MOB"] = trim($_REQUEST["hameleon_call_phone_mob"]);
    $arFields["UF_CALL_PHN_MOB_DESC"] = trim($_REQUEST["hameleon_call_phone_mob_desc"]);
    $arFields["UF_CH_COLOR_HEADER"] = trim($_REQUEST["hameleon_color_header"]);

    $arFields["UF_CH_FOOTER_BG_CLR"] = trim($_REQUEST["hameleon_footer_bg_clr"]);
    if($arFields["UF_CH_FOOTER_BG_CLR"] == "#")
        $arFields["UF_CH_FOOTER_BG_CLR"] = "";


    $arFields["UF_CH_FTR_CLR_OPACTY"] = trim($_REQUEST["hameleon_ftr_clr_opacity"]);
    $arFields["UF_QUAL_IMAGES"] = trim($_REQUEST["hameleon_quality_imgs"]);
    $arFields["UF_MORE_NAME_TRFF"] = trim($_REQUEST["hameleon_desc_name_trff"]);
    $arFields["UF_MORE_NAME_SRVC"] = trim($_REQUEST["hameleon_desc_name_srv"]);
    $arFields["UF_CHAM_CATAL_BTN_N2"] = trim($_REQUEST["hameleon_desc_name_ctl"]);
    $arFields["UF_MORE_NAME_CTLG"] = trim($_REQUEST["hameleon_desc_name_fast_order"]);
    $arFields["UF_CHAM_SCRL_CNCTS"] = trim($_REQUEST["hameleon_scrl_cncts"]);

    //$arFields["IPROPERTY_TEMPLATES"]["SECTION_META_TITLE"] = trim($_REQUEST["set-title"]);

    if(SITE_CHARSET == "windows-1251")
    {
        foreach($arFields as $key => $value)
            $arFields[$key] = utf8win1251($value);
            
        //$arFields["IPROPERTY_TEMPLATES"]["SECTION_META_TITLE"] = utf8win1251(trim($_REQUEST["set-title"]));
    }

    if(strlen($_FILES["hameleon_logotype"]["name"]) > 0)
    {
        $arFile = $_FILES["hameleon_logotype"];
        $arFile["MODULE_ID"] = "iblock";
        
        $arFields["PICTURE"] = $arFile;
    }
    elseif($_REQUEST["hameleon_logotype_del"] == 'Y' && strlen($_FILES["hameleon_logotype"]["name"]) <= 0)
    {
        CFile::Delete($_REQUEST['imagelogotype']);
        
        $arFile = CFile::MakeFileArray(0);
        $arFile["MODULE_ID"] = "iblock";
        $arFile["del"] = "Y";
        
        $arFields["PICTURE"] = $arFile;
    }


    if(strlen($_FILES["hameleon_favicon"]["name"]))
    {
        $arFile = $_FILES["hameleon_favicon"];
        $arFile["MODULE_ID"] = "iblock";
        
        $arFields["DETAIL_PICTURE"] = $arFile;
    }
    elseif($_REQUEST["hameleon_favicon_del"] == 'Y' && strlen($_FILES["hameleon_favicon"]["name"]) <= 0)
    {
        CFile::Delete($_REQUEST['imagefavicon']);
        
        $arFile = CFile::MakeFileArray(0);
        $arFile["MODULE_ID"] = "iblock";
        $arFile["del"] = "Y";
        
        $arFields["DETAIL_PICTURE"] = $arFile;
    }


    if(strlen($_FILES["hameleon_header_img"]["name"]))
    {
        $arFile = $_FILES["hameleon_header_img"];
        $arFile["MODULE_ID"] = "iblock";
        
        $arFields["UF_CHAM_HEADER_IMG"] = $arFile;
    }
    elseif($_REQUEST["hameleon_header_img_del"] == 'Y' && strlen($_FILES["hameleon_header_img"]["name"]) <= 0)
    {
        CFile::Delete($_REQUEST['imageheader_img']);
        
        $arFile = CFile::MakeFileArray(0);
        $arFile["MODULE_ID"] = "iblock";
        $arFile["del"] = "Y";
        
        $arFields["UF_CHAM_HEADER_IMG"] = $arFile;
    }


    if(strlen($_FILES["hameleon_copyright_picture"]["name"]))
    {
        $arFile = $_FILES["hameleon_copyright_picture"];
        $arFile["MODULE_ID"] = "iblock";
        
        $arFields["UF_CHAM_COPYPICTURE"] = $arFile;
    }
    elseif($_REQUEST["hameleon_copyright_picture_del"] == 'Y' && strlen($_FILES["hameleon_copyright_picture"]["name"]) <= 0)
    {
        CFile::Delete($_REQUEST['imagecopyright_img']);
        
        $arFile = CFile::MakeFileArray(0);
        $arFile["MODULE_ID"] = "iblock";
        $arFile["del"] = "Y";
        
        $arFields["UF_CHAM_COPYPICTURE"] = $arFile;
    }

    if(strlen($_FILES["hameleon_cart_bg_head"]["name"]))
    {
        $arFile = $_FILES["hameleon_cart_bg_head"];
        $arFile["MODULE_ID"] = "iblock";
        
        $arFields["UF_CH_BOX_BG_HEAD"] = $arFile;
    }
    elseif($_REQUEST["hameleon_cart_bg_head_del"] == 'Y' && strlen($_FILES["hameleon_cart_bg_head"]["name"]) <= 0)
    {
        CFile::Delete($_REQUEST['imagecart_bg_head']);
        
        $arFile = CFile::MakeFileArray(0);
        $arFile["MODULE_ID"] = "iblock";
        $arFile["del"] = "Y";
        
        $arFields["UF_CH_BOX_BG_HEAD"] = $arFile;
    }


    if(strlen($_FILES["body_bg"]["name"]))
    {
        $arFile = $_FILES["body_bg"];
        $arFile["MODULE_ID"] = "iblock";
        
        $arFields["UF_CH_BODY_BG"] = $arFile;
    }
    elseif($_REQUEST["body_bg_del"] == 'Y' && strlen($_FILES["body_bg"]["name"]) <= 0)
    {
        CFile::Delete($_REQUEST['imagebody_bg']);
        
        $arFile = CFile::MakeFileArray(0);
        $arFile["MODULE_ID"] = "iblock";
        $arFile["del"] = "Y";
        
        $arFields["UF_CH_BODY_BG"] = $arFile;
    }

    if(strlen($_FILES["hameleon_ftr_bg"]["name"]))
    {
        $arFile = $_FILES["hameleon_ftr_bg"];
        $arFile["MODULE_ID"] = "iblock";
        
        $arFields["UF_CH_FTR_BG"] = $arFile;
    }
    elseif($_REQUEST["hameleon_ftr_bg_del"] == 'Y' && strlen($_FILES["hameleon_ftr_bg"]["name"]) <= 0)
    {
        CFile::Delete($_REQUEST['imageftr_bg']);
        
        $arFile = CFile::MakeFileArray(0);
        $arFile["MODULE_ID"] = "iblock";
        $arFile["del"] = "Y";
        
        $arFields["UF_CH_FTR_BG"] = $arFile;
    }

   

    $res = CIBlockSection::GetByID($ID);
    $ar_res = $res->GetNext();


    if($bs->Update($ID, $arFields))
    {
        $arResult["OK"] = "Y";
        
        $ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues($ar_res["IBLOCK_ID"], $ID);
        $ipropValues->clearValues();
    }

    $arResult["HREF"] = "0";

    if(strlen(trim($_REQUEST["hameleon_domen"])) > 0)
        $arResult["HREF"] = "http://".trim($_REQUEST["hameleon_domen"]);

}

$arResult = json_encode($arResult);
echo $arResult;  
    
?>


<?//require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>
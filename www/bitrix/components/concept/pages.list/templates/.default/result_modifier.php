<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?

$host = explode(":", $_SERVER["HTTP_HOST"]);

if(strlen(SITE_SERVER_NAME) > 0 && $host[0] != SITE_SERVER_NAME)
    $host = SITE_SERVER_NAME;
    
else
    $host = $host[0];

$host = ChamHost::ChamHostFunc($host);
$url_name = "http://".$host;

$arResult["SERVER_URL2"] = $host;
$arResult["SERVER_URL"] = $url_name;


foreach($arResult["SECTIONS"] as $key=>$arSection)
{
    
    if($arSection["ID"] != $GLOBALS["CURRENT_SECTION_ID"])
        continue;

    if($arSection["PICTURE"] > 0)
    {
        $rsFile = CFile::GetByID($arSection["PICTURE"]);
        $arFile = $rsFile->Fetch();
        
        $arResult["SECTIONS"][$key]["LOGO_NAME"] = $arFile["ORIGINAL_NAME"];
    }
    
    if($arSection["DETAIL_PICTURE"] > 0)
    {
        $rsFile = CFile::GetByID($arSection["DETAIL_PICTURE"]);
        $arFile = $rsFile->Fetch();
        
        $arResult["SECTIONS"][$key]["FAVICON_NAME"] = $arFile["ORIGINAL_NAME"];
    }
    
    if($arSection["UF_CHAM_HEADER_IMG"] > 0)
    {
        $rsFile = CFile::GetByID($arSection["UF_CHAM_HEADER_IMG"]);
        $arFile = $rsFile->Fetch();
        
        $arResult["SECTIONS"][$key]["HEADER_IMG_NAME"] = $arFile["ORIGINAL_NAME"];
    }
    
    if($arSection["UF_CHAM_COPYPICTURE"] > 0)
    {
        $rsFile = CFile::GetByID($arSection["UF_CHAM_COPYPICTURE"]);
        $arFile = $rsFile->Fetch();
        
        $arResult["SECTIONS"][$key]["COPYRIGHT"] = $arFile["ORIGINAL_NAME"];
    }
    
    if($arSection["UF_CHAM_OG_IMAGE"] > 0)
    {
        $rsFile = CFile::GetByID($arSection["UF_CHAM_OG_IMAGE"]);
        $arFile = $rsFile->Fetch();
        
        $arResult["SECTIONS"][$key]["OG_IMAGE"] = $arFile["ORIGINAL_NAME"];
    }

    if($arSection["UF_CH_BOX_BG_HEAD"] > 0)
    {
        $rsFile = CFile::GetByID($arSection["UF_CH_BOX_BG_HEAD"]);
        $arFile = $rsFile->Fetch();
        
        $arResult["SECTIONS"][$key]["CART_BG_HEAD"] = $arFile["ORIGINAL_NAME"];
    }

    if($arSection["UF_CH_BODY_BG"] > 0)
    {
        $rsFile = CFile::GetByID($arSection["UF_CH_BODY_BG"]);
        $arFile = $rsFile->Fetch();
        
        $arResult["SECTIONS"][$key]["BODY_BG"] = $arFile["ORIGINAL_NAME"];
    }

    if($arSection["UF_CH_FTR_BG"] > 0)
    {
        $rsFile = CFile::GetByID($arSection["UF_CH_FTR_BG"]);
        $arFile = $rsFile->Fetch();
        
        $arResult["SECTIONS"][$key]["FTR_BG"] = $arFile["ORIGINAL_NAME"];
    }
    
    
    
    $arResult["SECTIONS"][$key]["UF_CHAM_TITLE_FONT_VAL"]["XML_ID"] = "lato";
    
    if(strlen($arSection["UF_CHAM_TITLE_FONT"]) > 0 )
    {
        $font = CUserFieldEnum::GetList(array(), array(
            "ID" => $arSection["UF_CHAM_TITLE_FONT"],
        ));

        $arResult["SECTIONS"][$key]["UF_CHAM_TITLE_FONT_VAL"] = $font->GetNext();

    }

    $arResult["SECTIONS"][$key]["UF_CH_MASK_VAL"]["XML_ID"] = "lato";
    
    if(strlen($arSection["UF_CH_MASK"]) > 0 )
    {
        $font = CUserFieldEnum::GetList(array(), array(
            "ID" => $arSection["UF_CH_MASK"],
        ));

        $arResult["SECTIONS"][$key]["UF_CH_MASK_VAL"] = $font->GetNext();

    }
    
    
    $arResult["SECTIONS"][$key]["UF_CHAM_TEXT_FONT_VAL"]["XML_ID"] = "lato";
    
    if(strlen($arSection["UF_CHAM_TEXT_FONT"]) > 0)
    {
        $font = CUserFieldEnum::GetList(array(), array(
            "ID" => $arSection["UF_CHAM_TEXT_FONT"],
        ));

        $arResult["SECTIONS"][$key]["UF_CHAM_TEXT_FONT_VAL"] = $font->GetNext();
    }
    
    
    $arResult["SECTIONS"][$key]["UF_CHAM_MAIN_COLOR_VAL"]["XML_ID"] = "light-blue";
    
    if(strlen($arSection["UF_CHAM_MAIN_COLOR"]) > 0)
    {
        $font = CUserFieldEnum::GetList(array(), array(
            "ID" => $arSection["UF_CHAM_MAIN_COLOR"],
        ));

        $arResult["SECTIONS"][$key]["UF_CHAM_MAIN_COLOR_VAL"] = $font->GetNext();
    }

    if(strlen($arSection["UF_CHAM_MENU_TYPE"]) > 0)
    {
        $menu = CUserFieldEnum::GetList(array(), array(
            "ID" => $arSection["UF_CHAM_MENU_TYPE"],
        ));

        $arResult["SECTIONS"][$key]["UF_CHAM_MENU_TYPE_ENUM"] = $menu->GetNext();
    }

}

$rsEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_NAME"=>"UF_CHAM_TITLE_FONT")); 
while($arEnum = $rsEnum->GetNext())
    $arResult["TITLE_FONTS"][] = $arEnum;

$rsEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_NAME"=>"UF_CHAM_TEXT_FONT")); 
while($arEnum = $rsEnum->GetNext())
    $arResult["TEXT_FONTS"][] = $arEnum;

$rsEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_NAME"=>"UF_CHAM_MAIN_COLOR")); 
while($arEnum = $rsEnum->GetNext())
    $arResult["MAIN_COLOR"][] = $arEnum;

$rsEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_NAME"=>"UF_CHAM_MENU_TYPE")); 
while($arEnum = $rsEnum->GetNext())
    $arResult["MENU_TYPE"][] = $arEnum;
    
$rsEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_NAME"=>"UF_CHAM_HEADER_CLR")); 
while($arEnum = $rsEnum->GetNext())
    $arResult["COLOR_SCHEME"][] = $arEnum;

$rsEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_NAME"=>"UF_CHAM_BUTTONS_TYPE")); 
while($arEnum = $rsEnum->GetNext())
    $arResult["BUTTONS_VIEW"][] = $arEnum;

$rsEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_NAME"=>"UF_CHAM_SOC_VIEW")); 
while($arEnum = $rsEnum->GetNext())
    $arResult["SOCIALS_POSITION"][] = $arEnum;   
 
$rsEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_NAME"=>"UF_CHAM_CHOOSECOPY")); 
while($arEnum = $rsEnum->GetNext())
    $arResult["CHOOSECOPY"][] = $arEnum;

$rsEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_NAME"=>"UF_CH_POS_BODY_BG")); 
while($arEnum = $rsEnum->GetNext())
    $arResult["POS_BODY_BG"][] = $arEnum;

$rsEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_NAME"=>"UF_CH_BODY_REPEAT_BG")); 
while($arEnum = $rsEnum->GetNext())
    $arResult["BODY_REPEAT_BG"][] = $arEnum;


$rsEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_NAME"=>"UF_CH_COLOR_HEADER")); 
while($arEnum = $rsEnum->GetNext())
    $arResult["COLOR_HEADER"][] = $arEnum;

$rsEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_NAME"=>"UF_VIEW_SCRLL_MENU")); 
while($arEnum = $rsEnum->GetNext())
    $arResult["VIEW_SCRLL_MENU"][] = $arEnum;

$rsEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_NAME"=>"UF_CH_MASK")); 
while($arEnum = $rsEnum->GetNext())
    $arResult["MASKS"][] = $arEnum;

//agreements
  
$res = CIBlock::GetList(
    Array(), 
    Array(
        'TYPE'=>'concept_hameleon',  
        'ACTIVE'=>'Y', 
        "CODE"=>'concept_hameleon_agreements'
    ), true
);

$arResult["AGREEMENT_BLOCK"] = $res->Fetch();


$arFilter = Array("IBLOCK_ID"=>$arResult["AGREEMENT_BLOCK"]["ID"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false);

while($ob = $res->GetNextElement())
    $arResult["AGREEMENTS"][] = $ob->GetFields();



//forms
  
$res = CIBlock::GetList(
    Array(), 
    Array(
        'TYPE'=>'concept_hameleon',  
        'ACTIVE'=>'Y', 
        "CODE"=>'concept_hameleon_forms'
    ), true
);

$arResult["FORMS_BLOCK"] = $res->Fetch();


$arFilter = Array("IBLOCK_ID"=>$arResult["FORMS_BLOCK"]["ID"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false);

while($ob = $res->GetNextElement())
    $arResult["FORMS"][] = $ob->GetFields();



$res = CIBlock::GetList(
    Array(), 
    Array(
        'TYPE'=>'concept_hameleon',  
        'ACTIVE'=>'Y', 
        "CODE"=>'concept_hameleon_advantag'
    ), true
);

$arResult["ADV_BLOCK"] = $res->Fetch();


$arFilter = Array("IBLOCK_ID"=>$arResult["ADV_BLOCK"]["ID"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false);

while($ob = $res->GetNextElement())
    $arResult["CART_ADV"][] = $ob->GetFields();


//seo
foreach($arResult["SECTIONS"] as $arSection)
{

    if($arSection["ID"] == $arParams["CURRENT_SECTION_ID"])
    {
       
        $h1 = $GLOBALS["h1_main"];
        $points = 0;
        
        if($arSection["UF_CHAM_NOINDEX"])
        {
            $arMess = Array();
            
            $arMess["class"] = "bad";
            $arMess["TEXT"] = "HAMELEON_SEO_NOINDEX_BAD";
            
            $arResult["SEO_MESSAGE"][] = $arMess;
        }
        
        
        
        //title
        $title = $arSection["NAME"];
                                                            
        if(strlen($arSection["IPROPERTY_VALUES"]["SECTION_META_TITLE"]) > 0)
            $title = $arSection["IPROPERTY_VALUES"]["SECTION_META_TITLE"];
            
            
        if(strlen($title) > 0)
        {
            $points += 40;
            
            $arMess = Array();
            
            $arMess["class"] = "good";
            $arMess["TEXT"] = "HAMELEON_SEO_TITLE1_GOOD";
            
            $arResult["SEO_MESSAGE"][] = $arMess;
 
        }
        else
        {
            $arMess = Array();
            
            $arMess["class"] = "bad";
            $arMess["TEXT"] = "HAMELEON_SEO_TITLE1_BAD";
            
            $arResult["SEO_MESSAGE"][] = $arMess;
            
            $arResult["SEO_TITLE_MESSAGE"][] = $arMess;
            
        }
        
        
        if(strlen($title) > 0 && strlen($arSection["IPROPERTY_VALUES"]["SECTION_META_TITLE"]) > 0)
        {
            $points += 5;
            
            $arMess = Array();
            
            $arMess["class"] = "good";
            $arMess["TEXT"] = "HAMELEON_SEO_TITLE2_GOOD";
            
            $arResult["SEO_MESSAGE"][] = $arMess;
        }
        else
        {
            $arMess = Array();
            
            $arMess["class"] = "notbad";
            $arMess["TEXT"] = "HAMELEON_SEO_TITLE2_BAD";
            
            $arResult["SEO_MESSAGE"][] = $arMess;
            
            $arResult["SEO_TITLE_MESSAGE"][] = $arMess;
        }
        
        if(strlen($title) > 0 && strlen($title) <= 70)
        {
            $points += 3;
            
            $arMess = Array();
            
            $arMess["class"] = "good";
            $arMess["TEXT"] = "HAMELEON_SEO_TITLE3_GOOD";
            
            $arResult["SEO_MESSAGE"][] = $arMess;
 
        }
        elseif(strlen($title) > 0 && strlen($title) > 70)
        {
            $arMess = Array();
            
            $arMess["class"] = "notbad";
            $arMess["TEXT"] = "HAMELEON_SEO_TITLE3_BAD";
            
            $arResult["SEO_MESSAGE"][] = $arMess;
            
            $arResult["SEO_TITLE_MESSAGE"][] = $arMess;
        }
        
        
        
        
        
        
        //description
        if(strlen($arSection["IPROPERTY_VALUES"]["SECTION_META_DESCRIPTION"]) > 0)
        {
            $points += 15;
            
            $arMess = Array();
            
            $arMess["class"] = "good";
            $arMess["TEXT"] = "HAMELEON_SEO_DESCRIPTION1_GOOD";
            
            $arResult["SEO_MESSAGE"][] = $arMess;
            
            $points += 2;
            
            $arMess = Array();
            
            $arMess["class"] = "good";
            $arMess["TEXT"] = "HAMELEON_SEO_DESCRIPTION2_GOOD";
            
            $arResult["SEO_MESSAGE"][] = $arMess;
                
                
            if(strlen($arSection["IPROPERTY_VALUES"]["SECTION_META_DESCRIPTION"]) <= 200)
            {
                $points += 2;
            
                $arMess = Array();
                
                $arMess["class"] = "good";
                $arMess["TEXT"] = "HAMELEON_SEO_DESCRIPTION3_GOOD";
                
                $arResult["SEO_MESSAGE"][] = $arMess;
            }
            else
            {
                $arMess = Array();
            
                $arMess["class"] = "notbad";
                $arMess["TEXT"] = "HAMELEON_SEO_DESCRIPTION3_BAD";
                
                $arResult["SEO_MESSAGE"][] = $arMess;
                
                $arResult["SEO_DESCRIPTION_MESSAGE"][] = $arMess;
            }
            
        }
        else
        {
            $arMess = Array();
            
            $arMess["class"] = "bad";
            $arMess["TEXT"] = "HAMELEON_SEO_DESCRIPTION1_BAD";
            
            $arResult["SEO_MESSAGE"][] = $arMess;
            
            $arResult["SEO_DESCRIPTION_MESSAGE"][] = $arMess;
        }
        
        if(strlen($arSection["IPROPERTY_VALUES"]["SECTION_META_DESCRIPTION"]) > 0 && $arSection["IPROPERTY_VALUES"]["SECTION_META_DESCRIPTION"] != $title)
        {
            $points += 10;
            
            $arMess = Array();
            
            $arMess["class"] = "good";
            $arMess["TEXT"] = "HAMELEON_SEO_DESCRIPTION4_GOOD";
            
            $arResult["SEO_MESSAGE"][] = $arMess;
        }
        else
        {
            $arMess = Array();
            
            $arMess["class"] = "bad";
            $arMess["TEXT"] = "HAMELEON_SEO_DESCRIPTION4_BAD";
            
            $arResult["SEO_MESSAGE"][] = $arMess;
            
            $arResult["SEO_DESCRIPTION_MESSAGE"][] = $arMess;
        }
        
        //keywords
        if(strlen($arSection["IPROPERTY_VALUES"]["SECTION_META_KEYWORDS"]) > 0)
        {
            $points += 2;
            
            $arMess = Array();
            
            $arMess["class"] = "good";
            $arMess["TEXT"] = "HAMELEON_SEO_KEYWORDS1_GOOD";
            
            $arResult["SEO_MESSAGE"][] = $arMess;
        }
        else
        {
            $arMess = Array();
            
            $arMess["class"] = "notbad";
            $arMess["TEXT"] = "HAMELEON_SEO_KEYWORDS1_BAD";
            
            $arResult["SEO_MESSAGE"][] = $arMess;
            
            $arResult["SEO_KEYWORDS_MESSAGE"][] = $arMess;
        }
        
        
    
        //h1
        if($h1 == 1)
        {
            $points += 15;
            
            $arMess = Array();
            
            $arMess["class"] = "good";
            $arMess["TEXT"] = "HAMELEON_SEO_H1_GOOD";
            
            $arResult["SEO_MESSAGE"][] = $arMess;
        }
        else
        {
            $arMess = Array();
            
            $arMess["class"] = "bad";
            $arMess["TEXT"] = "HAMELEON_SEO_H1_BAD";
            
            $arResult["SEO_MESSAGE"][] = $arMess;
        }
        
        
        //og
        if(strlen($arSection["UF_CHAM_OG_TITLE"]) > 0)
        {
            $points += 2;
            
            $arMess = Array();
            
            $arMess["class"] = "good";
            $arMess["TEXT"] = "HAMELEON_SEO_OG_TITLE_GOOD";
            
            $arResult["SEO_MESSAGE"][] = $arMess;
        }
        else
        {
            $arMess = Array();
            
            $arMess["class"] = "notbad";
            $arMess["TEXT"] = "HAMELEON_SEO_OG_TITLE_BAD";
            
            $arResult["SEO_MESSAGE"][] = $arMess;
        }
        
        if(strlen($arSection["UF_CHAM_OG_DESC"]) > 0)
        {
            $points += 2;
            
            $arMess = Array();
            
            $arMess["class"] = "good";
            $arMess["TEXT"] = "HAMELEON_SEO_OG_DESCRIPTION_GOOD";
            
            $arResult["SEO_MESSAGE"][] = $arMess;
        }
        else
        {
            $arMess = Array();
            
            $arMess["class"] = "notbad";
            $arMess["TEXT"] = "HAMELEON_SEO_OG_DESCRIPTION_BAD";
            
            $arResult["SEO_MESSAGE"][] = $arMess;
        }
        
        if($arSection["UF_CHAM_OG_IMAGE"] > 0)
        {
            $points += 2;
            
            $arMess = Array();
            
            $arMess["class"] = "good";
            $arMess["TEXT"] = "HAMELEON_SEO_OG_IMAGE_GOOD";
            
            $arResult["SEO_MESSAGE"][] = $arMess;
        }
        else
        {
            $arMess = Array();
            
            $arMess["class"] = "notbad";
            $arMess["TEXT"] = "HAMELEON_SEO_OG_IMAGE_BAD";
            
            $arResult["SEO_MESSAGE"][] = $arMess;
        }
        
        
        
        
        if($arSection["UF_CHAM_NOINDEX"])
            $points = 0;
        
        
        $arResult["SEO_POINTS"] = $points;
        
        if($points <= 50)
        {
            $arResult["SEO_CLASS"] = "bad";
            $arResult["SEO_STATUS"] = "BAD";
        }  
        elseif($points > 50 && $points <= 85)
        {
            $arResult["SEO_CLASS"] = "notbad";
            $arResult["SEO_STATUS"] = "NOTBAD";
        } 
        elseif($points > 85)
        {
            $arResult["SEO_CLASS"] = "good";
            $arResult["SEO_STATUS"] = "GOOD";
        }


        
    }
}

?>

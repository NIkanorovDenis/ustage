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

    $arFields["UF_CHAM_NOINDEX"] = trim($_REQUEST["hameleon_seo_noindex"]);

    $arFields["IPROPERTY_TEMPLATES"]["SECTION_META_TITLE"] = trim($_REQUEST["hameleon_seo_title"]);
    $arFields["IPROPERTY_TEMPLATES"]["SECTION_META_KEYWORDS"] = trim($_REQUEST["hameleon_seo_keywords"]);
    $arFields["IPROPERTY_TEMPLATES"]["SECTION_META_DESCRIPTION"] = trim($_REQUEST["hameleon_seo_description"]);

    $arFields["UF_CHAM_OG_URL"] = $_REQUEST["hameleon_seo_og_url"];
    $arFields["UF_CHAM_OG_TYPE"] = $_REQUEST["hameleon_seo_og_type"];
    $arFields["UF_CHAM_OG_TITLE"] = $_REQUEST["hameleon_seo_og_title"];
    $arFields["UF_CHAM_OG_DESC"] = $_REQUEST["hameleon_seo_og_description"];


    $arFields["UF_CHAM_META_TAGS"] = $_REQUEST["hameleon_other_meta"];

    if(SITE_CHARSET == "windows-1251")
    {
        foreach($arFields as $key => $value)
        {
            if(is_array($value))
            {
                foreach($value as $k=>$val)
                    $value[$k] = utf8win1251($val);
                    
            }
            else
            {
                $arFields[$key] = utf8win1251($value);
            }
            
            
        }
            
            
        $arFields["IPROPERTY_TEMPLATES"]["SECTION_META_TITLE"] = utf8win1251(trim($_REQUEST["hameleon_seo_title"]));
        $arFields["IPROPERTY_TEMPLATES"]["SECTION_META_KEYWORDS"] = utf8win1251(trim($_REQUEST["hameleon_seo_keywords"]));
        $arFields["IPROPERTY_TEMPLATES"]["SECTION_META_DESCRIPTION"] = utf8win1251(trim($_REQUEST["hameleon_seo_description"]));
    }



    if(strlen($_FILES["hameleon_seo_og_image"]["name"]))
    {
        $arFile = $_FILES["hameleon_seo_og_image"];
        $arFile["MODULE_ID"] = "iblock";
        
        $arFields["UF_CHAM_OG_IMAGE"] = $arFile;
    }
    elseif($_REQUEST["hameleon_seo_og_image_del"] == 'Y' && strlen($_FILES["hameleon_seo_og_image"]["name"]) <= 0)
    {
        CFile::Delete($_REQUEST['imageogimage']);
        
        $arFile = CFile::MakeFileArray();
        $arFile["MODULE_ID"] = "iblock";
        $arFile["del"] = "Y";
        
        $arFields["UF_CHAM_OG_IMAGE"] = $arFile;
    }


    $res = CIBlockSection::GetByID($ID);
    $ar_res = $res->GetNext();


    if($bs->Update($ID, $arFields))
    {
        $arResult["OK"] = "Y";
        
        $ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues($ar_res["IBLOCK_ID"], $ID);
        $ipropValues->clearValues();
    }


}
$arResult = json_encode($arResult);
echo $arResult;  
    
?>


<?//require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>
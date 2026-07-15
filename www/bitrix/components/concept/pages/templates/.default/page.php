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
<?
$host = ChamHost::ChamHostFunc($_SERVER["HTTP_HOST"]);

//require_once($_SERVER["DOCUMENT_ROOT"].$templateFolder.'/convert_class.php');
// if(stripos($_SERVER["HTTP_HOST"], 'xn--') !== false) 
// {
//     $idn = new idna_convert(array('idn_version'=>2008));
//     $punycode = $idn->decode($_SERVER["HTTP_HOST"]);
    
//     if(SITE_CHARSET == "windows-1251")
//         $punycode = utf8win1251($punycode);
    
//     $host = $punycode;
// }

// $host = explode(":", $host);
// $host = $host[0];


// $sub = substr($host, 0, 4);

// if($sub == "www.")
//     $host = substr_replace($host, "", 0, 4);
   
?>

<?
$arSelect = Array("ID", "SECTION_PAGE_URL", "UF_CHAM_URL");
$arFilter = Array('IBLOCK_ID'=>$arParams["IBLOCK_ID"], "ACTIVE"=>"Y", "=CODE"=>$arResult["VARIABLES"]["SECTION_CODE"]);
$db_list = CIBlockSection::GetList(Array("SORT"=>"ASC"), $arFilter, false, $arSelect);
$ar_result = $db_list->GetNext();

if(strlen($ar_result["UF_CHAM_URL"]) > 0)
    LocalRedirect("http://".$ar_result["UF_CHAM_URL"]);


$arFilter2 = Array('IBLOCK_ID'=>$arParams["IBLOCK_ID"], "ACTIVE"=>"Y");
$db_list2 = CIBlockSection::GetList(Array("SORT"=>"ASC", "ID"=>"ASC"), $arFilter2, false);
$ar_result2 = $db_list2->GetNext();    


if($ar_result["ID"] == $ar_result2["ID"])
    LocalRedirect(SITE_DIR);


$arFilter3 = Array('IBLOCK_ID'=>$arParams["IBLOCK_ID"], "ACTIVE"=>"Y", "=UF_CHAM_URL" => $host);
$db_list3 = CIBlockSection::GetList(Array("SORT"=>"ASC", "ID"=>"ASC"), $arFilter3, false);
$ar_result3 = $db_list3->GetNext(); 

if($ar_result["ID"] == $ar_result3["ID"])
    LocalRedirect(SITE_DIR);
    

/*if(strlen(SITE_SERVER_NAME) > 0)
{
    if($host != SITE_SERVER_NAME && strlen($ar_result["UF_CHAM_URL"]) <= 0)
        LocalRedirect("http://".SITE_SERVER_NAME.$ar_result["SECTION_PAGE_URL"]);
}*/


if($ar_result["ID"] <= 0)
    $ar_result["ID"] = -1;

?>


<?$GLOBALS["CURRENT_SECTION_ID"] = $APPLICATION->IncludeComponent(
	"concept:page.generator", 
	"", 
	array(
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CHECK_DATES" => $arParams["CHECK_DATES"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"PARENT_SECTION" => $ar_result["ID"],
		"SET_TITLE" => $arParams["SET_TITLE"],
		"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
		"MESSAGE_404" => $arParams["MESSAGE_404"],
		"SET_STATUS_404" => $arParams["SET_STATUS_404"],
		"SHOW_404" => $arParams["SHOW_404"],
		"FILE_404" => $arParams["FILE_404"],
		"COMPONENT_TEMPLATE" => ""
	),
	$component
);?>


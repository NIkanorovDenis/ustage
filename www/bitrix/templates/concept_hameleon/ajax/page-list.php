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
	$arFilter = Array('IBLOCK_CODE'=>"concept_hameleon_site", 'GLOBAL_ACTIVE'=>'', "ACTIVE"=>"");
	$arSelect = Array("ID");
	$db_list = CIBlockSection::GetList(Array("SORT"=>"ASC"), $arFilter, false, $arSelect);

	while($ar_result = $db_list->GetNext())
	{
	    $bs = new CIBlockSection;
	    
	    $arFields = Array();
	    
	    $arFields["ACTIVE"] = trim($_REQUEST["page_active".$ar_result["ID"]]);
	    $arFields["SORT"] = trim($_REQUEST["sort_".$ar_result["ID"]]);
	    
	    
	    
	    $bs->Update($ar_result["ID"], $arFields);
	}


	$arResult["OK"] = "Y";
}
$arResult = json_encode($arResult);
echo $arResult;
?>
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?

	$arFilter = Array("ID"=> $arResult["ID"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(Array("sort" => "asc"), $arFilter);
    while($ob = $res->GetNextElement())
    {
        $arResult["PROPERTIES"] = $ob->GetProperties();
    }



    $iblock = array();
    $res = CIBlockSection::GetByID($arParams["CHAM_SECTION_ID"]);
	if($ar_res = $res->GetNext())
	{
        $iblock["IBLOCK_ID"] = $ar_res["IBLOCK_ID"];
        $iblock["ID"] = $ar_res["ID"];
	}

    $rsSections = CIBlockSection::GetList($arSort, array("IBLOCK_ID" => $iblock["IBLOCK_ID"], "ID"=>$iblock["ID"]),false, array("ID","IBLOCK_ID","IBLOCK_SECTION_ID","NAME","DESCRIPTION","UF_*"));
    
    while ($arSection = $rsSections->Fetch())
    {
        $arResult["SECTION_MAIN"] = $arSection;
    }


    $arSelect = Array("SORT", "ID", "IBLOCK_ID", "PROPERTY_*");
    $arFilter = Array("ID"=>$arParams["CATALOG_ID"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, $arSelect);
    while($ob = $res->GetNextElement()){ 
        $arFields = $ob->GetFields();  
        $arFields["PROPERTIES"] = $ob->GetProperties();  

        $arResult["CATALOG"] = $arFields;

    }

    $currency = "";
    if($arResult["CATALOG"]["PROPERTIES"]["CHAM_CURR_ON"]["VALUE"] == "Y")
        $currency = $arResult["CATALOG"]["PROPERTIES"]["CHAM_CURR_VAL"]["VALUE"];

    if(strlen($currency)<=0)
        $currency = $arResult["PROPERTIES"]["CHAM_CURR"]["VALUE"];

 
    // 
    global $DB_cham;
    $arResult["PROPERTIES"]["CUR_PRICE"]["VALUE"] = "<span class='main1'>".$arResult["PROPERTIES"]["PRICE"]["~VALUE"]."</span>";
           
    if(strlen($arResult["PROPERTIES"]["BOX_PRICE"]["VALUE"])>0 && strlen($arResult["PROPERTIES"]["PRICE"]["~VALUE"])<=0)
    {
        $unit = "";

        if(in_array($arResult["PROPERTIES"]["CHAM_UNITS"]["VALUE"], $arResult["SECTION_MAIN"]["UF_CHAM_UNITS"]) && $arResult["PROPERTIES"]["REQUEST_PRICE"]["VALUE"] != "Y")
        {
            $unit = $DB_cham["UNITS"]["ITEMS"][$arResult["PROPERTIES"]["CHAM_UNITS"]["VALUE"]]["~SYM_MAIN"];

            if(strlen($DB_cham["UNITS"]["ITEMS"][$arResult["PROPERTIES"]["CHAM_UNITS"]["VALUE"]]["~SYM_PRICE"])>0)
                $unit = $DB_cham["UNITS"]["ITEMS"][$arResult["PROPERTIES"]["CHAM_UNITS"]["VALUE"]]["~SYM_PRICE"];

            $unit = "<span class='units-style'> ".$unit."</span>";
        }


        $from = "";
            if($arResult["PROPERTIES"]["PRICE_FROM"]["VALUE"] == "Y")
                $from = GetMessage("HAM_MODAL_CTL_FROM");

        $arResult["PROPERTIES"]["CUR_PRICE"]["VALUE"] = $from."<span class='main1'>".CHam_format::convertMain($arResult["PROPERTIES"]["BOX_PRICE"]["VALUE"], $arResult["PROPERTIES"]["CHAM_CURR"]["VALUE"], $currency)."</span>".$unit;
    }

    if($arResult["PROPERTIES"]["REQUEST_PRICE"]["VALUE"] == "Y")
       $arResult["PROPERTIES"]["CUR_PRICE"]["VALUE"] = "<span class='main1'>".GetMessage("HAM_MODAL_CTL_REQUEST")."</span>";

    $arResult["PROPERTIES"]["CUR_OLD_PRICE"]["VALUE"] = $arResult["PROPERTIES"]["OLD_PRICE"]["~VALUE"];

    if($arResult["PROPERTIES"]["REQUEST_PRICE"]["VALUE"] == "Y" && strlen($arResult["PROPERTIES"]["CUR_OLD_PRICE"]["VALUE"])<=0)
        $arResult["PROPERTIES"]["CUR_OLD_PRICE"]["VALUE"] = "";


    if(strlen($arResult["PROPERTIES"]["BOX_OLD_PRICE"]["VALUE"])>0 && strlen($arResult["PROPERTIES"]["CUR_OLD_PRICE"]["VALUE"])<=0 && $arResult["PROPERTIES"]["REQUEST_PRICE"]["VALUE"] != "Y")
        $arResult["PROPERTIES"]["CUR_OLD_PRICE"]["VALUE"] = CHam_format::CurrFormatString($arResult["PROPERTIES"]["BOX_OLD_PRICE"]["VALUE"], $arResult["PROPERTIES"]["CHAM_CURR"]["VALUE"], $currency);
    // 
	

	

    if(!empty($arResult["SECTION_MAIN"]["UF_CHAM_AGREEMENTS"]))
	{

        $arSelect = Array("SORT", "ID", "IBLOCK_ID", "NAME", "PREVIEW_TEXT", "PROPERTY_*");
        $arFilter = Array("ID"=>$arResult["SECTION_MAIN"]["UF_CHAM_AGREEMENTS"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
        $res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, $arSelect);
        while($ob = $res->GetNextElement()){ 
            $arFields = $ob->GetFields();  
            $arFields["PROPERTIES"] = $ob->GetProperties();  

            $arResult["SECTION_MAIN"]["AGREEMENTS"][] = $arFields;
        }
	  
	}
    
    if(strlen($arResult["SECTION_MAIN"]["UF_CHAM_BUTTONS_TYPE"]) > 0)
    {
        $arResult["SECTION_MAIN"]["UF_CHAM_BUTTONS_TYPE_ENUM"] = CUserFieldEnum::GetList(array(), array(
        "ID" => $arResult["SECTION_MAIN"]["UF_CHAM_BUTTONS_TYPE"],
        ))->GetNext();
    }
    else
        $arResult["SECTION_MAIN"]["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"] = "elips";



?>
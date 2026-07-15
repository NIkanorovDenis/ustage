<?
global $INTRANET_TOOLBAR;
global $DB_cham;

use Bitrix\Main\Context,
	Bitrix\Main\Type\DateTime,
	Bitrix\Main\Loader,
	Bitrix\Iblock;

if(!CModule::IncludeModule("iblock"))
	return false;


	$arResult = array();

	$iblockIdLand = 0;


	$cur_land = $arParams["CURRENT_LAND"];

	if(strlen($cur_land)<=0)
		$cur_land = $_REQUEST["section"];

	$res = CIBlockSection::GetByID($cur_land);

	if($ar_res = $res->GetNext())
  		$iblockIdLand = $ar_res['IBLOCK_ID'];

	$rsSections = CIBlockSection::GetList(Array("SORT"=>"ASC"), array("IBLOCK_ID" => $iblockIdLand, "ID"=>$cur_land), false, array("ID","UF_CH_BAS_CURENCIES","UF_CHAM_UNITS"));
	$arResult["BAS_CURENCIES"] = $rsSections->GetNext();




	$ibcode = 'concept_hameleon_site_catalog';



	$HAM_BOX_ = $APPLICATION->get_cookie('_ham_box_'.$cur_land, "");
	$HAM_BOX = unserialize($HAM_BOX_);

	
	$id_cart = array();
	foreach ($HAM_BOX as $value) {
		$id_cart[] = $value["id"];
	}

	if(!empty($id_cart))
	{
		$arResult["SALE"] = false;
		$arResult["REQUEST_PRICE"] = false;
		$arResult["FROM"] = false;
		$cur_total = 0;
		$cur_total_old = 0;
		$cur_total_sale = 0;
		$cur_total_max = 0;

		$count_added_elements = 0;

		$arFilter = Array('IBLOCK_CODE' => $ibcode, "ID"=>$id_cart, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "PROPERTY_BOX_ADD_VALUE" => "Y");
		$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false);

		while($ob = $res->GetNextElement())
		{
			$arItem = $ob->GetFields();  
			$arItem["PROPERTIES"] = $ob->GetProperties();
			$arItem["OTHER_COMPLECT"] = array();
			
			// 
			if(strlen($HAM_BOX[$arItem["ID"]]["other_complect"])>0)
			{
				$arItem["OTHER_COMPLECT"]["NAME"] = $arItem["PROPERTIES"]["OTHER_COMPLECT"]["~VALUE"][$HAM_BOX[$arItem["ID"]]["other_complect"]]." ". $arItem["PROPERTIES"]["OTHER_COMPLECT"]["~DESCRIPTION"][$HAM_BOX[$arItem["ID"]]["other_complect"]];

				$arItem["OTHER_COMPLECT"]["VALUE"] = $HAM_BOX[$arItem["ID"]]["other_complect"];
				$arItem["OTHER_COMPLECT"]["ID"] = $HAM_BOX[$arItem["ID"]]["other_complect"];
			}

			// 
			$from_on = "";
			if($arItem["PROPERTIES"]["PRICE_FROM"]["VALUE"] == "Y" && strlen($from_on) <= 0) 
	            $from_on = GetMessage("HAM_BOX_FROM")." ";
			
			$cur_step = floatval(trim($arItem["PROPERTIES"]["BOX_PRICE_STEP"]["VALUE"]));
			if($cur_step<=0)
			{
				$arItem["PROPERTIES"]["BOX_PRICE_STEP"]["VALUE"] = 1;
				$cur_step = 1;
			}

			$cur_min_count = floatval(trim($arItem["PROPERTIES"]["BOX_MIN_COUNT"]["VALUE"]));
			if($cur_min_count<=0)
			{
				$arItem["PROPERTIES"]["BOX_MIN_COUNT"]["VALUE"] = 1;
				$cur_min_count = 1;
			}

			if($cur_min_count < $cur_step)
				$arItem["PROPERTIES"]["BOX_MIN_COUNT"]["VALUE"] = $cur_step;


			$cur_step_cookie = floatval(trim($HAM_BOX[$arItem["ID"]]["count"]));

			if($cur_step_cookie>0)
				$arItem["PROPERTIES"]["BOX_PRICE_STEP_"]["VALUE"] = floatval(trim($HAM_BOX[$arItem["ID"]]["count"]));
			
			else
			{
				$arItem["PROPERTIES"]["BOX_PRICE_STEP_"]["VALUE"] = 1;
				$cur_step_cookie = 1;
			}

			if($cur_step_cookie < $cur_min_count)
			{
				$arItem["PROPERTIES"]["BOX_PRICE_STEP_"]["VALUE"] = $cur_min_count;
				$cur_step_cookie = $cur_min_count;
			}


			$total_element_val = CHam_format::convertCurr($arItem["PROPERTIES"]["BOX_PRICE"]["VALUE"], $arItem["PROPERTIES"]["CHAM_CURR"]["VALUE"], $arResult["BAS_CURENCIES"]["UF_CH_BAS_CURENCIES"]) * $cur_step_cookie;
			$total_element_val_old = CHam_format::convertCurr($arItem["PROPERTIES"]["BOX_OLD_PRICE"]["VALUE"], $arItem["PROPERTIES"]["CHAM_CURR"]["VALUE"], $arResult["BAS_CURENCIES"]["UF_CH_BAS_CURENCIES"]) * $cur_step_cookie;

			$arItem["PROPERTIES"]["BOX_PRICE_NUM"]["VALUE"] = CHam_format::convertCurr($arItem["PROPERTIES"]["BOX_PRICE"]["VALUE"], $arItem["PROPERTIES"]["CHAM_CURR"]["VALUE"], $arResult["BAS_CURENCIES"]["UF_CH_BAS_CURENCIES"]);
			$arItem["PROPERTIES"]["BOX_OLD_PRICE_NUM"]["VALUE"] = CHam_format::convertCurr($arItem["PROPERTIES"]["BOX_OLD_PRICE"]["VALUE"], $arItem["PROPERTIES"]["CHAM_CURR"]["VALUE"], $arResult["BAS_CURENCIES"]["UF_CH_BAS_CURENCIES"]);

			$arItem["PROPERTIES"]["BOX_PRICE_COUNT"]["VALUE"] = $total_element_val;
			$arItem["PROPERTIES"]["BOX_OLD_PRICE_COUNT"]["VALUE"] = $total_element_val_old;


			if($total_element_val_old>0 && $arItem["PROPERTIES"]["REQUEST_PRICE"]["VALUE"] != "Y" && !$arResult["SALE"])
				$arResult["SALE"] = true;


			if($arItem["PROPERTIES"]["PRICE_FROM"]["VALUE"] == "Y" && !$arResult["FROM"] && $arItem["PROPERTIES"]["REQUEST_PRICE"]["VALUE"] != "Y") 
				$arResult["FROM"] = true;


			

			if($total_element_val>0)
			{
				if($arItem["PROPERTIES"]["REQUEST_PRICE"]["VALUE"] == "Y")
				{
					$cur_total += 0;

					if(!$arResult["REQUEST_PRICE"] && $count_added_elements == 0)
						$arResult["REQUEST_PRICE"] = true;
				}

				else
				{
					if($arResult["REQUEST_PRICE"])
						$arResult["REQUEST_PRICE"] = false;

					if($total_element_val_old<=0)
						$cur_total_max += $total_element_val;

					$cur_total += $total_element_val;
				}

				
			}


			if($total_element_val_old>0 && $total_element_val>0)
			{
				
				if($arItem["PROPERTIES"]["REQUEST_PRICE"]["VALUE"] == "Y")
				{
					$cur_total_old += 0;
					$cur_total_max += 0;
				}

				else
				{
					$cur_total_old += $total_element_val_old;
					$cur_total_max += $total_element_val_old;
				}
				
			}

			

			$unit = "";
	      
	            if(in_array($arItem["PROPERTIES"]["CHAM_UNITS"]["VALUE"], $arResult["BAS_CURENCIES"]["UF_CHAM_UNITS"]) && $arItem["PROPERTIES"]["REQUEST_PRICE"]["VALUE"] != "Y")
                {
                    $unit = $DB_cham["UNITS"]["ITEMS"][$arItem["PROPERTIES"]["CHAM_UNITS"]["VALUE"]]["~SYM_MAIN"];

                    if(strlen($DB_cham["UNITS"]["ITEMS"][$arItem["PROPERTIES"]["CHAM_UNITS"]["VALUE"]]["~SYM_PRICE"])>0)
                        $unit = $DB_cham["UNITS"]["ITEMS"][$arItem["PROPERTIES"]["CHAM_UNITS"]["VALUE"]]["~SYM_PRICE"];

                    $unit = "<span class='units-style'>&nbsp;".$unit."</span>";
                }

	        $from = "";
	            if($arItem["PROPERTIES"]["PRICE_FROM"]["VALUE"] == "Y")
	            $from = GetMessage("HAM_BOX_FROM");

	        $price = "";
	            if($arItem["PROPERTIES"]["REQUEST_PRICE"]["VALUE"] == "Y")
	                $price = GetMessage("HAM_BOX_REQUEST");
	            else
	                $price = CHam_format::convertMain($arItem["PROPERTIES"]["BOX_PRICE"]["VALUE"], $arItem["PROPERTIES"]["CHAM_CURR"]["VALUE"], $arResult["BAS_CURENCIES"]["UF_CH_BAS_CURENCIES"]);

	        $price_count = "";
	            if($arItem["PROPERTIES"]["REQUEST_PRICE"]["VALUE"] == "Y")
	                $price_count = GetMessage("HAM_BOX_REQUEST");

	            else
	                $price_count = CHam_format::CurrFormatString($arItem["PROPERTIES"]["BOX_PRICE_COUNT"]["VALUE"], $arResult["BAS_CURENCIES"]["UF_CH_BAS_CURENCIES"]);

	        $oldprice = "";
	            if($arItem["PROPERTIES"]["BOX_OLD_PRICE"]["VALUE"] && $arItem["PROPERTIES"]["REQUEST_PRICE"]["VALUE"] != "Y")
	                $oldprice = CHam_format::convertMain($arItem["PROPERTIES"]["BOX_OLD_PRICE"]["VALUE"], $arItem["PROPERTIES"]["CHAM_CURR"]["VALUE"], $arResult["BAS_CURENCIES"]["UF_CH_BAS_CURENCIES"]);


	        $old_price_count = "";
	        if($arItem["PROPERTIES"]["BOX_OLD_PRICE_COUNT"]["VALUE"] > 0 && $arItem["PROPERTIES"]["REQUEST_PRICE"]["VALUE"] != "Y")
	            $old_price_count = CHam_format::CurrFormatString($arItem["PROPERTIES"]["BOX_OLD_PRICE_COUNT"]["VALUE"], $arResult["BAS_CURENCIES"]["UF_CH_BAS_CURENCIES"]);


	        $arItem["PROPERTIES"]["BOX_PRICE_FORMAT"]["VALUE"] = $from.$price.$unit;
	        $arItem["PROPERTIES"]["BOX_PRICE_COUNT_FORMAT"]["VALUE"] = $from.$price_count;
			$arItem["PROPERTIES"]["BOX_OLD_PRICE_FORMAT"]["VALUE"] = $oldprice;
			$arItem["PROPERTIES"]["BOX_OLD_PRICE_COUNT_FORMAT"]["VALUE"] = $old_price_count;

			$arResult["ITEMS"][] = $arItem;

			$count_added_elements++;
		}


		$cur_total_sale = $cur_total_max - $cur_total;
		$arResult["TOTAL_SALE_NUM"] = $cur_total_sale;
		$arResult["TOTAL_SALE"] = CHam_format::CurrFormatString($cur_total_sale, $arResult["BAS_CURENCIES"]["UF_CH_BAS_CURENCIES"]);

		$arResult["TOTAL_OLD"] = CHam_format::CurrFormatString($cur_total_old, $arResult["BAS_CURENCIES"]["UF_CH_BAS_CURENCIES"]);


		if($arResult["SALE"])
	        $arResult["SALE_TEXT"] = GetMessage('HAM_BOX_TOTAL_SALE');
	    else
	        $arResult["SALE_TEXT"] = GetMessage('HAM_BOX_TOTAL');


		$from = "";
		if($arResult["FROM"])
	        $from = GetMessage('HAM_BOX_FROM');

	    $arResult["TOTAL_NEW"] = $from.CHam_format::CurrFormatString($cur_total, $arResult["BAS_CURENCIES"]["UF_CH_BAS_CURENCIES"]);

	    $arResult["TOTAL_NEW_NUM"] = $cur_total;
	    
	    if($arResult["REQUEST_PRICE"])
			$arResult["REQUEST_PRICE_REQ"] = GetMessage("HAM_BOX_REQUEST");
		

		$arResult["COUNT"] = 0;
		if(!empty($arResult["ITEMS"]))
			$arResult["COUNT"] = count($arResult["ITEMS"]);

	}


?>
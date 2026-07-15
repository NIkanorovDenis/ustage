<?
class ESEvents
{
	// IBlock
	public static function  OnAfterIBlockSectionAdd(&$arFields)
	{
		GLOBAL $ES_IB_SECTION_UPDATE;
		if($ES_IB_SECTION_UPDATE == "Y") return true;

		$id = intval($arFields["ID"]);

		if($arFields["IBLOCK_ID"] == 32 && intval($arFields["RESULT"]) > 0 && $id > 0)
		{
			if(intval($arFields["UF_YM"]) > 0)
			{
				CModule::IncludeModule("energosoft.utils");
				$arElements = ESIBlock::GetList(32, false, false, array("ACTIVE"=>"ALL","INCLUDE_SUBSECTIONS"=>"Y","SECTION_ID"=>$id));
				foreach($arElements as $arElement)
				{
					CIBlockElement::SetPropertyValueCode($arElement["ID"], "YMC", $arFields["UF_YM"]);
				}
				$ES_IB_SECTION_UPDATE = "Y";
				$se = new CIBlockSection();
				$se->Update($arFields["ID"], array("UF_YM"=>false));
				$ES_IB_SECTION_UPDATE = "";
			}
		}
	}

	public static function  OnAfterIBlockSectionUpdate(&$arFields)
	{
		GLOBAL $ES_IB_SECTION_UPDATE;
		if($ES_IB_SECTION_UPDATE == "Y") return true;

		$id = intval($arFields["ID"]);

		if($arFields["IBLOCK_ID"] == 32 && intval($arFields["RESULT"]) > 0 && $id > 0)
		{
			if(intval($arFields["UF_YM"]) > 0)
			{
				CModule::IncludeModule("energosoft.utils");
				$arElements = ESIBlock::GetList(32, false, false, array("ACTIVE"=>"ALL","INCLUDE_SUBSECTIONS"=>"Y","SECTION_ID"=>$id));
				foreach($arElements as $arElement)
				{
					CIBlockElement::SetPropertyValueCode($arElement["ID"], "YMC", $arFields["UF_YM"]);
				}
				$ES_IB_SECTION_UPDATE = "Y";
				$se = new CIBlockSection();
				$se->Update($arFields["ID"], array("UF_YM"=>false));
				$ES_IB_SECTION_UPDATE = "";
			}
		}
	}

	public static function  OnAfterIBlockElementAdd(&$arFields)
	{
		GLOBAL $ES_IB_ELEMENT_UPDATE;
		if($ES_IB_ELEMENT_UPDATE == "Y") return true;

		if(intval($arFields["ID"]) > 0)
		{
			CModule::IncludeModule("energosoft.utils");
			CModule::IncludeModule("iblock");
			$arElement = ESIBlock::GetByID($arFields["ID"]);
			if($arElement["IBLOCK_ID"] == 35)
			{
				$arElement["NAME"] = str_replace("( ", "(", $arElement["NAME"]);
				$arElement["NAME"] = str_replace("  ", " ", $arElement["NAME"]);
				$ES_IB_ELEMENT_UPDATE = "Y";
				$el = new CIBlockElement();
				$el->Update($arFields["ID"], array("NAME"=>$arElement["NAME"]));
				$ES_IB_ELEMENT_UPDATE = "";
			}
		}
		return true;
	}

	public static function  OnAfterIBlockElementUpdate(&$arFields)
	{
		GLOBAL $ES_IB_ELEMENT_UPDATE;
		if($ES_IB_ELEMENT_UPDATE == "Y") return true;

		if(intval($arFields["ID"]) > 0)
		{
			CModule::IncludeModule("energosoft.utils");
			CModule::IncludeModule("iblock");
			$arElement = ESIBlock::GetByID($arFields["ID"]);
			if($arElement["IBLOCK_ID"] == 35)
			{
				$arElement["NAME"] = str_replace("( ", "(", $arElement["NAME"]);
				$arElement["NAME"] = str_replace("  ", " ", $arElement["NAME"]);
				$ES_IB_ELEMENT_UPDATE = "Y";
				$el = new CIBlockElement();
				$el->Update($arFields["ID"], array("NAME"=>$arElement["NAME"]));
				$ES_IB_ELEMENT_UPDATE = "";
			}
		}
		return true;
	}

	// Catalog
	public static function  OnBeforePriceAdd(&$arFields)
	{
//        if($_GET["type"] == "catalog" && $_GET["mode"] == "import" && $_GET["filename"] != "")
//        {
//            //CModule::IncludeModule("energosoft.utils");
//            //$arElement = ESIBlock::GetByID($arFields["PRODUCT_ID"]);
//            if($arElement["IBLOCK_ID"] == 58 && $arFields["CATALOG_GROUP_ID"] == 1)
//            {
//                //CIBlockElement::SetPropertyValueCode($arElement["ID"], "ES_1C_PRICE", $arFields["PRICE"]);
//            }
//        }
//        $r = "";
//        $r .= print_r($_GET,true);
//        $r .= print_r($_POST,true);
//        $r .= print_r($arFields,true);
//        $r .= "\n\n";
//        file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/es/OnBeforePriceAdd", $r, FILE_APPEND | LOCK_EX);
		return true;
	}

	public static function  OnBeforePriceUpdate($ID, &$arFields)
	{
//        if($_GET["type"] == "catalog" && $_GET["mode"] == "import" && $_GET["filename"] != "")
//        {
//            //CModule::IncludeModule("energosoft.utils");
//            //$arElement = ESIBlock::GetByID($arFields["PRODUCT_ID"]);
//            if($arElement["IBLOCK_ID"] == 58 && $arFields["CATALOG_GROUP_ID"] == 1)
//            {
//                //CIBlockElement::SetPropertyValueCode($arElement["ID"], "ES_1C_PRICE", $arFields["PRICE"]);
//            }
//        }
//        $r = "";
//        $r .= print_r($ID,true);
//        $r .= print_r($_GET,true);
//        $r .= print_r($_POST,true);
//        $r .= print_r($arFields,true);
//        $r .= "\n\n";
//        file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/es/OnBeforePriceUpdate", $r, FILE_APPEND | LOCK_EX);
		return true;
	}

	public static function  OnBeforeProductAdd(&$arFields)
	{
//        if($_GET["type"] == "catalog" && $_GET["mode"] == "import" && $_GET["filename"] != "")
//        {
//            if(isset($arFields["QUANTITY"]))
//            {
//                //CModule::IncludeModule("energosoft.utils");
//                //$arElement = ESIBlock::GetByID($arFields["ID"]);
//                if($arElement["IBLOCK_ID"] == 58)
//                {
//                    //CIBlockElement::SetPropertyValueCode($arElement["ID"], "ES_1C_QUANTITY", $arFields["QUANTITY"]);
//                }
//            }
//        }
//        $r = "";
//        $r .= print_r($_GET,true);
//        $r .= print_r($_POST,true);
//        $r .= print_r($arFields,true);
//        $r .= "\n\n";
//        file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/es/OnBeforeProductAdd", $r, FILE_APPEND | LOCK_EX);
		return true;
	}

	public static function  OnBeforeProductUpdate($ID, &$arFields)
	{
//        if($_GET["type"] == "catalog" && $_GET["mode"] == "import" && $_GET["filename"] != "")
//        {
//            if(isset($arFields["QUANTITY"]))
//            {
//                //CModule::IncludeModule("energosoft.utils");
//                //$arElement = ESIBlock::GetByID($ID);
//                if($arElement["IBLOCK_ID"] == 58)
//                {
//                    //CIBlockElement::SetPropertyValueCode($arElement["ID"], "ES_1C_QUANTITY", $arFields["QUANTITY"]);
//                }
//            }
//        }
//        $r = "";
//        $r .= print_r($ID,true);
//        $r .= print_r($_GET,true);
//        $r .= print_r($_POST,true);
//        $r .= print_r($arFields,true);
//        $r .= "\n\n";
//        file_put_contents($_SERVER["DOCUMENT_ROOT"]."/upload/es/OnBeforeProductUpdate", $r, FILE_APPEND | LOCK_EX);
		return true;
	}

	public static function  OnStoreProductAdd($lastId, $arFields)
	{
		GLOBAL $ES_IB_ELEMENT_UPDATE;
		if($ES_IB_ELEMENT_UPDATE == "Y") return true;

		CModule::IncludeModule("iblock");
		CModule::IncludeModule("catalog");
		CModule::IncludeModule("energosoft.utils");

		if($_GET["type"] == "catalog" && $_GET["mode"] == "import" && $_GET["filename"] != "")
		{
			if(intval($arFields["PRODUCT_ID"]) > 0 && intval($arFields["STORE_ID"]) == 3)
			{
				$arElement = ESIBlock::GetByID($arFields["PRODUCT_ID"]);
				if($arElement["IBLOCK_ID"] == 35)
				{
					$ES_IB_ELEMENT_UPDATE = "Y";

					$arFilter = array();
					if($arElement["PROPERTIES"]["ES_LINK"]["VALUE"] == "") $arFilter["NAME"] = $arElement["NAME"];
					else $arFilter["XML_ID"] = $arElement["PROPERTIES"]["ES_LINK"]["VALUE"];

					$arFilter["IBLOCK_ID"] = 32;
					$obElement = CIBlockElement::GetList(array(), $arFilter, false, false, array('ID','XML_ID'));
					if($arItem = $obElement->Fetch())
					{
						if($arElement["PROPERTIES"]["ES_LINK"]["VALUE"] == "") CIBlockElement::SetPropertyValueCode($arElement["ID"], "ES_LINK", $arItem["XML_ID"]);
						$arProdFields = Array(
							"PRODUCT_ID" => $arItem['ID'],
							"STORE_ID" => 6,
							"AMOUNT" => $arFields["AMOUNT"],
						);
						CCatalogStoreProduct::UpdateFromForm($arProdFields);
					}
					else
					{
						$arFilter["IBLOCK_ID"] = 33;
						$obElement = CIBlockElement::GetList(array(), $arFilter, false, false, array('ID','XML_ID'));
						if($arItem = $obElement->Fetch())
						{
							if($arElement["PROPERTIES"]["ES_LINK"]["VALUE"] == "") CIBlockElement::SetPropertyValueCode($arElement["ID"], "ES_LINK", $arItem["XML_ID"]);
							$arProdFields = Array(
								"PRODUCT_ID" => $arItem['ID'],
								"STORE_ID" => 6,
								"AMOUNT" => $arFields["AMOUNT"],
							);
							CCatalogStoreProduct::UpdateFromForm($arProdFields);
						}
						else
						{
							unset($arFilter["NAME"]);
							unset($arFilter["XML_ID"]);
							$arFilter["PROPERTY_ES_NAME_SEARCH"] = $arElement["NAME"];
							$obElement = CIBlockElement::GetList(array(), $arFilter, false, false, array('ID','XML_ID'));
							if($arItem = $obElement->Fetch())
							{
								if($arElement["PROPERTIES"]["ES_LINK"]["VALUE"] == "") CIBlockElement::SetPropertyValueCode($arElement["ID"], "ES_LINK", $arItem["XML_ID"]);
								$arProdFields = Array(
									"PRODUCT_ID" => $arItem['ID'],
									"STORE_ID" => 6,
									"AMOUNT" => $arFields["AMOUNT"],
								);
								CCatalogStoreProduct::UpdateFromForm($arProdFields);
							}
						}
					}

					$ES_IB_ELEMENT_UPDATE = "";
				}
			}
		}
		if(intval($arFields["PRODUCT_ID"]) > 0 && (intval($arFields["STORE_ID"]) == 5 || intval($arFields["STORE_ID"]) == 6))
		{
			$arStore = array();
			$rsStore = CCatalogStoreProduct::GetList(array(), array("STORE_ID"=>array(5,6),"PRODUCT_ID"=>$arFields["PRODUCT_ID"]), false, false, array('PRODUCT_ID', 'STORE_ID', 'AMOUNT'));
			while($arItem = $rsStore->Fetch()) $arStore[$arItem["STORE_ID"]] = $arItem["AMOUNT"];

			$ES_IB_ELEMENT_UPDATE = "Y";
			$arProdFields = array(
				"ID" => $arFields["PRODUCT_ID"],
				"VAT_INCLUDED" => "Y",
				"QUANTITY" => intval($arStore[5]) + intval($arStore[6]),
			);
			CCatalogProduct::Add($arProdFields);
			ESUtils::SaveOption("calc", array("RUN"=>"START"));
			$ES_IB_ELEMENT_UPDATE = "";
		}
		return true;
	}

	public static function  OnStoreProductUpdate($id, $arFields)
	{
		GLOBAL $ES_IB_ELEMENT_UPDATE;
		if($ES_IB_ELEMENT_UPDATE == "Y") return true;

		CModule::IncludeModule("iblock");
		CModule::IncludeModule("catalog");
		CModule::IncludeModule("energosoft.utils");

		if($_GET["type"] == "catalog" && $_GET["mode"] == "import" && $_GET["filename"] != "")
		{
			if(intval($arFields["PRODUCT_ID"]) > 0 && intval($arFields["STORE_ID"]) == 3)
			{
				$arElement = ESIBlock::GetByID($arFields["PRODUCT_ID"]);
				if($arElement["IBLOCK_ID"] == 35)
				{
					$ES_IB_ELEMENT_UPDATE = "Y";

					$arFilter = array();
					if($arElement["PROPERTIES"]["ES_LINK"]["VALUE"] == "") $arFilter["NAME"] = $arElement["NAME"];
					else $arFilter["XML_ID"] = $arElement["PROPERTIES"]["ES_LINK"]["VALUE"];

					$arFilter["IBLOCK_ID"] = 32;
					$obElement = CIBlockElement::GetList(array(), $arFilter, false, false, array('ID','XML_ID'));
					if($arItem = $obElement->Fetch())
					{
						if($arElement["PROPERTIES"]["ES_LINK"]["VALUE"] == "") CIBlockElement::SetPropertyValueCode($arElement["ID"], "ES_LINK", $arItem["XML_ID"]);
						$arProdFields = Array(
							"PRODUCT_ID" => $arItem['ID'],
							"STORE_ID" => 6,
							"AMOUNT" => $arFields["AMOUNT"],
						);
						CCatalogStoreProduct::UpdateFromForm($arProdFields);
					}
					else
					{
						$arFilter["IBLOCK_ID"] = 33;
						$obElement = CIBlockElement::GetList(array(), $arFilter, false, false, array('ID','XML_ID'));
						if($arItem = $obElement->Fetch())
						{
							if($arElement["PROPERTIES"]["ES_LINK"]["VALUE"] == "") CIBlockElement::SetPropertyValueCode($arElement["ID"], "ES_LINK", $arItem["XML_ID"]);
							$arProdFields = Array(
								"PRODUCT_ID" => $arItem['ID'],
								"STORE_ID" => 6,
								"AMOUNT" => $arFields["AMOUNT"],
							);
							CCatalogStoreProduct::UpdateFromForm($arProdFields);
						}
						else
						{
							unset($arFilter["NAME"]);
							unset($arFilter["XML_ID"]);
							$arFilter["PROPERTY_ES_NAME_SEARCH"] = $arElement["NAME"];
							$obElement = CIBlockElement::GetList(array(), $arFilter, false, false, array('ID','XML_ID'));
							if($arItem = $obElement->Fetch())
							{
								if($arElement["PROPERTIES"]["ES_LINK"]["VALUE"] == "") CIBlockElement::SetPropertyValueCode($arElement["ID"], "ES_LINK", $arItem["XML_ID"]);
								$arProdFields = Array(
									"PRODUCT_ID" => $arItem['ID'],
									"STORE_ID" => 6,
									"AMOUNT" => $arFields["AMOUNT"],
								);
								CCatalogStoreProduct::UpdateFromForm($arProdFields);
							}
						}
					}

					$ES_IB_ELEMENT_UPDATE = "";
				}
			}
		}
		if(intval($arFields["PRODUCT_ID"]) > 0 && (intval($arFields["STORE_ID"]) == 5 || intval($arFields["STORE_ID"]) == 6))
		{
			$arStore = array();
			$rsStore = CCatalogStoreProduct::GetList(array(), array("STORE_ID"=>array(5,6),"PRODUCT_ID"=>$arFields["PRODUCT_ID"]), false, false, array('PRODUCT_ID', 'STORE_ID', 'AMOUNT'));
			while($arItem = $rsStore->Fetch()) $arStore[$arItem["STORE_ID"]] = $arItem["AMOUNT"];

			$ES_IB_ELEMENT_UPDATE = "Y";
			$arProdFields = array(
				"ID" => $arFields["PRODUCT_ID"],
				"VAT_INCLUDED" => "Y",
				"QUANTITY" => intval($arStore[5]) + intval($arStore[6]),
			);
			CCatalogProduct::Add($arProdFields);
			ESUtils::SaveOption("calc", array("RUN"=>"START"));
			$ES_IB_ELEMENT_UPDATE = "";
		}
		return true;
	}
}
?>
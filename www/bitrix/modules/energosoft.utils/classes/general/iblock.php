<?
class ESIBlock
{
	public static function GetByID($ID)
	{
		if(!CModule::IncludeModule("iblock")) return;
		$obElement = CIBlockElement::GetByID($ID);
		$arItem = $obElement->GetNext();
		$arItem["PREVIEW_PICTURE"] = CFile::GetFileArray($arItem["PREVIEW_PICTURE"]);
		$arItem["DETAIL_PICTURE"] = CFile::GetFileArray($arItem["DETAIL_PICTURE"]);

		$arItem["PROPERTIES"] = array();
		$rsProperties = CIBlockElement::GetProperty($arItem["IBLOCK_ID"], $arItem["ID"]);
		while($p=$rsProperties->Fetch())
		{
			if($p["CODE"] != "")
			{
				$arItem["PROPERTIES"][$p["CODE"]] = CIBlockFormatProperties::GetDisplayValue($arItem, $p, "catalog_out");
				if(preg_match("/<(.+)>(.+)<\/a>/i", $arItem["PROPERTIES"][$p["CODE"]]["DISPLAY_VALUE"], $arValue) == 1) $arItem["PROPERTIES"][$p["CODE"]]["DISPLAY_VALUE"] = $arValue[2];
				if($p["MULTIPLE"] == "Y")
				{
					$arValues = array();
					$rsMultiple = CIBlockElement::GetProperty($arItem["IBLOCK_ID"], $arItem["ID"], "sort", "asc", array("CODE"=>$p["CODE"]));
					while($pp = $rsMultiple->GetNext()) $arValues[] = $pp["VALUE"];
					$arItem["PROPERTIES"][$p["CODE"]]["VALUES"] = $arValues;
				}
			}
		}
		return $arItem;
	}

	public static function GetProperties($iblock = 0, $arSelectExt = false, $arFilterExt = false, $arSortExt = false, $groupBy = false)
	{
		$arResult = array();
		if(CModule::IncludeModule("iblock") && intval($iblock) > 0)
		{
			if($arSelectExt == false) $arSelectExt = array();
			if($arFilterExt == false) $arFilterExt = array();
			if($arSortExt == false) $arSortExt = array();
			$arSelect = array("ID", "NAME", "CODE");
			$arSelect = array_merge($arSelect, $arSelectExt);
			$arSort = array("SORT"=>"ASC");
			if(count($arSortExt) > 0) $arSort = $arSortExt;
			$arFilter = array("IBLOCK_ID"=>$iblock);
			$arFilter = array_merge($arFilter, $arFilterExt);
			$cache = new CPHPCache();
			$cache_time = 360000;
			$cache_id = __FUNCTION__.":".serialize(array_merge($arSelect, $arSort, $arFilter)).":".$groupBy;
			if($cache->InitCache($cache_time, $cache_id, "/"))
			{
				$res = $cache->GetVars();
				if(is_array($res) && count($res) > 0) $arResult = $res;
			}
			$obiBlock = CIBlock::GetByID($iblock);
			if($ariBlock = $obiBlock->GetNext())
			{
				$lastUpdate = ESUtils::Load("ES_IBLOCK_LASTUPDATE_".$iblock);
				if(count($arResult) > 0 && $lastUpdate != $ariBlock["TIMESTAMP_X"]) $arResult = array();
			}
			if(count($arResult) == 0)
			{
				ESUtils::Save("ES_IBLOCK_LASTUPDATE_".$iblock, $ariBlock["TIMESTAMP_X"]);
				$rsProperties = CIBlockProperty::GetList($arSort, $arFilter);
				while($arProperty = $rsProperties->GetNext())
				{
					{
						$arData = array();
						foreach($arSelect as $arField) $arData[$arField] = $arProperty[$arField];
						if($groupBy) $arResult[$arProperty[$groupBy]] = $arData;
						else $arResult[] = $arData;
					}
				}
				$cache->StartDataCache();
				$cache->EndDataCache($arResult);
			}
		}
		return $arResult;
	}

	public static function GetPropertyEnum($iblock = 0, $arSelectExt = false, $arFilterExt = false, $arSortExt = false, $groupByGroup = false, $groupByElement = false, $useCache = true)
	{
		$arResult = array();
		if(CModule::IncludeModule("iblock") && intval($iblock) > 0)
		{
			if($arSelectExt == false) $arSelectExt = array();
			if($arFilterExt == false) $arFilterExt = array();
			if($arSortExt == false) $arSortExt = array();
			$arSelect = array("ID", "XML_ID", "VALUE", "PROPERTY_ID", "PROPERTY_NAME", "PROPERTY_CODE");
			$arSelect = array_merge($arSelect, $arSelectExt);
			$arSort = array("SORT"=>"ASC", "PROPERTY_SORT"=>"ASC");
			if(count($arSortExt) > 0) $arSort = $arSortExt;
			$arFilter = array("IBLOCK_ID"=>$iblock);
			$arFilter = array_merge($arFilter, $arFilterExt);
			$cache = new CPHPCache();
			$cache_time = 360000;
			$cache_id = __FUNCTION__.":".serialize(array_merge($arSelect, $arSort, $arFilter)).":".$groupByGroup.":".$groupByElement;
			if($cache->InitCache($cache_time, $cache_id, "/"))
			{
				$res = $cache->GetVars();
				if(is_array($res) && count($res) > 0) $arResult = $res;
			}
			$obiBlock = CIBlock::GetByID($iblock);
			if($ariBlock = $obiBlock->GetNext())
			{
				$lastUpdate = ESUtils::Load("ES_IBLOCK_LASTUPDATE_".$iblock);
				if(count($arResult) > 0 && $lastUpdate != $ariBlock["TIMESTAMP_X"]) $arResult = array();
			}
			if(!$useCache) $arResult = array();
			if(count($arResult) == 0)
			{
				ESUtils::Save("ES_IBLOCK_LASTUPDATE_".$iblock, $ariBlock["TIMESTAMP_X"]);
				$rsProperties = CIBlockPropertyEnum::GetList($arSort, $arFilter);
				while($arProperty = $rsProperties->GetNext())
				{
					$arData = array();
					foreach($arSelect as $arField) $arData[$arField] = $arProperty[$arField];
					if($groupByGroup)
					{
						if($groupByElement) $arResult[$arProperty[$groupByGroup]][$arData[$groupByElement]] = $arData;
						else $arResult[$arProperty[$groupByGroup]][] = $arData;
					}
					else $arResult[] = $arData;
				}
				$cache->StartDataCache();
				$cache->EndDataCache($arResult);
			}
		}
		return $arResult;
	}

	public static function GetSectionList($iblock = 0, $arSelectExt = false, $arFilterExt = false, $arSortExt = false, $groupBy = false, $incCount = false)
	{
		$arResult = array();
		if(CModule::IncludeModule("iblock") && intval($iblock) > 0)
		{
			if($arSelectExt == false) $arSelectExt = array();
			if($arFilterExt == false) $arFilterExt = array();
			if($arSortExt == false) $arSortExt = array();
			$arSelect = array("ID");
			$arSelect = array_merge($arSelect, $arSelectExt);
			$arSort = array("LEFT_MARGIN"=>"ASC", "NAME"=>"ASC");
			if(count($arSortExt) > 0) $arSort = $arSortExt;
			$arFilter = array("IBLOCK_ID"=>$iblock, "ACTIVE"=>"Y");
			$arFilter = array_merge($arFilter, $arFilterExt);
			$cache = new CPHPCache();
			$cache_time = 360000;
			$cache_id = __FUNCTION__.":".serialize(array_merge($arSelect, $arSort, $arFilter)).":".$groupBy;
			if($cache->InitCache($cache_time, $cache_id, "/"))
			{
				$res = $cache->GetVars();
				if(is_array($res) && count($res) > 0) $arResult = $res;
			}
			$rsSections = CIBlockSection::GetList(array("TIMESTAMP_X"=>"DESC"), array("IBLOCK_ID"=>$iblock, "ACTIVE"=>"Y"), false, array("TIMESTAMP_X"), false);
			if($arSection = $rsSections->GetNext())
			{
				$lastUpdate = ESUtils::Load("ES_SECTION_LASTUPDATE_".$iblock);
				if(count($arResult) > 0 && $lastUpdate != $arSection["TIMESTAMP_X"]) $arResult = array();
			}
			if($arFilter["ACTIVE"] == "ALL")
			{
				unset($arFilter["ACTIVE"]);
				$arResult = array();
			}
			if($arFilter["ACTIVE"] == "YC")
			{
				$arFilter["ACTIVE"] = "Y";
				$arResult = array();
			}
			if(count($arResult) == 0)
			{
				ESUtils::Save("ES_SECTION_LASTUPDATE_".$iblock, $arSection["TIMESTAMP_X"]);
				$rsSections = CIBlockSection::GetList($arSort, $arFilter, $incCount, $arSelect, false);
				while($arSection = $rsSections->GetNext())
				{
					$arData = array();
					foreach($arSelect as $arField) $arData[$arField] = $arSection[$arField];
					foreach($arSection as $k=>$arField) if(substr($k, 0, 3) == "UF_") $arData[$k] = $arSection[$k];
					if($groupBy) $arResult[$arSection[$groupBy]][] = $arData;
					else $arResult[] = $arData;
				}
				$cache->StartDataCache();
				$cache->EndDataCache($arResult);
			}
		}
		return $arResult;
	}

	public static function GetSectionInfo()
	{
		GLOBAL $APPLICATION;
		$arSect = explode("/", $APPLICATION->GetCurDir());
		$arData = array();
		foreach($arSect as $v)
		{
			if($v != "")
			{
				$v = htmlspecialchars($v);
				$v = ToLower($v);
				$arData["LAST"] = $v;
				$arData[] = $v;
			}
		}
		return $arData;
	}

	public static function GetSectionPath($iblock, $sp = "")
	{
		$arSections = ESIBlock::GetSectionList($iblock, array("NAME", "CODE", "IBLOCK_SECTION_ID"), false, false, "IBLOCK_SECTION_ID");
		$arSectionCode = explode("/", htmlspecialchars($_REQUEST["SECTION_CODE"]));
		if($sp != "") $arSectionCode = explode("/", $sp);
		TrimArr($arSectionCode);

		$sid = false;
		foreach($arSectionCode as $k=>$code)
		{
			if($k == 0)
			{
				foreach($arSections[""] as $arSect)
				{
					if($arSect["CODE"] == $code)
					{
						$arSectionCode[$k] = $arSect;
						$sid = $arSect["ID"];
						$arSectionCode["SECTION_ID"] = $sid;
						break;
					}
				}
			}
			else
			{
				if($sid)
				{
					foreach($arSections[$sid] as $arSect)
					{
						if($arSect["CODE"] == $code)
						{
							$arSectionCode[$k] = $arSect;
							$sid = $arSect["ID"];
							$arSectionCode["SECTION_ID"] = $sid;
							break;
						}
					}
				}
			}
		}
		return $arSectionCode;
	}

	public static function GetElementProperty($iblock = 0, $id = 0, $arPropereties = false)
	{
		$arResult = array();
		$iblock = intval($iblock);
		$id = intval($id);
		if($arPropereties == false) $arPropereties = array();
		if(CModule::IncludeModule("iblock") && $iblock > 0 && $id > 0)
		{
			$arItem["PROPERTIES"] = array();
			if(count($arPropereties) > 0)
			{
				$arPropertiesFilter = array();
				foreach($arPropereties as $arProp) $arPropertiesFilter[] = array("CODE" => $arProp);
				$rsProperties = CIBlockElement::GetProperty($iblock, $id, array("SORT"=>"ASC"), $arPropertiesFilter);
				while($p=$rsProperties->Fetch())
				{
					if(in_array($p["CODE"], $arPropereties))
					{
						$arItem["PROPERTIES"][$p["CODE"]] = CIBlockFormatProperties::GetDisplayValue($arItem, $p, "catalog_out");
						if(preg_match("/<(.+)>(.+)<\/a>/i", $arItem["PROPERTIES"][$p["CODE"]]["DISPLAY_VALUE"], $arValue) == 1) $arItem["PROPERTIES"][$p["CODE"]]["DISPLAY_VALUE"] = $arValue[2];
						if($p["MULTIPLE"] == "Y")
						{
							$arValues = array();
							$rsMultiple = CIBlockElement::GetProperty($iblock, $arItem["ID"], "sort", "asc", array("CODE"=>$p["CODE"]));
							while($pp = $rsMultiple->GetNext()) $arValues[] = $pp["VALUE"];
							$arItem["PROPERTIES"][$p["CODE"]]["VALUES"] = $arValues;
						}
						unset($arItem["PROPERTIES"][$p["CODE"]]["TIMESTAMP_X"]);
						unset($arItem["PROPERTIES"][$p["CODE"]]["IBLOCK_ID"]);
						unset($arItem["PROPERTIES"][$p["CODE"]]["ACTIVE"]);
						unset($arItem["PROPERTIES"][$p["CODE"]]["SORT"]);
						unset($arItem["PROPERTIES"][$p["CODE"]]["CODE"]);
						unset($arItem["PROPERTIES"][$p["CODE"]]["DEFAULT_VALUE"]);
						unset($arItem["PROPERTIES"][$p["CODE"]]["PROPERTY_TYPE"]);
						unset($arItem["PROPERTIES"][$p["CODE"]]["ROW_COUNT"]);
						unset($arItem["PROPERTIES"][$p["CODE"]]["COL_COUNT"]);
						unset($arItem["PROPERTIES"][$p["CODE"]]["LIST_TYPE"]);
						unset($arItem["PROPERTIES"][$p["CODE"]]["FILE_TYPE"]);
						unset($arItem["PROPERTIES"][$p["CODE"]]["TMP_ID"]);
						unset($arItem["PROPERTIES"][$p["CODE"]]["LINK_IBLOCK_ID"]);
						unset($arItem["PROPERTIES"][$p["CODE"]]["WITH_DESCRIPTION"]);
						unset($arItem["PROPERTIES"][$p["CODE"]]["MULTIPLE"]);
						unset($arItem["PROPERTIES"][$p["CODE"]]["SEARCHABLE"]);
						unset($arItem["PROPERTIES"][$p["CODE"]]["FILTRABLE"]);
						unset($arItem["PROPERTIES"][$p["CODE"]]["IS_REQUIRED"]);
						unset($arItem["PROPERTIES"][$p["CODE"]]["VERSION"]);
						unset($arItem["PROPERTIES"][$p["CODE"]]["MULTIPLE_CNT"]);
						unset($arItem["PROPERTIES"][$p["CODE"]]["USER_TYPE"]);
						unset($arItem["PROPERTIES"][$p["CODE"]]["USER_TYPE_SETTINGS"]);
						unset($arItem["PROPERTIES"][$p["CODE"]]["HINT"]);
						unset($arItem["PROPERTIES"][$p["CODE"]]["VALUE_SORT"]);
					}
				}
			}
			$arResult = $arItem["PROPERTIES"];
		}
		return $arResult;
	}

	public static function GetList($iblock = 0, $arSelectExt = false, $arPropereties = false, $arFilterExt = false, $arSortExt = false, $groupBy = false)
	{
		$arResult = array();
		if(CModule::IncludeModule("iblock") && intval($iblock) > 0)
		{
			if($arSelectExt == false) $arSelectExt = array();
			if($arPropereties == false) $arPropereties = array();
			if($arFilterExt == false) $arFilterExt = array();
			if($arSortExt == false) $arSortExt = array();
			$arSelect = array("ID", "CODE", "NAME", "IBLOCK_SECTION_ID");
			$arSelect = array_merge($arSelect, $arSelectExt);
			$arSort = array("NAME"=>"ASC");
			if(count($arSortExt) > 0) $arSort = $arSortExt;
			$arFilter = array("IBLOCK_ID"=>$iblock, "ACTIVE"=>"Y");
			$arFilter = array_merge($arFilter, $arFilterExt);
			$useCache = true;
			if($arFilter["ACTIVE"] == "ALL")
			{
				unset($arFilter["ACTIVE"]);
				$useCache = false;
			}
			if($arFilter["ACTIVE"] == "YC")
			{
				$arFilter["ACTIVE"] = "Y";
				$useCache = false;
			}
			if($useCache)
			{
				$cache = new CPHPCache();
				$cache_time = 360000;
				$cache_id = __FUNCTION__.":".serialize(array_merge($arSelect, $arSort, $arPropereties, $arFilter)).":".$groupBy;
				if($cache->InitCache($cache_time, md5($cache_id), "/"))
				{
					$res = $cache->GetVars();
					if(is_array($res) && count($res) > 0) $arResult = $res;
				}
				$rsElements = CIBlockElement::GetList(array("DATE_CREATE"=>"DESC","TIMESTAMP_X"=>"DESC"), array("IBLOCK_ID"=>$iblock), false, array("nTopCount"=>1), array("DATE_CREATE","TIMESTAMP_X"));
				if($arItem = $rsElements->GetNext())
				{
					$lastUpdate = ESUtils::Load("ES_ELEMENT_LASTUPDATE_".$iblock);
					$lastUpdates = $arItem["DATE_CREATE"].$arItem["TIMESTAMP_X"];
					if($lastUpdate != $lastUpdates)
					{
						$arResult = array();
						$cache->CleanDir();
					}
				}
			}
			if(count($arResult) == 0)
			{
				if($useCache) ESUtils::Save("ES_ELEMENT_LASTUPDATE_".$iblock, $arItem["DATE_CREATE"].$arItem["TIMESTAMP_X"]);
				$rsElements = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);
				while($arItem = $rsElements->GetNext())
				{
					if(count($arPropereties) > 0)
					{
						$arItem["PROPERTIES"] = array();
						$arPropertiesFilter = array();
						foreach($arPropereties as $arProp) $arPropertiesFilter[] = array("CODE" => $arProp);
						$rsProperties = CIBlockElement::GetProperty($iblock, $arItem["ID"], array("SORT"=>"ASC"), $arPropertiesFilter);
						while($p=$rsProperties->Fetch())
						{
							if(in_array($p["CODE"], $arPropereties))
							{
								$arItem["PROPERTIES"][$p["CODE"]] = CIBlockFormatProperties::GetDisplayValue($arItem, $p, "catalog_out");
								if(preg_match("/<(.+)>(.+)<\/a>/i", $arItem["PROPERTIES"][$p["CODE"]]["DISPLAY_VALUE"], $arValue) == 1) $arItem["PROPERTIES"][$p["CODE"]]["DISPLAY_VALUE"] = $arValue[2];
								if($p["MULTIPLE"] == "Y")
								{
									$arValues = array();
									$rsMultiple = CIBlockElement::GetProperty($iblock, $arItem["ID"], "sort", "asc", array("CODE"=>$p["CODE"]));
									while($pp = $rsMultiple->GetNext()) $arValues[] = $pp["VALUE"];
									$arItem["PROPERTIES"][$p["CODE"]]["VALUES"] = $arValues;
								}
								unset($arItem["PROPERTIES"][$p["CODE"]]["TIMESTAMP_X"]);
								unset($arItem["PROPERTIES"][$p["CODE"]]["IBLOCK_ID"]);
								unset($arItem["PROPERTIES"][$p["CODE"]]["ACTIVE"]);
								unset($arItem["PROPERTIES"][$p["CODE"]]["SORT"]);
								unset($arItem["PROPERTIES"][$p["CODE"]]["CODE"]);
								unset($arItem["PROPERTIES"][$p["CODE"]]["DEFAULT_VALUE"]);
								unset($arItem["PROPERTIES"][$p["CODE"]]["PROPERTY_TYPE"]);
								unset($arItem["PROPERTIES"][$p["CODE"]]["ROW_COUNT"]);
								unset($arItem["PROPERTIES"][$p["CODE"]]["COL_COUNT"]);
								unset($arItem["PROPERTIES"][$p["CODE"]]["LIST_TYPE"]);
								unset($arItem["PROPERTIES"][$p["CODE"]]["FILE_TYPE"]);
								unset($arItem["PROPERTIES"][$p["CODE"]]["TMP_ID"]);
								unset($arItem["PROPERTIES"][$p["CODE"]]["LINK_IBLOCK_ID"]);
								unset($arItem["PROPERTIES"][$p["CODE"]]["WITH_DESCRIPTION"]);
								unset($arItem["PROPERTIES"][$p["CODE"]]["MULTIPLE"]);
								unset($arItem["PROPERTIES"][$p["CODE"]]["SEARCHABLE"]);
								unset($arItem["PROPERTIES"][$p["CODE"]]["FILTRABLE"]);
								unset($arItem["PROPERTIES"][$p["CODE"]]["IS_REQUIRED"]);
								unset($arItem["PROPERTIES"][$p["CODE"]]["VERSION"]);
								unset($arItem["PROPERTIES"][$p["CODE"]]["MULTIPLE_CNT"]);
								unset($arItem["PROPERTIES"][$p["CODE"]]["USER_TYPE"]);
								unset($arItem["PROPERTIES"][$p["CODE"]]["USER_TYPE_SETTINGS"]);
								unset($arItem["PROPERTIES"][$p["CODE"]]["HINT"]);
								unset($arItem["PROPERTIES"][$p["CODE"]]["VALUE_SORT"]);
							}
						}
					}

					$arItem["PREVIEW_PICTURE"] = CFile::GetFileArray($arItem["PREVIEW_PICTURE"]);
					$arItem["DETAIL_PICTURE"] = CFile::GetFileArray($arItem["DETAIL_PICTURE"]);

					$arData = array();
					foreach($arSelect as $arField) $arData[$arField] = $arItem[$arField];
					if(isset($arItem["PROPERTIES"])) $arData["PROPERTIES"] = $arItem["PROPERTIES"];
					if($groupBy) $arResult[$arData[$groupBy]] = $arData;
					else $arResult[] = $arData;

				}
				if($useCache)
				{
					$cache->StartDataCache();
					$cache->EndDataCache($arResult);
				}
			}
		}
		return $arResult;
	}

	public static function GetListCount($iblock, $arFilterExt = array())
	{
		CModule::IncludeModule("iblock");
		$arSelect = array("ID");
		$arSort = array("ID"=>"ASC");
		$arFilter = array("IBLOCK_ID" => $iblock);
		$arFilter = array_merge($arFilter, $arFilterExt);
		$rsElements = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);
		return intval($rsElements->SelectedRowsCount());
	}
}
?>
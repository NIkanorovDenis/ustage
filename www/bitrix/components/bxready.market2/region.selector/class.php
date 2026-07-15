<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class MarketRegionSelector extends CBitrixComponent
{
    public function getList($showAll = false)
    {
        $arList = array();
        $idBlock = $this->arParams["IBLOCK_ID"];

        if (intval($this->arParams["COUNT_CITY"]) >= 0 )
            $countElements = $this->arParams["COUNT_CITY"];
        else
            $countElements = 8;

        $arSelect = Array("ID", "NAME", "CODE", "PROPERTY_BXR_DOMAIN");

        $arFilter = Array(
            "IBLOCK_ID" => $idBlock,
            "ACTIVE" => "Y",
        );
        
        if(isset($this->arParams["CONSIDER_SHOW_FORM"]) && $this->arParams["CONSIDER_SHOW_FORM"]=="Y" && !$showAll)
            $arFilter["PROPERTY_BXR_SHOW_FORM_VALUE"] = "Y";
            

        $arOrder = Array(
            "SORT" => "ASC",
        );

		if($showAll)
			$query = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);
		else
			$query = CIBlockElement::GetList($arOrder, $arFilter, false, array("nPageSize" => $countElements), $arSelect);

        while ($resultQuery = $query->GetNextElement()) {
            $resultFields = $resultQuery->GetFields();
            
            if(isset($this->arParams["USE_DOMAIN"]) && $this->arParams["USE_DOMAIN"]=="Y" && isset($resultFields["PROPERTY_BXR_DOMAIN_VALUE"]) && !empty($resultFields["PROPERTY_BXR_DOMAIN_VALUE"]) ) {
                if(is_array($resultFields["PROPERTY_BXR_DOMAIN_VALUE"]))
                    $resultFields['LINK'] = "//".array_shift($resultFields["PROPERTY_BXR_DOMAIN_VALUE"]);
                else
                    $resultFields['LINK'] = "//".$resultFields["PROPERTY_BXR_DOMAIN_VALUE"];
                
                $resultFields['LINK'] .= $this->arParams["CURRENT_PAGE"] . '?set_region=Y&amp;region=' . $resultFields["CODE"];
                
            }
            
            if(empty($resultFields['LINK'])) {
                if(isset($this->arParams["USE_DOMAIN"]) && $this->arParams["USE_DOMAIN"]=="Y") {
                    /*$marketRegistry = \Alexkova\Market2\Bxmarket::getInstance();
                    $arResult['REGION_INFO'] = $marketRegistry->getRegionData();
                    
                    $default_region_domain = "";
                    if(isset($arResult['REGION_INFO']["default_region"]["PROPERTY_BXR_DOMAIN_VALUE"]) && is_array($arResult['REGION_INFO']["default_region"]["PROPERTY_BXR_DOMAIN_VALUE"]))
                        $default_region_domain = array_shift($arResult['REGION_INFO']["default_region"]["PROPERTY_BXR_DOMAIN_VALUE"]);
                    elseif(isset($arResult['REGION_INFO']["default_region"]["PROPERTY_BXR_DOMAIN_VALUE"]))
                        $default_region_domain = $arResult['REGION_INFO']["default_region"]["PROPERTY_BXR_DOMAIN_VALUE"];
                                            
                    $resultFields['LINK'] = "//" . $default_region_domain . '?set_region=Y&amp;region=' . $resultFields["CODE"];
                    
                    if(empty($resultFields['LINK']))*/
                        
                    $resultFields['LINK'] = "#";
                }
                else
                    $resultFields['LINK'] = $this->arParams["CURRENT_PAGE"] . '?set_region=Y&amp;region=' . $resultFields["CODE"];
            }
                
            
            $arList[] = $resultFields;
        }

        return $arList;
    }

}
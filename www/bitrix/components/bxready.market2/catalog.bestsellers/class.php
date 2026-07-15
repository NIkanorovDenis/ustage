<?
namespace Alexkova\Market2;
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

class CatalogBestsellersComponent extends \CBitrixComponent{

    private $loadMode = array(
        'lazy', 'single', 'standart'
    );

    public function getPage() {
        $this->arResult['PAGE'] = 'standart';

        if (isset($this->arParams['LOAD_MODE'])
            && in_array($this->arParams['LOAD_MODE'], $this->loadMode)
        ) {
            $this->arResult['PAGE'] = $this->arParams['LOAD_MODE'];
        }
    }

	public function getBestsellers($BID)
	{
		if(is_array($BID) && isset($BID["ID"])) {
			$BID = $BID["ID"];
		}

	    $result = array();
        $this->arResult['PARENT'] = $BID;
        $arSelect = array("ID", "NAME", "PROPERTY_ITEMS");
        $arFilter = array(
            "ACTIVE" => "Y",
            "ID" => $BID,
            "IBLOCK_ID" => $this->arParams["BESTSELLER_IBLOCK_ID"]
        );

        if(isset($this->arParams["REGION_CONTENT"]) && !empty($this->arParams["REGION_CONTENT"]))
            $arFilter["PROPERTY_BXR_REGION"] = array($this->arParams["REGION_CONTENT"], false);

        $res = \CIblockElement::GetList(array("SORT"=>"ASC"), $arFilter, false, false, $arSelect);
        if ($arFields = $res->Fetch()) {
            if (is_array($arFields["PROPERTY_ITEMS_VALUE"]) && count($arFields["PROPERTY_ITEMS_VALUE"])>0)
                $result = $arFields["PROPERTY_ITEMS_VALUE"];
        }
		return $result;
	}

    public function getItems()
    {
        $result = array();
        $arSelect = array("ID", "NAME", "PROPERTY_ITEMS");
        $arFilter = array(
            "ACTIVE" => "Y",
            "IBLOCK_ID" => intval($this->arParams["BESTSELLER_IBLOCK_ID"]),
        );

        if(isset($this->arParams["REGION_CONTENT"]) && !empty($this->arParams["REGION_CONTENT"]))
            $arFilter["PROPERTY_BXR_REGION"] = array($this->arParams["REGION_CONTENT"], false);

        $res = \CIblockElement::GetList(array("SORT"=>"ASC"), $arFilter, false, false, $arSelect);
        while ($arFields = $res->Fetch()){
            if (is_array($arFields["PROPERTY_ITEMS_VALUE"]) && count($arFields["PROPERTY_ITEMS_VALUE"])>0)
                $result[] = $arFields;
        }
        return $result;
    }

}
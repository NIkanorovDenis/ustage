<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arResult = array();

$BID = intval($_REQUEST["ID"]) > 0 ? intval($_REQUEST["ID"]): 0;
$arParams["SHOW_ALL_WO_SECTION"] = "Y";

if (intval($arParams['IBLOCK_ID']) <= 0) return;

foreach($arParams as $cell=>$val){
    if (substr_count($cell, '_LISTPAGE')){
        $code = str_replace('_LISTPAGE', '', $cell);
        $arParams['BXR_PRESENT_SETTINGS'][$code] = $val;
    }
}

if (\Bitrix\Main\Loader::includeModule("iblock")
    && \Bitrix\Main\Loader::includeModule("alexkova.bxready2")
    && \Bitrix\Main\Loader::includeModule("alexkova.market2"))
{
    \Alexkova\Bxready2\Component::prepareParams($arParams, "bxready.market2:catalog.bestsellers");

    if ($USER->IsAuthorized()) {
        $arParams['USER_GROUPS'] = CUser::GetUserGroup($USER->GetID());
    } else {
        $arParams['USER_GROUPS'] = array();
    }
    
    if ($this->StartResultCache(intVal($arParams["CACHE_TIME"]), array("ID" => $BID, $arParams))) 
    {
        $this->getPage();
        if ($BID > 0) {
            $arResult["BESTSELLERS_ITEMS"] = $this->getBestsellers($BID);
        } else {
            $arResult["ITEMS"] = $this->getItems();
            if ($arResult['PAGE'] == 'standart' && count($arResult['ITEMS']) > 0) {
                $arResult["BESTSELLERS_ITEMS"] = $this->getBestsellers($arResult["ITEMS"][0]);;
            }
        }

        if (count($arResult["ITEMS"]) <= 0 && count($arResult["BESTSELLERS_ITEMS"]) <= 0) $this->AbortResultCache();

        //$CACHE_MANAGER->RegisterTag("iblock_id_".$arParams['IBLOCK_ID']);

        if ($BID == 0) $this->AbortResultCache();

        $this->IncludeComponentTemplate();
    }
}


?>
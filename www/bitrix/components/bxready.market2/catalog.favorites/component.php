<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arResult = array();

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
    \Alexkova\Bxready2\Component::prepareParams($arParams, "bxready.market2:catalog.favorites");

    if ($this->StartResultCache(intVal($arParams["CACHE_TIME"])))
    {
        if (!is_array($favorList) || empty($favorList))
            $favorList = Alexkova\Market2\Basket::favorItem();

        $arFavorList = explode("#", $favorList);
        $arFavorItems = array();
        if (is_array($arFavorList) && count($arFavorList) > 0) {
            foreach ($arFavorList as $favorId) {
                if (!!$favorId && intval($favorId) > 0 && !in_array($favorId, $arFavorItems))
                    $arFavorItems[] = $favorId;
            }
        }

        $arResult["FAVORITES_ITEMS"] = $arFavorItems;

        if (count($arResult["FAVORITES_ITEMS"]) <= 0) $this->AbortResultCache();

        $this->IncludeComponentTemplate();
    }
}


?>
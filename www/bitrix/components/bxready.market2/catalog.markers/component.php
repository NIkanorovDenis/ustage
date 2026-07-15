<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arResult = array();

if (isset($_REQUEST["ID"]) && strlen($_REQUEST["ID"]) > 0)
    $BID = htmlspecialchars($_REQUEST["ID"]);
$arParams["SHOW_ALL_WO_SECTION"] = "Y";
if (intval($arParams['IBLOCK_ID']) <= 0) return;

if (!isset($arParams['MOBILE_SETTINGS_USE_LAZY_LOAD'])) {
    $arParams['MOBILE_SETTINGS_USE_LAZY_LOAD'] = "Y";
}

$tempMarkers = array("ACTION", "NEW", "RECCOMEND", "HIT", "TEST");
foreach($tempMarkers as $cell){
    $arParams["TAB_".$cell."_SETTING"] = $arParams["TAB_".$cell."_SETTING"] == "N" ? "N" : "Y";
    $arParams["TAB_".$cell."_SORT"] = intval($arParams["TAB_".$cell."_SORT"]) > 0 ? intval($arParams["TAB_".$cell."_SORT"]) : 100+$i;
    $i++;
}

foreach($arParams as $cell => $val){
    if (substr_count($cell, '_LISTPAGE')){
        $code = str_replace('_LISTPAGE', '', $cell);
        $arParams['BXR_PRESENT_SETTINGS'][$code] = $val;
    }
}

if (\Bitrix\Main\Loader::includeModule("iblock")
    && \Bitrix\Main\Loader::includeModule("alexkova.bxready2")
    && \Bitrix\Main\Loader::includeModule("alexkova.market2"))
{
    \Alexkova\Bxready2\Component::prepareParams($arParams, "bxready.market2:catalog.markers");

    if ($USER->IsAuthorized()) {
        $arParams['USER_GROUPS'] = CUser::GetUserGroup($USER->GetID());
    } else {
        $arParams['USER_GROUPS'] = array(0);
    }

    if ($this->StartResultCache(intVal($arParams["CACHE_TIME"]), array("ID" => $BID, $arParams))) {
        $this->getPage();
        $arMarkers = array();

        foreach($tempMarkers as $cell){
                if ($arParams["TAB_".$cell."_SETTING"] == "Y")
                    $arMarkers[$arParams["TAB_".$cell."_SORT"]] = $cell;
        }
        ksort($arMarkers);

        $arResult["MARKERS_LIST"] = $arMarkers;

        if ($arResult['PAGE'] == 'standart') {
            reset($arResult["MARKERS_LIST"]);
            switch (current($arResult["MARKERS_LIST"])) {
                case 'RECCOMEND':
                    $arResult["PARENT"] = "RECOMMENDED";
                    break;
                case 'NEW':
                    $arResult["PARENT"] = "NEWPRODUCT";
                    break;
                case 'HIT':
                    $arResult["PARENT"] = "SALELEADER";
                    break;
                case 'ACTION':
                    $arResult["PARENT"] = "SPECIALOFFER";
                    break;
                case 'TEST':
                    $arResult["PARENT"] = "TEST_DRIVE";
                    break;
                default:
                    break;
            }
        }

        if (strlen($BID) > 0){
            $arResult["PARENT"] = $BID;
            $arParams['SINGLE_MODE'] == "Y";
        }

        if ($BID == 0 && !isset($arResult["PARENT"])) $this->AbortResultCache();

        $this->IncludeComponentTemplate();
    }
}



?>
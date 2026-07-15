<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
if(isset($arParams["USE_DOMAIN"]) && $arParams["USE_DOMAIN"]=="Y") {
    if(!empty($arResult["REGION_LIST_ALL"]) && is_array($arResult["REGION_LIST_ALL"])) {
        foreach($arResult["REGION_LIST_ALL"] as $k => $v){
            $arResult["REGION_LIST_ID_LINK"][$v['ID']] = $v['LINK'];
        }
    }
}
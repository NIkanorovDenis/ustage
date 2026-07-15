<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(isset($arParams["DATA_ATTR"]["select"]) && !empty($arParams["DATA_ATTR"]["select"])) {
    $arSelect = explode(";", $arParams["DATA_ATTR"]["select"]);
    foreach ($arSelect as $k => $v) {
        if(!empty($v)) {
            $ex = explode("=", $v);
            if(!empty($ex[0]) && !empty($ex[1]))
                $arParams["SELECT"][$ex[0]] = $ex[1];
        }
    }
}
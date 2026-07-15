<?
$APPLICATION->IncludeComponent(
    "bxready.market2:sort.panel", 
    ".default", 
    array(
        "COMPONENT_TEMPLATE" => ".default",
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
        "THEME" =>  $arParams["THEME"],
        "ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
        "ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
        "PAGE_ELEMENT_COUNT_SHOW" => $arParams["PAGE_ELEMENT_COUNT_SHOW"],
        "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
        "PAGE_ELEMENT_COUNT_LIST" => $arParams["PAGE_ELEMENT_COUNT_LIST"],
        "CATALOG_VIEW_SHOW" => $arParams["CATALOG_VIEW_SHOW"],
        "DEFAULT_CATALOG_VIEW" => $arParams["DEFAULT_CATALOG_VIEW"],
        "CATALOG_DEFAULT_SORT" => $arParams["CATALOG_DEFAULT_SORT"],
        "CATALOG_DEFAULT_SORT_ORDER" =>  isset($arParams['CATALOG_DEFAULT_SORT_ORDER']) ? $arParams['CATALOG_DEFAULT_SORT_ORDER'] : 'desc',
    ),
    false,
    array(
        "HIDE_ICONS" => "Y"
    )
);
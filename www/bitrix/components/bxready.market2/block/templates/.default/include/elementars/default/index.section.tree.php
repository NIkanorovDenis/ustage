<?
$APPLICATION->IncludeComponent(
    "bxready2:catalog.section.tree",
    $indexTemplate,
    Array(
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
        "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
        "CACHE_TIME" => $arParams["CACHE_TIME"],
        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
        "ADD_SECTIONS_CHAIN" => "N",
        "COUNT_ELEMENTS" => $arParams["INDEX_SHOW_COUNT"],
        "SECTION_FIELDS" => $sectionFields,
        "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
        "SECTION_USER_FIELDS" => array(),
        "SHOW_PARENT_NAME" => "Y",
        "TOP_DEPTH" => $arParams["INDEX_MAX_LEVEL"],
        "VIEW_MODE" => "LIST",
        "BXREADY_ELEMENT_DRAW" => $arParams["INDEX_ELEMENT_DRAW"],
        "DETAIL_PAGE_URL_CAPTION" => $arParams["DETAIL_PAGE_URL_CAPTION"],
        "REGION" => (isset($arParams["REGION"]) && !empty($arParams["REGION"])) ? $arParams["REGION"] : "",
    ),
    $component
);
?>
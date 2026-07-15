<?
$APPLICATION->IncludeComponent(
    "bxready.market2:main.include",
    "named_area",
    array(
        "COMPONENT_TEMPLATE" => "named_area",
        "INCLUDE_PTITLE" => GetMessage('SEO_TEXT_INDEX'),
        "AREA_FILE_SHOW" => "sect",
        "AREA_FILE_SUFFIX" => "bxr_index",
        "AREA_FILE_RECURSIVE" => "N",
        "EDIT_TEMPLATE" => ""
    ),
    $component
);
?>
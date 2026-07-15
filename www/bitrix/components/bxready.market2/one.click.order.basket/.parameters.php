<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
    "GROUPS" => array(
        "PARAMS" => array(
            "NAME" => GetMessage("KZNC_IBLOCK_PARAMS"),
            "SORT" => "200"
        ),
        "PERSONAL_DATA" => array(
            "NAME" => GetMessage("KZNC_IBLOCK_PERSONAL_DATA"),
            "SORT" => "400",
        ),
    ),

    "PARAMETERS" => array(
    ),
);

$arProperties = array(
    "USER_NAME" => GetMessage("BXR_FORM_NAME"),
    "USER_PHONE" => GetMessage("BXR_FORM_PHONE"),
    "USER_EMAIL" => GetMessage("BXR_FORM_EMAIL"),
    "USER_COMMENT" => GetMessage("BXR_FORM_COMMENT")
);

$arComponentParameters["PARAMETERS"]['BXR_FORM_REQUIRED_PROPS'] = array(
    "PARENT" => "PARAMS",
    "NAME" => GetMessage("BXR_FORM_REQUIRED_PROPS"),
    "TYPE" => "LIST",
    "MULTIPLE" => "Y",
    'REFRESH' => 'N',
    "VALUES" => $arProperties,
);

$arComponentParameters["PARAMETERS"]['FORM_TITLE'] = array(
    "PARENT" => "PARAMS",
    "NAME" => GetMessage("KZNC_IBLOCK_POPUP_TITLE"),
    "TYPE" => "TEXT",
    "DEFAULT" => GetMessage("KZNC_IBLOCK_POPUP_DEFAULT_TITLE")
);

$arComponentParameters["PARAMETERS"]['BXR_FORM_SUBMIT_CAPTION'] = array(
    'NAME' => GetMessage('BXR_FORM_SUBMIT_CAPTION'),
    'PARENT' => 'PARAMS',
    'TYPE' => 'STRING',
    "DEFAULT" => GetMessage("BXR_FORM_SUBMIT_CAPTION_DEFAULT")
);

$arComponentParameters["PARAMETERS"]["PERSONAL_DATA"] = array(
    "PARENT" => "PERSONAL_DATA",
    "NAME" => GetMessage("KZNC_PERSONAL_DATA"),
    "TYPE" => "CHECKBOX",
);

$arComponentParameters["PARAMETERS"]["PERSONAL_DATA_TEXT"] = array(
    "PARENT" => "PERSONAL_DATA",
    "NAME" => GetMessage("KZNC_PERSONAL_DATA_TEXT"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("KZNC_PERSONAL_DATA_TEXT_DEFAULT")
);

$arComponentParameters["PARAMETERS"]["PERSONAL_DATA_CAPTION"] = array(
    "PARENT" => "PERSONAL_DATA",
    "NAME" => GetMessage("KZNC_PERSONAL_DATA_CAPTION"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("KZNC_PERSONAL_DATA_CAPTION_DEFAULT")
);

$arComponentParameters["PARAMETERS"]["PERSONAL_DATA_URL"] = array(
    "PARENT" => "PERSONAL_DATA",
    "NAME" => GetMessage("KZNC_PERSONAL_DATA_URL"),
    "TYPE" => "STRING",
    "DEFAULT" => ""
);

$arComponentParameters["PARAMETERS"]["PERSONAL_DATA_ERROR"] = array(
    "PARENT" => "PERSONAL_DATA",
    "NAME" => GetMessage("KZNC_PERSONAL_DATA_ERROR"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("KZNC_PERSONAL_DATA_ERROR_DEFAULT")
);
<?
$arTemplateParameters['BXR_SEARCH_PAGE_RESULT_COUNT'] = array(
	'PARENT' => 'SEARCH_PAGE_SETTINGS',
	'NAME' => GetMessage('BXR_PAGE_RESULT_COUNT'),
	'TYPE' => 'STRING',
	'DEFAULT' => "20"
);

$arTemplateParameters['BXR_SEARCH_DEFAULT_SORT'] = array(
	'PARENT' => 'SEARCH_PAGE_SETTINGS',
	'NAME' => GetMessage('CP_SP_DEFAULT_SORT'),
	"TYPE" => "LIST",
	"MULTIPLE" => "N",
	"DEFAULT" => "rank",
	"VALUES" => array(
		"rank" => GetMessage("CP_SP_DEFAULT_SORT_RANK"),
		"date" => GetMessage("CP_SP_DEFAULT_SORT_DATE"),
	),
);

$arTemplateParameters['BXR_SEARCH_USE_TITLE_RANK'] = array(
	"PARENT" => "SEARCH_PAGE_SETTINGS",
	"NAME" => GetMessage("SEARCH_USE_TITLE_RANK"),
	"TYPE" => "CHECKBOX",
	"DEFAULT" => "N",
);

$arTemplateParameters["RESTART"] = array(
        "PARENT" => "SEARCH_PAGE_SETTINGS",
        "NAME" => GetMessage("SEARCH_RESTART"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "N",
);

$arTemplateParameters["NO_WORD_LOGIC"] = array(
        "PARENT" => "SEARCH_PAGE_SETTINGS",
        "NAME" => GetMessage("CP_BSP_NO_WORD_LOGIC"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "N",
);

$arTemplateParameters["USE_LANGUAGE_GUESS"] = array(
        "PARENT" => "SEARCH_PAGE_SETTINGS",
        "NAME" => GetMessage("CP_BSP_USE_LANGUAGE_GUESS"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
);

$arTemplateParameters["CHECK_DATES"] = array(
        "PARENT" => "SEARCH_PAGE_SETTINGS",
        "NAME" => GetMessage("SEARCH_CHECK_DATES"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "N",
);

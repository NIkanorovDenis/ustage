<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters["SHOW_PROPS"] = array(
	"NAME" => GetMessage("TP_BSP_SHOW_PROPS"),
	"TYPE" => "STRING",
	"DEFAULT" => "",
	"MULTIPLE" => "Y",
);

$arTemplateParameters["INPUT_PLACEHOLDER"] = array(
	"NAME" => GetMessage("TP_BSP_INPUT_PLACEHOLDER"),
	"TYPE" => "STRING",
	"DEFAULT" => "",
);
$arTemplateParameters["SHOW_HISTORY"] = array(
	"PARENT" => "VISUAL",
	"NAME" => GetMessage("CP_BSP_SHOW_HISTORY"),
	"TYPE" => "CHECKBOX",
	"DEFAULT" => "N"
);

/* if(COption::GetOptionString("search", "use_social_rating") == "Y")
{
	$arTemplateParameters["SHOW_RATING"] = Array(
		"NAME" => GetMessage("TP_BSP_SHOW_RATING"),
		"TYPE" => "LIST",
		"VALUES" => Array(
			"" => GetMessage("TP_BSP_SHOW_RATING_CONFIG"),
			"Y" => GetMessage("MAIN_YES"),
			"N" => GetMessage("MAIN_NO"),
		),
		"MULTIPLE" => "N",
		"DEFAULT" => "",
	);
	$arTemplateParameters["RATING_TYPE"] = Array(
		"NAME" => GetMessage("TP_BSP_RATING_TYPE"),
		"TYPE" => "LIST",
		"VALUES" => Array(
			"" => GetMessage("TP_BSP_RATING_TYPE_CONFIG"),
			"like" => GetMessage("TP_BSP_RATING_TYPE_LIKE_TEXT"),
			"like_graphic" => GetMessage("TP_BSP_RATING_TYPE_LIKE_GRAPHIC"),
			"standart_text" => GetMessage("TP_BSP_RATING_TYPE_STANDART_TEXT"),
			"standart" => GetMessage("TP_BSP_RATING_TYPE_STANDART_GRAPHIC"),
		),
		"MULTIPLE" => "N",
		"DEFAULT" => "",
	);
	$arTemplateParameters["PATH_TO_USER_PROFILE"] = Array(
		"NAME" => GetMessage("TP_BSP_PATH_TO_USER_PROFILE"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
	);
} */
?>

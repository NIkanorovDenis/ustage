<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!CModule::IncludeModule("iblock")
|| !CModule::IncludeModule("sale")
|| !CModule::IncludeModule("catalog")
|| !CModule::IncludeModule("alexkova.market2"))
	return;

$arComponentParameters = Array(
    	"GROUPS" => array(
                "COMPARE" => array('NAME'=>GetMessage("COMPARE"), "SORT" => "1000"),
                "FAVORITES" => array('NAME'=>GetMessage("FAVORITES"), "SORT" => "1010"),
	),
	"PARAMETERS" => Array(
		"PATH_TO_BASKET" => Array(
			"NAME" => GetMessage("SBBS_PATH_TO_BASKET"),
			"TYPE" => "STRING",
			"MULTIPLE" => "N",
			"DEFAULT" => "/personal/basket.php",
			"COLS" => 25,
			"PARENT" => "ADDITIONAL_SETTINGS",
		),
		"PATH_TO_ORDER" => Array(
			"NAME" => GetMessage("SBBS_PATH_TO_ORDER"),
			"TYPE" => "STRING",
			"MULTIPLE" => "N",
			"DEFAULT" => "/personal/order.php",
			"COLS" => 25,
			"PARENT" => "ADDITIONAL_SETTINGS",
		),
                "PRODUCT_PROVIDER_CLASS" => Array(
			"NAME" => GetMessage("PRODUCT_PROVIDER_CLASS"),
			"TYPE" => "STRING",
			"MULTIPLE" => "N",
			"DEFAULT" => "",
			"COLS" => 25,
			"PARENT" => "ADDITIONAL_SETTINGS",
		),

		"USE_COMPARE"=>array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => GetMessage("USE_COMPARE"),
			"TYPE" => "CHECKBOX",
			"REFRESH" => "Y"
		),

		/*"MOBILE_BLOCK"=>array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => GetMessage("MOBILE_BLOCK"),
			"TYPE" => "STRING",
			"DEFAULT" => "bxr-basket-mobile"
		)*/
	)
);

if(isset($arCurrentValues["USE_COMPARE"]) && $arCurrentValues["USE_COMPARE"] == "Y")
{
	$arIBlockType = CIBlockParameters::GetIBlockTypes();

	$arIBlock=array();
	$rsIBlock = CIBlock::GetList(Array("sort" => "asc"), Array("TYPE" => $arCurrentValues["IBLOCK_TYPE"], "ACTIVE"=>"Y"));
	while($arr=$rsIBlock->Fetch())
	{
		$arIBlock[$arr["ID"]] = "[".$arr["ID"]."] ".$arr["NAME"];
	}

	$arComponentParameters["PARAMETERS"]["IBLOCK_TYPE"] = array(
		"PARENT" => "COMPARE",
		"NAME" => GetMessage("BN_P_IBLOCK_TYPE"),
		"TYPE" => "LIST",
		"VALUES" => $arIBlockType,
		"REFRESH" => "Y",
		"SORT"=>800
	);

	$arComponentParameters["PARAMETERS"]["IBLOCK_ID"] = array(
		"PARENT" => "COMPARE",
		"NAME" => GetMessage("BN_P_IBLOCK"),
		"TYPE" => "LIST",
		"VALUES" => $arIBlock,
		"SORT"=>900
	);
        
        $arComponentParameters["PARAMETERS"]["BXR_COMPARE_LINK"] = array(
            "PARENT" => "COMPARE",
            "NAME" => GetMessage("BXR_COMPARE_LINK"),
            "TYPE" => "STRING ",
            "DEFAULT" => "/catalog/compare.php",
        );
}

$arComponentParameters["PARAMETERS"]["USE_DELAY"] = array(
	"PARENT" => "ADDITIONAL_SETTINGS",
	"NAME" => GetMessage("USE_DELAY"),
	"TYPE" => "CHECKBOX",
	"DEFAULT" => "Y",
	"SORT"=>1000
);

$arComponentParameters["PARAMETERS"]["USE_HEART"] = array(
	"PARENT" => "ADDITIONAL_SETTINGS",
	"NAME" => GetMessage("USE_HEART"),
	"TYPE" => "CHECKBOX",
	"DEFAULT" => "Y",
	"SORT"=>1000,
        "REFRESH" => "Y"
);

$arShowPopup = array(
    "true" => GetMessage("SHOW_POPUP_true"),
    "false" => GetMessage("SHOW_POPUP_false"),
);

$arComponentParameters["PARAMETERS"]["SHOW_POPUP"] = array(
	"PARENT" => "ADDITIONAL_SETTINGS",
	"NAME" => GetMessage("SHOW_POPUP"),
	"TYPE" => "LIST",
	"DEFAULT" => "true",
        "VALUES" => $arShowPopup,
	"SORT" => 1000,
);

if(isset($arCurrentValues["USE_HEART"]) && $arCurrentValues["USE_HEART"] == "Y")
{
    $arComponentParameters["PARAMETERS"]["BXR_FAVORITES_LINK"] = array(
        "PARENT" => "FAVORITES",
        "NAME" => GetMessage("BXR_FAVORITES_LINK"),
        "TYPE" => "STRING ",
        "DEFAULT" => "/personal/favorites/",
    );
}
?>
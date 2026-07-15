<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @global CMain $APPLICATION */
if(\Bitrix\Main\Loader::includeModule("alexkova.bxready2"))
    \Alexkova\Bxready2\Component::prepareParams($arParams, "bxready.market2:catalog");

if (isset($arParams["USE_FILTER"]) && $arParams["USE_FILTER"]=="Y")
{
	$arParams["FILTER_NAME"] = trim($arParams["FILTER_NAME"]);
	if ($arParams["FILTER_NAME"] === '' || !preg_match("/^[A-Za-z_][A-Za-z01-9_]*$/", $arParams["FILTER_NAME"]))
		$arParams["FILTER_NAME"] = "arrFilter";
}
else
	$arParams["FILTER_NAME"] = "";

//default gifts
if(empty($arParams['USE_GIFTS_SECTION']))
{
	$arParams['USE_GIFTS_SECTION'] = 'Y';
}
if(empty($arParams['GIFTS_SECTION_LIST_PAGE_ELEMENT_COUNT']))
{
	$arParams['GIFTS_SECTION_LIST_PAGE_ELEMENT_COUNT'] = 3;
}
if(empty($arParams['GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT']))
{
	$arParams['GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT'] = 3;
}
if(empty($arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT']))
{
	$arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT'] = 3;
}

foreach($arParams as $cell => $val){
    if (substr_count($cell, '_PRESENT')){
        $code = str_replace('_PRESENT', '', $cell);
        $arParams['BXR_PRESENT_SETTINGS'][$code] = $val;
    }
}

$smartBase = ($arParams["SEF_URL_TEMPLATES"]["section"]? $arParams["SEF_URL_TEMPLATES"]["section"]: "#SECTION_ID#/");
$arDefaultUrlTemplates404 = array(
	"sections" => "",
	"section" => "#SECTION_ID#/",
	"element" => "#SECTION_ID#/#ELEMENT_ID#/",
	"compare" => "compare.php?action=COMPARE",
	"smart_filter" => $smartBase."filter/#SMART_FILTER_PATH#/apply/"
);

$arDefaultVariableAliases404 = array();

$arDefaultVariableAliases = array();

$arComponentVariables = array(
	"SECTION_ID",
	"SECTION_CODE",
	"ELEMENT_ID",
	"ELEMENT_CODE",
	"action",
);

$bxr_use_links_sku_sef_section = COption::GetOptionString("alexkova.market2", "bxr_use_links_sku_sef_section", "");
$offerMask = ($bxr_use_links_sku_sef_section != "") ? $bxr_use_links_sku_sef_section : 'offer';

CModule::IncludeModule("energosoft.utils");
$arPropCode = array();
foreach(ESIBlock::GetProperties(32, array("SORT")) as $arItem) if(intval($arItem["SORT"]) > 100) $arPropCode[] = $arItem["CODE"];
$arParams["DETAIL_PROPERTY_CODE"] = $arPropCode;
$arParams["COMPARE_PROPERTY_CODE"] = $arPropCode;

if($arParams["SEF_MODE"] == "Y")
{
	$arVariables = array();

	$engine = new CComponentEngine($this);
	if (\Bitrix\Main\Loader::includeModule('iblock'))
	{
		$engine->addGreedyPart("#SECTION_CODE_PATH#");
		$engine->addGreedyPart("#SMART_FILTER_PATH#");
		$engine->setResolveCallback(array("CIBlockFindTools", "resolveComponentEngine"));
	}
	$arUrlTemplates = CComponentEngine::makeComponentUrlTemplates($arDefaultUrlTemplates404, $arParams["SEF_URL_TEMPLATES"]);
	$arVariableAliases = CComponentEngine::makeComponentVariableAliases($arDefaultVariableAliases404, $arParams["VARIABLE_ALIASES"]);

	$componentPage = $engine->guessComponentPath(
		$arParams["SEF_FOLDER"],
		$arUrlTemplates,
		$arVariables
	);

	$isSmartFilter = 'N';

	if ($componentPage === "smart_filter") {
		$componentPage = "section";
		$isSmartFilter = 'Y';
	}

	if((!$componentPage || $componentPage == "sections") && isset($_REQUEST["q"]))
		$componentPage = "search";

	$b404 = false;
	if(!$componentPage || strripos($APPLICATION->GetCurDir(), $offerMask))
	{
            $bxr_use_links_sku = COption::GetOptionString("alexkova.market2", "bxr_use_links_sku", "N");
            $bxr_use_links_sku_sef = COption::GetOptionString("alexkova.market2", "bxr_use_links_sku_sef", "N");
            $bxr_use_links_sku_sef_code = COption::GetOptionString("alexkova.market2", "bxr_use_links_sku_sef_code", "N");
            if ($bxr_use_links_sku == "Y" && $bxr_use_links_sku_sef == "Y") {
                $arUrlTemplates["element"] = ($bxr_use_links_sku_sef_code != "Y") ? rtrim($arUrlTemplates["element"], '/').'/'.$offerMask.'/#OFFER_ID#/': rtrim($arUrlTemplates["element"], '/').'/'.$offerMask.'/#OFFER_CODE#/';

                $componentPage = $engine->guessComponentPath(
                    $arParams["SEF_FOLDER"],
                    $arUrlTemplates,
                    $arVariables
                );
            }
            if(!$componentPage) {
		$componentPage = "sections";
		$b404 = true;
            }
	}

	if($componentPage == "section")
	{
		if (isset($arVariables["SECTION_ID"]))
			$b404 |= (intval($arVariables["SECTION_ID"])."" !== $arVariables["SECTION_ID"]);
		else
			$b404 |= !isset($arVariables["SECTION_CODE"]);
	}

	if($b404 && CModule::IncludeModule('iblock'))
	{
		$folder404 = str_replace("\\", "/", $arParams["SEF_FOLDER"]);
		if ($folder404 != "/")
			$folder404 = "/".trim($folder404, "/ \t\n\r\0\x0B")."/";
		if (substr($folder404, -1) == "/")
			$folder404 .= "index.php";

		if ($folder404 != $APPLICATION->GetCurPage(true))
		{
			\Bitrix\Iblock\Component\Tools::process404(
				""
				,($arParams["SET_STATUS_404"] === "Y")
				,($arParams["SET_STATUS_404"] === "Y")
				,($arParams["SHOW_404"] === "Y")
				,$arParams["FILE_404"]
			);
		}
	}
        
	CComponentEngine::initComponentVariables($componentPage, $arComponentVariables, $arVariableAliases, $arVariables);
	$arResult = array(
		"FOLDER" => $arParams["SEF_FOLDER"],
		"URL_TEMPLATES" => $arUrlTemplates,
		"VARIABLES" => $arVariables,
		"ALIASES" => $arVariableAliases,
		"USE_SMART_FILTER" => $isSmartFilter
	);
}
else
{
	$arVariables = array();

	$arVariableAliases = CComponentEngine::makeComponentVariableAliases($arDefaultVariableAliases, $arParams["VARIABLE_ALIASES"]);
	CComponentEngine::initComponentVariables(false, $arComponentVariables, $arVariableAliases, $arVariables);

	$componentPage = "";

	$arCompareCommands = array(
		"COMPARE",
		"DELETE_FEATURE",
		"ADD_FEATURE",
		"DELETE_FROM_COMPARE_RESULT",
		"ADD_TO_COMPARE_RESULT",
		"COMPARE_BUY",
		"COMPARE_ADD2BASKET",
	);

	if(isset($arVariables["action"]) && in_array($arVariables["action"], $arCompareCommands))
		$componentPage = "compare";
	elseif(isset($arVariables["ELEMENT_ID"]) && intval($arVariables["ELEMENT_ID"]) > 0)
		$componentPage = "element";
	elseif(isset($arVariables["ELEMENT_CODE"]) && strlen($arVariables["ELEMENT_CODE"]) > 0)
		$componentPage = "element";
	elseif(isset($arVariables["SECTION_ID"]) && intval($arVariables["SECTION_ID"]) > 0)
		$componentPage = "section";
	elseif(isset($arVariables["SECTION_CODE"]) && strlen($arVariables["SECTION_CODE"]) > 0)
		$componentPage = "section";
	elseif(isset($_REQUEST["q"]))
		$componentPage = "search";
	else
		$componentPage = "sections";
        
	$currentPage = htmlspecialcharsbx($APPLICATION->GetCurPage())."?";
	$arResult = array(
		"FOLDER" => "",
		"URL_TEMPLATES" => array(
			"section" => $currentPage.$arVariableAliases["SECTION_ID"]."=#SECTION_ID#",
			"element" => $currentPage.$arVariableAliases["SECTION_ID"]."=#SECTION_ID#"."&".$arVariableAliases["ELEMENT_ID"]."=#ELEMENT_ID#",
			"compare" => $currentPage.$arVariableAliases["action"]."=COMPARE",
		),
		"VARIABLES" => $arVariables,
		"ALIASES" => $arVariableAliases
	);
}

$this->IncludeComponentTemplate($componentPage);
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/** @var MarketRegionController $this */
$arResult = array();

if (!\Bitrix\Main\Loader::includeModule('alexkova.market2')
    || !\Bitrix\Main\Loader::includeModule('alexkova.bxready2')    
    || !\Bitrix\Main\Loader::includeModule('iblock') )
        return ;

if( \COption::GetOptionString( 'alexkova.market2', "regions_mode"."_".SITE_TEMPLATE_ID, "N") != "Y")
    return false;

if(isset($arParams["HIDE_COMPONENT"]) && $arParams["HIDE_COMPONENT"]=="Y")
    return false;

if( \COption::GetOptionString( 'alexkova.market2', "regions_mode_domain"."_".SITE_TEMPLATE_ID, "N") == "Y")
    $arParams["USE_DOMAIN"] = "Y";

\Alexkova\Bxready2\Component::prepareParams($arParams, "bxready.market2:region.controller");


$marketRegistry = \Alexkova\Market2\Bxmarket::getInstance();

if(!isset($arParams["CACHE_TIME"]))
    $arParams["CACHE_TIME"] = 36000000;

$newRegion =  htmlspecialcharsbx($_REQUEST["region"]);
//$changeRegion =  htmlspecialcharsbx($_REQUEST["change_region"]);

/*if (strlen($changeRegion) > 0 && $this->getCurrentRegion() != $changeRegion) {
    $this->setNewRegion($changeRegion, false);
} else*/
if (strlen($newRegion) > 0  && strlen($_REQUEST["set_region"])>0) {
    $this->setNewRegion($newRegion, true);
    return;
}

if (strlen($_REQUEST["reset_region"])>0){
	$this->resetRegion();
	return;
}

$marketRegistry->setRegionData(array(
	'auto_detect'=>true,
	'current_region' => "",
	'default_region' => "",
	'detect_region' => ""
));


if(isset($arParams["USE_DOMAIN"]) && $arParams["USE_DOMAIN"]=="Y"){
    $currentRegion = $this->getCurrentRegionDomain();
}else{
    $currentRegion = $this->getCurrentRegion();
}

$cacheParams = array('REGION'=>$currentRegion);

if($this->StartResultCache(false,$cacheParams))
{
	$startRegion = $currentRegion;
        
        if(isset($arParams["USE_DOMAIN"]) && $arParams["USE_DOMAIN"]=="Y") {
            $currentRegion = $this->detectRegionDomain();
        }
        else {
            if (function_exists('curl_init') && empty($currentRegion)){
                    $currentRegion = $this->detectRegion();
            }
            
            if (empty($currentRegion)){
		$currentRegion = $this->getDefaultRegion();
            }
        }
        
        if(isset($arParams["USE_DOMAIN"]) && $arParams["USE_DOMAIN"]=="Y")
            $this->getDefaultRegionInfo();

	if (!empty($currentRegion)){
		$this->getRegionInfo($currentRegion);
	}

	$regionData = $marketRegistry->getRegionData();
	$arResult['REGION_REGISTRY'] = $marketRegistry->getRegionData();
	$this->setResultCacheKeys(array('REGION_REGISTRY'));

	if (empty($startRegion))
		$this->AbortResultCache();

	$this->IncludeComponentTemplate();
}

if (!empty($currentRegion)){
        $this->setNewRegion($currentRegion);
}

if (isset($arResult['REGION_REGISTRY']) && is_array($arResult['REGION_REGISTRY'])){
        $marketRegistry = \Alexkova\Market2\Bxmarket::getInstance();
        $marketRegistry->setRegionData(
                $arResult['REGION_REGISTRY']
        );
        
        $regionData = $marketRegistry->getRegionData();
        if(isset($regionData["region_detail"]) && !empty($regionData["region_detail"])) {
            $_SESSION["REGION_INFO"] = serialize($regionData);
        }
}
?>
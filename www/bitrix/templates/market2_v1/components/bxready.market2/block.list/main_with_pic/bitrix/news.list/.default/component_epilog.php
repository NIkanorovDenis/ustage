<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Alexkova\Bxready\BXReady;

global $setActivitiesLink;
$setActivitiesLink = false;

if ($arResult["COUNT_ELS"]>0)
	$setActivitiesLink = true;

$use_seo_pagenavigation = COption::GetOptionString("alexkova.market2", "use_seo_pagenavigation", "N");
if ($use_seo_pagenavigation == "Y" && $arResult['CURRENT_PAGE'] > 0 && $arResult['MAX_PAGE'] > 1) {

	if ( $arResult['CURRENT_PAGE'] > 1 ) {
		$APPLICATION->AddHeadString('<meta name="robots" content="noindex, follow"/>',true);
	}

	$siteLink = (CMain::IsHTTPS()) ? 'https://' : 'http://';
	$siteLink .= $_SERVER['SERVER_NAME'] . $APPLICATION->GetCurPage(false);

	if (empty($_REQUEST['PAGEN_'.$arResult['NAV_NUM']])) {
		$APPLICATION->AddHeadString('<link rel="next" href="' . $siteLink . '?PAGEN_'.$arResult['NAV_NUM'].'=2"/>', true);
	}

	if ( $arResult['CURRENT_PAGE'] == 1 ) {
		$APPLICATION->AddHeadString('<link rel="next" href="'.$siteLink.'?PAGEN_'.$arResult['NAV_NUM'].'=2"/>',true);
	}
	elseif( ($arResult['CURRENT_PAGE'] == 2) && ($arResult['CURRENT_PAGE'] != $arResult['MAX_PAGE']) ) {
		$APPLICATION->AddHeadString('<link rel="prev" href="'.$siteLink.'"/>',true);
		$APPLICATION->AddHeadString('<link rel="next" href="'.$siteLink.'?PAGEN_'.$arResult['NAV_NUM'].'='.($arResult['CURRENT_PAGE'] + 1).'"/>',true);
	}
	elseif( ($arResult['CURRENT_PAGE'] == 2) && ($arResult['CURRENT_PAGE'] == $arResult['MAX_PAGE']) ) {
		$APPLICATION->AddHeadString('<link rel="prev" href="'.$siteLink.'"/>',true);
	}
	elseif( $arResult['CURRENT_PAGE'] == $arResult['MAX_PAGE'] ) {
		$APPLICATION->AddHeadString('<link rel="prev" href="'.$siteLink.'?PAGEN_'.$arResult['NAV_NUM'].'='.($arResult['CURRENT_PAGE'] - 1).'"/>',true);
	}
	else {
		$APPLICATION->AddHeadString('<link rel="prev" href="'.$siteLink.'?PAGEN_'.$arResult['NAV_NUM'].'='.($arResult['CURRENT_PAGE'] - 1).'"/>',true);
		$APPLICATION->AddHeadString('<link rel="next" href="'.$siteLink.'?PAGEN_'.$arResult['NAV_NUM'].'='.($arResult['CURRENT_PAGE'] + 1).'"/>',true);
	}
}

$APPLICATION->AddHeadScript('/bitrix/js/alexkova.bxready2/slick/slick.js', true);
$APPLICATION->SetAdditionalCSS('/bitrix/js/alexkova.bxready2/slick/slick.css', false);
?>
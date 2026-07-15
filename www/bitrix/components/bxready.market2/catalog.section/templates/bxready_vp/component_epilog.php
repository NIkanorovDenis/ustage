<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $templateData
 * @var string $templateFolder
 * @var CatalogSectionComponent $component
 */

global $APPLICATION;

if (!empty($templateData['TEMPLATE_LIBRARY']))
{
	$loadCurrency = false;
	if (!empty($templateData['CURRENCIES']))
	{
		$loadCurrency = \Bitrix\Main\Loader::includeModule('currency');
	}

	CJSCore::Init($templateData['TEMPLATE_LIBRARY']);

	if ($loadCurrency)
	{
		?>
		<script>
			//BX.Currency.setCurrencies(<?=$templateData['CURRENCIES']?>);
		</script>
		<?
	}
}

//	lazy load and big data json answers
$request = \Bitrix\Main\Context::getCurrent()->getRequest();
if ($request->isAjaxRequest() && ($request->get('action') === 'showMore' || $request->get('action') === 'deferredLoad'))
{
	$content = ob_get_contents();
	ob_end_clean();

	list(, $itemsContainer) = explode('<!-- items-container -->', $content);
	list(, $paginationContainer) = explode('<!-- pagination-container -->', $content);

	if ($arParams['AJAX_MODE'] === 'Y')
	{
		$component->prepareLinks($paginationContainer);
	}

	$component::sendJsonAnswer(array(
		'items' => $itemsContainer,
		'pagination' => $paginationContainer
	));
}

if ($arParams["BXREADY_LIST_SLIDER_LISTPAGE"] == "Y"){
	$APPLICATION->AddHeadScript('/bitrix/js/alexkova.bxready2/slick/slick.js');
	$APPLICATION->SetAdditionalCSS('/bitrix/js/alexkova.bxready2/slick/slick.css', false);
}

$use_seo_pagenavigation = COption::GetOptionString("alexkova.market2", "use_seo_pagenavigation", "N");
if ($use_seo_pagenavigation && $arResult['CURRENT_PAGE'] > 0 && $arResult['MAX_PAGE'] > 1) {

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
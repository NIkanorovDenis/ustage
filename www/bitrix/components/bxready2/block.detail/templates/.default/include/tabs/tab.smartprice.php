<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>


<div class="row">

	<?if (\Bitrix\Main\Loader::includeModule('alexkova.business')):?>
		<div class="col-xs-12">
			<?
			if (is_array($arResult['SMARTPRICE_SECTIONS']) && count($arResult['SMARTPRICE_SECTIONS'])>0){
				$APPLICATION->IncludeComponent(
					"alexkova.business:price.list",
					".default",
					array(
						"COMPONENT_TEMPLATE" => ".default",
						"BXR_BUSINESS_SMARTPRICE_IBLOCK_ID" => $arParams['BXR_SMARTPRICE']['BXR_BUSINESS_SMARTPRICE_IBLOCK_ID'],
						"BXR_BUSINESS_PRICE_SECTION" => $arResult['SMARTPRICE_SECTIONS'],
						"BXR_SMARTPRICE_ARTICLE_CODE" => $arParams['BXR_SMARTPRICE']['BXR_SMARTPRICE_ARTICLE_CODE'],
						"BXR_BUSINESS_INCLUDE_SUBSECTION" => "N",
						"BXR_SMARTPRICE_PRICE_TEMPLATE" => $arParams['BXR_SMARTPRICE']['BXR_SMARTPRICE_PRICE_TEMPLATE'],
						"BXR_SMARTPRICE_PRICE_DECIMAL" => $arParams['BXR_SMARTPRICE']['BXR_SMARTPRICE_PRICE_DECIMAL'],
						"BXR_SMARTPRICE_PRICE_DECIMAL_POINT" => $arParams['BXR_SMARTPRICE']['BXR_SMARTPRICE_PRICE_DECIMAL_POINT'],
						"BXR_SMARTPRICE_PRICE_THOUSAND" => $arParams['BXR_SMARTPRICE']['BXR_SMARTPRICE_PRICE_THOUSAND'],
						"CACHE_TYPE" => $arParams['CACHE_TYPE'],
						"CACHE_TIME" => $arParams['CACHE_TIME']
					),
					false
				);
			}
			?>
		</div>
	<?endif;?>

</div>
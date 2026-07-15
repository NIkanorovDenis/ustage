<div class="row">
	<div class="col-xl-9 col-lg-8 col-md-12 col-sm-12 col-xs-12">
		<div class="bxr-detail-col">

			<?
			$commonListParams = array(
				"ID" => $ElementID,
				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
				"COMPONENT_TEMPLATE" => "bxready.market2",
				"CROSS_TYPE" => "E",
				"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
				"OFFERS_PROPERTY_CODE" => $arParams["OFFERS_PROPERTY_CODE"],
				"ELEMENT_SORT_FIELD" => "sort",
				"HIDE_NOT_AVAILABLE" => "N",
				"PAGE_ELEMENT_COUNT" => "30",
				"BLOCK_TITLE" => $arParams['BXR_CROSS_SELL_TITLE'],
				"BXR_SHOW_MAX_QUANTITY" => $arParams["SHOW_MAX_QUANTITY"],
				"PRICE_CODE" => $arParams['PRICE_CODE'],
				"SHOW_OLD_PRICE" => $arParams["SHOW_OLD_PRICE"],
				"USE_PRICE_COUNT" => "N",
				"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
				"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
				"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
				"CONVERT_CURRENCY" => $arParams["CURRENCY_ID"],
				"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
				"USE_PRODUCT_QUANTITY" => $arParams["USE_PRODUCT_QUANTITY"],
				"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
				"ADD_PROPERTIES_TO_BASKET" => $arParams["ADD_PROPERTIES_TO_BASKET"],
				"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
				"PARTIAL_PRODUCT_PROPERTIES" => $arParams["PARTIAL_PRODUCT_PROPERTIES"],
				"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
				"BXREADY_LIST_XLG_CNT_LISTPAGE" => $arParams["BXREADY_LIST_XLG_CNT_LISTPAGE"],
				"BXREADY_LIST_LG_CNT_LISTPAGE" => $arParams["BXREADY_LIST_LG_CNT_LISTPAGE"],
				"BXREADY_LIST_MD_CNT_LISTPAGE" => $arParams["BXREADY_LIST_MD_CNT_LISTPAGE"],
				"BXREADY_LIST_SM_CNT_LISTPAGE" => $arParams["BXREADY_LIST_SM_CNT_LISTPAGE"],
				"BXREADY_LIST_XS_CNT_LISTPAGE" => $arParams["BXREADY_LIST_XS_CNT_LISTPAGE"],
				"BXREADY_ELEMENT_ADDCLASS_LISTPAGE" => $arParams["BXREADY_ELEMENT_ADDCLASS_LISTPAGE"],
				"BXREADY_USE_ELEMENTCLASS_LISTPAGE" => $arParams["BXREADY_USE_ELEMENTCLASS_LISTPAGE"],
				"BXREADY_VERTICAL_ALIGN_LISTPAGE" => $arParams["BXREADY_VERTICAL_ALIGN_LISTPAGE"],
				"BXREADY_ELEMENT_EXT_PARAMS_LISTPAGE" => $arParams["BXREADY_ELEMENT_EXT_PARAMS_LISTPAGE"],
				"BXREADY_USER_TYPES_LISTPAGE" => $arParams["BXREADY_USER_TYPES_LISTPAGE"],
				"BXREADY_ELEMENT_DRAW_LISTPAGE" => $arParams["BXREADY_ELEMENT_DRAW_LISTPAGE"],
				"BXR_SHOW_RATING_LISTPAGE" => $arParams["BXR_SHOW_RATING_LISTPAGE"],
				"BXR_SHOW_ACTION_TIMER_LISTPAGE" => $arParams["BXR_SHOW_ACTION_TIMER_LISTPAGE"],
				"BXR_SKU_PROPS_SHOW_TYPE_LISTPAGE" => $arParams["BXR_SKU_PROPS_SHOW_TYPE_LISTPAGE"],
				"BXR_TILE_SHOW_PROPERTIES_LISTPAGE" => $arParams["BXR_TILE_SHOW_PROPERTIES_LISTPAGE"],
				"BXREADY_LIST_MARKER_TYPE_LISTPAGE" => $arParams["BXREADY_LIST_MARKER_TYPE_LISTPAGE"],
				"BXREADY_LIST_OWN_MARKER_USE_LISTPAGE" => $arParams["BXREADY_LIST_OWN_MARKER_USE_LISTPAGE"],
				"BXR_SHOW_ARTICLE_LISTPAGE" => $arParams["BXR_SHOW_ARTICLE_LISTPAGE"],
				"BXR_SHOW_SLIDER_LISTPAGE" => $arParams["BXR_SHOW_SLIDER_LISTPAGE"],
				"BXR_USE_FAST_VIEW_LISTPAGE" => $arParams["BXR_USE_FAST_VIEW_LISTPAGE"],
				"BXR_IMG_MAX_WIDTH_LISTPAGE" => $arParams["BXR_IMG_MAX_WIDTH_LISTPAGE"],
				"BXR_IMG_MAX_HEIGHT_LISTPAGE" => $arParams["BXR_IMG_MAX_HEIGHT_LISTPAGE"],
				"BXREADY_LIST_SLIDER_LISTPAGE" => "Y",
				"BXREADY_LIST_VERTICAL_SLIDER_MODE_LISTPAGE" => "N",
				"BXREADY_LIST_HIDE_SLIDER_ARROWS_LISTPAGE" => "Y",
				"BXREADY_LIST_SLIDER_MARKERS_LISTPAGE" => "Y",
				"BXREADY_LIST_HIDE_MOBILE_SLIDER_ARROWS_LISTPAGE" => "N",
				"BXREADY_LIST_SLIDER_AUTOSCROLL_LISTPAGE" => "N",
				"BXR_SLIDER_INTERVAL_LISTPAGE" => "0",
				"BXREADY_LIST_SLIDER_SCROLLSPEED_LISTPAGE" => "300",
				"BXREADY_LIST_SLIDER_AUTOPLAY_SPEEDD_LISTPAGE" => "2500",
				'MERGE_TYPE' => $arParams['BXR_USE_CROSS_SELL_MERGE_MODE'],
				"BXR_LAZY_LOAD" => "N",
			);

			if ($arParams["BXR_EXT_LIST_SETTINGS_MODE"] == "Y" || $arParams["BXR_EXT_LIST_SETTINGS_RECOMMENDED"] != "Y")
				$allBXRPrefix = array("_OTHER");
			else
				$allBXRPrefix = array("_RECOMMENDED");

			$allBXRPrefix = array("_OTHER");

			foreach ($arParams as $cell => $val) {
				foreach ($allBXRPrefix as $prefix) {
					if (substr_count($cell, "~") > 0)
						continue;
					if (substr($cell, strlen($cell) - strlen($prefix), strlen($prefix)) == $prefix)
						$additionalListParams[substr($cell, 0, strlen($cell) - strlen($prefix)) . '_LISTPAGE'] = $val;
				}
			}

			$arRecommendedParams = array_merge($commonListParams, $additionalListParams);

			$arRecommendedParams["BXR_AJAX_REGION_INFO"] = $arParams["BXR_AJAX_REGION_INFO"];
			$arRecommendedParams["USE_BXR_STORES"] = $arParams["USE_BXR_STORES"];
			$arRecommendedParams["STORES"] = $arParams["STORES"];
			$arRecommendedParams["CROSS_TYPE"] = 'E';
			$arRecommendedParams["ELEMENT_COUNT"] = intval($arParams['BXR_CROSS_SELL_COUNT']) > 0 ? intval($arParams['BXR_CROSS_SELL_COUNT']) : 10;
			$arRecommendedParams["PAGE_ELEMENT_COUNT"] = $arRecommendedParams["ELEMENT_COUNT"];

			$APPLICATION->IncludeComponent(
				"alexkova.sets:cross.list",
				'bxready.market2',
				$arRecommendedParams,
				$component,
				array("HIDE_ICONS" => "Y")
			); ?>

		</div>
	</div>
</div>
<? global $APPLICATION; ?>
<div>

	<? $APPLICATION->IncludeComponent(
			"bxready.market2:menu",
			"bxr_mobile_v2_with_columns",
			array(
				"ALLOW_MULTI_SELECT" => "N",
				"CHILD_MENU_TYPE" => "left_catalog",
				"COMPONENT_TEMPLATE" => "bxr_mobile_v2_with_columns",
				"DELAY" => "N",
				"MAX_LEVEL" => "3",
				"MENU_CACHE_GET_VARS" => array(),
				"MENU_CACHE_TIME" => "36000",
				"MENU_CACHE_TYPE" => "A",
				"MENU_CACHE_USE_GROUPS" => "N",
				"ROOT_MENU_TYPE" => "top_info",
				"USE_EXT" => "Y",
				"BXR_MOBILE_SHOW_SEARCH_FORM" => "Y",
				"BXR_MOBILE_SHOW_ANSWER_FORM" => "Y",
				"BXR_MOBILE_SHOW_PHONE_FORM" => "Y",
				"BXR_MOBILE_SHOW_USER_FORM" => "Y",
				"CACHE_SELECTED_ITEMS" => false,
				"BXR_MOBILE_SHOW_CHART_FORM" => "Y",
				"BXR_MOBILE_SHOW_HEART_FORM" => "Y",
				"BXR_MOBILE_SHOW_BASKET_FORM" => "Y",
				"BXR_COMPARE_LINK" => "/catalog/compare.php",
				"BXR_FAVORITES_LINK" => "/personal/favorites/",
				"BXR_BASKET_LINK" => "/personal/basket/",
				"STYLE_MENU" => "colored_light",
				"BXR_USER_LINK" => "/personal/profile/"
			),
			false
		);
	
	?>
</div>

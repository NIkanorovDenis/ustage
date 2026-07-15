<?php
$bxmarket = \Alexkova\Market2\Bxmarket::getInstance();
if ($bxmarket->getCoreData("left_column") == 'Y' && $APPLICATION->GetCurPage() == SITE_DIR) { ?>
    <div class="bxr-b20 bxr-cloud-all bxr-cloud-all-br1-not bxr-cloud-all-br2-not">
        <div class="bxr-cloud-padding">
            <?$APPLICATION->IncludeComponent(
	"bxready.market2:block.list", 
	".default", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BXREADY_COLLECTION_DRAW" => "flat",
		"BXREADY_ELEMENT_ADDCLASS" => "",
		"BXREADY_ELEMENT_DRAW" => "news.short.list.v1",
		"BXREADY_ELEMENT_EXT_PARAMS" => "arrExtParams",
		"BXREADY_LIST_BOOTSTRAP_GRID_STYLE" => "12",
		"BXREADY_LIST_HIDE_MOBILE_SLIDER_ARROWS" => "N",
		"BXREADY_LIST_HIDE_SLIDER_ARROWS" => "Y",
		"BXREADY_LIST_LG_CNT" => "12",
		"BXREADY_LIST_MD_CNT" => "12",
		"BXREADY_LIST_PAGE_BLOCK_TITLE" => "РќРѕРІРѕСЃС‚Рё",
		"BXREADY_LIST_PAGE_BLOCK_TITLE_GLYPHICON" => "",
		"BXREADY_LIST_SLIDER" => "N",
		"BXREADY_LIST_SLIDER_AUTOSCROLL" => "N",
		"BXREADY_LIST_SLIDER_MARKERS" => "Y",
		"BXREADY_LIST_SM_CNT" => "12",
		"BXREADY_LIST_TYPES" => "elements",
		"BXREADY_LIST_VERTICAL_SLIDER_MODE" => "Y",
		"BXREADY_LIST_XLG_CNT" => "12",
		"BXREADY_LIST_XS_CNT" => "12",
		"BXREADY_SECTION_DRAW" => "empty",
		"BXREADY_USER_TYPES" => "N",
		"BXREADY_USE_ELEMENTCLASS" => "Y",
		"BXREADY_VERTICAL_ALIGN" => "Y",
		"BXR_PRST_SHOW_BORDER" => "N",
		"BXR_PRST_STYLE" => "left",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "NAME",
			1 => "PREVIEW_PICTURE",
			2 => "DATE_ACTIVE_FROM",
			3 => "DATE_ACTIVE_TO",
			4 => "",
		),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "13",
		"IBLOCK_TYPE" => "content",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "5",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?>
        </div>
    </div>

    <div class="bxr-b20 bxr-cloud-all bxr-cloud-all-br1-not bxr-cloud-all-br2-not">
        <?$APPLICATION->IncludeComponent(
	"bitrix:sender.subscribe", 
	"market_column", 
	array(
		"COMPONENT_TEMPLATE" => "market_column",
		"USE_PERSONALIZATION" => "Y",
		"SHOW_HIDDEN" => "N",
		"PAGE" => "/personal/subscribe/?type=list",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"SHOW_RUBRICS" => "Y",
		"CONFIRMATION" => "Y",
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"SET_TITLE" => "Y"
	),
	false,
	array(
		"ACTIVE_COMPONENT" => "Y"
	)
);?>
    </div>
<?}?>
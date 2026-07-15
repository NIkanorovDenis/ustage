<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="tb20-bottom hidden-sm hidden-xs">
    <?$APPLICATION->IncludeComponent(
            "alexkova.business:menu",
            isset($arParams["LEFT_MENU_TEMPLATE"]) ? $arParams["LEFT_MENU_TEMPLATE"] : "left_hover",
            array(
                "ROOT_MENU_TYPE" => isset($arParams["ROOT_MENU_TYPE"]) ? $arParams["ROOT_MENU_TYPE"] : "left",
                "MAX_LEVEL" => isset($arParams["MAX_LEVEL"]) ? $arParams["MAX_LEVEL"] : "2",
                "CHILD_MENU_TYPE" => isset($arParams["CHILD_MENU_TYPE"]) ? $arParams["CHILD_MENU_TYPE"] : "left",
                "USE_EXT" => isset($arParams["USE_EXT"]) ? $arParams["USE_EXT"] : "Y",
                "DELAY" => isset($arParams["DELAY"]) ? $arParams["DELAY"] : "N",
                "TITLE_MENU" => isset($arParams["TITLE_MENU"]) ? $arParams["TITLE_MENU"] : "",                    
                "STYLE_MENU" => isset($arParams["STYLE_MENU"]) ? $arParams["STYLE_MENU"] : "colored_light", 			
                "PICTURE_SECTION" => isset($arParams["PICTURE_SECTION"]) ? $arParams["PICTURE_SECTION"] : "N", 
                "STYLE_MENU_HOVER" => isset($arParams["STYLE_MENU_HOVER"]) ? $arParams["STYLE_MENU_HOVER"] : "colored_light",
                "PICTURE_SECTION_HOVER" => isset($arParams["PICTURE_SECTION_HOVER"]) ? $arParams["PICTURE_SECTION_HOVER"] : "N",
                "PICTURE_CATEGARIES" => isset($arParams["PICTURE_CATEGARIES"]) ? $arParams["PICTURE_CATEGARIES"] : "N",
                "HOVER_MENU_COL_LG" => isset($arParams["HOVER_MENU_COL_LG"]) ? $arParams["HOVER_MENU_COL_LG"] : "2",
                "HOVER_MENU_COL_MD" => isset($arParams["HOVER_MENU_COL_MD"]) ? $arParams["HOVER_MENU_COL_MD"] : "2",
                "HOVER_MENU_COL_SM" => isset($arParams["HOVER_MENU_COL_SM"]) ? $arParams["HOVER_MENU_COL_SM"] : "2",
                "HOVER_MENU_COL_XS" => isset($arParams["HOVER_MENU_COL_XS"]) ? $arParams["HOVER_MENU_COL_XS"] : "2",
                "SUBMENU" => isset($arParams["SUBMENU"]) ? $arParams["SUBMENU"] : "ACTIVE_SHOW",
                "ICO_LEFT_MENU_COLOR_1" => isset($arParams["ICO_LEFT_MENU_COLOR_1"]) ? $arParams["ICO_LEFT_MENU_COLOR_1"] : "color",
                "ICO_LEFT_MENU_COLOR_2" => isset($arParams["ICO_LEFT_MENU_COLOR_2"]) ? $arParams["ICO_LEFT_MENU_COLOR_2"] : "light",
                "ICO_LEFT_MENU_HOVER_COLOR_1" => isset($arParams["ICO_LEFT_MENU_HOVER_COLOR_1"]) ? $arParams["ICO_LEFT_MENU_HOVER_COLOR_1"] : "color",
                "ICO_LEFT_MENU_HOVER_COLOR_2" => isset($arParams["ICO_LEFT_MENU_HOVER_COLOR_2"]) ? $arParams["ICO_LEFT_MENU_HOVER_COLOR_2"] : "light",
                "HOVER_TEMPLATE" => isset($arParams["HOVER_TEMPLATE"]) ? $arParams["HOVER_TEMPLATE"] : "classic",
                "MENU_CACHE_TYPE" => $arParams["CACHE_TYPE"],
                "MENU_CACHE_TIME" => $arParams["CACHE_TIME"],
                "MENU_CACHE_USE_GROUPS" => $arParams["CACHE_GROUPS"],
                "HOVER_SHOW_LEFT" => ($showLeft) ? "Y" : "N",
                "MENU_CACHE_GET_VARS" => array(
                ),
                "SHOW_TREE" => "Y",
            ),
            false,
            array("HIDE_ICONS" => "Y")
    );?>
</div>
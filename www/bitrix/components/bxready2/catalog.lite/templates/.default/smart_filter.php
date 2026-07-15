<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if(isset($arParams["USE_FILTER"]) && $arParams["USE_FILTER"]=="Y"):?>
    <div class="tb20-bottom <?if(isset($arParams["HIDE_FILTER_MOBILE"])&& $arParams["HIDE_FILTER_MOBILE"]=="Y") echo "hidden-sm hidden-xs";?>">
        <?
            $templateSmartFilter = "visual_vertical";
            if(isset($arParams["FILTER_VIEW_MODE"]) && $arParams["FILTER_VIEW_MODE"]=="HORIZONTAL")
                $templateSmartFilter = "visual_horisontal";
        ?>
        <?$APPLICATION->IncludeComponent(
                "bitrix:catalog.smart.filter",
                $templateSmartFilter,
                array(
                        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                        "SECTION_ID" => $arCurSection['ID'],
                        "FILTER_NAME" => $arParams["FILTER_NAME"],
                        "PRICE_CODE" => $arParams["PRICE_CODE"],
                        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                        "CACHE_TIME" => $arParams["CACHE_TIME"],
                        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                        "SAVE_IN_SESSION" => "N",
                        "FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
                        "XML_EXPORT" => "Y",
                        "SECTION_TITLE" => "NAME",
                        "SECTION_DESCRIPTION" => "DESCRIPTION",
                        'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
                        "TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
                        'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                        'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                        "SEF_MODE" => $arParams["SEF_MODE"],
                        "SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
                        "SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
                        "DISPLAY_ELEMENT_COUNT" => $arParams["DISPLAY_ELEMENT_COUNT"],
                        "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                        "FILTER_PRICE_CODE" => $arParams['FILTER_PRICE_CODE']
                ),
                $component,
                array('HIDE_ICONS' => 'Y')
        );?>
    </div>
<?endif;?>
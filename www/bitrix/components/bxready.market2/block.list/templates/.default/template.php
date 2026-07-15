<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (strlen($arParams['FILTER_NAME'])>0)
    global ${$arParams['FILTER_NAME']};
?>
<?$this->setFrameMode(true);
if ($arParams["BXREADY_LIST_SLIDER"] == "Y"){
	$this->addExternalJS('/bitrix/js/alexkova.bxready2/slick/slick.js');
	$this->addExternalCss('/bitrix/js/alexkova.bxready2/slick/slick.css', false);
}?>

<?$APPLICATION->IncludeComponent(
        "bitrix:news.list",
        "",
        $arParams,
        $component,
        array("HIDE_ICONS"=>"Y")
);?>
<div class="clearfix"></div>
    
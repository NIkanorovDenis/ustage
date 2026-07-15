<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
    if($showSmartFilter && (isset($arParams["FILTER_VIEW_MODE"]) && $arParams["FILTER_VIEW_MODE"]=="VERTICAL"))
        include($_SERVER["DOCUMENT_ROOT"]."/".$this->GetFolder()."/smart_filter.php");
    
    if(isset($arParams["SHOW_LEFT_MENU"]) && $arParams["SHOW_LEFT_MENU"]=="Y")
        include($_SERVER["DOCUMENT_ROOT"]."/".$this->GetFolder()."/menu.php");
?>
<?$APPLICATION->IncludeComponent(
        "bxready2:abmanager", 
        "full-static", 
        array(
                "SHOW" => "BXR_COLUMN",
                "BANTYPE" => "BXR_COLUMN",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "0",
                "USE_IN_LG_MODE" => "Y",
                "USE_IN_MD_MODE" => "Y",
                "USE_IN_SM_MODE" => "N",
                "USE_IN_XS_MODE" => "N",
                "COMPONENT_TEMPLATE" => "full-static"
        ),
        $component,
        array(
                "ACTIVE_COMPONENT" => "Y",
                "HIDE_ICONS" => "Y"
        )
    );
?>
<div class="clearfix"></div>
<?$APPLICATION->IncludeComponent(
    "bxready2:buffer.content",
    "",
    array(
        "BUFFER_NAME" => "sidebar"
    ),
    false,
    array('HIDE_ICONS' => 'Y')
);?>


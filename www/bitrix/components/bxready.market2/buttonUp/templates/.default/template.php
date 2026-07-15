<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?
    $location = "right";
    if(isset($arParams["LOCATION_HORIZONTALLY"]) && $arParams["LOCATION_HORIZONTALLY"] == "left")
        $location = "left";
    
    $paddingH = "";
    if(isset($arParams["BUTTON_UP_HORIZONTALLY_INDENT"]) && is_numeric($arParams["BUTTON_UP_HORIZONTALLY_INDENT"]))
        $paddingH = $location . ":" .  $arParams["BUTTON_UP_HORIZONTALLY_INDENT"] . "px;";
    
    $paddingV = "";
    if(isset($arParams["BUTTON_UP_VERTICAL_INDENT"]) && is_numeric($arParams["BUTTON_UP_VERTICAL_INDENT"]))
        $paddingV = "bottom:" .  $arParams["BUTTON_UP_VERTICAL_INDENT"] . "px;";
            
            
?>
<button type="button" class="bxr-button-up hidden-sm hidden-xs natural <?=$location;?> bxr-color-flat bxr-bg-hover-dark-flat" style="<?=$paddingH;?> <?=$paddingV;?>">
    <i class="fa fa-angle-double-up"></i>
</button>
<script>
    $(document).ready(function(){
        window.BXReady.Market.buttonUp.init(
            "<?=(isset($arParams["BUTTON_UP_TOP_SHOW"]) && is_numeric($arParams["BUTTON_UP_TOP_SHOW"])) ? $arParams["BUTTON_UP_TOP_SHOW"] : "150";?>",
            "<?=(isset($arParams["BUTTON_UP_SPEED"]) && is_numeric($arParams["BUTTON_UP_SPEED"])) ? $arParams["BUTTON_UP_SPEED"] : "1000";?>",
            "<?=(isset($arParams["BUTTON_UP_VERTICAL_INDENT"]) && is_numeric($arParams["BUTTON_UP_VERTICAL_INDENT"])) ? $arParams["BUTTON_UP_VERTICAL_INDENT"] : "10";?>");
    });
</script>


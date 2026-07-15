<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div class="bxr-classic-hover-menu <?if($arParams['COLOR_MENU'] == "light") {echo " menu-arrow-top";} ?><?if($arParams['STYLE_MENU_HOVER'] == "colored_color") {echo " bxr-classic-hover-menu-color";} ?><?if($arParams['STYLE_MENU_HOVER'] == "colored_dark") {echo " bxr-classic-hover-menu-dark";} ?>">
    <?  
        $isIco = "N";
        if(!empty($arParams['PICTURE_SECTION']))
             $isIco = $arParams['PICTURE_SECTION'];
        
        $arColorParams = array(
            "li" => "bxr-bg-hover-flat",
            "li_selected" => "bxr-color-flat",
            "ico_1" => "dark",
            "ico_2" => "light",
        );

        if(isset($arParams["STYLE_MENU_HOVER"]) && !empty($arParams["STYLE_MENU_HOVER"])) {
            switch ($arParams["STYLE_MENU_HOVER"]) {
                case "colored_color":
                    $arColorParams = array(
                        "li" => "bxr-color-flat bxr-bg-hover-dark-flat",
                        "li_selected" => "bxr-color-dark-flat"
                    );
                    break;
                case "colored_dark":
                    $arColorParams = array(
                        "li" => "bxr-dark-flat bxr-bg-hover-flat",
                        "li_selected" => "bxr-color-flat bxr-bg-hover-flat"
                    );
                    break;
                case "colored_light_new":
                    $arColorParams = array(
                        "li" => "bxr-children-color-hover",
                        "li_selected" => "bxr-children-color"
                    );
                    break;
            }
        }
        
        if(isset($arParams['SHOW_TOP']) &&  $arParams['SHOW_TOP']=="Y")
            $arColorParams["li"] .= " bxr-show-top ";
        
        if(!empty($arParams["ICO_HOVER_MENU_COLOR_1"]))
            $arColorParams["ico_1"] = $arParams["ICO_HOVER_MENU_COLOR_1"];
        
        if(!empty($arParams["ICO_HOVER_MENU_COLOR_2"]))
            $arColorParams["ico_2"] = $arParams["ICO_HOVER_MENU_COLOR_2"];

        $tree = bxr_classic_build_tree($arParams['MENU_TREE'], $isIco, $arColorParams, 1);       
        echo $tree;
    ?>
</div>
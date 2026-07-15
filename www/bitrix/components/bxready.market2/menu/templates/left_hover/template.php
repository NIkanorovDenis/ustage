<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?if (!empty($arResult["TREE"])):?>
<?
    if(!function_exists('getIcon')) {
        function getIcon($arItem, $arStyle, $arParams) {
        
            $arResult = array(
                "s_ico" => "",
                "s_ico_h" => "",
            );
            
            if(isset($arParams["PICTURE_SECTION"]) && $arParams["PICTURE_SECTION"] != "N") {
                if($arStyle["ico_1"]!=$arStyle["ico_2"]) {
                    if(isset($arItem["ico_".$arColor["ico_2"]]) && !empty($arItem["ico_".$arStyle["ico_2"]])) { 
                        if(is_numeric($arItem["ico_".$arStyle["ico_2"]])) {
                            $img = CFile::ResizeImageGet($arItem["ico_".$arStyle["ico_2"]], array('width'=>16, 'height'=>16), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                        }
                        else {
                           $img['src'] = $arItem[$arStyle["ico_2"]];
                        }
                        $arResult["s_ico_h"] = "<img class='bxr-ico-menu-left-hover-hover'  src='" . $img['src'] . "' alt='".$arItem["TEXT"]."'>";
                    }
                    elseif(!empty($arItem["ico_font"])){
                        $arResult["s_ico_h"] = "<i class='bxr-ico-menu-left-hover-hover bxr-font-".$arStyle["ico_2"]." fa fa-fw " . $arItem["ico_font"] . "' ></i>";
                    }
                    elseif($arParams["PICTURE_SECTION"] == "ICO_DEFAULT") {
                        $arResult["s_ico_h"] = "<i class='bxr-ico-menu-left-hover-hover bxr-font-".$arStyle["ico_2"]." fa fa-fw fa-angle-double-right' ></i>";
                    }
                }
                
                if(!empty($arResult["s_ico_h"]))
                    $icoClass = "bxr-ico-menu-left-hover-default";
                
                if(isset($arItem["ico_".$arStyle["ico_1"]]) && !empty($arItem["ico_".$arStyle["ico_1"]])) {
                    if(is_numeric($arItem["ico_".$arStyle["ico_1"]])) {
                        $img = CFile::ResizeImageGet($arItem["ico_".$arStyle["ico_1"]], array('width'=>16, 'height'=>16), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                    }
                    else {
                       $img['src'] = $arItem[$arStyle["ico_1"]];
                    }
                    $arResult["s_ico"] = "<img class='".$icoClass."' src='" . $img['src'] . "' alt='".$arItem["TEXT"]."'>";
                }
                elseif(!empty($arItem["ico_font"])){
                    $arResult["s_ico"] = "<i class='".$icoClass." bxr-font-".$arStyle["ico_1"]." fa fa-fw " . $arItem["ico_font"] . "' ></i>";
                }
                elseif($arParams["PICTURE_SECTION"] == "ICO_DEFAULT") {
                    $arResult["s_ico"] = "<i class='".$icoClass." bxr-font-".$arStyle["ico_1"]." fa fa-fw fa-angle-double-right' ></i>";
                }
            }
            
            return $arResult;
        }
    }
?>
<?
    $arStyle = array(
        "classUl" => "",
        "classTopLi" => "",
        "classLi" => "",
        "classLiSelected" => "",
        "classLiSelected2" => "",
        "ico_1" => (!empty($arParams['ICO_LEFT_MENU_COLOR_1'])) ? $arParams['ICO_LEFT_MENU_COLOR_1'] : "dark",
        "ico_2" => (!empty($arParams['ICO_LEFT_MENU_COLOR_2'])) ? $arParams['ICO_LEFT_MENU_COLOR_2'] : "light",
        "bigMode" => "N",
        "lightMode" => "N",
    );

    switch ($arParams['STYLE_MENU']) {
        case "colored_light": 
            $arStyle["classTopLi"] = "bxr-color-dark-flat";
            $arStyle["classLi"] = "bxr-bg-hover-flat";
            $arStyle["classLi2"] = "bxr-bg-hover-flat";
            $arStyle["classLiSelected"] = "bxr-color-flat";
            //$arStyle["classLiSelected2"] = "bxr-color-flat";
            break;
        case "colored_color":
            $arStyle["classUl"] = "bxr-color-flat";
            $arStyle["classTopLi"] = "bxr-color-dark-flat";
            $arStyle["classLi"] = "bxr-color-flat bxr-bg-hover-light-flat";
            $arStyle["classLi2"] = "bxr-color-flat bxr-bg-hover-light-flat";
            $arStyle["classLiSelected"] = "bxr-color-light-flat";
            //$arStyle["classLiSelected2"] = "bxr-color-light-flat";
            break;
        case "colored_dark": 
            $arStyle["classUl"] = "bxr-dark-flat";
            $arStyle["classTopLi"] = "bxr-dark-dark-flat";
            $arStyle["classLi"] = "bxr-dark-flat bxr-bg-hover bxr-bg-hover-flat";
            $arStyle["classLi2"] = "bxr-dark-flat bxr-bg-hover bxr-bg-hover-flat";
            $arStyle["classLiSelected"] = "bxr-color-flat";
            //$arStyle["classLiSelected2"] = "bxr-color-flat";
            break;
        case "colored_light_new":
            $arStyle["classLi"] = "colored-light-new bxr-children-color";
            $arStyle["classLi2"] = "bxr-children-color-hover";
            $arStyle["classLiSelected"] = "bxr-children-color";
            $arStyle["classLiPadding"] = "";
            $arStyle["classLiPadding2"] = "bxr-left-menu-hover-padding";
            break;
    }
    
    /*if (strripos($arParams['STYLE_MENU'], "_big") !== false) {
        $arStyle["bigMode"] = "Y";
        $arParams['STYLE_MENU'] = str_replace("_big", "", $arParams['STYLE_MENU']);
    }

    if (strripos($arParams['STYLE_MENU'], "_lighten") !== false) {
        $arStyle["lightMode"] = "Y";
        $arParams['STYLE_MENU'] = str_replace("_lighten", "", $arParams['STYLE_MENU']);
    }

    if($arStyle["bigMode"] == "Y")
        $arStyle["classUl"] .= " bxr-big-menu ";

    if($arStyle["lightMode"] == "Y")
        $arStyle["classUl"] .= " bxr-light-menu ";*/
        
    if(isset($arParams['SHOW_TOP']) &&  $arParams['SHOW_TOP']=="Y") {
        $arStyle["classLi"] .= " bxr-show-top ";
        $arStyle["classLi2"] .= " bxr-show-top ";
    }
    
    if($arParams['STYLE_MENU']=="colored_light")
        $arStyle["classUl"] .= " line-top ";
    
    
    if(isset($arParams['HOVER_MODAL_BACKDROP']) &&  $arParams['HOVER_MODAL_BACKDROP']=="Y")
        $arStyle["classUl"] .= " isModalBackdrop ";

?>
<nav>
    <ul class="<?=$arStyle["classUl"];?> bxr-left-menu-hover hidden-sm hidden-xs">
        <?if(isset($arParams["TITLE_MENU"]) && !empty($arParams["TITLE_MENU"])):?>
            <li class="top-element-js <?=$arStyle["classTopLi"];?> bxr-title-menu-hover"><?=$arParams["TITLE_MENU"];?></li>
        <?endif;?>
<?
        if(!function_exists('drawLeftMenu')) {
            function drawLeftMenu($arResult, $arStyle, $arParams, $lvl){

                global $APPLICATION;
                $hoverLeft = false;
                if(isset($arParams['HOVER_SHOW_LEFT']) &&  $arParams['HOVER_SHOW_LEFT']=="Y")
                    $hoverLeft = true;

                $section_has_children = false;
                $showPadding = false;

                foreach($arResult["TREE"] as $k => $arItem){
                    if($hoverLeft) {
                        if(isset($arItem["CHILDREN"])){
                            $arStyle["classLi"] .= " bxr-hover-menu-right";
                            $section_has_children = true;
                            break;
                        }
                    }
                    $ico = getIcon($arItem, $arStyle, $arParams);
                    if($ico["s_ico"]!="" || $ico["s_ico_h"]!=""){
                        $showPadding = true;
                    }
                }

                foreach($arResult["TREE"] as $k => $arItem):
                    ++$i;
                    $isChildren = false;
                    $glyphicon_right = "";
                    $glyphicon_left = '<span class="fa fa-circle-o"></span>';

                    if(isset($arItem["CHILDREN"])) {
                        $isChildren = true;
                        if($arItem["show_in"]!="Y" || $lvl>=2) {
                            if(!$hoverLeft)
                                $glyphicon_right = '<span class="fa fa-angle-right"></span>';

                            if($hoverLeft)
                                $glyphicon_left = '<span class="fa fa-angle-left"></span>';
                        }
                    }

                    if(!$section_has_children)
                        $glyphicon_left = "";
                    
                    /*if($arParams["CACHE_SELECTED_ITEMS"]===false && $arItem["LINK"]==$APPLICATION->GetCurDir()) {
                        $arItem['SELECTED'] = 1;
                    } */                  

                    $ico = getIcon($arItem, $arStyle, $arParams);?>
                    <li <?if($arItem['SELECTED'] == 1) echo "data-selected='1' ";?>  class="top-element-js <?=($showPadding && $ico["s_ico"]=="" && $ico["s_ico_h"]=="")? $arStyle["classLiPadding"] : "";?> <?=$arStyle["classLi"];?><?if($arItem['SELECTED'] == 1) echo " " . $arStyle["classLiSelected"];?>">
                        <a class="<?=$arStyle["classA"];?>" href="<?=$arItem["LINK"]?>"><?=$glyphicon_left;?><span class='111 bxr-ico-left-hover-menu'><?=$ico["s_ico"] . $ico["s_ico_h"]; ?></span><?=$arItem["TEXT"].$glyphicon_right;?></a>
                        <?
                            $hoverTemplate = "classic";
                            if(!empty($arParams["HOVER_TEMPLATE"]))
                                $hoverTemplate = $arParams["HOVER_TEMPLATE"];

                             if(!empty($arItem["hover"]))
                                $hoverTemplate = $arItem["hover"];
                        ?>
                        <?if($isChildren && ($arItem["show_in"]!="Y" || $lvl>=2)):?>
                            <?$APPLICATION->IncludeComponent(
                                "bxready.market2:menu.hover", 
                                $hoverTemplate, 
                                array(
                                        "PICTURE_SECTION" => $arParams['PICTURE_SECTION_HOVER'],
                                        "PICTURE_CATEGARIES" => $arParams['PICTURE_CATEGARIES'],
                                        "HOVER_MENU_COL_LG" => $arParams['HOVER_MENU_COL_LG'],
                                        "HOVER_MENU_COL_MD" => $arParams['HOVER_MENU_COL_MD'],
                                        "HOVER_MENU_COL_SM" => $arParams['HOVER_MENU_COL_SM'],
                                        "HOVER_MENU_COL_XS" => $arParams['HOVER_MENU_COL_XS'],
                                        "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                                        "CACHE_TIME" => $arParams['CACHE_TIME'],
                                        "MENU_TREE" => $arItem["CHILDREN"],
                                        "SHOW_TOP" => isset($arParams["SHOW_TOP"])? $arParams["SHOW_TOP"] : "N",
                                        "IMG" => $arItem["IMG"],
                                        "ICO_HOVER_MENU_COLOR_1" => $arParams['ICO_LEFT_MENU_HOVER_COLOR_1'], // dark // color
                                        "ICO_HOVER_MENU_COLOR_2" => $arParams['ICO_LEFT_MENU_HOVER_COLOR_2'],
                                        "STYLE_MENU" => "",
                                        "STYLE_MENU_HOVER" => $arParams["STYLE_MENU_HOVER"],
                                        
                                ),
                                false,
                                array("HIDE_ICONS" => "Y")
                            );?>
                        <?endif;?>                        
                    </li>
                    <?
                        if($isChildren && $arItem["show_in"]=="Y" && $lvl<2) {
                            $arResult["TREE"] = $arItem["CHILDREN"];
                            $arStyleNew = $arStyle;
                            $arStyleNew["classLi"] = $arStyle["classLi2"];
                            $arStyleNew["classLiPadding"] = $arStyle["classLiPadding2"];
                            echo drawLeftMenu($arResult, $arStyleNew, $arParams, ++$lvl);
                        }
                    ?>
                <?endforeach; 
            }
        }
        echo drawLeftMenu($arResult, $arStyle, $arParams, 1);?>
    </ul>
</nav>
<?endif;?>
<script>
    $(document).ready(function() {
        var obLeftMenu = new JCLeftMenu({
            
        });
    });
</script>

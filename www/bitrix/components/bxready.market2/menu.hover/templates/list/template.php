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

    $arResult["INCLUDE"] = array();

    if(file_exists($_SERVER["DOCUMENT_ROOT"].$templateFolder."/style.css"))
        $arResult["INCLUDE"]["CSS"] = $templateFolder."/style.css";

    if(file_exists($_SERVER["DOCUMENT_ROOT"].$templateFolder."/script.js"))
        $arResult["INCLUDE"]["JS"] = $templateFolder."/script.js";
    
    $this->__component->SetResultCacheKeys(array("INCLUDE"));

?>
<?
    $isIco = "N";
    if(!empty($arParams['PICTURE_SECTION']))
         $isIco = $arParams['PICTURE_SECTION'];
    
    $bIMG = "N";
    if(!empty($arParams['PICTURE_CATEGARIES']) && $arParams['PICTURE_CATEGARIES']!="N") {
        $bIMG = mb_strtolower($arParams['PICTURE_CATEGARIES']);
    }
        
    $bImgSrc = "";
    if(!empty($arParams['IMG']))
    {
        if(is_numeric($arParams['IMG'])) {
            $img = CFile::ResizeImageGet($arParams['IMG'], array('width'=>200, 'height'=>200), BX_RESIZE_IMAGE_PROPORTIONAL, true);
        }
        else {
           $img['src'] = $arParams['IMG'];                  
        }
        $bImgSrc = $img['src'];
    }
        
    $arColor['ico'] = "ico_color";
    
?>
<div data-bimgsrc="<?=$bImgSrc;?>" data-bimg="<?=$bIMG;?>" data-lg="<?if(!empty($arParams["HOVER_MENU_COL_LG"])) echo $arParams["HOVER_MENU_COL_LG"];?>" data-md="<?if(!empty($arParams["HOVER_MENU_COL_MD"])) echo $arParams["HOVER_MENU_COL_MD"];?>" data-sm="<?if(!empty($arParams["HOVER_MENU_COL_SM"])) echo $arParams["HOVER_MENU_COL_SM"];?>" data-xs="<?if(!empty($arParams["HOVER_MENU_COL_XS"])) echo $arParams["HOVER_MENU_COL_XS"];?>" class="col-w-lg-9 col-w-md-9  bxr-list-hover-menu <?if($arParams['COLOR_MENU'] == "light") {echo "menu-arrow-top";} ?>">
    <?foreach($arParams['MENU_TREE'] as $k1 => $v1): ?>
    <div class="bxr-element-hover-menu">
        <?if($isIco=="IMG"):?>
        <div class="bxr-element-image">            
            <?
                $s_ico = "";
               
                if(isset($v1["IMG"]) && !empty($v1["IMG"])) {
                    if(is_numeric($v1["IMG"])) {
                        $img = CFile::ResizeImageGet($v1["IMG"], array('width'=>82, 'height'=>82), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                    }
                    else {
                        $img['src'] = $v1["IMG"];                   
                    }
                    $s_ico = "<img src='" . $img['src'] . "' alt='".$v1["TEXT"]."'>";
                }
            ?>
            <?if($s_ico != ""):?>
                <a href="<?=$v1['LINK'];?>"><?=$s_ico;?></a>
            <?else:?>
                <!--<span>&nbsp;</span>-->
            <?endif;?>
	</div>
        <?endif;?>
        <div class="bxr-element-content">
            <div class="bxr-element-name bxr-children-color-hover">
                <?
                    $s_ico = "";
                    $s_ico_font = "";
					if($isIco != "N" /*&& $isIco != "IMG"*/) {
                        if(isset($v1[$arColor['ico']]) && !empty($v1[$arColor['ico']])) {
                            if(is_numeric($v1[$arColor['ico']])) {
                                $img = CFile::ResizeImageGet($v1[$arColor['ico']], array('width'=>18, 'height'=>18), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                            }
                            else {
                               $img['src'] = $v1[$arColor['ico']];                   
                            }
                            $s_ico = "<img class='bxr-ico-menu' src='" . $img['src'] . "' alt='".$v1["TEXT"]."'>";
                        }
                        elseif(!empty($v1["ico_font"])){
                            $s_ico_font = "<i class='bxr-ico-menu-fa fa fa-fw " . $v1["ico_font"] . "' ></i>";
                        }
                        elseif($isIco == "ICO_DEFAULT") {
                            $s_ico_font = "<i class='bxr-ico-menu-fa fa fa-fw fa-angle-double-right' ></i>";         
                        }
                    }
                ?>
                <?=$s_ico;?>
                <a href="<?=$v1['LINK'];?>"><?=$s_ico_font;?><?=$v1["TEXT"]?></a>
	    </div>
            <?if(isset($v1['CHILDREN'])):?>
                <div class="bxr-element-items">
                    <?foreach($v1['CHILDREN'] as $k2 => $v2): ?>
                    <span class="bxr-children-color-hover"><a href="<?=$v2['LINK'];?>"><?=$v2["TEXT"]?></a></span>
                    <?endforeach;?>
                </div>
            <?endif;?>   
        </div>
        <div class="bxr-clear"></div>
    </div>
    <?endforeach;?>
</div>
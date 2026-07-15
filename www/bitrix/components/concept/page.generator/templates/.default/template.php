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
<?ob_start();?>
<?//dump($arResult["SECTION"])?>
<?
global $Landing;
$Landing = $arResult["SECTION"];
?>

<input type="hidden" id="current_landing_id" name="current_landing_id" value="<?=$arResult["SECTION"]["ID"]?>" />
<?
global $admin_active;
global $show_setting;
global $USER;
global $h1;
global $DB_cham;
global $components;
global $img_quality;

$img_quality = $arResult["SECTION"]["UF_QUAL_IMAGES"];
$h1 = 0;
$components = 0;
$admin_active = $USER->isAdmin();
$show_setting = $arResult["SECTION"]["UF_CHAM_SHOW_EDIT"];
?>

<?
function hamButtonEditClass ($xml_id, $form_id = '', $modal_id='')
{
    $classes = '';

    if($xml_id == "form" && strlen($form_id)>0)
        $classes = 'call-modal callform';

    elseif($xml_id == "modal" && strlen($modal_id)>0)
        $classes = 'call-modal callmodal';

    elseif($xml_id == "block")
        $classes = 'scroll';

    elseif($xml_id == "quiz")
        $classes = 'call-wqec';


    return $classes;
}
?>
<?
function hamButtonEditAttr ($xml_id, $form_id = '', $modal_id = '', $link = '', $blank='', $header = '', $quiz_id = '', $arElement='')
{

    $attr = '';

    if($xml_id == "form" && strlen($form_id)>0)
    {
        $attr = 'data-header="'.$header.'" data-call-modal="form'.$form_id.'" data-element-id="'.$arElement.'"';
    }

    elseif($xml_id == "modal" && strlen($modal_id)>0)
        $attr = 'data-call-modal="modal'.$modal_id.'"';

    elseif($xml_id == "block" && strlen($link)>0)
        $attr = 'href = "#block'.$link.'"';

    elseif($xml_id == "blank" && strlen($link)>0)
        $attr = 'href = "'.$link.'" '.$blank;


    elseif($xml_id == "quiz")
        $attr = 'data-wqec-section-id="'.$quiz_id.'"';

 


    return $attr;
}
?>

<?function admin_setting($arItem, $center = false){?>

    <?global $admin_active;?>
    <?global $show_setting;?>

    <?if($admin_active && $show_setting == 1):?>

        <div class="tool-settings">
            <a href='/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=<?=$arItem['~IBLOCK_ID']?>&type=<?=$arItem['~IBLOCK_TYPE_ID']?>&ID=<?=$arItem['ID']?>&find_section_section=<?=$arItem['IBLOCK_SECTION_ID']?>&WF=Y' class="tool-settings <?if($center):?>in-center<?endif;?>" data-toggle="tooltip" target="_blank" data-placement="right" title="<?=GetMessage("PAGE_GENERATOR_EDIT")?> &quot;<?=TruncateText($arItem["NAME"], 35)?>&quot;"></a>

        </div>


    <?endif;?>
<?}
?>

<?function CreateSoc($arSection){?>

    <div class="socials">
    
        <?if(strlen($arSection["UF_CHAM_SOC_VK"])>0):?>
            <a target="_blank" href="<?=$arSection["UF_CHAM_SOC_VK"]?>" class="soc_ic soc_vk"><i class="concept-vkontakte"></i></a>
        <?endif;?>

        <?if(strlen($arSection["UF_CHAM_SOC_FB"])>0):?>
            <a target="_blank" href="<?=$arSection["UF_CHAM_SOC_FB"]?>" class="soc_ic soc_fb"><i class="concept-facebook-1"></i></a>
        <?endif;?>

        <?if(strlen($arSection["UF_CHAM_SOC_TW"])>0):?>
            <a target="_blank" href="<?=$arSection["UF_CHAM_SOC_TW"]?>" class="soc_ic soc_tw"><i class="concept-twitter-bird-1"></i></a>
        <?endif;?>

        <?if(strlen($arSection["UF_CHAM_SOC_YT"])>0):?>
            <a target="_blank" href="<?=$arSection["UF_CHAM_SOC_YT"]?>" class="soc_ic soc_yu"><i class="concept-youtube-play"></i></a>
        <?endif;?>

        <?if(strlen($arSection["UF_CHAM_SOC_IG"])>0):?>
            <a target="_blank" href="<?=$arSection["UF_CHAM_SOC_IG"]?>" class="soc_ic soc_ins"><i class="concept-instagram-4"></i></a>
        <?endif;?>

        <?if(strlen($arSection["UF_CHAM_SOC_TLG"])>0):?>
            <a target="_blank" href="<?=$arSection["UF_CHAM_SOC_TLG"]?>" class="soc_ic soc_tlg"><i class="concept-paper-plane"></i></a>
        <?endif;?>
        
    </div>

<?}?>

<?function CreateEmptyBlock($arSection){?>

    <div class="block light empty-block padding-on">
    
        <div class="shadow"></div>
     
        <div class="head def">
            
            <div class="container">
            
                <div class="no-margin-top-bot">
                
                    <h2 class="main1"><?=GetMessage("EMPTYBLOCK_TITLE")?></h2>

                    <div class="descrip"><?=GetMessage("EMPTYBLOCK_SUBTITLE")?></div>
                    
                    
                </div>

            </div>
            
        </div>
        
        <div class="content">

            <div class="container">
                <div class="row">
                    
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        
                        <div class="start-block">
                            
                            <div class="icon start1"></div>
                            
                            <div class="text"><?=GetMessage("EMPTYBLOCK_STEP1")?></div>
                            
                            <div class="button">
                                <a class="button-def primary big <?=$arSection["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?> hameleon-sets-open" data-open-set="edit-sets"><?=GetMessage("EMPTYBLOCK_BUTTON1")?></a>
                            </div>
                        
                        </div>
                        
                    </div>
                    
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 hidden-xs">
                       <div class="start-del"></div> 
                    </div>
                    
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        
                        <div class="start-block">
                            
                            <div class="icon start2"></div>
                            
                            <div class="text"><?=GetMessage("EMPTYBLOCK_STEP2")?></div>
                            
                            <div class="button">
                                <a class="button-def primary big <?=$arSection["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?>" target="_blank" href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=<?=$arSection["IBLOCK_ID"]?>&type=concept_hameleon&ID=0&lang=ru&IBLOCK_SECTION_ID=<?=$arSection["ID"]?>&find_section_section=<?=$arSection["ID"]?>&from=iblock_list_admin"><?=GetMessage("EMPTYBLOCK_BUTTON2")?></a>
                            </div>
                        
                        </div>
                        
                    </div>
                
                </div>
            </div>
            
        </div>

    </div>

<?}?>


<?function CreateFirstSlider($arSlider){?>

    <?
    global $Landing;   
    global $h1;
    global $header_bg_on;
    global $img_quality;
    ?>

    <div class="wrap-first-slider parent-scroll-down <?if($arSlider["ELEMENTS"][0]["PROPERTIES"]["FB_HEIGHT_WINDOW"]["VALUE"] == "Y"):?>min-height-block<?endif;?>">
        <?if(!$header_bg_on) echo "<div class='top-shadow'></div>";?>

        <div class="first-slider" id="block<?=$arSlider["ID"]?>">

            <?foreach($arSlider["ELEMENTS"] as $arItem):?>

                <?
                    global $USER;

                    $block_name = '';

                    if(strlen($arItem["PROPERTIES"]["HEADER"]["VALUE"]) > 0)
                        $block_name = $arItem["PROPERTIES"]["HEADER"]["~VALUE"];
                    else
                        $block_name = $arItem['~NAME'];

                    $block_name = htmlspecialcharsEx(strip_tags(html_entity_decode($block_name)));
                ?> 


                <div id="first_slider_<?=$arItem["ID"]?>" class="first-block <?=$arItem["PROPERTIES"]["SHADOW"]["VALUE_XML_ID"]?> <?if($arItem["PROPERTIES"]["HIDE_BLOCK"]["VALUE"] == "Y"):?> hidden-sm hidden-xs<?endif;?> <?if($arItem["PROPERTIES"]["HIDE_BLOCK_LG"]["VALUE"] == "Y"):?> hidden-lg hidden-md<?endif;?> <?if(strlen($arItem["PROPERTIES"]["VIDEO_BACKGROUND"]["VALUE"]) > 0):?>video-bg<?endif;?> <?=$arItem["PROPERTIES"]["COVER"]["VALUE_XML_ID"]?>" style="<?if(strlen($arItem["PREVIEW_PICTURE"]["SRC"]) > 0):?>background-image: url('<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>');<?endif;?> <?if(strlen($arItem["PROPERTIES"]["BACKGROUND_COLOR"]["VALUE"]) > 0):?>background-color: <?=$arItem["PROPERTIES"]["BACKGROUND_COLOR"]["VALUE"]?>;<?endif;?>">

                        

                    <?if(strlen($arItem["PROPERTIES"]["MARGIN_TOP_MOB"]["VALUE"])>0 || strlen($arItem["PROPERTIES"]["MARGIN_BOTTOM_MOB"]["VALUE"])>0 || strlen($arItem["PROPERTIES"]["PADDING_TOP_MOB"]["VALUE"])>0 || strlen($arItem["PROPERTIES"]["PADDING_BOTTOM_MOB"]["VALUE"])>0):?>

                        <style>
                            @media (max-width: 991px){
                                #first_slider_<?=$arItem["ID"]?>{
                                    <?if(strlen($arItem["PROPERTIES"]["MARGIN_TOP_MOB"]["VALUE"])>0):?>margin-top: <?=$arItem["PROPERTIES"]["MARGIN_TOP_MOB"]["VALUE"]?>px !important;<?endif;?>
                                    <?if(strlen($arItem["PROPERTIES"]["MARGIN_BOTTOM_MOB"]["VALUE"])>0):?>margin-bottom: <?=$arItem["PROPERTIES"]["MARGIN_BOTTOM_MOB"]["VALUE"]?>px !important;<?endif;?>
                                    <?if(strlen($arItem["PROPERTIES"]["PADDING_TOP_MOB"]["VALUE"])>0):?>padding-top: <?=$arItem["PROPERTIES"]["PADDING_TOP_MOB"]["VALUE"]?>px !important;<?endif;?>
                                    <?if(strlen($arItem["PROPERTIES"]["PADDING_BOTTOM_MOB"]["VALUE"])>0):?>padding-bottom: <?=$arItem["PROPERTIES"]["PADDING_BOTTOM_MOB"]["VALUE"]?>px !important;<?endif;?>
                                }
                            }
                        </style>

                    <?endif;?>

                    <?if(is_array($arItem["PROPERTIES"]["SLIDES"]["VALUE_XML_ID"]) && !empty($arItem["PROPERTIES"]["SLIDES"]["VALUE_XML_ID"])):?>
        
                        <?foreach($arItem["PROPERTIES"]["SLIDES"]["VALUE_XML_ID"] as $arSlID):?>
                            <?if($arSlID == 'top tb' || $arSlID == 'top bt') continue;?>
                            <div class="corner <?=$arSlID?> hidden-xs hidden-sm"></div>
                        <?endforeach;?>
                            
                    <?endif;?>

                    <?if(strlen($arItem["PROPERTIES"]["VIDEO_BACKGROUND"]["VALUE"]) > 0):?>

                        <?preg_match("/^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/",$arItem['PROPERTIES']['VIDEO_BACKGROUND']['~VALUE'],$out);?>
                        <div class="iframe-wrap">
                            <iframe class="video-bg" allowfullscreen="" frameborder="0" height="100%" src="https://www.youtube.com/embed/<?=$out[1]?>?rel=0&amp;mute=1&amp;controls=0&amp;loop=1&amp;showinfo=0&amp;autoplay=1&amp;playlist=<?=$out[1]?>" width="100%"></iframe>
                        </div>
                       
                    <?endif;?>

                    <div class="shadow"></div>
                
                    <div class="container">
                        <div class="row">

                            <div class="first-block-container <?=$arItem["PROPERTIES"]["FB_TEXT_COLOR"]["VALUE_XML_ID"]?>">
                                
                                <div class="first-block-cell text-part <?if($arItem["TWO_COLS"] == "Y"):?>col-lg-7 col-md-7 col-sm-8 col-xs-12 two-cols <?if($arItem["PROPERTIES"]["FB_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["FB_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "left"):?>col-lg-push-5 col-md-push-5 col-sm-push-4 col-xs-push-0 right<?endif;?><?else:?>col-lg-12 col-md-12 col-sm-12 col-xs-12<?endif;?>">
                                
                                    <div class="<?if($arItem["TWO_COLS"] == "Y"):?><?if($arItem["PROPERTIES"]["FB_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["FB_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "left"):?>wrap-padding-left<?else:?>wrap-padding-right<?endif;?><?endif;?>">
           
                                        <div class="head no-margin-top-bot <?if($arItem["TWO_COLS"] == "Y"):?>min left<?endif;?> <?=$arItem["PROPERTIES"]["TITLE_SHADOW"]["VALUE_XML_ID"]?> <?=$animate;?> <?=$arItem["PROPERTIES"]["SUBTITLE_SHADOW"]["VALUE_XML_ID"]?>">

                                            <?if(strlen($arItem["PROPERTIES"]["TITLE_SIZE"]["VALUE"])>0 || strlen($arItem["PROPERTIES"]["SUBTITLE_SIZE"]["VALUE"])>0 || strlen($arItem["PROPERTIES"]["TITLE_SIZE_MOB"]["VALUE"])>0 || strlen($arItem["PROPERTIES"]["SUBTITLE_SIZE_MOB"]["VALUE"])>0):?>

                                                <style>
                                                    <?if(strlen($arItem["PROPERTIES"]["TITLE_SIZE"]["VALUE"])>0 || strlen($arItem["PROPERTIES"]["SUBTITLE_SIZE"]["VALUE"])>0):?>
                                                        @media (min-width: 992px){

                                                            <?if(strlen($arItem["PROPERTIES"]["TITLE_SIZE"]["VALUE"])>0):?>
                                                                #first_slider_<?=$arItem["ID"]?> div.head div.title, #first_slider_<?=$arItem["ID"]?> div.head h1, #first_slider_<?=$arItem["ID"]?> div.head h2{
                                                                    <?if(strlen($arItem["PROPERTIES"]["TITLE_SIZE"]["VALUE"])>0):?>font-size: <?=$arItem["PROPERTIES"]["TITLE_SIZE"]["VALUE"]?>px !important;<?endif;?>

                                                                    <?
                                                                        $line_height_tit = intval($arItem["PROPERTIES"]["TITLE_SIZE"]["VALUE"]) + 5;
                                                                        if(strlen($arItem["PROPERTIES"]["TITLE_SIZE"]["DESCRIPTION"])>0)
                                                                            $line_height_tit = $arItem["PROPERTIES"]["TITLE_SIZE"]["DESCRIPTION"];
                                                                    ?>
                                                                    line-height: <?=$line_height_tit?>px !important;
                                                                }
                                                            <?endif;?>

                                                            <?if(strlen($arItem["PROPERTIES"]["SUBTITLE_SIZE"]["VALUE"])>0):?>
                                                                #first_slider_<?=$arItem["ID"]?> div.head .subtitle{
                                                                    <?if(strlen($arItem["PROPERTIES"]["SUBTITLE_SIZE"]["VALUE"])>0):?>font-size: <?=$arItem["PROPERTIES"]["SUBTITLE_SIZE"]["VALUE"]?>px !important;<?endif;?>
                                                                    <?
                                                                        $line_height_sub = intval($arItem["PROPERTIES"]["SUBTITLE_SIZE"]["VALUE"]) + 3;
                                                                        if(strlen($arItem["PROPERTIES"]["SUBTITLE_SIZE"]["DESCRIPTION"])>0)
                                                                            $line_height_sub = $arItem["PROPERTIES"]["SUBTITLE_SIZE"]["DESCRIPTION"];
                                                                    ?>
                                                                    line-height: <?=$line_height_sub?>px !important;
                                                                }
                                                            <?endif;?>
                                                        }

                                                    <?endif;?>

                                                    <?if(strlen($arItem["PROPERTIES"]["TITLE_SIZE_MOB"]["VALUE"]) > 0 || strlen($arItem["PROPERTIES"]["SUBTITLE_SIZE_MOB"]["VALUE"]) > 0):?>
                                                        @media (max-width: 991px){

                                                            <?if(strlen($arItem["PROPERTIES"]["TITLE_SIZE_MOB"]["VALUE"]) > 0):?>
                                                                #first_slider_<?=$arItem["ID"]?> div.head div.title, #first_slider_<?=$arItem["ID"]?> div.head h1, #first_slider_<?=$arItem["ID"]?> div.head h2{
                                                                    <?if(strlen($arItem["PROPERTIES"]["TITLE_SIZE_MOB"]["VALUE"])>0):?>font-size: <?=$arItem["PROPERTIES"]["TITLE_SIZE_MOB"]["VALUE"]?>px !important;<?endif;?>
                                                                    <?
                                                                        $line_height_tit_mob = intval($arItem["PROPERTIES"]["TITLE_SIZE_MOB"]["VALUE"]) + 5;
                                                                        if(strlen($arItem["PROPERTIES"]["TITLE_SIZE_MOB"]["DESCRIPTION"])>0)
                                                                            $line_height_tit_mob = $arItem["PROPERTIES"]["TITLE_SIZE_MOB"]["DESCRIPTION"];
                                                                    ?>
                                                                    line-height: <?=$line_height_tit_mob?>px !important;
                                                                }
                                                            <?endif;?>

                                                            <?if(strlen($arItem["PROPERTIES"]["SUBTITLE_SIZE_MOB"]["VALUE"]) > 0):?>
                                                                #first_slider_<?=$arItem["ID"]?> div.head .subtitle{
                                                                    <?if(strlen($arItem["PROPERTIES"]["SUBTITLE_SIZE_MOB"]["VALUE"])>0):?>font-size: <?=$arItem["PROPERTIES"]["SUBTITLE_SIZE_MOB"]["VALUE"]?>px !important;<?endif;?>
                                                                    <?
                                                                        $line_height_sub_mob = intval($arItem["PROPERTIES"]["SUBTITLE_SIZE_MOB"]["VALUE"]) + 3;
                                                                        if(strlen($arItem["PROPERTIES"]["SUBTITLE_SIZE_MOB"]["DESCRIPTION"])>0)
                                                                            $line_height_sub_mob = $arItem["PROPERTIES"]["SUBTITLE_SIZE_MOB"]["DESCRIPTION"];
                                                                    ?>
                                                                    line-height: <?=$line_height_sub_mob?>px !important;
                                                                }
                                                            <?endif;?>

                                                        }
                                                    <?endif;?>
                                                </style>

                                            <?endif;?>
                                            
                                            <?if(strlen($arItem["PROPERTIES"]["HEADER"]["VALUE"]) > 0):?>
                                                    
                                                <?
                                                    $tit = Array();
                                                    $title = Array();

                                                    if(substr_count($arItem["PROPERTIES"]["HEADER"]["VALUE"], "{") > 0 && substr_count($arItem["PROPERTIES"]["HEADER"]["VALUE"], "}") > 0)
                                                    {
                                                        $tit = explode("{", $arItem["PROPERTIES"]["HEADER"]["VALUE"]);
                                                        $title[] = $tit[0];
                                                        $tit = $tit[1];
                                                        
                                                        $tit = explode("}", $tit);
                                                        $title[] = $tit[1];
                                                        $tit = $tit[0];

                                                        $tit = explode("|", $tit);
                                                        
                                                    }
                                                ?>
                                            
                                                <div class="title main1 <?=$arItem["PROPERTIES"]["HEADER_COLOR"]["VALUE_XML_ID"]?>" <?if(strlen($arItem["PROPERTIES"]["TITLE_COLOR"]["VALUE"])>0):?> style="color: <?=$arItem["PROPERTIES"]["TITLE_COLOR"]["VALUE"]?>;"<?endif;?>>

                                                    <?$h1_close = 0;?>
                                                    
                                                    <?if($arItem["PROPERTIES"]["THIS_H1"]["VALUE"] == "Y" && $h1 == 0):?>
                                                        <h1>
                                                        
                                                        <?$h1 = 1;?>
                                                        <?$h1_close = 1;?>
                                                    <?endif;?>
                                                
                                                    <?if(!empty($tit)):?>
                                                        <?=htmlspecialcharsBack($title[0])?><span class="typed"></span><?=htmlspecialcharsBack($title[1])?>
                                                    <?else:?>
                                                        <?=$arItem["PROPERTIES"]["HEADER"]["~VALUE"]?>
                                                    <?endif;?>
                                                    
                                                    <?if($arItem["PROPERTIES"]["THIS_H1"]["VALUE"] == "Y" && $h1_close == 1):?>
                                                        </h1>
                                                    <?endif;?>
                                                
                                                                                                    
                                                </div>
                                                
                                                <?if(!empty($tit)):?>
                    
                                                    <script>
                                                        $(document).ready(
                                                            function(){
                                                            $("div#block<?=$arItem["ID"]?> div.title span.typed").typed({
                                                                strings: ["<?=implode('","', $tit)?>"],
                                                                typeSpeed: 50,
                                                                startDelay: 3000,
                                                                backDelay: 2000,
                                                            });
                                                        });
                                                    </script>
                                                
                                                <?endif;?>
                                            
                                            <?endif;?>
                                            
                                            <?if(strlen($arItem["PROPERTIES"]["SUBHEADER"]["VALUE"]) > 0):?>
                                            
                                                
                                                <?

                                                $tit = Array();
                                                $title = Array();
                                                if(substr_count($arItem["PROPERTIES"]["SUBHEADER"]["VALUE"], "{") > 0 && substr_count($arItem["PROPERTIES"]["SUBHEADER"]["VALUE"], "}") > 0)
                                                {
                                                    $tit = explode("{", $arItem["PROPERTIES"]["SUBHEADER"]["VALUE"]);
                                                    $title[] = $tit[0];
                                                    $tit = $tit[1];
                                                    
                                                    $tit = explode("}", $tit);
                                                    $title[] = $tit[1];
                                                    $tit = $tit[0];
                                                                                                                
                                                    $tit = explode("|", $tit);
                                                    
                                                }
                                                ?>
                                            
                                                <div class="subtitle <?=$arItem["PROPERTIES"]["HEADER_COLOR"]["VALUE_XML_ID"]?>" <?if(strlen($arItem["PROPERTIES"]["SUBTITLE_COLOR"]["VALUE"])>0):?> style="color: <?=$arItem["PROPERTIES"]["SUBTITLE_COLOR"]["VALUE"]?>;"<?endif;?>>
                                                
                                                    <?if(!empty($tit)):?>
                                                        <?=htmlspecialcharsBack($title[0])?><span class="typed"></span><?=htmlspecialcharsBack($title[1])?>
                                                    <?else:?>
                                                        <?=$arItem["PROPERTIES"]["SUBHEADER"]["~VALUE"]?>
                                                    <?endif;?>
                                                
                                                </div>
                                                
                                                <?if(!empty($tit)):?>
                    
                                                    <script>
                                                        $(document).ready(
                                                            function(){
                                                            $("div#block<?=$arItem["ID"]?> div.subtitle span.typed").typed({
                                                                strings: ["<?=implode('","', $tit)?>"],
                                                                typeSpeed: 50,
                                                                startDelay: 3000,
                                                                backDelay: 2000,
                                                            });
                                                        });
                                                    </script>
                                                
                                                <?endif;?>
                                                
                                            <?endif;?>

                                            <?if($arItem["PROPERTIES"]["FB_VIEW"]["VALUE_XML_ID"] == "icons" || $arItem["PROPERTIES"]["FB_VIEW"]["VALUE_XML_ID"] == "mixed"):?>
                                                
                                                <div class="icons row">
                                                    <?
                                                        $class = "";
                                                        if($arItem["TWO_COLS"] == "Y")
                                                            $class = "col-lg-6 col-md-6 col-sm-6 col-xs-12 min";
                                                        else
                                                        {
                                                            if($arItem["ICONS_MAX"] <= 3)
                                                                $class = "col-lg-4 col-md-4 col-sm-4 col-xs-6";

                                                            else
                                                                $class = "col-lg-3 col-md-3 col-sm-6 col-xs-6";
                                                        }
                                                    ?>

                                                    <?for($i = 0; $i < $arItem["ICONS_MAX"]; $i++):?>
                                                    
                                                        <?if($i > 3) continue;?>
                                                    
                                                        <div class="<?=$class?> element">
                                                            
                                                            <div class="icon">
                                                                
                                                                <?if($arItem["ICONS_COUNT"] > 0):?>
                                                            
                                                                    <div class="image-table">
                                                                        <div class="image-cell">
                                                                        
                                                                            <?if($arItem["PROPERTIES"]["FB_ICONS"]["VALUE"][$i] > 0):?>
                                                                                <?$file = CFile::ResizeImageGet($arItem["PROPERTIES"]["FB_ICONS"]["VALUE"][$i], array('width'=>200, 'height'=>200), BX_RESIZE_IMAGE_PROPORTIONAL, false, false, false, $img_quality);?>
                                                                                <img alt="" class="img-responsive" src="<?=$file["src"]?>" />
                                                                            <?endif;?>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                
                                                                <?endif;?>
                                                                
                                                                <?if($arItem["ICONS_DESC_COUNT"] > 0):?>
                                                                
                                                                    <div class="text-wrap no-margin-top-bot">
                                                                        <div class="text">
                                                                            <?=$arItem["PROPERTIES"]["FB_ICONS_DESC"]["~VALUE"][$i]?>
                                                                        </div>
                                                                    </div>
                                                                
                                                                <?endif;?>
                                                            </div>
                                                        </div>

                                                        <?
                                                            if($arItem["TWO_COLS"] == "Y")
                                                            {
                                                                if(($i+1)%2 == 0)
                                                                    echo "<div class='clearfix'></div>";
                                                            }

                                                            else
                                                            {
                                                                if($arItem["ICONS_MAX"] <= 3)
                                                                {
                                                                    if(($i+1)%2 == 0)
                                                                        echo "<div class='clearfix visible-xs'></div>";

                                                                    if(($i+1)%3 == 0)
                                                                        echo "<div class='clearfix hidden-xs'></div>";
                                                                }
                                                                else
                                                                {
                                                                    if(($i+1)%2 == 0)
                                                                        echo "<div class='clearfix visible-sm visible-xs'></div>";

                                                                    if(($i+1)%4 == 0)
                                                                        echo "<div class='clearfix hidden-sm hidden-xs'></div>";
                                                                }
                                                            }
                                                        ?>                                                        
                                                    <?endfor;?>                                                        
                                                </div>
                                                
                                            <?endif;?>
                                            
                                            <?if($arItem["PROPERTIES"]["FB_VIEW"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["FB_VIEW"]["VALUE_XML_ID"] == "buttons" || $arItem["PROPERTIES"]["FB_VIEW"]["VALUE_XML_ID"] == "mixed"):?>
            
                                                <div class="buttons <?if($arItem["TWO_COLS"] == "Y"):?>row<?else:?> no-image<?endif;?> clearfix <?if(strlen($arItem["PROPERTIES"]["FB_LB_NAME"]["VALUE"])>0):?> left-button-on<?endif;?><?if(strlen($arItem["PROPERTIES"]["FB_RB_NAME"]["VALUE"])>0):?> right-button-on<?endif;?><?if(strlen($arItem["PROPERTIES"]["FB_VIDEO_LINK"]["VALUE"])>0):?> video-button-on<?endif;?> <?=$arItem["PROPERTIES"]["FB_VIEW"]["VALUE_XML_ID"]?>">
                                                    
                                                    <?if($arItem["TWO_COLS"] != "Y"):?>
                                                                                                      
                                                        <?/*if($arItem["BUTTONS_COUNT"] == 1):?>
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"></div>
                                                        <?endif;*/?>
                                                        
                                                        <?if($arItem["BUTTONS_COUNT"] == 2):?>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"></div>
                                                        <?endif;?>
        
                                                    <?endif;?>
                                                    
                                                    <?if(strlen($arItem["PROPERTIES"]["FB_LB_TYPE"]["VALUE_XML_ID"]) <= 0):?>
                                                        <?$arItem["PROPERTIES"]["FB_LB_TYPE"]["VALUE_XML_ID"] = "form";?>
                                                    <?endif;?>
                                                    
                                                    <?if(strlen($arItem["PROPERTIES"]["FB_LB_NAME"]["VALUE"]) > 0 && $arItem["PROPERTIES"]["FB_LB_TYPE"]["VALUE_XML_ID"] != ""):?>
                                                    
                                                        <div class="<?if($arItem["TWO_COLS"] == "Y"):?>col-lg-6 col-md-6 col-sm-6 col-xs-12<?else:?><?if($arItem["BUTTONS_COUNT"] == 1):?> col-lg-12 col-md-12 col-sm-12 col-xs-12<?else:?> col-lg-4 col-md-4 col-sm-4 col-xs-12<?endif;?><?endif;?>">
                                                            <div class="">
                                                            
                                                                <div class="button left">

                                                                    <a <?if(strlen($arItem["PROPERTIES"]["FB_LB_ONCLICK"]["VALUE"])>0) echo "onclick='".$arItem["PROPERTIES"]["FB_LB_ONCLICK"]["VALUE"]."'";?> class="button-def <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?> <?if($arItem["PROPERTIES"]["FB_LB_VIEW"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["FB_LB_VIEW"]["VALUE_XML_ID"] == "solid"):?> primary <?elseif($arItem["PROPERTIES"]["FB_LB_VIEW"]["VALUE_XML_ID"] == "shine"):?> shine primary <?else:?>secondary<?endif;?> <?=hamButtonEditClass($arItem["PROPERTIES"]["FB_LB_TYPE"]["VALUE_XML_ID"], $arItem["PROPERTIES"]["FB_LB_FORM"]["VALUE"], $arItem["PROPERTIES"]["FB_LB_MODAL"]["VALUE"])?>" <?=hamButtonEditAttr($arItem["PROPERTIES"]["FB_LB_TYPE"]["VALUE_XML_ID"], $arItem["PROPERTIES"]["FB_LB_FORM"]["VALUE"], $arItem["PROPERTIES"]["FB_LB_MODAL"]["VALUE"], $arItem["PROPERTIES"]["FB_LB_LINK"]["VALUE"], $arItem["PROPERTIES"]["FB_LB_BUTTON_BLANK"]["VALUE_XML_ID"], $block_name, $arItem["PROPERTIES"]["FB_LB_QUIZ"]["VALUE"])?>><?=$arItem["PROPERTIES"]["FB_LB_NAME"]["~VALUE"]?></a>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    
                                                    <?endif;?>
                                                    
                                                    <?if(strlen($arItem["PROPERTIES"]["FB_VIDEO_LINK"]["VALUE"]) > 0):?>
              
                                                        <div class="<?if($arItem["TWO_COLS"] == "Y"):?>col-lg-6 col-md-6 col-sm-6 col-xs-12<?else:?><?if($arItem["BUTTONS_COUNT"] == 1):?> col-lg-12 col-md-12 col-sm-12 col-xs-12<?else:?> col-lg-4 col-md-4 col-sm-4 col-xs-12<?endif;?><?endif;?>">
                                                            <div class="">

                                                            <?preg_match("/^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/",$arItem['PROPERTIES']['FB_VIDEO_LINK']['~VALUE'],$out);?>
                                                                <a class="link-video call-modal callvideo" data-call-modal="<?=$out[1]?>">
                                                                    <div class="video-cont">
                                                                        <div class="video">
                                                                        
                                                                            <div class="play-button"></div>
                                                                            <table>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="video-name"><?=$arItem["PROPERTIES"]["FB_VIDEO_NAME"]["~VALUE"]?></div>
                                                                                        <div class="video-comm"><?=$arItem["PROPERTIES"]["FB_VIDEO_COMMENT"]["~VALUE"]?></div>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                            
                                                                        </div> 
                                                                    </div>
                                                                </a>
                                                                
                                                            </div>
                                                        </div>
                                                    
                                                    <?endif;?>
                                                    
                                                    
                                                    <?if(strlen($arItem["PROPERTIES"]["FB_RB_TYPE"]["VALUE_XML_ID"]) <= 0)
                                                        $arItem["PROPERTIES"]["FB_RB_TYPE"]["VALUE_XML_ID"] = "form";?>
                                          
                                                    
                                                    <?if(strlen($arItem["PROPERTIES"]["FB_RB_NAME"]["VALUE"]) > 0 && $arItem["PROPERTIES"]["FB_RB_TYPE"]["VALUE_XML_ID"] != ""):?>
                                                    
                                                        <?if($arItem["BUTTONS_COUNT"] == 3 && $arItem["TWO_COLS"] == "Y"):?>
                                                            <span class="clearfix"></span>
                                                        <?endif;?>
                                                    
                                                        <div class="<?if($arItem["TWO_COLS"] == "Y"):?>col-lg-6 col-md-6 col-sm-6 col-xs-12<?else:?><?if($arItem["BUTTONS_COUNT"] == 1):?>col-lg-12 col-md-12 col-sm-12 col-xs-12<?else:?>col-lg-4 col-md-4 col-sm-4 col-xs-12<?endif;?><?endif;?>">
                                                        
                                                            <div class="button right">
                                                                <a <?if(strlen($arItem["PROPERTIES"]["FB_RB_ONCLICK"]["VALUE"])>0) echo "onclick='".$arItem["PROPERTIES"]["FB_RB_ONCLICK"]["VALUE"]."'";?> class="button-def <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?> <?if($arItem["PROPERTIES"]["FB_RB_VIEW"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["FB_RB_VIEW"]["VALUE_XML_ID"] == "solid"):?> primary <?elseif($arItem["PROPERTIES"]["FB_RB_VIEW"]["VALUE_XML_ID"] == "shine"):?> shine primary <?else:?> secondary <?endif;?> <?=hamButtonEditClass ($arItem["PROPERTIES"]["FB_RB_TYPE"]["VALUE_XML_ID"], $arItem["PROPERTIES"]["FB_RB_FORM"]["VALUE"], $arItem["PROPERTIES"]["FB_RB_MODAL"]["VALUE"])?>" <?=hamButtonEditAttr ($arItem["PROPERTIES"]["FB_RB_TYPE"]["VALUE_XML_ID"], $arItem["PROPERTIES"]["FB_RB_FORM"]["VALUE"], $arItem["PROPERTIES"]["FB_RB_MODAL"]["VALUE"], $arItem["PROPERTIES"]["FB_RB_LINK"]["VALUE"], $arItem["PROPERTIES"]["FB_RB_BUTTON_BLANK"]["VALUE_XML_ID"], $block_name, $arItem["PROPERTIES"]["FB_RB_QUIZ"]["VALUE"])?>><?=$arItem["PROPERTIES"]["FB_RB_NAME"]["~VALUE"]?></a>
                                                            </div>

                                                        </div>
                                                    
                                                    <?endif;?>
                                                    
                                                </div>
                                            
                                            <?endif;?>

                                        </div>
                                    
                                    </div>
                                    
                                </div>
                                
                                <?if($arItem["TWO_COLS"] == "Y"):?>
                                
                                    <div class="first-block-cell image-part hidden-xs col-lg-5 col-md-5 col-sm-4 col-xs-12 <?if($arItem["PROPERTIES"]["FB_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["FB_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "left"):?>col-lg-pull-7 col-md-pull-7 col-sm-pull-8 col-xs-pull-0<?endif;?> <?=$arItem["PROPERTIES"]["FB_IMAGE_POSITION"]["VALUE_XML_ID"]?>">
                                        
                                        <?$file = CFile::ResizeImageGet($arItem["PROPERTIES"]["FB_ADD_PICTURE"]["VALUE"], array('width'=>800, 'height'=>800), BX_RESIZE_IMAGE_PROPORTIONAL, false, false, false, 60);?>
                                        <img src="<?=$file["src"]?>" class="img-responsive center-block" />
                                        
                                    </div>
                                
                                <?endif;?>
                                
                            </div>

                        </div>
                    </div>


                    <?if($arItem["PROPERTIES"]["FB_CLICK_DOWN"]["VALUE"] == "Y"):?>
                        <div class="wrap-down hidden-xs">
                            <div class="down-scroll">
                                <i class="fa fa-chevron-down"></i>
                            </div>
                        </div>
                    <?endif;?>

                    <?admin_setting($arItem, true)?>

                </div>

            <?endforeach;?>

        </div>

        <?if($Landing["UF_CHAM_SLIDER_TIME"] > 0):?>
    
            <script type="text/javascript">
                
                $(window).load(
                    function()
                    {
                        $('.first-slider').slick('slickSetOption', 'autoplaySpeed', '<?=$Landing["UF_CHAM_SLIDER_TIME"]*1000?>');
                        $('.first-slider').slick('slickPlay');
                    }
                );
                
            </script>

        <?endif;?>
    </div>
    
<?}?>


<?function CreateHead($arItem, $min = false, $main_key){?>

    <?global $h1;?>

    <?if(strlen($arItem["PROPERTIES"]["HEADER"]["VALUE"]) > 0 || strlen($arItem["PROPERTIES"]["SUBHEADER"]["VALUE"]) > 0):?>

        <?
            $animate = '';
            $animate_set = '';

            if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y")
            {
                $animate = 'wow fadeInDown';
                $animate_set = 'data-wow-offset="250" data-wow-duration="0.5s" data-wow-delay="0.2s"';
            }

            if($arItem["PROPERTIES"]["MAIN_TITLE_POS"]["VALUE_XML_ID"] == "")
                $arItem["PROPERTIES"]["MAIN_TITLE_POS"]["VALUE_XML_ID"] = "def";
        ?>

        <?if(strlen($arItem["PROPERTIES"]["TITLE_SIZE"]["VALUE"])>0 || strlen($arItem["PROPERTIES"]["SUBTITLE_SIZE"]["VALUE"])>0 || strlen($arItem["PROPERTIES"]["TITLE_SIZE_MOB"]["VALUE"])>0 || strlen($arItem["PROPERTIES"]["SUBTITLE_SIZE_MOB"]["VALUE"])>0):?>

            <style>

                <?if(strlen($arItem["PROPERTIES"]["TITLE_SIZE"]["VALUE"])>0 || strlen($arItem["PROPERTIES"]["SUBTITLE_SIZE"]["VALUE"])>0):?>

                    @media (min-width: 992px){

                        <?if(strlen($arItem["PROPERTIES"]["TITLE_SIZE"]["VALUE"])>0):?>
                            #block<?=$arItem["ID"]?> div.head h1, #block<?=$arItem["ID"]?> div.head h2{
                                <?if(strlen($arItem["PROPERTIES"]["TITLE_SIZE"]["VALUE"])>0):?>font-size: <?=$arItem["PROPERTIES"]["TITLE_SIZE"]["VALUE"]?>px !important;<?endif;?>
                                <?
                                    $line_height_tit = intval($arItem["PROPERTIES"]["TITLE_SIZE"]["VALUE"]) + 5;
                                    if(strlen($arItem["PROPERTIES"]["TITLE_SIZE"]["DESCRIPTION"])>0)
                                        $line_height_tit = $arItem["PROPERTIES"]["TITLE_SIZE"]["DESCRIPTION"];
                                ?>
                                line-height: <?=$line_height_tit?>px !important;
                            }
                        <?endif;?>

                        <?if(strlen($arItem["PROPERTIES"]["SUBTITLE_SIZE"]["VALUE"])>0):?>
                            #block<?=$arItem["ID"]?> div.head .descrip, #first_slider_<?=$arItem["ID"]?> div.head .subtitle{
                                <?if(strlen($arItem["PROPERTIES"]["SUBTITLE_SIZE"]["VALUE"])>0):?>font-size: <?=$arItem["PROPERTIES"]["SUBTITLE_SIZE"]["VALUE"]?>px !important;<?endif;?>
                                <?
                                    $line_height_sub = intval($arItem["PROPERTIES"]["SUBTITLE_SIZE"]["VALUE"]) + 3;
                                    if(strlen($arItem["PROPERTIES"]["SUBTITLE_SIZE"]["DESCRIPTION"])>0)
                                        $line_height_sub = $arItem["PROPERTIES"]["SUBTITLE_SIZE"]["DESCRIPTION"];
                                ?>
                                line-height: <?=$line_height_sub?>px !important;
                            }
                        <?endif;?>

                    }

                <?endif;?>

                <?if(strlen($arItem["PROPERTIES"]["TITLE_SIZE_MOB"]["VALUE"])>0 || strlen($arItem["PROPERTIES"]["SUBTITLE_SIZE_MOB"]["VALUE"])>0):?>
                    @media (max-width: 991px){

                        <?if(strlen($arItem["PROPERTIES"]["TITLE_SIZE_MOB"]["VALUE"])>0):?>
                            #block<?=$arItem["ID"]?> div.head h1, #block<?=$arItem["ID"]?> div.head h2{
                                <?if(strlen($arItem["PROPERTIES"]["TITLE_SIZE_MOB"]["VALUE"])>0):?>font-size: <?=$arItem["PROPERTIES"]["TITLE_SIZE_MOB"]["VALUE"]?>px !important;<?endif;?>
                                <?
                                    $line_height_tit_mob = intval($arItem["PROPERTIES"]["TITLE_SIZE_MOB"]["VALUE"]) + 5;
                                    if(strlen($arItem["PROPERTIES"]["TITLE_SIZE_MOB"]["DESCRIPTION"])>0)
                                        $line_height_tit_mob = $arItem["PROPERTIES"]["TITLE_SIZE_MOB"]["DESCRIPTION"];
                                ?>
                                line-height: <?=$line_height_tit_mob?>px !important;
                            }
                        <?endif;?>

                        <?if(strlen($arItem["PROPERTIES"]["SUBTITLE_SIZE_MOB"]["VALUE"])>0):?>
                            #block<?=$arItem["ID"]?> div.head .descrip, #first_slider_<?=$arItem["ID"]?> div.head .subtitle{
                                <?if(strlen($arItem["PROPERTIES"]["SUBTITLE_SIZE_MOB"]["VALUE"])>0):?>font-size: <?=$arItem["PROPERTIES"]["SUBTITLE_SIZE_MOB"]["VALUE"]?>px !important;<?endif;?>
                                <?
                                    $line_height_sub_mob = intval($arItem["PROPERTIES"]["SUBTITLE_SIZE_MOB"]["VALUE"]) + 3;
                                    if(strlen($arItem["PROPERTIES"]["SUBTITLE_SIZE_MOB"]["DESCRIPTION"])>0)
                                        $line_height_sub_mob = $arItem["PROPERTIES"]["SUBTITLE_SIZE_MOB"]["DESCRIPTION"];
                                ?>
                                line-height: <?=$line_height_sub_mob?>px !important;
                            }
                        <?endif;?>
                    }

                <?endif;?>

            </style>

        <?endif;?>

        <div class="head <?if($min):?>min<?endif;?> <?=$animate?> <?=$arItem["PROPERTIES"]["MAIN_TITLE_POS"]["VALUE_XML_ID"]?> <?=$arItem["PROPERTIES"]["TITLE_SHADOW"]["VALUE_XML_ID"]?>  <?=$arItem["PROPERTIES"]["SUBTITLE_SHADOW"]["VALUE_XML_ID"]?>" <?=$animate_set?>>
        
            <?if(!$min):?>
                <div class="container">
            <?endif;?>
            
            <div class="no-margin-top-bot">
            
                <?if(strlen($arItem["PROPERTIES"]["HEADER"]["VALUE"]) > 0):?>
                
                    <?
                        $tit = Array();
                        $title = Array();

                        if(substr_count($arItem["PROPERTIES"]["HEADER"]["VALUE"], "{") > 0 && substr_count($arItem["PROPERTIES"]["HEADER"]["VALUE"], "}") > 0)
                        {
                            $tit = explode("{", $arItem["PROPERTIES"]["HEADER"]["VALUE"]);
                            $title[] = $tit[0];
                            $tit = $tit[1];
                            
                            $tit = explode("}", $tit);
                            $title[] = $tit[1];
                            $tit = $tit[0];
                            
                            $tit = explode("|", $tit);
                            
                        }

                        $h1_close = 0;

                    ?>

                    <?if($arItem["PROPERTIES"]["THIS_H1"]["VALUE"] == "Y" && $h1 == 0):?>
                        <h1 class="main1 <?=$arItem["PROPERTIES"]["HEADER_COLOR"]["VALUE_XML_ID"]?>" <?if(strlen($arItem["PROPERTIES"]["TITLE_COLOR"]["VALUE"])>0):?> style="color: <?=$arItem["PROPERTIES"]["TITLE_COLOR"]["VALUE"]?>;"<?endif;?>>
                        <?
                            $h1 = 1;
                            $h1_close = 1;
                        ?>
                    <?else:?>

                        <h2 class="main1 <?=$arItem["PROPERTIES"]["HEADER_COLOR"]["VALUE_XML_ID"]?>" <?if(strlen($arItem["PROPERTIES"]["TITLE_COLOR"]["VALUE"])>0):?> style="color: <?=$arItem["PROPERTIES"]["TITLE_COLOR"]["VALUE"]?>;"<?endif;?>>

                    <?endif;?>
                        
                    <?if(!empty($tit)):?>
                        <?=htmlspecialcharsBack($title[0])?><span class="typed"></span><?=htmlspecialcharsBack($title[1])?>
                    <?else:?>
                        <?=$arItem["PROPERTIES"]["HEADER"]["~VALUE"]?>
                    <?endif;?>

                    <?if($arItem["PROPERTIES"]["THIS_H1"]["VALUE"] == "Y" && $h1_close == 1):?>
                        </h1>
                    <?else:?>
                        </h2>
                    <?endif;?>
                    
                    <?if(!empty($tit)):?>
                    
                        <?if($main_key == 0):?>
                        
                            <script>
                                $(document).ready(function(){
                                                                 
                                    $("div#block<?=$arItem["ID"]?> span.typed").typed({
                                        strings: ["<?=implode('","', $tit)?>"],
                                        typeSpeed: 50,
                                        startDelay: 2000,
                                        backDelay: 2000,
                                    });
    
                                });
                            </script>
                        
                        <?else:?>
                        
                            <script>
                                $(document).ready(function(){
                                                                 
                                    $(window).scroll(
                                        function()
                                        {
                                            if($(document).scrollTop() + $(window).height() > $("div#block<?=$arItem["ID"]?>").offset().top + 200)
                                            {
                                                $("div#block<?=$arItem["ID"]?> span.typed").typed({
                                                    strings: ["<?=implode('","', $tit)?>"],
                                                    typeSpeed: 50,
                                                    startDelay: 2000,
                                                    backDelay: 2000,
                                                });
                                            }
                                            
                                        }
                                    );
    
                                });
                            </script>
                        
                        <?endif;?>
                    
                    <?endif;?>                
                    
                <?endif;?>
        
                <?if(strlen($arItem["PROPERTIES"]["SUBHEADER"]["VALUE"]) > 0):?>
                
                    <?$tit = Array();?>
                    <?$title = Array();?>
                
                    <?
                    if(substr_count($arItem["PROPERTIES"]["SUBHEADER"]["VALUE"], "{") > 0 && substr_count($arItem["PROPERTIES"]["SUBHEADER"]["VALUE"], "}") > 0)
                    {
                        $tit = explode("{", $arItem["PROPERTIES"]["SUBHEADER"]["VALUE"]);
                        $title[] = $tit[0];
                        $tit = $tit[1];
                        
                        
                        $tit = explode("}", $tit);
                        $title[] = $tit[1];
                        $tit = $tit[0];
                        
                        
                        $tit = explode("|", $tit);
                        
                    }
                    ?>               
                
                    <div class="descrip <?=$arItem["PROPERTIES"]["HEADER_COLOR"]["VALUE_XML_ID"]?>" <?if(strlen($arItem["PROPERTIES"]["SUBTITLE_COLOR"]["VALUE"])>0):?> style="color: <?=$arItem["PROPERTIES"]["SUBTITLE_COLOR"]["VALUE"]?>;"<?endif;?>>
                    
                        <?if(!empty($tit)):?>
                            <?=htmlspecialcharsBack($title[0])?><span class="typed"></span><?=htmlspecialcharsBack($title[1])?>
                        <?else:?>
                            <?=$arItem["PROPERTIES"]["SUBHEADER"]["~VALUE"]?>
                        <?endif;?>
                    
                    </div>
                    
                    <?if(!empty($tit)):?>
                    
                        <?if($main_key == 0):?>
                        
                            <script>
                                $(document).ready(function(){
                                                                 
                                    $("div#block<?=$arItem["ID"]?> div.descrip span.typed").typed({
                                        strings: ["<?=implode('","', $tit)?>"],
                                        typeSpeed: 50,
                                        startDelay: 2000,
                                        backDelay: 2000,
                                    });

                                });
                            </script>
                        
                        <?else:?>
                        
                            <script>
                                $(document).ready(function(){
                                                                 
                                    $(window).scroll(
                                        function()
                                        {
                                            
                                            if($(document).scrollTop() + $(window).height() > $("div#block<?=$arItem["ID"]?>").offset().top + 200)
                                            {
                                                $("div#block<?=$arItem["ID"]?> div.descrip span.typed").typed({
                                                    strings: ["<?=implode('","', $tit)?>"],
                                                    typeSpeed: 50,
                                                    startDelay: 2000,
                                                    backDelay: 2000,
                                                });
                                            }
                                            
                                        }
                                    );

                                });
                            </script>
                        
                        <?endif;?>
                    
                    <?endif;?>
                    
                    
                <?endif;?>
                
            </div>
            
            <?if(!$min):?>
                </div>
            <?endif;?>
            
        </div>

    <?endif;?>
         
<?}?>

<?function CreateButton($arItem, $center = true){?>
    
    <?global $Landing;?>
    
    <div class="clearfix"></div>
    
    <?
        if(strlen($arItem["PROPERTIES"]["BUTTON_TYPE"]["VALUE_XML_ID"]) <= 0)
            $arItem["PROPERTIES"]["BUTTON_TYPE"]["VALUE_XML_ID"] = "form";
        
        if(strlen($arItem["PROPERTIES"]["BUTTON_TYPE_2"]["VALUE_XML_ID"]) <= 0)
            $arItem["PROPERTIES"]["BUTTON_TYPE_2"]["VALUE_XML_ID"] = "form";
    ?>
    
    <?if(strlen($arItem["PROPERTIES"]["BUTTON_NAME"]["VALUE"]) > 0 && strlen($arItem["PROPERTIES"]["BUTTON_TYPE"]["VALUE_XML_ID"]) > 0 || strlen($arItem["PROPERTIES"]["BUTTON_NAME_2"]["VALUE"]) > 0 && strlen($arItem["PROPERTIES"]["BUTTON_TYPE_2"]["VALUE_XML_ID"]) > 0):?>

        <?
            $block_name = $arItem['~NAME'];

            if(strlen($arItem["PROPERTIES"]["HEADER"]["VALUE"]) > 0)
                $block_name .= " (".$arItem["PROPERTIES"]["HEADER"]["~VALUE"].")";

            $block_name = htmlspecialcharsEx(strip_tags(html_entity_decode($block_name)));

            $class_button = "";
            $class_button2 = "";

            if(strlen($arItem["PROPERTIES"]["BUTTON_NAME"]["VALUE"]) > 0 && strlen($arItem["PROPERTIES"]["BUTTON_TYPE"]["VALUE_XML_ID"]) > 0)
                $class_button = "left-on";
            
            if(strlen($arItem["PROPERTIES"]["BUTTON_NAME_2"]["VALUE"]) > 0 && strlen($arItem["PROPERTIES"]["BUTTON_TYPE_2"]["VALUE_XML_ID"]) > 0)
                $class_button2 = "right-on";
        ?>
    
        <div class="main-button-wrap <?if($center):?>center<?endif;?> <?=$class_button?> <?=$class_button2?>">
        
            <?if(strlen($class_button) > 0):?>

                <a <?if(strlen($arItem["PROPERTIES"]["BUTTON_ONCLICK"]["VALUE"])>0) echo "onclick='".$arItem["PROPERTIES"]["BUTTON_ONCLICK"]["VALUE"]."'";?> class="big button-def left <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?> <?=hamButtonEditClass($arItem["PROPERTIES"]["BUTTON_TYPE"]["VALUE_XML_ID"], $arItem["PROPERTIES"]["BUTTON_FORM"]["VALUE"], $arItem["PROPERTIES"]["BUTTON_MODAL"]["VALUE"])?> <?if($arItem["PROPERTIES"]["BUTTON_VIEW"]["VALUE_XML_ID"] == "empty"):?> secondary <?elseif($arItem["PROPERTIES"]["BUTTON_VIEW"]["VALUE_XML_ID"] == "shine"):?> shine primary <?else:?> primary <?endif;?>" <?=hamButtonEditAttr($arItem["PROPERTIES"]["BUTTON_TYPE"]["VALUE_XML_ID"], $arItem["PROPERTIES"]["BUTTON_FORM"]["VALUE"], $arItem["PROPERTIES"]["BUTTON_MODAL"]["VALUE"], $arItem["PROPERTIES"]["BUTTON_LINK"]["VALUE"], $arItem["PROPERTIES"]["BUTTON_BLANK"]["VALUE_XML_ID"], $block_name, $arItem["PROPERTIES"]["BUTTON_QUIZ"]["VALUE"])?>><?=$arItem["PROPERTIES"]["BUTTON_NAME"]["~VALUE"]?></a>

            <?endif;?>

            <?if(strlen($class_button2) > 0):?>

                <a <?if(strlen($arItem["PROPERTIES"]["BUTTON_2_ONCLICK"]["VALUE"])>0) echo "onclick='".$arItem["PROPERTIES"]["BUTTON_2_ONCLICK"]["VALUE"]."'";?> class="big button-def right <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?> <?=hamButtonEditClass($arItem["PROPERTIES"]["BUTTON_TYPE_2"]["VALUE_XML_ID"], $arItem["PROPERTIES"]["BUTTON_FORM_2"]["VALUE"], $arItem["PROPERTIES"]["BUTTON_MODAL_2"]["VALUE"])?> <?if($arItem["PROPERTIES"]["BUTTON_VIEW_2"]["VALUE_XML_ID"] == "empty"):?> secondary <?elseif($arItem["PROPERTIES"]["BUTTON_VIEW_2"]["VALUE_XML_ID"] == "shine"):?> shine primary <?else:?> primary <?endif;?>" <?=hamButtonEditAttr($arItem["PROPERTIES"]["BUTTON_TYPE_2"]["VALUE_XML_ID"], $arItem["PROPERTIES"]["BUTTON_FORM_2"]["VALUE"], $arItem["PROPERTIES"]["BUTTON_MODAL_2"]["VALUE"], $arItem["PROPERTIES"]["BUTTON_LINK_2"]["VALUE"], $arItem["PROPERTIES"]["BUTTON_BLANK_2"]["VALUE_XML_ID"], $block_name, $arItem["PROPERTIES"]["BUTTON_QUIZ_2"]["VALUE"])?>><?=$arItem["PROPERTIES"]["BUTTON_NAME_2"]["~VALUE"]?></a>

            <?endif;?>
            
        </div>
        
    <?endif;?>
         
<?}?>


<?function CreateElement($arItem, $arSection, $mainkey){?>

    <?
        global $Landing;
        global $admin_active;
        global $show_setting;
        global $components;
        global $DB_cham;
        global $img_quality;
        global $header_bg_on;

        $main_key = $mainkey;

        $block_name = $arItem['~NAME'];

        if(strlen($arItem["PROPERTIES"]["HEADER"]["VALUE"]) > 0)
            $block_name .= " (".$arItem["PROPERTIES"]["HEADER"]["~VALUE"].")";

        $block_name = htmlspecialcharsEx(strip_tags(html_entity_decode($block_name)));

        
        $style = "";
        $style2 = "";
        $class ="";
    
        if(strlen($arItem["PREVIEW_PICTURE"]["SRC"]) > 0)
            $style .= "background-image: url('".$arItem["PREVIEW_PICTURE"]["SRC"]."');";

        if(strlen($arItem["PROPERTIES"]["BACKGROUND_COLOR"]["VALUE"]) > 0)
            $style .= "background-color: ".$arItem["PROPERTIES"]["BACKGROUND_COLOR"]["VALUE"].";";
            
        if($arItem["PROPERTIES"]["PARALLAX"]["VALUE_XML_ID"] == "100")
            $style .= "background-attachment: fixed;";
    
        
        if(strlen($arItem["PROPERTIES"]["MARGIN_TOP"]["VALUE"]) > 0)
            $style .= "margin-top: ".$arItem["PROPERTIES"]["MARGIN_TOP"]["VALUE"]."px;";

    
        if(strlen($arItem["PROPERTIES"]["MARGIN_BOTTOM"]["VALUE"]) > 0)
            $style .= "margin-bottom: ".$arItem["PROPERTIES"]["MARGIN_BOTTOM"]["VALUE"]."px;";


        if(strlen($arItem["PROPERTIES"]["PADDING_TOP"]["VALUE"]) > 0)
        {
            if(!$arItem["PADDING_CHANGE"])
                $style .= "padding-top: ".$arItem["PROPERTIES"]["PADDING_TOP"]["VALUE"]."px;";
            else
                $style2 .= "padding-top: ".$arItem["PROPERTIES"]["PADDING_TOP"]["VALUE"]."px;";
        }
        
        if(strlen($arItem["PROPERTIES"]["PADDING_BOTTOM"]["VALUE"]) > 0){
            
            if(!$arItem["PADDING_CHANGE"])
                $style .= "padding-bottom: ".$arItem["PROPERTIES"]["PADDING_BOTTOM"]["VALUE"]."px;";
            else
                $style2 .= "padding-bottom: ".$arItem["PROPERTIES"]["PADDING_BOTTOM"]["VALUE"]."px;";
        }

        if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y" && ($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "text"))
            $class = "cham-overflow";
    ?>

    <?if(strlen($arItem["PROPERTIES"]["MARGIN_TOP_MOB"]["VALUE"])>0 || strlen($arItem["PROPERTIES"]["MARGIN_BOTTOM_MOB"]["VALUE"])>0 || strlen($arItem["PROPERTIES"]["PADDING_TOP_MOB"]["VALUE"])>0 || strlen($arItem["PROPERTIES"]["PADDING_BOTTOM_MOB"]["VALUE"])>0):?>

        <style>
            @media (max-width: 991px){
                #block<?=$arItem["ID"]?>{
                    <?if(strlen($arItem["PROPERTIES"]["MARGIN_TOP_MOB"]["VALUE"])>0):?>margin-top: <?=$arItem["PROPERTIES"]["MARGIN_TOP_MOB"]["VALUE"]?>px !important;<?endif;?>
                    <?if(strlen($arItem["PROPERTIES"]["MARGIN_BOTTOM_MOB"]["VALUE"])>0):?>margin-bottom: <?=$arItem["PROPERTIES"]["MARGIN_BOTTOM_MOB"]["VALUE"]?>px !important;<?endif;?>
                    <?if(strlen($arItem["PROPERTIES"]["PADDING_TOP_MOB"]["VALUE"])>0):?>padding-top: <?=$arItem["PROPERTIES"]["PADDING_TOP_MOB"]["VALUE"]?>px !important;<?endif;?>
                    <?if(strlen($arItem["PROPERTIES"]["PADDING_BOTTOM_MOB"]["VALUE"])>0):?>padding-bottom: <?=$arItem["PROPERTIES"]["PADDING_BOTTOM_MOB"]["VALUE"]?>px !important;<?endif;?>
                }
            }
        </style>

    <?endif;?>

    <?if($arItem["PROPERTIES"]["COMPONENT_DESIGN"]["VALUE_XML_ID"] != "Y" && $arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "component"):?>

        #DYNAMIC<?=$components?>#
        <?$components++;?>    

    <?else:?>
    
    
        <div id="block<?=$arItem["ID"]?>" class="block clearfix <?=$class?> <?if($mainkey == 0):?>hameleon-first<?endif;?> <?if(!$arItem["PADDING_CHANGE"]):?>padding-on <?if($mainkey == 0):?>padding-change<?endif;?><?endif;?> <?if(strlen($arItem["PROPERTIES"]["VIDEO_BACKGROUND"]["VALUE"]) > 0):?>video-bg<?endif;?> <?=$arItem["PROPERTIES"]["SHADOW"]["VALUE_XML_ID"]?> <?=$arItem["PROPERTIES"]["COVER"]["VALUE_XML_ID"]?> 
            <?if($arItem["PROPERTIES"]["HIDE_BLOCK"]["VALUE"] == "Y"):?>hidden-sm hidden-xs<?endif;?> <?if($arItem["PROPERTIES"]["HIDE_BLOCK_LG"]["VALUE"] == "Y"):?> hidden-lg hidden-md<?endif;?>" <?if(strlen($style)>0):?> style="<?=$style?>"<?endif;?> <?if($arItem["PROPERTIES"]["PARALLAX"]["VALUE_XML_ID"] == "30"):?>data-enllax-ratio=".25"<?endif;?>>

            
        
            <?if(strlen($arItem["PROPERTIES"]["VIDEO_BACKGROUND"]["VALUE"]) > 0):?>

                <?preg_match("/^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/",$arItem['PROPERTIES']['VIDEO_BACKGROUND']['~VALUE'],$out);?>     
                
                <div class="iframe-wrap">
                    <iframe class="video-bg" allowfullscreen="" frameborder="0" height="100%" src="https://www.youtube.com/embed/<?=$out[1]?>?rel=0&amp;mute=1&amp;controls=0&amp;loop=1&amp;showinfo=0&amp;autoplay=1&amp;playlist=<?=$out[1]?>" width="100%"></iframe>
                </div>
            
            <?endif;?>

            <div class="shadow"></div>

            <?
                if($header_bg_on)
                {
                    if($main_key == 0)
                        echo "<div class='top-shadow'></div>";
                }
            ?>

            <?
                if(is_array($arItem["PROPERTIES"]["SLIDES"]["VALUE_XML_ID"]) && !empty($arItem["PROPERTIES"]["SLIDES"]["VALUE_XML_ID"]))
                {
                    foreach($arItem["PROPERTIES"]["SLIDES"]["VALUE_XML_ID"] as $arSlID)
                    {
                        echo "<div class='corner ".$arSlID." hidden-xs hidden-sm'></div>";
                    }
                }
            ?>
            
            <?if(!$arItem["TITLE_CHANGE"])
                CreateHead($arItem, false, $main_key);?>

            <div class="content <?if($arItem["TITLE_CHANGE"] || !(strlen($arItem["PROPERTIES"]["HEADER"]["VALUE"]) > 0 || strlen($arItem["PROPERTIES"]["SUBHEADER"]["VALUE"]) > 0)):?>no-margin<?endif;?>">

                <div class="container">
                    <div class="row">
                    
                        <?//text?>
                        <?if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "text"):?>
                            <?

                                if($arItem["PROPERTIES"]["TEXT_BLOCK_PICTURE_BLOCK_POSITION"]["VALUE_XML_ID"] == "")
                                    $arItem["PROPERTIES"]["TEXT_BLOCK_PICTURE_BLOCK_POSITION"]["VALUE_XML_ID"] = "left";

                                $class1="col-lg-12 col-md-12 col-sm-12 col-xs-12";
                                $class2="";

                                $offset1="";
                                $offset2="";

                                if($arItem["TITLE_CHANGE"])
                                {
                                    $class1="col-lg-7 col-md-7 col-sm-8 col-xs-12";
                                    $class2="col-lg-5 col-md-5 col-sm-4 col-xs-12";

                                    if($arItem["PROPERTIES"]["TEXT_BLOCK_PICTURE_BLOCK_POSITION"]["VALUE_XML_ID"] == "left")
                                    {
                                        $offset1="col-lg-push-5 col-md-push-5 col-sm-push-4 col-xs-push-0 right";
                                        $offset2="col-lg-pull-7 col-md-pull-7 col-sm-pull-8 col-xs-pull-0<";
                                    }
                                }

                                $count_gallery = 0;
                                if(!empty($arItem["PROPERTIES"]["TEXT_BLOCK_GALLERY"]["VALUE"]))
                                    $count_gallery = count($arItem["PROPERTIES"]["TEXT_BLOCK_GALLERY"]["VALUE"]);
                            ?>
                            
                            <div class="descriptive">
                        
                                <div class="descriptive-table">
                                
                                    <div class="descriptive-cell <?=$class1?> text-part z-text <?=$offset1?>" style="<?=$style2?>">
                                    
                                        <div class="<?if($arItem["TITLE_CHANGE"]):?><?if($arItem["PROPERTIES"]["TEXT_BLOCK_PICTURE_BLOCK_POSITION"]["VALUE_XML_ID"] == "left"):?>wrap-padding-left<?else:?>wrap-padding-right<?endif;?><?endif;?>">
                
                                            <?if($arItem["TITLE_CHANGE"]):?>
                                                <?CreateHead($arItem, true, $main_key)?>
                                            <?endif;?>
                                            
                                            
                                            <?if(!$arItem["TITLE_CHANGE"] && $count_gallery > 0):?>
        
                                                <div class="descriptive-tabs-wrap">
                                                
                                                    <div class="images-wrap">
                                                        
                                                        <?foreach($arItem["PROPERTIES"]["TEXT_BLOCK_GALLERY"]["VALUE"] as $k=>$photo):?>
                                                        
                                                            <div class="image-content <?if($k == 0):?>active<?endif;?>">
                                                                
                                                                <?if($count_gallery > 1):?>
                                                                    <div class="mob-tab visible-xs <?if($k == 0):?>active<?endif;?>">
                                                                        <?if(strlen($arItem["PROPERTIES"]["TEXT_BLOCK_GALLERY"]["DESCRIPTION"][$k]) > 0):?>
                                                                            <?=$arItem["PROPERTIES"]["TEXT_BLOCK_GALLERY"]["DESCRIPTION"][$k]?>
                                                                        <?else:?>
                                                                            <?=$k+1?>
                                                                        <?endif;?>
                                                                        <div class="primary"></div>
                                                                    </div>
                                                                <?endif;?>
                
                                                                <div class="mob-content <?if($k == 0):?>active<?endif;?>">
                                                                
                                                                    <?$file = CFile::ResizeImageGet($photo, array('width'=>1200, 'height'=>700), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                                                    <img alt="<?=$arItem["PROPERTIES"]["TEXT_BLOCK_GALLERY"]["DESCRIPTION"][$k]?>" class="img-responsive center-block" src="<?=$file["src"]?>" />

                                                                </div>
                                                            </div>
                                                            
                                                        <?endforeach;?>

                                                    </div>
        
                                                    <?if($count_gallery > 1):?>
                                                    
                                                        <ul class="tabs hidden-xs">
                                                            
                                                            <?foreach($arItem["PROPERTIES"]["TEXT_BLOCK_GALLERY"]["VALUE"] as $k=>$photo):?>
                                                                <li class="<?if($k == 0):?>active<?endif;?> mainColor">
                                                                
                                                                    <?if(strlen($arItem["PROPERTIES"]["TEXT_BLOCK_GALLERY"]["DESCRIPTION"][$k]) > 0):?>
                                                                        <?=$arItem["PROPERTIES"]["TEXT_BLOCK_GALLERY"]["DESCRIPTION"][$k]?>
                                                                    <?else:?>
                                                                        <?=$k+1?>
                                                                    <?endif;?>

                                                                </li>
                                                            <?endforeach;?>
                            
                                                        </ul>
                                                    
                                                    <?endif;?>
                                                    
                                                </div>
                                            
                                            <?endif;?>
                                            
         
                                            <?if(strlen($arItem["PREVIEW_TEXT"]) > 0):?>
                                                <div class="text-wrap text-content no-margin-top-bot <?=$arItem["PROPERTIES"]["TEXT_BLOCK_COLOR"]["VALUE_XML_ID"]?> <?if(!$arItem["TITLE_CHANGE"]):?>center<?endif;?>">
                                                    <?=$arItem["PREVIEW_TEXT"]?>
                                                </div>
                                            <?endif;?>
                                            
                                            <?if($arItem["TITLE_CHANGE"] && $count_gallery > 0):?>
        
                                                <div class="gallery <?if($arItem["PROPERTIES"]["TEXT_BLOCK_BORDER"]["VALUE"]):?>border-img-on<?endif;?>">
                                                    <div class="row clearfix">
                                                    
                                                        <?foreach($arItem["PROPERTIES"]["TEXT_BLOCK_GALLERY"]["VALUE"] as $k=>$photo):?>
                                                            
                                                            <?$file_small = CFile::ResizeImageGet($photo, array('width'=>200, 'height'=>140), BX_RESIZE_IMAGE_EXACT, false, false, false, $img_quality);?>
                                                            <?$file_big = CFile::ResizeImageGet($photo, array('width'=>1500, 'height'=>1500), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                                            
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                            
                                                                <div class="img-wrap">
                                                                    <a title="<?=$arItem["PROPERTIES"]["TEXT_BLOCK_GALLERY"]["DESCRIPTION"][$k]?>" data-gallery="gal<?=$arItem['ID']?>" data-gallery="a<?=$arItem["ID"]?>" class="cursor-loop" href="<?=$file_big["src"]?>">
                                                                        <img alt="<?=$arItem["PROPERTIES"]["TEXT_BLOCK_GALLERY"]["DESCRIPTION"][$k]?>" class="img-responsive" src="<?=$file_small["src"]?>">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            
                                                            <?if(($k+1)%4 == 0):?>
                                                                <span class="clearfix"></span>
                                                            <?endif;?>
                                                        
                                                        <?endforeach;?>
                                                    
                                                    </div>
                                                </div>
                                            
                                            <?endif;?>
        
                                            <?if($arItem["BUTTON_CHANGE"]):?>
                                                <?=CreateButton($arItem, false)?>
                                            <?endif;?>
                                        
                                        </div>

                                    </div>
                                    
                                    <?if($arItem["TITLE_CHANGE"]):?>
                                    
                                        <div class="descriptive-cell image-part z-image <?=$class2?> <?=$offset2?> <?=$arItem["PROPERTIES"]["TEXT_BLOCK_PICTURE_POSITION"]["VALUE_XML_ID"]?>">
                                        
                                            <?
                                                $file = CFile::ResizeImageGet($arItem["PROPERTIES"]["TEXT_BLOCK_PICTURE"]["VALUE"], array('width'=>800, 'height'=>800), BX_RESIZE_IMAGE_PROPORTIONAL, false);
                                                $animate = '';
                                                $animate_set = '';

                                                if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y")
                                                {
                                                    if($arItem["PROPERTIES"]["TEXT_BLOCK_PICTURE_POSITION"]["VALUE_XML_ID"] == "middle")
                                                        $animate = 'wow zoomIn';

                                                    if($arItem["PROPERTIES"]["TEXT_BLOCK_PICTURE_POSITION"]["VALUE_XML_ID"] == "bottom")
                                                        $animate = 'wow slideInUp';

                                                    if($arItem["PROPERTIES"]["TEXT_BLOCK_PICTURE_POSITION"]["VALUE_XML_ID"] == "top")
                                                        $animate = 'wow zoomIn';

                                                    $animate_set = 'data-wow-offset="250" data-wow-duration="1s" data-wow-delay="0.5s"';
                                                }
                                            ?>

                                            <img alt="<?=$arItem['NAME']?>" class=" img-responsive center-block <?=$animate;?>" src="<?=$file["src"]?>" <?=$animate_set?>/>
                                        
                                        </div>
                                        
                                    <?endif;?>

                                </div>
                            </div>
                            
                        <?endif;?>


                        <?//advantages?>

                        <?if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "advantages"):?>

                            <?
                                if($arItem["PROPERTIES"]["ADVANTAGES_VIEW_SIZE"]["VALUE_XML_ID"] == '') $arItem["PROPERTIES"]["ADVANTAGES_VIEW_SIZE"]["VALUE_XML_ID"] = 'big';
                                if($arItem["PROPERTIES"]["ADVANTAGES_TYPE_PICTURE"]["VALUE_XML_ID"] == '') $arItem["PROPERTIES"]["ADVANTAGES_TYPE_PICTURE"]["VALUE_XML_ID"] = 'images';
                            ?>
                        

                            <?if($arItem["PROPERTIES"]["ADVANTAGES_VIEW"]["VALUE_XML_ID"] == "flat" || $arItem["PROPERTIES"]["ADVANTAGES_VIEW"]["VALUE_XML_ID"] == ""):?>
                                <?$count = $arItem["PIC_MAX"];?>


                                <div class="advantages clearfix <?=$arItem["PROPERTIES"]["ADVANTAGES_TYPE_PICTURE"]["VALUE_XML_ID"]?> <?if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y"):?>parent-animate<?endif;?><?if(strlen($arItem["PROPERTIES"]["ADVANTAGES_IMAGE"]["VALUE"]) > 0):?> image-on<?endif;?>">

                                    <div class="advantages-table clearfix">

                                        <div class="advantages-cell clearfix text-part z-text <?if($arItem["PROPERTIES"]["ADVANTAGES_IMAGE"]["VALUE"] > 0):?>col-lg-7 col-md-7 col-sm-12 col-xs-12 <?if($arItem["PROPERTIES"]["ADVANTAGES_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["ADVANTAGES_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "left"):?>col-lg-push-5 col-md-push-5 col-sm-push-0 col-xs-push-0 right<?endif;?><?else:?>col-lg-12 col-md-12 col-sm-12 col-xs-12<?endif;?>" style="<?=$style2?>">
                                        
                                            <div class="<?if($arItem["PROPERTIES"]["ADVANTAGES_IMAGE"]["VALUE"] > 0):?><?if($arItem["PROPERTIES"]["ADVANTAGES_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["ADVANTAGES_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "left"):?>wrap-padding-left<?else:?>wrap-padding-right<?endif;?><?endif;?>">
                    
                                                <?if($arItem["TITLE_CHANGE"]):?>
                                                    <?CreateHead($arItem, true, $main_key)?>
                                                    <div class="clearfix"></div>
                                                <?endif;?>

                                                <div class="part-wrap row clearfix <?if($arItem["TITLE_CHANGE"]):?>min<?endif;?>">

                                                    <?if(strlen($count)>0):?>

                                                        <?  
                                                            $rest1 = 5 % 3;
                                                            $rest2 = 7 % 3;
                                                            $rowRest = -1;

                                                            $class = "col-lg-4 col-md-4 col-sm-6 col-xs-12";
                                                            $class2 = "";
                                                            

                                                            if($arItem["PROPERTIES"]["ADVANTAGES_VIEW_SIZE"]["VALUE_XML_ID"] == "small")
                                                            {
                                                                if(strlen($arItem["PROPERTIES"]["ADVANTAGES_IMAGE"]["VALUE"]) > 0)
                                                                    $class = "col-lg-6 col-md-6 col-sm-6 col-xs-12";
                                                            }

                                                            else
                                                            {
                                                                if(strlen($arItem["PROPERTIES"]["ADVANTAGES_IMAGE"]["VALUE"]) > 0)
                                                                    $class = "col-lg-6 col-md-6 col-sm-6 col-xs-12";

                                                                else
                                                                {
                                                                    if($count % 4 == 0)
                                                                        $class = "col-lg-3 col-md-3 col-sm-6 col-xs-12 four-cols";

                                                                    elseif($count % 3 == $rest1)
                                                                    {
                                                                        $class2 = "col-lg-offset-2 col-md-offset-2 col-sm-offset-0 col-xs-offset-0";
                                                                        $rowRest = $count-2;
                                                                    }
                                                                        
                                                                    elseif($count % 3 == $rest2)
                                                                    {
                                                                        $class2 = "col-lg-offset-4 col-md-offset-4 col-sm-offset-0 col-xs-offset-0";
                                                                        $rowRest = $count-1;
                                                                    }

                                                                }                                                          

                                                            }
                                                        ?>

                                                        <?for($i = 0; $i < $count; $i++):?>

                                                            <div class="<?=$class?><?if($i == $rowRest):?> <?=$class2?><?endif;?>">

                                                                <div class="element <?if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y"):?>child-animate opacity-zero<?endif;?> <?=$arItem["PROPERTIES"]["ADVANTAGES_TEXT_COLOR"]["VALUE_XML_ID"]?> <?=$arItem["PROPERTIES"]["ADVANTAGES_VIEW_SIZE"]["VALUE_XML_ID"]?>">
                                                                    

                                                                    <?if($arItem["PIC_COUNT"] > 0 || $arItem["IC_COUNT"]):?>
                                                                
                                                                        <div class="image-table">
                                                                            <div class="image-cell">

                                                                                <?if($arItem["PROPERTIES"]["ADVANTAGES_TYPE_PICTURE"]["VALUE_XML_ID"] == "images" || $arItem["PROPERTIES"]["ADVANTAGES_TYPE_PICTURE"]["VALUE_XML_ID"] == ""):?>
                                                                            
                                                                                    <?if($arItem["PROPERTIES"]["ADVANTAGES_PICTURES"]["VALUE"][$i] > 0):?>


                                                                                        <?if($arItem["TITLE_CHANGE"]):?>

                                                                                            <?$file = CFile::ResizeImageGet($arItem["PROPERTIES"]["ADVANTAGES_PICTURES"]["VALUE"][$i], array('width'=>720, 'height'=>256), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>

                                                                                        <?else:?>

                                                                                            <?$file = CFile::ResizeImageGet($arItem["PROPERTIES"]["ADVANTAGES_PICTURES"]["VALUE"][$i], array('width'=>720, 'height'=>470), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>

                                                                                        <?endif;?>


                                                                                        <img alt="" class="img-responsive" src="<?=$file["src"]?>"/>


                                                                                    <?endif;?>

                                                                                <?elseif($arItem["PROPERTIES"]["ADVANTAGES_TYPE_PICTURE"]["VALUE_XML_ID"] == "icons"):?>

                                                                                    <i class="style-ic <?=$arItem["PROPERTIES"]["ADVANTAGES_ICONS"]["VALUE"][$i]?>" style="color: <?=$arItem["PROPERTIES"]["ADVANTAGES_ICONS"]["~DESCRIPTION"][$i]?>"></i>

                                                                                <?endif;?>
                                                                                
                                                                            </div>
                                                                        </div>
                                                                    
                                                                    <?endif;?>


                                                                    
                                                                    <?if($arItem["PIC_DESC_COUNT"] > 0 || $arItem["PIC_NAME_COUNT"] > 0):?>
                                                                    
                                                                        <div class="text-wrap no-margin-top-bot  <?if($arItem["PIC_COUNT"] > 0):?>icons-on<?endif;?>">

                                                                            <?if(strlen($arItem["PROPERTIES"]["ADVANTAGES_IMAGE"]["VALUE"]) > 0 || $arItem["PROPERTIES"]["ADVANTAGES_VIEW_SIZE"]["VALUE_XML_ID"] == "small"):?>



                                                                                <?if(strlen($arItem["PROPERTIES"]["ADVANTAGES_PICTURES_DESC"]["~DESCRIPTION"][$i]) > 0):?>

                                                                                    <div class="name main1">
                                                                                        <?=$arItem["PROPERTIES"]["ADVANTAGES_PICTURES_DESC"]["~DESCRIPTION"][$i]?>
                                                                                    </div>

                                                                                <?endif;?>


                                                                            <?else:?>


                                                                                <?if(strlen($arItem["PIC_NAME_COUNT"]) > 0):?>

                                                                                    <div class="name main1">
                                                                                        <?=$arItem["PROPERTIES"]["ADVANTAGES_PICTURES_DESC"]["~DESCRIPTION"][$i]?>
                                                                                    </div>

                                                                                <?endif;?>


                                                                            <?endif;?>



                                                                            <?if(strlen($arItem["PIC_DESC_COUNT"]) > 0):?>
                                                                            
                                                                                <div class="text">
                                                                                    <?=$arItem["PROPERTIES"]["ADVANTAGES_PICTURES_DESC"]["~VALUE"][$i]?>
                                                                                </div>

                                                                            <?endif;?>

                                                                        </div>
                                                                    
                                                                    <?endif;?>

                                                                </div>

                                                            </div>

                                                            <?if($arItem["PROPERTIES"]["ADVANTAGES_VIEW_SIZE"]["VALUE_XML_ID"] == "small"):?>

                                                                <?if(strlen($arItem["PROPERTIES"]["ADVANTAGES_IMAGE"]["VALUE"]) > 0):?>
                                                                    <?if(($i+1) % 2 == 0):?>
                                                                        <span class="clearfix"></span>
                                                                    <?endif;?>
                                                                    
                                                                <?else:?>
                                                                    <?if(($i+1) % 2 == 0):?>
                                                                        <span class="clearfix visible-sm"></span>
                                                                    <?endif;?>
                                                                    <?if(($i+1) % 3 == 0):?>
                                                                        <span class="clearfix hidden-sm"></span>
                                                                    <?endif;?>

                                                                <?endif;?>

                                                            <?else:?>

                                                                <?if(strlen($arItem["PROPERTIES"]["ADVANTAGES_IMAGE"]["VALUE"]) > 0):?>

                                                                    <?if(($i+1) % 2 == 0):?>
                                                                        <span class="clearfix"></span>
                                                                    <?endif;?>

                                                                <?else:?>
                                                                    <?if($count % 4 == 0):?>

                                                                        <?if(($i+1) % 4 == 0):?>
                                                                            <span class="clearfix hidden-sm"></span>
                                                                        <?endif;?>

                                                                    <?else:?>
                                                                        <?if(($i+1) % 3 == 0):?>
                                                                            <span class="clearfix hidden-sm"></span>
                                                                        <?endif;?>

                                                                    <?endif;?>

                                                                    

                                                                    <?if(($i+1) % 2 == 0):?>
                                                                        <span class="clearfix visible-sm"></span>
                                                                    <?endif;?>

                                                                <?endif;?>  

                                                            <?endif;?>
                                                        
                                                        <?endfor;?>

                                                    <?endif;?>

                                                </div>

                                                <?if($arItem["BUTTON_CHANGE"]):?>
                                                    <?=CreateButton($arItem, false)?>
                                                <?endif;?>
                                            </div>

                                        </div>

                                        <?if(strlen($arItem["PROPERTIES"]["ADVANTAGES_IMAGE"]["VALUE"]) > 0):?>
                                        
                                            <div class="advantages-cell image-part z-image hidden-sm hidden-xs col-lg-5 col-md-5 col-sm-0 col-xs-12 <?if($arItem["PROPERTIES"]["ADVANTAGES_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["ADVANTAGES_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "left"):?>col-lg-pull-7 col-md-pull-7 col-sm-pull-0 col-xs-pull-0<?endif;?> <?=$arItem["PROPERTIES"]["ADVANTAGES_IMAGE_POSITION"]["VALUE_XML_ID"]?>">
                                            
                                                <?$file = CFile::ResizeImageGet($arItem["PROPERTIES"]["ADVANTAGES_IMAGE"]["VALUE"], array('width'=>800, 'height'=>800), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                            
                                                <img alt="<?=$arItem["NAME"]?>" class="img-responsive center-block" src="<?=$file["src"]?>" />
                                            
                                            </div>
                                            
                                        <?endif;?>

                                    </div>

                                </div><!-- ^advantages -->

                            <?elseif($arItem["PROPERTIES"]["ADVANTAGES_VIEW"]["VALUE_XML_ID"] == "slider"):?>

                                <div class="slider-advantages <?=$arItem["PROPERTIES"]["ADVANTAGES_TYPE_PICTURE"]["VALUE_XML_ID"]?> <?=$arItem["PROPERTIES"]["ADVANTAGES_VIEW_SIZE"]["VALUE_XML_ID"]?>-slide clearfix <?=$arItem["PROPERTIES"]["ADVANTAGES_TEXT_COLOR"]["VALUE_XML_ID"]?>">

                                    <?for($i = 0; $i < $arItem["PIC_MAX"]; $i++):?>

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="div-table">
                                                   

                                               <?if($arItem["PIC_COUNT"] > 0 || $arItem["IC_COUNT"]):?>
                                                    <div class="div-cell left">
                                                        <table>
                                                            <tr>
                                                                <td>
                                                                    <?if($arItem["PROPERTIES"]["ADVANTAGES_TYPE_PICTURE"]["VALUE_XML_ID"] == "icons"):?>

                                                                         <i class="style-ic <?=$arItem["PROPERTIES"]["ADVANTAGES_ICONS"]["VALUE"][$i]?>" style="color: <?=$arItem["PROPERTIES"]["ADVANTAGES_ICONS"]["~DESCRIPTION"][$i]?>"></i>
                                                                    
                                                                    <?else:?>
                                                                        <?$file = CFile::ResizeImageGet($arItem["PROPERTIES"]["ADVANTAGES_PICTURES"]["VALUE"][$i], array('width'=>1200, 'height'=>960), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                                                        <img src="<?=$file['src']?>" class="img-responsive center-block" alt="">

                                                                    <?endif;?>

                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                <?endif;?>

                                                <div class="div-cell right">

                                                    <?if(strlen($arItem["PROPERTIES"]["ADVANTAGES_PICTURES_DESC"]["~DESCRIPTION"][$i])>0):?>
                                                        <div class="title bold"><?=$arItem["PROPERTIES"]["ADVANTAGES_PICTURES_DESC"]["~DESCRIPTION"][$i]?></div>
                                                    <?endif;?>

                                                    <?if(strlen($arItem["PROPERTIES"]["ADVANTAGES_PICTURES_DESC"]["~VALUE"][$i])>0):?>
                                                        <div class="desc"><?=$arItem["PROPERTIES"]["ADVANTAGES_PICTURES_DESC"]["~VALUE"][$i]?></div>
                                                    <?endif;?>

                                                </div>

                                            </div>

                                        </div>

                                    <?endfor;?>

                                </div>

                            <?endif;?>
                            
                        <?endif;?>
                        
                        <?//advantages end?>
                        

                        <?//form?>
                        
                        <?if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "form"):?>

                            <div class="form-block <?if($arItem["PROPERTIES"]["FORM_IMAGE_POSITION"]["VALUE_XML_ID"] == "bottom"):?> un-margin-bottom<?endif;?>">
                                <div class="form-table">

                                    <?if($arItem["PROPERTIES"]["FORM_IMAGE"]["VALUE"] > 0 || strlen($arItem["PROPERTIES"]["FORM_TEXT_TITLE"]["~VALUE"]) > 0 || strlen($arItem["PROPERTIES"]["FORM_TEXT_UNDER_TITLE"]["~VALUE"]['TEXT']) > 0 ):?>

                                        <?if($arItem["PROPERTIES"]["FORM_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["FORM_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "left"):?> 
                                        
                                                <div class="form-cell image-part z-image left <?if($arItem["PROPERTIES"]["FORM_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "right"):?> hidden-lg hidden-md <?endif;?> hidden-sm hidden-xs <?=$arItem["PROPERTIES"]["FORM_IMAGE_POSITION"]["VALUE_XML_ID"]?>">
                                                
                                                    <?if(strlen($arItem["PROPERTIES"]["FORM_TEXT_TITLE"]["~VALUE"]) || strlen($arItem["PROPERTIES"]["FORM_TEXT_UNDER_TITLE"]["~VALUE"]['TEXT']) > 0 ):?>

                                                        <div class="text-wrap <?=$arItem["PROPERTIES"]["FORM_TEXT_TITLE_COLOR"]["VALUE_XML_ID"]?>">
                                                            <?if($arItem["PROPERTIES"]["FORM_UPLINE"]["VALUE"] == 'Y'):?><div class="line main-color"></div><?endif;?>
        
                                                            <?if(strlen($arItem["PROPERTIES"]["FORM_TEXT_TITLE"]["~VALUE"]) > 0):?><div class="form-text-title bold"><?=$arItem["PROPERTIES"]["FORM_TEXT_TITLE"]["~VALUE"]?></div><?endif;?>
        
                                                            <?if(strlen($arItem["PROPERTIES"]["FORM_TEXT_UNDER_TITLE"]["~VALUE"]['TEXT'])> 0):?><div class="form-text-under-title italic"><?=$arItem["PROPERTIES"]["FORM_TEXT_UNDER_TITLE"]["~VALUE"]['TEXT']?></div><?endif;?>
        
                                                        </div>
        
                                                    <?endif;?>

                                                    <?if($arItem["PROPERTIES"]["FORM_IMAGE"]["VALUE"] > 0):?>
                                                
                                                        <?$img = CFile::ResizeImageGet($arItem["PROPERTIES"]["FORM_IMAGE"]["VALUE"], array('width'=>700, 'height'=>1500), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                                    
                                                        <img alt="<?=$arItem["NAME"]?>" class="img-responsive hidden-xs" src="<?=$img["src"]?>" />

                                                    <?endif;?>
                                                
                                                </div>
                                        <?endif;?>
                                        
                                    <?endif;?>

                                    <div class="form-cell text-part z-text" style="<?=$style2?>">
                                        <div class="">
                                            
                                            <?
                                                
                                                $timer_on = false;

                                                if($arItem["PROPERTIES"]["FORM_TIMER_ON"]["VALUE"] == 'Y')
                                                    $timer_on = true;

                                                if($arItem["PROPERTIES"]["FORM_ADMIN"]["VALUE_XML_ID"] == "")
                                                    $arItem["PROPERTIES"]["FORM_ADMIN"]["VALUE_XML_ID"] = "light";

                                                $style = '';

                                                if(strlen($arItem["PROPERTIES"]["FORM_BGC"]["VALUE"]))
                                                    $style .= 'background-color:'.$arItem["PROPERTIES"]["FORM_BGC"]["VALUE"].';';

                                                if(strlen($arItem["PROPERTIES"]["FORM_BACKGROUND"]["VALUE"])>0)
                                                {
                                                    $img = CFile::ResizeImageGet($arItem["PROPERTIES"]["FORM_BACKGROUND"]["VALUE"], array('width'=>700, 'height'=>700), BX_RESIZE_IMAGE_PROPORTIONAL, false);
                                                    $style .= 'background-image: url('.$img["src"].');';
                                                }

                                                if($arItem["PROPERTIES"]["FORM_TEXT_COLOR"]["VALUE_XML_ID"] == "")
                                                    $arItem["PROPERTIES"]["FORM_TEXT_COLOR"]["VALUE_XML_ID"] = "dark";
                                            ?>

                                            <form action="/" class="form send <?=$arItem["PROPERTIES"]["FORM_TEXT_COLOR"]["VALUE_XML_ID"]?> <?if($timer_on):?>timer_form<?endif;?>" enctype="multipart/form-data" method="post" role="form" <?if($style):?>style='<?=$style?>'<?endif;?>>

                                                <input name="section" type="hidden" value="<?=$arSection["ID"]?>">
                                                <input name="element" type="hidden" value="<?=$arItem["ID"]?>">
                                                <input name="site_id" type="hidden" value="<?=SITE_ID?>">
                                                <input name="url" type="hidden" value="">
                                                <input name="header" type="hidden" value="<?=$block_name?>">

                                                <input name="important_id" type="hidden" value="access">

                                                <table class="wrap-act">
                                                    <tr>
                                                        <td>

                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 questions active">

                                                                <?if(strlen($arItem["PROPERTIES"]["FORM_TITLE"]["VALUE"]) > 0):?>

                                                                    <div class="title main1">
                                                                        <?=$arItem["PROPERTIES"]["FORM_TITLE"]["~VALUE"]?>
                                                                    </div>

                                                                <?endif;?>

                                                                <?if(strlen($arItem["PROPERTIES"]["FORM_SUBTITLE"]["VALUE"]) > 0):?>

                                                                    <div class="subtitle">
                                                                        <?=$arItem["PROPERTIES"]["FORM_SUBTITLE"]["~VALUE"]?>
                                                                    </div>

                                                                <?endif;?>

                                                                <?if($timer_on):?>
                                                                    <input type="hidden" class="timerVal" value="<?=$arItem["PROPERTIES"]["FORM_TIMER_SHOW"]["VALUE"]?>">
                                                                    <input type="hidden" class="forCookieTime" value="<?=$arItem["PROPERTIES"]["FORM_TIMER_HIDE"]["VALUE"]?>">
                                                                    <input type="hidden" class="idSect" value="<?=$arSection["ID"]?>">
                                                                   

                                                                    <div class="hameltimer">

                                                                    <div class="numbers bold">
                                                                        <div class="timer-part timer_left">
                                                                            <span class='t-top'>{hnn}</span>
                                                                            <span class='t-bot'>{hl}</span>
                                                                        </div>
                                                                        <div class="sep">:</div>
                                                                        <div class="timer-part timer_center">
                                                                            <span class='t-top'>{mnn}</span>
                                                                            <span class='t-bot'>{ml}</span>
                                                                        </div>
                                                                        <div class="sep">:</div>
                                                                        <div class="timer-part timer_right">
                                                                            <span class='t-top'>{snn}</span>
                                                                            <span class='t-bot'>{sl}</span>
                                                                        </div>
                                                                    </div>
                                                                

                                                                    </div>

                                                                <?endif;?>


                                                                <div class="row">
                                                                
                                                                    <?if($arItem["PROPERTIES"]["FORM_ADMIN"]["VALUE_XML_ID"] == "light" || $arItem["PROPERTIES"]["FORM_ADMIN"]["VALUE_XML_ID"] == ""):?>
                                                                        
        
                                                                        <?if($arItem["PROPERTIES"]["FORM_RADIOCHECK"]["VALUE_XML_ID"] == "radio" || $arItem["PROPERTIES"]["FORM_RADIOCHECK"]["VALUE_XML_ID"] == "check"):?>
        
                                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                                                                <?if(strlen($arItem["PROPERTIES"]["FORM_LIST_TITLE"]["VALUE"]) > 0):?>

                                                                                    <div class="name-tit bold">
                                                                                        <?=$arItem["PROPERTIES"]["FORM_LIST_TITLE"]["~VALUE"]?>
                                                                                    </div>
                
                                                                                <?endif;?>
        
                                                                                 <?if($arItem["PROPERTIES"]["FORM_RADIOCHECK"]["VALUE_XML_ID"] == "radio" && is_array($arItem["PROPERTIES"]["FORM_LIST"]["VALUE"]) && !empty($arItem["PROPERTIES"]["FORM_LIST"]["VALUE"])):?>
        
                                                                                        <ul class="form-radio">
        
                                                                                            <?foreach($arItem["PROPERTIES"]["FORM_LIST"]["~VALUE"] as $k=>$arElement):?>
        
                                                                                                <li>
        
                                                                                                    <label>
        
                                                                                                        <input <?if($k == 0):?>checked <?endif;?> name='radiobutton<?=$arItem["ID"]?>' type="radio" value="<?=$arElement?>"><span></span><?=$arElement?>
        
                                                                                                    </label>
                                                                                                </li>
        
                                                                                            <?endforeach;?>
        
                                                                                        </ul>
        
                                                                                 <?elseif ($arItem["PROPERTIES"]["FORM_RADIOCHECK"]["VALUE_XML_ID"] == "check" && is_array($arItem["PROPERTIES"]["FORM_LIST"]["VALUE"]) && !empty($arItem["PROPERTIES"]["FORM_LIST"]["VALUE"])):?>
        
                                                                                     <ul class="form-check">
        
                                                                                        <?foreach($arItem["PROPERTIES"]["FORM_LIST"]["~VALUE"] as $k => $arElement):?>
        
                                                                                            <li>
                                                                                                <label>
                                                                                                    <input type="checkbox" name="checkbox<?=$arItem["ID"]?>[]" value="<?=$arElement?>">
                                                                                                    <span></span>                                                                          
                                                                                                    <span class="text"><?=$arElement?></span>
                                                                                                </label>
                                                                                            </li>
        
                                                                                        <?endforeach;?>
                                                     
                                                                                    </ul>

                                                                                <?endif;?>
        
                                                                                
        
                                                                            </div>
        
                                                                        <?endif;?>

                                                                        <?if(is_array($arItem["PROPERTIES"]["FORM_INPUTS"]["VALUE_XML_ID"]) && !empty($arItem["PROPERTIES"]["FORM_INPUTS"]["VALUE_XML_ID"])):?>

                                                                         
        
                                                                            <?foreach($arItem["PROPERTIES"]["FORM_INPUTS"]["VALUE_XML_ID"] as $k=>$arInput):?>
        
                                                                                <?if($arInput == "name"):?>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                        <div class="input">
                                                                                            <div class="bg"></div>
                                                                                            <span class="desc"><?=GetMessage('HAM_FORM_NAME')?></span>
                                                                                            <input class='focus-anim <?if(in_array("name", $arItem["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?>require<?endif;?>' name="name" type="text">
                                                                                            
                                                                                        </div>
                                                                                    </div>
                                                                                <?endif;?>
        
                                                                                <?if($arInput == "phone"):?>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                        <div class="input">

                                                                                            <div class="bg"></div>
                                                                                            <span class="desc"><?=GetMessage('HAM_FORM_PHONE')?></span>
        
                                                                                            <input class="phone focus-anim <?if(in_array("phone", $arItem["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?>require<?endif;?>" name="phone" type="text">
                                                                                        </div>
                                                                                    </div>
                                                                                <?endif;?>
        
                                                                                <?if($arInput == "email"):?>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                        <div class="input">
                                                                                            <div class="bg"></div>
                                                                                            <span class="desc"><?=GetMessage('HAM_FORM_EMAIL')?></span>
                                                                                            <input class="focus-anim email <?if(in_array("email", $arItem["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?>require<?endif;?>" name="email" type="text">
                                                                                            
                                                                                        </div>
                                                                                    </div>
                                                                                <?endif;?>
        
        
                                                                                <?if($arInput == "count"):?>
        
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                        <div class="input count <?if(in_array("count", $arItem["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?>require<?endif;?>">

                                                                                            <div class="bg"></div>
                                                                                            <span class="desc"><?=GetMessage('HAM_FORM_COUNT')?></span>
                                                                                            <input class='focus-anim <?if(in_array("count", $arItem["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?>require<?endif;?>' name="count" type="text"> <span class="plus"></span> <span class="minus"></span>
                                                                                        </div>
                                                                                    </div>
        
                                                                                <?endif;?>
        
        
                                                                                <?if($arInput == "date"):?>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                        <div class="input date-wrap <?if(in_array("date", $arItem["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?>require<?endif;?>">

                                                                                            <div class="bg"></div>
                                                                                            <span class="desc"><?=GetMessage('HAM_FORM_DATE')?></span>

                                                                                            <input class="date focus-anim <?if(in_array("date", $arItem["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?>require<?endif;?>" name="date" type="text">
                                                                                        </div>
                                                                                    </div>
                                                                                <?endif;?>
        
                                                                                <?if($arInput == "address"):?>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                        <div class="input input-textarea">

                                                                                            <div class="bg"></div>
                                                                                            <span class="desc"><?=GetMessage('HAM_FORM_ADDRESS')?></span>
                                                                                            <textarea class='focus-anim <?if(in_array("address", $arItem["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?>require<?endif;?>' name="address"></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                <?endif;?>
        
                                                                                <?if($arInput == "textarea"):?>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                        <div class="input input-textarea">
                                                                                            <div class="bg"></div>
                                                                                            <span class="desc"><?=GetMessage('HAM_FORM_TEXTAREA')?></span>
                                                                                            <textarea class='focus-anim <?if(in_array("textarea", $arItem["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?>require<?endif;?>' name="text"></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                <?endif;?>
        
                                                                                
        
                                                                                <?if($arInput == "file"):?>
        
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                        <div class="load-file">
                                                                                            <label><span class="area-file"><?=GetMessage('HAM_FORM_FILE')?></span> 
        
                                                                                            <input class="hidden <?if(in_array("file", $arItem["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?>require<?endif;?>" name="userfile" type="file">
        
                                                                                            <?if(in_array("file", $arItem["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?><span class="star-req"></span><?endif;?>
        
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
        
                                                                                <?endif;?>
        
                                                                            <?endforeach;?>
        
                                                                        <?endif;?>
                                                    
                                                                    <?elseif($arItem["PROPERTIES"]["FORM_ADMIN"]["VALUE_XML_ID"] == "professional"):?>

                                                                        <?if(!empty($arItem["PROPERTIES"]["FORM_PROP_INPUTS"]["VALUE"]) && is_array($arItem["PROPERTIES"]["FORM_PROP_INPUTS"]["VALUE"])):?>
                                                                    
                                                                            <?foreach($arItem["PROPERTIES"]["FORM_PROP_INPUTS"]["VALUE"] as $key=>$arValue):?>
                                                                                
                                                                                <?if(strlen($arValue) > 0):?>
                                                                                    
                                                                                    <?$type = $arItem["PROPERTIES"]["FORM_PROP_INPUTS"]["DESCRIPTION"][$key];?>
                                                                                    
                                                                                    <?$type = explode(";", ToLower($type));?>

                                                                                    <?if(!empty($type) && is_array($type)):?>
                                                                                    
                                                                                        <?foreach($type as $k=>$val):?>
                                                                                            <?$type[$k] = trim($val);?>
                                                                                        <?endforeach;?>

                                                                                    <?endif;?>
                                                                                    
                                                                                    
                                                                                    <?if($type[0] == "text"):?>
                                                                                        
                                                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                            <div class="input">
                                                                                                <div class="bg"></div>
                                                                                                <span class="desc"><?=$arValue?></span>
                                                                                                <input class='focus-anim <?if($type[1] == "y"):?>require<?endif;?>' name="input_<?=$arItem["ID"]?>_<?=$key?>" type="text" />
                                                                                                
                                                                                            </div>
                                                                                        </div>
                                                                                        
                                                                                    <?endif;?>
                                                                                    
                                                                                    
                                                                                    <?if($type[0] == "textarea"):?>
                                                                                        
                                                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                            <div class="input input-textarea">
                                                                                                <div class="bg"></div>
                                                                                                <span class="desc"><?=$arValue?></span>
                                                                                                <textarea class='focus-anim <?if($type[1] == "y"):?>require<?endif;?>' name="input_<?=$arItem["ID"]?>_<?=$key?>"></textarea>
                                                                                            </div>
                                                                                        </div>
         
                                                                                    <?endif;?>

                                                                                    <?if($type[0] == "name"):?>
                                                                                    
                                                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                            <div class="input">
                                                                                                <div class="bg"></div>
                                                                                                <span class="desc"><?=$arValue?></span>
                                                                                                <input class='focus-anim <?if($type[1] == "y"):?>require<?endif;?>' name="input_<?=$arItem["ID"]?>_<?=$key?>" type="text" />
                                                                                                
                                                                                            </div>
                                                                                        </div>
                                                                                        
                                                                                    <?endif;?>
                                                                                    
                                                                                    <?if($type[0] == "email"):?>
                                                                                    
                                                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                            <div class="input">
                                                                                                <div class="bg"></div>
                                                                                                <span class="desc"><?=$arValue?></span>
                                                                                                <input class="focus-anim email <?if($type[1] == "y"):?>require<?endif;?>" name="input_<?=$arItem["ID"]?>_<?=$key?>" type="text">
                                                                                                
                                                                                            </div>
                                                                                        </div>
                                                                                        
                                                                                    <?endif;?>
                                                                                    
                                                                                    <?if($type[0] == "phone"):?>
                                                                                           
                                                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                            <div class="input">
                                                                                                <div class="bg"></div>
                                                                                                <span class="desc"><?=$arValue?></span>
                                                                                                <input class="phone focus-anim <?if($type[1] == "y"):?>require<?endif;?>" name="input_<?=$arItem["ID"]?>_<?=$key?>" type="text">
                                                                                            </div>
                                                                                        </div>
                                                                        
                                                                                    <?endif;?>
                                                                                    
                                                                                    <?if($type[0] == "count"):?>
                                                                                                                                                 
                                                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                            <div class="input count <?if($type[1] == "y"):?>require<?endif;?>">
                                                                                                <div class="bg"></div>
                                                                                                <span class="desc"><?=$arValue?></span>
                                                                                                <input class="focus-anim <?if($type[1] == "y"):?>require<?endif;?>" name="input_<?=$arItem["ID"]?>_<?=$key?>" type="text"> <span class="plus"></span> <span class="minus"></span>
                                                                                            </div>
                                                                                        </div>
                                                                        
                                                                                    <?endif;?>
                                                                                    
                                                                                    <?if($type[0] == "date"):?>
                                                                                    
                                                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                            <div class="input date-wrap <?if($type[1] == "y"):?>require<?endif;?>">
                                                                                                <div class="bg"></div>
                                                                                                <span class="desc"><?=$arValue?></span>
                                                                                                <input class="date focus-anim <?if($type[1] == "y"):?>require<?endif;?>"  name="input_<?=$arItem["ID"]?>_<?=$key?>" type="text">
                                                                                            </div>
                                                                                        </div>
                                                                        
                                                                                    <?endif;?>
                                                                                    
                                                                                    <?if($type[0] == "password"):?>
                                                                                    
                                                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                            <div class="input">
                                                                                                <div class="bg"></div>
                                                                                                <span class="desc"><?=$arValue?></span>
                                                                                                <input class="focus-anim <?if($type[1] == "y"):?>require<?endif;?>" name="input_<?=$arItem["ID"]?>_<?=$key?>" type="password">
                                                                                                
                                                                                            </div>
                                                                                        </div>
                                                                                        
                                                                                    <?endif;?>
                                                                                    
                                                                                    
                                                                                    <?if($type[0] == "file"):?>
            
                                                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                            <div class="load-file">
                                                                                                <label><span class="area-file"><?=$arValue?></span> 
            
                                                                                                <input class="hidden <?if($type[1] == "y"):?>require<?endif;?>"  name="input_<?=$arItem["ID"]?>_<?=$key?>" type="file">
            
                                                                                                <?if($type[1] == "y"):?><span class="star-req"></span><?endif;?>
            
                                                                                                </label>
                                                                                            </div>
                                                                                        </div>
            
                                                                                    <?endif;?>
                                                                                    
                                                                                    
                                                                                    <?if($type[0] == "radio"):?>
                                                                                        
                                                                                        <?$list = explode(";", htmlspecialcharsBack($arValue));?>
                                                                                        
                                                                                        <?
                                                                                        $first = $list[0];
                                                                                        
                                                                                        if(substr_count($first, "<") > 0 && substr_count($first, ">") > 0)
                                                                                        {
                                                                                            $tit = str_replace(array("<", ">"), array("", ""), $first);
                                                                                            unset($list[0]);
                                                                                        }
                                                                                        
                                                                                        ?>
                                                                                    
                                                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                        
                                                                                            <?if(strlen($tit) > 0):?>
                                                                                                <div class="name-tit bold"><?=$tit?></div>
                                                                                            <?endif;?>
            
                                                                                            <ul class="form-radio">
                                                                                            
                                                                                                <?$c = 0;?>

                                                                                                <?if(!empty($list) && is_array($list)):?>
            
                                                                                                    <?foreach($list as $arElement):?>
                
                                                                                                        <li>
                
                                                                                                            <label>
                
                                                                                                                <input <?if($c == 0):?>checked <?endif;?> name='input_<?=$arItem["ID"]?>_<?=$key?>' type="radio" value="<?=$arElement?>"><span></span><?=$arElement?>
                
                                                                                                            </label>
                                                                                                        </li>
                                                                                                        
                                                                                                        <?$c++;?>
                
                                                                                                    <?endforeach;?>

                                                                                                <?endif;?>
            
                                                                                            </ul>

                                                                                        </div>
                                                                                    
                                                                                    <?endif;?>
                                                                                    
                                                                                    
                                                                                    <?if($type[0] == "checkbox"):?>
                                                                                        
                                                                                        <?$list = explode(";", htmlspecialcharsBack($arValue));?>
                                                                                        
                                                                                        <?
                                                                                        $first = $list[0];
                                                                                        
                                                                                        if(substr_count($first, "<") > 0 && substr_count($first, ">") > 0)
                                                                                        {
                                                                                            $tit1 = str_replace(array("<", ">"), array("", ""), $first);
                                                                                            unset($list[0]);
                                                                                        }
                                                                                        
                                                                                        ?>
                                                                                    
                                                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                        
                                                                                            <?if(strlen($tit1) > 0):?>
                                                                                                <div class="name-tit bold"><?=$tit1?></div>
                                                                                            <?endif;?>
            
                                                                                            <ul class="form-check">

                                                                                                <?if(!empty($list) && is_array($list)):?>
                                                                                            
                                                                                                    <?foreach($list as $arElement):?>
                
                                                                                                        <li>
                
                                                                                                            <label>
                
                                                                                                                <input name='input_<?=$arItem["ID"]?>_<?=$key?>[]' type="checkbox" value="<?=$arElement?>"><span></span><span class="text"><?=$arElement?></span>
                
                                                                                                            </label>
                                                                                                        </li>
                                                                                                        
                                                                                                    <?endforeach;?>

                                                                                                <?endif;?>
            
                                                                                            </ul>

                                                                                        </div>
                                                                                    
                                                                                    <?endif;?>

                                                                                    <?if($type[0] == "select"):?>
                                                                                        
                                                                                        <?$list = explode(";", htmlspecialcharsBack($arValue));?>
                                                                                        
                                                                                        <?
                                                                                        $first = $list[0];
                                                                                        
                                                                                        if(substr_count($first, "<") > 0 && substr_count($first, ">") > 0)
                                                                                        {
                                                                                            $tit2 = str_replace(array("<", ">"), array("", ""), $first);
                                                                                            unset($list[0]);
                                                                                        }
                                                                                        
                                                                                        ?>
                                                                                    
                                                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                                                                            <?if(strlen($tit2) > 0):?>
                                                                                                <div class="name-tit bold"><?=$tit2?></div>
                                                                                            <?endif;?>

                                                                                            <div class="input">
                                                                                        
                                                                                                <div class="form-select">
                                                                                                    <div class="ar-down"></div>
                                                                                                    
                                                                                                    <div class="select-list-choose first"><span class="list-area"><?=GetMessage('HAM_FORM_SELECT');?></span></div>

                                                                                                    <div class="select-list">

                                                                                                        <?if(!empty($list) && is_array($list)):?>
                                                                                                        <?foreach($list as $arElement):?>
                                                                                                            <label>
                                                                                                                <span class="name">
                                                                                                                    
                                                                                                                    <input class="opinion" type="radio" name='input_<?=$arItem["ID"]?>_<?=$key?>' value="<?=$arElement?>">
                                                                                                                    <span class="text"><?=$arElement?></span>
                                                                                                                    
                                                                                                                </span>
                                                                                                            </label>
                                                                                                        <?endforeach;?>

                                                                                                        <?endif;?>
                                                                                                    </div>
                                                                                                </div>

                                                                                            </div>
            
                                                                                         
                                                                                        </div>
                                                                                    
                                                                                    <?endif;?>

                                                                                <?endif;?>
                                                                                    
                                                                                
                                                                                    
                                                                            <?endforeach;;?>

                                                                        <?endif;?>
                                                                    
                                                                                                                                        
                                                                    <?endif;?>


                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <div class="input-btn">
                                                                            <div class="load">
                                                                                <div class="xLoader form-preload"><div class="audio-wave"><span></span><span></span><span></span><span></span><span></span></div></div>
                                                                            </div>

                                                                            <?
                                                                                $btn_name = GetMessage('PAGE_GENERATOR_FORM_SUBMIT');

                                                                                if(strlen($arItem['PROPERTIES']['FORM_BUTTON']['VALUE']) > 0)
                                                                                    $btn_name = $arItem['PROPERTIES']['FORM_BUTTON']['~VALUE'];
                                                                            ?>

                                                                            <button class="button-def primary big active <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?>" name="form-submit" type="submit" <?if(strlen($arItem["PROPERTIES"]["FORM_TO_LINK"]["VALUE"]) > 0):?> data-link='<?=$arItem["PROPERTIES"]["FORM_TO_LINK"]["VALUE"]?>'<?endif;?>>
                                                                                    <?=$btn_name?>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>

                                                                <?if(!empty($arSection["AGREEMENTS"])):?>

                                                                    <?$cAgr = count($arSection["AGREEMENTS"]);?>

                                                                    <div class="wrap-agree">

                                                                        <label>
                                                                            <input type="checkbox" name="checkboxAgree" value="agree" <?if($arSection["UF_CHAM_AGREEMENTS_Y"]):?> checked<?endif;?>>
                                                                            <span></span>   
                                                                        </label>   

                                                                        <div class="wrap-desc">                                                                    
                                                                            <span class="text"><?if(strlen($arSection["UF_CHAM_AGREE_TEXT"])>0):?><?=$arSection["~UF_CHAM_AGREE_TEXT"]?><?else:?><?=GetMessage('FORM_AGREEMENT')?><?endif;?> </span>
                                                                        
                                                                            <?foreach($arSection["AGREEMENTS"] as $countAg => $arAgreement):?>
                                                                                <a class="call-modal callagreement" data-call-modal="agreement<?=$arAgreement["ID"]?>"><?if(strlen($arAgreement["PROPERTIES"]['CASE_TEXT']['VALUE'])>0):?><?=$arAgreement["PROPERTIES"]['CASE_TEXT']['~VALUE']?><?else:?><?=$arAgreement['~NAME']?><?endif;?></a><?if(($countAg+1) != $cAgr):?><span>, </span><?endif;?> 
                                                                            <?endforeach;?>
                                                                        </div>

                                                                    </div>
                                                                <?endif;?>
                                                            </div>
                            
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 thank">
                                                                <?if(!empty($arItem['PROPERTIES']['FORM_THANKS']['VALUE'])):?>
                                                                    <?=$arItem['PROPERTIES']['FORM_THANKS']['~VALUE']["TEXT"]?>
                                                                <?else:?>
                                                                    <?=GetMessage('THANK')?>
                                                                <?endif;?>
                                                            </div>

                                                            <?if($timer_on):?>
                                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 timeout_text">
                                                                    <?if(!empty($arItem['PROPERTIES']['FORM_TIMER_TEXT']['VALUE'])):?>
                                                                        <?=$arItem['PROPERTIES']['FORM_TIMER_TEXT']['~VALUE']['TEXT']?>
                                                                    <?else:?>
                                                                        <?=GetMessage('HAMEL_TIMEOUT')?>
                                                                    <?endif;?>
                                                                </div>
                                                            <?endif;?>
                                                            
                                                        </td>
                                                    </tr>
                                                </table>
                                                
                                                <div class="clearfix">
                                                </div>
                                            </form>

                                        </div>

                                    </div>

                                    <?if($arItem["PROPERTIES"]["FORM_IMAGE"]["VALUE"] > 0 || strlen($arItem["PROPERTIES"]["FORM_TEXT_TITLE"]["~VALUE"]) > 0 || strlen($arItem["PROPERTIES"]["FORM_TEXT_UNDER_TITLE"]["~VALUE"]['TEXT']) > 0 ):?>
                                    
                                        <?if($arItem["PROPERTIES"]["FORM_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "right"):?> 
                                    
                                            <div class="form-cell image-part z-image right <?if($arItem["PROPERTIES"]["FORM_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["FORM_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "left"):?> hidden-lg hidden-md <?endif;?> <?=$arItem["PROPERTIES"]["FORM_IMAGE_POSITION"]["VALUE_XML_ID"]?>">
                                            
                                            
                                                <?if(strlen($arItem["PROPERTIES"]["FORM_TEXT_TITLE"]["~VALUE"]) || strlen($arItem["PROPERTIES"]["FORM_TEXT_UNDER_TITLE"]["~VALUE"]['TEXT']) > 0 ):?>

                                                    <div class="text-wrap <?=$arItem["PROPERTIES"]["FORM_TEXT_TITLE_COLOR"]["VALUE_XML_ID"]?>">
                                                    
                                                        <?if($arItem["PROPERTIES"]["FORM_UPLINE"]["VALUE"] == 'Y'):?>
                                                            <div class="line main-color"></div>
                                                        <?endif;?>
    
                                                        <?if(strlen($arItem["PROPERTIES"]["FORM_TEXT_TITLE"]["~VALUE"])> 0):?>
                                                            <div class="form-text-title bold"><?=$arItem["PROPERTIES"]["FORM_TEXT_TITLE"]["~VALUE"]?></div>
                                                        <?endif;?>
    
                                                        <?if(strlen($arItem["PROPERTIES"]["FORM_TEXT_UNDER_TITLE"]["~VALUE"]['TEXT'])> 0):?>
                                                            <div class="form-text-under-title italic"><?=$arItem["PROPERTIES"]["FORM_TEXT_UNDER_TITLE"]["~VALUE"]['TEXT']?></div>
                                                        <?endif;?>
    
                                                    </div>
    
                                                <?endif;?>

                                                <?if($arItem["PROPERTIES"]["FORM_IMAGE"]["VALUE"] > 0):?>
                                            
                                                    <?$img = CFile::ResizeImageGet($arItem["PROPERTIES"]["FORM_IMAGE"]["VALUE"], array('width'=>700, 'height'=>1500), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                                
                                                    <img alt="" class="img-responsive hidden-xs" src="<?=$img["src"]?>" />

                                                <?endif;?>
                                            
                                            </div>

                                        <?endif;?>
                                        
                                    <?endif;?>

                                </div>
                                
                            </div>
                            
                        <?endif;?>
                        
                        <?//form end?>
                        
                        
                        <?//video?>
                        
                        <?if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "video"):?>
                            
                            <div class="video-block col-lg-12 col-md-12 col-sm-12 col-xs-12 clearfix">

                                <?if(count($arItem["PROPERTIES"]["VIDEO_BLOCK_CODE"]["VALUE"]) <= 1):?>
                                
                                    <?if(strlen($arItem["PROPERTIES"]["VIDEO_BLOCK_CODE"]["VALUE"][0]) > 0):?>

                                        <?if(strlen($arItem["PROPERTIES"]["VIDEO_BLOCK_PICTURES"]["VALUE"][0]) > 0)
                                            $img = CFile::ResizeImageGet($arItem["PROPERTIES"]["VIDEO_BLOCK_PICTURES"]["VALUE"][0], array('width'=>800, 'height'=>480), BX_RESIZE_IMAGE_PROPORTIONAL, false);
                                        ?>

                                        <div class="video-content">
                                        
                                            <?preg_match("/^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/",$arItem["PROPERTIES"]["VIDEO_BLOCK_CODE"]["VALUE"][0],$out);?>
                                            
                                            <?if(strlen($arItem["PROPERTIES"]["VIDEO_BLOCK_PICTURES"]["VALUE"][0])<=0):?>
        
                                                <iframe allowfullscreen="" frameborder="0" height="100%" src="https://www.youtube.com/embed/<?=$out[1]?>?rel=0&amp;controls=1&amp;showinfo=0" width="100%"></iframe>

                                            <?else:?>
                                                <a class="call-modal callvideo big-play" data-call-modal="<?=$out[1]?>"></a>
                                            <?endif;?>
                                            
                                        </div>

                                        <?if(strlen($arItem["PROPERTIES"]["VIDEO_BLOCK_CODE"]["DESCRIPTION"][0])>0):?>
                                            <div class="desc-one"><?=$arItem["PROPERTIES"]["VIDEO_BLOCK_CODE"]["DESCRIPTION"][0]?></div>
                                        <?endif;?>
                                    
                                    <?endif;?>
                                    
                                <?else:?>

                                    <?
                                        $countVideo = count($arItem["PROPERTIES"]["VIDEO_BLOCK_CODE"]["VALUE"]);
                                        $class="";
                                        $offsetClass = "";

                                        if($countVideo == 2)
                                        {
                                            $offsetClass = 'col-lg-offset-1 col-md-offset-0 col-sm-offset-0 col-xs-offset-0';
                                            $class="col-lg-5 col-md-6 col-sm-6 col-xs-6";
                                        }

                                        else
                                        {

                                            $arNeed = array(
                                                "0.25" => array("OFFSET"=>"col-lg-offset-four col-md-offset-four col-sm-offset-one col-xs-offset-four", "NUM" => 0), 
                                                "0.5" => array("OFFSET"=>"col-lg-offset-3 col-md-offset-3 col-sm-offset-3 col-xs-offset-3", "NUM" => 1), 
                                                "0.75" =>  array("OFFSET"=>"col-lg-offset-one col-md-offset-one col-sm-offset-2 col-xs-offset-one", "NUM" => 2));

                                            $residual = $countVideo / 4;

                                            if($countVideo > 4)
                                            {
                                                $residual = $residual - floor($residual);
                                            }
                                            $residual = strval($residual);
                                            $needKey = $countVideo - $arNeed[$residual]["NUM"];

                                            $class="col-lg-3 col-md-3 col-sm-3 col-xs-3";

                                        }
                                    ?>



                                    <?if(is_array($arItem["PROPERTIES"]["VIDEO_BLOCK_CODE"]["VALUE"]) && !empty($arItem["PROPERTIES"]["VIDEO_BLOCK_CODE"]["VALUE"])):?>
                                        <div class="row ">
                                            
                                            <div class="video-gallery-wrap <?if($countVideo == 2):?>two-video<?endif;?> clearfix">

                                            <?foreach($arItem["PROPERTIES"]["VIDEO_BLOCK_CODE"]["VALUE"] as $k=>$arVideo):?>

                                                <?
                                                    if(strlen($arItem["PROPERTIES"]["VIDEO_BLOCK_PICTURES"]["VALUE"][$k])>0)
                                                    {
                                                        if($countVideo == 2)
                                                            $img = CFile::ResizeImageGet($arItem["PROPERTIES"]["VIDEO_BLOCK_PICTURES"]["VALUE"][$k], array('width'=>460, 'height'=>230), BX_RESIZE_IMAGE_EXACT, false); 
                                                        
                                                        else
                                                            $img = CFile::ResizeImageGet($arItem["PROPERTIES"]["VIDEO_BLOCK_PICTURES"]["VALUE"][$k], array('width'=>300, 'height'=>150), BX_RESIZE_IMAGE_EXACT, false); 
                                                    }

                                                    else
                                                        $img["src"] = SITE_TEMPLATE_PATH."/images/video-pic.jpg";
                                                ?>

                                                <div class="video-gallery <?=$class?><?if($k == 0):?> <?=$offsetClass?><?endif;?><?if(($k+1) == $needKey):?> <?=$arNeed[$residual]["OFFSET"]?><?endif;?>">
                                                    <div class="video-gallery-element">

                                                    <?preg_match("/^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/", $arVideo, $out);?>     
                                                        <table class="videoimage-wrap" style='background-image: url(<?=$img["src"]?>);'>
                                                            <tr>
                                                                <td>
                                                                    <a class="call-modal callvideo" data-call-modal="<?=$out[1]?>">       
                                                                        <div class="play"></div>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </table>

                                                        <?if(strlen($arItem["PROPERTIES"]["VIDEO_BLOCK_CODE"]["DESCRIPTION"][$k])>0):?>
                                                            <div class="desc"><?=$arItem["PROPERTIES"]["VIDEO_BLOCK_CODE"]["DESCRIPTION"][$k]?></div>
                                                        <?endif;?>
                                                    </div>

                                                </div>  

                                                <?if(($k+1) % 4 == 0):?>
                                                    <div class="clearfix"></div>    
                                                <?endif;?>

                                            <?endforeach;?>

                                            </div>
                                        </div>
                                    <?endif;?>

                                <?endif;?>

                                <?if(strlen($arItem["DETAIL_TEXT"]) > 0):?>

                                    <div class="text text-content <?=$arItem["PROPERTIES"]["VIDEO_BLOCK_COLOR"]["VALUE_XML_ID"]?>">
                                        <?=$arItem["~DETAIL_TEXT"]?>
                                    </div>

                                <?endif;?>
                            
                            </div>
                            
                        <?endif;?>
                        <?//video end?>

                        <?//tariffs?>
                        <?if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "tariff"):?>
                            
                            <?if($arItem["PROPERTIES"]["TARIFF_VIEW"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["TARIFF_VIEW"]["VALUE_XML_ID"] == "flat"):?>

                                <?
                                    $class = "";
                                    $count = count($arItem["ELEMENTS"]);
                                    
                                    if($count <= 3)
                                    {
                                        $class = "col-lg-4 col-md-4 col-sm-4 col-xs-12";
                                        $col_lg = 3;
                                        $col_md = 3;
                                        $col_sm = 3;
                                    }
                                    else
                                    {
                                        $class = "col-lg-3 col-md-3 col-sm-6 col-xs-12 four-elements";
                                        $col_lg = 4;
                                        $col_md = 4;
                                        $col_sm = 2;
                                    }
                                    
                                    $class2 = "";
                                    
                                    if($count == 1)
                                        $class2 = "col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-0";

                                    elseif($count == 2)
                                        $class2 = "col-lg-offset-2 col-md-offset-2 col-sm-offset-0 col-xs-offset-0";
                                ?>
                            
                                <div class="tarif col-lg-12 col-md-12 col-sm-12 col-xs-12 clearfix <?if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y"):?>parent-animate<?endif;?>" <?if($arItem["PROPERTIES"]["TARIFF_ROUND_HEIGHT"]["VALUE"] == "Y"):?> data-round-height = "Y" data-col-lg="<?=$col_lg?>" data-col-md="<?=$col_md?>" data-col-sm="<?=$col_sm?>"<?endif;?>>

                                    <?if(is_array($arItem["ELEMENTS"]) && !empty($arItem["ELEMENTS"])):?>
                                    
                                        <?foreach($arItem["ELEMENTS"] as $k=>$arTariff):?>

                                            <div class="tarif-item <?=$class?> <?if($k==0):?><?=$class2?><?endif;?>">

                                                <div class="row">
                                                    
                                                    <div class="tarif-element no-margin-top-bot <?if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y"):?>child-animate opacity-zero<?endif;?>">

                                                        <div class="tarif-element-inner">

                                                            <div class="trff-top-part">
                                                    
                                                                <?if($arTariff["PROPERTIES"]["TARIFF_HIT"]["VALUE"] == "Y"):?><div class="star"></div><?endif;?>
                                                            
                                                                <?if(strlen($arTariff["PROPERTIES"]["TARIFF_NAME"]["VALUE"]) > 0):?>
                                                                    <div class="name main1">
                                                                        <?=$arTariff["PROPERTIES"]["TARIFF_NAME"]["~VALUE"]?>
                                                                    </div>
                                                                <?endif;?>

                                                                <?if($arTariff["PROPERTIES"]["TARIFF_PICTURE"]["VALUE"] > 0):?>
                                                                    
                                                                    <?$img = CFile::ResizeImageGet($arTariff["PROPERTIES"]["TARIFF_PICTURE"]["VALUE"], array('width'=>300, 'height'=>300), BX_RESIZE_IMAGE_PROPORTIONAL, false, false, false, $img_quality); ?>

                                                                    
                                                                    <?if((!empty($arTariff["PROPERTIES"]["TARIFF_DETAIL_TEXT"]["VALUE"])) || (!empty($arTariff["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"]) && is_array($arTariff["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"]))):?>
                                                                        <a class="btn-modal-open" data-header="<?=$block_name?>" data-site-id='<?=SITE_ID?>' data-detail="tariff" data-element-id="<?=$arTariff["ID"]?>"  data-all-id = "<?=implode("," , $arItem["ID_ALL"])?>">
                                                                    <?endif;?>
                                                                    
                                                                    <img class="image" src="<?=$img["src"]?>" />
                                                                        
                                                                     <?if((!empty($arTariff["PROPERTIES"]["TARIFF_DETAIL_TEXT"]["VALUE"])) || (!empty($arTariff["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"]) && is_array($arTariff["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"]))):?>
                                                                        </a>
                                                                    <?endif;?>
                                                                
                                                                <?endif;?>
                                                                
                                                                <?if(strlen($arTariff["PROPERTIES"]["TARIFF_PREVIEW_TEXT"]["VALUE"]) > 0):?>
                                                                    <div class="tarif-descript italic">
                                                                        <?=$arTariff["PROPERTIES"]["TARIFF_PREVIEW_TEXT"]["~VALUE"]?>
                                                                    </div>
                                                                <?endif;?>
                                                                
                                                                <?if(!empty($arTariff["PROPERTIES"]["TARIFF_INCLUDE"]["VALUE"]) || !empty($arTariff["PROPERTIES"]["TARIFF_INCLUDE"]["VALUE"])):?>
                                                                
                                                                    <ul>
                                                                        
                                                                        <?if(is_array($arTariff["PROPERTIES"]["TARIFF_INCLUDE"]["VALUE"]) && !empty($arTariff["PROPERTIES"]["TARIFF_INCLUDE"]["VALUE"])):?>
                                                                            
                                                                            <?foreach($arTariff["PROPERTIES"]["TARIFF_INCLUDE"]["~VALUE"] as $val):?>
                                                                                <li class="point-green"><?=$val?></li>
                                                                            <?endforeach;?>
                                                                            
                                                                        <?endif;?>
                                                                        
                                                                        <?if(is_array($arTariff["PROPERTIES"]["TARIFF_NOT_INCLUDE"]["VALUE"]) && !empty($arTariff["PROPERTIES"]["TARIFF_NOT_INCLUDE"]["VALUE"])):?>
                                                                            
                                                                            <?foreach($arTariff["PROPERTIES"]["TARIFF_NOT_INCLUDE"]["~VALUE"] as $val):?>
                                                                                <li><?=$val?></li>
                                                                            <?endforeach;?>
                                                                            
                                                                        <?endif;?>
                                                                        
                                                                    </ul>
                                                                
                                                                <?endif;?>

                                                            </div>

                                                            <div class="trff-bot-part">
                                                            
                                                                <?if((!empty($arTariff["PROPERTIES"]["TARIFF_INCLUDE"]["VALUE"]) || !empty($arTariff["PROPERTIES"]["TARIFF_INCLUDE"]["VALUE"])) && (strlen($arTariff["PROPERTIES"]["TARIFF_PRICE"]["VALUE"]) > 0 || strlen($arTariff["PROPERTIES"]["TARIFF_OLD_PRICE"]["VALUE"]) > 0)):?>
                                                                    <div class="line-grey"></div>
                                                                <?endif;?>
                                                                
                                                                <?if(strlen($arTariff["PROPERTIES"]["TARIFF_PRICE"]["VALUE"]) > 0 || strlen($arTariff["PROPERTIES"]["TARIFF_OLD_PRICE"]["VALUE"]) > 0):?>
                                                                    
                                                                    <div class="price-wrap">
                                                                        
                                                                        <?if(strlen($arTariff["PROPERTIES"]["TARIFF_OLD_PRICE"]["VALUE"]) > 0):?>
                                                                            <div class="old-price main2"><?=$arTariff["PROPERTIES"]["TARIFF_OLD_PRICE"]["~VALUE"]?></div>
                                                                        <?endif;?>
                
                                                                        <?if(strlen($arTariff["PROPERTIES"]["TARIFF_PRICE"]["VALUE"]) > 0):?>
                                                                            <div class="price main1"><?=$arTariff["PROPERTIES"]["TARIFF_PRICE"]["~VALUE"]?></div>
                                                                        <?endif;?>
                                                                        
                                                                    </div>
                                                                
                                                                <?endif;?>
                
                                                                
                                                                <?if(strlen($arTariff["PROPERTIES"]["TARIFF_BUTTON_TYPE"]["VALUE_XML_ID"]) <= 0):?>
                                                                    <?$arTariff["PROPERTIES"]["TARIFF_BUTTON_TYPE"]["VALUE_XML_ID"] = "form";?>
                                                                <?endif;?>
                                                                
                                                                <?if((strlen($arTariff["PROPERTIES"]["TARIFF_BUTTON_NAME"]["VALUE"]) > 0) || (!empty($arTariff["PROPERTIES"]["TARIFF_DETAIL_TEXT"]["VALUE"]) || !empty($arTariff["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"]))):?>
                                                                
                                                                    <div class="bot-wrap no-margin-top-bot">
                                                                        
                                                                        <?if(strlen($arTariff["PROPERTIES"]["TARIFF_BUTTON_NAME"]["VALUE"]) > 0):?>

                                                                            <div class="button-wrap">

                                                                                <a <?if(strlen($arTariff["PROPERTIES"]["TARIFF_BUTTON_ONCLICK"]["VALUE"])>0) echo "onclick='".$arTariff["PROPERTIES"]["TARIFF_BUTTON_ONCLICK"]["VALUE"]."'";?> class="button-def primary more-modal-info <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?> <?=hamButtonEditClass ($arTariff["PROPERTIES"]["TARIFF_BUTTON_TYPE"]["VALUE_XML_ID"], $arTariff["PROPERTIES"]["TARIFF_BUTTON_FORM"]["VALUE"], $arTariff["PROPERTIES"]["TARIFF_MODAL"]["VALUE"])?><?if($count <= 3):?> big<?else:?> medium<?endif;?>" data-element-type = "TRF" <?=hamButtonEditAttr($arTariff["PROPERTIES"]["TARIFF_BUTTON_TYPE"]["VALUE_XML_ID"], $arTariff["PROPERTIES"]["TARIFF_BUTTON_FORM"]["VALUE"], $arTariff["PROPERTIES"]["TARIFF_MODAL"]["VALUE"], $arTariff["PROPERTIES"]["TARIFF_BUTTON_LINK"]["VALUE"], $arTariff["PROPERTIES"]["TARIFF_BUTTON_BLANK"]["VALUE_XML_ID"], $block_name, $arTariff["PROPERTIES"]["TARIFF_BUTTON_QUIZ"]["VALUE"], $arTariff["ID"])?>><?if(strlen($arTariff["PROPERTIES"]["TARIFF_BUTTON_NAME"]["VALUE"]) > 0):?><?=$arTariff["PROPERTIES"]["TARIFF_BUTTON_NAME"]["~VALUE"]?><?endif;?></a>
                                                                            </div>

                                                                          
                                                                        
                                                                        <?endif;?>
                            
                                                                        <?if(!empty($arTariff["PROPERTIES"]["TARIFF_DETAIL_TEXT"]["VALUE"]) || !empty($arTariff["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"])):?>
                                                                            <div class="link-wrap no-margin-top-bot">
                                                                                <a class="link-def btn-modal-open" data-header="<?=$block_name?>"  data-all-id = "<?=implode("," , $arItem["ID_ALL"])?>" data-site-id='<?=SITE_ID?>' data-detail="tariff"  data-element-id="<?=$arTariff["ID"]?>"><i class="fa fa-info" aria-hidden="true"></i><span class="bord"><?if(strlen($arSection['~UF_MORE_NAME_TRFF'])>0)echo $arSection['~UF_MORE_NAME_TRFF']; else echo GetMessage("MORE_DETAIL");?></span></a>
                                                                            </div>
                                                                            
                                                                        <?endif;?>
                                                                    </div>
                                                                
                                                                <?endif;?>

                                                            </div>

                                                        </div>
                                                        
                                                    
                                                    </div>
                                                    
                                                </div>

                                                <?admin_setting($arTariff)?>

                                            </div>

                                            <?
                                                if($count <= 3)
                                                {
                                                    if(($k+1)%3 == 0)
                                                        echo "<span class='clearfix visible-lg visible-md visible-sm'></span>";
                                                }

                                                else
                                                {
                                                    if(($k+1)%2 == 0)
                                                        echo "<span class='clearfix visible-sm'></span>";
                                                    if(($k+1)%4 == 0)
                                                        echo "<span class='clearfix visible-lg visible-md'></span>";
                                                }
                                            ?>

                                            <?
                                                if($count > 3)
                                                {
                                                    if( ($k+1) % 4 == 0)
                                                        $row++;
                                            
                                                }
                                            ?>
                                            
                                        <?endforeach;?>
                                    
                                    <?endif;?>
                                    
                                </div>
                                                
                            <?endif;?>
                            
                            
                            <?if($arItem["PROPERTIES"]["TARIFF_VIEW"]["VALUE_XML_ID"] == "full"):?>
                                
                                <div class="tarif-2 <?=$arItem["PROPERTIES"]["TARIFF_TEXT_COLOR"]["VALUE_XML_ID"]?> clearfix">

                                    <?
                                        if($arItem["PROPERTIES"]["TARIFF_PICTURE"]["VALUE"] > 0)
                                            $img = CFile::ResizeImageGet($arItem["PROPERTIES"]["TARIFF_PICTURE"]["VALUE"], array('width'=>500, 'height'=>500), BX_RESIZE_IMAGE_PROPORTIONAL, false);
                                        

                                    ?>

                                                                
                                    <div class="tarif-table">
        
                                        <div class="tarif-cell text-part no-margin-top-bot <?if($arItem["PROPERTIES"]["TARIFF_PICTURE"]["VALUE"] > 0):?>col-lg-7 col-md-7 col-sm-12 col-xs-12<?else:?>col-lg-12 col-md-12 col-sm-12 col-xs-12<?endif;?> <?if($arItem["PROPERTIES"]["TARIFF_PICTURE_POSITION"]["VALUE_XML_ID"] == "left"):?>col-lg-push-5 col-md-push-5 col-sm-push-0 col-xs-push-0<?endif;?>">
                                        
                                            <?if(strlen($arItem["PROPERTIES"]["TARIFF_NAME"]["VALUE"]) > 0):?>
                                                <div class="title main1">
                                                    <?=$arItem["PROPERTIES"]["TARIFF_NAME"]["~VALUE"]?> <?if($arItem["PROPERTIES"]["TARIFF_HIT"]["VALUE"] == "Y"):?><span class="hit"></span><?endif;?>
                                                </div>
                                            <?endif;?>
            
                                            <?if(strlen($arItem["PROPERTIES"]["TARIFF_PREVIEW_TEXT"]["VALUE"]) > 0):?>
                                                <div class="subtitle italic">
                                                    <?=$arItem["PROPERTIES"]["TARIFF_PREVIEW_TEXT"]["~VALUE"]?>
                                                </div>
                                            <?endif;?>
                                            
                                            
                                            <div class="tarif-body no-margin-top-bot">
                                                <?if($arItem["PROPERTIES"]["TARIFF_PICTURE"]["VALUE"] > 0):?>

                                                    <noindex>

                                                        <div class="image-hidden visible-sm visible-xs">

                                                            <?if((!empty($arItem["PROPERTIES"]["TARIFF_DETAIL_TEXT"]["VALUE"])) || (!empty($arItem["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"]) && is_array($arItem["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"]))):?>
                                                                <a class="btn-modal-open" data-header="<?=$block_name?>" data-site-id='<?=SITE_ID?>' data-detail="tariff" data-element-id="<?=$arItem["ID"]?>"  data-all-id = "<?=implode("," , $arItem["ID_ALL"])?>">
                                                            <?endif;?>
                                                        
                                                            <img alt="<?=$arItem["NAME"]?>" class="img-responsive" src="<?=$img["src"]?>" />
                                                            
                                                            <?if((!empty($arItem["PROPERTIES"]["TARIFF_DETAIL_TEXT"]["VALUE"])) || (!empty($arItem["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"]) && is_array($arItem["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"]))):?>
                                                                </a>
                                                            <?endif;?>

                                                        </div>

                                                    </noindex>

                                                <?endif;?>
                                            
                                                <?if(strlen($arItem["PROPERTIES"]["TARIFF_PRICE"]["VALUE"]) > 0 || strlen($arItem["PROPERTIES"]["TARIFF_OLD_PRICE"]["VALUE"]) > 0):?>
                                                
                                                    <div class="list-wrap">
    
                                                        <div class="price-wrap">
                                                        
                                                            <?if(strlen($arItem["PROPERTIES"]["TARIFF_OLD_PRICE"]["VALUE"]) > 0):?>
                                                                <div class="old-price main2"><?=$arItem["PROPERTIES"]["TARIFF_OLD_PRICE"]["~VALUE"]?></div>
                                                            <?endif;?>
            
                                                            <?if(strlen($arItem["PROPERTIES"]["TARIFF_PRICE"]["VALUE"]) > 0):?>
                                                                <div class="price main1"><?=$arItem["PROPERTIES"]["TARIFF_PRICE"]["~VALUE"]?></div>
                                                            <?endif;?>
                                                            
                                                        </div>
                                                        
                                                    </div>
                                                
                                                <?endif;?>
                                            
                                                
                                                <?if(!empty($arItem["PROPERTIES"]["TARIFF_INCLUDE"]["VALUE"]) || !empty($arItem["PROPERTIES"]["TARIFF_INCLUDE"]["VALUE"])):?>
                                            
                                                    <div class="list-wrap">
                                                        <div class="row clearfix">
                                                        
                                                            <?if(is_array($arItem["PROPERTIES"]["TARIFF_INCLUDE"]["VALUE"]) && !empty($arItem["PROPERTIES"]["TARIFF_INCLUDE"]["VALUE"])):?>
                                                            
                                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                              
                                                                    <ul class="adv-plus-minus">
                                                                        
                                                                        <?foreach($arItem["PROPERTIES"]["TARIFF_INCLUDE"]["~VALUE"] as $val):?>
                                                                            <li class="point-green"><?=$val?></li>
                                                                        <?endforeach;?>
                                                                    
                                                                    </ul>
    
                                                                </div>
                                                            
                                                            <?endif;?>
                                                            
                                                            <?if(is_array($arItem["PROPERTIES"]["TARIFF_NOT_INCLUDE"]["VALUE"]) && !empty($arItem["PROPERTIES"]["TARIFF_NOT_INCLUDE"]["VALUE"])):?>
                                                             
                                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                
                                                                    
                                                                    <ul class="adv-plus-minus">
                                                                        
                                                                        <?foreach($arItem["PROPERTIES"]["TARIFF_NOT_INCLUDE"]["~VALUE"] as $val):?>
                                                                            <li><?=$val?></li>
                                                                        <?endforeach;?>
         
                                                                    </ul>
                                                                    
                                                                </div>
                                                            
                                                            <?endif;?>
                                                            
                                                        </div>
                                                    </div>
                                                
                                                <?endif;?>
                                                
                                                <?if(!empty($arItem["PROPERTIES"]["TARIFF_PRICES"]["VALUE"])):?>
            
                                                    <div class="list-wrap last">
                                                    
                                                        <?if(strlen($arItem["PROPERTIES"]["TARIFF_PRICES_TITLE"]["VALUE"]) > 0):?>
                                                            <div class="name main1"><?=$arItem["PROPERTIES"]["TARIFF_PRICES_TITLE"]["~VALUE"]?></div>
                                                        <?endif;?>
                
                
                                                        <ul class="list-char">
                                                            
                                                            <?foreach($arItem["PROPERTIES"]["TARIFF_PRICES"]["VALUE"] as $k=>$val):?>
                                                                <li class="clearfix">
                                                                
                                                                    <table>
                                                                        <tr>
                                                                            <td class="left">
                                                                                <div class="left"><?=$val?></div>
                                                                            </td>
                                                                            
                                                                            <td class="dotted">
                                                                                <div class="dotted"></div>
                                                                            </td>
                                                                            
                                                                            <td class="right">
                                                                                <div class="main1 right"><?=$arItem["PROPERTIES"]["TARIFF_PRICES"]["~DESCRIPTION"][$k]?></div>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                
                                                                </li>
                                                            <?endforeach;?>
    
                                                        </ul>
                                                    </div>
                                                
                                                <?endif;?>
                                                
                                                <?if(strlen($arItem["PROPERTIES"]["TARIFF_BUTTON_TYPE"]["VALUE_XML_ID"]) <= 0):?>
                                                    <?$arItem["PROPERTIES"]["TARIFF_BUTTON_TYPE"]["VALUE_XML_ID"] = "form";?>
                                                <?endif;?>
                                                

                                               
                                                <?if((strlen($arItem["PROPERTIES"]["TARIFF_BUTTON_NAME"]["VALUE"]) > 0) || (!empty($arItem["PROPERTIES"]["TARIFF_DETAIL_TEXT"]["VALUE"]) || !empty($arItem["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"]))):?>
            
                                                    <div class="buttons-wrap no-margin-left-right">
                                                    
                                                        <?if(strlen($arItem["PROPERTIES"]["TARIFF_BUTTON_NAME"]["VALUE"]) > 0):?>

                                                            <?if(($arItem["PROPERTIES"]["TARIFF_BUTTON_TYPE"]["VALUE_XML_ID"] == "modal") || ($arItem["PROPERTIES"]["TARIFF_BUTTON_TYPE"]["VALUE_XML_ID"] == "form") || ($arItem["PROPERTIES"]["TARIFF_BUTTON_TYPE"]["VALUE_XML_ID"] == "quiz") || ($arItem["PROPERTIES"]["TARIFF_BUTTON_TYPE"]["VALUE_XML_ID"] == "block" && strlen($arItem["PROPERTIES"]["TARIFF_BUTTON_LINK"]["VALUE"])>0) || ($arItem["PROPERTIES"]["TARIFF_BUTTON_TYPE"]["VALUE_XML_ID"] == "blank" && strlen($arItem["PROPERTIES"]["TARIFF_BUTTON_LINK"]["VALUE"])>0)):?>
                  
                                                                <div class="button-child">

                                                                    <a <?if(strlen($arItem["PROPERTIES"]["TARIFF_BUTTON_ONCLICK"]["VALUE"])>0) echo "onclick='".$arItem["PROPERTIES"]["TARIFF_BUTTON_ONCLICK"]["VALUE"]."'";?> class="button-def more-modal-info <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?> primary big <?=hamButtonEditClass ($arItem["PROPERTIES"]["TARIFF_BUTTON_TYPE"]["VALUE_XML_ID"], $arItem["PROPERTIES"]["TARIFF_BUTTON_FORM"]["VALUE"], $arItem["PROPERTIES"]["TARIFF_MODAL"]["VALUE"])?><?if($count <= 3):?> big<?else:?> medium<?endif;?>" data-element-type = "TRF" <?=hamButtonEditAttr($arItem["PROPERTIES"]["TARIFF_BUTTON_TYPE"]["VALUE_XML_ID"], $arItem["PROPERTIES"]["TARIFF_BUTTON_FORM"]["VALUE"], $arItem["PROPERTIES"]["TARIFF_MODAL"]["VALUE"], $arItem["PROPERTIES"]["TARIFF_BUTTON_LINK"]["VALUE"], $arItem["PROPERTIES"]["TARIFF_BUTTON_BLANK"]["VALUE_XML_ID"], $block_name, $arItem["PROPERTIES"]["TARIFF_BUTTON_QUIZ"]["VALUE"], $arItem["ID"])?>><?if(strlen($arItem["PROPERTIES"]["TARIFF_BUTTON_NAME"]["VALUE"]) > 0):?><?=$arItem["PROPERTIES"]["TARIFF_BUTTON_NAME"]["~VALUE"]?><?endif;?></a>
                                                                </div>

                                                            <?endif;?>

                                                        <?endif;?>

               
                                                        <?if(!empty($arItem["PROPERTIES"]["TARIFF_DETAIL_TEXT"]["VALUE"]) || !empty($arItem["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"])):?>

                                                            <?
                                                                $sec_btn_name = GetMessage("MORE_DETAIL");
                                                                if(strlen($arSection['~UF_MORE_NAME_TRFF'])>0)
                                                                    $sec_btn_name = $arSection['~UF_MORE_NAME_TRFF'];
                                                            ?>
                
                                                            <div class="button-child">
                                                                <a class="button-def secondary big btn-modal-open <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?>" data-header="<?=$block_name?>" data-all-id = "<?=implode("," , $arItem["ID_ALL"])?>" data-site-id='<?=SITE_ID?>' data-detail="tariff"  data-element-id="<?=$arItem["ID"]?>">
                                                                    <i class="fa fa-info" aria-hidden="true"></i>
                                                                    <?=$sec_btn_name?>
                                                                </a>
                                                            </div>
                                                        
                                                        <?endif;?>
                                                        
                                                    </div>
                                                
                                                <?endif;?>
                                                
                                            </div>

                                        </div>
            
                                        <?if($arItem["PROPERTIES"]["TARIFF_PICTURE"]["VALUE"] > 0):?>
                                        
                                            <div class="tarif-cell image-part hidden-sm hidden-xs col-lg-5 col-md-5 col-sm-0 col-xs-12 <?if($arItem["PROPERTIES"]["TARIFF_PICTURE_POSITION"]["VALUE_XML_ID"] == "left"):?>col-lg-pull-7 col-md-pull-7 col-sm-pull-0 col-xs-pull-0<?endif;?>">
                                                
                                                <?if((!empty($arItem["PROPERTIES"]["TARIFF_DETAIL_TEXT"]["VALUE"])) || (!empty($arItem["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"]) && is_array($arItem["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"]))):?>
                                                    <a class="btn-modal-open" data-header="<?=$block_name?>" data-site-id='<?=SITE_ID?>' data-detail="tariff" data-element-id="<?=$arItem["ID"]?>"  data-all-id = "<?=implode("," , $arItem["ID_ALL"])?>">
                                                <?endif;?>
                                            
                                                <img alt="<?=$arItem["NAME"]?>" class="img-responsive center-block" src="<?=$img["src"]?>" />
                                                
                                                <?if((!empty($arItem["PROPERTIES"]["TARIFF_DETAIL_TEXT"]["VALUE"])) || (!empty($arItem["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"]) && is_array($arItem["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"]))):?>
                                                    </a>
                                                <?endif;?>
                
                                                <div class="name-wrap">
                                                    <div class="image-descrip italic">
                                                        <?=$arItem["PROPERTIES"]["TARIFF_PICTURE"]["~DESCRIPTION"]?>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        
                                        <?endif;?>
                                        
                                    </div>

                                </div>
                            
                            <?endif;?>

                        <?endif;?>                        
                        <?//tariffs end?>

                        <?//opinion?>
                        <?if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "opinion"):?>
                        
                            <?if($arItem["PROPERTIES"]["OPINION_VIEW"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["OPINION_VIEW"]["VALUE_XML_ID"] == "slider"):?>

                                <div class="opinion">

                                    <?if(is_array($arItem["ELEMENTS"]) && !empty($arItem["ELEMENTS"])):?>

                                        <div class="slider" data-count = "<?=count($arItem["ELEMENTS"]);?>">
                                            <div class="slider-nav-wrap">

                                                <?if(count($arItem["ELEMENTS"]) > 3 || count($arItem["ELEMENTS"]) == 1):?>
                                                    <div class="slider-icon-center primary"><span></span></div>
                                                <?endif;?>

                                                <div class="slider-nav <?=$arItem["ELEMENTS"][0]["PROPERTIES"]["OPINION_ROUND_OFF"]["VALUE_XML_ID"]?>">
                                        
                                                    <?foreach($arItem["ELEMENTS"] as $k=>$arOpinion):?>

                                                        <div class="for-count">
                                                            <div class="slider-image">
                                                                <div class="image-child">
       
                                                                    <?admin_setting($arOpinion)?>
                                                                
                                                                    <?if($arOpinion["PROPERTIES"]["OPINION_IMAGE"]["VALUE"] > 0):?>
                                                                        <?$img_big = CFile::ResizeImageGet($arOpinion["PROPERTIES"]["OPINION_IMAGE"]["VALUE"], array('width'=>234, 'height'=>234), BX_RESIZE_IMAGE_EXACT , false, false, false, $img_quality);?>
                                                                        <img alt="" class="img-responsive center-block" src="<?=$img_big["src"]?>" />
                                                                    <?else:?>
                                                                        <img alt="" class="img-responsive center-block" src="<?=SITE_TEMPLATE_PATH?>/images/quote.png">
                                                                    <?endif;?>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    <?endforeach;?>
                                                </div>
                                                    
                                            </div>
                                            

                                            <div class="slider-for">
                                                <?foreach($arItem["ELEMENTS"] as $k=>$arOpinion):?>
                                                    <div>

                                                        <?if(!empty($arOpinion["PROPERTIES"]["OPINION_TEXT"]["VALUE"])):?>

                                                            <div class="text italic no-margin-top-bot">
                                                                <?=$arOpinion["PROPERTIES"]["OPINION_TEXT"]["~VALUE"]["TEXT"]?>
                                                            </div>

                                                        <?endif;?>

                                                        <?if(strlen($arOpinion["PROPERTIES"]["OPINION_NAME"]["VALUE"]) > 0 || strlen($arOpinion["PROPERTIES"]["OPINION_PROF"]["VALUE"]) > 0):?>

                                                            <div class="descrip-wrap">

                                                                <?if(strlen($arOpinion["PROPERTIES"]["OPINION_NAME"]["VALUE"]) > 0):?>
                                                                    <div class="name main1">
                                                                        <?=$arOpinion["PROPERTIES"]["OPINION_NAME"]["~VALUE"]?>
                                                                    </div>
                                                                <?endif;?>

                                                                <?if(strlen($arOpinion["PROPERTIES"]["OPINION_PROF"]["VALUE"]) > 0):?>
                                                                    <div class="proof">
                                                                        <?=$arOpinion["PROPERTIES"]["OPINION_PROF"]["~VALUE"]?>
                                                                    </div>
                                                                <?endif;?>

                                                            </div>

                                                        <?endif;?>

                                                        <?if(strlen($arOpinion["PROPERTIES"]["OPINION_VIDEO"]["VALUE"]) > 0 || strlen($arOpinion["PROPERTIES"]["OPINION_FILE"]["VALUE"]) > 0):?>

                                                            <div class="more-info-wrap">

                                                                <div class="more-info no-margin-left-right no-margin-top-bot">
                                                                    
                                                                    <?if(strlen($arOpinion["PROPERTIES"]["OPINION_FILE"]["VALUE"]) > 0):?>

                                                                        <div class="link-wrap no-margin-top-bot">

                                                                            <?
                                                                                $arFile = CFile::MakeFileArray($arOpinion["PROPERTIES"]["OPINION_FILE"]["VALUE"]);
                                                                                $is_image = CFile::IsImage($arFile["name"], $arFile["type"]);
                                                                            ?>

                                                                            <a href="<?=CFile::GetPath($arOpinion["PROPERTIES"]["OPINION_FILE"]["VALUE"])?>" <?if(!$is_image):?> target="_blank" <?else:?> data-gallery="s<?=$arOpinion['ID']?>" <?endif;?>class="link-blank">
                                                                                <?if(strlen($arOpinion["PROPERTIES"]["OPINION_FILE_TEXT"]["VALUE"]) > 0):?>
                                                                                    <span><?=$arOpinion["PROPERTIES"]["OPINION_FILE_TEXT"]["~VALUE"]?></span>
                                                                                <?endif;?>
                                                                            </a>

                                                                        </div>

                                                                    <?endif;?>

                                                                    <?if(strlen($arOpinion["PROPERTIES"]["OPINION_VIDEO"]["VALUE"]) > 0):?>

                                                                        <div class="link-wrap no-margin-top-bot">

                                                                            <?preg_match("/^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/",$arOpinion['PROPERTIES']['OPINION_VIDEO']['~VALUE'],$out);?>     

                                                                            <a class="link-video call-modal callvideo" data-call-modal="<?=$out[1]?>">
                                                                                <?if(strlen($arOpinion["PROPERTIES"]["OPINION_VIDEO_TEXT"]["VALUE"]) > 0):?>

                                                                                    <span><?=$arOpinion["PROPERTIES"]["OPINION_VIDEO_TEXT"]["~VALUE"]?></span>

                                                                                <?endif;?>
                                                                            </a>
                                                                        </div>
                                                                 
                                                                    <?endif;?>

                                                                </div>
                                                            </div>

                                                        <?endif;?>


                                                    </div>
                                                <?endforeach;?>
                                            </div>
                                    
                                        </div>

                                    <?endif;?>
                                </div>
                                                
                            <?endif;?>
                            
                            
                            <?if($arItem["PROPERTIES"]["OPINION_VIEW"]["VALUE_XML_ID"] == "block"):?>

                                <div class="opinion">
                
                                    <div class="opinion-table">

                                        <div class="opinion-cell text-part no-margin-top-bot col-lg-7 col-md-7 col-sm-8 col-xs-12 <?if($arItem["PROPERTIES"]["OPINION_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "left"):?>col-lg-push-5 col-md-push-5 col-sm-push-4 col-xs-push-0<?endif;?>">
                                            <?if($arItem["TITLE_CHANGE"]):?>
                                                <?CreateHead($arItem, true, $main_key)?>
                                            <?endif;?>

                                            <?if(strlen($arItem["PROPERTIES"]["OPINION_TEXT"]["VALUE"]['TEXT']) > 0):?>
                                                <div class="text no-margin-top-bot italic">
                                                    <?=$arItem["PROPERTIES"]["OPINION_TEXT"]["~VALUE"]['TEXT']?>
                                                </div>
                                            <?endif;?>

                                            <?if(strlen($arItem["PROPERTIES"]["OPINION_NAME"]["VALUE"]) > 0 || strlen($arItem["PROPERTIES"]["OPINION_PROF"]["VALUE"]) > 0):?>

                                                <div class="name-wrap no-margin-top-bot visible-xs">

                                                    <?if(strlen($arItem["PROPERTIES"]["OPINION_NAME"]["VALUE"]) > 0):?>

                                                        <div class="name main1">
                                                            <?=$arItem["PROPERTIES"]["OPINION_NAME"]["~VALUE"]?>
                                                        </div>

                                                    <?endif;?>

                                                    <?if(strlen($arItem["PROPERTIES"]["OPINION_PROF"]["VALUE"]) > 0):?>
                                                        <div class="prof">
                                                            <?=$arItem["PROPERTIES"]["OPINION_PROF"]["~VALUE"]?>
                                                        </div>
                                                    <?endif;?>
                                                </div>

                                            <?endif;?>

                                            <?if(strlen($arItem["PROPERTIES"]["OPINION_VIDEO"]["VALUE"]) > 0 || strlen($arItem["PROPERTIES"]["OPINION_FILE"]["VALUE"]) > 0):?>

                                                <div class="more-info no-margin-top-bot">

                                                    <?if(strlen($arItem["PROPERTIES"]["OPINION_FILE"]["VALUE"]) > 0):?>

                                                        <?$arFile = CFile::MakeFileArray($arItem["PROPERTIES"]["OPINION_FILE"]["VALUE"]);?>
                                                        <?$is_image = CFile::IsImage($arFile["name"], $arFile["type"]);?>

                                                        <div class="link-wrap no-margin-top-bot">

                                                            <a href="<?=CFile::GetPath($arItem["PROPERTIES"]["OPINION_FILE"]["VALUE"])?>" <?if(!$is_image):?> target="_blank" <?else:?> data-gallery="s<?=$arItem['ID']?>" <?endif;?>class="link-blank">

                                                                <?if(strlen($arItem["PROPERTIES"]["OPINION_FILE_TEXT"]["VALUE"]) > 0):?>

                                                                    <span><?=$arItem["PROPERTIES"]["OPINION_FILE_TEXT"]["~VALUE"]?></span>

                                                                <?endif;?>

                                                            </a>
                                                        </div>

                                                    <?endif;?>

                                                    <?if(strlen($arItem["PROPERTIES"]["OPINION_VIDEO"]["VALUE"]) > 0):?>

                                                        <div class="link-wrap no-margin-top-bot">

                                                         <?preg_match("/^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/",$arItem['PROPERTIES']['OPINION_VIDEO']['~VALUE'],$out);?>     

                                                                <a class="link-video call-modal callvideo" data-call-modal="<?=$out[1]?>">


                                                                <?if(strlen($arItem["PROPERTIES"]["OPINION_VIDEO_TEXT"]["VALUE"]) > 0):?>

                                                                    <span><?=$arItem["PROPERTIES"]["OPINION_VIDEO_TEXT"]["~VALUE"]?></span>

                                                                <?endif;?>
                                                            </a>
                                                        </div>
                                                 
                                                    <?endif;?>
                                                </div>

                                            <?endif;?>
                                        </div>
      
                                        
                                        <div class="opinion-cell z-image image-part hidden-xs col-lg-5 col-md-5 col-sm-4 col-xs-12 <?if($arItem["PROPERTIES"]["OPINION_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "left"):?>col-lg-pull-7 col-md-pull-7 col-sm-pull-8 col-xs-pull-0<?endif;?>">                                 

                                            <?if($arItem["PROPERTIES"]["OPINION_IMAGE"]["VALUE"] > 0):?>
                                                <?$img_big = CFile::ResizeImageGet($arItem["PROPERTIES"]["OPINION_IMAGE"]["VALUE"], array('width'=>500, 'height'=>500), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                                <img alt="" class="img-responsive center-block" src="<?=$img_big["src"]?>" />
                                            <?else:?>
                                                <img alt="" class="img-responsive center-block" src="<?=SITE_TEMPLATE_PATH?>/images/quote.png">
                                            <?endif;?>
            
                                            <?if(strlen($arItem["PROPERTIES"]["OPINION_NAME"]["VALUE"]) > 0 || strlen($arItem["PROPERTIES"]["OPINION_PROF"]["VALUE"]) > 0):?>

                                                <div class="name-wrap no-margin-top-bot">
                                                    <?if(strlen($arItem["PROPERTIES"]["OPINION_NAME"]["VALUE"]) > 0):?>
                                                        <div class="name main1">
                                                             <?=$arItem["PROPERTIES"]["OPINION_NAME"]["~VALUE"]?>
                                                        </div>

                                                    <?endif;?>

                                                    <?if(strlen($arItem["PROPERTIES"]["OPINION_PROF"]["VALUE"]) > 0):?>
                                                        <div class="prof">
                                                            <?=$arItem["PROPERTIES"]["OPINION_PROF"]["~VALUE"]?>
                                                        </div>
                                                    <?endif;?>
                                                </div>

                                            <?endif;?>
                                            
                                        </div>

                                    </div>
                                </div>
                            
                            <?endif;?>

                        <?endif;?>
                        <?//opinion end?>
                        
                        <?//services?>                        
                        <?if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "service"):?>
                            
                            <?if($arItem["PROPERTIES"]["SERVICE_VIEW"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["SERVICE_VIEW"]["VALUE_XML_ID"] == "flat"):?>
                                
                                <div class="services col-lg-12 col-md-12 col-sm-12 col-xs-12 clearfix <?if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y"):?>parent-animate<?endif;?>">
                                    
                                    <?
                                        $class = "";
                                        $count = count($arItem["ELEMENTS"]);
                                        
                                        if($count <= 3)
                                            $class = "col-lg-4 col-md-4 col-sm-4 col-xs-12 service-item";
                                        else
                                            $class = "col-lg-3 col-md-3 col-sm-6 col-xs-12 service-item four-elements";
                                          
                                        $class2 = "";
                                        
                                        if($count == 1)
                                            $class2 = "col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-0";

                                        elseif($count == 2)
                                            $class2 = "col-lg-offset-2 col-md-offset-2 col-sm-offset-0 col-xs-offset-0";
                                    ?>
                            
                                    <?if(is_array($arItem["ELEMENTS"]) && !empty($arItem["ELEMENTS"])):?>

                                        <?foreach($arItem["ELEMENTS"] as $k=>$arService):?>     
                                            <div class="<?=$class?> <?if($k==0):?><?=$class2?><?endif;?>">

                                                <div class="row">
                                                    
                                                    <div class="service-element no-margin-top-bot  <?if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y"):?>child-animate opacity-zero<?endif;?>">

                                                        <?if($arService["PROPERTIES"]["SERVICE_HIT"]["VALUE"] == "Y"):?><div class="star"></div><?endif;?>
                                                        
                                                        <?if($arItem["SHOW_PICTURE"] > 0):?>
                                                            
                                                            <div class="image-table-wrap">
                                                                <table>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="image-wrap <?if(!empty($arService["PROPERTIES"]["SERVICE_DETAIL_TEXT"]["VALUE"]) > 0 || !empty($arService["PROPERTIES"]["SERVICE_GALLERY"]["VALUE"])):?> btn-modal-open" data-header="<?=$block_name?>" data-site-id='<?=SITE_ID?>'  data-detail="service" data-element-id="<?=$arService["ID"]?>" data-all-id = "<?=implode("," , $arItem["ID_ALL"])?>"<?else:?>"<?endif;?>>
                                                                                <?if($count <= 3):?>
                                                                                    <?$img = CFile::ResizeImageGet($arService["PROPERTIES"]["SERVICE_PICTURE"]["VALUE"], array('width'=>500, 'height'=>250), BX_RESIZE_IMAGE_EXACT, false, false, false, $img_quality); ?>

                                                                                <?else:?>
                                                                                     <?$img = CFile::ResizeImageGet($arService["PROPERTIES"]["SERVICE_PICTURE"]["VALUE"], array('width'=>500, 'height'=>300), BX_RESIZE_IMAGE_EXACT, false, false, false, $img_quality); ?>

                                                                                <?endif;?>

                                                                                <img alt="<?=$arService["NAME"]?>" class="img-responsive" src="<?=$img["src"]?>" />

                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                    
                                                        <?endif;?>
                
                                                        <?if($arItem["SHOW_SUBNAME"] > 0):?>
                                                        
                                                            <div class="top-name">
                                                                <?if(strlen($arService["PROPERTIES"]["SERVICE_SUBNAME"]["VALUE"]) > 0):?>
                                                                    <?=$arService["PROPERTIES"]["SERVICE_SUBNAME"]["~VALUE"]?>
                                                                <?endif;?>
                                                            </div>
                                                        
                                                        <?endif;?>
                
                                                        <?if($arItem["SHOW_NAME"] > 0):?>
                                                        
                                                            <div class="name-wrap">
                                                                <div class="name main1">
                                                                    <?if(strlen($arService["PROPERTIES"]["SERVICE_NAME"]["VALUE"]) > 0):?>
                                                                        <?=$arService["PROPERTIES"]["SERVICE_NAME"]["~VALUE"]?>
                                                                    <?endif;?>
                                                                </div>
                                                            </div>
                                                        
                                                        <?endif;?>
                
                                                        <?if($arItem["SHOW_PRICE"] > 0):?>
                                                            
                                                            <?if(($arItem["SHOW_NAME"] > 0 || $arItem["SHOW_SUBNAME"] > 0) && (strlen($arService["PROPERTIES"]["SERVICE_OLD_PRICE"]["VALUE"]) > 0 || strlen($arService["PROPERTIES"]["SERVICE_PRICE"]["VALUE"]) > 0)):?>
                                                                <div class="line-grey"></div>
                                                            <?endif;?>
                                                            
                                                            <div class="price-wrap">
                                                            
                                                                <?if(strlen($arService["PROPERTIES"]["SERVICE_OLD_PRICE"]["VALUE"]) > 0):?>
                                                                    <div class="old-price main2"><?=$arService["PROPERTIES"]["SERVICE_OLD_PRICE"]["~VALUE"]?></div>
                                                                <?endif;?>
                                                                
                                                                <div class="price main1">
                                                                    <?if(strlen($arService["PROPERTIES"]["SERVICE_PRICE"]["VALUE"]) > 0):?>
                                                                       <?=$arService["PROPERTIES"]["SERVICE_PRICE"]["~VALUE"]?>
                                                                    <?endif;?>
                                                                </div>
                                                            
                                                            </div>
                                                            
                                                            
                                                            
                                                        <?endif;?>
                                                        
                                                        <?if((strlen($arService["PROPERTIES"]["SERVICE_PREVIEW_TEXT"]["VALUE"]) > 0 || !empty($arService["PROPERTIES"]["SERVICE_DETAIL_TEXT"]["VALUE"]) || !empty($arService["PROPERTIES"]["SERVICE_GALLERY"]["VALUE"])) || (strlen($arService["PROPERTIES"]["SERVICE_BUTTON_TYPE"]["VALUE_XML_ID"]) > 0)):?>
                
                                                            <div class="bot-wrap no-margin-top-bot">
                                                                
                                                                <?if(strlen($arService["PROPERTIES"]["SERVICE_PREVIEW_TEXT"]["VALUE"]) > 0):?>
                                                                    <div class="text">
                                                                        <?=$arService["PROPERTIES"]["SERVICE_PREVIEW_TEXT"]["~VALUE"]?>
                                                                    </div>
                                                                <?endif;?>
                                                                
                                                                <?if(strlen($arService["PROPERTIES"]["SERVICE_BUTTON_TYPE"]["VALUE_XML_ID"]) <= 0):?>
                                                                    <?$arService["PROPERTIES"]["SERVICE_BUTTON_TYPE"]["VALUE_XML_ID"] = "form";?>
                                                                <?endif;?>
                                                                
                                                                <?if(strlen($arService["PROPERTIES"]["SERVICE_BUTTON_NAME"]["VALUE"]) > 0):?>

                                                                    <div class="button-wrap">


                                                                        <a <?if(strlen($arService["PROPERTIES"]["SERVICE_BUTTON_ONCLICK"]["VALUE"])>0) echo "onclick='".$arService["PROPERTIES"]["SERVICE_BUTTON_ONCLICK"]["VALUE"]."'";?> class="button-def primary more-modal-info <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?> <?=hamButtonEditClass ($arService["PROPERTIES"]["SERVICE_BUTTON_TYPE"]["VALUE_XML_ID"], $arService["PROPERTIES"]["SERVICE_BUTTON_FORM"]["VALUE"], $arService["PROPERTIES"]["SERVICE_MODAL"]["VALUE"])?><?if($count <= 3):?> big<?else:?> medium<?endif;?>" data-element-type = "SRV" <?=hamButtonEditAttr($arService["PROPERTIES"]["SERVICE_BUTTON_TYPE"]["VALUE_XML_ID"], $arService["PROPERTIES"]["SERVICE_BUTTON_FORM"]["VALUE"], $arService["PROPERTIES"]["SERVICE_MODAL"]["VALUE"], $arService["PROPERTIES"]["SERVICE_BUTTON_LINK"]["VALUE"], $arService["PROPERTIES"]["SERVICE_BUTTON_BLANK"]["VALUE_XML_ID"], $block_name, $arService["PROPERTIES"]["SERVICE_BUTTON_QUIZ"]["VALUE"], $arService["ID"])?>><?if(strlen($arService["PROPERTIES"]["SERVICE_BUTTON_NAME"]["VALUE"]) > 0):?><?=$arService["PROPERTIES"]["SERVICE_BUTTON_NAME"]["~VALUE"]?><?endif;?></a>
                                                                    </div>

                                                                <?endif;?>
                                                                
                                                                <?if(!empty($arService["PROPERTIES"]["SERVICE_DETAIL_TEXT"]["VALUE"]) || !empty($arService["PROPERTIES"]["SERVICE_GALLERY"]["VALUE"])):?>

                                                                    <?
                                                                        $sec_btn_name = GetMessage("MORE_DETAIL");
                                                                        if(strlen($arSection['~UF_MORE_NAME_SRVC'])>0)
                                                                            $sec_btn_name = $arSection['~UF_MORE_NAME_SRVC'];
                                                                    ?>
                                                                
                                                                    <a class="link-def btn-modal-open" data-header="<?=$block_name?>" data-all-id = "<?=implode("," , $arItem["ID_ALL"])?>" data-site-id='<?=SITE_ID?>'  data-detail="service" data-element-id="<?=$arService["ID"]?>"><i class="fa fa-info" aria-hidden="true"></i><span class="bord"><?=$sec_btn_name?></span></a>
                                                                
                                                                
                                                                <?endif;?>
                                                                
                                                            </div>
                                                        
                                                        <?endif;?>
                                                        
                                                    </div>
                                                
                                                </div>

                                                <?admin_setting($arService)?>
                                            </div>

                                            <?
                                                if($count <= 3)
                                                {
                                                    if(($k+1)%3 == 0)
                                                        echo "<span class='clearfix visible-lg visible-md visible-sm'></span>";
                                                }

                                                else
                                                {
                                                    if(($k+1)%2 == 0)
                                                        echo "<span class='clearfix visible-sm'></span>";

                                                    if(($k+1)%4 == 0)
                                                        echo "<span class='clearfix visible-lg visible-md'></span>";
                                                }
                                            ?>

                                        <?endforeach;?>
                                        
                                    <?endif;?>
                                    
                                </div>
                                
                            <?endif;?>
                            
                            
                            <?if($arItem["PROPERTIES"]["SERVICE_VIEW"]["VALUE_XML_ID"] == "table"):?>

                                <div class="services-2 col-lg-12 col-md-12 col-sm-12 col-xs-12 clearfix <?if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y"):?>parent-animate<?endif;?>">
                                    
                                    <?if(is_array($arItem["ELEMENTS"]) && !empty($arItem["ELEMENTS"])):?>
                                    
                                        <?foreach($arItem["ELEMENTS"] as $k=>$arService):?>
                                            <div class="wrap-service-table">

                                                <div class="service-table <?if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y"):?>child-animate opacity-zero<?endif;?>">
                                                    
                                                    <?if($arService["PROPERTIES"]["SERVICE_PICTURE"]["VALUE"] > 0):?>
                                                    
                                                        <div class="service-cell image-wrap <?if(!empty($arService["PROPERTIES"]["SERVICE_DETAIL_TEXT"]["VALUE"]) > 0 || !empty($arService["PROPERTIES"]["SERVICE_GALLERY"]["VALUE"])):?>btn-modal-open" data-site-id='<?=SITE_ID?>'  data-detail="service" data-element-id="<?=$arService["ID"]?>" data-header="<?=$block_name?>" data-all-id = "<?=implode("," , $arItem["ID_ALL"])?>""<?else:?>"<?endif;?>>
                                                            
                                                            <?$img = CFile::ResizeImageGet($arService["PROPERTIES"]["SERVICE_PICTURE"]["VALUE"], array('width'=>200, 'height'=>200), BX_RESIZE_IMAGE_EXACT, false, false, false, $img_quality); ?>
                                                            
                                                            <img alt="<?=$arService["PROPERTIES"]["SERVICE_NAME"]["VALUE"]?>" class="img-responsive center-block" src="<?=$img["src"]?>" />

                                                        </div>
                                                    
                                                    <?endif;?>

                                                    <div class="service-cell text-wrap no-margin-top-bot">
                                                        
                                                        <?if(strlen($arService["PROPERTIES"]["SERVICE_SUBNAME"]["VALUE"]) > 0):?>
                                                            <div class="top-name"><?=$arService["PROPERTIES"]["SERVICE_SUBNAME"]["~VALUE"]?></div>
                                                        <?endif;?>
                                                     
                                                        
                                                        <?if(strlen($arService["PROPERTIES"]["SERVICE_NAME"]["VALUE"]) > 0):?>            
                                                            <div class="name main1">
                                                                <?=$arService["PROPERTIES"]["SERVICE_NAME"]["~VALUE"]?>
                                                                
                                                                <?if($arService["PROPERTIES"]["SERVICE_HIT"]["VALUE"] == "Y"):?>
                                                                    <span class="hit"></span>
                                                                <?endif;?>

                                                            </div>
                                                        <?endif;?>
                    
                                                        <?if(strlen($arService["PROPERTIES"]["SERVICE_PREVIEW_TEXT"]["VALUE"]) > 0):?>
                                                            <div class="text">
                                                                <?=$arService["PROPERTIES"]["SERVICE_PREVIEW_TEXT"]["~VALUE"]?>
                                                            </div>
                                                        <?endif;?>
                                                        
                                                        <?if(strlen($arService["PROPERTIES"]["SERVICE_PRICE"]["VALUE"]) > 0 || strlen($arService["PROPERTIES"]["SERVICE_OLD_PRICE"]["VALUE"]) > 0):?>
                                                            <div class="price-sm main1 visible-sm">
                                                                <?=$arService["PROPERTIES"]["SERVICE_PRICE"]["~VALUE"]?>
                                                                
                                                                <?if(strlen($arService["PROPERTIES"]["SERVICE_OLD_PRICE"]["VALUE"]) > 0):?>
                                                                    <span class="old-price main2"><?=$arService["PROPERTIES"]["SERVICE_OLD_PRICE"]["~VALUE"]?></span>
                                                                <?endif;?>
                                                            </div>
                                                        <?endif;?>
                    
                                                        <?if(!empty($arService["PROPERTIES"]["SERVICE_DETAIL_TEXT"]["VALUE"]) || !empty($arService["PROPERTIES"]["SERVICE_GALLERY"]["VALUE"])):?>
                                                            <div class="link-wrap">
                                                            <a class="link-def btn-modal-open" data-header="<?=$block_name?>" data-all-id = "<?=implode("," , $arItem["ID_ALL"])?>" data-site-id='<?=SITE_ID?>' data-detail="service"  data-element-id="<?=$arService["ID"]?>"><i class="fa fa-info" aria-hidden="true"></i><span class="bord"><?if(strlen($arSection['~UF_MORE_NAME_SRVC'])>0) echo $arSection['~UF_MORE_NAME_SRVC']; else echo GetMessage("MORE_DETAIL");?></a>
                                                            </div>

                                                                                                           
                                                        <?endif;?>
                                                        
                                                    </div>
                    
                                                    <?if(strlen($arService["PROPERTIES"]["SERVICE_PRICE"]["VALUE"]) > 0  || strlen($arService["PROPERTIES"]["SERVICE_OLD_PRICE"]["VALUE"]) > 0):?>
                                                        <div class="service-cell price-wrap main1 hidden-sm">
                                                            <?=$arService["PROPERTIES"]["SERVICE_PRICE"]["~VALUE"]?>
                                                            
                                                            <?if(strlen($arService["PROPERTIES"]["SERVICE_OLD_PRICE"]["VALUE"]) > 0):?>
                                                                <span class="old-price main2"><?=$arService["PROPERTIES"]["SERVICE_OLD_PRICE"]["~VALUE"]?></span>
                                                            <?endif;?>
                                                        </div>
                                                    <?endif;?>
                                                    
                                                    <?if(strlen($arService["PROPERTIES"]["SERVICE_BUTTON_TYPE"]["VALUE_XML_ID"]) <= 0):?>
                                                        <?$arService["PROPERTIES"]["SERVICE_BUTTON_TYPE"]["VALUE_XML_ID"] = "form";?>
                                                    <?endif;?>
                                                    
                                                    <?if(strlen($arService["PROPERTIES"]["SERVICE_BUTTON_NAME"]["VALUE"]) > 0):?>                    
                                                        <div class="service-cell button-wrap">
                                                            <a <?if(strlen($arService["PROPERTIES"]["SERVICE_BUTTON_ONCLICK"]["VALUE"])>0) echo "onclick='".$arService["PROPERTIES"]["SERVICE_BUTTON_ONCLICK"]["VALUE"]."'";?> class="button-def primary more-modal-info big <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?> <?=hamButtonEditClass ($arService["PROPERTIES"]["SERVICE_BUTTON_TYPE"]["VALUE_XML_ID"], $arService["PROPERTIES"]["SERVICE_BUTTON_FORM"]["VALUE"], $arService["PROPERTIES"]["SERVICE_MODAL"]["VALUE"])?>" data-element-type = "SRV" <?=hamButtonEditAttr($arService["PROPERTIES"]["SERVICE_BUTTON_TYPE"]["VALUE_XML_ID"], $arService["PROPERTIES"]["SERVICE_BUTTON_FORM"]["VALUE"], $arService["PROPERTIES"]["SERVICE_MODAL"]["VALUE"], $arService["PROPERTIES"]["SERVICE_BUTTON_LINK"]["VALUE"], $arService["PROPERTIES"]["SERVICE_BUTTON_BLANK"]["VALUE_XML_ID"], $block_name, $arService["PROPERTIES"]["SERVICE_BUTTON_QUIZ"]["VALUE"], $arService["ID"])?>><?if(strlen($arService["PROPERTIES"]["SERVICE_BUTTON_NAME"]["VALUE"]) > 0):?><?=$arService["PROPERTIES"]["SERVICE_BUTTON_NAME"]["~VALUE"]?><?endif;?></a>
                                                        </div>                                                
                                                    <?endif;?>
                                                    
                                                </div>

                                                <?admin_setting($arService)?>

                                            </div>
                                            
                                        <?endforeach;?>
                                        
                                    <?endif;?>
                                
                                </div>
                                
                            <?endif;?>
                            
                            
                            <?if($arItem["PROPERTIES"]["SERVICE_VIEW"]["VALUE_XML_ID"] == "slider"):?>

                                    </div>
                                </div>
                                    
                                    <?if(is_array($arItem["ELEMENTS"]) && !empty($arItem["ELEMENTS"])):?>
                                        
                                        <div class="images-animate hidden-sm hidden-xs clearfix">
                                            
                                            <div class="slider-services-images">
                                                
                                                <?foreach($arItem["ELEMENTS"] as $k=>$arService):?>
                                                    
                                                    <div class="service-slide">
                                                        <?if($arService["PROPERTIES"]["SERVICE_ADD_BACK_PICTURE"]["VALUE"] > 0):?>

                                                            <?$img = CFile::ResizeImageGet($arService["PROPERTIES"]["SERVICE_ADD_BACK_PICTURE"]["VALUE"], array('width'=>1500, 'height'=>1500), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                                            <img  class="center-block img-responsive show-on" src="<?=$img["src"]?>" />
                                                        
                                                        <?endif;?>
                                                        
                                                    </div>
                                                
                                                <?endforeach;?>

                                            </div>
                                            
                                        </div>
                                        
                                        
                                        <div class="slider-services-wrap clearfix">
                                    
                                                
                                            <?if(count($arItem["ELEMENTS"]) > 1):?>
                                            
                                                <button type="button" class="slick-prev"></button>
                                                <button type="button" class="slick-next"></button>
                                            
                                            <?endif;?>
                                            
                                            
                                            <div class="slider-services ">
                                                
                                                <?foreach($arItem["ELEMENTS"] as $k=>$arService):?>

                                                    <div class="service-slide">
                                                        <div class="element-table-wrap">
                                                    
                                                            <div class="element-table <?=$arService["PROPERTIES"]["SERVICE_TEXT_COLOR"]["VALUE_XML_ID"]?>">
                                                                
                                                                <?if($arService["PROPERTIES"]["SERVICE_PICTURE"]["VALUE"] > 0):?>
                                                                
                                                                    <?$img = CFile::ResizeImageGet($arService["PROPERTIES"]["SERVICE_PICTURE"]["VALUE"], array('width'=>900, 'height'=>900), BX_RESIZE_IMAGE_PROPORTIONAL, false); ?>
                                                                
                                                                
                                                                    <div class="element-cell image-wrap radius-on">
                                                                    
                                                                        <div class="image-wrap <?if(!empty($arService["PROPERTIES"]["SERVICE_DETAIL_TEXT"]["VALUE"]) > 0 || !empty($arService["PROPERTIES"]["SERVICE_GALLERY"]["VALUE"])):?> btn-modal-open" data-header="<?=$block_name?>" data-site-id='<?=SITE_ID?>'  data-detail="service" data-element-id="<?=$arService["ID"]?>" data-all-id = "<?=implode("," , $arItem["ID_ALL"])?>"<?else:?>"<?endif;?>>
                                                                        
                                                                            <img class="center-block img-responsive show-on" src="<?=$img["src"]?>" />
                                                                        
                                                                        </div>
                                                                        
                                                                    </div>
                                                                    
                                                                <?endif;?>
                        
                        
                                                                <div class="element-cell text-wrap no-margin-top-bot show-on <?=$arService["PROPERTIES"]["SERVICE_TEXT_COLOR"]["VALUE_XML_ID"]?>">

                                                                    <div class="wrap-padding-left">
                                                                        
                                                                        <?if(strlen($arService["PROPERTIES"]["SERVICE_SUBNAME"]["VALUE"]) > 0):?>
                                                                            <div class="name"><?=$arService["PROPERTIES"]["SERVICE_SUBNAME"]["~VALUE"]?></div>
                                                                        <?endif;?>
                                 
                                                                        <?if(strlen($arService["PROPERTIES"]["SERVICE_NAME"]["VALUE"]) > 0):?>            
                                                                            <div class="title main1">
                                                                                <?=$arService["PROPERTIES"]["SERVICE_NAME"]["~VALUE"]?>
                                                                                
                                                                                <?if($arService["PROPERTIES"]["SERVICE_HIT"]["VALUE"] == "Y"):?>
                                                                                    <span class="hit"></span>
                                                                                <?endif;?>
                                                                            </div>
                                                                        <?endif;?>

                                                                        <div class="line"></div>
                                                                        
                                                                        <?if(strlen($arService["PROPERTIES"]["SERVICE_PREVIEW_TEXT"]["VALUE"]) > 0):?>
                                                                            <div class=" text text-content <?=$arService["PROPERTIES"]["SERVICE_TEXT_COLOR"]["VALUE_XML_ID"]?>" >
                                                                                <?=$arService["PROPERTIES"]["SERVICE_PREVIEW_TEXT"]["~VALUE"]?>
                                                                            </div>
                                                                        <?endif;?>
                            
                                                                        
                                                                        <?if(strlen($arService["PROPERTIES"]["SERVICE_PRICE"]["VALUE"]) > 0  || strlen($arService["PROPERTIES"]["SERVICE_OLD_PRICE"]["VALUE"]) > 0):?>
                                                                         
                                                                            <div class="price-wrap no-margin-top-bot">
                                                                                
                                                                                <?if(strlen($arService["PROPERTIES"]["SERVICE_OLD_PRICE"]["VALUE"]) > 0):?>
                                                                                    <div class="old-price main2"><?=$arService["PROPERTIES"]["SERVICE_OLD_PRICE"]["~VALUE"]?></div>
                                                                                <?endif;?>
                                                                                    
                                                                                <div class="price main1">
                                                                                    <?=$arService["PROPERTIES"]["SERVICE_PRICE"]["~VALUE"]?>
                                                                                </div>
                                                                            
                                                                            </div>
                                                                         
                                                                            
                                                                        <?endif;?>
                                                                        
                                                                      
                                                                        <?if(strlen($arService["PROPERTIES"]["SERVICE_BUTTON_TYPE"]["VALUE_XML_ID"]) <= 0):?>
                                                                            <?$arService["PROPERTIES"]["SERVICE_BUTTON_TYPE"]["VALUE_XML_ID"] = "form";?>
                                                                        <?endif;?>
                                                   
                            
                                                                        <?if(strlen($arService["PROPERTIES"]["SERVICE_PREVIEW_TEXT"]["VALUE"]) > 0 || !empty($arService["PROPERTIES"]["SERVICE_DETAIL_TEXT"]["VALUE"]) || !empty($arService["PROPERTIES"]["SERVICE_GALLERY"]["VALUE"]) || strlen($arService["PROPERTIES"]["SERVICE_BUTTON_NAME"]["VALUE"]) > 0):?>
                                                                            
                                                                            <div class="buttons-wrap">

                                                                                <?if(strlen($arService["PROPERTIES"]["SERVICE_BUTTON_NAME"]["VALUE"]) > 0):?>
                                                                                
                                                                                    <div class="button-wrap-inner">

                                                                                        <a <?if(strlen($arService["PROPERTIES"]["SERVICE_BUTTON_ONCLICK"]["VALUE"])>0) echo "onclick='".$arService["PROPERTIES"]["SERVICE_BUTTON_ONCLICK"]["VALUE"]."'";?> class="button-def primary big more-modal-info <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?> <?=hamButtonEditClass ($arService["PROPERTIES"]["SERVICE_BUTTON_TYPE"]["VALUE_XML_ID"], $arService["PROPERTIES"]["SERVICE_BUTTON_FORM"]["VALUE"], $arService["PROPERTIES"]["SERVICE_MODAL"]["VALUE"])?>" data-element-type = "SRV" <?=hamButtonEditAttr($arService["PROPERTIES"]["SERVICE_BUTTON_TYPE"]["VALUE_XML_ID"], $arService["PROPERTIES"]["SERVICE_BUTTON_FORM"]["VALUE"], $arService["PROPERTIES"]["SERVICE_MODAL"]["VALUE"], $arService["PROPERTIES"]["SERVICE_BUTTON_LINK"]["VALUE"], $arService["PROPERTIES"]["SERVICE_BUTTON_BLANK"]["VALUE_XML_ID"], $block_name, $arService["PROPERTIES"]["SERVICE_BUTTON_QUIZ"]["VALUE"], $arService["ID"])?>>
                                                                                            <?=$arService["PROPERTIES"]["SERVICE_BUTTON_NAME"]["~VALUE"]?>
                                                                                        </a>
                                                                                    </div>
                                                                                <?endif;?>
                                
                                                                                <?if(!empty($arService["PROPERTIES"]["SERVICE_DETAIL_TEXT"]["VALUE"]) > 0 || !empty($arService["PROPERTIES"]["SERVICE_GALLERY"]["VALUE"])):?>
                                                                                    <?
                                                                                        $sec_btn_name = GetMessage("MORE_DETAIL");
                                                                                        if(strlen($arSection['~UF_MORE_NAME_SRVC'])>0)
                                                                                            $sec_btn_name = $arSection['~UF_MORE_NAME_SRVC'];
                                                                                    ?>

                                                                                    <div class="button-wrap-inner">
                                                                                        <a class="button-def secondary <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?> big btn-modal-open" data-header="<?=$block_name?>" data-site-id='<?=SITE_ID?>' data-detail="service"  data-element-id="<?=$arService["ID"]?>" data-all-id = "<?=implode("," , $arItem["ID_ALL"])?>">
                                                                                            <i class="fa fa-info" aria-hidden="true"></i>
                                                                                            <?=$sec_btn_name?>
                                                                                        </a>
                                                                                    </div>
                                                                                    
                                                                                <?endif;?>
                                                                                
                                                                            </div>
                                                                            
                                                                        <?endif;?>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>

                                                            <?admin_setting($arService, true)?>

                                                        </div>
                                                    </div>
                                                                                                    
                                                <?endforeach;?>
                                            
                                            </div>
                                        </div>

                                    <?endif;?>

                                <div class="container">
                                    <div class="row">

                            <?endif;?>
                        
                        <?endif;?>
                        <?//services end?>
                        
                        <?//numbers?>
                        <?if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "numbers"):?>

                            <div class="info-num col-lg-12 col-md-12 col-sm-12 col-xs-12 clearfix <?if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y"):?>parent-animate<?endif;?>">
                                <div class="row">

                                    <?
                                        $class = "";
                                        $class2 = "";

                                        $count = count($arItem["PROPERTIES"]["NUMBERS_TEXTS"]["VALUE"]);
                                        
                                        if($count <= 3)
                                            $class = "col-lg-4 col-md-4 col-sm-4 col-xs-12";
                                        else
                                            $class = "col-lg-3 col-md-3 col-sm-6 col-xs-12 four-elements";
                                
                                        if($count == 1)
                                            $class2 = "col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-0";

                                        elseif($count == 2)
                                            $class2 = "col-lg-offset-2 col-md-offset-2 col-sm-offset-0 col-xs-offset-0";
                                    ?>


                                    <?if(is_array($arItem["PROPERTIES"]["NUMBERS_TEXTS"]["VALUE"]) && !empty($arItem["PROPERTIES"]["NUMBERS_TEXTS"]["VALUE"])):?>
                                                                               
                                        <?foreach($arItem["PROPERTIES"]["NUMBERS_TEXTS"]["~VALUE"] as $k => $arValue):?>
                                                
                                            <div class="info-num-element no-margin-top-bot <?=$class?> <?if($k==0):?><?=$class2?><?endif;?> <?=$arItem["PROPERTIES"]["NUMBERS_TEXTS_COLOR"]["VALUE_XML_ID"]?> <?if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y"):?>child-animate opacity-zero<?endif;?>" >
                                                <?if($arItem["STRING_NUM"] > 0):?>

                                                    <div class="title main1" <?if(strlen($arItem["PROPERTIES"]["NUMBERS_FONT_SIZE"]["VALUE"]) > 0):?> style="font-size: <?=$arItem["PROPERTIES"]["NUMBERS_FONT_SIZE"]["VALUE"]?>px; line-height: <?=$arItem["PROPERTIES"]["NUMBERS_FONT_SIZE"]["VALUE"] + 3?>px; min-height: <?=$arItem["PROPERTIES"]["NUMBERS_FONT_SIZE"]["VALUE"] + 3?>px "<?endif;?>>
                                                        <?=$arValue?>
                                                    </div>

                                                <?endif;?>


                                                <div class="text">
                                                    <?=$arItem["PROPERTIES"]["NUMBERS_TEXTS"]["~DESCRIPTION"][$k]?>
                                                </div>
                                            </div>

                                            <?
                                                if($count <= 3)
                                                {
                                                    if(($k+1)%3 == 0)
                                                        echo "<span class='clearfix visible-lg visible-md visible-sm'></span>";
                                                }

                                                else
                                                {
                                                    if(($k+1)%2 == 0)
                                                        echo "<span class='clearfix visible-sm'></span>";

                                                    if(($k+1)%4 == 0)
                                                        echo "<span class='clearfix visible-lg visible-md'></span>";
                                                }
                                            ?>
                                      
                                        <?endforeach;?>

                                    <?endif;?>

                                </div>
                            </div>

                        <?endif;?>
                        <?//numbers end?>

                        <?//gallery?>
                        <?if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "gallery"):?>

                            <?if($arItem["PROPERTIES"]["GALLERY_VIEW"]["VALUE_XML_ID"] == "slider"):?>
                            
                                <?
                                    $arWaterMark = Array();
            
                                    if($arItem["PROPERTIES"]["GALLERY_WATERMARK"]["VALUE"] > 0){
            
                                        $arWaterMark = Array(
                                            array(
                                                "name" => "watermark",
                                                "position" => "center",
                                                "type" => "image",
                                                "size" => "big",
                                                "file" => $_SERVER["DOCUMENT_ROOT"].CFile::GetPath($arItem["PROPERTIES"]["GALLERY_WATERMARK"]["VALUE"]), 
                                                "fill" => "exact",
                                            )
                                        );
                                    }
                                ?>

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <?
                                        $count_slide = 1;

                                        if($arItem["PROPERTIES"]["GALLERY_PICS_IN_SLIDE"]["VALUE"] > 0)
                                        {
                                            $count_slide = $arItem["PROPERTIES"]["GALLERY_PICS_IN_SLIDE"]["VALUE"];

                                            if($count_slide < 1)
                                                $count_slide = 1;

                                            if($count_slide > 6)
                                                $count_slide = 6;
                                        }
                                            
                                    ?>
                                    <div class="slider-gallery clearfix <?if($count_slide > 1):?>over-one<?endif;?> slider-gallery-<?=$count_slide?>" data-slide-visible = "<?=$count_slide?>">

                                        <?foreach($arItem["PROPERTIES"]["GALLERY"]["VALUE"] as $k=>$photo):?>

                                            <div class="slide-style">

                                                <div class="wrap-slide">
                                                
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                <?
                                                                    $img = CFile::ResizeImageGet($photo, array('width'=>1200, 'height'=>700), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, false, $arWaterMark, false, $img_quality);
                                                                    $img_big = CFile::ResizeImageGet($photo, array('width'=>2000, 'height'=>2000), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, false, $arWaterMark, false, $img_quality);
                                                                ?>

                                                                <a href="<?=$img_big["src"]?>" title="<?=$arItem["PROPERTIES"]["GALLERY"]["DESCRIPTION"][$k]?>" data-gallery="gal<?=$arItem['ID']?>" class="cursor-loop">
                                                                    <div class="slide-element" style="background-image: url('<?=$img["src"]?>');"></div>
                                                                </a>                                                            
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    
                                                    <?if($arItem["GALLERY_COUNT_DESC"] && $count_slide == 1):?>
                                                        <div class="desc"><?=$arItem["PROPERTIES"]["GALLERY"]["DESCRIPTION"][$k]?></div>
                                                    <?endif;?>

                                                </div>

                                                
                                            </div>

                                        <?endforeach;?>
                                    </div>

                                </div>
                                <div class="clearfix"></div>

                            <?else:?>
                            
                                <?
                                    $arWaterMark = Array();
            
                                    if($arItem["PROPERTIES"]["GALLERY_WATERMARK"]["VALUE"] > 0){
            
                                        $arWaterMark = Array(
                                            array(
                                                "name" => "watermark",
                                                "position" => "center",
                                                "type" => "image",
                                                "size" => "real",
                                                "file" => $_SERVER["DOCUMENT_ROOT"].CFile::GetPath($arItem["PROPERTIES"]["GALLERY_WATERMARK"]["VALUE"]), 
                                                "fill" => "exact",
                                            )
                                        );
                                    }                                 
                                ?>
                            
                                <div class="gallery-block clearfix <?if($arItem["PROPERTIES"]["GALLERY_BORDER"]["VALUE"] == "Y"):?>border-img-on<?endif;?> <?=$arItem["PROPERTIES"]["GALLERY_DESK_COLOR"]["VALUE_XML_ID"]?> <?if($arItem["PROPERTIES"]["GALLERY_VIEW"]["VALUE_XML_ID"] == "nogallery"):?>nogallery<?endif;?>">
                                    
                                        
                                    <?if(is_array($arItem["PROPERTIES"]["GALLERY"]["VALUE"]) && !empty($arItem["PROPERTIES"]["GALLERY"]["VALUE"])):?>
        
                                        <? 
                                            $arSize = Array();
        
                                            $arSize[3] = array('width'=>400, 'height'=>400);
                                            $arSize[4] = array('width'=>300, 'height'=>300);
                                            $arSize[6] = array('width'=>200, 'height'=>200);
        
                                            $arStyle = Array();
        
                                            $arStyle[3] = 'big';
                                            $arStyle[4] = 'middle';
                                            $arStyle[6] = 'small';
        
                                            $class = "";
                                            $str = 1;
                                            $rows = 0;

                                        ?>
        
                                        
        
                                        <?foreach($arItem["PROPERTIES"]["GALLERY"]["VALUE"] as $k=>$photo):?>
        
                                            <?if($photo <= 0) continue;?>
        
                                            <?$rows++;?>  
    
                                            <?$class = 12 / $arItem["GALLERY_COUNT"][$str];?>
                                               
                                            <div class="col-lg-<?=$class?> col-md-<?=$class?> col-sm-<?=$class?> <?if($arItem["PROPERTIES"]["GALLERY_VIEW"]["VALUE_XML_ID"] == "nogallery"):?> col-xs-6 <?else:?> col-xs-4<?endif;?> <?=$arStyle[$arItem["GALLERY_COUNT"][$str]]?>">
                                                
                                                <?
                                                    $img_big = CFile::ResizeImageGet($photo, array('width'=>1600, 'height'=>1200), BX_RESIZE_IMAGE_PROPORTIONAL, false, $arWaterMark);
                                                    if($arItem["PROPERTIES"]["GALLERY_VIEW"]["VALUE_XML_ID"] == "nogallery")
                                                        $img = CFile::ResizeImageGet($photo, $arSize[$arItem["GALLERY_COUNT"][$str]], BX_RESIZE_IMAGE_PROPORTIONAL_ALT, false, false, false, $img_quality);
                                                    else
                                                        $img = CFile::ResizeImageGet($photo, $arSize[$arItem["GALLERY_COUNT"][$str]], BX_RESIZE_IMAGE_EXACT, false, false, false, $img_quality);
                                                ?>
     
                                                <div class="gallery-img">
    
                                                    <a title="<?=$arItem["PROPERTIES"]["GALLERY"]["DESCRIPTION"][$k]?>" href="<?=$img_big["src"]?>" data-gallery="gal<?=$arItem['ID']?>" class="cursor-loop">

                                                        <?if($arItem["PROPERTIES"]["GALLERY_VIEW"]["VALUE_XML_ID"] == "nogallery"):?>
    
                                                            <table>
                                                                <tr>
                                                                    <td>
                                                                        <div class="gallery-img-wrap">
                                                                            <div class="corner-line mainColor"></div>
                                                                            <img alt="" class="img-responsive center-block" src="<?=$img["src"]?>" />
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <?if(strlen($arItem["PROPERTIES"]["GALLERY"]["DESCRIPTION"][$k]) > 0 ):?>
                                                                <div class="text-img">
                                                                    <?=$arItem["PROPERTIES"]["GALLERY"]["~DESCRIPTION"][$k]?>
                                                                </div>
                                                            <?endif;?>
    
                                                        <?else:?>
    
                                                            <div class="corner-line mainColor"></div>
                                                            <img alt="" class="img-responsive center-block" src="<?=$img["src"]?>" />
    
                                                        <?endif;?>
                                                        
                                                    </a>
    
                                                </div>

                                            </div> 

                                            <?

                                                if($arItem["PROPERTIES"]["GALLERY_VIEW"]["VALUE_XML_ID"] == "nogallery")
                                                {
                                                    if(($k+1)%2==0)
                                                        echo "<span class='clearfix visible-xs'></span>";
                                                }
                                                else
                                                {
                                                    if(($k+1)%3==0)
                                                        echo "<span class='clearfix visible-xs'></span>";
                                                }

                                                if($rows >= $arItem["GALLERY_COUNT"][$str])
                                                {
                                                    $rows = 0;
                                                    $str++;

                                                    if($str>4) $str=4;

                                                    echo "<span class='clearfix hidden-xs'></span>";
                                                }
                                            ?>
                                                                        
                                        <?endforeach;?>
        
                                    <?endif;?>
                                            
                                </div>
                            
                            <?endif;?>
                            
                        <?endif;?>
                        <?//gallery end?>

                        <?//news?>
                        <?if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "news"):?>
                            <?if(is_array($arItem["ELEMENTS"]) && !empty($arItem["ELEMENTS"])):?>
                                <?if($arItem["PROPERTIES"]["NEWS_VIEW"]["VALUE_XML_ID"] == "chrono"):?>

                                        </div>
                                    </div>
                                        <?if(strlen($arItem["PROPERTIES"]["NEWS_PICTURE"]["VALUE"]) > 0):?>
                                            <div class="container">
                                                <div class="row">
                                                
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 news-image">
                                                        <?$img_big = CFile::ResizeImageGet($arItem["PROPERTIES"]["NEWS_PICTURE"]["VALUE"], array('width'=>1600, 'height'=>1200), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                                        <img alt="" class="img-responsive center-block" src="<?=$img_big["src"]?>">
                                                        
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        <?endif;?>

                                        <div class="news <?if($arItem["SHOW_SUBNAME"] == 0):?>no-date<?endif;?>">
                                            <div class="bg_line">
                                            </div>
                                            <div class="container">
                                                <div class="row">
                                                    <div class="slider slider-news mainColor">
                                                        <?foreach($arItem["ELEMENTS"] as $k=>$arNews):?>

                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <div class="element">

                                                                    <?if($arItem["SHOW_SUBNAME"] > 0):?>
                                                                        <div class="date">
                                                                           <?=$arNews["PROPERTIES"]["DATE"]["~VALUE"]?>
                                                                        </div>
                                                                    <?endif;?>


                                                                    <div class="point">
                                                                    </div>


                                                                    <div class="name main1">
                                                                        <?=$arNews["~NAME"]?>
                                                                    </div>

                                                                    <?if(strlen($arNews["PROPERTIES"]["NEWS_DETAIL_TEXT"]["VALUE"]['TEXT']) > 0):?>
                                                                        <div class="text">

                                                                            <?=$arNews["PROPERTIES"]["NEWS_DETAIL_TEXT"]["~VALUE"]['TEXT']?>
                                                                        </div>
                                                                    <?endif;?>

                                                                    <?if(strlen($arNews["~PREVIEW_TEXT"])>0 || !empty($arNews["PROPERTIES"]["NEWS_GALLERY"]["VALUE"])):?>
                                                                        <div class="btn-detail-wrap no-margin-top-bot">
                                                                            <a class=" link-def btn-modal-open" data-all-id = "<?=implode("," , $arItem["ID_ALL"])?>" data-site-id='<?=SITE_ID?>' data-detail="news"  data-element-id="<?=$arNews["ID"]?>">
                                                                            <i class="fa fa-info" aria-hidden="true"></i><span class="bord"><?=GetMessage("NEWS_DETAIL")?></span></a>

                                                                        </div>
                                                                    <?endif;?>

                                                                    <?admin_setting($arNews)?>
                                                                </div>
                                                            </div>
                                                        <?endforeach;?>

                                                    </div>
                                                </div>
                                            </div>
                                             
                                        </div>

                                    <div class="container">
                                        <div class="row">
                                <?endif;?>
                            <?endif;?>
                        <?endif;?>
                        <?//news end?>

                        <?//faq?>
                        <?if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "faq"):?>
                            
                            <?if(is_array($arItem["ELEMENTS"]) && !empty($arItem["ELEMENTS"])):?>
                                <div class="faq-block col-lg-12 col-md-12 col-sm-12 col-xs-12 <?if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y"):?>parent-animate<?endif;?>">
                                    <div class="row">

                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 hidden-xs">
                                            <div class="photo">

                                                <?if($arItem["PROPERTIES"]["FAQ_PICTURE"]["VALUE"] > 0):?>
                                                    <?$img_big = CFile::ResizeImageGet($arItem["PROPERTIES"]["FAQ_PICTURE"]["VALUE"], array('width'=>700, 'height'=>1096), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                                    <img alt="" class="img-responsive center-block hidden-sm" src="<?=$img_big["src"]?>">
                                                <?else:?>
                                                    <img alt="" class="img-responsive center-block hidden-sm" src="<?=SITE_TEMPLATE_PATH?>/images/faqq.png">
                                                <?endif;?>

                                                <?if(strlen($arItem["PROPERTIES"]["FAQ_NAME"]["VALUE"]) > 0 || strlen($arItem["PROPERTIES"]["FAQ_PROF"]["VALUE"]) > 0):?>
                                                    <div class="comm">
                                                        <?=GetMessage("FAQ_DESC")?>
                                                    </div>
                                                <?endif;?>
                                               
                                                <div class="bot">
                                                    <?if(strlen($arItem["PROPERTIES"]["FAQ_NAME"]["VALUE"]) > 0 || strlen($arItem["PROPERTIES"]["FAQ_PROF"]["VALUE"]) > 0):?>
                                                        <div class="wrap">
                                                            <div class="name">
                                                                <?if(strlen($arItem["PROPERTIES"]["FAQ_NAME"]["VALUE"])):?>
                                                                    <span class="main1"><?=$arItem["PROPERTIES"]["FAQ_NAME"]["~VALUE"]?></span><br>
                                                                <?endif;?>
                                                                <?if(strlen($arItem["PROPERTIES"]["FAQ_PROF"]["VALUE"])):?>
                                                                    <span class="prof italic"><?=$arItem["PROPERTIES"]["FAQ_PROF"]["~VALUE"]?></span>
                                                                <?endif;?>
                                                            </div>
                                                        </div>
                                                    <?endif;?>

                                                    <div class="hidden-sm">
                                                        <?if($arItem["BUTTON_CHANGE"]):?>
                                                            <?CreateButton($arItem);?>
                                                        <?endif;?>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                            <div class="l_wrap">
                                                <div class="faq">

                                                    <?foreach($arItem["ELEMENTS"] as $k=>$arFaq):?>
                                                        <div class="faq-element  <?if($k == 0):?> active <?endif;?> <?if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y"):?>child-animate opacity-zero<?endif;?>">

                                                            <div class="question">
                                                                <span><?=$arFaq["~NAME"]?></span>
                                                            </div>

                                                            <div class="text text-content italic">
                                                                <?=$arFaq["~PREVIEW_TEXT"]?>
                                                            </div>

                                                            <?admin_setting($arFaq)?>
                                                        </div>
                                                    <?endforeach;?>

                                                    <div class="btn_wrap visible-sm visible-xs">
                                                        <?if($arItem["BUTTON_CHANGE"]):?>
                                                            <?CreateButton($arItem);?>
                                                        <?endif;?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            <?endif;?>
                        <?endif;?>
                        <?//faq end?>

                        <?//catalog?>
                        <?if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "catalog"):?>
                        
                            <?if(is_array($arItem["ELEMENTS"]) && !empty($arItem["ELEMENTS"])):?>
                                    </div>
                                </div>
                                <?
                                    $two_cols = false;

                                    if($arItem["PROPERTIES"]["CATALOG_VIEW_XS"]["VALUE_XML_ID"] == "")
                                        $arItem["PROPERTIES"]["CATALOG_VIEW_XS"]["VALUE_XML_ID"] = "6";
                                        
                                    
                                    if($arItem["PROPERTIES"]["CATALOG_VIEW_XS"]["VALUE_XML_ID"] == "6")
                                        $two_cols = true;
                                ?>

                                <div class="catalog-block tab-control <?if(!isset($_COOKIE['__ham_box_'.$arSection["ID"]]) && $arSection["UF_CH_BOX_FCLICK_OPN"]):?>first-click-box-on first-click-box<?endif;?> <?if($two_cols):?>two-cols<?else:?>one-col<?endif;?>">
                                    <div class="container">
                                        <div class="row">
                                            <?
                                                $count_sections = count($arItem["ELEMENTS"]);
                                                $class = '';
                                                $class2 = '';

                                                if($count_sections > 1 && $count_sections < 5)
                                                {
                                                    $class = 'col-lg-3 col-md-3 col-sm-0 col-xs-0';
                                                    
                                                    if($count_sections == 2)
                                                        $class2 = 'col-lg-offset-3 col-md-offset-3 col-sm-offset-0 col-xs-offset-0';

                                                    elseif($count_sections == 3)
                                                        $class2 = 'col-lg-offset-one col-md-offset-one';

                                                }

                                                elseif($count_sections > 4 && $count_sections < 6)
                                                    $class = 'col-lg-five col-md-five col-sm-five col-xs-five';
                                                
                                                elseif($count_sections > 5)
                                                    $class = 'col-lg-2 col-md-2 col-sm-0 col-xs-0';
                                            ?>                                            

                                            <?if($count_sections > 1):?>
                                                <div class="tabs-wrap  hidden-sm hidden-xs clearfix" >

                                                    <?foreach($arItem["ELEMENTS"] as $cell=>$arCatalog):?> 

                                                        <?if(($cell+1) > 6) continue;?>
                                                        
                                                        <div class="tabs-element tab-child <?=$class?> <?if($cell == 0):?> active <?=$class2?> <?endif;?> tab-menu" data-tab='id_<?=$arCatalog['ID']?>'>

                                                            <?if($arItem["SHOW_CATALOG_PICTURE"] > 0):?>

                                                                <div class="image-parent hidden-sm hidden-xs">
                                                                    <div class="image-child">

                                                                        <?$img_big = CFile::ResizeImageGet($arCatalog["PICTURE"], array('width'=>70, 'height'=>70), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                                                            <img alt="<?$arCatalog["NAME"]?>" class="img-responsive center-block"  src="<?=$img_big["src"]?>">
                                                                    
                                                                    </div>
                                                                </div>

                                                            <?endif;?>

                                                            <div class="name">
                                                                <span><?=$arCatalog["NAME"]?><div class="primary"></div></span>
                                                            </div>
                                                        </div>

                                                    <?endforeach;?>

                                                </div>
                                            <?endif;?>
                                        </div>
                                    </div>
                                        
                                    <?if($count_sections > 1):?>
                                        <div class="block-grey-line hidden-sm hidden-xs"></div>
                                    <?endif;?>

                                    <div class="catalog-content-wrap">
                                        <div class="container">

                                            <div class="tabb-content-wrap">

                                                <?$cols = "catalog-element col-lg-3 col-md-3 col-sm-4 col-xs-".$arItem["PROPERTIES"]["CATALOG_VIEW_XS"]["VALUE_XML_ID"];?>
                                          
                                                <?foreach($arItem["ELEMENTS"] as $cell=>$arCatalog):?>

                                                    <?
                                                        $count = count($arCatalog["SECT_ELEMENTS"]);

                                                        $class = "";

                                                        if($count == 1)
                                                            $class = "col-lg-offset-four col-md-offset-four col-sm-offset-four";
                                                        
                                                        elseif($count == 2)
                                                            $class = "col-lg-offset-3 col-md-offset-3 col-sm-offset-0 col-xs-offset-0";
                                                        
                                                        elseif($count == 3)
                                                            $class = "col-lg-offset-one col-md-offset-one";
                                                        
                                                    ?>

                                                    <div class="catalog-content tabb-content show-hidden-parent parent-slide-show <?if($cell == 0):?> active<?endif;?> <?if($count_sections <= 1):?> no-tab<?endif;?> parent-box" data-tab='id_<?=$arCatalog['ID']?>'>
                                                    
                                                        <?if($count_sections > 1):?>
                                                            <div class="mob-title click-slide-show <?if($cell == 0):?> active<?endif;?>">
                                                                <?=$arCatalog["NAME"]?>
                                                                <div class="primary"></div>
                                                                <span></span>
                                                            </div>
                                                        <?endif;?>

                                                        <div class="mob-show content-slide-show <?if($cell == 0):?> active<?endif;?>">
                                                            <div class="row clearfix">
                                                            
                                                                <?
                                                                    if($arItem["PROPERTIES"]["CATALOG_COUNT"]["VALUE"] > 0)
                                                                        $count_line = $arItem["PROPERTIES"]["CATALOG_COUNT"]["VALUE"];
                                                                    else
                                                                        $count_line = 8;
                                                                ?>

                                                                <?foreach($arCatalog["SECT_ELEMENTS"] as $key=>$arElement):?>
                                                                   
                                                                    <div class="<?=$cols?><?if($key == 0):?> <?=$class?><?endif;?><?if($key > $count_line-1):?> hidden<?endif;?><?/*if($key > 5):?>hidden-sm<?endif;*/?>">
                                                                        <!-- <a href="#" class="link-element-wrap"></a> -->

                                                                        <div class="element-wrap element-outer elem-hover">  

                                                                            <div class="element elem-hover-height-more">

                                                                                <div class="element-inner elem-hover-height">

                                                                                    <?if(!$two_cols):?><div class="row clearfix"><?endif;?>
                                                                                
                                                                                        <div class="image-wrap <?if(!$two_cols):?>col-lg-12 col-md-12 col-sm-12 col-xs-5<?endif;?>">

                                                                                            <table>
                                                                                                <tr>
                                                                                                    <td class="parent_anim_img_area">

                                                                                                    <?

                                                                                                        $more_on = false;

                                                                                                        if(!empty($arElement["PROPERTIES"]["CHARACTERISTICS"]["VALUE"]) && !$more_on)
                                                                                                            $more_on = true;

                                                                                                        if(!empty($arElement["PROPERTIES"]["OTHER_COMPLECT"]["VALUE"]) && !$more_on)
                                                                                                            $more_on = true;

                                                                                                        if(strlen($arElement["DETAIL_TEXT"]) > 0 && !$more_on)
                                                                                                            $more_on = true;

                                                                                                        if(strlen($arElement["PREVIEW_TEXT"]) > 0 && !$more_on)
                                                                                                            $more_on = true;
                                                                                                    ?>

                                                                                                    <?if($more_on):?>

                                                                                                        <a class="btn-modal-open" data-header = "<?=$block_name;?>" data-all-id = "<?=implode("," , $arItem["ID_ALL"][$arCatalog["ID"]])?>" data-section-id="<?=$arSection["ID"]?>" data-site-id='<?=SITE_ID?>'  data-detail="catalog"  data-element-id="<?=$arElement['ID']?>" data-main-catalog-id="<?=$arItem["ID"]?>">

                                                                                                    <?endif;?>

                                                                                                    <?if($arElement["PROPERTIES"]["PICTURES"]["VALUE"][0] > 0):?>

                                                                                                        <?if($arElement["PROPERTIES"]["RESIZE_IMAGES"]["VALUE_XML_ID"] == "scale"):?>
                                                                                                            <?$img_big = CFile::ResizeImageGet($arElement["PROPERTIES"]["PICTURES"]["VALUE"][0], array('width'=>240, 'height'=>240), BX_RESIZE_IMAGE_PROPORTIONAL, false, Array(), false, $img_quality);?>
                                                                                                        <?else:?>
                                                                                                            <?$img_big = CFile::ResizeImageGet($arElement["PROPERTIES"]["PICTURES"]["VALUE"][0], array('width'=>240, 'height'=>240), BX_RESIZE_IMAGE_EXACT, false, Array(), false, $img_quality);?>
                                                                                                        <?endif;?>

                                                                                                        <img alt="<?=$arCatalog["NAME"]?>" class="img-responsive center-block animate_to_box" src="<?=$img_big["src"]?>" data-box-id-img="<?=$arElement["ID"]?>">

                                                                                                    <?else:?>
                                                                                                        <img alt="<?=$arCatalog["NAME"]?>" class="img-responsive center-block animate_to_box" src="<?=SITE_TEMPLATE_PATH?>/images/catalog.png" data-box-id-img="<?=$arElement["ID"]?>">
                                                                                                    <?endif;?>

                                                                                                    <?if($more_on):?>
                                                                                                        </a>
                                                                                                    <?endif;?>

                                                                                                </td>
                                                                                                </tr>
                                                                                            </table>
                                                                                            

                                                                                            <?if(!empty($arElement["PROPERTIES"]["HNA"]["VALUE_XML_ID"])):?>

                                                                                                <div class="icons-wrap">

                                                                                                    <?foreach($arElement["PROPERTIES"]["HNA"]["VALUE_XML_ID"] as $arHits):?>

                                                                                                        <?if($arHits == "action"):?>
                                                                                                            <div class="icon ic_act"></div>
                                                                                                        <?endif;?>

                                                                                                        <?if($arHits == "hit"):?>
                                                                                                            <div class="icon ic_pop"></div>
                                                                                                        <?endif;?>

                                                                                                        <?if($arHits == "new"):?>
                                                                                                            <div class="icon ic_new"></div>
                                                                                                        <?endif;?>

                                                                                                    <?endforeach;?>

                                                                                                </div>

                                                                                            <?endif;?>

                                                                                        </div>

                                                                                        <div class="bot-part <?if(!$two_cols):?>col-lg-12 col-md-12 col-sm-12 col-xs-7<?endif;?>">

                                                                                            <div class="name">
                                                                                                <?=$arElement["~NAME"]?>
                                                                                            </div>

                                                                                            <?if(strlen($arElement["PROPERTIES"]["CUR_OLD_PRICE"]["VALUE"])>0 || strlen($arElement["PROPERTIES"]["CUR_PRICE"]["VALUE"])>0):?>

                                                                                                <div class="price-table">

                                                                                                    <?if(strlen($arElement["PROPERTIES"]["CUR_OLD_PRICE"]["VALUE"])>0 && $arElement["PROPERTIES"]["REQUEST_PRICE"]["VALUE"] != "Y"):?>
                                                                                                        <div class="price-cell old-price main2">
                                                                                                            <?=$arElement["PROPERTIES"]["CUR_OLD_PRICE"]["VALUE"]?>
                                                                                                        </div>
                                                                                                    <?endif;?>

                                                                                                    <?if(strlen($arElement["PROPERTIES"]["CUR_PRICE"]["VALUE"])>0 || $arElement["PROPERTIES"]["REQUEST_PRICE"]["VALUE"] == "Y"):?>
                                                                                                    
                                                                                                        <div class="price-cell price">
                                                                                                            <?=$arElement["PROPERTIES"]["CUR_PRICE"]["VALUE"]?>
                                                                                                        </div>
                                                                                                    <?endif;?>
                                                                                                  
                                                                                                </div>

                                                                                            <?endif;?>

                                                                                        </div>

                                                                                    <?if(!$two_cols):?></div><?endif;?>

                                                                                </div>

                                                                                <?if($more_on || $arElement["PROPERTIES"]["SHOW_FORM"]["VALUE"] == "Y" || ($arSection["UF_CH_BOX_ON"] && $arElement["PROPERTIES"]["BOX_ADD"]["VALUE"] == "Y") ):?>

                                                                                    <div class="btn-detail-wrap elem-hover-show">

                                                                                        <?if($arSection["UF_CH_BOX_ON"] && $arElement["PROPERTIES"]["BOX_ADD"]["VALUE"] == "Y"):?>

                                                                                            <?
                                                                                                $btn_name = GetMessage("HAM_BOX_CATALOG_BUTTON_NAME");

                                                                                                if(strlen($arElement["PROPERTIES"]["BOX_BUTTON_NAME"]["~VALUE"]) > 0)
                                                                                                    $btn_name = $arElement["PROPERTIES"]["BOX_BUTTON_NAME"]["~VALUE"];

                                                                                                else if(strlen($arSection["~UF_CH_BOX_BUTTONNAME"]) > 0)
                                                                                                    $btn_name = $arSection["~UF_CH_BOX_BUTTONNAME"];



                                                                                                $btn_name2 = GetMessage("HAM_BOX_CATALOG_BUTTON_NAME_ADDED");

                                                                                                if(strlen($arElement["PROPERTIES"]["BOX_BUTTON_NAME_ADDED"]["~VALUE"]) > 0)
                                                                                                    $btn_name2 = $arElement["PROPERTIES"]["BOX_BUTTON_NAME_ADDED"]["~VALUE"];

                                                                                                else if(strlen($arSection["~UF_CH_BOX_BTNNAME_AD"]) > 0)
                                                                                                    $btn_name2 = $arSection["~UF_CH_BOX_BTNNAME_AD"];


                                                                                            ?>
                                                                                            <div class="def-wrap-btn">

                                                                                                <div class="button-def primary <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?> click_box" data-box-id="<?=$arElement["ID"]?>" data-box-step="<?=$arElement["PROPERTIES"]["BOX_PRICE_STEP"]["VALUE"]?>" data-box-action = "add">

                                                                                                    <span class="first">
                                                                                                       <?=$btn_name?>
                                                                                                    </span>

                                                                                                    <span class="second">
                                                                                                        <?=$btn_name2?>
                                                                                                    </span>
                                                                                                    
                                                                                                </div>

                                                                                            </div>

                                                                                        <?endif;?>


                                                                                        <?if($arElement["PROPERTIES"]["SHOW_FORM"]["VALUE"] == "Y"):?>

                                                                                            <?
                                                                                                $form_id = $Landing["UF_CHAM_CATALOG_FRM"];

                                                                                                if($arItem["PROPERTIES"]["CATALOG_FORM"]["VALUE"])
                                                                                                    $form_id = $arItem["PROPERTIES"]["CATALOG_FORM"]["VALUE"];
                                                                                                
            
                                                                                                if($arElement["PROPERTIES"]["ORDER_FORM"]["VALUE"] > 0)
                                                                                                    $form_id = $arElement["PROPERTIES"]["ORDER_FORM"]["VALUE"];


                                                                                                $btn_name = GetMessage("CATALOG_BUTTON");

                                                                                                if(strlen($arElement["PROPERTIES"]["BUTTON_NAME"]["~VALUE"]) > 0)
                                                                                                    $btn_name = $arElement["PROPERTIES"]["BUTTON_NAME"]["~VALUE"];

                                                                                                else if(strlen($arItem["PROPERTIES"]["CATALOG_BUTTON_NAME"]["~VALUE"]) > 0)
                                                                                                    $btn_name = $arItem["PROPERTIES"]["CATALOG_BUTTON_NAME"]["~VALUE"];

                                                                                                else if(strlen($arSection["~UF_CHAM_CATAL_BTN_N2"]) > 0)
                                                                                                    $btn_name = $arSection["~UF_CHAM_CATAL_BTN_N2"];
                                                                                            ?>

                                                                                            <div class="def-wrap-btn">
                                                                                        
                                                                                                <a class="button-def primary more-modal-info <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?> <?if(strlen($form_id)>0):?>call-modal callform<?endif;?> catalog" data-element-type = "CTL" data-call-modal="form<?=$form_id?>" data-element-id="<?=$arElement["ID"]?>" data-header="<?=$block_name?>">
                                                                                                    <?=$btn_name?>
                                                                                                </a>

                                                                                            </div>

                                                                                        <?endif;?>


                                                                                        <?if($more_on):?>
                                                                                            <div class="def-wrap-btn">
                                                                                                <a class=" link-def btn-modal-open" data-header = "<?=$block_name;?>" data-all-id = "<?=implode("," , $arItem["ID_ALL"][$arCatalog["ID"]])?>" data-site-id='<?=SITE_ID?>' data-section-id="<?=$arSection["ID"]?>"  data-detail="catalog" data-element-id="<?=$arElement['ID']?>" data-main-catalog-id="<?=$arItem["ID"]?>"><i class="fa fa-info" aria-hidden="true"></i> <span class="bord"><?if(strlen($arSection['~UF_MORE_NAME_CTLG'])>0) echo $arSection['~UF_MORE_NAME_CTLG']; else echo GetMessage("MORE_DETAIL");?></span></a>
                                                                                            </div>
                                                                                        <?endif;?>
                                                                                    </div>

                                                                               <?endif;?>

                                                                            <?admin_setting($arElement)?>
                                                                           </div>
                                                                        </div>
                                                                    </div>

                                                                    <?
                                                                        if(($key+1) % 3 == 0)
                                                                            echo "<span class='clearfix visible-sm'></span>";

                                                                        if(($key+1) % 2 == 0)
                                                                            echo "<span class='clearfix visible-xs'></span>";

                                                                        if(($key+1) % 4 == 0)
                                                                            echo "<span class='clearfix hidden-sm'></span>";
                                                                    ?>

                                                                <?endforeach;?>

                                                                <div class="clearfix"></div>

                                                            </div>

                                                            <?if($count > $count_line):?>

                                                                <div class="show-btn-wrap show-hidden-wrap" >
            
                                                                    <a class="button-def secondary big show-hidden <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?>"><?=GetMessage("SHOW_ALL")?></a>
                                                                    
                                                                </div>

                                                            <?endif;?>
                                                        </div>

                                                    </div>

                                                <?endforeach;?>

                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>


                                <div class="container">
                                    <div class="row">
                            <?endif;?>
                        <?endif;?>
                        <?//catalog end?>


                        <?//map?>
                        <?if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "map"):?>
                                </div>
                            </div>

                
                            <div class="map-block <?if(!strlen($arItem["PROPERTIES"]["MAP"]["VALUE"]) > 0):?>no-map<?endif;?>">

                                <?if($arItem["PROPERTIES"]["MAP_VIEW"]["VALUE_XML_ID"] == "info-on-map" && strlen($arItem["PROPERTIES"]["MAP"]["VALUE"]) > 0):?>

                                    <div class="map-descript-wrap">

                                        <div class="container">
                                            <div class="row">

                                                <?if(strlen($arItem["PROPERTIES"]["MAP_NAME"]["VALUE"]) > 0 || !empty($arItem["PROPERTIES"]["MAP_PHONE"]["VALUE"]) || !empty($arItem["PROPERTIES"]["MAP_MAIL"]["VALUE"]) || strlen($arItem["PROPERTIES"]["MAP_ADDRESS"]["~VALUE"]) > 0):?>

                                                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12"> 

                                                        <table class="wrap-table">
                                                            <tr>
                                                                <td>

                                                                    <div class="map-descript">

                                                                        <?if(strlen($arItem["PROPERTIES"]["MAP_NAME"]["VALUE"]) > 0):?>

                                                                            <div class="name">
                                                                                <?=$arItem["PROPERTIES"]["MAP_NAME"]["~VALUE"]?>
                                                                            </div>

                                                                        <?endif;?>


                                                                        <div class="text-table-wrap">

                                                                            <?if(strlen($arItem["PROPERTIES"]["MAP_ADDRESS"]["VALUE"]) > 0):?>

                                                                                <div class="text-table">
                                                                                    <div class="text-cell icon icon-point"></div>

                                                                                    <div class="text-cell text">

                                                                                        <?=$arItem["PROPERTIES"]["MAP_ADDRESS"]["~VALUE"]?>

                                                                                    </div>
                                                                                </div>

                                                                            <?endif;?>

                                                                            <?if(!empty($arItem["PROPERTIES"]["MAP_PHONE"]["VALUE"])):?>

                                                                                <div class="text-table">
                                                                                    <div class="text-cell icon icon-phone">
                                                                                    </div>


                                                                                    <div class="text-cell text phone bold">

                                                                                        <?foreach($arItem["PROPERTIES"]["MAP_PHONE"]["VALUE"] as $k => $arPhone):?>  

                                                                                            <?$phone=preg_replace('/[^0-9+]/', '', $arPhone);?>

                                                                                            <?if($k != 0):?>
                                                                                                <br>
                                                                                            <?endif;?>

                                                                                            <a href="tel:<?=$phone?>"><?=$arPhone?></a>

                                                                                        <?endforeach;?>

                                                                                    </div>
                                                                                </div>

                                                                            <?endif;?>

                                                                            <?if(!empty($arItem["PROPERTIES"]["MAP_MAIL"]["VALUE"])):?>

                                                                                <div class="text-table">
                                                                                    <div class="text-cell icon icon-mail">
                                                                                    </div>


                                                                                    <div class="text-cell text e-mail">
                                                                                        <?foreach($arItem["PROPERTIES"]["MAP_MAIL"]["VALUE"] as $k => $arMail):?>   

                                                                                            <?if($k != 0):?>
                                                                                                <br>
                                                                                            <?endif;?>

                                                                                             <a href="mailto:<?=$arMail?>"><?=$arMail?></a>

                                                                                        <?endforeach;?>

                                                                                    </div>
                                                                                </div>

                                                                            <?endif;?>
                                                                        </div>

                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>                                                    
                                                    </div>

                                                    <span class="clearfix"></span>

                                                <?endif;?>

                                            </div>
                                        </div>

                                    </div>

                                <?else:?>

                                    <div class="bot-wrap">
                                        <div class="container">
                                        
                                            <div class="text-table-wrap clearfix">
                                                <?if(strlen($arItem["PROPERTIES"]["MAP_NAME"]["VALUE"]) > 0):?>
                                                    <div class="text-cell-wrap col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                                        <div class="name">
                                                            <?=$arItem["PROPERTIES"]["MAP_NAME"]["~VALUE"]?>
                                                        </div>
                                                    </div>
                                                <?endif;?>

                                                <?if(strlen($arItem["PROPERTIES"]["MAP_ADDRESS"]["VALUE"]) > 0):?>
                                                    <div class="text-cell-wrap col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                        <div class="text-table">
                                                            <div class="text-cell icon icon-point">
                                                            </div>


                                                            <div class="text-cell text">
                                                                <?=$arItem["PROPERTIES"]["MAP_ADDRESS"]["~VALUE"]?>
                                                            </div>

                                                        </div>
                                                    </div>
                                                <?endif;?>

                                                <span class="clearfix visible-sm"></span>

                                                <?if(!empty($arItem["PROPERTIES"]["MAP_PHONE"]["VALUE"])):?>
                                                    <div class="text-cell-wrap col-lg-3 col-md-3 col-sm-6 col-xs-12">

                                                        <div class="text-table">

                                                            <div class="text-cell icon icon-phone"></div>


                                                            <div class="text-cell text phone bold">

                                                                <?foreach($arItem["PROPERTIES"]["MAP_PHONE"]["VALUE"] as $k => $arPhone):?>  

                                                                    <?$phone=preg_replace('/[^0-9+]/', '', $arPhone);?>

                                                                    <?if($k != 0):?>
                                                                        <br>
                                                                    <?endif;?>

                                                                    <a href="tel:<?=$phone?>"><?=$arPhone?></a>

                                                                <?endforeach;?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                <?endif;?>

                                                <?if(!empty($arItem["PROPERTIES"]["MAP_MAIL"]["VALUE"])):?>
                                                    <div class="text-cell-wrap col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                        <div class="text-table">
                                                            <div class="text-cell icon icon-mail">
                                                            </div>


                                                            <div class="text-cell text e-mail">
                                                               <?foreach($arItem["PROPERTIES"]["MAP_MAIL"]["VALUE"] as $k => $arMail):?>   

                                                                    <?if($k != 0):?>
                                                                        <br>
                                                                    <?endif;?>
                                                                    <a href="mailto:<?=$arMail?>"><?=$arMail?></a>

                                                                <?endforeach;?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <?endif;?>
                                            </div>

                                        </div>
                                           
                                    </div>

                                <?endif;?>


                                <div class="container">

                                    <div class="main-button-wrap center">
                                
                                        <a class="map-show button-def secondary "><?=GetMessage("MAP_SHOW")?></a>    
                                          
                                    </div>

                                </div>
                                
                                <?if(strlen($arItem["PROPERTIES"]["MAP"]["VALUE"]) > 0):?>

                                    <div class="map-height">

                                        <?if (preg_match("<script>", $arItem["PROPERTIES"]["MAP"]["VALUE"])):?>
                                           
                                           <?$map = str_replace("<script ", "<script data-skip-moving='true' ", $arItem["PROPERTIES"]["MAP"]["~VALUE"]);?>
                                           <?=str_replace("scroll=true", "scroll=false", $map);?>
                                           
                                       <?else:?>
                                               
                                           <?if(preg_match("<iframe>", $arItem["PROPERTIES"]["MAP"]["VALUE"])):?>
                                               <div class="overlay" onclick="style.pointerEvents='none'"></div>
                                           <?endif;?>
                                           
                                           <?=$arItem["PROPERTIES"]["MAP"]["~VALUE"];?>
                                                                  
                                       <?endif;?>
             
                                   </div>

                                <?endif;?>
                                          
                                
                            </div>

                            <div class="container">
                                <div class="row">
                        <?endif;?>
                        <?//map end?>

                        <?//switcher?>
                        <?if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "switcher"):?>
                            <?if(!empty($arItem["PROPERTIES"]["SWITCHER_TABNAME"]["~VALUE"])):?>
                                </div>
                                    </div>

                                    <div class="switcher">

                                        <?if($arItem["PROPERTIES"]["SWITCHER_VIEW"]["VALUE_XML_ID"] == "tabs-left" || $arItem["PROPERTIES"]["SWITCHER_VIEW"]["VALUE_XML_ID"] == ""):?>

                                            <div class="container">
                                                <div class="row clearfix">
                                                    
                                                    <div class="col-lg-4 col-md-4 col-sm-0 col-xs-0 hidden-sm hidden-xs">
                                                        <ul class="switcher-tab left">

                                                        <?foreach($arItem["PROPERTIES"]["SWITCHER_TABNAME"]["~VALUE"] as $k => $arTabs):?>  
                                                            

                                                            <li<?if($k == 0):?> class="active"<?endif;?>>
                                                                <span><?=$arTabs;?></span>
                                                            </li>

                                                            <?endforeach;?>
                                                            
                                                        </ul>
                                                    </div>

                                                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                                        <div class="switcher-content-wrap left">

                                                            <?foreach($arItem["PROPERTIES"]["SWITCHER_TABNAME"]["~VALUE"] as $k => $arTabs):?>

                                                                <div class="switcher-wrap <?if($k == 0):?>active<?endif;?>">

                                                                    <div class="switcher-title visible-sm visible-xs <?if($k == 0):?>active<?endif;?>"><?=$arTabs?><div class="primary"></div></div>   

                                                                    <div class="switcher-content text-content<?if($k == 0):?> active<?endif;?>">
                                                                        
                                                                        <?=$arItem["PROPERTIES"]["SWITCHER_HTML"]["~VALUE"][$k]["TEXT"]?>
                                                                    </div>

                                                                </div>
                                                            <?endforeach;?>

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            

                                        <?elseif($arItem["PROPERTIES"]["SWITCHER_VIEW"]["VALUE_XML_ID"] == "tabs-up"):?>

                                            <?$count_sections = count($arItem["PROPERTIES"]["SWITCHER_TABNAME"]["~VALUE"]);?>
                                            <?$class = ''?>
                                            <?$class2 = ''?>

                                            <?if($count_sections > 1 && $count_sections < 5):?>
                                                <?$class = 'col-lg-3 col-md-3 col-sm-0 col-xs-0'?>

                                                <?if($count_sections == 2):?>
                                                    <?$class2 = 'col-lg-offset-3 col-md-offset-3 col-sm-offset-0 col-xs-offset-0'?>

                                                <?elseif($count_sections == 3):?>

                                                    <?$class2 = 'col-lg-offset-one col-md-offset-one'?>

                                                <?endif;?>

                                            <?elseif($count_sections > 4 && $count_sections < 6):?>

                                                <?$class = 'col-lg-five col-md-five col-sm-five col-xs-five'?>

                                            <?elseif($count_sections > 5):?>
                                                <?$class = 'col-lg-2 col-md-2 col-sm-0 col-xs-0'?>
                                            <?endif;?>

                                            <div class="container hidden-sm hidden-xs">
                                                <div class="row">
                                            
                                                    <ul class="switcher-tab">

                                                        <?foreach($arItem["PROPERTIES"]["SWITCHER_TABNAME"]["~VALUE"] as $k => $arTabs):?>  
                                                        <?if(($cell+1) > 6) continue;?>

                                                        <li class="<?=$class?> <?if($k == 0):?>active <?=$class2?><?endif;?>">
                                                            <span><?=$arTabs;?><div class="primary"></div></span>
                                                        </li>

                                                        <?endforeach;?>
                                                        
                                                    </ul> 

                                                </div> 

                                              

                                            </div>

                                            <div class="block-grey-line hidden-sm hidden-xs"></div>

                                            <div class="container">
                                                <div class="switcher-content-wrap">
                                                    
                                                
                                                    <?foreach($arItem["PROPERTIES"]["SWITCHER_TABNAME"]["~VALUE"] as $k => $arTabs):?>

                                                        <div class="switcher-wrap <?if($k == 0):?>active<?endif;?>">

                                                            <div class="switcher-title visible-sm visible-xs <?if($k == 0):?>active<?endif;?>"><?=$arTabs?><div class="primary"></div></div>   

                                                            <div class="switcher-content text-content<?if($k == 0):?> active<?endif;?>">
                                                                
                                                                <?=$arItem["PROPERTIES"]["SWITCHER_HTML"]["~VALUE"][$k]["TEXT"]?>
                                                            </div>

                                                        </div>
                                                    <?endforeach;?>

                                                </div>

                                            </div>

                                        <?endif;?>

                                    </div>

                                <div class="container">
                                    <div class="row">
                            <?endif;?>
                        <?endif;?>

                        <?//switcher end?>
                        
                        
                        <?//blink?>
                        <?if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "blink"):?>

                            <?if(is_array($arItem["ELEMENTS"]) && !empty($arItem["ELEMENTS"])):?> 

                                <div class="banners-menu big-parent-colls <?if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y"):?>parent-animate<?endif;?>">

                                    <?if($admin_active && $show_setting):?>
                                        <div class='change-colls-info'><?=GetMessage('HAMELEON_BLINK_INFO_SAVE')?></div>
                                    <?endif;?>

                                    <div class="">

                                        <div class="frame-wrap clearfix">

                                            <?foreach($arItem["ELEMENTS"] as $k=>$arLink):?>
                                            
                                                <?$size = array("width" => 280, "height" => 280);?>
                                                <?$cols = 'col-lg-3 col-md-3 col-sm-6 col-xs-12 small';?>

                                                <?if($arLink["PROPERTIES"]['BLINK_COLS']['VALUE_XML_ID'] == 'middle'):?>
                                                    <?$size = array("width" => 580, "height" => 280);?>
                                                    <?$cols = 'col-lg-6 col-md-6 col-sm-6 col-xs-12 middle';?>
                                                <?endif;?>
                                                    
                                                    
                                                <?$size2 = array("width" => 400, "height" => 280);?>
                                                <?$size3 = array("width" => 400, "height" => 400);?>

                                                <div class="<?=$cols?> parent-change-cools<?if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y"):?> child-animate opacity-zero<?endif;?>">

                                                    <input type="hidden" class='colls_code' value="BLINK_COLS">
                                                    <input type="hidden" class='colls_middle' value="<?=$arSection['ENUM_COLLS_BLINK'][0]?>">
                                                    <input type="hidden" class='colls_small' value="<?=$arSection['ENUM_COLLS_BLINK'][1]?>">

                                                    <div class="frame <?=$arLink["PROPERTIES"]['BLINK_TEXT_COLOR']['VALUE_XML_ID']?>">
                                                        
                                                        <?if($arLink["PROPERTIES"]['BLINK_LINK_BLOCK']['VALUE'] == 'Y' && strlen($arLink["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'])>0):?>
                                                        
                                                            <a <?if(strlen($arLink["PROPERTIES"]["BLINK_ONCLICK"]["VALUE"])>0) echo "onclick='".$arLink["PROPERTIES"]["BLINK_ONCLICK"]["VALUE"]."'";?> class="wrap-link <?=hamButtonEditClass($arLink["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'], $arLink["PROPERTIES"]['BLINK_BUTTON_FORM']['VALUE'], $arLink["PROPERTIES"]['BLINK_MODAL']['VALUE'])?>" <?=hamButtonEditAttr($arLink["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'], $arLink["PROPERTIES"]['BLINK_BUTTON_FORM']['VALUE'], $arLink["PROPERTIES"]['BLINK_MODAL']['VALUE'], $arLink["PROPERTIES"]['BLINK_BUTTON_LINK']['VALUE'], $arLink["PROPERTIES"]['BLINK_BUTTON_BLANK']['VALUE_XML_ID'], $block_name, $arLink["PROPERTIES"]['BLINK_BUTTON_QUIZ']['VALUE'])?>></a>
                                                        
                                                        
                                                        <?endif;?>
                                                        
                                                       
                                                        <?$img = CFile::ResizeImageGet($arLink["PROPERTIES"]['BLINK_BACKGROUND']['VALUE'], $size, BX_RESIZE_IMAGE_EXACT, true);?>  
                                                        <img class="img hidden-xs hidden-sm" src="<?=$img["src"]?>"  />
                                                        
                                                        
                                                        <?$img = CFile::ResizeImageGet($arLink["PROPERTIES"]['BLINK_BACKGROUND']['VALUE'], $size2, BX_RESIZE_IMAGE_EXACT, true);?>  
                                                        <img class="img visible-sm" src="<?=$img["src"]?>"  />
                                                        
                                                        
                                                        <?$img = CFile::ResizeImageGet($arLink["PROPERTIES"]['BLINK_BACKGROUND']['VALUE'], $size3, BX_RESIZE_IMAGE_EXACT, true);?>  
                                                        <img class="img visible-xs" src="<?=$img["src"]?>"  />
                                    
                                                                      
                                                    
                                                                
                                                        <div class="small-shadow"></div>
                                                        <div class="frameshadow"></div>
                                                        
                                                        <div class="text">
                                                        
                                                            <div class="cont">
                                                                <div class="name bold"><?=$arLink["PROPERTIES"]['BLINK_TITLE']['~VALUE']?></div>
                                                                <div class="comment"><?=$arLink["PROPERTIES"]['BLINK_TEXT']['~VALUE']["TEXT"]?></div>
                                                            </div>

                                                            <?if(strlen($arLink["PROPERTIES"]['BLINK_NAME']['VALUE'])>0 && strlen($arLink["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'])>0):?>

                                                                <div class="button">
                                                                     
                                                                    <?if($arLink["PROPERTIES"]['BLINK_LINK_BLOCK']['VALUE'] == 'Y'):?>
                                                                        
                                                                        <a class="medium button-def primary <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?>"><?=$arLink["PROPERTIES"]['BLINK_NAME']['~VALUE']?></a>
                                                                    
                                                                    <?else:?>                                                           
                                                                    
                                                                         <a <?if(strlen($arLink["PROPERTIES"]["BLINK_ONCLICK"]["VALUE"])>0) echo "onclick='".$arLink["PROPERTIES"]["BLINK_ONCLICK"]["VALUE"]."'";?> class="button-def primary medium <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?> <?=hamButtonEditClass($arLink["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'], $arLink["PROPERTIES"]['BLINK_BUTTON_FORM']['VALUE'], $arLink["PROPERTIES"]['BLINK_MODAL']['VALUE'])?>" <?=hamButtonEditAttr($arLink["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'], $arLink["PROPERTIES"]['BLINK_BUTTON_FORM']['VALUE'], $arLink["PROPERTIES"]['BLINK_MODAL']['VALUE'], $arLink["PROPERTIES"]['BLINK_BUTTON_LINK']['VALUE'], $arLink["PROPERTIES"]['BLINK_BUTTON_BLANK']['VALUE_XML_ID'], $block_name, $arLink["PROPERTIES"]['BLINK_BUTTON_QUIZ']['VALUE'])?>><?=$arLink["PROPERTIES"]['BLINK_NAME']['~VALUE']?></a>
                                                                    
                                                                    <?endif;?>
                                                                    
                                                                </div>
                                                            <?endif;?>

                                                        </div>

                                                        <?admin_setting($arLink)?>



                                                        <?if($admin_active && $show_setting):?>
    
                                                            <span class='change-colls' data-type='element' data-element-id='<?=$arLink['ID']?>'></span>
    
                                                        <?endif;?>
                                                        
                                                    </div>
                                                </div>

                                                <?if(($k+1) % 2 == 0 ):?><div class="clearfix visible-sm"></div><?endif;?>

                                            <?endforeach;?>
                                        </div>

                             
                                    </div>
                               

                                </div>

                            <?endif;?>

                            <?if($arItem["PROPERTIES"]["BLINK_VIEW"]["VALUE_XML_ID"] == "banner"):?>
                                <div class="banner clearfix">
                                    
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    
                                        <?
                                            $bg = '';

                                            if(strlen($arItem["PROPERTIES"]['BLINK_BACKGROUND']['VALUE'])>0)
                                                $bg = CFile::ResizeImageGet($arItem["PROPERTIES"]['BLINK_BACKGROUND']['VALUE'], array('width'=>900, 'height'=>900), BX_RESIZE_IMAGE_PROPORTIONAL, false);
                                        ?>

                                        <div class="element" style="background-image: url('<?=$bg["src"]?>');">
                                            <div class="row">

                                                <?
                                                    $view = '1';
                                                    $col_img = 'col-lg-3 col-md-3';
                                                    $col_btn = 'col-lg-3 col-md-3';
                                                    $col_text = 'col-lg-6 col-md-6';

                                                    $text_ini = false;
                                                    $img_ini = false;
                                                    $btn_ini = false;

                                                    if(strlen($arItem["PROPERTIES"]['BLINK_TITLE']['VALUE'])>0 ||strlen($arItem["PROPERTIES"]['BLINK_TEXT']['VALUE']['TEXT'])>0)
                                                        $text_ini = true;

                                                    if(strlen($arItem["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'])>0 && strlen($arItem["PROPERTIES"]['BLINK_NAME']['VALUE'])>0)
                                                        $btn_ini = true;

                                                    if(strlen($arItem["PROPERTIES"]['BLINK_PICTURE']['VALUE'])>0)
                                                        $img_ini = true;
                                                    

                                                    if(!$btn_ini)
                                                    {
                                                        $col_btn = 'hidden-lg hidden-md';
                                                        $col_img = 'col-lg-3 col-md-3';
                                                        $col_text = 'col-lg-9 col-md-9';
                                                    }

                                                    if(!$img_ini)
                                                    {
                                                        $col_img = 'hidden-lg hidden-md';
                                                        $col_btn = 'col-lg-3 col-md-3';
                                                        $col_text = 'col-lg-9 col-md-9';
                                                    }

                                                    if(!$btn_ini && !$img_ini)
                                                    {
                                                        $col_btn = 'hidden-lg hidden-md';
                                                        $col_img = 'hidden-lg hidden-md';
                                                        $col_text = 'col-lg-12 col-md-12';
                                                    }


                                                    $mark1 = $col_text.'';
                                                    $mark2 = $col_btn.' button';
                                                    $mark3 = $col_img.' image';


                                                    if($arItem["PROPERTIES"]['BLINK_POSITION']['VALUE_XML_ID'] == 'view2')
                                                    {
                                                        $view = '2';
                                                        $mark1 = $col_btn.' button';
                                                        $mark2 = $col_text.'';
                                                        $mark3 = $col_img.' image';
                                                    }

                                                    elseif($arItem["PROPERTIES"]['BLINK_POSITION']['VALUE_XML_ID'] == 'view3')
                                                    {
                                                        $view = '3';
                                                        $mark1 = $col_img.' image';
                                                        $mark2 = $col_btn.' button';
                                                        $mark3 = $col_text.'';
                                                    }

                                                    elseif($arItem["PROPERTIES"]['BLINK_POSITION']['VALUE_XML_ID'] == 'view4')
                                                    {
                                                        $view = '4';
                                                        $mark1 = $col_img.' image';
                                                        $mark2 = $col_text.'';
                                                        $mark3 = $col_btn.' button';
                                                    }
                                                ?>

                                                <div class="part-wrap <?=$arItem["PROPERTIES"]['BLINK_TEXT_COLOR']['VALUE_XML_ID']?>">

                                                    <div class="part col-sm-8 col-xs-12 left <?=$mark1?>">
                                                        <div class="part-inner-wrap">

                                                            <div class="hidden-sm hidden-xs unset-margin-top-child">
                                                                <?if($view == '1'):?>

                                                                    <?if(strlen($arItem["PROPERTIES"]['BLINK_TITLE']['VALUE'])>0):?>
                                                                        <div class="text bold"><?=$arItem["PROPERTIES"]['BLINK_TITLE']['~VALUE']?></div>
                                                                    <?endif;?>

                                                                    <?if(strlen($arItem["PROPERTIES"]['BLINK_TEXT']['VALUE']['TEXT'])>0):?>
                                                                        <div class="desc"><?=$arItem["PROPERTIES"]['BLINK_TEXT']['~VALUE']['TEXT']?></div>
                                                                    <?endif;?>

                                                                <?elseif($view == '2'):?>

                                                                    <?if($btn_ini):?>
                                                                      

                                                                        <a <?if(strlen($arItem["PROPERTIES"]["BLINK_ONCLICK"]["VALUE"])>0) echo "onclick='".$arItem["PROPERTIES"]["BLINK_ONCLICK"]["VALUE"]."'";?> class="button-def main-color <?=$btn_view?> <?=hamButtonEditClass($arItem["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'], $arItem["PROPERTIES"]['BLINK_BUTTON_FORM']['VALUE'], $arItem["PROPERTIES"]['BLINK_MODAL']['VALUE'])?>" <?=hamButtonEditAttr($arItem["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'], $arItem["PROPERTIES"]['BLINK_BUTTON_FORM']['VALUE'], $arItem["PROPERTIES"]['BLINK_MODAL']['VALUE'], $arItem["PROPERTIES"]['BLINK_BUTTON_LINK']['VALUE'], $arItem["PROPERTIES"]['BLINK_BUTTON_BLANK']['VALUE_XML_ID'], $block_name, $arItem["PROPERTIES"]['BLINK_BUTTON_QUIZ']['VALUE'])?>><?=$arItem["PROPERTIES"]['BLINK_NAME']['~VALUE']?></a>

                                                                    <?endif;?>

                                                                <?elseif($view == '3' || $view == '4'):?>

                                                                    <?if($img_ini):?>

                                                                        <?$img = CFile::ResizeImageGet($arItem["PROPERTIES"]['BLINK_PICTURE']['VALUE'], array('width'=>300, 'height'=>2900), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                                                        <img src="<?=$img['src']?>" alt="" class="img-responsive">

                                                                    <?endif;?>

                                                                <?endif;?>
                                                            </div>

                                                            <noindex>
                                                                <div class="visible-sm visible-xs unset-margin-top-child">
                                                                
                                                                    <?if(strlen($arItem["PROPERTIES"]['BLINK_TITLE']['VALUE'])>0):?>
                                                                        <div class="text bold"><?=$arItem["PROPERTIES"]['BLINK_TITLE']['~VALUE']?></div>
                                                                    <?endif;?>

                                                                    <?if(strlen($arItem["PROPERTIES"]['BLINK_TEXT']['VALUE']['TEXT'])>0):?>
                                                                        <div class="desc"><?=$arItem["PROPERTIES"]['BLINK_TEXT']['~VALUE']['TEXT']?></div>
                                                                    <?endif;?>

                                                                    <?if($btn_ini):?>
                                                                    

                                                                        <a <?if(strlen($arItem["PROPERTIES"]["BLINK_ONCLICK"]["VALUE"])>0) echo "onclick='".$arItem["PROPERTIES"]["BLINK_ONCLICK"]["VALUE"]."'";?> class="medium button-def primary <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?> <?=hamButtonEditClass($arItem["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'], $arItem["PROPERTIES"]['BLINK_BUTTON_FORM']['VALUE'], $arItem["PROPERTIES"]['BLINK_MODAL']['VALUE'])?>" <?=hamButtonEditAttr($arItem["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'], $arItem["PROPERTIES"]['BLINK_BUTTON_FORM']['VALUE'], $arItem["PROPERTIES"]['BLINK_MODAL']['VALUE'], $arItem["PROPERTIES"]['BLINK_BUTTON_LINK']['VALUE'], $arItem["PROPERTIES"]['BLINK_BUTTON_BLANK']['VALUE_XML_ID'], $block_name, $arItem["PROPERTIES"]['BLINK_BUTTON_QUIZ']['VALUE'])?>><?=$arItem["PROPERTIES"]['BLINK_NAME']['~VALUE']?></a>
                                                                        
                                                                    <?endif;?>
                                                                </div>
                                                            </noindex> 
                                                            
                                                        </div>
                                                    </div>

                                                    <div class="part col-sm-0 col-xs-0 center hidden-sm hidden-xs <?=$mark2?>">

                                                        <div class="part-inner-wrap">
                                                            <?if($view == '1' || $view == '3'):?>

                                                                <?if($btn_ini):?>
                                                                    <a <?if(strlen($arItem["PROPERTIES"]["BLINK_ONCLICK"]["VALUE"])>0) echo "onclick='".$arItem["PROPERTIES"]["BLINK_ONCLICK"]["VALUE"]."'";?> class="medium button-def primary <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?> <?=hamButtonEditClass($arItem["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'], $arItem["PROPERTIES"]['BLINK_BUTTON_FORM']['VALUE'], $arItem["PROPERTIES"]['BLINK_MODAL']['VALUE'])?>" <?=hamButtonEditAttr($arItem["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'], $arItem["PROPERTIES"]['BLINK_BUTTON_FORM']['VALUE'], $arItem["PROPERTIES"]['BLINK_MODAL']['VALUE'], $arItem["PROPERTIES"]['BLINK_BUTTON_LINK']['VALUE'], $arItem["PROPERTIES"]['BLINK_BUTTON_BLANK']['VALUE_XML_ID'], $block_name, $arItem["PROPERTIES"]['BLINK_BUTTON_QUIZ']['VALUE'])?>><?=$arItem["PROPERTIES"]['BLINK_NAME']['~VALUE']?></a>

                                                                    
                                                                <?endif;?>

                                                            <?elseif($view == '2' || $view == '4'):?>

                                                                <?if(strlen($arItem["PROPERTIES"]['BLINK_TITLE']['VALUE'])>0):?>
                                                                    <div class="text bold"><?=$arItem["PROPERTIES"]['BLINK_TITLE']['~VALUE']?></div>
                                                                <?endif;?>

                                                                <?if(strlen($arItem["PROPERTIES"]['BLINK_TEXT']['VALUE']['TEXT'])>0):?>
                                                                    <div class="desc"><?=$arItem["PROPERTIES"]['BLINK_TEXT']['~VALUE']['TEXT']?></div>
                                                                <?endif;?>

                                                            <?endif;?>

                                                        </div>
                                                    </div>

                                                    <div class="part col-sm-4 col-xs-12 right <?=$mark3?>">
                                                        <div class="part-inner-wrap">
                                                            <div class="hidden-sm hidden-xs unset-margin-top-child">

                                                                <?if($view == '1' || $view == '2'):?>

                                                                    <?if($img_ini):?>

                                                                        <?$img = CFile::ResizeImageGet($arItem["PROPERTIES"]['BLINK_PICTURE']['VALUE'], array('width'=>300, 'height'=>2900), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                                                        <img src="<?=$img['src']?>" alt="" class="img-responsive">
                                                                    
                                                                    <?endif;?>

                                                                <?elseif($view == '3'):?>

                                                                    <?if(strlen($arItem["PROPERTIES"]['BLINK_TITLE']['VALUE'])>0):?>
                                                                        <div class="text bold"><?=$arItem["PROPERTIES"]['BLINK_TITLE']['~VALUE']?></div>
                                                                    <?endif;?>

                                                                    <?if(strlen($arItem["PROPERTIES"]['BLINK_TEXT']['VALUE']['TEXT'])>0):?>
                                                                        <div class="desc"><?=$arItem["PROPERTIES"]['BLINK_TEXT']['~VALUE']['TEXT']?></div>
                                                                    <?endif;?>

                                                                <?elseif($view == '4'):?>
                                                                    <?if($btn_ini):?>
                                                                        <a <?if(strlen($arItem["PROPERTIES"]["BLINK_ONCLICK"]["VALUE"])>0) echo "onclick='".$arItem["PROPERTIES"]["BLINK_ONCLICK"]["VALUE"]."'";?> class="medium button-def primary <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?> <?=hamButtonEditClass($arItem["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'], $arItem["PROPERTIES"]['BLINK_BUTTON_FORM']['VALUE'], $arItem["PROPERTIES"]['BLINK_MODAL']['VALUE'])?>" <?=hamButtonEditAttr($arItem["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'], $arItem["PROPERTIES"]['BLINK_BUTTON_FORM']['VALUE'], $arItem["PROPERTIES"]['BLINK_MODAL']['VALUE'], $arItem["PROPERTIES"]['BLINK_BUTTON_LINK']['VALUE'], $arItem["PROPERTIES"]['BLINK_BUTTON_BLANK']['VALUE_XML_ID'], $block_name, $arItem["PROPERTIES"]['BLINK_BUTTON_QUIZ']['VALUE'])?>><?=$arItem["PROPERTIES"]['BLINK_NAME']['~VALUE']?></a>
                                                                        
                                                                    <?endif;?>
                                                                <?endif;?>

                                                            </div>

                                                            <noindex>
                                                                <div class="visible-sm visible-xs unset-margin-top-child">
                                                                    <?if($img_ini):?>

                                                                        <?$img = CFile::ResizeImageGet($arItem["PROPERTIES"]['BLINK_PICTURE']['VALUE'], array('width'=>300, 'height'=>2900), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                                                        <img src="<?=$img['src']?>" alt="" class="img-responsive">
                                                                    
                                                                    <?endif;?>
                                                                </div>  
                                                            </noindex>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                            <?if($arItem["PROPERTIES"]['BLINK_LINK_BLOCK']['VALUE'] == 'Y' && strlen($arItem["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'])>0):?>
                                                <a <?if(strlen($arItem["PROPERTIES"]["BLINK_ONCLICK"]["VALUE"])>0) echo "onclick='".$arItem["PROPERTIES"]["BLINK_ONCLICK"]["VALUE"]."'";?> class="wrap-link <?=hamButtonEditClass($arItem["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'], $arItem["PROPERTIES"]['BLINK_BUTTON_FORM']['VALUE'], $arItem["PROPERTIES"]['BLINK_MODAL']['VALUE'])?>" <?=hamButtonEditAttr($arItem["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'], $arItem["PROPERTIES"]['BLINK_BUTTON_FORM']['VALUE'], $arItem["PROPERTIES"]['BLINK_MODAL']['VALUE'], $arItem["PROPERTIES"]['BLINK_BUTTON_LINK']['VALUE'], $arItem["PROPERTIES"]['BLINK_BUTTON_BLANK']['VALUE_XML_ID'], $block_name, $arItem["PROPERTIES"]['BLINK_BUTTON_QUIZ']['VALUE'])?>></a>
                                            
                                            <?endif;?>


                                        </div>
                                
                                    </div>
                                  
                                </div>
                            <?endif;?>

                        <?endif;?>

                        <?//blink end?>
                        

                        <?//partners?>
                        <?if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "partners"):?>

                            <?if(is_array($arItem["PROPERTIES"]["PARTNERS"]["VALUE"]) && !empty($arItem["PROPERTIES"]["PARTNERS"]["VALUE"])):?>

                                <?
                                    $countPartners = count($arItem["PROPERTIES"]["PARTNERS"]["VALUE"]);

                                    $class = "";
                                    $offsetClass = "";

                                    if($countPartners <= 6)
                                    {

                                        if($countPartners <= 4)
                                            $class="col-lg-3 col-md-3 col-sm-4 col-xs-6 big";
                                        
                                        else
                                            $class="col-lg-2 col-md-2 col-sm-4 col-xs-6";
                                        

                                        $arNeed = array(
                                            "0.16" => array("OFFSET"=>"col-lg-offset-four col-md-offset-four col-sm-offset-four col-xs-offset-3"), 
                                            "0.33" => array("OFFSET"=>"col-lg-offset-3 col-md-offset-3 col-sm-offset-0 col-xs-offset-0"), 
                                            "0.5" =>  array("OFFSET"=>"col-lg-offset-one col-md-offset-one col-sm-offset-0 col-xs-offset-0"),
                                            "0.66" =>  array("OFFSET"=>""),
                                            "0.83" =>  array("OFFSET"=>"col-lg-offset-1 col-md-offset-1 col-sm-offset-0 col-xs-offset-0"));
                                
                                        $residual = strval(floor(($countPartners / 6)*100)/100);
                                        $needKey = 1;
                                    }

                                    else
                                    {
                                        $class="col-lg-2 col-md-2 col-sm-4 col-xs-6";

                                        $arNeed = array(
                                            "0.16" => array("OFFSET"=>"col-lg-offset-5 col-md-offset-5 col-sm-offset-0 col-xs-offset-3", "NUM" => 0), 
                                            "0.33" => array("OFFSET"=>"col-lg-offset-4 col-md-offset-4 col-sm-offset-0 col-xs-offset-0", "NUM" => 1), 
                                            "0.5" =>  array("OFFSET"=>"col-lg-offset-3 col-md-offset-3 col-sm-offset-0 col-xs-offset-0", "NUM" => 2),
                                            "0.66" =>  array("OFFSET"=>"col-lg-offset-2 col-md-offset-2 col-sm-offset-0 col-xs-offset-0", "NUM" => 3),
                                            "0.83" =>  array("OFFSET"=>"col-lg-offset-1 col-md-offset-1 col-sm-offset-0 col-xs-offset-0", "NUM" => 4));

                                
                                        $residual = strval((floor(($countPartners / 6)*100)/100) - (intval($countPartners / 6))) ;
                                        $needKey = $countPartners - $arNeed[$residual]["NUM"];
                                    }

                                ?>

                                <div class="partners clearfix">

                                    <?foreach($arItem["PROPERTIES"]["PARTNERS"]["VALUE"] as $k => $arPartner):?>

                                        <div class="<?=$class?> <?if(($k+1) == $needKey):?> <?=$arNeed[$residual]["OFFSET"]?> <?endif;?>">

                                            <?if($countPartners <= 4):?>
                                                <?$img = CFile::ResizeImageGet($arPartner, array('width'=>360, 'height'=>180), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                            <?else:?>
                                                <?$img = CFile::ResizeImageGet($arPartner, array('width'=>288, 'height'=>144), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                            <?endif;?>

                                            <div class="partners-wrap">

                                                <table>
                                                    <tr>
                                                        <td><img class="img-responsive <?if($arItem["PROPERTIES"]["PARTNERS_SHADOW"]["VALUE"] == "Y"):?>shadow<?endif;?>" src="<?=$img["src"]?>"></td>
                                                    </tr>
                                                </table>

                                                <?if(strlen($arItem["PROPERTIES"]["PARTNERS"]["DESCRIPTION"][$k]) > 0):?>

                                                    <div class="partners-part-bot hidden-sm hidden-xs">
                                                        <?=$arItem["PROPERTIES"]["PARTNERS"]["~DESCRIPTION"][$k]?>
                                                    </div>

                                                <?endif;?>

                                            </div>
                                            
                                        </div>

                                        <?
                                            if(($k+1) % 2 == 0)
                                                echo "<div class='clearfix visible-xs'></div>";
                                           
                                            if(($k+1) % 3 == 0)
                                                echo "<div class='clearfix visible-sm'></div>";
                                         
                                            if(($k+1) % 6 == 0)
                                                echo "<div class='clearfix'></div>";
                                        ?>

                                    <?endforeach;?>

                                </div>

                            <?endif;?>

                        <?endif;?>

                        <?//partners end?>


                        <?if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "component"):?>
                            #DYNAMIC<?=$components?>#
                            <?$components++;?>
                        <?endif;?>
                    
                
                    </div>

                    <?if(!$arItem["BUTTON_CHANGE"]):?>
                        <?CreateButton($arItem);?>
                    <?endif;?>
                
                </div>
            </div>
            

            <?foreach($arItem["PROPERTIES"]["LINES"]["VALUE_XML_ID"] as $line):?>
                
                <div class="line-ds <?=$line?>">
                    <div class="container">
                        <div class="ln"></div>
                    </div>
                </div>

            <?endforeach;?>

            <?admin_setting($arItem, true);?>
        </div>

    <?endif;?>    
<?}?>


<style>
    <?if($arResult["SECTION"]["UF_CHAM_HIDESCROLL"] == 1):?>
        ::-webkit-scrollbar{ 
            width: 0px; 
        }
    <?endif;?>

    <?if(strlen($arResult["SECTION"]["UF_CH_BODY_BG"])>0 || strlen($arResult["SECTION"]["UF_CH_BODY_BG_CLR"])>0):?>

    <?$bgBody = CFile::ResizeImageGet($arResult["SECTION"]["UF_CH_BODY_BG"], array('width'=>2000, 'height'=>12000), BX_RESIZE_IMAGE_PROPORTIONAL, false, false, false, $img_quality);?>
        body{
            <?if(!empty($bgBody)):?>background-image: url(<?=$bgBody["src"]?>);<?endif;?>
            background-attachment: <?=$arResult["SECTION"]["UF_CH_POS_BODY_BG_ENUM"]["XML_ID"]?>;
            background-repeat: <?=$arResult["SECTION"]["UF_CH_BODY_REPEAT_BG_ENUM"]["XML_ID"]?>;
            background-position: top center;
            background-color: <?=$arResult["SECTION"]["UF_CH_BODY_BG_CLR"]?>;
        }

    <?endif;?>
</style>


<?if(!empty($arResult["MENU"])):?>
<a class="menu-slide-close click-cl-menu tone-<?=$arResult["SECTION"]["UF_CHAM_HEADER_CLR_ENUM"]["XML_ID"]?>"></a>


<div class="slide-menu tone-<?=$arResult["SECTION"]["UF_CHAM_HEADER_CLR_ENUM"]["XML_ID"]?>">
    <div class="inner">
        

        <div class="head-wrap">
            <div class="head-table">        
                
                <div class="head-cell logotype">
                   <a href="#body" class="scroll close-from-menu"><img src="<?=CFile::getPath($arResult["SECTION"]["PICTURE"])?>" alt="" class="img-responsive"></a> 
                </div>

                <?if(strlen($arResult["SECTION"]["UF_CHAM_DESCRIPT"]) > 0):?>   
                    <div class="head-cell descrip right hidden-xs"><?=$arResult["SECTION"]["~UF_CHAM_DESCRIPT"]?></div>
                <?endif;?>

            </div>
        </div>

        <div class="menu-content no-margin-top-bot ">

            <ul class="nav">

                 <?foreach($arResult["MENU"] as $keys => $arMenu):?>
                 
                    <li class="<?if($arMenu["HIDE_LG"] == "Y") echo 'hidden-lg hidden-md'; if($arMenu["HIDE"] == "Y") echo 'hidden-sm hidden-xs';?>">
                        
                        <?if(strlen($arMenu["MENU_LINK"]) > 0):?>
                        
                            <a href="<?=$arMenu["MENU_LINK"]?>" <?if($arMenu["MENU_LINK_OPEN"] == "Y"):?>target="_blank"<?endif;?> class="scroll close-from-menu"><span><?=$arMenu["NAME"]?></span></a>
                      
                        <?else:?>
                        
                            <a href="#block<?=$arMenu['ID']?>" class="scroll close-from-menu"><span><?=$arMenu["NAME"]?></span></a>
                        
                        <?endif;?>
                    </li>

                <?endforeach;?>

            </ul>

        </div>

        <div class="foot-wrap">
            <div class="foot-inner">
            
                <?if($arResult["SECTION"]["UF_CHAM_CALLBACK"]):?>
                    <div class="part-cell left">
                        <a class="button-def primary big <?if(strlen($arResult["SECTION"]["UF_CHAM_CALLBACK_FRM"])>0):?>call-modal callform<?endif;?> <?=$arResult["SECTION"]["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?>" data-header="<?=GetMessage("FORM_HEADER_CALLBACK")?>" data-call-modal="form<?=$arResult["SECTION"]["UF_CHAM_CALLBACK_FRM"]?>">
                           <?=GetMessage("CALLBACK")?>
                        </a>

                     
                    </div>
                <?endif;?>

                <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) > 0):?>
                    <div class="part-cell right">
                        <table>
                            <tr>
                                <td>
                                    <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) > 0):?>
                                       <div class="number main1">
                                            <?=$arResult["SECTION"]["~UF_CHAM_PHONE"]?>
                                        </div>
                                    <?endif;?> 
                                    
                                    <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) <= 0 && strlen($arResult["SECTION"]["UF_CHAM_PHONECOMM1"]) >= 0):?>     
                                        <div class="email">
                                            <?=$arResult["SECTION"]["~UF_CHAM_PHONECOMM1"]?>
                                        </div>
                                    <?endif;?>
                                    
                                    <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) > 0):?>     
                                        <div class="email">
                                            <a href="mailto:<?=$arResult["SECTION"]["UF_CHAM_EMAIL"]?>"><?=$arResult["SECTION"]["UF_CHAM_EMAIL"]?></a>
                                        </div>
                                    <?endif;?>
                                </td>
                                
                            </tr>
                        </table>
                                            
                    </div>
                <?endif;?>
                
                
                <?if($arResult["SHOW_SOC"] && in_array("menu", $arResult["SECTION"]["UF_CHAM_SOC_VIEW_ENUM"])):?>

                    <div class="part-cell right hidden-sm">
                        <?CreateSoc($arResult["SECTION"])?>
                    </div>
                
                <?endif;?>

            </div>
            
            <?if($arResult["SHOW_SOC"] && in_array("menu", $arResult["SECTION"]["UF_CHAM_SOC_VIEW_ENUM"])):?>

                <div class="part-cell right visible-sm">
                    <?CreateSoc($arResult["SECTION"])?>
                </div>
            
            <?endif;?>
            
        </div>

    </div>

</div> 

<?endif;?>

<div class="wrapper tone-<?=$arResult["SECTION"]["UF_CHAM_HEADER_CLR_ENUM"]["XML_ID"]?>">

    <input class="tmpl" name="tmpl" value="<?=SITE_TEMPLATE_ID?>" type="hidden">
    <input class="site_id" name="site_id" value="<?=SITE_ID?>" type="hidden">
    <input class="btn_type" name="btn_type" value="<?=$arResult["SECTION"]["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?>" type="hidden">
    <input class="sect" name="section" value="<?=$arResult["SECTION"]["ID"]?>" type="hidden">
    <input class="ib" name="ib" value="<?=$arResult["SECTION"]["IBLOCK_ID"]?>" type="hidden">
   

    <?
        $header_class = "full";
        $header_style = "";

        if(strlen($arResult["SECTION"]["UF_CHAM_HEADER_BACK"]) > 0 || $arResult["SECTION"]["UF_CHAM_HEADER_IMG"] > 0)
        {
            $header_class = "small";


            if(strlen($arResult["SECTION"]["UF_CHAM_HEADER_BACK"]) > 0)
            {
                $arColor = $arResult["SECTION"]["UF_CHAM_HEADER_BACK"];

                if($arColor == "transparent")
                    $header_style .= 'background-color: transparent; ';

                else if(preg_match('/^\#/', $arResult["SECTION"]["UF_CHAM_HEADER_BACK"]))
                {
                    $arColor = hex2rgb($arResult["SECTION"]["UF_CHAM_HEADER_BACK"]);
                    $arColor = implode(',',$arColor);

                    $percent = 1;
        
                    if(strlen($arResult["SECTION"]["UF_CHAM_HEADER_BK_O"])>0)
                        $percent = (100 - $arResult["SECTION"]["UF_CHAM_HEADER_BK_O"])/100;
                    
                    $header_style .= 'background-color: rgba('.$arColor.', '.$percent.'); ';
                }

                else
                    $header_style .= 'background-color: '.$arColor.'; ';
        
                
            }

            if($arResult["SECTION"]["UF_CHAM_HEADER_IMG"] > 0)
                $header_style .= 'background-image: url('.CFile::getPath($arResult["SECTION"]["UF_CHAM_HEADER_IMG"]).'); background-position: top center; background-repeat: no-repeat; ';
            

            if($arResult["SECTION"]["UF_CHAM_HEADER_IMG_F"])
                $header_style .= 'background-size: cover; ';
            
        }

        global $header_bg_on;
        $header_bg_on = false;

        if(strlen($header_style)>0)
        {
            $header_style = "style = '".$header_style."'";
            $header_bg_on = true;
        }


        if($arResult["SECTION"]["UF_CHAM_LOGOTYPE"]) 
            $header_class .= " type-1"; 
        else 
            $header_class .= " type-2"; 

        if($arResult["SECTION"]["UF_CHAM_SLIDEMENU"]) 
            $header_class .= " slide"; 

        if($arResult["SECTION"]["UF_CHAM_MENU_TYPE_ENUM"]["XML_ID"] != "first" && !empty($arResult["MENU"]))
            $header_class .= " menu-open"; 

        if(!$arResult["SECTION"]["UF_CHAM_SCRL_CNCTS"])
            $header_class .= " scroll-phone-hide"; 

        $header_class .= " ".$arResult["SECTION"]["UF_VIEW_SCRLL_MENU_ENUM"]["XML_ID"];
        $header_class .= " tone-".$arResult["SECTION"]["UF_CHAM_HEADER_CLR_ENUM"]["XML_ID"];
        $header_class .= " header-color-".$arResult["SECTION"]["UF_CH_COLOR_HEADER_ENUM"]["XML_ID"]; 

    ?>   

    <header class="<?=$header_class?>" <?=$header_style?>>
        <?/*if($header_class == "full"):?>
            <div class="shadow"></div>
        <?endif;*/?>
        
        <div class="scroll-wrap">

            <div class="container">
                <div class="row">
    
                    
                    <div class="header-block header-table hidden-xs">

                        <div class="header-cell col-lg-4 col-md-4 col-sm-4 col-xs-0 left">
                            <div class="row">
                                
                                <table class="tbl-lvl-1">
                                    <tr>
                                        <?if(!empty($arResult["MENU"])):?>
                                            <td class="td-lvl-1 ic_menu">
                                                <a class="menu-link primary click-op-menu"><span></span></a>
                                            </td>
                                        <?endif;?>
                                        
                                        
                                        <?if($arResult["SECTION"]["UF_CHAM_LOGOTYPE"] == 0):?>
                                           
                                            <?if($arResult["SECTION"]["PICTURE"] > 0):?>
                                           
                                                <td class="td-lvl-1 logotype">
                                                    <a class="scroll" href="#body">
                                                        <?$img = CFile::ResizeImageGet($arResult["SECTION"]["PICTURE"], array('width'=>900, 'height'=>280), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                                        <img class="img-responsive" src="<?=$img["src"]?>">
                                                        
                                                    </a>
                                                </td>
                                            
                                            <?endif;?>
                                            
                                        <?else:?>
                                            
                                            <?if(strlen($arResult["SECTION"]["UF_CHAM_DESCRIPT"]) > 0):?>
                                                <td class="td-lvl-1 descript">
                                                    <div class="main-desciption <?if($arResult["SECTION"]["UF_CHAM_DESCRIPT_BK"]):?>backdrop<?endif;?>">
                                                        <?=$arResult["SECTION"]["~UF_CHAM_DESCRIPT"]?>
                                                    </div> 
                                                </td>
                                            <?endif;?>
                                            
                                        <?endif;?>
                                    </tr>
                                </table>
                            </div>
                                    
                        </div>

                        <div class="header-cell col-lg-4 col-md-4 col-sm-4 col-xs-0 center">
                            <div class="row">
                                
                                <table class="tbl-lvl-1">
                                    <tr>
                                
                                        <?if($arResult["SECTION"]["UF_CHAM_LOGOTYPE"] == 1):?>
                                    
                                            <?if($arResult["SECTION"]["PICTURE"] > 0):?>
  
                                                <td class="td-lvl-1 logotype">
                                                    <a class="scroll" href="#body">
                                                        
                                                        <?$img = CFile::ResizeImageGet($arResult["SECTION"]["PICTURE"], array('width'=>900, 'height'=>280), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                                        <img src="<?=$img["src"]?>" class="img-responsive" />
                                                    </a>
                                                </td>
        
                                            <?endif;?>
                                            
                                        <?else:?>
                                                
                                            <?if($arResult["SECTION"]["PICTURE"] > 0):?>
                                            <td class="td-lvl-1 logotype">
                                                <a class="scroll" href="#body">
                                                    <?$img = CFile::ResizeImageGet($arResult["SECTION"]["PICTURE"], array('width'=>900, 'height'=>280), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                                    <img class="img-responsive" src="<?=$img["src"]?>">
                                                    
                                                </a>
                                            </td>
                                            <?endif;?>
                                            <?if(strlen($arResult["SECTION"]["UF_CHAM_DESCRIPT"]) > 0):?>
                                                <td class="td-lvl-1 descript">
                                                    <div class="main-desciption <?if($arResult["SECTION"]["UF_CHAM_DESCRIPT_BK"]):?>backdrop<?endif;?>">
                                                        <?=$arResult["SECTION"]["~UF_CHAM_DESCRIPT"]?>
                                                    </div>
                                                </td>
                                            <?endif;?>
        
                                        <?endif;?>

                                    </tr>
                                </table>

                            </div>
                            
                        </div>


                        <div class="header-cell col-lg-4 col-md-4 col-sm-4 col-xs-0 right">
                            <div class="row">
                            
                                <table class="tbl-lvl-1 right-inner">
                                    <tr>
                                        <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) > 0 || strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) > 0 || strlen($arResult["SECTION"]["UF_CHAM_PHONE2"]) > 0 || strlen($arResult["SECTION"]["UF_CHAM_EMAIL2"]) > 0):?>
                                            <td class="td-lvl-1 hidden-xs">
                                                <div class="main-phone">

                                                    <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) > 0):?> 
                                                        <div class="element phone main1"><?=$arResult["SECTION"]["~UF_CHAM_PHONE"]?></div>
                                                    <?endif;?>
                                                        
                                                    <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONECOMM1"]) > 0 && strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) <= 0):?>
                                                        <div class="comment"><?=$arResult["SECTION"]["~UF_CHAM_PHONECOMM1"]?></div>
                                                    <?endif;?>
                                                        
                                                    <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) > 0):?>
                                                        
                                                        <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) <= 0):?> 
                                                            <div class="element email main1">
                                                        <?else:?>
                                                            <div class="comment">
                                                        <?endif;?>
                                                        
                                                        <a class="mail" href="mailto:<?=$arResult["SECTION"]["UF_CHAM_EMAIL"]?>"><?=$arResult["SECTION"]["UF_CHAM_EMAIL"]?></a>
                                                        
                                                        </div>

                                                    <?endif;?>


                                                    <?if($arResult["PHONES_SHOW_DOWN"]):?>

                                                        <div class="ic-open-list-contact open-list-contact"><span></span></div>

                                                        <div class="list-contacts">
                                                            <table>
                                                            
                                                                <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) > 0):?>
                                                                    
                                                                    <tr>
                                                                        <td>
                                                                            <div class="phone bold"><?=$arResult["SECTION"]["~UF_CHAM_PHONE"]?></div>
                                                                            
                                                                            <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONECOMM1"]) > 0 ):?>
                                                                                <div class="desc"><?=$arResult["SECTION"]["~UF_CHAM_PHONECOMM1"]?></div>
                                                                            <?endif;?>
                                                                        </td>
                                                                    </tr>
                                                                
                                                                <?endif;?>
                                                                
                                                                <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE2"]) > 0):?>
                                                                    
                                                                    <tr>
                                                                        <td>
                                                                            <div class="phone bold"><?=$arResult["SECTION"]["~UF_CHAM_PHONE2"]?></div>
                                                                            
                                                                            <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONECOMM2"]) > 0 ):?>
                                                                                <div class="desc"><?=$arResult["SECTION"]["~UF_CHAM_PHONECOMM2"]?></div>
                                                                            <?endif;?>
                                                                        </td>
                                                                    </tr>
                                                                
                                                                <?endif;?>
                                                                
                                                                <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) > 0):?>
                                                                    
                                                                    <tr>
                                                                        <td>
                                                                            
                                                                            <div class="email">
                                                                                <a href="mailto:<?=$arResult["SECTION"]["UF_CHAM_EMAIL"]?>"><span class="bord"><?=$arResult["SECTION"]["UF_CHAM_EMAIL"]?></span></a>
                                                                                </div>
                                                                                                                                                    
                                                                            <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAILCOMM1"]) > 0 ):?>
                                                                                <div class="desc"><?=$arResult["SECTION"]["~UF_CHAM_EMAILCOMM1"]?></div>
                                                                            <?endif;?>
                                                                        </td>
                                                                    </tr>
                                                                
                                                                <?endif;?>
                                                            
                                                                
                                                                <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAIL2"]) > 0):?>
                                                                    
                                                                    <tr>
                                                                        <td>
                                                                            
                                                                            <div class="email">
                                                                                <a href="mailto:<?=$arResult["SECTION"]["UF_CHAM_EMAIL2"]?>"><span class="bord"><?=$arResult["SECTION"]["UF_CHAM_EMAIL2"]?></span></a>
                                                                            </div>
                                                                                                                                                    
                                                                            <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAILCOMM2"]) > 0 ):?>
                                                                                <div class="desc"><?=$arResult["SECTION"]["~UF_CHAM_EMAILCOMM2"]?></div>
                                                                            <?endif;?>
                                                                        </td>
                                                                    </tr>
                                                                
                                                                <?endif;?>
                                                                
                                                                <?if($arResult["SHOW_SOC"] && in_array("header", $arResult["SECTION"]["UF_CHAM_SOC_VIEW_ENUM"])):?>
                                                                    <tr>
                                                                        <td>
                                                                            <?CreateSoc($arResult["SECTION"])?>
                                                                        </td>
                                                                    </tr>
                                                                
                                                                <?endif;?>
                                                                    
                                                            </table>
                                                            
                                                            
                                                        </div>

                                                    <?endif;?>

                                                </div>
                                            </td>
                                        <?endif;?>

                                        <?if($arResult["SECTION"]["UF_CHAM_CALLBACK"]):?>
                                        
                                            <td class="td-lvl-1 hidden-xs">
    
                                                <a class="callback primary <?if(strlen($arResult["SECTION"]["UF_CHAM_CALLBACK_FRM"])>0):?>call-modal callform<?endif;?>" data-call-modal="form<?=$arResult["SECTION"]["UF_CHAM_CALLBACK_FRM"]?>" data-header="<?=GetMessage("FORM_HEADER_CALLBACK")?>"></a>  
                                                
                                            </td>
                                        
                                        <?endif;?>
                                    </tr>
                                </table>
                                
                            </div>
                             
                        </div>


                    </div>


                    <div class="col-xs-12 visible-xs">
                        <div class="header-block-mob-wrap">
                            <?
                                $style = "";
                                if($arResult["SECTION"]["UF_CH_BOX_ON"])
                                    $style .= "cart-on ";
                                
                                if(empty($arResult["MENU"]) || $arResult["SECTION"]["UF_VIEW_SCRLL_MENU_ENUM"]["XML_ID"] == "menu-scroll-none")
                                    $style .= "no-menu ";

                                if(strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) <= 0 && strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) <= 0)
                                    $style .= "no-contacts ";

                                if(!$arResult["SECTION"]["UF_CH_BOX_ON"])
                                    $style .= "no-cart ";
                            ?>
                            <table class="header-block-mob <?=$style?>">
                                <tr>
                                    <?if(!empty($arResult["MENU"])):?>
                                        <td class="mob-callmenu">
                                           <a class="menu-link primary click-op-menu"><span></span></a>
                                        </td>
                                    <?endif;?>

                                    <?if($arResult["SECTION"]["PICTURE"] > 0):?>
                                        <td class="mob-logo">
                                            
                                            <a class="scroll" href="#body">
                                                <?$img = CFile::ResizeImageGet($arResult["SECTION"]["PICTURE"], array('width'=>900, 'height'=>280), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                                <img src="<?=$img["src"]?>" class="img-responsive" />
                                            </a>
                                        
                                        </td>
                                    <?endif;?>

                                    <?if($arResult["SECTION"]["UF_CH_BOX_ON"]):?>
                                        <td class="mob-cart area_for_mini_cart_mob">

                                            <?$APPLICATION->IncludeComponent(
                                                "concept:hameleon_cart",
                                                "mini_cart_mob",
                                                Array(
                                                    "COMPOSITE_FRAME_MODE" => "A",
                                                    "COMPOSITE_FRAME_TYPE" => "AUTO",
                                                    "CURRENT_LAND" => $arResult["SECTION"]["ID"],
                                                    "MESSAGE_404" => "",
                                                    "SET_STATUS_404" => "N",
                                                    "SHOW_404" => "N",
                                                    "LINK_EMPTY_BOX" => $arResult["SECTION"]["UF_LINK_EMPTY_BOX"]
                                                )
                                            );?>
                                        </td>

                                    <?endif;?>

                                    <td class="mob-contacts">

                                        <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) > 0 || strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) > 0):?>
                                            
                                              
                                                <a class="primary" data-button="wind-modal" data-target=".wind-modalphones" data-toggle="modal">
                                                    <span></span>
                                                </a>

                                        <?else:?>

                                            <?if(!$arResult["SECTION"]["UF_CH_BOX_ON"]):?>
                                                <div class="empty-mob-block"></div>
                                            <?endif;?>
                                             
                                            
                                        <?endif;?>

                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="description visible-xs"><?=$arResult["SECTION"]["~UF_CHAM_DESCRIPT"]?></div>          
                       
                </div>
            </div>   

    
            
            <?if(($arResult["SECTION"]["UF_CHAM_MENU_TYPE_ENUM"]["XML_ID"] != "first") && !empty($arResult["MENU"])):?>
            
                
                <?
                if(strlen($arResult["SECTION"]["UF_CHAM_MENU_PLANK"]) > 0)
                {
            
                    $arColor = $arResult["SECTION"]["UF_CHAM_MENU_PLANK"];
            
                    if(preg_match('/^\#/', $arResult["SECTION"]["UF_CHAM_MENU_PLANK"]))
                    {
                        $arColor = hex2rgb($arResult["SECTION"]["UF_CHAM_MENU_PLANK"]);
                        $arColor = implode(',',$arColor);
                    }
            
                    $percent = 1;
            
                    if(strlen($arResult["SECTION"]["UF_CHAM_MENU_PLANK_O"])>0)
                        $percent = (100 - $arResult["SECTION"]["UF_CHAM_MENU_PLANK_O"])/100;
                    
                    $styleBg = 'background-color: rgba('.$arColor.', '.$percent.');';
                    $styleLn = 'border-bottom: 2px solid rgba('.$arColor.', '.$percent.');';
                
                }
                ?>
            

                <div class="menu-type2 hidden-xs <?if($arResult["SECTION"]["UF_CHAM_MENU_TYPE_ENUM"]["XML_ID"] == "third"):?>active<?endif;?> <?if($arResult["SECTION"]["UF_CHAM_MENU_TYPE_ENUM"]["XML_ID"] == "fifth"):?>active ln<?endif;?>" <?if($arResult["SECTION"]["UF_CHAM_MENU_TYPE_ENUM"]["XML_ID"] == "third"):?>style="<?=$styleBg?>"<?endif;?> <?if($arResult["SECTION"]["UF_CHAM_MENU_TYPE_ENUM"]["XML_ID"] == "fifth"):?>style="<?=$styleLn?>"<?endif;?> >
                
                    <div class="container">

                        <div class="menu-type3  <?if($arResult["SECTION"]["UF_CHAM_MENU_TYPE_ENUM"]["XML_ID"] == "second"):?>active<?endif;?> <?if($arResult["SECTION"]["UF_CHAM_MENU_TYPE_ENUM"]["XML_ID"] == "fourth"):?>active ln<?endif;?>">

                            <div class="nav-wrap clearfix <?=$arResult["SECTION"]["UF_CH_COLOR_MENU_ENUM"]["XML_ID"]?>" <?if($arResult["SECTION"]["UF_CHAM_MENU_TYPE_ENUM"]["XML_ID"] == "second"):?> style="<?=$styleBg?>"<?endif;?> <?if($arResult["SECTION"]["UF_CHAM_MENU_TYPE_ENUM"]["XML_ID"] == "fourth"):?>style="<?=$styleLn?>"<?endif;?>>

                                <table class="wrap-main-menu">
                                    <tr>

                                        <td><div class="burger"><a class="click-op-menu"><span></span></a></div></td>

                                        <td>
                                            <ul class="nav main-menu-nav">

                                                <?foreach($arResult["MENU"] as $keys => $arMenu):?>
                                                 

                                                    <li class="lvl1 <?if($arMenu["HIDE_LG"] == "Y") echo 'hidden-lg hidden-md'; if($arMenu["HIDE"] == "Y") echo 'hidden-sm hidden-xs';?>" id="element<?=$arMenu["ID"]?>">
                                                        <?if(strlen($arMenu["MENU_LINK"]) > 0):?>
                                
                                                            <a href="<?=$arMenu["MENU_LINK"]?>" <?if($arMenu["MENU_LINK_OPEN"] == "Y"):?>target="_blank"<?endif;?>><?=$arMenu["NAME"]?></a>
                                                      
                                                        <?else:?>
                                                    
                                                            <a href="#block<?=$arMenu['ID']?>" class="scroll" ><?=$arMenu["NAME"]?></a>
                                                        
                                                        <?endif;?>
                                                    </li>

                                                <?endforeach;?>

                                                
                                            </ul>
                                        </td>
                                    </tr>
                                </table>

                            </div>
       
                        </div>  


                    </div>              
                </div> 

                            

            <?endif;?>

            <?if($arResult["SECTION"]["UF_VIEW_SCRLL_MENU_ENUM"]["XML_ID"] == "menu-scroll-open"):?>

                <div class="container hidden-xs">
                    
                    <div class="menu-slide-wrap">
        
                        <div class="row">

                            <?
                                $cols_logo = "";
                                $cols_menu = "col-lg-10 col-md-10 col-sm-10 col-xs-0";
                                $cols_contacs = "";
                                $cols_callback = "";

                                $arFile = CFile::GetFileArray($arResult["SECTION"]["PICTURE"]);
                                if($arFile)
                                {
                                    $cols_logo = "col-lg-1 col-md-1 col-sm-1 col-xs-1";

                                    if($arFile["WIDTH"] / $arFile["HEIGHT"] > 1.4)
                                    {
                                        $cols_logo = "col-lg-2 col-md-2 col-sm-2 col-xs-0";

                                        if($arResult["SECTION"]["UF_CHAM_CALLBACK"])
                                            $cols_menu = "col-lg-9 col-md-9 col-sm-9 col-xs-0";
                                    }
                                }

                                if($arResult["SECTION"]["UF_CHAM_SCRL_CNCTS"])
                                {
                                    $cols_contacs = "col-lg-4 col-md-4 col-sm-4 col-xs-0";
                                    if($arFile)
                                        $cols_menu = "col-lg-7 col-md-6 col-sm-6 col-xs-0";
                                }
                                

                                if($arResult["SECTION"]["UF_CHAM_CALLBACK"]){
                                    $cols_callback = "col-lg-1 col-md-1 col-sm-1 col-xs-0";
                                    $cols_contacs = "col-lg-2 col-md-3 col-sm-3 col-xs-0";
                                }

                                if(strlen($cols_logo)<=0 && strlen($cols_contacs)<=0 && strlen($cols_callback)<=0)
                                    $cols_menu = "col-lg-12 col-md-12 col-sm-12 col-xs-0";


                            ?>

                            <table class="menu-slide">
                                <tr>
                                    <?if($arResult["SECTION"]["PICTURE"] > 0):?>
                                        <td class="left <?=$cols_logo;?>">
                                            <a class="scroll" href="#body">
                                                <?$img = CFile::ResizeImageGet($arResult["SECTION"]["PICTURE"], array('width'=>400, 'height'=>180), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                            <img class="img-responsive" src="<?=$img["src"]?>">
                                            </a>
                                        </td>
                                    <?endif;?>

                                    <?if(!empty($arResult["MENU"])):?>
                                        <td class="center <?=$cols_menu?>">

                                            <div class="wrapper-main-menu">

                                                <table class="wrap-main-menu">
                                                    <tr>
                                                        
                                                        <td><div class="burger-slide"><a class="menu-link primary click-op-menu"><span></span></a></div></td>
                                                       
                                                        <td>
                                                            <ul class="nav main-menu-nav-slide t-left">
                                                    
                                                                <?foreach($arResult["MENU"] as $keys => $arMenu):?>

                                                                    <li class="lvl1 <?if($arMenu["HIDE_LG"] == "Y") echo 'hidden-lg hidden-md'; if($arMenu["HIDE"] == "Y") echo 'hidden-sm hidden-xs';?>" id="element<?=$arMenu["ID"]?>">
                                                                        <?if(strlen($arMenu["MENU_LINK"]) > 0):?>
                                                
                                                                            <a href="<?=$arMenu["MENU_LINK"]?>" <?if($arMenu["MENU_LINK_OPEN"] == "Y"):?>target="_blank"<?endif;?>><?=$arMenu["NAME"]?></a>
                                                                      
                                                                        <?else:?>
                                                                    
                                                                            <a href="#block<?=$arMenu['ID']?>" class="scroll" ><?=$arMenu["NAME"]?></a>
                                                                        
                                                                        <?endif;?>
                                                                    </li>

                                                                <?endforeach;?>

                                                            </ul>
                                                        </td>
                                                    </tr>
                                                </table>

                                            </div>

                                        </td>
                                    <?endif;?>

                                    <?if($arResult["SECTION"]["UF_CHAM_SCRL_CNCTS"] && (strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) > 0 || strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) > 0 || strlen($arResult["SECTION"]["UF_CHAM_PHONE2"]) > 0 || strlen($arResult["SECTION"]["UF_CHAM_EMAIL2"]) > 0)):?>

                                        <td class="pre-right <?=$cols_contacs?>">
                                            <div class="main-phone">

                                                <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) > 0):?> 
                                                    <div class="element phone main1"><?=$arResult["SECTION"]["~UF_CHAM_PHONE"]?></div>
                                                <?endif;?>
                                                    
                                                <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONECOMM1"]) > 0 && strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) <= 0):?>
                                                    <div class="comment"><?=$arResult["SECTION"]["~UF_CHAM_PHONECOMM1"]?></div>
                                                <?endif;?>
                                                    
                                                <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) > 0):?>
                                                    
                                                    <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) <= 0):?> 
                                                        <div class="element email main1">
                                                    <?else:?>
                                                        <div class="comment">
                                                    <?endif;?>
                                                    
                                                    <a class="mail" href="mailto:<?=$arResult["SECTION"]["UF_CHAM_EMAIL"]?>"><?=$arResult["SECTION"]["UF_CHAM_EMAIL"]?></a>
                                                    
                                                    </div>

                                                <?endif;?>


                                                <?if($arResult["PHONES_SHOW_DOWN"]):?>

                                                    <div class="ic-open-list-contact open-list-contact"><span></span></div>

                                                    <div class="list-contacts">
                                                        <table>
                                                        
                                                            <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) > 0):?>
                                                                
                                                                <tr>
                                                                    <td>
                                                                        <div class="phone bold"><?=$arResult["SECTION"]["~UF_CHAM_PHONE"]?></div>
                                                                        
                                                                        <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONECOMM1"]) > 0 ):?>
                                                                            <div class="desc"><?=$arResult["SECTION"]["~UF_CHAM_PHONECOMM1"]?></div>
                                                                        <?endif;?>
                                                                    </td>
                                                                </tr>
                                                            
                                                            <?endif;?>
                                                            
                                                            <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE2"]) > 0):?>
                                                                
                                                                <tr>
                                                                    <td>
                                                                        <div class="phone bold"><?=$arResult["SECTION"]["~UF_CHAM_PHONE2"]?></div>
                                                                        
                                                                        <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONECOMM2"]) > 0 ):?>
                                                                            <div class="desc"><?=$arResult["SECTION"]["~UF_CHAM_PHONECOMM2"]?></div>
                                                                        <?endif;?>
                                                                    </td>
                                                                </tr>
                                                            
                                                            <?endif;?>
                                                            
                                                            <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) > 0):?>
                                                                
                                                                <tr>
                                                                    <td>
                                                                        
                                                                        <div class="email">
                                                                            <a href="mailto:<?=$arResult["SECTION"]["UF_CHAM_EMAIL"]?>"><?=$arResult["SECTION"]["UF_CHAM_EMAIL"]?></a>
                                                                            </div>
                                                                                                                                                
                                                                        <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAILCOMM1"]) > 0 ):?>
                                                                            <div class="desc"><?=$arResult["SECTION"]["~UF_CHAM_EMAILCOMM1"]?></div>
                                                                        <?endif;?>
                                                                    </td>
                                                                </tr>
                                                            
                                                            <?endif;?>
                                                        
                                                            
                                                            <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAIL2"]) > 0):?>
                                                                
                                                                <tr>
                                                                    <td>
                                                                        
                                                                        <div class="email">
                                                                            <a href="mailto:<?=$arResult["SECTION"]["UF_CHAM_EMAIL2"]?>"><?=$arResult["SECTION"]["UF_CHAM_EMAIL2"]?></a>
                                                                        </div>
                                                                                                                                                
                                                                        <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAILCOMM2"]) > 0 ):?>
                                                                            <div class="desc"><?=$arResult["SECTION"]["~UF_CHAM_EMAILCOMM2"]?></div>
                                                                        <?endif;?>
                                                                    </td>
                                                                </tr>
                                                            
                                                            <?endif;?>
                                                            
                                                            <?if($arResult["SHOW_SOC"] && in_array("header", $arResult["SECTION"]["UF_CHAM_SOC_VIEW_ENUM"])):?>
                                                                <tr>
                                                                    <td>
                                                                        <?CreateSoc($arResult["SECTION"])?>
                                                                    </td>
                                                                </tr>
                                                            
                                                            <?endif;?>
                                                                
                                                        </table>
                                                        
                                                        
                                                    </div>

                                                <?endif;?>

                                            </div>
                                        </td>

                                    <?endif;?>

                                    <?if($arResult["SECTION"]["UF_CHAM_CALLBACK"]):?>
                                    
                                        <td class="right <?=$cols_callback?>">
                                            <a class="callback primary <?if(strlen($arResult["SECTION"]["UF_CHAM_CALLBACK_FRM"])>0):?>call-modal callform<?endif;?>" data-call-modal="form<?=$arResult["SECTION"]["UF_CHAM_CALLBACK_FRM"]?>" data-header="<?=GetMessage("FORM_HEADER_CALLBACK")?>"></a>    
                                        </td>
                                    
                                    <?endif;?>
                                    
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>

            <?endif;?>
                 
                
        </div>
  
    </header>
    
    
    
    <?if(!empty($arResult["ITEMS"])):?>
    
        <?foreach($arResult["ITEMS"] as $key=>$arItem):?>
        
            <?global $USER;?>
            
            <?if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "first_block"):?>
            
                <?CreateFirstSlider($arItem);?>
                
            <?else:?>
    
                 <?CreateElement($arItem, $arResult["SECTION"], $key);?>
            
            <?endif;?>
        
        <?endforeach;?>
    
    <?else:?>
        
        <?CreateEmptyBlock($arResult["SECTION"]);?>
        
    <?endif;?>    

    <?if(!$arResult["SECTION"]["UF_CHAM_FOOTER_HIDE"]):?>

        <?$footer_style = "";?>
        <?if(strlen($arResult["SECTION"]["UF_CH_FOOTER_BG_CLR"]) > 0 || $arResult["SECTION"]["UF_CH_FTR_BG"] > 0):?>
                    
            <?if(strlen($arResult["SECTION"]["UF_CH_FOOTER_BG_CLR"]) > 0):?>
            
                <?
                    $arColor = $arResult["SECTION"]["UF_CH_FOOTER_BG_CLR"];
            
                    if(preg_match('/^\#/', $arResult["SECTION"]["UF_CH_FOOTER_BG_CLR"]))
                    {
                        $arColor = hex2rgb($arResult["SECTION"]["UF_CH_FOOTER_BG_CLR"]);
                        $arColor = implode(',',$arColor);

                        $footer_style .= " background-color: rgb(".$arColor.");";
                    }

                    else
                        $footer_style .= " background-color: ".$arColor.";";
            
                    $percent = 1;
            
                    if(strlen($arResult["SECTION"]["UF_CH_FTR_CLR_OPACTY"])>0)
                        $percent = (100 - $arResult["SECTION"]["UF_CH_FTR_CLR_OPACTY"])/100;
                    
                    

                    $footer_style .= " opacity: ".$percent.";";

                ?>
            
            <?endif;?>
            
            <?if(strlen($arResult["SECTION"]["UF_CH_FTR_BG"]) > 0):?>
                <?$footer_style .= " background-image: url('".CFile::getPath($arResult["SECTION"]["UF_CH_FTR_BG"])."'); background-position: top center; background-repeat: no-repeat;"?>
            <?endif;?>
            
        <?endif;?>

        <footer class="tone-<?=$arResult["SECTION"]["UF_CHAM_HEADER_CLR_ENUM"]["XML_ID"]?> <?if(strlen($footer_style)<=0):?>def-bg<?endif;?>">

        	<div class="bg-footer" <?if(strlen($footer_style)>0):?> style="<?=$footer_style?>"<?endif;?>></div>

            <div class="container">
               
                <div class="footer-content-wrap no-margin-top-bot">
                    
                    <?if($arResult["SECTION"]["PICTURE"] > 0):?>
                    
                        <div class="logotype">
                            <?$img = CFile::ResizeImageGet($arResult["SECTION"]["PICTURE"], array('width'=>900, 'height'=>280), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                            <img class="img-responsive center-block" src="<?=$img["src"]?>">
                        </div>
                    
                    <?endif;?>
                    
                    <?if(strlen($arResult["SECTION"]["UF_CHAM_DESCRIPT"]) > 0):?>
                        <div class="descript"><?=$arResult["SECTION"]["~UF_CHAM_DESCRIPT"]?></div>
                    <?endif;?>
                    
                    <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) > 0 || strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) > 0 || strlen($arResult["SECTION"]["UF_CHAM_CALL_TRACK"])>0 || ($arResult["SHOW_SOC"] && in_array("footer", $arResult["SECTION"]["UF_CHAM_SOC_VIEW_ENUM"]))):?>
                    
                        <div class="contacts-table-wrap">
                            <div class="contacts-table">
                                
                                <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) > 0 || strlen($arResult["SECTION"]["UF_CHAM_CALL_TRACK"])>0):?>
                                    <div class="contacts-cell number main1">
                                        <?=$arResult["SECTION"]["~UF_CHAM_PHONE"]?></a> 
                                    </div>
                                <?endif;?>

                                <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) > 0):?>  
                                    <div class="contacts-cell email">
                                        <a href="mailto:<?=$arResult["SECTION"]["UF_CHAM_EMAIL"]?>"><?=$arResult["SECTION"]["UF_CHAM_EMAIL"]?></a>
                                    </div>
                                <?endif;?>
                                
                                <?if($arResult["SHOW_SOC"] && in_array("footer", $arResult["SECTION"]["UF_CHAM_SOC_VIEW_ENUM"])):?>
                                    <div class="contacts-cell socials">
                                        <?CreateSoc($arResult["SECTION"]);?>
                                    </div>
                                <?endif;?>
                                
                            </div>
                        </div>
                    
                    <?endif;?>
                    
                    <?if(strlen($arResult["SECTION"]["UF_CHAM_FOOTER"]) > 0):?>  
                        <div class="info"><?=$arResult["SECTION"]["~UF_CHAM_FOOTER"]?></div>
                    <?endif;?>

                    <?if(!empty($arResult["SECTION"]["AGREEMENTS"])):?>

                        <?$count = count($arResult["SECTION"]["AGREEMENTS"]);?>

                        <div class="wrap-agree">

                            <ul class="wrap-agree <?if($count == 1):?>alone<?endif;?>">
                            
                            <?foreach($arResult["SECTION"]["AGREEMENTS"] as $arAgreement):?>
                            
                                <?
                                $name = $arAgreement['~NAME'];
                                
                                if(strlen($arAgreement["PROPERTIES"]["IM_TEXT"]["VALUE"]) > 0)
                                    $name = $arAgreement["PROPERTIES"]["IM_TEXT"]["~VALUE"];
                                ?>
                            
                                <li><a class="call-modal callagreement" data-call-modal="agreement<?=$arAgreement["ID"]?>"><?=$name?></a></li>


                            <?endforeach;?>

                            </ul>

                        </div>

                    <?endif;?>
        
                    <?if(!$arResult["SECTION"]["UF_CHAM_COPYRIGHT"]):?>
              
                        <div class="copyright">

                            <?if($arResult["SECTION"]["UF_CHAM_CHOOSECOPY_ENUM"]["XML_ID"] == "cham" || $arResult["SECTION"]["UF_CHAM_CHOOSECOPY"] == "") :?>  
                                <a class="hameleon" target="_blank" href="http://marketplace.1c-bitrix.ru/solutions/concept.hameleon/"></a>
                            <?endif;?>

                            <?if((strlen($arResult["SECTION"]["UF_CHAM_COPYPICTURE"]) > 0 || strlen($arResult["SECTION"]["UF_CHAM_LINK_TEXT"]) > 0) && ($arResult["SECTION"]["UF_CHAM_CHOOSECOPY_ENUM"]["XML_ID"] == "user")):?> 
                                <?$img_img = CFile::ResizeImageGet($arResult["SECTION"]["UF_CHAM_COPYPICTURE"], array('width'=>150, 'height'=>20), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                
                                <a class="users_copyright no-margin-left-right" <?if(strlen($arResult["SECTION"]["UF_CHAM_LINK"]) > 0):?> target="_blank" href="<?=$arResult["SECTION"]["UF_CHAM_LINK"]?>"<?endif;?>>
                                    <?if(strlen($arResult["SECTION"]["UF_CHAM_LINK_TEXT"]) > 0):?>
                                    <span><?=$arResult["SECTION"]["~UF_CHAM_LINK_TEXT"]?></span>
                                    <?endif;?>

                                    <img alt="" class="img-responsive center-block" src="<?=$img_img["src"]?>">
                                </a>

                            <?endif;?> 



                        </div>

                    <?endif;?>

                </div>
            </div>

            
            <?if(strlen($arResult["SECTION"]["UF_CHAM_FOOTER_REQS"]) > 0):?>
                
                <div class="footer-reqs">
                    
                    <div class="container">
                        <?=$arResult["SECTION"]["~UF_CHAM_FOOTER_REQS"]?>
                    </div>
                    
                </div>
            
            <?endif;?>
            
        </footer>
    <?endif;?>

    <a href="#body" class="up scroll"></a>

    <?if($arResult["SECTION"]["UF_CHAM_SHARE"]!=0):?>
        
        <div class="public_shares hidden-xs">
        
            <a class='vkontakte' onclick="Share.vkontakte('<?=$arResult["SEO"]["seo_url"]?>','<?=$arResult["SEO"]["seo_title"]?>','<?=$arResult["SEO"]["seo_img"]?>','<?=$arResult["SEO"]["seo_desc"]?>')"><i class="concept-vkontakte"></i><span><?=GetMessage("PUBLIC_SHARES_DESC")?></span></a>
            
            <a class='facebook' onclick="Share.facebook('<?=$arResult["SEO"]["seo_url"]?>','<?=$arResult["SEO"]["seo_title"]?>','<?=$arResult["SEO"]["seo_img"]?>','<?=$arResult["SEO"]["seo_desc"]?>')"><i class="concept-facebook-1"></i><span><?=GetMessage("PUBLIC_SHARES_DESC")?></span></a>
            
            <a class='twitter' onclick="Share.twitter('<?=$arResult["SEO"]["seo_url"]?>','<?=$arResult["SEO"]["seo_title"]?>')"><i class="concept-twitter-bird-1"></i><span><?=GetMessage("PUBLIC_SHARES_DESC")?></span></a>
            
        </div>
        
    <?endif;?>

    <?if($arResult["SECTION"]["UF_CALL_PHONE_ON"]):?>
        <div class="callphone-wrap">
            <?if(strlen($arResult["SECTION"]["UF_CALL_PHN_MOB_DESC"])>0):?>
                <span class="callphone-desc"><?=$arResult["SECTION"]["UF_CALL_PHN_MOB_DESC"]?></span>
            <?endif;?>
            <a class='callphone mainColor' href='tel:<?=$arResult["SECTION"]["UF_CALL_PHONE_MOB"]?>'></a>
        </div>
    <?endif;?>

</div> 
<!-- /wrapper -->

<div class="no-click-block"></div>

<div class="wrap-modal">

    <div class="scroll-close">
        <div class="container row">
            <a class="wrap-modal-close"></a>
        </div>
    </div>

    <div class="modal-container"></div> 


</div>

<?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) > 0 || strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) > 0):?>
    
    <div class="modal fade wind-modal wind-modalphones" >

           <div class="click-for-reset"></div>
           
            <div class="modal-dialog">
                <a aria-hidden="true" class="form-close" data-dismiss="modal" type="button"></a>

                <div class="wind-content">
                    
                    <div class="list-contacts-modal">
                        <table>
                        
                            <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) > 0):?>
                                
                                <tr>
                                    <td>
                                        <div class="phone bold"><?=$arResult["SECTION"]["~UF_CHAM_PHONE"]?></div>
                                        
                                        <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONECOMM1"]) > 0 ):?>
                                            <div class="desc"><?=$arResult["SECTION"]["~UF_CHAM_PHONECOMM1"]?></div>
                                        <?endif;?>
                                    </td>
                                </tr>
                            
                            <?endif;?>
                            
                            <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE2"]) > 0):?>
                                
                                <tr>
                                    <td>
                                        <div class="phone bold"><?=$arResult["SECTION"]["~UF_CHAM_PHONE2"]?></div>
                                        
                                        <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONECOMM2"]) > 0 ):?>
                                            <div class="desc"><?=$arResult["SECTION"]["~UF_CHAM_PHONECOMM2"]?></div>
                                        <?endif;?>
                                    </td>
                                </tr>
                            
                            <?endif;?>
                            
                            <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) > 0):?>
                                
                                <tr>
                                    <td>
                                        
                                        <div class="email">
                                            <a href="mailto:<?=$arResult["SECTION"]["UF_CHAM_EMAIL"]?>"><?=$arResult["SECTION"]["UF_CHAM_EMAIL"]?></a>
                                            </div>
                                                                                                                
                                        <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAILCOMM1"]) > 0 ):?>
                                            <div class="desc"><?=$arResult["SECTION"]["~UF_CHAM_EMAILCOMM1"]?></div>
                                        <?endif;?>
                                    </td>
                                </tr>
                            
                            <?endif;?>
                        
                            
                            <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAIL2"]) > 0):?>
                                
                                <tr>
                                    <td>
                                        
                                        <div class="email">
                                            <a href="mailto:<?=$arResult["SECTION"]["UF_CHAM_EMAIL2"]?>"><?=$arResult["SECTION"]["UF_CHAM_EMAIL2"]?></a>
                                        </div>
                                                                                                                
                                        <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAILCOMM2"]) > 0 ):?>
                                            <div class="desc"><?=$arResult["SECTION"]["~UF_CHAM_EMAILCOMM2"]?></div>
                                        <?endif;?>
                                    </td>
                                </tr>
                            
                            <?endif;?>
                            
                             <?if($arResult["SHOW_SOC"] && in_array("header", $arResult["SECTION"]["UF_CHAM_SOC_VIEW_ENUM"])):?>
                                <tr>
                                    <td>
                                        <?CreateSoc($arResult["SECTION"])?>
                                    </td>
                                </tr>
                            
                            <?endif;?>
                            
          
                                
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>

<?endif;?>

<div class="shadow-agree"></div>
<div class="xLoader"><div class="google-spin-wrapper"><div class="google-spin"></div></div></div>

<?

    $arMask["rus"] = "+7 (999) 999-99-99";
    $arMask["ukr"] = "+380 (99) 999-99-99";
    $arMask["blr"] = "+375 (99) 999-99-99";
    $arMask["kz"] = "+7 (999) 999-99-99";
    $arMask["user"] = $arResult["SECTION"]["UF_CH_USER_MASK"];
?>

<script type="text/javascript">
    /*mask phone*/
    $(document).on("focus", "form input.phone", 
        function()
        { 
            if(!device.android())
                $(this).mask("<?=$arMask[$arResult["SECTION"]["UF_CH_MASK_ENUM"]["XML_ID"]]?>");
        }
    );
</script>

<?$this->__component->arResult["CACHED_TPL"] = @ob_get_contents();
  ob_get_clean();?>
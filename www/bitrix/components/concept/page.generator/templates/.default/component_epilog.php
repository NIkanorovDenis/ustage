<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?use \Bitrix\Main\Page\Asset as Asset;?>
<?global $APPLICATION;?>
<?

$cur_color = $arResult["SECTION"]["UF_CH_USER_M_COLOR"];

if(strlen($cur_color) <= 0)
{
    $srd_main_color = array(
        "light-blue" => "#2285c4",
        "yellow" => "#e59a05",
        "orange" => "#e5420b",
        "light-green" => "#66b132",
        "dark-green" => "#358a69",
        "purple" => "#da0b76",
        "pink" => "#ff00ae",
        "dark-blue" => "#193cec",
        "brown" => "#936200",
        "red" => "#8d0909",
        "green" => "#3d860b",
        "light-dark-green" => "#08d585",
        "dark-gray" => "#494949",
        "violet" => "#b71cea"
    );

    $cur_color = "#2285c4";

    if(strlen($arResult["SECTION"]["UF_CHAM_MAIN_COLOR"]) > 0)
    {
        $color = CUserFieldEnum::GetList(array(), array(
        "ID" => $arResult["SECTION"]["UF_CHAM_MAIN_COLOR"],
        ));

        $cur_color = $color->GetNext();

        $cur_color = $srd_main_color[$cur_color["XML_ID"]];
    }
}

$cur_color = str_replace("#", "", $cur_color);


?>

<?/*Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/colors/".$arResult["SECTION"]["UF_CHAM_MAIN_COLOR_VAL"]["XML_ID"].".css", true);*/?>

<?
    $file_less = $_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/concept_hameleon/css/main_color.less";

    $dir = "/bitrix/templates/concept_hameleon/css/generate_colors/land_".$arResult["SECTION"]["ID"]."/";

    $dir_abs = $_SERVER["DOCUMENT_ROOT"].$dir;

    $newfile_css = $_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/concept_hameleon/css/generate_colors/land_".$arResult["SECTION"]["ID"]."/main_color_".$cur_color.".css";

    $flag = false;



    if(!file_exists($newfile_css))
    {
        DeleteDirFilesEx($dir);
        $flag = true;
    }


    if($flag)
    {
        CheckDirPath($dir_abs);

        require ($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/concept_hameleon/lessc.inc.php");

        $less = new lessc;
        $less->setVariables(array(
            "color" => "#".$cur_color
        ));

        $less->compileFile($file_less, $newfile_css);

    }
    

?>

<?Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/generate_colors/land_".$arResult["SECTION"]["ID"]."/main_color_".$cur_color.".css", true);?>
<?

$arResult["SECTION"]["UF_CHAM_TITLE_FONT_VAL"]["XML_ID"] = "lato";

if(strlen($arResult["SECTION"]["UF_CHAM_TITLE_FONT"]) > 0)
{
    $font1 = CUserFieldEnum::GetList(array(), array(
        "ID" => $arResult["SECTION"]["UF_CHAM_TITLE_FONT"],
    ));
    $arResult["SECTION"]["UF_CHAM_TITLE_FONT_VAL"] = $font1->GetNext();

}


$arResult["SECTION"]["UF_CHAM_TEXT_FONT_VAL"]["XML_ID"] = "lato";
   
if(strlen($arResult["SECTION"]["UF_CHAM_TEXT_FONT"]) > 0)
{
    $font2 = CUserFieldEnum::GetList(array(), array(
        "ID" => $arResult["SECTION"]["UF_CHAM_TEXT_FONT"],
    ));
    $arResult["SECTION"]["UF_CHAM_TEXT_FONT_VAL"] = $font2->GetNext();

}


//standart fonts
$arStandart = array();

$arStandart[] = "arial";


//include
$arInclude = Array();

$arInclude[] = "lato";
$arInclude[] = "helvetica";
$arInclude[] = "segoeUI";


//Google fonts
$arGoogle = Array();

$arGoogle["elmessiri"] = "El+Messiri:400,700";
$arGoogle["exo2"] = "Exo+2:400,700";
$arGoogle["ptserif"] = "PT+Serif:400,700";
$arGoogle["roboto"] = "Roboto:300,400,700";
$arGoogle["yanonekaffeesatz"] = "Yanone+Kaffeesatz:400,700";
$arGoogle["firasans"] = "Fira+Sans+Condensed:300,700";
$arGoogle["arimo"] = "Arimo:400,700";
$arGoogle["opensans"] = "Open+Sans:400,700";


if(in_array($arResult["SECTION"]["UF_CHAM_TITLE_FONT_VAL"]["XML_ID"], $arInclude))
{
    $font[$arResult["SECTION"]["UF_CHAM_TITLE_FONT_VAL"]["XML_ID"]] = true;
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/fonts/".$arResult["SECTION"]["UF_CHAM_TITLE_FONT_VAL"]["XML_ID"].".css", true);
}
elseif(!in_array($arResult["SECTION"]["UF_CHAM_TITLE_FONT_VAL"]["XML_ID"], $arStandart) && !in_array($arResult["SECTION"]["UF_CHAM_TITLE_FONT_VAL"]["XML_ID"], $arInclude))
{
    $font[$arResult["SECTION"]["UF_CHAM_TITLE_FONT_VAL"]["XML_ID"]] = true;
    Asset::getInstance()->addCss("https://fonts.googleapis.com/css?family=".$arGoogle[$arResult["SECTION"]["UF_CHAM_TITLE_FONT_VAL"]["XML_ID"]]."&amp;subset=cyrillic", true);
}

if(in_array($arResult["SECTION"]["UF_CHAM_TEXT_FONT_VAL"]["XML_ID"], $arInclude) && !$font[$arResult["SECTION"]["UF_CHAM_TEXT_FONT_VAL"]["XML_ID"]])
{
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/fonts/".$arResult["SECTION"]["UF_CHAM_TEXT_FONT_VAL"]["XML_ID"].".css", true);
}
elseif(!in_array($arResult["SECTION"]["UF_CHAM_TEXT_FONT_VAL"]["XML_ID"], $arStandart) && !in_array($arResult["SECTION"]["UF_CHAM_TEXT_FONT_VAL"]["XML_ID"], $arInclude) && !$font[$arResult["SECTION"]["UF_CHAM_TEXT_FONT_VAL"]["XML_ID"]])
{
    Asset::getInstance()->addCss("https://fonts.googleapis.com/css?family=".$arGoogle[$arResult["SECTION"]["UF_CHAM_TEXT_FONT_VAL"]["XML_ID"]]."&amp;subset=cyrillic", true);
}

Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/fonts/title/".$arResult["SECTION"]["UF_CHAM_TITLE_FONT_VAL"]["XML_ID"].".css", true);
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/fonts/text/".$arResult["SECTION"]["UF_CHAM_TEXT_FONT_VAL"]["XML_ID"].".css", true);


?>



<?
if($arResult["SECTION"]["UF_CHAM_NOINDEX"] == 1)
{
    $APPLICATION->AddHeadString('<meta name="robots" content="noindex, nofollow" />');
}

if($arResult["SECTION"]["DETAIL_PICTURE"] > 0)
{
    $file = CFile::ResizeImageGet($arResult["SECTION"]["DETAIL_PICTURE"], array('width'=>180, 'height'=>180), BX_RESIZE_IMAGE_EXACT, false);                       
    $APPLICATION->AddHeadString('<link rel="icon" href="'.$file["src"].'" type="image/x-icon">', false, true);
    $APPLICATION->AddHeadString('<link rel="shortcut icon" href="'.$file["src"].'" type="image/x-icon">', false, true);
}
else
{
    $APPLICATION->AddHeadString('<link rel="shortcut icon" href="'.SITE_TEMPLATE_PATH.'/favicon.png" type="image/png">');
}

if(!empty($arResult["SECTION"]["UF_CHAM_META_TAGS"]))
{
    foreach($arResult["SECTION"]["~UF_CHAM_META_TAGS"] as $string)
        $APPLICATION->AddHeadString($string, false, true);

}

//og tags

$string = '<meta property="og:url" content= "'.$arResult["SEO"]["seo_url"].'" />';
$APPLICATION->AddHeadString($string, false, true);

$string = '<meta property="og:type" content= "'.$arResult["SEO"]["seo_type"].'" />';
$APPLICATION->AddHeadString($string, false, true);
  
$string = '<meta property="og:title" content= "'.$arResult["SEO"]["seo_title"].'" />';
$APPLICATION->AddHeadString($string, false, true);
   
$string = '<meta property="og:description" content= "'.$arResult["SEO"]["seo_desc"].'" />';
$APPLICATION->AddHeadString($string, false, true);

$string = '<meta property="og:image" content= "'.$arResult["SEO"]["seo_img"].'" />';
$APPLICATION->AddHeadString($string, false, true);





if(strlen($arResult["SECTION"]["UF_CHAM_METRIKA"]) > 0)
{
    
$string = '<!-- Yandex.Metrika counter -->
<script type="text/javascript" data-skip-moving="true">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter'.$arResult["SECTION"]["UF_CHAM_METRIKA"].' = new Ya.Metrika({id:'.$arResult["SECTION"]["UF_CHAM_METRIKA"].',
                    webvisor:true,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/'.$arResult["SECTION"]["UF_CHAM_METRIKA"].'" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter --> ';

    $APPLICATION->AddHeadString($string, false, true);

}

if(strlen($arResult["SECTION"]["UF_CHAM_GOOGLE"]) > 0)
{
    
$string = "
<script data-skip-moving='true'>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '".$arResult["SECTION"]["UF_CHAM_GOOGLE"]."', 'auto');
  ga('send', 'pageview');

</script> 
";

    $APPLICATION->AddHeadString($string, false, true);

}

if(strlen($arResult["SECTION"]["UF_CHAM_GTM"]) > 0)
{

$string = "
<!-- Google Tag Manager -->
<script data-skip-moving='true'>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','".$arResult["SECTION"]["UF_CHAM_GTM"]."');</script>
<!-- End Google Tag Manager -->
";

    $APPLICATION->AddHeadString($string, false, true);

}


if(strlen($arResult["SECTION"]["~UF_CHAM_SERVICES"]) > 0)
{
    $APPLICATION->AddHeadString($arResult["SECTION"]["~UF_CHAM_SERVICES"], false, true);
}

?>

<?/*if($arResult["VIDEO_API"] > 0):?>

    <script type="text/javascript">
        var tag = document.createElement('script');
        tag.src = "<?=SITE_TEMPLATE_PATH?>/js/video.js";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    </script>

<?endif;*/?>

<?
$GLOBALS["h1_main"] = $arResult["H1_MAIN"];
?>

<?$temp = $arResult["CACHED_TPL"]?>

<?if(!empty($arResult["COMPONENTS"])):?>

    <?foreach($arResult["COMPONENTS"] as $key=>$arItem):?>
        
        <?$path = $arItem["PROPERTIES"]["COMPONENT_PATH"]["VALUE"];?>

        <?$temp = preg_replace_callback(
                    "/#DYNAMIC".$key."#/is".BX_UTF_PCRE_MODIFIER,
                    create_function('$matches', 'ob_start();
                    $GLOBALS["APPLICATION"]->IncludeFile("'.$path.'", array(),
                        array(
                            "MODE"  => "php",
                        )
                    );
                    $retrunStr = @ob_get_contents();
                    ob_get_clean();
                    return $retrunStr;'),
                    $temp);
        ?>

    <?endforeach;?>

<?endif;?>

<?=$temp;?>



<?if($USER->isAdmin() && !empty($arResult["ERRORS"])):?>

    <div class="alert-block hidden-sm hidden-xs">
        
        <div class="hameleon-alert-btn mgo-widget-alert_pulse"></div>
        
        <div class="alert-block-content">
            
            <div class="alert-head">
                <?=GetMessage("HAMELEON_ALERT_HEAD")?>
                
                <a class="alert-close"></a>
            </div>
            
            <div class="alert-body">
                
                <?if($arResult["ERRORS"]["CALLBACK"] == "Y"):?>
                    
                    <div class="cont">
                        
                        <div class="big-name"><?=GetMessage("HAMELEON_ALERT_CALLBACK_TITLE")?></div>
                        
                        <div class="instr">
                            
                            <div class="instr-element">
                                
                                <div class="text">1. <a href="/bitrix/admin/iblock_list_admin.php?IBLOCK_ID=<?=$arResult["FORMS_ELEMENTS_IBLOCK_ID"]?>&type=concept_hameleon&lang=ru&find_section_section=0" target="_blank"><?=GetMessage("HAMELEON_ALERT_CALLBACK_TEXT_1")?></a></div>
                                
                            </div>
                            
                            <div class="instr-element">
                                
                                <div class="text">2. <a class="hameleon-sets-open" data-open-set="edit-sets"><?=GetMessage("HAMELEON_ALERT_CALLBACK_TEXT_2")?></a></div>
                                <div class="comment"><?=GetMessage("HAMELEON_ALERT_CALLBACK_COMMENT_2")?></div>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                <?endif;?>
                
                <?if($arResult["ERRORS"]["CATALOG_FORM"] == "Y"):?>
                    
                    <div class="cont">
                        
                        <div class="big-name"><?=GetMessage("HAMELEON_ALERT_CATALOG_FORM_TITLE")?></div>
                        
                        <div class="instr">
                            
                            <div class="instr-element">
                                
                                <div class="text">1. <a href="/bitrix/admin/iblock_list_admin.php?IBLOCK_ID=<?=$arResult["FORMS_ELEMENTS_IBLOCK_ID"]?>&type=concept_hameleon&lang=ru&find_section_section=0" target="_blank"><?=GetMessage("HAMELEON_ALERT_CATALOG_FORM_TEXT_1")?></a></div>
                                
                            </div>
                            
                            <div class="instr-element">
                                
                                <div class="text">2. <a class="hameleon-sets-open" data-open-set="edit-sets"><?=GetMessage("HAMELEON_ALERT_CATALOG_FORM_TEXT_2")?></a></div>
                                <div class="comment"><?=GetMessage("HAMELEON_ALERT_CATALOG_FORM_COMMENT_2")?></div>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                <?endif;?>
                
                <?if($arResult["ERRORS"]["CATALOG_CART_FORM"] == "Y"):?>
                    
                    <div class="cont">
                        
                        <div class="big-name"><?=GetMessage("HAMELEON_ALERT_CATALOG_CART_FORM_TITLE")?></div>
                        
                        <div class="instr">
                            
                            <div class="instr-element">
                                
                                <div class="text">1. <a href="/bitrix/admin/iblock_list_admin.php?IBLOCK_ID=<?=$arResult["FORMS_ELEMENTS_IBLOCK_ID"]?>&type=concept_hameleon&lang=ru&find_section_section=0" target="_blank"><?=GetMessage("HAMELEON_ALERT_CATALOG_CART_FORM_TEXT_1")?></a></div>
                                
                            </div>
                            
                            <div class="instr-element">
                                
                                <div class="text">2. <a class="hameleon-sets-open" data-open-set="edit-sets"><?=GetMessage("HAMELEON_ALERT_CATALOG_CART_FORM_TEXT_2")?></a></div>
                                <div class="comment"><?=GetMessage("HAMELEON_ALERT_CATALOG_CART_FORM_COMMENT_2")?></div>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                <?endif;?>
                
            </div>
            
        </div>
        
    </div>

<?endif;?>



<?

$frame = new \Bitrix\Main\Page\FrameHelper("my_dynamic_area");
$frame->begin();

if($arResult["SECTION"]["UF_CH_BOX_ON"])
{

    ?>



    <?/*<div class="area_for_box">
        <?$APPLICATION->IncludeComponent(
            "concept:ham_box",
            "",
            Array(
                "COMPOSITE_FRAME_MODE" => "A",
                "COMPOSITE_FRAME_TYPE" => "AUTO",
                "CURRENT_LAND" => $arResult["SECTION"]["ID"],
                "MESSAGE_404" => "",
                "SET_STATUS_404" => "N",
                "SHOW_404" => "N"
            )
        );?>
    </div>
    */?>

    <div class="wrapper-mbox">

        <input class="link_empty_box" type="hidden" value="<?=$arResult["SECTION"]["UF_LINK_EMPTY_BOX"]?>">
        
        <div class="area_for_mini_cart hidden-xs">

            <?$APPLICATION->IncludeComponent(
                "concept:hameleon_cart",
                "mini_cart",
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
            
        </div>


        <?
            if(strlen($arResult["SECTION"]["UF_CH_BOX_BG_HEAD"]) > 0)
                $bg = CFile::ResizeImageGet($arResult["SECTION"]["UF_CH_BOX_BG_HEAD"], array('width'=>1600, 'height'=>500), BX_RESIZE_IMAGE_PROPORTIONAL, false, false, false, 85);
        ?>


        <div class="m-box-outer box-parent col-lg-10 col-md-12 col-sm-12 col-xs-12">
            <form action="/" class="form-box form send" method="post" role="form">
                <div class="m-box-inner row">

                    <div class="head box-head-height"<?if($arResult["SECTION"]["UF_CH_BOX_BG_HEAD"]>0):?> style="background-image: url(<?=$bg["src"]?>);"<?endif;?>>
                        <div class="inbox-shadow"></div>

                        <table>
                            <tbody>
                                <tr>
                                    <td class="col-lg-2 col-md-2 col-sm-3 col-xs-0 hidden-xs box-image"><div></div></td>
                                    <td class="col-lg-8 col-md-8 col-sm-6 col-xs-9 title"><?=$arResult["SECTION"]["~UF_CH_BOX_TITLE"]?></td>
                                    <td class="col-lg-2 col-md-2 col-sm-3 col-xs-3"></td>
                                </tr>
                            </tbody>
                        </table>

                        <a class="cancel-box box-close"></a>


                    </div>

                    <div class="body box-body-height">

                        <table class="main-table mobile-break pad-break">
                            <tbody>
                                <tr>
                                    <td class="left-p col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                        <div class="product-area">
                                            <div class="area_for_products">

                                                <?$APPLICATION->IncludeComponent(
                                                    "concept:hameleon_cart",
                                                    "products",
                                                    Array(
                                                        "COMPOSITE_FRAME_MODE" => "A",
                                                        "COMPOSITE_FRAME_TYPE" => "AUTO",
                                                        "CURRENT_LAND" => $arResult["SECTION"]["ID"],
                                                        "MESSAGE_404" => "",
                                                        "SET_STATUS_404" => "N",
                                                        "SHOW_404" => "N"
                                                    )
                                                );?>
                                            </div>

                                        </div>

                                        <div class="wrap-adv-table">

                                            <div class="row">

                                                <?$total_count = count($arResult["CH_BOX_ADV"]);?>

                                                <?foreach($arResult["CH_BOX_ADV"] as $key=>$arAdv):?>
                        
                                                    <?                                                
                                                        $row = 3;
                                                        $class = "col-lg-4 col-md-4 col-sm-4 col-xs-12";
                                                        
                                                        
                                                        if($total_count == 2)
                                                        {
                                                            $row = 2;
                                                            $class = "col-lg-6 col-md-6 col-sm-6 col-xs-12";
                                                        }
                                                        
                                                        if($total_count == 1)
                                                        {
                                                            $row = 1;
                                                            $class = "col-lg-12 col-md-12 col-sm-12 col-xs-12";
                                                        }
                                                    
                                                    ?>
                                                    
                                                    <?if($key == 0 || ($key+1)%($row+1) == 0):?>
                                                        <div class="adv-table clearfix">
                                                    <?endif;?>

                                                        <div class="<?=$class?> adv-cell">
                                                            <table>
                                                                <tr>
                                                                
                                                                    <td class="img">

                                                                        <?if($arAdv["PREVIEW_PICTURE"] > 0):?>
                                                                            
                                                                            <?$file = CFile::ResizeImageGet($arAdv["PREVIEW_PICTURE"], array('width'=>100, 'height'=>100), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                                                    
                                                                            <img src="<?=$file["src"]?>" alt="<?=$arAdv["NAME"]?>" class="img-responsive" />

                                                                        <?elseif(strlen($arAdv["PROPERTIES"]["ICON"]["VALUE"]) && $arAdv["PREVIEW_PICTURE"] <= 0):?>
                                                 
                                                                            <div class="icon">
                                                                                <i class="<?=$arAdv["PROPERTIES"]["ICON"]["VALUE"]?>" <?if(strlen($arAdv["PROPERTIES"]["ICON"]["DESCRIPTION"]) > 0):?>style="color: <?=$arAdv["PROPERTIES"]["ICON"]["DESCRIPTION"]?>;"<?endif;?>></i>
                                                                            </div>
                                                                            
                                                                        <?else:?>
                                                                            <div class="icon default"></div>
                                                                        <?endif;?>
                                                                        
                                                                    </td>
                                                                    
                                                                    <td class='text'><?=$arAdv["PROPERTIES"]["SIGN"]["~VALUE"]?></td>
                                                                    
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    
                                                    
                                                    <?if(($key+1)%$row == 0):?>

                                                        <!-- <div class="clearfix"></div> -->

                                                        </div> <!-- ^adv-table -->

                                                    <?endif;?>
                                                    
                                                    <?/*if(($key+1)%2 == 0):?>
                                                        <div class="clearfix visible-sm"></div> 
                                                    <?endif;*/?>
                                                    
                                                <?endforeach;?>

                                            </div> 

                                        </div>


                                 
                                        <div class="buttons box-buttons-height hidden-xs">
                                            <table class="mobile-break">
                                                <tbody>
                                                    <tr>
                                                        <td class="left">
                                                            <a class="button-def secondary elips big box-close"><?=GetMessage("BOX_CATALOG_CONTINUE")?></a>
                                                        </td>

                                                        <?
                                                            if(strlen($arResult["SECTION"]["UF_CH_CONDITIONS"])>0)
                                                                $par_condition = "class='open-info call-modal callagreement from-modal from-modalform' data-call-modal='agreement".$arResult["SECTION"]["UF_CH_CONDITIONS"]."'";

                                                            if(strlen($arResult["SECTION"]["UF_CH_CONDITIONS_USR"])>0)
                                                                $par_condition = "class='open-info' target='_blank' href='".$arResult["SECTION"]["UF_CH_CONDITIONS_USR"]."' ";                                                            
                                                        ?>

                                                        <?if(isset($par_condition)):?>
                                                            <td class="right">
                                                                <a <?=$par_condition?>><span class="bord"><?if(strlen($arResult["SECTION"]["UF_CATALOG_DELIVERY"])>0) echo $arResult["SECTION"]["UF_CATALOG_DELIVERY"]; else echo GetMessage("BOX_CATALOG_DELIVERY");?></span></a>
                                                            </td>
                                                        <?endif;?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </td>
                                    <td class="right-p col-lg-4 col-md-4 col-sm-12 col-xs-12">

                                        <div class="info-table active">

                                            <div class="area_for_info_table">
                                                <?$APPLICATION->IncludeComponent(
                                                    "concept:hameleon_cart",
                                                    "info_table",
                                                    Array(
                                                        "COMPOSITE_FRAME_MODE" => "A",
                                                        "COMPOSITE_FRAME_TYPE" => "AUTO",
                                                        "CURRENT_LAND" => $arResult["SECTION"]["ID"],
                                                        "MESSAGE_404" => "",
                                                        "SET_STATUS_404" => "N",
                                                        "SHOW_404" => "N"
                                                    )
                                                );?>
                                            </div>

                                            <div class="buttons">
                                                <?if(strlen($arResult["SECTION"]["UF_CH_BOX_ORDER_FORM"])>0):?>

                                                    <a class="first-b primary button-def elips shine big call-modal box-form main-click" data-call-modal="form<?=$arResult["SECTION"]["UF_CH_BOX_ORDER_FORM"]?>" data-header="<?=GetMessage("CART_HEADER_ORDER")?>">

                                                        <?if(strlen($arResult["SECTION"]["UF_CH_BOX_BTN_NAME"])>0) echo $arResult["SECTION"]["~UF_CH_BOX_BTN_NAME"]; else echo GetMessage("BOX_CATALOG_ORDER");?>
                                                    </a>
                                                <?endif;?>

                                                <?if($arResult["SECTION"]["UF_CH_BOX_ONE_CLICK"]>0):?>

                                                    <a class="sec-b call-modal box-form" data-call-modal ="<?=$arResult["SECTION"]["UF_CH_BOX_ONE_CLICK"]?>" data-header="<?=GetMessage("CART_HEADER_FAST_ORDER")?>">

                                                        <span class="bord">
                                                    
                                                        <?if(strlen($arResult["SECTION"]["UF_CH_BOX_BTN_NAME_C"])>0) echo $arResult["SECTION"]["~UF_CH_BOX_BTN_NAME_C"]; else echo GetMessage("BOX_CATALOG_CLICK");?>

                                                        </span>
                                                    </a>
                                                <?endif;?>

                                            </div>

                                            <?if(strlen($arResult["SECTION"]["UF_CH_BOX_COMMENT"]) > 0):?>

                                                <div class="comment">
                                                   <?=$arResult["SECTION"]["~UF_CH_BOX_COMMENT"]?>
                                                </div> 

                                            <?endif;?>

                                            <div class="clear">
                                                <a class="click_box clear-box" data-box-action="clear"><?=GetMessage("BOX_CATALOG_CLEAR")?></a>
                                            </div>

                                        </div>

                                        <div class="form-order row">
                                            <div class="areabox-form box-order clearfix"></div>
                                        </div>

                                        <div class="style-box-back box-back"></div>

                                        <noindex>
    
                                            <div class="buttons buttons-2 box-buttons-height visible-xs">
                                                <table class="mobile-break">
                                                    <tbody>
                                                        <tr>
                                                            <td class="left">
                                                                <a class="button-def secondary elips big box-close"><?=GetMessage("BOX_CATALOG_CONTINUE")?></a>
                                                            </td>

                                                            <?
                                                                if(strlen($arResult["SECTION"]["UF_CH_CONDITIONS"])>0)
                                                                    $par_condition = "class='open-info call-modal callagreement from-modal from-modalform' data-call-modal='agreement".$arResult["SECTION"]["UF_CH_CONDITIONS"]."'";

                                                                if(strlen($arResult["SECTION"]["UF_CH_CONDITIONS_USR"])>0)
                                                                    $par_condition = "class='open-info' target='_blank' href='".$arResult["SECTION"]["UF_CH_CONDITIONS_USR"]."' ";                                                            
                                                            ?>

                                                            <?if(isset($par_condition)):?>
                                                                <td class="right">
                                                                    <a <?=$par_condition?>><span class="bord"><?if(strlen($arResult["SECTION"]["UF_CATALOG_DELIVERY"])>0) echo $arResult["SECTION"]["UF_CATALOG_DELIVERY"]; else echo GetMessage("BOX_CATALOG_DELIVERY");?></span></a>
                                                                </td>
                                                            <?endif;?>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </noindex>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="clearfix"></div>

                    </div>

                </div>
            </form>
        </div>


    </div>




<?}


$HAM_BOX_ = $APPLICATION->get_cookie('_ham_box_'.$arResult["SECTION"]["ID"], "");
$HAM_BOX = unserialize($HAM_BOX_);
?>

<script type="text/javascript">

$(document).ready(
    function()
   {
        callToBox("mini_cart_mob", "N", "update");
        $(".click_box").removeClass('added');

       <?foreach($HAM_BOX as $arItem):?>
           
           $(".click_box[data-box-id='<?=$arItem["id"]?>']").addClass('added');

       <?endforeach;?>
   }
);

</script>

<?$frame->end();?>



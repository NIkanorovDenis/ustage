<?use \Bitrix\Main\Page\Asset as Asset;?>

<?
global $HameleonCssFullList; 

$HameleonCssList = Array();
$HameleonCssTrueList = Array();

$HameleonCssList[] = SITE_TEMPLATE_PATH."/css/bootstrap.min.css";
$HameleonCssList[] = SITE_TEMPLATE_PATH."/css/font-awesome.css";
$HameleonCssList[] = SITE_TEMPLATE_PATH."/css/animate.min.css";
$HameleonCssList[] = SITE_TEMPLATE_PATH."/css/xloader.css";
$HameleonCssList[] = SITE_TEMPLATE_PATH."/css/blueimp-gallery.min.css";
$HameleonCssList[] = SITE_TEMPLATE_PATH."/slick/slick.css";
$HameleonCssList[] = SITE_TEMPLATE_PATH."/slick/slick-theme.css";
$HameleonCssList[] = SITE_TEMPLATE_PATH."/css/jquery.datetimepicker.min.css";
$HameleonCssList[] = SITE_TEMPLATE_PATH."/css/farbtastic.css";
$HameleonCssList[] = SITE_TEMPLATE_PATH."/css/concept.css";

$HameleonCssTrueList[] = SITE_TEMPLATE_PATH."/css/responsive.css";
$HameleonCssTrueList[] = SITE_TEMPLATE_PATH."/css/custom.css";

$HameleonCssFullList = array_merge($HameleonCssList, $HameleonCssTrueList);



global $HameleonJSFullList;

$HameleonJSFullList = Array();

$HameleonJSFullList[] = SITE_TEMPLATE_PATH."/js/jquery-1.12.3.min.js";
$HameleonJSFullList[] = SITE_TEMPLATE_PATH."/js/bootstrap.min.js";
$HameleonJSFullList[] = SITE_TEMPLATE_PATH."/js/jquery.plugin.min.js";
$HameleonJSFullList[] = SITE_TEMPLATE_PATH."/js/jquery.countdown.min.js";
$HameleonJSFullList[] = SITE_TEMPLATE_PATH."/lang/ru/jquery.countdown-ru.js";
$HameleonJSFullList[] = SITE_TEMPLATE_PATH."/js/device.min.js";
$HameleonJSFullList[] = SITE_TEMPLATE_PATH."/js/wow.js";
$HameleonJSFullList[] = SITE_TEMPLATE_PATH."/js/jquery.enllax.js";
$HameleonJSFullList[] = SITE_TEMPLATE_PATH."/js/jquery.maskedinput-1.2.2.min.js";
$HameleonJSFullList[] = SITE_TEMPLATE_PATH."/js/jquery.blueimp-gallery.min.js";
$HameleonJSFullList[] = SITE_TEMPLATE_PATH."/slick/slick.min.js";
$HameleonJSFullList[] = SITE_TEMPLATE_PATH."/lang/ru/jquery.datetimepicker.full.min.js";
$HameleonJSFullList[] = SITE_TEMPLATE_PATH."/js/zero-clipboard.js";
$HameleonJSFullList[] = SITE_TEMPLATE_PATH."/js/typed.min.js";
$HameleonJSFullList[] = SITE_TEMPLATE_PATH."/js/size-resize.js";
$HameleonJSFullList[] = SITE_TEMPLATE_PATH."/js/script.js";
$HameleonJSFullList[] = SITE_TEMPLATE_PATH."/js/forms.js";
$HameleonJSFullList[] = SITE_TEMPLATE_PATH."/js/custom.js";
?>


<?CJSCore::Init(array("fx"));?>

<?foreach($HameleonCssList as $css):?>
    <?Asset::getInstance()->addCss($css);?>
<?endforeach;?>

<?foreach($HameleonCssTrueList as $css):?>
    <?Asset::getInstance()->addCss($css, true);?>
<?endforeach;?>


<?foreach($HameleonJSFullList as $js):?>
    <?Asset::getInstance()->addJs($js);?>
<?endforeach;?>


<?\Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("composit_styles");?>

    <?if(!$OS):?>
        <?Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/smoothscroll.js");?>
    <?endif;?>

    <?global $USER;?>
    <?if($USER->isAdmin()):?>
        <?Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/fonts/fontAdmin.css", true);?>
        <?Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/farbtastic.js");?>
        <?Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/settings.js");?>
    <?endif;?>
    
<?\Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("composit_styles");?>

<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>
<?
if (count($arResult["VIDEO"])>0){
    
    $elementDraw = \Alexkova\Bxready2\Draw::getInstance($this);
    $elementDraw->setCurrentTemplate($this);

    switch ($arParams["BXR_DETAIL_TABS"]['BXR_DETAIL_TAB_VIDEO_MODE']){

            case ('table'):
                include('tab.video.table.php');
                break;
            case ('list'):
                include('tab.video.list.php');
                break;
            case ('fullsize'):
                include('tab.video.fullsize.php');
                break;
            case ('table_iframe'):
                include('tab.video.table.iframe.php');
                break;
            case ('list_iframe'):
                include('tab.video.list.iframe.php');
                break;
            case ('fullsize_iframe'):
                include('tab.video.fullsize.iframe.php');
                break;
            default:
                include('tab.video.table.php');
    }
}
?>
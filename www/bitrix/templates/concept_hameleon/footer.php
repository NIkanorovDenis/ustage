<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?$bIsMainPage = $APPLICATION->GetCurDir(false) == SITE_DIR;?>

<?
use \Bitrix\Main\Localization\Loc as Loc;
use \Bitrix\Main\Page\Asset as Asset; 
?>

<?Loc::loadMessages(__FILE__);?>


<?if($USER->isAdmin()):?>

    <?\Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("area");?>

    <?$APPLICATION->IncludeComponent(
    	"concept:pages.list",
    	"",
    	Array(
    		"CACHE_GROUPS" => "Y",
    		"CACHE_TIME" => "36000000",
    		"CACHE_TYPE" => "A",
    		"COMPOSITE_FRAME_MODE" => "A",
    		"COMPOSITE_FRAME_TYPE" => "AUTO",
    		"IBLOCK_ID" => "27",
    		"IBLOCK_TYPE" => "concept_hameleon",
    		"CURRENT_SECTION_ID" => $GLOBALS["CURRENT_SECTION_ID"],
    	)
    );?>
    
    <?\Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("area");?>

<?endif;?>


<div class="blueimp-gallery blueimp-gallery-controls" id="blueimp-gallery">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev"></a> 
    <a class="next"></a> 
    <a class="close"></a>
</div>

<div class="modalArea modalAreaVideo"></div>
<div class="modalArea modalAreaForm"></div>
<div class="modalArea modalAreaWindow"></div>
<div class="modalArea modalAreaAgreement"></div>


<?$APPLICATION->ShowViewContent("service_close_body");?>

</body>

</html>
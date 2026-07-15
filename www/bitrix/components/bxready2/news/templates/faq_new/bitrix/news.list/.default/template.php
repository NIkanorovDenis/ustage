<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (count($arResult["ITEMS"])>0):?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<div class="bxr-faq">
    
    <div id="accordion" class="bxr-faq-accordion bxr-children-color">
    <?foreach($arResult["ITEMS"] as $arItem):?>

        <?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
            <h3 class="bxr-children-color-children"><?=$arItem['NAME']?></h3>
            <div><p><?=$arItem['DETAIL_TEXT']?></p></div>
        
    <? endforeach; ?>
    </div>
</div>
        
<script>
    $(function() {
        $("#accordion").accordion({
            icons: null,
            collapsible: true,
            heightStyle: "content"
        });
    });
</script>

<?endif;?>
   

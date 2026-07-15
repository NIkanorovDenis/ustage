<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$showAll = $arParams['SHOW_ALL_SECTIONS_AND_Q'] ? $arParams['SHOW_ALL_SECTIONS_AND_Q'] : 'N';
$elementsQ = $arParams['SHOWS_ELEMENTS_Q'] ? $arParams['SHOWS_ELEMENTS_Q'] : '3';
?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<div class="bxr-faq">
    <?foreach ($arResult["SECTIONS"] as $cell => $arSection):?>

        <?
        $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>
    
        <?if ($arParams['SHOWS_ELEMENTS_Q'] == 0){?>
            <a href="<?=$arSection["SECTION_PAGE_URL"]?>" class="bxr-faq-section-name"><?=$arSection["NAME"]?></a>
        <?}else{?>
            <div class="bxr-faq-section-name"><?=$arSection["NAME"]?></div>
    
            <div id="accordion_<?=$arSection["ID"]?>" class="bxr-children-color bxr-faq-accordion">

                <?    
                $arSelectQ = Array("ID", "NAME", "DETAIL_TEXT");
                $arFilterQ = Array("IBLOCK_ID" => $arSection['IBLOCK_ID'], "SECTION_ID" => $arSection["ID"],"ACTIVE_DATE" => "Y", "ACTIVE" => "Y");
                $arNavQ = false;
                if ($elementsQ && $showAll=="N")
                    $arNavQ = array("nPageSize"=>$elementsQ);
                $resQ = CIBlockElement::GetList(Array(), $arFilterQ, false, $arNavQ, $arSelectQ);
                while ($obQ = $resQ->GetNext()) {
                ?>  
                    <h3 class="bxr-children-color-children"><?=$obQ['NAME']?></h3>
                    <div><p><?=$obQ['DETAIL_TEXT']?></p></div>
                <?}?>
            </div>
                
            <?if ($elementsQ && $showAll=="N" && $elementsQ < $arSection['ELEMENT_CNT']):?>
            <div class="bxr-faq-show-all-q">
                <a href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=GetMessage("SHOW_ALL_ELEMENTS")?></a>
            </div>
            <?endif;?>
                
            <br>
            <br>
        <?}?>
        <script>   
            $(function() {
                
                var icons = {
                    header: "fa fa-angle-down",
                    activeHeader: "fa fa-angle-up"
                };
                
                $("#accordion_<?=$arSection["ID"]?>").accordion({
                    icons: icons,
                    collapsible: true,
                    heightStyle: "content",
                    active: false
                });
                
            });
        </script>

    <? endforeach; ?>
</div>
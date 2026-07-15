<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$this->setFrameMode(true);
$signer = new \Bitrix\Main\Security\Sign\Signer;
$signedTemplate = $signer->sign($templateName, 'regions');
$arResult['TRANSPORT_PARAMS'] = array();

foreach ($arParams as $cell=>$val){

    if (substr($cell, 0, 1) !=  "~"){
        $arResult['TRANSPORT_PARAMS'][$cell] = $val;
    }
}

if (is_array($arResult['TRANSPORT_PARAMS']['BXREADY_SETTINGS'])) {
    foreach ($arResult['TRANSPORT_PARAMS']['BXREADY_SETTINGS'] as $cell => $val) {

        if (substr($cell, 0, 1) == "~") {
            unset($arResult['TRANSPORT_PARAMS']['BXREADY_SETTINGS'][$cell]);
        }
    }
}

/*$marketRegistry = \Alexkova\Market2\Bxmarket::getInstance();
$arResult['TRANSPORT_PARAMS']["BXR_AJAX_REGION_INFO"] = $marketRegistry->getRegionData();*/

$signedParams = $signer->sign(base64_encode(serialize($arResult['TRANSPORT_PARAMS'])), 'regions');

?>
<?$modal_region_current = $this->createFrame()->begin("");?>
<?if((!isset($arParams["REGION_CORRECTLY"]) || $arParams["REGION_CORRECTLY"] == "Y" ) && empty($_REQUEST['ajax_call']) && empty($_REQUEST['ajax_mode']) && isset($arResult["REGION_INFO"]["current_region"]) && empty($arResult["REGION_INFO"]["current_region"])):?>
    <div class="" id="myModalRegionCurrent" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog current_region_dialog modal-sm" data-contentLoad="N">
            <div class="modal-content " >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&#215;</span></button>
                <div class="modal-body"><div><?=GetMessage('REGION_SELECTOR_CITY');?> - <b><?=$arResult['REGION_INFO']['region_detail']['NAME'];?></b> ?</div>
                    <div class="current_region_dialog_btn">
                        <a href="<?=$arResult['REGION_INFO']['region_detail']['LINK'];?>" class="bxr-color-button bxr-color-button-small-only-icon bxr-basket-add"><?=GetMessage('YES');?></a>
                        <a id="other_region" href="#" class="bxr-border-color-button"><?=GetMessage('NO');?></a>
                    </div>
                    <?if(isset($arParams["REGION_CURRENT_INFO_TEXT"]) && !empty($arParams["REGION_CURRENT_INFO_TEXT"])):?>
                        <div class="current_region_dialog_info"><?=$arParams["REGION_CURRENT_INFO_TEXT"];?></div>
                    <?endif;?>
                </div>
            </div>
        </div>
    </div>
<?endif;?>
<?$modal_region_current->end();?>
<? if ($arParams['FORM_MODE'] == 'STATIC' || $_REQUEST['ajax_call'] == 'y'):?>
    <div class="modal-content <?=$arParams['FORM_MODE'];?><?=($_REQUEST['ajax_mode'])=="yes" ? "yes" : "";?>" id="bxr-region-selector">
        <div class="popup-region">
            <div class="modal-header bxr-border-bottom-color">
                <?if($_REQUEST['ajax_mode'] == 'yes'):?><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&#215;</span></button><?endif;?>
                <div class="h4 modal-title"><?=GetMessage('REGION_SELECTOR_CITY_CHOICE');?></div>
            </div>
            <div class="modal-body">
                <?if(!isset($arParams["USE_SEARCH_TITLE"]) || $arParams["USE_SEARCH_TITLE"]=="Y"):?>
                    <? $APPLICATION->IncludeComponent(
                        "bxready.market2:search.title",
                        ".default",
                        array(
                            "CATEGORY_0" => array(
                                0 => "iblock_" . $arParams['IBLOCK_TYPE'],
                            ),
                            "CATEGORY_0_TITLE" => "",
                            "CATEGORY_0_iblock_" . $arParams['IBLOCK_TYPE'] => array(
                                0 => $arParams['IBLOCK_ID'],
                            ),
                            "CHECK_DATES" => "N",
                            "CONTAINER_ID" => "title-search-region",
                            "INPUT_ID" => "title-search-input-region",
                            "NUM_CATEGORIES" => "1",
                            "ORDER" => "date",
                            "PAGE" => "",
                            "SHOW_INPUT" => "Y",
                            "SHOW_OTHERS" => "N",
                            "TOP_COUNT" => "5",
                            "USE_LANGUAGE_GUESS" => "Y",
                            "COMPONENT_TEMPLATE" => ".default",
                            "CURRENT_PAGE" => $arParams["CURRENT_PAGE"],
                            "REGION_LIST_ID_LINK" => $arResult["REGION_LIST_ID_LINK"]
                        ),
                        $component,
                        array(
                            "HIDE_ICONS"=>"Y"
                        )
                    ); ?>
                    <?if(isset($arResult['REGION_LIST']) && is_array($arResult['REGION_LIST']) && count($arResult['REGION_LIST'])>0):?>
                        <div class="bxr_region_example"><?=GetMessage('REGION_EXAMPLE');?>:
                            <?for($i=0; $i<=1; $i++):?><?=($i!=0 && isset($arResult['REGION_LIST'][$i]))?", ":""?><?if(isset($arResult['REGION_LIST'][$i])):?><a href="<?=$arResult['REGION_LIST'][$i]["LINK"];?>"><?=$arResult['REGION_LIST'][$i]["NAME"];?></a><?endif;?><?endfor;?>
                        </div>
                    <?endif;?>
                    <hr>
                <?endif;?>
                <ul class="popup-region__list">
                    <? foreach ($arResult['REGION_LIST'] as $city): ?>
                        <li class="popup-region__item">
                            <a href="<?= $city["LINK"] ?>" class="popup-region__link">
                                <?= $city["NAME"] ?>
                            </a>
                        </li>
                    <? endforeach; ?>
                </ul>
                <?if(isset($arParams["REGION_INFO_TEXT"]) && !empty($arParams["REGION_INFO_TEXT"])):?>
                    <hr><div class="popup-region__info"><?=$arParams["REGION_INFO_TEXT"];?></div>
                <?endif;?>
            </div>
        </div>
    </div>
<?elseif ($arParams['FORM_MODE'] == 'SELECT' ):?>
    <ul class="btn-t gift-catalog-sort-panel__text-sity" data-type="select">
        <li><div><i class="fa fa-map-marker"></i><?=$arResult['REGION_INFO']['region_detail']['NAME']?><i class="fa fa-angle-down"></i></div>
            <?if(is_array($arResult['REGION_LIST']) && count($arResult['REGION_LIST'])>1):?>
                <ul><?$i=0;?>
                    <?$showOther = false;?>
                    <?foreach ($arResult['REGION_LIST'] as $k => $v):?>
                        <?if($v["CODE"] != $arResult['REGION_INFO']['region_detail']['CODE']):?>
                            <li><div><a href="<?=$v["LINK"]?>" ><?=$v["NAME"];?></a></div></li>
                            <?++$i;?>
                        <?endif;?>
                        <?if(isset($arParams["COUNT_CITY_SELECT"]) && !empty($arParams["COUNT_CITY_SELECT"]) && $arParams["COUNT_CITY_SELECT"]>0 ):?>
                            <?if($i>=$arParams["COUNT_CITY_SELECT"]):?>
                                <li class="other-selector-js"><div class="bxr-children-color"><a data-toggle="modal" data-target="#myModalRegion" href="#" ><?=GetMessage('ALL_REGION');?></a></div></li>
                                <?$showOther = true; break;
                              endif;
                            ?>
                        <?endif;?>
                    <?endforeach;?>
                    <?if(!$showOther):?>
                        <li class="other-selector-js hidden"><div class="bxr-children-color"><a data-toggle="modal" data-target="#myModalRegion" href="#" ><?=GetMessage('ALL_REGION');?></a></div></li>  
                    <?endif;?>
                </ul>
            <?endif;?>
        </li>
    </ul>
    <div class="modal fade" id="myModalRegion" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog region_dialog" data-contentLoad="N">
        </div>
    </div>
<?elseif ($arParams['FORM_MODE'] == 'POPUP' ):?>

    <span class="btn-t gift-catalog-sort-panel__text-sity" data-toggle="modal" data-target="#myModalRegion"  data-type="popup">
        <i class="fa fa-map-marker"></i><?=$arResult['REGION_INFO']['region_detail']['NAME']?>
    </span>

    <div class="modal fade" id="myModalRegion" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog region_dialog" data-contentLoad="N"></div>
    </div>
<?endif?>
<?if(empty($_REQUEST['ajax_call']) && empty($_REQUEST['ajax_mode'])):?>
<script>
    $(document).ready(function() {

        $('#myModalRegionCurrent').css('display', 'block');

        $('#myModalRegionCurrent .modal-content .close').click(function() {
            $('#myModalRegionCurrent').css('display', 'none');
        });

        $('#other_region').click(function() {
            $('#myModalRegionCurrent').modal('hide');
            $('#myModalRegion').modal('show');
            
            <?if ($arParams['FORM_MODE'] == 'POPUP' ):?>
                $('.btn-t').trigger('click');
            <?else:?>
                $('.btn-t .other-selector-js').trigger('click');
            <?endif;?>
            
            return false;
        });
        
        var $content = $('.region_dialog');
        
         <?if ($arParams['FORM_MODE'] == 'POPUP' ):?>
            $('.btn-t').click(function() {
        <?else:?>
            $('.btn-t .other-selector-js').click(function() {
        <?endif;?>

            if ($content.attr('data-contentLoad') == 'N') {
                var ajaxUrl = '<?=$this->GetFolder().'/ajax.php'?>';
                $.ajax({
                    url: ajaxUrl,
                    method: 'POST',
                    data: {
                        "ajax_mode": "yes",
                        "siteId": "<?=SITE_ID?>",
                        "template": "<?=$signedTemplate?>",
                        "parameters": "<?=$signedParams?>",
                    },
                    beforeSend: function(){
                        $('.region_dialog').html('<div class="modal-content region-pre"><i class="fa fa-circle-o-notch fa-spin fa-fw bxr-font-color margin-bottom"></i></div>');
                    },
                    success: function (data) {
                        $content.html(data);
                        $content.attr('data-contentLoad', 'Y');
                        $('#myModalRegion').modal('show');
                    }
                });
            } else return;
        });
    });
</script>
<?endif;?>
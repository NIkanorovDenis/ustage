<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$this->setFrameMode(true);

global $unicumID;
if ($unicumID <= 0) {$unicumID = 1;} else {$unicumID++;}
if (isset($_REQUEST["bxr_ajax"]) && $_REQUEST["bxr_ajax"] == "yes")
    $unicumID = "marc_".htmlspecialchars($_REQUEST["ID"]);

if (!isset($arParams['MOBILE_SETTINGS_USE_LAZY_LOAD'])) {
    $arParams['MOBILE_SETTINGS_USE_LAZY_LOAD'] = "Y";
}

if (!isset($arParams['BXR_LAZY_LOAD'])) {
    $arParams['BXR_LAZY_LOAD'] = "MOBILE";
}

if ($arParams['SINGLE_MODE'] == 'Y')
{
    $arParams['UNICUM_POSTFIX'] = $arResult['PARENT'];
    $arParams['FILTER_NAME'] = 'arrMarkers';
    $arParams['BXR_LAZY_LOAD'] = "N";
    global $arrMarkers;

    switch ($arResult['PARENT']) {
        case 'RECOMMENDED':
            $arrMarkers = array("!PROPERTY_RECOMMENDED" => false);
            break;
        case 'NEWPRODUCT':
            $arrMarkers = array("!PROPERTY_NEWPRODUCT" => false);
            break;
        case 'SPECIALOFFER':
            $arrMarkers = array("!PROPERTY_SPECIALOFFER" => false);
            break;
        case 'SALELEADER':
            $arrMarkers = array("!PROPERTY_SALELEADER" => false);
            break;
        default: 
            break;
    }

    $APPLICATION->IncludeComponent(
        'bxready.market2:catalog.section',
        'bxready',
        $arParams,
        $component,
        array('HIDE_ICONS'=>'Y')
    );
}
else
{
    $signer = new \Bitrix\Main\Security\Sign\Signer;
    $signedTemplate = $signer->sign($templateName, 'markers');
    $arResult['TRANSPORT_PARAMS'] = array();

    foreach ($arParams as $cell=>$val){
        if (substr($cell, 0, 1) !=  "~")
            $arResult['TRANSPORT_PARAMS'][$cell] = $val;
    }

    foreach ($arResult['TRANSPORT_PARAMS']['BXR_PRESENT_SETTINGS'] as $cell => $val){
        if (substr($cell, 0, 1) ==  "~")
            unset($arResult['TRANSPORT_PARAMS']['BXR_PRESENT_SETTINGS'][$cell]);
    }

    unset($arResult['TRANSPORT_PARAMS']['PAGER_TITLE']);

    $signedParams = $signer->sign(base64_encode(serialize($arResult['TRANSPORT_PARAMS'])), 'markers');
    
    if (count($arResult["MARKERS_LIST"]) > 0): 
        $first = ' bxr-markers-group-active';?>
        <div id="bxr-markers-container">
            <?
            $firstMarker = false?>
            <div class="row hidden-xs" id="bxr-markers">
                <div class="col-xs-12 lent">
                    <?foreach($arResult["MARKERS_LIST"] as $cell):
                        switch ($cell) {
                            case "ACTION":?>
                                <div class="bxr-markers-group" id="marc_tabSPECIALOFFER" data-slide="SPECIALOFFER" data-type="markers"><?=GetMessage('SPECIALOFFER_BUTTON')?></div>
                                <?
                                if (!$firstMarker) $firstMarker = "SPECIALOFFER";
                                break;
                            case "NEW":?>
                                <div class="bxr-markers-group" id="marc_tabNEWPRODUCT" data-slide="NEWPRODUCT" data-type="markers"><?=GetMessage('NEWPRODUCT_BUTTON')?></div>
                                <?
                                if (!$firstMarker) $firstMarker = "NEWPRODUCT";
                                break;
                            case "RECCOMEND":?>
                                <div class="bxr-markers-group" id="marc_tabRECOMMENDED" data-slide="RECOMMENDED" data-type="markers"><?=GetMessage('RECOMMENDED_BUTTON')?></div>
                                <?
                                if (!$firstMarker) $firstMarker = "RECOMMENDED";
                                break;
                            case "HIT":?>
                                <div class="bxr-markers-group" id="marc_tabSALELEADER" data-slide="SALELEADER" data-type="markers"><?=GetMessage('SALELEADER_BUTTON')?></div>
                                <?
                                if (!$firstMarker) $firstMarker = "SALELEADER";
                                break;
                            default ;
                        }
                    endforeach;?>
                </div>
            </div><?

            foreach($arResult["MARKERS_LIST"] as $cell):
                switch ($cell) {
                    case "ACTION":?>
                        <div class="hidden-lg hidden-md hidden-sm">
                            <div id="bxr-mobile-name-SPECIALOFFER"
                                 class="bxr-marker-mobile-names bxr-color-button"
                                 data-slide="SPECIALOFFER"
                                 data-unicum="<?=$unicum?>">
                                <?=GetMessage('SPECIALOFFER_BUTTON')?>
                            </div>
                        </div>
                        <div id="mark-panel-SPECIALOFFER" class="bxr-carousel bxr-markers-list"></div><?
                        break;
                    case "NEW":?>
                        <div class="hidden-lg hidden-md hidden-sm">
                            <div id="bxr-mobile-name-NEWPRODUCT"
                                 class="bxr-marker-mobile-names bxr-color-button"
                                 data-slide="NEWPRODUCT"
                                 data-unicum="<?=$unicum?>">
                                <?=GetMessage('NEWPRODUCT_BUTTON')?>
                            </div>
                        </div>
                        <div id="mark-panel-NEWPRODUCT" class="bxr-carousel bxr-markers-list"></div><?
                        break;
                    case "RECCOMEND":?>
                        <div class="hidden-lg hidden-md hidden-sm">
                            <div id="bxr-mobile-name-RECOMMENDED"
                                 class="bxr-marker-mobile-names bxr-color-button"
                                 data-slide="RECOMMENDED"
                                 data-unicum="<?=$unicum?>">
                                <?=GetMessage('RECOMMENDED_BUTTON')?>
                            </div>
                        </div>
                        <div id="mark-panel-RECOMMENDED" class="bxr-carousel bxr-markers-list"></div><?
                        break;
                    case "HIT":?>
                        <div class="hidden-lg hidden-md hidden-sm">
                            <div id="bxr-mobile-name-SALELEADER"
                                 class="bxr-marker-mobile-names bxr-color-button"
                                 data-slide="SALELEADER"
                                 data-unicum="<?=$unicum?>">
                                <?=GetMessage('SALELEADER_BUTTON')?>
                            </div>
                        </div>
                        <div id="mark-panel-SALELEADER" class="bxr-carousel bxr-markers-list"></div><?
                        break;
                    default ;
                }
            endforeach;?>
        </div>

        <script>
        $(document).ready(function(){
            var Bestsellers = new JCCatalogSectionMarkers({
                ajaxUrl: '<?=$this->GetFolder().'/ajax.php'?>',
                first: '<?=$firstMarker?>',
                lazyLoad: <?=$arParams['MOBILE_SETTINGS_USE_LAZY_LOAD'] ? 'true' : 'false'?>,
                postData: {
                    siteId : '<?=SITE_ID?>',
                    template : '<?=$signedTemplate?>',
                    parameters : '<?=$signedParams?>'
                }
            });
        });

        </script>

        <?
        $APPLICATION->IncludeComponent(
            'bxready.market2:catalog.section',
            'empty',
            $arParams,
            $component,
            array('HIDE_ICONS'=>'Y')
        );       
        
        $elementDraw = \Alexkova\Bxready2\Draw::getInstance($this);
        $elementDraw->setCurrentTemplate($this);
        $elementDraw->showElement("elements", $arParams['BXR_PRESENT_SETTINGS']["BXREADY_ELEMENT_DRAW"], $arItem, $arParams, true);
        $elementDraw->showElement("markers", $arParams['BXR_PRESENT_SETTINGS']["BXREADY_LIST_MARKER_TYPE"], array(), array(), true);
    endif;
}




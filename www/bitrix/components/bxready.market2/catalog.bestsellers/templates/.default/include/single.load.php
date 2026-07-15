<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$this->setFrameMode(true);
if (!isset($arParams['BXR_LAZY_LOAD'])) {
    $arParams['BXR_LAZY_LOAD'] = "MOBILE";
}

if ($arParams['SINGLE_MODE'] == 'Y')
{
    if (count($arResult['BESTSELLERS_ITEMS'])>0) {  
        $arParams['UNICUM_POSTFIX'] = $arResult['PARENT'];
        $arParams['FILTER_NAME'] = 'arrBestsellers';
        $arParams['BXR_LAZY_LOAD'] = "N";
        global $arrBestsellers;
        $arrBestsellers = array('ID' => $arResult['BESTSELLERS_ITEMS']);
        $APPLICATION->IncludeComponent(
            'bxready.market2:catalog.section',
            'bxready',
            $arParams,
            $component,
            array('HIDE_ICONS'=>'Y')
        );
    }
}
else 
{
    $signer = new \Bitrix\Main\Security\Sign\Signer;
    $signedTemplate = $signer->sign($templateName, 'bestsellers');
    $arResult['TRANSPORT_PARAMS'] = array();

    foreach ($arParams as $cell=>$val) {
        if (substr($cell, 0, 1) !=  "~")
            $arResult['TRANSPORT_PARAMS'][$cell] = $val;
    }

    foreach ($arResult['TRANSPORT_PARAMS']['BXR_PRESENT_SETTINGS'] as $cell=>$val) {
        if (substr($cell, 0, 1) ==  "~")
            unset($arResult['TRANSPORT_PARAMS']['BXR_PRESENT_SETTINGS'][$cell]);
    }

    unset($arResult['TRANSPORT_PARAMS']['PAGER_TITLE']);

    $signedParams = $signer->sign(base64_encode(serialize($arResult['TRANSPORT_PARAMS'])), 'bestsellers');

    if (count($arResult["ITEMS"])>0):

        $unicumID = 0;
        if (isset($_REQUEST["ajax_mode"]) && $_REQUEST["ajax_mode"] == "yes")
            $unicumID = 10000+intval($_REQUEST["ID"]);

        $colToElem = array();
        $bootstrapGridCount = 12;
        if ($bootstrapGridCount>0) {
            for($i=1; $i<=$bootstrapGridCount; $i++) {
                if (($bootstrapGridCount % $i) == 0)
                    $colToElem[$bootstrapGridCount / $i] = $i;
            }
        }

        $first = ' bxr-bestsellers-group-active';?>
        <div id="bxr-bestsellers-container">
            <div class="row hidden-xs" id="bxr-bestsellers">
                <div class="col-lg-12 jcarousel-row">
                    <div class="lent">
                        <?foreach($arResult["ITEMS"] as $arItem):
                            $arItem['EDIT_LINK'] = str_replace(array("/ajax/bestsellers_tc.php", "bxr_ajax=yes"), "", $arItem['EDIT_LINK']);
                            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
                            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
                            $strMainID = $this->GetEditAreaId($arItem['ID']);
                            $unicum = 10000 + intval($arItem["ID"]);
                            ?>
                            <div class="bxr-bestsellers-group bxr-color-hover bxr-border-color-hover<?=$first?>"
                                 id="rec_tab<?=$arItem["ID"]?>" data-slide="<?=$arItem["ID"]?>" data-type="group"
                                 data-unicum="<?=$unicum?>">
                                <div><?=$arItem["NAME"]?> <?if(!isset($arParams["REGION_CONTENT"]) || empty($arParams["REGION_CONTENT"])):?>(<?=intval(count($arItem["PROPERTY_ITEMS_VALUE"]))?>)<?endif;?></div>
                            </div>
                            <?$first = '';
                        endforeach;?>
                    </div>
                </div>
            </div><?
            foreach($arResult["ITEMS"] as $arItem):?>
                <div class="hidden-lg hidden-md hidden-sm">
                    <div id="bxr-mobile-name-<?=$arItem["ID"]?>"
                         class="bxr-mobile-names bxr-color-button"
                         data-slide="<?=$arItem["ID"]?>"
                         data-unicum="<?=$unicum?>">
                        <?=$arItem["NAME"]?> (<?=intval(count($arItem["PROPERTY_ITEMS_VALUE"]))?>)
                    </div>
                </div>
                <div id="best-panel-<?=$arItem["ID"]?>" class="bxr-carousel bxr-bestseller-list"></div>
            <?endforeach;?>
        </div>

        <script>
        $(document).ready(function(){
            var Bestsellers = new JCCatalogSectionBestseller({
                ajaxUrl: '<?=$this->GetFolder().'/ajax.php'?>',
                dots: false,
                infinite: false,
                speed: 300,
                slidesToShow: 4,
                centerMode: false,
                variableWidth: true,
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




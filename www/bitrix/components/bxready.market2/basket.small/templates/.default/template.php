<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
    global $eMarketBasketData;

    $signer = new \Bitrix\Main\Security\Sign\Signer;
    $signedTemplate = $signer->sign($templateName, 'basket');
    $arResult['TRANSPORT_PARAMS'] = array();

    if(is_array($arParams)) {
        foreach ($arParams as $cell=>$val){
            if (substr($cell, 0, 1) !=  "~")
                $arResult['TRANSPORT_PARAMS'][$cell] = $val;
        }
    }

    if(is_array($arResult['TRANSPORT_PARAMS']['BXR_PRESENT_SETTINGS'] )) {
        foreach ($arResult['TRANSPORT_PARAMS']['BXR_PRESENT_SETTINGS'] as $cell => $val){
            if (substr($cell, 0, 1) ==  "~")
                unset($arResult['TRANSPORT_PARAMS']['BXR_PRESENT_SETTINGS'][$cell]);
        }
    }

    unset($arResult['TRANSPORT_PARAMS']['PAGER_TITLE']);

    $signedParams = $signer->sign(base64_encode(serialize($arResult['TRANSPORT_PARAMS'])), 'basket');    
?>
<?if (isset($_REQUEST['ajaxbuy']) && $_REQUEST['ajaxbuy'] == "yes"){$APPLICATION->RestartBuffer();}?>

<?if (isset($_REQUEST['ajaxbuy']) && $_REQUEST['ajaxbuy'] == "yes" && $_REQUEST["action"] == 'add'):?>
    <?include('popup.php');?>
<?endif;?>
<div class="<?=$arParams["STYLE"];?>">
    <?if (!isset($_REQUEST['ajaxbuy']) || $_REQUEST['ajaxbuy'] != "yes"):?>
        <div id="bxr-basket-row" class="basket-body-table-row bxr-basket-row-top">
            <?if ($arParams["USE_COMPARE"] == "Y"):?>
                <div <?=(!empty($arParams["STYLE"]))?" class='bxr-bg-hover-flat' ":""?> >
                    <?if (substr_count($APPLICATION->GetCurPage(),SITE_DIR.'/catalog/compare.php') <= 0)
                        $APPLICATION->IncludeComponent(
                            "bxready.market2:catalog.compare.list",
                            ".default",
                                Array(
                                        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                                        "AJAX_MODE" => "N",
                                        "AJAX_OPTION_JUMP" => "N",
                                        "AJAX_OPTION_STYLE" => "Y",
                                        "AJAX_OPTION_HISTORY" => "N",
                                        "DETAIL_URL" => "",
                                        "COMPARE_URL" => $arParams["BXR_COMPARE_LINK"],
                                        "NAME" => "CATALOG_COMPARE_LIST"
                                ),
                                false,
                                array('HIDE_ICONS'=>"Y")
                    );?>
                </div>
            <?endif;?>
    <?else:?>
        <span id="bxr-basket-data" style="display: none;"><?=json_encode($eMarketBasketData)?></span>
    <?endif;?>

    <?if (!isset($_REQUEST['ajaxbuy']) || $_REQUEST['ajaxbuy'] != "yes"):?>
        <?if(!isset($arParams["USE_HEART"]) || $arParams["USE_HEART"]=="Y"):?>
            <div <?=(!empty($arParams["STYLE"]))?" class='bxr-bg-hover-flat' ":""?> >
                <a href="javascript:void(0);" data-group="basket-group" class="bxr-basket-indicator bxr-indicator-favor bxr-font-hover-light"  data-child="bxr-favor-body" 
                    title="<?=GetMessage("FAVOR_TITLE")?>">
                        <?include('favor_state.php');?>
                </a>
        <?endif;?>
    <?endif;?>

    <?
    $idDelay = "bxr-favor-body";
    if (isset($_REQUEST['ajaxbuy']) && $_REQUEST['ajaxbuy'] == "yes")
        $idDelay = 'favor-body-content';
    ?>

    <div id="<?=$idDelay?>" class="basket-body-container" data-group="basket-group" data-state="hide">
        <?include('items_favor.php');?>
    </div>

    <?if (!isset($_REQUEST['ajaxbuy']) || $_REQUEST['ajaxbuy'] != "yes"):?>
        <?if(!isset($arParams["USE_HEART"]) || $arParams["USE_HEART"]=="Y"):?>       
            </div>
        <?endif;?>
    <?endif;?>    

    <?if (!isset($_REQUEST['ajaxbuy']) || $_REQUEST['ajaxbuy'] != "yes"):?>
        <div <?=(!empty($arParams["STYLE"]))?" class='bxr-bg-hover-flat' ":""?> >
            <a href="javascript:void(0);" class="bxr-basket-indicator bxr-indicator-basket bxr-font-hover-light" data-group="basket-group" data-child="bxr-basket-body" 
               title="<?=GetMessage("BASKET_TITLE")?>">
            <?include('basket_delay_state.php');?>
            </a>
    <?endif;?>

    <?
    $idDelay = "bxr-basket-body";
    if (isset($_REQUEST['ajaxbuy']) && $_REQUEST['ajaxbuy'] == "yes")
        $idDelay = 'basket-body-content';
    ?>
    <div id="<?=$idDelay?>" class="basket-body-container" data-group="basket-group" data-state="hide">
        <?include('items_basket.php');?>
    </div>
    <?if (!isset($_REQUEST['ajaxbuy']) || $_REQUEST['ajaxbuy'] != "yes"):?>
        </div>
    <?endif;?>  
    <?if (!isset($_REQUEST['ajaxbuy']) || $_REQUEST['ajaxbuy'] != "yes"):?>
        </div>
        <div class="clearfix"></div>
        <div style="display: none;" id="bxr-basket-content"></div>
    <?else:?>
        <div id="bxr-indicator-basket-new"><?include('basket_delay_state.php');?></div>
        <div id="bxr-indicator-delay-new"><?include('delay_state.php');?></div>
        <div id="bxr-indicator-favor-new"><?include('favor_state.php');?></div>
        <?die();
    endif;
    ?>
</div>
<?if (!isset($_REQUEST['ajaxbuy']) || $_REQUEST['ajaxbuy'] != "yes"):?>

    <script>
        var delayClick = false;
        BX.message({
            setItemDelay2BasketTitle: '<?=GetMessage('BASKET_DELAY_OK_TITLE')?>',
            setItemAdded2BasketTitle: '<?=GetMessage('BASKET_ADD_OK_TITLE')?>'
        });

        BXR = window.BXReady.Market.Basket;
        BXR.init({
            ajaxUrl: '<?=$templateFolder;?>/ajax/bxr_basket_action.php',
            getFolder: '<?=$this->GetFolder()?>',
            showPopup: '<?=isset($arParams["SHOW_POPUP"])? $arParams["SHOW_POPUP"] : "true";?>',
            postData: {
                siteId : '<?=SITE_ID?>',
                template : '<?=$signedTemplate?>',
                parameters : '<?=$signedParams?>'
            },
            startBasketData: <?=json_encode($eMarketBasketData)?>
        });
    </script>
<?endif;?>

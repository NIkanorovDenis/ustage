<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$signer = new \Bitrix\Main\Security\Sign\Signer;
$signedTemplate = $signer->sign($templateName, 'settingspanel');
$arResult['TRANSPORT_PARAMS'] = array();

if (is_array($arParams)) {
    foreach ($arParams as $cell => $val) {
        if (substr($cell, 0, 1) != "~")
            $arResult['TRANSPORT_PARAMS'][$cell] = $val;
    }
}

$signedParams = $signer->sign(base64_encode(serialize($arResult['TRANSPORT_PARAMS'])), 'settingspanel');
$ajaxModePostfix = '';
?>

<? if (isset($_REQUEST['ajax_mode']) && $_REQUEST['ajax'] == "ajax_mode") {
    $APPLICATION->RestartBuffer();
    $ajaxModePostfix = '-ajax';
} ?>

<? if (!$arResult['AJAX_MODE']): ?>
    <?
    if ($arParams['INIT_JQUERY'] == 'Y') {
        CJSCore::Init('jquery');
    }
    ?>
    <div class="gearBXR24" id="gearBXR24">
        <div class="gear<? if ($arResult['SHOW']) echo ' show' ?>">

            <div class="gearhead">
                <div class="head_gear">
                    <div class="title">
                        <?= Loc::getMessage("BXR_SETTINGS_PANEL_TITLE"); ?>
                    </div>
                    <div class="btn-def"><i
                                class="fa fa-magic"></i> <?= Loc::getMessage("BXR_SETTINGS_PANEL_DEFAULT"); ?>
                    </div>
                </div>
            </div>
            <div class="gear-main scrollbar-macosx">
                <? endif; ?>
                <? if ($arResult['SHOW'] || $arResult['LAZY']): ?>

                    <div class="gear-tabs">
                        <? foreach ($arResult['settings'] as $val): ?>
                            <div class="gear-tab<? if ($val['active']) echo ' active' ?>"
                                 data-item="<?= $val['code'] ?>">
                                <div class="gear-img">
                                    <div class="gear-img-sprite"
                                         style='background: url("<?= $val["icon"] ?>") no-repeat top center;'></div>
                                </div>
                                <span><?= $val['name'] ?></span>
                            </div>
                        <? endforeach; ?>
                    </div>
                    <div class="gear-content">
                        <? foreach ($arResult['settings'] as $cell => $val): ?>
                            <div class="gear-block<? if ($val['active']) echo ' active' ?>"
                                 data-item="<?= $val['code'] ?>">

                                <? foreach ($val['items'] as $cell2 => $val2):
                                    $addHidden = '';
                                    if ($val2['parent']) {
                                        if (isset($arResult['selected'][$arResult['parents'][$val2['parent']]['selector']])
                                            && $arResult['selected'][$arResult['parents'][$val2['parent']]['selector']] != $arResult['parents'][$val2['parent']]['value']) {
                                            $addHidden = ' hidden';
                                        } else {
                                            $addHidden = '';
                                        }
                                    }
                                    ?>
                                    <div class="element<?= $addHidden ?>">
                                        <?
                                        if (isset($val2['type'])) {
                                            switch ($val2['type']) {

                                                case 'delimiter':
                                                    ?>
                                                    <div class="caption-main">
                                                        <?= $val2['name'] ?>
                                                    </div>
                                                    <hr>

                                                    <?
                                                    break;

                                                case 'color':
                                                    $selectorId = 'selector_' . $val2['id'];
                                                    ?>
                                                    <div class="caption"><?= Loc::getMessage("BXR_SELECTOR_COLOR"); ?></div>
                                                    <div class="body color">
                                                        <?
                                                        foreach ($val2['values'] as $value):?>
                                                            <label>
                                                                <input type="radio" class="option-input radio"
                                                                       name="<?= $selectorId ?>" value="<?= $value ?>"
                                                                       style="background-color: #<?= $value ?>">
                                                            </label>
                                                        <? endforeach ?>
                                                        <input type="color" name="<?= $selectorId ?>" id="color_picker">
                                                    </div>
                                                    <?
                                                    break;

                                                case 'checkbox':
                                                    $selectorId = 'selector_' . $val2['id'];
                                                    $checked = $arResult['selected'][$selectorId] == $selectorId . "_on" || (!$arResult['selected'][$selectorId] && $val2['values']['on']['default'])
                                                    ?>
                                                    <div class="caption">
                                                        <?= $val2['name'] ?>
                                                    </div>
                                                    <div class="body checkbox">
                                                        <label class="switch">
															<input type="checkbox" name="<?=$selectorId?>" class="checkbox-selector" value="on" <?if($checked) echo 'checked'?>>
                                                            <span class="check_round"></span>
                                                        </label>
                                                    </div>
                                                    <?
                                                    break;

                                                case 'text-select':
                                                    ?>
                                                    <div class="caption">
                                                        <?= $val2['name'] ?>
                                                    </div>
                                                    <div class="body text-select">
                                                        <?
                                                        foreach ($val2['values'] as $cell3 => $value):
                                                            $id = 'selector_' . $val2['id'] . '_' . $cell3;
                                                            $selectorId = 'selector_' . $val2['id'];
                                                            if ($arResult['selected'][$selectorId] == $id
                                                                || (!$arResult['selected'][$selectorId] && $value['default'])
                                                            ) {
                                                                $addSelected = 'checked = "checked"';
                                                            } else {
                                                                $addSelected = '';
                                                            }
                                                            ?>
                                                            <div>
                                                                <input type="radio" name="selector_<?= $val2['id'] ?>"
                                                                       id="<?= $id ?>" <?= $addSelected ?>/>
                                                                <label for="<?= 'selector_' . $val2['id'] . '_' . $cell3 ?>">
                                                                    <nobr> <?= $value['name'] ?></nobr>
                                                                </label>
                                                            </div>
                                                        <? endforeach; ?>
                                                    </div>
                                                    <?
                                                    break;

                                                case 'img-select':
                                                    $addSubtype = $val2['subtype'] ? " " . $val2['subtype'] : "";
                                                    ?>
                                                    <div class="caption">
                                                        <?= $val2['name'] ?>
                                                    </div>
                                                    <div class="body img-select<?= $addSubtype ?>">
                                                        <?
                                                        $selectorId = 'selector_' . $val2['id']; ?>
                                                        <input type="hidden" name="<?= $selectorId ?>" value="">
                                                        <?
                                                        foreach ($val2['values'] as $cell3 => $value):
                                                            $id = 'selector_' . $val2['id'] . '_' . $cell3;

                                                            if ($arResult['selected'][$selectorId] == $id
                                                                || (!$arResult['selected'][$selectorId] && $value['default'])
                                                            ) {
                                                                $addSelected = ' active';
                                                            } else {
                                                                $addSelected = '';
                                                            }
                                                            ?>
                                                            <div class="template-box<?= $addSelected ?>"
                                                                 data-item="<?= $id ?>"
                                                                 data-parent="<?= $selectorId ?>">
                                                                <div class="template-img"><img
                                                                            src="<?= $value['picture'] ?>" alt=""></div>
                                                                <div class="template-descr"><?= $value['name'] ?></div>
                                                            </div>
                                                        <? endforeach; ?>
                                                    </div>
                                                    <?
                                                    break;

                                                default:

                                                    break;
                                            }
                                        }
                                        ?>
                                    </div>
                                <? endforeach ?>
                            </div>
                        <? endforeach; ?>
                    </div>

                <? endif; ?>
                <? if (!$arResult['AJAX_MODE']): ?>
            </div>
            <div class="gearbuttons">
                <div class="btn-gear btn-start"><i class="fa fa-cogs"></i></div>
                <?if ($arParams['USE_SHARE'] == 'Y'):?>
                    <div class="btn-gear btn-share"><i class="fa fa-paper-plane"></i></div>
                <?endif;?>
                <div class="btn-gear btn-document"><i class="fa fa-id-card"></i></div>
            </div>
        </div>

        <div class="gear-share">
            <div class="gear-box">
                <div class="head_gear">
                    <div class="title">
                        <?= Loc::getMessage("SHARE"); ?>
                    </div>
                    <div class="btn-close-share"><i class="fa fa-close"></i> <?= Loc::getMessage("BXR_CLOSE"); ?></div>
                </div>
                <div class="gear-box-content">
                    <div class="share-text">
                        <span class="share-quote"><?= Loc::getMessage("BXR_PANEL_TEXT1"); ?></span>
                        <span class="share-description"><?= Loc::getMessage("BXR_PANEL_TEXT2"); ?></span>
                        <div class="share-link">
                            <div class="share-copylink"><span class="fa fa-link"></span></div>
                            <?
                                $CURRENT_PAGE = (CMain::IsHTTPS()) ? "https://" : "http://";
                                $CURRENT_PAGE .= $_SERVER["HTTP_HOST"];
                                $CURRENT_PAGE .= "/";
                                
                                if(!empty(\Alexkova\Bxready2\Bxready::getInstance()->getUser()))
                                    $CURRENT_PAGE .= "?svisual_id=".\Alexkova\Bxready2\Bxready::getInstance()->getUser();
                            ?>
                            <input class="share-copyinput" type="text" value="<?=$CURRENT_PAGE?>" readonly></div>
                        <div class='copied'></div>
                        <span class="share-description"><?= Loc::getMessage("BXR_PANEL_TEXT3"); ?></span>
                        <div class="share-icon">
                            <div class="pluso" data-background="transparent"
                                 data-options="big,square,line,horizontal,nocounter,theme=01"
                                 data-services="vkontakte,odnoklassniki,facebook,twitter,google,moimir,email"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="gear-document">
            <div class="gear-box">
                <div class="head_gear">
                    <div class="title">
                        <?= Loc::getMessage("SHARE"); ?>
                    </div>
                    <div class="btn-close-document"><i class="fa fa-close"></i> <?= Loc::getMessage("BXR_CLOSE"); ?></div>
                </div>
                <div class="gear-box-content">

                    <div class="link-box">

                        <a href="http://blog.bxready.ru/blog/">
                            <div class="link-img">
                                <img src="<?= $templateFolder ?>/img/img_doc01.jpg" alt="<?= Loc::getMessage("BXR_PANEL_TEXT10"); ?>">
                            </div>
                            <div class="link-description">
                                <span><?= Loc::getMessage("BXR_PANEL_TEXT4"); ?></span>
                            </div>
                        </a>
                    </div>


                    <div class="link-box">
                        <a href="https://docs.kuznica74.ru/documentation/course/course22/index">
                            <div class="link-img">
                                <img src="<?= $templateFolder ?>/img/img_doc02.jpg" alt="<?= Loc::getMessage("BXR_PANEL_TEXT7"); ?>">
                            </div>
                            <div class="link-description">
                                <span><?= Loc::getMessage("BXR_PANEL_TEXT5"); ?></span>
                            </div>
                        </a>
                    </div>


                    <div class="link-box">
                        <a href="http://support.kuznica74.ru/">
                            <div class="link-img">
                                <img src="<?= $templateFolder ?>/img/img_doc03.jpg" alt="<?= Loc::getMessage("BXR_PANEL_TEXT8"); ?>">
                            </div>
                            <div class="link-description">
                                <span><?= Loc::getMessage("BXR_PANEL_TEXT6"); ?></span>
                            </div>
                        </a>

                    </div>

                    <div class="link-social">
                        <a href="https://vk.com/bxready">
                            <div class="link-icon vk"><span class="fa  fa-vk"></span></div>
                        </a>
                        <a href="https://www.facebook.com/bxready/">
                            <div class="link-icon facebook"><span class="fa  fa-facebook-f"></span></div>
                        </a>
                        <a href="https://twitter.com/alex_kova">
                            <div class="link-icon twitter"><span class="fa  fa-twitter"></span></div>
                        </a>
                        <a href="https://www.youtube.com/user/AlexeyKovalenko/videos">
                            <div class="link-icon youtube"><span class="fa   fa-youtube"></span></div>
                        </a>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <script>
        $(document).ready(function () {
            gearBXR24Control = new gearBXR24Control({
                ajaxUrl: "<?=$arResult['AJAX_URL']?>",
                <?if ($arResult['SHOW']):?>
                downloadAjax: true,
                <?else:?>
                downloadAjax: false,
                <?endif;?>
                timeReload: 1000,
                objName: 'gearBXR24Control',
                postData: {
                    siteId: "<?=SITE_ID?>",
                    template: "<?=$signedTemplate?>",
                    parameters: "<?=$signedParams?>",
                    siteTemplate: "<?=SITE_TEMPLATE_ID?>"
                },
                currentTab: '<?=$arResult['TAB']?>',
                selected: <?=json_encode($arResult['selected'])?>,
                sessid: '<?=bitrix_sessid()?>'
            });

            gearBXR24Control.init();
        });

    </script>
<? endif; ?>
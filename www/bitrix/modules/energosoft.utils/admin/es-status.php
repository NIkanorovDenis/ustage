<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
IncludeModuleLangFile(__FILE__);

GLOBAL $USER, $DB;
if(!$USER->IsAdmin()) return;
CModule::IncludeModule("energosoft.utils");
CModule::IncludeModule("iblock");
CModule::IncludeModule("currency");

// $arUsd = CCurrencyRates::GetList($by='id', $order='desc', array("CURRENCY"=>"USD"))->Fetch();

$arStatus = ESUtils::LoadOption("status");
$arStatusRun = ESUtils::LoadOption("status-run");
$arColumns = ESUtils::LoadOption("columns");
$arColumnsUsd = ESUtils::LoadOption("columns_usd");

if($_GET["action"] == "status_start")
{
    define("STOP_STATISTICS", true);
    $APPLICATION->RestartBuffer();

    if($arStatus["RUN"]=="STOP"||$arStatus["RUN"]=="")
    {
        $arStatus = array();
        $arStatus["RUN"] = "START";
        $arStatus["LOG"] = array();
        ESUtils::SaveOption("status", $arStatus);
        ESUtils::SaveOption("status-run", array());
        die("OK");
    }
    else die("Процесс уже запущен...");
}

if($_POST["action"] == "columns")
{
    define("STOP_STATISTICS", true);
    $APPLICATION->RestartBuffer();

    $arColumns = array();
    $arColumns["NAME"] = intval($_POST["COL_NAME"]);
    $arColumns["PRICE"] = intval($_POST["COL_PRICE"]);
    $arColumns["QUANTITY"] = intval($_POST["COL_QUANTITY"]);
    ESUtils::SaveOption("columns", $arColumns);
    die("OK");
}

if($_POST["action"] == "columns_usd")
{
  define("STOP_STATISTICS", true);
  $APPLICATION->RestartBuffer();

  $arColumnsUsd = array();
  $arColumnsUsd["NAME"] = intval($_POST["COL_NAME_USD"]);
  $arColumnsUsd["PRICE"] = intval($_POST["COL_PRICE_USD"]);
  $arColumnsUsd["QUANTITY"] = intval($_POST["COL_QUANTITY_USD"]);
  ESUtils::SaveOption("columns_usd", $arColumnsUsd);
  die("OK");
}

$e = "";
$f = $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/energosoft.utils/tmp/al_price";
$f_usd = $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/energosoft.utils/tmp/al_price_usd";

if ($_POST["action"] == "save-price" && check_bitrix_sessid()) {
  if($_FILES["AL_PRICE"]["error"] === 0)
  {
    $arPathInfo = pathinfo($_FILES["AL_PRICE"]["name"]);
    if(ToLower($arPathInfo["extension"]) != "csv") $e = "Тип файла должен быть CSV";

    if($e == "")
    {
      move_uploaded_file($_FILES["AL_PRICE"]["tmp_name"], $f);
      $fe = file_get_contents($f);
      file_put_contents($f, iconv("WINDOWS-1251", "UTF8", $fe));
    }
  }

  if($_FILES["AL_PRICE_USD"]["error"] === 0)
  {
    $arPathInfo = pathinfo($_FILES["AL_PRICE_USD"]["name"]);
    if(ToLower($arPathInfo["extension"]) != "csv") $e = "Тип файла должен быть CSV";

    if($e == "")
    {
      move_uploaded_file($_FILES["AL_PRICE_USD"]["tmp_name"], $f_usd);
      $fe = file_get_contents($f_usd);
      file_put_contents($f_usd, iconv("WINDOWS-1251", "UTF8", $fe));
    }
  }

  LocalRedirect($APPLICATION->GetCurPageParam());
}

//$aTabs = array(
//    array("DIV" => "edit1", "TAB" => "Парсинг и обновление", "ICON" => "main_user_edit", "TITLE" => "Парсинг и обновление"),
//    array("DIV" => "edit2", "TAB" => "EDS", "ICON" => "main_user_edit", "TITLE" => "Журнал" ),
//    array("DIV" => "edit3", "TAB" => "RiggerShop", "ICON" => "main_user_edit", "TITLE" => "Журнал"),
//    array("DIV" => "edit4", "TAB" => "AnzheeLight", "ICON" => "main_user_edit", "TITLE" => "Журнал"),
//    array("DIV" => "edit5", "TAB" => "OknaAudio", "ICON" => "main_user_edit", "TITLE" => "Журнал"),
//	array("DIV" => "edit6", "TAB" => "GlobalEffects", "ICON" => "main_user_edit", "TITLE" => "Журнал"),
//	array("DIV" => "edit7", "TAB" => "Showatelier", "ICON" => "main_user_edit", "TITLE" => "Журнал"),
//    array("DIV" => "edit8", "TAB" => "Invask", "ICON" => "main_user_edit", "TITLE" => "Журнал"),
//    array("DIV" => "edit9", "TAB" => "Slami", "ICON" => "main_user_edit", "TITLE" => "Журнал"),
//);
//$tabControl = new CAdminTabControl("tabControl", $aTabs, false);

$APPLICATION->SetTitle("Парсинг и обновление");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");
/*
$arElements = array();
$obElement = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>32,'PROPERTY_UPLOADED_FROM_PAGE'=>'%riggershop.ru%'), false, false, array('ID', 'NAME'));
while($arItem = $obElement->Fetch()) $arElements[] = $arItem;

$arOffers = array();
foreach($arElements as $k=>$arElement)
{
    $obElement = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>33,'PROPERTY_CML2_LINK'=>$arElement["ID"]), false, false, array('ID', 'NAME'));
    while($arItem = $obElement->Fetch()) $arOffers[] = $arItem["ID"];
}
foreach($arOffers as $id) CIBlockElement::Delete($id);
*/
?>
    <script type="text/javascript" src="/bitrix/js/main/jquery/jquery-2.1.3.min.js"></script>
    <div class="adm-detail-tabs-block" id="tabControl_tabs" style="left: 0px;">
        <style>
            .adm-detail-tab.adm-detail-tab-active {
                background-position: 0 -2473px;
                color: #000;
                margin: 4px 6px 8px 0;
                height: 26px;
                padding-top: 13px;
                position: relative;
                cursor: default;
                z-index: 2;
            }
            .adm-detail-tab{
                text-decoration: none;
            }
        </style>
        <a href="/bitrix/admin/es-status.php?lang=ru" title="Журнал"  class="adm-detail-tab <?= (!isset($_GET['parser'])) ? 'adm-detail-tab-active' : '' ?>">Парсинг и обновление</a>
        <a href="/bitrix/admin/es-status.php?lang=ru&parser=eds" title="Журнал"  class="adm-detail-tab <?= (isset($_GET['parser']) && $_GET['parser'] == 'eds') ? 'adm-detail-tab-active' : '' ?>">EDS</a>
        <a href="/bitrix/admin/es-status.php?lang=ru&parser=riggershop"  title="Журнал"  class="adm-detail-tab <?= (isset($_GET['parser']) && $_GET['parser'] == 'riggershop') ? 'adm-detail-tab-active' : '' ?>">RiggerShop</a>
        <a href="/bitrix/admin/es-status.php?lang=ru&parser=anzhee"  title="Журнал"  class="adm-detail-tab <?= (isset($_GET['parser']) && $_GET['parser'] == 'anzhee') ? 'adm-detail-tab-active' : '' ?>">AnzheeLight</a>
        <a href="/bitrix/admin/es-status.php?lang=ru&parser=oknaaudio"  title="Журнал"  class="adm-detail-tab <?= (isset($_GET['parser']) && $_GET['parser'] == 'oknaaudio') ? 'adm-detail-tab-active' : '' ?>">OknaAudio</a>
        <a href="/bitrix/admin/es-status.php?lang=ru&parser=globaleffects"  title="Журнал"  class="adm-detail-tab <?= (isset($_GET['parser']) && $_GET['parser'] == 'globaleffects') ? 'adm-detail-tab-active' : '' ?>">GlobalEffects</a>
        <a href="/bitrix/admin/es-status.php?lang=ru&parser=showatelier"  title="Журнал"  class="adm-detail-tab <?= (isset($_GET['parser']) && $_GET['parser'] == 'showatelier') ? 'adm-detail-tab-active' : '' ?>">Showatelier</a>
        <a href="/bitrix/admin/es-status.php?lang=ru&parser=invask"  title="Журнал"  class="adm-detail-tab <?= (isset($_GET['parser']) && $_GET['parser'] == 'invask') ? 'adm-detail-tab-active' : '' ?>">Invask</a>
        <a href="/bitrix/admin/es-status.php?lang=ru&parser=slami"  title="Журнал"  class="adm-detail-tab adm-detail-tab-last <?= (isset($_GET['parser']) && $_GET['parser'] == 'slami') ? 'adm-detail-tab-active' : '' ?>">Slami</a>
        <a href="/bitrix/admin/es-status.php?lang=ru&parser=ltm"  title="Журнал"  class="adm-detail-tab adm-detail-tab-last <?= (isset($_GET['parser']) && $_GET['parser'] == 'ltm') ? 'adm-detail-tab-active' : '' ?>">LTM</a>
		<a href="/bitrix/admin/es-status.php?lang=ru&parser=imlight"  title="Журнал"  class="adm-detail-tab adm-detail-tab-last <?= (isset($_GET['parser']) && $_GET['parser'] == 'imlight') ? 'adm-detail-tab-active' : '' ?>">ImLight</a>
    </div>
    <div class="adm-detail-content-wrap">

        <form method="POST" action="<?=$APPLICATION->GetCurPageParam()?>" enctype="multipart/form-data">
            <?=bitrix_sessid_post();?>
            <input type="hidden" name="action" value="save-price"/>
            <?//$tabControl->Begin();?>
            <?//$tabControl->BeginNextTab();?>
           <div class="adm-detail-content-item-block">
                <table style="width: 100%;">
                    <tbody>
                        <?php if (isset($_GET['parser']) && $_GET['parser'] == 'eds'): ?>
                            <tr class="adm-detail-required-field">
                                <td>
                                    <?if(count($arStatus["LOG_EDS"]) > 0):?>
                                        <table width="100%" cellspacing="2" cellpadding="4" border="1" style="border-collapse:collapse;">
                                            <tr>
                                                <td><b>Дата</b></td>
                                                <td><b>Ссылка</b></td>
                                                <td><b>Статус</b></td>
                                            </tr>

                                            <?foreach($arStatus["LOG_EDS"] as $arItem):?>
                                                <tr>
                                                    <td><nobr><?=date("d.m.Y H:i:s", $arItem["DATE"])?></nobr></td>
                                                    <td><a href="<?=$arItem["URL"]?>"><?=$arItem["URL"]?></a></td>
                                                    <td><nobr><?=$arItem["STATUS"]?></nobr></td>
                                                </tr>
                                            <?endforeach;?>
                                        </table>
                                    <?endif;?>
                                </td>
                            </tr>
                        <?php elseif (isset($_GET['parser']) && $_GET['parser'] == 'riggershop'): ?>
                            <tr class="adm-detail-required-field">
                                <td>
                                    <?if(count($arStatus["LOG_RIGGER"]) > 0):?>
                                        <table width="100%" cellspacing="2" cellpadding="4" border="1" style="border-collapse:collapse;">
                                            <tr>
                                                <td><b>Дата</b></td>
                                                <td><b>Ссылка</b></td>
                                                <td><b>Код HTTP</b></td>
                                                <td><b>Статус</b></td>
                                            </tr>
                                            <?foreach($arStatus["LOG_RIGGER"] as $arItem):?>
                                                <?if(count($arItem["OFFERS"]) > 0):?>
                                                    <tr>
                                                        <td><nobr><?=date("d.m.Y H:i:s", $arItem["DATE"])?></nobr></td>
                                                        <td><a href="<?=$arItem["URL"]?>"><?=$arItem["URL"]?></a></td>
                                                        <td><?=$arItem["HTTP_CODE"]?></td>
                                                        <td></td>
                                                    </tr>
                                                    <?foreach($arItem["OFFERS"] as $arOffer):?>
                                                        <tr>
                                                            <td><nobr><?=date("d.m.Y H:i:s", $arItem["DATE"])?></nobr></td>
                                                            <td><?=$arOffer["NAME"]?></td>
                                                            <td></td>
                                                            <td><nobr><?=$arOffer["STATUS"]?></nobr></td>
                                                        </tr>
                                                    <?endforeach;?>
                                                <?else:?>
                                                    <tr>
                                                        <td><nobr><?=date("d.m.Y H:i:s", $arItem["DATE"])?></nobr></td>
                                                        <td><a href="<?=$arItem["URL"]?>"><?=$arItem["URL"]?></a></td>
                                                        <td><?=$arItem["HTTP_CODE"]?></td>
                                                        <td><nobr><?=$arItem["STATUS"]?></nobr></td>
                                                    </tr>
                                                <?endif;?>
                                            <?endforeach;?>
                                        </table>
                                    <?endif;?>
                                </td>
                            </tr>
                        <?php elseif (isset($_GET['parser']) && $_GET['parser'] == 'anzhee'): ?>
                            <tr class="adm-detail-required-field">
                                <td>
                                    <?if(count($arStatus["LOG_ANZHEE"]) > 0):?>
                                        <table width="100%" cellspacing="2" cellpadding="4" border="1" style="border-collapse:collapse;">
                                            <tr>
                                                <td><b>Дата</b></td>
                                                <td><b>Товар</b></td>
                                                <td><b>Ссылка</b></td>
                                                <td><b>Код HTTP</b></td>
                                                <td><b>Статус</b></td>
                                                <td><b>Источник</b></td>
                                            </tr>
                                            <?foreach($arStatus["LOG_ANZHEE"] as $arItem):?>
                                                <tr>
                                                    <td><nobr><?=date("d.m.Y H:i:s", $arItem["DATE"])?></nobr></td>
                                                    <td><?=$arItem["LINK"]?></td>
                                                    <td><a href="<?=$arItem["URL"]?>"><?=$arItem["URL"]?></a></td>
                                                    <td><?=$arItem["HTTP_CODE"]?></td>
                                                    <td><nobr><?=$arItem["STATUS"]?></nobr></td>
                                                    <td><?=$arItem["PRICE_LIST"]?></td>
                                                </tr>
                                            <?endforeach;?>
                                        </table>
                                    <?endif;?>
                                </td>
                            </tr>
                        <?php elseif (isset($_GET['parser']) && $_GET['parser'] == 'oknaaudio'): ?>
                            <tr class="adm-detail-required-field">
                                <td>
                                    <?if(count($arStatus["LOG_OKNAAUDIO"]) > 0):?>
                                        <table width="100%" cellspacing="2" cellpadding="4" border="1" style="border-collapse:collapse;">
                                            <tr>
                                                <td><b>Дата</b></td>
                                                <td><b>Ссылка</b></td>
                                                <td><b>Код HTTP</b></td>
                                                <td><b>Статус</b></td>
                                            </tr>
                                            <?foreach($arStatus["LOG_OKNAAUDIO"] as $arItem):?>
                                                <tr>
                                                    <td><nobr><?=date("d.m.Y H:i:s", $arItem["DATE"])?></nobr></td>
                                                    <td><a href="<?=$arItem["URL"]?>"><?=$arItem["URL"]?></a></td>
                                                    <td><?=$arItem["HTTP_CODE"]?></td>
                                                    <td><nobr><?=$arItem["STATUS"]?></nobr></td>
                                                </tr>
                                            <?endforeach;?>
                                        </table>
                                    <?endif;?>
                                </td>
                            </tr>
                        <?php elseif (isset($_GET['parser']) && $_GET['parser'] == 'globaleffects'): ?>
                            <tr class="adm-detail-required-field">
                            <td>
                                <?if(count($arStatus["LOG_GLOBALEFFECTS"]) > 0):?>
                                    <table width="100%" cellspacing="2" cellpadding="4" border="1" style="border-collapse:collapse;">
                                        <tr>
                                            <td><b>Дата</b></td>
                                            <td><b>Товар</b></td>
                                            <td><b>Ссылка</b></td>
                                            <td><b>Код HTTP</b></td>
                                            <td><b>Статус</b></td>
                                            <td><b>Источник</b></td>
                                        </tr>
                                        <?foreach($arStatus["LOG_GLOBALEFFECTS"] as $arItem):?>
                                            <tr>
                                                <td><nobr><?=date("d.m.Y H:i:s", $arItem["DATE"])?></nobr></td>
                                                <td><?=$arItem["LINK"]?></td>
                                                <td><a href="<?=$arItem["URL"]?>"><?=$arItem["URL"]?></a></td>
                                                <td><?=$arItem["HTTP_CODE"]?></td>
                                                <td><nobr><?=$arItem["STATUS"]?></nobr></td>
                                                <td><?=$arItem["PRICE_LIST"]?></td>
                                            </tr>
                                        <?endforeach;?>
                                    </table>
                                <?endif;?>
                            </td>
                        </tr>
                        <?php elseif (isset($_GET['parser']) && $_GET['parser'] == 'invask'): ?>
                            <tr class="adm-detail-required-field">
                                <td>
                                    <?if(count($arStatus["LOG_INVASK"]) > 0):?>
                                        <table width="100%" cellspacing="2" cellpadding="4" border="1" style="border-collapse:collapse;">
                                            <tr>
                                                <td><b>Дата</b></td>
                                                <td><b>Ссылка</b></td>
                                                <td><b>Код HTTP</b></td>
                                                <td><b>Статус</b></td>
                                            </tr>
                                            <?foreach($arStatus["LOG_INVASK"] as $arItem):?>
                                                <tr>
                                                    <td><nobr><?=date("d.m.Y H:i:s", $arItem["DATE"])?></nobr></td>
                                                    <td><a href="<?=$arItem["URL"]?>"><?=$arItem["URL"]?></a></td>
                                                    <td><?=$arItem["HTTP_CODE"]?></td>
                                                    <td><nobr><?=$arItem["STATUS"]?></nobr></td>
                                                </tr>
                                            <?endforeach;?>
                                        </table>
                                    <?endif;?>
                                </td>
                            </tr>
                        <?php elseif (isset($_GET['parser']) && $_GET['parser'] == 'showatelier'): ?>
                            <tr class="adm-detail-required-field">
                                <td>
                                    <?if(count($arStatus["LOG_SHOWATELIER"]) > 0):?>
                                        <table width="100%" cellspacing="2" cellpadding="4" border="1" style="border-collapse:collapse;">
                                            <tr>
                                                <td><b>Дата</b></td>
                                                <td><b>Ссылка</b></td>
                                                <td><b>Код HTTP</b></td>
                                                <td><b>Статус</b></td>
                                            </tr>
                                            <?foreach($arStatus["LOG_SHOWATELIER"] as $arItem):?>
                                                <tr>
                                                    <td><nobr><?=date("d.m.Y H:i:s", $arItem["DATE"])?></nobr></td>
                                                    <td><a href="<?=$arItem["URL"]?>"><?=$arItem["URL"]?></a></td>
                                                    <td><?=$arItem["HTTP_CODE"]?></td>
                                                    <td><nobr><?=$arItem["STATUS"]?></nobr></td>
                                                </tr>
                                            <?endforeach;?>
                                        </table>
                                    <?endif;?>
                                </td>
                            </tr>
                        <?php elseif (isset($_GET['parser']) && $_GET['parser'] == 'slami'): ?>
                            <tr class="adm-detail-required-field">
                                <td>
                                    <?if(count($arStatus["LOG_SLAMI"]) > 0):?>
                                        <table width="100%" cellspacing="2" cellpadding="4" border="1" style="border-collapse:collapse;">
                                            <tr>
                                                <td><b>Дата</b></td>
                                                <td><b>Товар</b></td>
                                                <td><b>Ссылка</b></td>
                                                <td><b>Код HTTP</b></td>
                                                <td><b>Источник</b></td>
                                            </tr>
                                            <?foreach($arStatus["LOG_SLAMI"] as $arItem):?>
                                                <tr>
                                                    <td><nobr><?=date("d.m.Y H:i:s", $arItem["DATE"])?></nobr></td>
                                                    <td><?=$arItem["LINK"]?></td>
                                                    <td><a href="<?=$arItem["URL"]?>"><?=$arItem["URL"]?></a></td>
                                                    <td><?=$arItem["HTTP_CODE"]?></td>
                                                    <td><?=$arItem["PRICE_LIST"]?></td>
                                                </tr>
                                            <?endforeach;?>
                                        </table>
                                    <?endif;?>
                                </td>
                            </tr>
                        <?php elseif (isset($_GET['parser']) && $_GET['parser'] == 'ltm'): ?>
                            <tr class="adm-detail-required-field">
                                <td>
                                    <?if(count($arStatus["LOG_LTM"]) > 0):?>
                                        <table width="100%" cellspacing="2" cellpadding="4" border="1" style="border-collapse:collapse;">
                                            <tr>
                                                <td><b>Дата</b></td>
                                                <td><b>Товар</b></td>
                                                <td><b>Ссылка</b></td>
                                                <td><b>Код HTTP</b></td>
                                                <td><b>Статус</b></td>
                                                <td><b>Источник</b></td>
                                            </tr>
                                            <?foreach($arStatus["LOG_LTM"] as $arItem):?>
                                                <tr>
                                                    <td><nobr><?=date("d.m.Y H:i:s", $arItem["DATE"])?></nobr></td>
                                                    <td><?=$arItem["LINK"]?></td>
                                                    <td><a href="<?=$arItem["URL"]?>"><?=$arItem["URL"]?></a></td>
                                                    <td><?=$arItem["HTTP_CODE"]?></td>
                                                    <td><nobr><?=$arItem["STATUS"]?></nobr></td>
                                                    <td><?=$arItem["PRICE_LIST"]?></td>
                                                </tr>
                                            <?endforeach;?>
                                        </table>
                                    <?endif;?>
                                </td>
                            </tr>
							<?php elseif (isset($_GET['parser']) && $_GET['parser'] == 'imlight'): ?>
                            <tr class="adm-detail-required-field">
                                <td>
                                    <?if (!empty($arStatus["LOG_IMLIGHT"]) && count($arStatus["LOG_IMLIGHT"]) > 0):?>
                                        <table width="100%" cellspacing="2" cellpadding="4" border="1" style="border-collapse:collapse;">
                                            <tr>
                                                <td><b>Дата</b></td>
                                                <td><b>Товар</b></td>
                                                <td><b>Ссылка</b></td>
                                                <td><b>Код HTTP</b></td>
                                                <td><b>Статус</b></td>
                                            </tr>
                                            <?foreach($arStatus["LOG_IMLIGHT"] as $arItem):?>
                                                <tr>
                                                    <td><nobr><?=date("d.m.Y H:i:s", $arItem["DATE"])?></nobr></td>
                                                    <td><?=$arItem["LINK"]?></td>
                                                    <td><a href="<?=$arItem["URL"]?>"><?=$arItem["URL"]?></a></td>
                                                    <td><?=$arItem["HTTP_CODE"]?></td>
                                                    <td><nobr><?=$arItem["STATUS"]?></nobr></td>
                                                </tr>
                                            <?endforeach;?>
                                        </table>
                                    <?endif;?>
                                </td>
                            </tr>
                        <?php else: ?>
                            <tr class="adm-detail-required-field">
                                <td>
                                    <table width="100%" cellspacing="2" cellpadding="4" border="1" style="border-collapse:collapse;">
                                        <tr>
                                            <td><b>Парсер</b></td>
                                            <td><b>Последняя обработка</b></td>
                                            <td><b>Кол-во обновленных товаров</b></td>
                                        </tr>

                                        <?foreach($arStatus as $key => $arItem):?>
                                            <?php if ($key != 'RUN'): ?>
                                                <tr>
                                                    <?php $parser_count = sizeof($arItem) ; ?>
                                                    <td><nobr><?= str_replace('LOG_', '', $key) ?></nobr></td>
                                                    <td><?= date("d.m.Y H:i:s", $arItem[$parser_count-1]["DATE"]) ?></td>
                                                    <td><nobr><?=$parser_count?></nobr></td>
                                                </tr>
                                            <?php endif; ?>
                                        <?endforeach;?>
                                    </table>
                                    <br>
                                    <br>
                                </td>
                            </tr>
                            <tr class="adm-detail-required-field">
                                <td>
                                    <table cellspacing="2" cellpadding="4" border="1" style="border-collapse:collapse;">
                                        <tr>
                                            <td><b>Статус:</b></td>
                                            <td>


                                                <?php 
                                                    if($_GET['test']){
                                                        var_dump($arStatus["RUN"]);
                                                    }
                                                
                                                
                                                ?>
                                                <b>
                                                    <?if($arStatus["RUN"]=="START"):?><span style="color:green;">запускается</span><?endif;?>
                                                    <?if($arStatus["RUN"]=="STOP"||$arStatus["RUN"]==""):?><span style="color:red;">остановлен</span><?endif;?>
                                                    <?if($arStatus["RUN"]=="RUN"):?><span style="color:green;">работает</span><?endif;?>
                                                </b>
                                            </td>
                                        </tr>
                                    </table>

                                    <?if($arStatus["RUN"]=="RUN" && count($arStatusRun) > 0):?>
                                        <br/>
                                        <table width="100%" cellspacing="2" cellpadding="4" border="1" style="border-collapse:collapse;">
                                            <tr>
                                                <td width="8%"><b>Парсер:</b></td>
                                                <td><?=$arStatusRun["ID"]?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Ссылка:</b></td>
                                                <td><?=$arStatusRun["URL"]?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Состояние:</b></td>
                                                <td><?=$arStatusRun["CNT"]?></td>
                                            </tr>
                                        </table>
                                    <?endif;?>

                                    <?if($arStatus["RUN"]=="STOP"||$arStatus["RUN"]=="" || !empty($_GET['test'])):?>
                                        <br/>
                                        <input class="adm-btn-save" style="color:red;" type="button" value="Запустить обновление кол-во" onclick="ESCronStatusStart(this);"/>									
                                        <br/>
                                        <br/>
										
										<? /* ?>
                                        <hr>
                                        <br/>
                                        <div style='margin-bottom: 9px;'>Файл с ценами:</div>
                                        <?=CFile::InputFile("AL_PRICE", 0, 0)?>

                                        <br/><br/>
                                        <input class="adm-btn" type="submit" value="Загрузить прайс лист AnzheeLight"/>
                                        <?if(file_exists($f)):?>
                                            <br/>
                                            <br/>
                                            <span><b>Последний прайс-лист был загружен: <?=date("d.m.Y H:i:s", filemtime($f))?></b></span>
                                        <?endif;?>
                                        <?
                                        $arPriceList = ESParser::AnzheePriceList();
                                        $arPriceListColumns = ESParser::AnzheePriceListColumns();
                                        ?>
                                        <br/>
                                        <br/>
                                        <hr></hr>
                                        <table cellspacing="0" cellpadding="4" border="0">
                                            <tr>
                                                <td>Наименование:</td>
                                                <td>
                                                    <select id="COL_NAME" name="COL_NAME">
                                                        <option value="">(не указано)</option>
                                                        <?foreach($arPriceListColumns as $k=>$v):?>
                                                            <?$k = intval($k) + 1?>
                                                            <?php if ($v) : ?>
                                                                <option value="<?=$k?>"<?=$arColumns["NAME"]==$k?" selected":""?>><?=$v?></option>
                                                            <?php endif; ?>
                                                        <?endforeach;?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Цена:</td>
                                                <td>
                                                    <select id="COL_PRICE" name="COL_PRICE">
                                                        <option value="">(не указано)</option>
                                                        <?foreach($arPriceListColumns as $k=>$v):?>
                                                            <?$k = intval($k) + 1?>
                                                            <option value="<?=$k?>"<?=$arColumns["PRICE"]==$k?" selected":""?>><?=$v?></option>
                                                        <?endforeach;?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Кол-во:</td>
                                                <td>
                                                    <select id="COL_QUANTITY" name="COL_QUANTITY">
                                                        <option value="">(не указано)</option>
                                                        <?foreach($arPriceListColumns as $k=>$v):?>
                                                            <?$k = intval($k) + 1?>
                                                            <option value="<?=$k?>"<?=$arColumns["QUANTITY"]==$k?" selected":""?>><?=$v?></option>
                                                        <?endforeach;?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td align="right">
                                                    <input class="adm-btn" type="button" value="Сохранить" onclick="ESSaveColumns(this);"/>
                                                </td>
                                            </tr>
                                        </table><br/>

                                        <?if(count($arPriceList)):?>
                                            <hr>
                                            <br/>
                                            <table width="100%" cellspacing="2" cellpadding="4" border="1" style="border-collapse:collapse;">
                                                <tr>
                                                    <td><b>Товар (<?=count($arPriceList)?> записей)</b></td>
                                                    <td><b>GUID</b></td>
                                                    <td><b>Цена в рублях</b></td>
                                                    <td><b>Кол-во</b></td>
                                                </tr>
                                                <?foreach($arPriceList as $k=>$arPrice):?>
                                                    <tr>
                                                        <td><?=$arPrice["N"]?></td>
                                                        <td><?=$arPrice["G"]?></td>
                                                        <td><?=floatval($arPrice["P"])?></td>
                                                        <td><?=intval($arPrice["Q"])?></td>
                                                    </tr>
                                                <?endforeach;?>
                                            </table>
                                        <?endif;?>
									<? */ ?>
									
                                    <?endif;?>									
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
           </div>

                <?//$tabControl->Buttons();?>
                <?//$tabControl->End();?>
        </form>

    </div>
    <script>
    function ESCronStatusStart(e)
    {
        if(!confirm($(e).val()+"?")) return;
        $(e).hide();
        $.get("<?=$APPLICATION->GetCurPageParam()?>&action=status_start", function(r)
        {
            if(r != "OK")
            {
                $(e).hide();
                alert(r);
            }
            else location.reload();
        });
    };
    function ESSaveColumns(e)
    {
        $(e).hide();
        $.post("<?=$APPLICATION->GetCurPageParam()?>",
            {
            action:"columns",
            COL_NAME:$("#COL_NAME").val(),
            COL_PRICE:$("#COL_PRICE").val(),
            COL_QUANTITY:$("#COL_QUANTITY").val()
            }, function(r)
        {
            if(r != "OK")
            {
                $(e).hide();
                alert(r);
            }
            else location.reload();
        });
    };
    function ESSaveColumnsUsd(e)
    {
      $(e).hide();
      $.post("<?=$APPLICATION->GetCurPageParam()?>",
        {
          action:"columns_usd",
          COL_NAME_USD:$("#COL_NAME_USD").val(),
          COL_PRICE_USD:$("#COL_PRICE_USD").val(),
          COL_QUANTITY_USD:$("#COL_QUANTITY_USD").val()
        }, function(r)
        {
          if(r != "OK")
          {
            $(e).hide();
            alert(r);
          }
          else location.reload();
        });
    };

    </script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");?>

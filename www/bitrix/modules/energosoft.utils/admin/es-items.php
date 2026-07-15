<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
IncludeModuleLangFile(__FILE__);

GLOBAL $USER, $DB;
if(!$USER->IsAdmin()) return;
CModule::IncludeModule("energosoft.utils");
CModule::IncludeModule("catalog");
CModule::IncludeModule("iblock");

$aTabs = array(
    array("DIV" => "edit1", "TAB" => "Товары добавленные вручную", "ICON" => "main_user_edit", "TITLE" => "Товары добавленные вручную"),
    array("DIV" => "edit2", "TAB" => "Привязка товара", "ICON" => "main_user_edit", "TITLE" => "Привязка товара"),
);
$tabControl = new CAdminTabControl("tabControl", $aTabs);

$arStore = array();
$rsStore = CCatalogStoreProduct::GetList(array(), array("STORE_ID"=>array(5,6)), false, false, array('PRODUCT_ID', 'STORE_ID', 'AMOUNT'));
while($arItem = $rsStore->Fetch()) $arStore[$arItem["PRODUCT_ID"]][$arItem["STORE_ID"]] = $arItem["AMOUNT"];

$arOffers = array();
$obOffers = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>33), false, false, array('ID', 'NAME', 'PROPERTY_CML2_LINK', 'PROPERTY_ES_NAME_SEARCH'));
while($arItem = $obOffers->Fetch()) $arOffers[$arItem["PROPERTY_CML2_LINK_VALUE"]][] = $arItem;

$arElements = array();
$obElements = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>32,'=PROPERTY_UPLOADED_FROM_PAGE'=>false), false, false, array('ID', 'NAME', 'IBLOCK_SECTION_ID'));
while($arItem = $obElements->Fetch())
{
    $arItem["OFFERS"] = $arOffers[$arItem["ID"]];
    $arElements[] = $arItem;
}

$arUnlinkElements = array();
$obUnlinkElements = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>35), false, false, array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PROPERTY_ES_LINK'));
while($arItem = $obUnlinkElements->Fetch()) $arUnlinkElements[] = $arItem;

$APPLICATION->SetTitle("Обработка товаров");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");
?>
    <form method="POST" action="<?=$APPLICATION->GetCurPageParam()?>" enctype="multipart/form-data">
        <?=bitrix_sessid_post();?>
        <input type="hidden" name="action" value="save-price"/>
        <?$tabControl->Begin();?>
        <?$tabControl->BeginNextTab();?>
        <tr class="adm-detail-required-field">
            <td>
                <table width="100%" cellspacing="2" cellpadding="4" border="1" style="border-collapse:collapse;">
                    <tr>
                        <td><b>Товар</b></td>
                        <td><b>Удаленный склад</b></td>
                        <td><b>Склад магазина</b></td>
                    </tr>
                    <?foreach($arElements as $arItem):?>
                        <tr>
                            <td>
                                <a href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=32&type=catalog_new&ID=<?=$arItem["ID"]?>&lang=ru&find_section_section=<?=intval($arItem["IBLOCK_SECTION_ID"])?>"><?=$arItem["NAME"]?></a>
                            </td>
                            <td><?=intval($arStore[$arItem["ID"]][5])?></td>
                            <td><?=intval($arStore[$arItem["ID"]][6])?></td>
                        </tr>
                        <?foreach($arItem["OFFERS"] as $arOffer):?>
                            <tr>
                                <td style="padding-left: 20px;"><?=$arOffer["PROPERTY_ES_NAME_SEARCH_VALUE"]==""?$arOffer["NAME"]:$arOffer["PROPERTY_ES_NAME_SEARCH_VALUE"]?></td>
                                <td><?=intval($arStore[$arOffer["ID"]][5])?></td>
                                <td><?=intval($arStore[$arOffer["ID"]][6])?></td>
                            </tr>
                        <?endforeach;?>
                    <?endforeach;?>
                </table>
            </td>
        </tr>
        <?$tabControl->BeginNextTab();?>
        <tr class="adm-detail-required-field">
            <td>
                <table width="100%" cellspacing="2" cellpadding="4" border="1" style="border-collapse:collapse;">
                    <tr>
                        <td><b>Товар (business.ru)</b></td>
                        <td><b>Привязка к товару/предложению на сайте</b></td>
                        <td><b>Действия</b></td>
                    </tr>
                    <?foreach($arUnlinkElements as $arItem):?>
                        <tr>
                            <td>
                                <a href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=35&type=business&ID=<?=$arItem["ID"]?>&lang=ru&find_section_section=<?=intval($arItem["IBLOCK_SECTION_ID"])?>"><?=$arItem["NAME"]?></a>
                            </td>
                            <td>
                                <?$link = ""?>
                                <?if($arItem["PROPERTY_ES_LINK_VALUE"] != ""):?>
                                    <?
                                    $arFilter = array();
                                    $arFilter["IBLOCK_ID"] = 32;
                                    $arFilter["XML_ID"] = $arItem["PROPERTY_ES_LINK_VALUE"];
                                    $obElement = CIBlockElement::GetList(array(), $arFilter, false, false, array('ID','NAME','IBLOCK_SECTION_ID'));
                                    if($arItem = $obElement->Fetch())
                                    {
                                        $link = '<a href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=32&type=catalog_new&ID='.$arItem["ID"].'&lang=ru&find_section_section='.intval($arItem["IBLOCK_SECTION_ID"]).'">'.$arItem["NAME"].'</a>';
                                    }
                                    else
                                    {
                                        $arFilter["IBLOCK_ID"] = 33;
                                        $obElement = CIBlockElement::GetList(array(), $arFilter, false, false, array('ID','NAME','IBLOCK_SECTION_ID','PROPERTY_ES_NAME_SEARCH'));
                                        if($arItem = $obElement->Fetch())
                                        {
                                            $link = '<a href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=33&type=offers_new&ID='.$arItem["ID"].'&lang=ru&find_section_section='.intval($arItem["IBLOCK_SECTION_ID"]).'">'.$arItem["PROPERTY_ES_NAME_SEARCH_VALUE"].'</a>';
                                        }
                                    }
                                    ?>
                                    <?=$link?>
                                <?endif;?>
                            </td>
                            <td>
                                <?if($link == ""):?>
                                    <a style="font-size: 11px;" href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=32&type=catalog_new&ID=0&lang=ru&find_section_section=2040&IBLOCK_SECTION_ID=2040&PRODUCT_TYPE=P" target="_blank"><nobr>Создать товар</nobr></a>
                                    <br/>
                                    <a style="font-size: 11px;" href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=35&type=business&ID=<?=$arItem["ID"]?>&lang=ru&find_section_section=<?=intval($arItem["IBLOCK_SECTION_ID"])?>" target="_blank"><nobr>Привязать вручную</nobr></a>
                                <?endif;?>
                            </td>
                        </tr>
                    <?endforeach;?>
                </table>
            </td>
        </tr>
        <?$tabControl->Buttons();?>
        <?$tabControl->End();?>
    </form>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");?>
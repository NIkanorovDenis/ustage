<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
IncludeModuleLangFile(__FILE__);

GLOBAL $USER, $DB;
if(!$USER->IsAdmin()) return;
CModule::IncludeModule("energosoft.utils");
CModule::IncludeModule("iblock");

$APPLICATION->SetTitle("Переадресация");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");
?>
<?
$arSections = array();
$arSectionsOld = ESIBlock::GetSectionList(17, array("SECTION_PAGE_URL", "NAME", "IBLOCK_SECTION_ID", "UF_ES301"), array("ACTIVE"=>"ALL"));
$arSectionsNew = ESIBlock::GetSectionList(32, array("SECTION_PAGE_URL"), array("ACTIVE"=>"ALL"), false, "ID");
$arSections301 = array();
foreach($arSectionsOld as $arItem)
{
    $url = $arSectionsNew[$arItem["UF_ES301"]][0]["SECTION_PAGE_URL"];
    if($url != "" && $arItem["SECTION_PAGE_URL"] != $url)
    {
        $arSections301[] = 'Redirect 301 "'.urldecode($arItem["SECTION_PAGE_URL"]).'" "https://ustage-group.ru'.urldecode($url).'"';
    }
    else
    {
        $isExist = false;
        foreach($arSectionsNew as $arItemNew)
        {
            if($arItemNew[0]["SECTION_PAGE_URL"] == $arItem["SECTION_PAGE_URL"]) $isExist = true;
        }
        if(!$isExist) $arSections[] = $arItem;
    }
}
?>
<?if(count($arSections) > 0):?>
    <p><b>Не распределенные разделы</b></p>
    <?foreach($arSections as $arSection):?>
        <a href="/bitrix/admin/iblock_section_edit.php?IBLOCK_ID=17&type=catalog&ID=<?=$arSection["ID"]?>&lang=ru&find_section_section=<?=intval($arSection["IBLOCK_SECTION_ID"])?>"><?=$arSection["NAME"]?></a>
        <br/>
    <?endforeach;?>
<?endif;?>
<?if(count($arSections301) > 0):?>
    <p><b>Сгенерированное описание для .htaccess</b></p>
    <?=implode("<br/>", $arSections301)?>
<?endif;?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");?>
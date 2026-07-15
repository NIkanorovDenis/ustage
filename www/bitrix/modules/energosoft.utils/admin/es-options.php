<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
IncludeModuleLangFile(__FILE__);

GLOBAL $USER, $DB;
if(!$USER->IsAdmin()) return;
CModule::IncludeModule("energosoft.utils");
CModule::IncludeModule("iblock");

if($REQUEST_METHOD == "POST" && check_bitrix_sessid())
{
    $arConfig = array(
        "MC_HOST" => trim(htmlspecialchars($_POST["MC_HOST"])),
        "MC_PORT" => trim(htmlspecialchars($_POST["MC_PORT"])),
        "MC_USE" => trim(htmlspecialchars($_POST["MC_USE"])),
        "DB_USE" => trim(htmlspecialchars($_POST["DB_USE"])),
    );
    ESUtils::SaveOption("config", $arConfig);
    LocalRedirect($APPLICATION->GetCurPageParam());
}
$arConfig = ESUtils::LoadOption("config");

$aTabs = array(
    //array("DIV" => "editOptions", "TAB" => "Настройки", "ICON" => "main_user_edit", "TITLE" => "Настройки"),
    array("DIV" => "editMemCache", "TAB" => "MemCache", "ICON" => "main_user_edit", "TITLE" => "MemCache"),
    array("DIV" => "editMySql", "TAB" => "MySql", "ICON" => "main_user_edit", "TITLE" => "MySql"),
);
$tabControl = new CAdminTabControl("tabControl", $aTabs, false, true);

$APPLICATION->SetTitle("Настройки");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");
?>
    <form id="es-fp-options" method="POST" action="<?=$APPLICATION->GetCurPageParam()?>" enctype="multipart/form-data">
        <?=bitrix_sessid_post();?>
        <?$tabControl->Begin();?>
        <?//$tabControl->BeginNextTab();?>
        <?$tabControl->BeginNextTab();?>
        <tr>
            <td width="40%">Хост:</td>
            <td width="60%">
                <input type="text" name="MC_HOST" size="30" value="<?=$arConfig["MC_HOST"]?>"/>
            </td>
        </tr>
        <tr>
            <td width="40%">Порт:</td>
            <td width="60%">
                <input type="text" name="MC_PORT" size="10" value="<?=$arConfig["MC_PORT"]?>"/>
            </td>
        </tr>
        <tr>
            <td width="40%">Show server status:</td>
            <td width="60%">
                <input type="checkbox" name="MC_USE" value="Y"<?=$arConfig["MC_USE"]=="Y"?" checked":""?>/>
            </td>
        </tr>
        <?if($arConfig["MC_USE"]=="Y"):?>
            <tr class="adm-detail-field">
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr class="adm-detail-field">
                <td colspan="2">
                    <?=ESUtils::GetMCStatus($arConfig["MC_HOST"], intval($arConfig["MC_PORT"]))?>
                </td>
            </tr>
        <?endif;?>
        <?$tabControl->BeginNextTab();?>
        <tr>
            <td width="40%">Show server status:</td>
            <td width="60%">
                <input type="checkbox" name="DB_USE" value="Y"<?=$arConfig["DB_USE"]=="Y"?" checked":""?>/>
            </td>
        </tr>
        <?if($arConfig["DB_USE"]=="Y"):?>
            <tr class="adm-detail-field">
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr class="adm-detail-field">
                <td colspan="2">
                    <?$arStatus = ESUtils::GetDBStatus();?>
                    <?if(count($arStatus) > 0):?>
                        <table width="100%" cellpadding="4" cellspacing="0" border="1" style="border-collapse:collapse;">
                            <tr>
                                <td><b>Параметр</b></td>
                                <td><b>Значение</b></td>
                            </tr>
                            <?foreach($arStatus as $arItem):?>
                                <tr>
                                    <td><?=$arItem["Variable_name"]?></td>
                                    <td><?=$arItem["Value"]?></td>
                                </tr>
                            <?endforeach;?>
                        </table>
                    <?endif;?>
                </td>
            </tr>
        <?endif;?>
        <?$tabControl->Buttons();?>
        <input class="adm-btn-save" type="submit" name="save" value="Сохранить" title="Сохранить"/>
        <?$tabControl->End();?>
    </form>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");?>
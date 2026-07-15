<?
$site_id = trim($_REQUEST["site_id"]);
define("SITE_ID", $site_id);
?>
<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
use \Bitrix\Main\Localization\Loc as Loc;
Loc::loadMessages(__FILE__);
CModule::IncludeModule('iblock');
    
    $code_wind = 'concept_hameleon_agreements';
    $itemId = trim($_REQUEST["resVal"]);
	$arItem = array();

	$arFilter = Array("IBLOCK_CODE" => $code_wind, "ID" => $itemId, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter);

    while($ob = $res->GetNextElement()){
        $arItem = $ob->GetFields();
    }

?>
	
<div class="shadow-modal"></div>

<div class="ham-modal window-modal">

	<div class="ham-modal-dialog">
		
		<div class="dialog-content">
            <a class="close-modal"></a>

            <div class="content-in">

				<?=$arItem['~PREVIEW_TEXT']?>
            </div>

        </div>

	</div>
</div>



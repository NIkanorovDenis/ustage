<?
$site_id = trim($_REQUEST["site_id"]);
define("SITE_ID", $site_id);
?>

<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

CModule::IncludeModule('iblock');
CModule::IncludeModule('main');

	if($_REQUEST["send"] == "Y")
	{
		$id = trim($_REQUEST["element_id"]);
		$code = trim($_REQUEST["code"]);
		$view = trim($_REQUEST["view"]);
		$type = trim($_REQUEST["type"]);


		if($type='element')
		{
			$PROPERTY_CODE = $code;  // код свойства
			$PROPERTY_VALUE = $view;  // значение свойства

			// Установим новое значение для данного свойства данного элемента
			CIBlockElement::SetPropertyValuesEx($id, false, array($PROPERTY_CODE => $PROPERTY_VALUE));

		}


		// if($type='section')
		// {
		//     $bs = new CIBlockSection;
		    
		//     $arFields = Array(
		//     	"UF_KRAKEN_CTLG_SIZE" => $view,
		//     );
		    
		//     $bs->Update($id, $arFields); 
		// }


		BXClearCache(true);
	}
?>





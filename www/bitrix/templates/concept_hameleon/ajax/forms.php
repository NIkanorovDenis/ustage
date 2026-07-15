<?$site_id = trim($_REQUEST["site_id"]);
define("SITE_ID", $site_id);

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

CModule::IncludeModule("concept.hameleon");
    
SendConceptForm();

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');
?>
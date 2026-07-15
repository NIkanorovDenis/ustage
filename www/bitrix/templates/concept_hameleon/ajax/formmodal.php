<?
$site_id = trim($_REQUEST["site_id"]);
define("SITE_ID", $site_id);
?>
<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

CModule::IncludeModule('iblock');


    $code_forms = 'concept_hameleon_forms';
    $formId = 0;
    $sect = 0;
    $ib = 0;
    $btn_type = "";
    $element_id = 0;
    $element_type = "";
    $other_complect = -1;

    if(trim($_REQUEST["resVal"]>0))
        $formId = trim($_REQUEST["resVal"]);

    if(trim($_REQUEST["section"]>0))
        $sect = trim($_REQUEST["section"]);

    if(trim($_REQUEST["ib"])>0)
        $ib = trim($_REQUEST["ib"]);

    if(strlen(trim($_REQUEST["btn_type"]))>0)
        $btn_type = trim($_REQUEST["btn_type"]);

    if(trim($_REQUEST["element_id"])>0)
        $element_id = trim($_REQUEST["element_id"]);

    if(strlen(trim($_REQUEST["element_type"]))>0)
        $element_type = trim($_REQUEST["element_type"]);

    if(strlen(trim($_REQUEST["other_complect"])) > 0)
        $other_complect = trim($_REQUEST["other_complect"]);

   
   
   
$APPLICATION->IncludeComponent(
    "concept:hameleon_form",
    "",
    Array(
        "COMPOSITE_FRAME_MODE" => "A",
        "COMPOSITE_FRAME_TYPE" => "AUTO",
        "CURRENT_FORM" => $formId,
        "CURRENT_LAND" => $sect,
        "IBLOCK_ID" => $ib,
        "IBLOCK_CODE" => "concept_hameleon_forms",
        "MESSAGE_404" => "",
        "SET_STATUS_404" => "N",
        "SHOW_404" => "N",
        "BTV_VIEW" => $btn_type,
        "ELEMENT_ID" => $element_id,
        "ELEMENT_TYPE" => $element_type,
        "OTHER_COMPLECT" => $other_complect
        
    )
);?>
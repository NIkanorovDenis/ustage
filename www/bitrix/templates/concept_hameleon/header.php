<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?CModule::IncludeModule("concept.hameleon");?>
<?include_once($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/functions.php");?>
<?$OS = os();?>


<?$bIsMainPage = $APPLICATION->GetCurDir(false) == SITE_DIR;?>

<?
use \Bitrix\Main\Localization\Loc as Loc;
use \Bitrix\Main\Page\Asset as Asset; 
?>

<?Loc::loadMessages(__FILE__);?>

<!DOCTYPE HTML>
<html lang="<?=LANGUAGE_ID?>">
<head>

	<meta name="author" content="concept" />
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0" />
    
    <?require_once($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/styles_and_scripts.php");?>

    <title><?$APPLICATION->ShowTitle()?></title>
    <?$APPLICATION->ShowHead();?>
    
	<?$APPLICATION->ShowViewContent("service_head");?>
</head>

<?
if(CModule::IncludeModuleEx("concept.hameleon") == 3)
{
    include_once($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/expired.php");
    die();
}
    
?>

<?$APPLICATION->ShowPanel();?>


<body id="body">

<?$APPLICATION->ShowViewContent("gtm_body");?>
<?$APPLICATION->ShowViewContent("service_body");?>

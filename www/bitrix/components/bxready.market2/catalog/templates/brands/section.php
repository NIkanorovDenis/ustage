<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;
use Alexkova\Market2\Core;
use Alexkova\Bxready2\Draw;
use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;
$this->setFrameMode(true);

$arParams['USE_FILTER'] = (isset($arParams['USE_FILTER']) && $arParams['USE_FILTER'] == 'Y' ? 'Y' : 'N');
if (isset($arResult["VARIABLES"]["SECTION_CODE"]) && strlen($arResult["VARIABLES"]["SECTION_CODE"])>0){
	global $arrFilter;

        CModule::IncludeModule("highloadblock");
        $properties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'],"CODE"=>$arParams['DETAIL_BRAND_PROP_CODE'][0]));
        if($prop_fields = $properties->GetNext())
        {
            $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getList(
                                        array('filter' => array('=TABLE_NAME' => $prop_fields['USER_TYPE_SETTINGS']['TABLE_NAME']))
                                )->fetch();
            $hlblock_id = $hlblock['ID'];
        }
        $hlblock_id = ($hlblock_id) ? $hlblock_id : 2;
 
        $hlblock = HL\HighloadBlockTable::getById($hlblock_id)->fetch();
        
        if (!empty($hlblock)) {
            $entity = HL\HighloadBlockTable::compileEntity($hlblock);
            $entity_data_class = $entity->getDataClass();
            $entity_table_name = $hlblock['TABLE_NAME'];

            $filter = array("UF_LINK" => "/brands/".$arResult["VARIABLES"]["SECTION_CODE"]."/"); 

            $sTableID = 'tbl_'.$entity_table_name;
            $rsData = $entity_data_class::getList(array(
                    "select" => array('*'), 
                    "filter" => $filter,
                    "order" => array("UF_SORT"=>"ASC") 
            ));
            $rsData = new CDBResult($rsData, $sTableID);
            if ($arRes = $rsData->Fetch()){
                if ($arRes["UF_FILE"]>0){
                    $arCurSection["PICTURE"] = Alexkova\Bxready2\Draw::prepareImage($arRes["UF_FILE"], array("width" => 200, "height" => 200));
                }
                $arCurSection["NAME"] = $arRes["UF_NAME"];
                $arCurSection["TITLE"] = $arRes["UF_TITLE"];
                $arCurSection["DESCRIPTION"] = $arRes["UF_DESCRIPTION"];
                $arCurSection["KEYWORDS"] = $arRes["UF_KEYWORDS"];
                $arCurSection["DESC"] = (strlen($arRes["UF_FULL_DESCRIPTION"]) > 0) ? $arRes["UF_FULL_DESCRIPTION"] : $arRes["UF_DESCRIPTION"];
                $xmlId = $arRes["UF_XML_ID"];
            }
        }
        
        $arrFilter["PROPERTY_".$arParams['DETAIL_BRAND_PROP_CODE'][0]] = strval($xmlId);
}
?>
<?
$arFilter = array(
	"IBLOCK_ID" => $arParams["IBLOCK_ID"],
	"ACTIVE" => "Y",
	"GLOBAL_ACTIVE" => "Y",
);

if (!Loader::includeModule('highloadblock'))
{
	ShowError(GetMessage("IBLOCK_CBB_HLIBLOCK_NOT_INSTALLED"));
	return false;
}
?>
<?
if (strlen($arCurSection["NAME"])>0)
{
?>
    <?if (isset($arCurSection))
    {
        $titleBrand = $arCurSection["NAME"];
        if (strlen($arParams["BRAND_PAGE_MASK"])>0)
            $titleBrand = str_replace('#BRAND_NAME#', $titleBrand, $arParams["BRAND_PAGE_MASK"]);

        $APPLICATION->SetPageProperty('h1', $titleBrand);
        $APPLICATION->SetPageProperty('description', $titleBrand);
        $APPLICATION->SetTitle($titleBrand);
        $APPLICATION->AddChainItem($titleBrand);
        $APPLICATION->SetPageProperty('title', $arCurSection["TITLE"]);
        $APPLICATION->SetPageProperty('keywords', $arCurSection["KEYWORDS"]);
        $APPLICATION->SetPageProperty('description', $arCurSection["DESCRIPTION"]);
        ?>
        <?if ($arParams["SHOW_SECTION_DESC"] == "top" && (strlen($arCurSection["PICTURE"]['src'])>0 || $arCurSection["DESC"])) {?>
            <?
            $elementarArea = \Alexkova\Bxready2\Elementars::getArea('catalog','section.desc');
            if (strlen($elementarArea) > 0) {
                include($elementarArea);
            } else {
                include('include/elementars/section.desc.php');
            }
            ?>
        <?}?>
    <?}?>
    <div class="row">
        <div class="col-xs-12 bxr-m20">
            <?
            $intSectionID = 0;
            ?>

            <?
            $elementarArea = \Alexkova\Bxready2\Elementars::getArea('catalog','sort.panel');
            if (strlen($elementarArea) > 0)
                include($elementarArea);
            else
                include('include/elementars/sort.panel.php');
            ?>


            <?
            if (isset($_SESSION["USER_SORTPANEL"]) && is_array($_SESSION["USER_SORTPANEL"]))
            {
                foreach ($_SESSION["USER_SORTPANEL"] as $cell=>$val)
                {
                    $_REQUEST[$cell] = $val;
                }
            }

            $elementarArea = \Alexkova\Bxready2\Elementars::getArea('catalog','section');
            if (strlen($elementarArea) > 0)
                include($elementarArea);
            else
                include('include/elementars/section.php');
            ?>
        </div>
        <?
        $GLOBALS['CATALOG_CURRENT_SECTION_ID'] = $intSectionID;
        unset($basketAction);
        ?>
    </div>
    <?if ($arParams["SHOW_SECTION_DESC"] == "bottom" && (strlen($arCurSection["PICTURE"]['src'])>0 || $arCurSection["DESC"])) {?>
        <?
        $elementarArea = \Alexkova\Bxready2\Elementars::getArea('catalog','section.desc');
        if (strlen($elementarArea) > 0) {
            include($elementarArea);
        } else {
            include('include/elementars/section.desc.php');
        }
        ?>
    <?}?>
<?
}
else
{
    if ($arParams['SET_STATUS_404'] == 'Y')
    {
        CHTTP::SetStatus("404 Not Found");

        if ($arParams['SHOW_404'] == "Y")
        {
            if (strlen($arParams['FILE_404'])>0)
                $file404 = $arParams['FILE_404'];
            else
                $file404 = '/404.php';

            include($_SERVER['DOCUMENT_ROOT'].$file404);
        }
        else
        {
            if (strlen($arParams['MESSAGE_404'])>0){?>
                <div class="bxr-404-message"><?=$arParams['MESSAGE_404']?></div>
            <?}
        }
    }
}?>
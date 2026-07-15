<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
	$arFilter = Array("ID"=> $arResult["ID"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");

    $res = CIBlockElement::GetList(Array("sort" => "asc"), $arFilter);

    while($ob = $res->GetNextElement())
    {
        
        $arResult["PROPERTIES"] = $ob->GetProperties();
       
    }
?>
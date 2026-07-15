<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arIDS = array();
$iblockID = 0;
if (count($arResult)>0){
    $arResult = array(
            "ITEMS"=>$arResult
    );
    
    foreach($arResult["ITEMS"] as $arElement){
            $arIDS[] = $arElement["ID"];
            $iblockID = $arElement["IBLOCK_ID"];
    }

    $arFilter = array(
            "ACTIVE"=>"Y",
            "ID"=>$arIDS,
            "IBLOCK_ID"=>$iblockID
    );

    $arSelect = array("ID", "DETAIL_PICTURE", "PREVIEW_PICTURE");

    $res = CIblockElement::GetList(array(),$arFilter, false,false, $arSelect);
    while ($arFields = $res->Fetch()){
        if ($arFields["PREVIEW_PICTURE"]>0)
            $arFields["PREVIEW_PICTURE"] = $arFields["PREVIEW_PICTURE"];
        
        if(empty($arFields["PREVIEW_PICTURE"])) {
            if ($arFields["DETAIL_PICTURE"]>0)
                $arFields["DETAIL_PICTURE"] = $arFields["DETAIL_PICTURE"];
        }
        
        $arResult["DATA"][$arFields["ID"]] = $arFields;
    }    
}

if (!empty($arResult["ITEMS"]) && count($arResult["ITEMS"])>0){
    foreach ($arResult["ITEMS"] as $val){
            $arResult["JSON"][$val["ID"]] = 1;
    }
}
?>
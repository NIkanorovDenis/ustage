<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (intval($arParams["DATA_ATTR"]["pid"]) > 0) {
    $pid = $arParams["DATA_ATTR"]["pid"];
    $res = CIBlockElement::GetByID($pid);

    if ($element = $res->GetNext()) {
        $arResult["ELEMENT"] = array(
            "ID" => $element["ID"],
            "NAME" => $element["NAME"],
            "LINK" => $element["DETAIL_PAGE_URL"],
            "PICTURE" => ($element["PREVIEW_PICTURE"])?CFile::GetPath($element["PREVIEW_PICTURE"]):(($element["DETAIL_PICTURE"])?CFile::GetPath($element["DETAIL_PICTURE"]):""),
            "MESSAGE" => GetMessage("REQUEST_MSG").'"'.$element["NAME"].'"'
        );
    }
}

if(isset($arParams["DATA_ATTR"]["select"]) && !empty($arParams["DATA_ATTR"]["select"])) {
	$arSelect = explode(";", $arParams["DATA_ATTR"]["select"]);
	foreach ($arSelect as $k => $v) {
		if(!empty($v)) {
			$ex = explode("=", $v);
			if(!empty($ex[0]) && !empty($ex[1]))
				$arParams["SELECT"][$ex[0]] = $ex[1];
		}
	}
}
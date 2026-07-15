<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arResult["SEARCH_HISTORY"] = array();
if($arParams["SHOW_HISTORY"] == 'Y'){
	
	$history_save = $APPLICATION->get_cookie("AG_SMSEARCH");
	if(strlen($history_save)>0){
		$history_save = explode('|', $history_save);
	}
	
	if(is_array($history_save) && count($history_save)){
		$ind = 0;
		foreach(array_reverse($history_save) as $k=>$v){
			if($v == trim($_GET["q"]) || $ind > 9) continue;
			$ind++;
			$arResult["SEARCH_HISTORY"][] = $v;
		}
	}
}
<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?
$prepareParams =  $arParams;
//if (!isset($prepareParams) || !is_array($prepareParams)) $prepareParams = $arParams;
if (isset($paramPrefix) && strlen($paramPrefix)>0){
	foreach ($arParams as $cell=>$val){
		$newCell = $cell;
		if (substr($cell, 0,strlen($paramPrefix)) == $paramPrefix){
                    $newCell = str_replace($paramPrefix, '', $cell);
		}

		$prepareParams[$newCell] = $val;

	}
}


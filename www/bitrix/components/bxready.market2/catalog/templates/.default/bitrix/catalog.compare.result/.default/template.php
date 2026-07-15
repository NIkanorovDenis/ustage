<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
foreach($arResult["SHOW_PROPERTIES"] as $cell=>$val){
	$arResult["SHOW_PROPERTIES"][$cell]["COUNT_VALUE"] = count($arResult["ITEMS"]);
}

foreach($arResult["ITEMS"] as $cell=>$val){
	foreach($val["PROPERTIES"] as $cell2=>$val2){
		if (!$val2["VALUE"])
			$arResult["SHOW_PROPERTIES"][$cell2]["COUNT_VALUE"] -= 1;
	}

}

foreach($arResult["SHOW_PROPERTIES"] as $cell=>$val){
	if ($arResult["SHOW_PROPERTIES"][$cell]["COUNT_VALUE"]<=0) {
		unset($arResult["SHOW_PROPERTIES"][$cell]);
		unset($arResult["DISPLAY_PROPERTIES"][$cell]);
	}
}
?>

<div class="row bxr-compare-list-mobile hidden-md hidden-lg hidden-xl">
    <div class="col-xs-12">
        <?
        $elementarArea = \Alexkova\Bxready2\Elementars::getArea('compare.result','mobile_template');
        if (strlen($elementarArea) > 0){
            include($elementarArea);
        }else{
            include 'mobile_template.php';
        }
        ?>
    </div>
</div>

<div class="row bxr-compare-list hidden-sm hidden-xs">
    <div class="col-xs-12">
        <?
        $elementarArea = \Alexkova\Bxready2\Elementars::getArea('compare.result','desctop_template');
        if (strlen($elementarArea) > 0){
            include($elementarArea);
        }else{
            include 'desctop_template.php';
        }
        ?>
    </div>
</div>

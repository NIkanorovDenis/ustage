<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?
global $APPLICATION;


$countBox = $_REQUEST["countBox"];
if($countBox == "NaN")
	$countBox = 1;

$id = $_REQUEST["idboxEl"];
$sect = $_REQUEST["sect"];
$action = $_REQUEST["action"];
$other_complect = "";

if(strlen($_REQUEST["other_complect"])>0)
	$other_complect = $_REQUEST["other_complect"];

$arBox = $APPLICATION->get_cookie('_ham_box_'.$sect, "");
$arBox = unserialize($arBox);

$arRes["EMPTY"] = "N";

$time_on = 60*60*60;

if(empty($arBox))
	$arBox = Array();

if($action == "add")
{
	$val = $arBox[$id]["count"];
	if($val == 0 || $val == "NaN")
		$val = $countBox;
	
	$arBox[$id] = Array(
		"id"=>$id, 
		"count" => $val,
		"other_complect" => $other_complect
	);

	$arBox = $arBox + $arBox;
}

if($action == "update")
{
	$arBox[$id] = Array(
		"id"=>$id, 
		"count" => $countBox,
		"other_complect" => $other_complect
	);
	
}

if($action == "delete")
{
	if(count($arBox) == 1)
	{
		$time_on = -100;
		$arRes["EMPTY"] = "Y";
	}

	else
		unset($arBox[$id]);
}


if($action == "clear")
{
	$time_on = -100;
	$arRes["EMPTY"] = "Y";
}

$arBox = serialize($arBox);
$APPLICATION->set_cookie("_ham_box_".$sect, $arBox, time()+($time_on), "/", false, false,true,"",false);

$arRes = json_encode($arRes);
echo $arRes;
?>

<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$selectMode = $arResult['USE_SMART_FILTER'] == "Y" ? 'filter' : 'condition';?>
<div id="seo_set_info" class="adm-detail-content-btns"<?if($arResult['SET_INFO']['ID']>0) echo 'data-set="'.$arResult['SET_INFO']['ID'].'"'?> data-ftype="<?=$selectMode?>">
		<?if (empty($arResult['SET_INFO'])){
			include ('create.php');
		} else {
			include ('editor.php');
		};?>

</div>


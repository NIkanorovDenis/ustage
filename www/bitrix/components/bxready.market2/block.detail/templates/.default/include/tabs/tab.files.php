<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>

<?
if (count($arResult["FILES"])>0){
	$elementDraw = \Alexkova\Bxready2\Draw::getInstance($this);
	$elementDraw->setCurrentTemplate($this);
}
?>
<div class="row">
<?foreach ($arResult['FILES'] as $cell=>$val):?>

<div class="col-xs-12 col-md-6 col-lg-4">
	<?
	$elementDraw->showElement('elements', 'file.standart.v2', $val, $arParams);
	?>

</div>
<?endforeach;?>
</div>
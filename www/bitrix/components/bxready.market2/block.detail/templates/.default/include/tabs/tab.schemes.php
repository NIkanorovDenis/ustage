<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>
<?
if (is_array($arResult["SCHEMES"]) && count($arResult['SCHEMES'])>0){
	?>

	<div class="row">

	<?foreach ($arResult["SCHEMES"] as $val){
		$arRes = array(
			"SIZE_LIMIT" => array(
				'width' => 300,
				'height' => 150
			),
			'DETAIL_PAGE_URL' => $val['SRC'],
			'PREVIEW_PICTURE'=>$val,
			'NAME'=>$val['DESCRIPTION'],
		);

		$arParam = array(
			'ADD_CLASS'=>'bxr-fancy',
			'ADD_REL'=>'shemes_gallery'
		);
	?>
	<div class="col-xs-12 col-md-4">
		<?
			$elementDraw->showElement('elements', 'image.v2', $arRes, $arParam);
		?>
	</div>
	<?}?>
	</div>
<?}
?>
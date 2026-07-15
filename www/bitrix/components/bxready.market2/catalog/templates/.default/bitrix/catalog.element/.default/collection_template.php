<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>

<div class="row">
	<? include('include/shorts.php'); ?>
	<div class="col-xl-7 col-lg-7 col-md-6 col-sm-6 col-xs-12 bxr-slider-detail-col bxr-slider-vertical-col">
		<div class="bxr-detail-col">
			<?
			$includeAreaName = 'collection.slider';
			include 'include_handler.php';
			?>
		</div>
	</div>
	<div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-xs-12 bxr-preview-detail-col">
		<div class="bxr-detail-col">
			<? foreach ($anounceBlocksOrder as $includeName): ?>
				<? if ($includeName != 'rating'): ?>
					<div class="hidden-md hidden-sm">
				<? endif ?>
				<?
				$includeAreaName = $includeName;
				include 'include_handler.php';
				?>
				<? if ($includeName != 'rating'): ?>
					</div>
				<? endif ?>
			<? endforeach ?>

			<? if (!empty($arResult['OFFERS'])) {
				$includeAreaName = 'collection.sku_list';
				include 'include_handler.php';
			} ?>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 bxr-bottom-detail-col">
	<? if ($arResult['OFFER_GROUP']) {
		$includeAreaName = 'set';
		include 'include_handler.php';
	}; ?>


	<? if (!empty($arResult["COMPLECT_ITEMS"])) {
		$includeAreaName = 'complect';
		include 'include_handler.php';
	} ?>

	<div class="bxr-detail-col<?= (count($arResult['TABS']['TABS']) > 0 && $arParams['BXR_DETAIL_TABS']['BXR_DETAIL_TAB_TYPE'] == 'tabs' && $arParams['BXR_DETAIL_TABS']['BXR_DETAIL_TAB_VIEW'] == 'tabs') ? " bxr-detail-col-tabs" : "" ?>">
	<? if ($arParams['BXR_DETAIL_TABS']['BXR_DETAIL_TAB_TEXT'] == 'detail') {
		$includeAreaName = 'detail';
		include 'include_handler.php';
	} ?>
	<? if ($arParams['GIFTS_DETAIL_TAB_POSITION'] == 'bottom') {
		$includeAreaName = 'gift';
		include 'include_handler.php';
	}
	?>
	<? include('include/tabs.php'); ?>
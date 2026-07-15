<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$this->addExternalCss("/bitrix/templates/market2_v1/components/bxready.market2/block.detail/.default/include/slider.css");
?>
<? if ($arResult["PROPERTIES"]["PROJECTS"]["VALUE"]): ?>
	<div class="h2">Реализованные проекты</div>
	<?php include('projects_slider.php') ?>
<? endif; ?>
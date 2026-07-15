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

use Alexkova\Bxready2\Draw;

$this->setFrameMode(true);

$elementDraw = Draw::getInstance($this);
$elementDraw->setCurrentTemplate($this);

$this->setFrameMode(true);
global $unicumID;
if ($unicumID<=0) {$unicumID = 1;} else {$unicumID++;}

$arParams["UNICUM_ID"] = $unicumID;
?>
<div class="row">
<?foreach ($arResult['ELEMENTS'] as $cell=>$val):?>
    <div class="t_<?=$thisUncumId?> col-xl-<?=$arParams["BXREADY_LIST_XLG_CNT"]?> col-lg-<?=$arParams["BXREADY_LIST_LG_CNT"]?> col-md-<?=$arParams["BXREADY_LIST_MD_CNT"]?> col-sm-<?=$arParams["BXREADY_LIST_SM_CNT"]?> col-xs-<?=$arParams["BXREADY_LIST_XS_CNT"]?>"  data-entity="items-row">
        <?$elementDraw->showElement('elements', $arParams["BXREADY_ELEMENT_DRAW"], $val, $arParams);?>
    </div>
<?endforeach;?>
</div>
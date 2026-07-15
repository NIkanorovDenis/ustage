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

if (empty($arResult["BRAND_BLOCKS"]))
	return;
$strRand = $this->randString();
$strObName = 'obIblockBrand_'.$strRand;
$blockID = 'bx_IblockBrand_'.$strRand;
$mouseEvents = 'onmouseover="'.$strObName.'.itemOver(this);" onmouseout="'.$strObName.'.itemOut(this)"';

$handlerIDS = array();

foreach ($arResult["BRAND_BLOCKS"] as $blockId => $arBB)
{
	$brandID = 'brand_'.$arResult['ID'].'_'.$strRand;
	$popupID = $brandID.'_popup';

	$usePopup = $arBB['FULL_DESCRIPTION'] !== false;
	$useLink = $arBB['LINK'] !== false;
	if ($useLink)
		$arBB['LINK'] = htmlspecialcharsbx($arBB['LINK']);?>

        <img src="<?=$arBB['PICT']['SRC'];?>">        

	<?if ($usePopup)
		$handlerIDS[] = $brandID;
}
?>
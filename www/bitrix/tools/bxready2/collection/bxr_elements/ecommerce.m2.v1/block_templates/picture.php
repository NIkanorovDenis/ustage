<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$imgWidth = ($arElementParams['BXR_PRESENT_SETTINGS']['BXR_IMG_MAX_WIDTH'] > 0 && $arElementParams['BXR_PRESENT_SETTINGS']['BXR_IMG_MAX_WIDTH'] < 180) ? $arElementParams['BXR_PRESENT_SETTINGS']['BXR_IMG_MAX_WIDTH'] : 180;
$imgHeight = ($arElementParams['BXR_PRESENT_SETTINGS']['BXR_IMG_MAX_HEIGHT'] > 0 && $arElementParams['BXR_PRESENT_SETTINGS']['BXR_IMG_MAX_HEIGHT'] < 180) ? $arElementParams['BXR_PRESENT_SETTINGS']['BXR_IMG_MAX_HEIGHT'] : 180;
$arMatrix = array('width' => $imgWidth, 'height' => $imgHeight);
if (is_array($arElement["PREVIEW_PICTURE"])){
    $mainPicture = $elementDraw->prepareImage($arElement["PREVIEW_PICTURE"]["ID"], $arMatrix);
} else {
    if (is_array($arElement["DETAIL_PICTURE"]))
        $mainPicture = $elementDraw->prepareImage($arElement["DETAIL_PICTURE"]["ID"], $arMatrix);
}
if (!is_array($mainPicture) || strlen($mainPicture["src"]) <= 0){
	$mainPicture = array("src" => $elementDraw->getDefaultImage());
}

$showSlider = $arElementParams["BXR_PRESENT_SETTINGS"]["BXR_SHOW_SLIDER"] === "Y";
$morePhoto[$arElement["ID"]] = ($arElement["MORE_PHOTO_SLIDER"]) ?: $arElement['MORE_PHOTO'];
if(is_array($morePhoto[$arElement["ID"]])) {
    foreach ($morePhoto[$arElement["ID"]] as &$photo) {
        $picture = $elementDraw->prepareImage($photo["ID"], $arMatrix);
        $picture['ITEM_ID'] = $photo['ITEM_ID'];
        $photo = $picture;
    }
}
unset($photo);

$usLazyLoad = false;
if (method_exists('\Alexkova\Market2\Bxmarket', 'usLazyLoad')) {
	$usLazyLoad = \Alexkova\Market2\Bxmarket::usLazyLoad($arElementParams['LAZY_LOAD'], $arElementParams['BXR_LAZY_LOAD']);
}

$isImgSlider = 'false';

$title = ($arElement["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]) ? $arElement["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_ALT"] : $arElement["NAME"];
$alt = ($arElement["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_ALT"]) ? $arElement["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_ALT"] : $arElement["NAME"];
if ($showSlider && isset($morePhoto[$arElement["ID"]]) && count($morePhoto[$arElement["ID"]]) > 1) {
    $isImgSlider = 'true';
?><div class="bxr-slider slide bxr-img-container" id="<?=$arItemIDs['PICT_SLIDER']?>" title="<?=$title?>"><?
    if(is_array($morePhoto[$arElement["ID"]])) {
        foreach ($morePhoto[$arElement["ID"]] as $key => $photo) {
            ?>

            <a class="bxr-item-image-wrap" href="<?=$arElement['DETAIL_PAGE_URL']?>" data-item="<?=($photo['ITEM_ID'])?:$arElement['ID']?>">
				<?if(!$usLazyLoad):?>
					<img class="bxr-item-image item-image" src="<?=$photo['src']?>" title="<?=$title?>" alt="<?=$alt?>">
				<?else:?>
					<img class="bxr-item-image item-image lazy" src="<?=$elementDraw->getPreloaderImage()?>" data-bxr-lazy="<?=$photo['src']?>" title="<?=$title?>" alt="<?=$alt?>">
				<?endif;?>
            </a><?
        }
    }
    unset($morePhoto[$arElement["ID"]]);
    ?><?if ($arElement["PROPERTIES"]["GISP"]["VALUE_XML_ID"] === "Y"):?>
        <span class="bxr-gisp-corner" title="ГИСП" aria-label="ГИСП"><span class="bxr-gisp-corner__logo"></span></span>
    <?endif;?></div><?
} else {
    ?><div class="bxr-element-image bxr-img-container">
        <a class="bxr-item-image-wrap" href="<?=$arElement['DETAIL_PAGE_URL']?>">
			<?if(!$usLazyLoad):?>
				<img class="item-image" src="<?=$mainPicture['src']?>" title="<?=$title?>" alt="<?=$alt?>">
			<?else:?>
				<img class="item-image lazy" src="<?=$elementDraw->getPreloaderImage()?>"  data-bxr-lazy="<?=$mainPicture['src']?>" title="<?=$title?>" alt="<?=$alt?>">
			<?endif;?>
        </a>
        <?if ($arElement["PROPERTIES"]["GISP"]["VALUE_XML_ID"] === "Y"):?>
            <span class="bxr-gisp-corner" title="ГИСП" aria-label="ГИСП"><span class="bxr-gisp-corner__logo"></span></span>
        <?endif;?>
    </div><?
}

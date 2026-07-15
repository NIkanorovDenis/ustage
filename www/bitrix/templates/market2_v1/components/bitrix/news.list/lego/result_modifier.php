<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

foreach ($arResult["ITEMS"] as $k=>$item) {

	if (!empty($item['PREVIEW_PICTURE'])) {
		
		if (!empty($item['PROPERTIES']['BANNER']) && $item['PROPERTIES']['BANNER']['VALUE_XML_ID'] == 'Y') {
			
			$arResult["ITEMS"][$k]['BANNER']['IMG'] = CFile::ResizeImageGet($item['~PREVIEW_PICTURE'], ['width' => 1100, 'height' => 600], BX_RESIZE_IMAGE_EXACT)['src'];
			$arResult["ITEMS"][$k]['BANNER']['TEXT'] = $item['~PREVIEW_TEXT'];
			
		} 		
	}

	if (!empty($item['PROPERTIES']['CITATA']) && $item['PROPERTIES']['CITATA']['VALUE_XML_ID'] == 'Y') {
		if (!empty($item['PREVIEW_PICTURE'])){
			$arResult["ITEMS"][$k]['CITATA']['IMG'] = CFile::ResizeImageGet($item['~PREVIEW_PICTURE'], ['width' => 180, 'height' => 120], BX_RESIZE_IMAGE_EXACT)['src'];
		} else {
			$arResult["ITEMS"][$k]['CITATA']['SVG'] = '<img src="/logo.svg" align="left" width="130" class="company-logo">';
		}
		$arResult["ITEMS"][$k]['CITATA']['TEXT'] = $item['~PREVIEW_TEXT'];
	}
	
	if (!empty($item['PROPERTIES']['PHOTO'])) {
		foreach ($item['PROPERTIES']['PHOTO']['~VALUE'] as $i=>$photo) {
			
			$arResult["ITEMS"][$k]['PHOTO'][$i]['IMG'] = CFile::ResizeImageGet($photo, ['width' => 320, 'height' => 215], BX_RESIZE_IMAGE_EXACT)['src'];
			$arResult["ITEMS"][$k]['PHOTO'][$i]['BIG_IMG'] = CFile::ResizeImageGet($photo, ['width' => 1200, 'height' => 1200], BX_RESIZE_IMAGE_EXACT)['src'];
			$arResult["ITEMS"][$k]['PHOTO'][$i]['TEXT'] = $item['PROPERTIES']['PHOTO']['~DESCRIPTION'][$i];
			
		}
		
	}

} ?>

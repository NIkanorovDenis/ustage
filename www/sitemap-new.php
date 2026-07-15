<?
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

if (!empty($_REQUEST['type'])) {

	CModule::IncludeModule('iblock');
	$sefUrl = '';

	if ($_REQUEST['type'] == 'tags') {
		
		$arFilter = [
			'IBLOCK_ID' => 66,
			'ACTIVE' => 'Y'
		];
		$res = CIBlockElement::GetList(false, $arFilter, ['ID', 'IBLOCK_ID', 'NAME', 'DATE_CREATE']);	
		while ($el = $res->GetNext()) {
			
			$date = new DateTimeImmutable($el['DATE_CREATE']);
			$sefUrl .= '<url>
					<loc>https://ustage-group.ru'. $el['NAME'] .'</loc>
					<lastmod>'.$date->format('Y-m-d').'</lastmod>
				  </url>';
			
		}
	
	} elseif ($_REQUEST['type'] == 'brands') {
		
		$HLBrandsAr = [];
		$HLBrandsRes = $DB->Query("SELECT UF_XML_ID FROM bxready_manufacturer");
		while ($HLBrandsRow = $HLBrandsRes->Fetch()) {
			$HLBrandsAr[] = $HLBrandsRow['UF_XML_ID'];
		}
		
		if (!empty($HLBrandsAr)) {
				
			$arFilter = [
				'IBLOCK_ID' => 32, 
				'ACTIVE' => 'Y',
				'GLOBAL_ACTIVE' => 'Y'
			];
			$arSelect = ['ID', 'NAME', 'SECTION_PAGE_URL', 'IBLOCK_SECTION_ID', 'DATE_CREATE', 'CODE'];
			$res = CIBlockSection::GetList(['NAME' => 'ASC'], $arFilter, false, $arSelect);
			while ($sec = $res->GetNext()) { 
				
				$brands_ar = [];
				$arFilterEl = [
					'IBLOCK_ID' => $sec['IBLOCK_ID'],
					'SECTION_ID' => $sec['ID'],
					'ACTIVE' => 'Y',
					'INCLUDE_SUBSECTIONS' => 'Y'
				];
				$resEl = CIBlockElement::GetList(false, $arFilterEl, ['ID', 'IBLOCK_ID', 'NAME', 'PROPERTY_MANUFACTURER']);	
				while ($elEl = $resEl->GetNext()) { 
					
					if (
						!empty($elEl['PROPERTY_MANUFACTURER_VALUE']) && 
						in_array($elEl['PROPERTY_MANUFACTURER_VALUE'], $HLBrandsAr) &&
						(empty($brands_ar) || !in_array($elEl['PROPERTY_MANUFACTURER_VALUE'], $brands_ar))
					) {
						$brands_ar[] = $elEl['PROPERTY_MANUFACTURER_VALUE'];
					}
					
				}		
				
				if (!empty($brands_ar)) {
					foreach ($brands_ar as $brand) {					

						if (!empty($brand)) {
							
							$date = new DateTimeImmutable($sec['DATE_CREATE']);
							$sefUrl .= '<url>
									<loc>https://ustage-group.ru'. $sec['SECTION_PAGE_URL'] .'filter/manufacturer-is-'. strtolower($brand) .'/apply/</loc>
									<lastmod>'.$date->format('Y-m-d').'</lastmod>
								  </url>';	
						
						}
					
					}
					
				} 

			}	
		
		}
		
	}	

	header('Content-Type: application/xml');
	header("Last-Modified: " . date('D, d M Y H:i:s'));

	echo '<?xml version="1.0" encoding="utf-8"?>';
	echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
	echo $sefUrl;	
	echo '</urlset>';

}
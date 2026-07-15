<?php
$_SERVER['DOCUMENT_ROOT'] = __DIR__.'/../';
$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);
define('BX_CRONTAB', true);
define('BX_NO_ACCELERATOR_RESET', true);

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

CModule::IncludeModule('iblock');

$IBLOCK_ID = 32;
$IBLOCK_ID_OFFER = 33;
$i=1;

$section = [
	'Y' => [],
	'N' => [],
	'CH' => [],
];

$arFilter = [
	'IBLOCK_ID' => $IBLOCK_ID,
	//'ACTIVE' => 'Y'
];
$res = CIBlockElement::GetList(false, $arFilter, ["ID", "IBLOCK_ID", "NAME", "PROPERTY_SORT_AVAIL", 'IBLOCK_SECTION_ID', 'ACTIVE']);	
while ($el = $res->GetNext()) { 

	//if ( $i >= 0 && $i <= 500 ) {
		
		/*avail*/
		/*if ($el['ACTIVE'] == 'Y') {
			
			$quantityAr = CCatalogProduct::GetByID($el['ID']);
			$quantity = $quantityAr['QUANTITY'];
			$quantityOffer = 0;
			
			$arFilterOffer = [
				'IBLOCK_ID' => $IBLOCK_ID_OFFER,
				'ACTIVE' => 'Y',
				'PROPERTY_CML2_LINK' => $el['ID'],
			];
			$resOffer = CIBlockElement::GetList(false, $arFilterOffer, ["ID", "IBLOCK_ID", "NAME"]);
			while ($elOffer = $resOffer->GetNext()) { 

				$quantityOfferAr = CCatalogProduct::GetByID($elOffer['ID']); 
				$quantityOffer += $quantityOfferAr['QUANTITY'];
			}
			
			$quantity = $quantityOffer>0 ? $quantityOffer : $quantity;
				
			if ($quantity > 0) {
				CIblockElement::SetPropertyValuesEx($el['ID'], $IBLOCK_ID, ['SORT_AVAIL' => '1']);	
			} else {
				CIblockElement::SetPropertyValuesEx($el['ID'], $IBLOCK_ID, ['SORT_AVAIL' => '']);	
			}
			
		}*/
		
		/*active*/
		if (!empty($el['IBLOCK_SECTION_ID'])) {
			
			if (!isset($section['CH'][$el['IBLOCK_SECTION_ID']])) {
				
				$elGroups = CIBlockSection::GetNavChain($IBLOCK_ID, $el['IBLOCK_SECTION_ID'], ['ID'], true);
				$section['CH'][$el['IBLOCK_SECTION_ID']] = $elGroups;
				
			} else {
				
				$elGroups = $section['CH'][$el['IBLOCK_SECTION_ID']];
				foreach ($elGroups as $elGroup) {
					
					if ($el['ACTIVE'] == 'Y') {
						if (!isset($section['Y'][$elGroup['ID']])) {
							$section['Y'][$elGroup['ID']] = $elGroup['ID'];
						} 

					} else {
						if (!isset($section['N'][$elGroup['ID']])) {
							$section['N'][$elGroup['ID']] = $elGroup['ID'];
						}
					}					
					
				}

			}
			
		}
		
		//echo $el['NAME'].' quantity: '.$quantity.' - '. $el['ACTIVE'] .'<br />';		

	//}
	$i++;	

} 

//$nosetSections = [3529, 3677, 3534, 3676, 3678, 3686, 3692, 3689, 3693, 3576, 3604, 3669, 3680, 3528, 3682, 3532, 3533, 3688, 3535, 3684, 3577, 3612, 2040];
$rsSectionsNS = CIBlockSection::GetList([], ['IBLOCK_ID' => $IBLOCK_ID, '!UF_NOACTIVEUPDATE' => false], false, ['IBLOCK_ID', 'ID', 'NAME', 'UF_NOACTIVEUPDATE']);
while ($arSectionsNS = $rsSectionsNS->GetNext()) {
    $nosetSections[] = $arSectionsNS['ID'];
} 
foreach ($section['N'] as $k=>$item) {
	if (isset($section['Y'][$k]) || in_array($k, $nosetSections)) {
		unset($section['N'][$k]);
	}
}

$rsSection = new CIBlockSection;
foreach ($section['Y'] as $k=>$item) {
	if (!in_array($k, $nosetSections)) {
		$updateRsSection = $rsSection->Update($k, ['ACTIVE' => 'Y']);
	}
}
foreach ($section['N'] as $k=>$item) {
	$updateRsSection = $rsSection->Update($k, ['ACTIVE' => 'N']);
	echo 'UNactive: '.$updateRsSection.'-'.$k.'<br>';
}
print_r($section);

mail('diz55@mail.ru', 'ustage update available', 'ustage update available'); 

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php');

?>
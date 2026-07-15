<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arResult['AJAX_URL'] = $this->GetFolder().'/ajax.php';
$this->addExternalCss('/bitrix/css/main/font-awesome.min.css');
$this->addExternalCss($this->GetFolder().'/vendor/spectrum/spectrum.css');
$this->addExternalJs($this->GetFolder().'/vendor/spectrum/spectrum.js');
$this->addExternalJs('/bitirx/js/alexkova.bxready2/scrollbar/jquery.scrollbar.min.js');
$this->addExternalCss('/bitirx/js/alexkova.bxready2/scrollbar/jquery.scrollbar.css');


if (!$arResult['TAB']) {
	foreach($arResult['settings'] as $cell => $val) {
		$arResult['settings'][$cell]['active'] = true;
		$arResult['TAB'] = $cell;
		break ;
	}
} else {
	$arResult['settings'][$arResult['TAB']]['active'] = true;
}

foreach($arResult['settings'] as $cell => $val) {
	if ($cell == 'doc' || count($val['items']) <= 0) {
		unset($arResult['settings'][$cell]);
	}
}
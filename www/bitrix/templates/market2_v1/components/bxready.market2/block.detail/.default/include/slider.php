<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$elementDraw = \Alexkova\Bxready2\Draw::getInstance($this);
$loopType = $arParams["BXR_PICTURE"]["BXR_ZOOM_PICTURE_TYPE"];?>

<?$this->addExternalJs('/bitrix/js/alexkova.bxready2/fancybox3/jquery.fancybox.min.js');
  $this->addExternalCss('/bitrix/js/alexkova.bxready2/fancybox3/jquery.fancybox.min.css');
?>

<? if (!empty($arResult['PROPERTIES']['SLICK']['VALUE'])): ?>
	<? include 'slider_simple.php'; ?>	
<? else: ?>
	<? include 'slider_main.php'; ?>
<? endif;?>




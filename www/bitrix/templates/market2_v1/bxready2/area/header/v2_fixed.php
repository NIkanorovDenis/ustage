<? global $APPLICATION;
$bxmarket = \Alexkova\Market2\Bxmarket::getInstance();
$bxmarket->setCoreData(array(
    'min_content_buttons_action' => true,
    'basket_style' => "bxr-basket-fixed",
));
?>
<?\Alexkova\Bxready2\Area::showArea("header", "v2", true);?>
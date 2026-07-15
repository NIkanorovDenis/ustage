<? global $APPLICATION;
$bxmarket = \Alexkova\Market2\Bxmarket::getInstance();
$bxmarket->setCoreData(array(
    'min_content_buttons_action' => true,
    'basket_style' => "bxr-basket-fixed bxr-basket-dinamic",
));
?>
<?\Alexkova\Bxready2\Area::showArea("header", "v1", true);?>
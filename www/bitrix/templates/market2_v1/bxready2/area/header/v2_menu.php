<? global $APPLICATION;
$bxmarket = \Alexkova\Market2\Bxmarket::getInstance();
$bxmarket->setCoreData(array(
    'top_menu' => true,
));
?>
<?\Alexkova\Bxready2\Area::showArea("header", "v2", true);?>
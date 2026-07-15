<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$elementarArea = \Alexkova\Bxready2\Elementars::getArea('compare.result','mobile.head');
if (strlen($elementarArea) > 0){
    include($elementarArea);
}else{
    include 'include/mobile.head.php';
}

$elementarArea = \Alexkova\Bxready2\Elementars::getArea('compare.result','mobile.difference');
if (strlen($elementarArea) > 0){
    include($elementarArea);
}else{
    include 'include/mobile.difference.php';
}

$elementarArea = \Alexkova\Bxready2\Elementars::getArea('compare.result','mobile.props');
if (strlen($elementarArea) > 0){
    include($elementarArea);
}else{
    include 'include/mobile.props.php';
}
?>

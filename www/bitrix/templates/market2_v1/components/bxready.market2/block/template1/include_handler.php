<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

if (isset($includeAreaName) && strlen($includeAreaName)>0){
	$elementarArea = \Alexkova\Bxready2\Elementars::getArea('block',$includeAreaName.'.prolog');
	if (strlen($elementarArea) > 0){
		include($elementarArea);
	}

	$elementarArea = \Alexkova\Bxready2\Elementars::getArea('block',$includeAreaName);
	if (strlen($elementarArea) > 0){
		include($elementarArea);
	}else if(file_exists(dirname(__FILE__).'/include/elementars/'.$includeType.'/'.$includeAreaName.'.php')) {
		include('include/elementars/'.$includeType.'/'.$includeAreaName.'.php');
	}

	$elementarArea = \Alexkova\Bxready2\Elementars::getArea('block',$includeAreaName.'.epilog');
	if (strlen($elementarArea) > 0){
		include($elementarArea);
	}
}
$includeAreaName = '';
?>
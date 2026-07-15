<?php
/** @var @global CMain $APPLICATION */
global $APPLICATION;

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';


if (!empty($_REQUEST['popup_may'])) {
	$_SESSION['popup_may1'] = 1;
	echo 1;
}

if (!empty($_REQUEST['popup_febrary'])) {
	$_SESSION['popup_febrary1'] = 1;
	echo 1;
}


require $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php";

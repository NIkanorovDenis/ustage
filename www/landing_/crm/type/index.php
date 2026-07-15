<?php

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');

$APPLICATION->includeComponent(
	'bitrix:crm.router',
	'',
	[
		'root' => '/landing/crm/',
	]
);

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');

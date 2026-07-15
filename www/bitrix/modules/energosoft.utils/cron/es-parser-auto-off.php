<?php
$_SERVER["DOCUMENT_ROOT"] = realpath(dirname(__FILE__)."/../../../..");
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
define("BX_CRONTAB", true);
define("BX_NO_ACCELERATOR_RESET", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

@set_time_limit(0);
@ignore_user_abort(true);

CModule::IncludeModule("energosoft.utils");
CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog");

/*
$lockFileName = __FILE__.".lock";
$lockFileHandle = fopen($lockFileName, 'w+');
if(flock($lockFileHandle, LOCK_EX | LOCK_NB))
{
	$arStatus = ESUtils::LoadOption("status");
	$arStatus["RUN"] = "STOP";
	ESUtils::SaveOption("status", $arStatus);
	if($arStatus["RUN"] == "STOP")
	{
		$arStatus["RUN"] = "RUN";
		ESUtils::SaveOption("status", $arStatus);

		ESParser::Rigger($arStatus);
		ESParser::Anzhee($arStatus);
		ESParser::OknaAudio($arStatus);
		ESParser::GlobalEffects($arStatus);
		ESParser::Showatelier($arStatus);

		$arStatus["RUN"] = "STOP";
		ESUtils::SaveOption("status", $arStatus);
	}

	flock($lockFileHandle, LOCK_UN);
	fclose($lockFileHandle);
	unlink($lockFileName);
}
else fclose($lockFileHandle);
*/


?>
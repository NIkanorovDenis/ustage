<?php

if (empty($PROFILE_ID)) {
  return;
}

$moduleName = 'kda.importexcel';

use Bitrix\Main\Loader;

Loader::includeModule("iblock");
Loader::includeModule('catalog');
Loader::includeModule("currency");
Loader::includeModule($moduleName);

$oProfile = CKDAImportProfile::getInstance();
CKDAImportUtils::RemoveTmpFiles(0); //Remove old dirs

$arProfiles = array_map('trim', explode(',', $PROFILE_ID));


foreach($arProfiles as $PROFILE_ID)
{
	$pid = $PROFILE_ID;
	if(strlen($PROFILE_ID)==0)
	{
		echo date('Y-m-d H:i:s').": profile id is not set\r\n";
		continue;
	}

	$oProfile = CKDAImportProfile::getInstance();
	$arProfileFields = $oProfile->GetFieldsByID($PROFILE_ID);
	if($arProfileFields['ACTIVE']=='N')
	{
		echo date('Y-m-d H:i:s').": profile is not active\r\n"."Profile id = ".$PROFILE_ID."\r\n\r\n";
		continue;
	}

	$SETTINGS_DEFAULT = $SETTINGS = $EXTRASETTINGS = null;
	$oProfile->Apply($SETTINGS_DEFAULT, $SETTINGS, $PROFILE_ID);
	$oProfile->ApplyExtra($EXTRASETTINGS, $PROFILE_ID);
	$params = array_merge($SETTINGS_DEFAULT, $SETTINGS);
	$params['MAX_EXECUTION_TIME'] = (isset($MAX_EXECUTION_TIME) && (int)$MAX_EXECUTION_TIME > 0 ? $MAX_EXECUTION_TIME : 0);

	$needCheckSize = (bool)(COption::GetOptionString($moduleName, 'CRON_NEED_CHECKSIZE', 'N')=='Y');
	$needImport = true;
	if($needCheckSize)
	{
		$checkSum = $arProfileFields['FILE_HASH'];
	}

	$fileSum = '';
	$DATA_FILE_NAME = $params['URL_DATA_FILE'];
	if($params['EXT_DATA_FILE'] || $params['EMAIL_DATA_FILE'])
	{
		$newFileId = 0;
		$fileLink = '';
		if($params['EMAIL_DATA_FILE'])
		{
			if($newFileId = \Bitrix\KdaImportexcel\SMail::GetNewFile($params['EMAIL_DATA_FILE']))
			{
				$arFile = CFile::GetFileArray($newFileId);
				$fileLink = $_SERVER["DOCUMENT_ROOT"].$arFile['SRC'];
				$fileSum = md5_file($fileLink);
			}
			elseif($checkSum)
			{
				 $fileSum = $checkSum;
			}
		}
		else
		{
			$arFile = CKDAImportUtils::MakeFileArray($params['EXT_DATA_FILE'], 86400);
			if($arFile['tmp_name'] && file_exists($arFile['tmp_name'])) $fileSum = md5_file($arFile['tmp_name']);
			elseif($checkSum) $fileSum = $checkSum;
		}

		if($needCheckSize && $checkSum && $checkSum==$fileSum)
		{
			$needImport = false;
		}
		else
		{
			if(!$newFileId && $arFile)
			{
				$newFileId = CKDAImportUtils::SaveFile($arFile);
			}
		}

		if($newFileId > 0)
		{
			$arFile = CFile::GetFileArray($newFileId);
			$DATA_FILE_NAME = $arFile['SRC'];

			if($params['DATA_FILE']) CKDAImportUtils::DeleteFile($params['DATA_FILE']);

			$SETTINGS_DEFAULT['DATA_FILE'] = $newFileId;
			$SETTINGS_DEFAULT['URL_DATA_FILE'] = $DATA_FILE_NAME;
			$oProfile->Update($PROFILE_ID, $SETTINGS_DEFAULT, $SETTINGS);
		}
	}

	$arParams = array();
	if(!file_exists($_SERVER["DOCUMENT_ROOT"].$DATA_FILE_NAME))
	{
		if(defined("BX_UTF")) $DATA_FILE_NAME = $APPLICATION->ConvertCharsetArray($DATA_FILE_NAME, LANG_CHARSET, 'CP1251');
		else $DATA_FILE_NAME = $APPLICATION->ConvertCharsetArray($DATA_FILE_NAME, LANG_CHARSET, 'UTF-8');
	}
	if(!file_exists($_SERVER["DOCUMENT_ROOT"].$DATA_FILE_NAME))
	{
		if(!$needImport) echo date('Y-m-d H:i:s').": file is loaded\r\n"."Profile id = ".$PROFILE_ID."\r\n\r\n";
		else
		{
			$arParams['IMPORT_MODE'] = 'CRON';
			$ie = new CKDAImportExcel($DATA_FILE_NAME, $params, $EXTRASETTINGS, $arParams, $pid);
			$ie->GetBreakParams('finish');
			echo date('Y-m-d H:i:s').": file not exists\r\n"."Profile id = ".$PROFILE_ID."\r\n\r\n";
		}
		continue;
	}

	if(COption::GetOptionString($moduleName, 'CRON_CONTINUE_LOADING', 'N')=='Y')
	{
		$oProfile = CKDAImportProfile::getInstance();
		$arParams = $oProfile->GetProccessParamsFromPidFile($PROFILE_ID);
		if($arParams===false)
		{
			echo date('Y-m-d H:i:s').": import in process\r\n"."Profile id = ".$PROFILE_ID."\r\n\r\n";
			continue;
		}
	}
	if(!is_array($arParams)) $arParams = array();
	if(empty($arParams))
	{
		if(!$needImport)
		{
			echo date('Y-m-d H:i:s').": file is loaded\r\n"."Profile id = ".$PROFILE_ID."\r\n\r\n";
			continue;
		}
		elseif($newFileId===0)
		{
			$arParams['IMPORT_MODE'] = 'CRON';
			$ie = new CKDAImportExcel($DATA_FILE_NAME, $params, $EXTRASETTINGS, $arParams, $pid);
			$ie->GetBreakParams('finish');
			echo date('Y-m-d H:i:s').": file not exists\r\n"."Profile id = ".$PROFILE_ID."\r\n\r\n";
			continue;
		}
	}

	if(!$oProfile->UpdateFileSettings($params, $EXTRASETTINGS, $DATA_FILE_NAME, $PROFILE_ID, true))
	{
		$oProfile->SetImportParams($pid, false, array('IMPORT_MODE'=>'CRON'));
		$oProfile->OnBreakImport('HEADERS_CHANGED');
		echo date('Y-m-d H:i:s').": file headers changed\r\n"."Profile id = ".$PROFILE_ID."\r\n\r\n";
		continue;
	}

	$arParams['IMPORT_MODE'] = 'CRON';
	$arResult = CKDAImportExcelRunner::ImportIblock($DATA_FILE_NAME, $params, $EXTRASETTINGS, $arParams, $pid);

	if(COption::GetOptionString($moduleName, 'CRON_REMOVE_LOADED_FILE', 'N')=='Y')
	{
		if(file_exists($_SERVER["DOCUMENT_ROOT"].$DATA_FILE_NAME))
		{
			unlink($_SERVER["DOCUMENT_ROOT"].$DATA_FILE_NAME);
		}

		if($params['EXT_DATA_FILE'])
		{
			$fn = $params['EXT_DATA_FILE'];
			if(is_file($fn)) unlink($fn);
			elseif(is_file($_SERVER["DOCUMENT_ROOT"].$fn)) unlink($_SERVER["DOCUMENT_ROOT"].$fn);
		}
	}

	echo date('Y-m-d H:i:s').": import complete\r\n"."Profile id = ".$PROFILE_ID."\r\n".CUtil::PhpToJSObject($arResult)."\r\n\r\n";
}

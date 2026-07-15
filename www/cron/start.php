<?php
$_SERVER['DOCUMENT_ROOT'] = __DIR__.'/../';
$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];

error_reporting(0);
ini_set('log_errors','On');
ini_set('display_errors','Off');
ini_set('display_startup_errors','Off');
ini_set('error_reporting', E_ALL );

define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);
define('BX_CRONTAB', true);
define('BX_NO_ACCELERATOR_RESET', true);

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

//@set_time_limit(0);
ini_set('max_execution_time', '5400'); //90 минут максимум (чтоб не висли другие)
ini_set('memory_limit', '16G'); 

@ignore_user_abort(true);

CModule::IncludeModule('energosoft.utils');
CModule::IncludeModule('iblock');
CModule::IncludeModule('catalog');

$type = htmlentities($_GET['type']);

if (empty($type) && !empty($argv) && !empty($argv[1])) {
	$type = htmlentities($argv[1]);
}

if (empty($type)) {

    $arStatus = ESUtils::LoadOption('status');
    var_dump($arStatus);

	exit;
}

echo '==========='.$type.'===========';

//Запись в лог текстовый
function cron_log($text) {
    if (empty($text)) return;
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/cron/logs.txt' , date("Y-m-d H:i:s").' '.$text.PHP_EOL , FILE_APPEND );
}

$lockFileName = __FILE__ . '.lock';
$lockFileHandle = fopen($lockFileName, 'w+');

if (flock($lockFileHandle, LOCK_EX | LOCK_NB) || 1 == 1) {
    $arStatus = ESUtils::LoadOption('status');
    if (empty($arStatus)) $arStatus = [];
    $arStatus['RUN'] = 'STOP';
    ESUtils::SaveOption('status', $arStatus);

    $arStatus = ESUtils::LoadOption('status');

    $arStatus['RUN'] = 'RUN';
    ESUtils::SaveOption('status', $arStatus);

    ESParser::clean(null, 300);
    ESParser::cleanResizeCache();
	
	if ($type == 'anzhee') {
        ini_set('max_execution_time', '5400');

        cron_log('Anzhee start');
		ESParser::AnzheeUpdatePrice($arStatus);  
        ESParser::Anzhee($arStatus);
        cron_log('Anzhee end');
    }
	elseif ($type == 'anzhee-price') {
        cron_log('Anzhee price start');
        ESParser::AnzheeUpdatePrice($arStatus);
        cron_log('Anzhee price end');
	}
    elseif ($type == 'eds') {
		cron_log('EDS start');
        ESParser::EDS($arStatus);
        cron_log('EDS end');
    }
    elseif ($type == 'okna') {
		ini_set('max_execution_time', '10800'); //180 минут (3 часа)
        cron_log('OknaAudio start');
        ESParser::OknaAudio($arStatus);
        cron_log('OknaAudio end');
    }
    elseif ($type == 'okna-eds') {
		ini_set('max_execution_time', '10800'); //180 минут (3 часа)
        cron_log('OknaAudio start');
        ESParser::OknaAudio($arStatus);
        cron_log('OknaAudio end');

        cron_log('EDS start');
        ESParser::EDS($arStatus);
        cron_log('EDS end');
    }
    elseif($type == 'ltm'){
        cron_log('LTM start');
        ESParser::LTM($arStatus);
        cron_log('LTM end');
    }
    elseif($type == 'slami'){
        cron_log('Slami start');
        ESParser::Slami($arStatus);
        cron_log('Slami end');
    }
    elseif ($type == 'invask') {
        cron_log('Invask start');
        ESParser::Invask($arStatus);
        cron_log('Invask end');
    }
    elseif ($type == 'rigger') {
        cron_log('Rigger start');
        ESParser::Rigger($arStatus);
        cron_log('Rigger end');
    }
    elseif ($type == 'globaleffects') {
        cron_log('GlobalEffects start');
        ESParser::GlobalEffects($arStatus);
        cron_log('GlobalEffects end');
    }
    elseif ($type == 'showatelier') {
        cron_log('Showatelier start');
        ESParser::Showatelier($arStatus);
        cron_log('Showatelier end');
    }
    elseif ($type == 'imlight') {
		ini_set('max_execution_time', '10800'); //180 минут (3 часа)
        cron_log('Imlight start');
        ESParser::Imlight($arStatus);
        cron_log('Imlight end');
    }	

    $arStatus['RUN'] = 'STOP';
    ESUtils::SaveOption('status', $arStatus);

    if ($type == 'add_anzhee') {
        cron_log('AnzheeAdd start');
        ESParser::AnzheeAdd();
        cron_log('AnzheeAdd end');
    }
    elseif ($type == 'add_rigger') {
        cron_log('RiggerAdd start');
        ESParser::RiggerAdd();
        cron_log('RiggerAdd end');
    }
    elseif ($type == 'add_globaleffects') {
        cron_log('GlobalEffectsAdd start');
        ESParser::GlobalEffectsAdd();
        cron_log('GlobalEffectsAdd end');
    }
    elseif ($type == 'add_showatelier') {
        cron_log('ShowatelierAdd start');
        ESParser::ShowatelierAdd();
        cron_log('ShowatelierAdd end');
    }
    elseif ($type == 'add_slami') {
        cron_log('SlamiAdd start');
        ESParser::SlamiAdd();
        cron_log('SlamiAdd end');
    }
    elseif ($type == 'add_ltm') {
        cron_log('LTMAdd start');
        ESParser::LTMAdd();
        cron_log('LTMAdd end');
    }
    elseif ($type == 'add_okna') {
        ini_set('max_execution_time', '10800'); //180 минут (3 часа)

        cron_log('OknaAudioAdd start');
        ESParser::OknaAudioAdd();
        cron_log('OknaAudioAdd end');
    }

    flock($lockFileHandle, LOCK_UN);
    fclose($lockFileHandle);

    unlink($lockFileName);
}
else {
  fclose($lockFileHandle);
}

if ($type == 'import') {

  ini_set('max_execution_time', '10800'); //3 часа

  /* --- Импорт остатоков тп --- */  
  cron_log('Import start 5');
  $PROFILE_ID = 5;
  require $_SERVER['DOCUMENT_ROOT'] . '/cron/import.php';
  cron_log('Import 5 end');

  /* --- Импорт остатоков --- */ 
  cron_log('Import start 6');
  $PROFILE_ID = 6;
  require $_SERVER['DOCUMENT_ROOT'] . '/cron/import.php';
  cron_log('Import 6 end');

  //ESParser::OknoAudioDownloadPriceList();

  /*cron_log('Import start 1');
  $PROFILE_ID = 1;
  require $_SERVER['DOCUMENT_ROOT'] . '/cron/import.php';
  cron_log('Import 1 end');*/

  cron_log('Update price limit start');
  require $_SERVER['DOCUMENT_ROOT'] . '/cron/update_price_limit.php';
  cron_log('Update price limit end');

  /* --- После обновления количества Okna нужно обновить парсер Invask (из-за общих товаров) --- */
  $arStatus = ESUtils::LoadOption('status');
  /*cron_log('Invask (after import) start');
  ESParser::Invask($arStatus);
  cron_log('Invask (after import) end');*/
  /* --- // --- */
  // ESParser::Anzhee($arStatus);

  ESParser::Calc();
}

if ($type == 'calc'){

    ini_set('max_execution_time', '7200'); //2 часа

    cron_log('Calc start');

    require $_SERVER['DOCUMENT_ROOT'] . '/cron/update_price_limit.php';

    //calc 
    //$arStatus = ESUtils::LoadOption('calc');
    //$arStatus['RUN'] = '';
    //ESUtils::SaveOption('calc', $arStatus);

    ESParser::Calc();

    cron_log('Calc end');
}

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_after.php'; 

<?php
class Log {
  private static $logFile = 'log_update.txt';
  private static $logDir = 'cron';
  static function msg( $data , $path = null) {
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    if(!$path){
        $path = static::$logDir;
    }
    $path = $root . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR .static::$logFile;

    $fh = fopen($path, 'a');

    if (!$fh)
      return ('can\'t open file with path: '.$path);

    fwrite($fh, "\n\n" . date("d.m.Y H:i:s") . "\n");

    ((is_array($data)) || (is_object($data))) ? fwrite($fh, print_r($data, TRUE) . "\n") : fwrite($fh, $data . "\n");
    fclose($fh);

    return 'message logged';
  }

  static function clear($path = null) {
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    if(!$path){
        $path = static::$logDir;
    }
    $path = $root . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR .static::$logFile;

    $fh = fopen($path, 'w');
    if (!$fh)
    return ('can\'t open file with path: '.$path);
    fwrite($fh, "");
    fclose($fh);
  }
}
<?php


class FilesManager {


  static $cacheFiles = [];


  static function getDirectorySize( $path ) {
    $bytestotal = 0;
    $path = realpath($path);
    if ($path !== false && $path != '' && file_exists($path)) {
      foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object) {
        $bytestotal += $object->getSize();
      }
    }
    return $bytestotal;
  }

  static function DownloadFile( $fileUrl ) {
    try {
      if (empty($fileUrl)) {
        return false;
      }

      // $pathInfo = pathinfo($fileUrl);

      // do {
      //   $path = BX_TEMPORARY_FILES_DIRECTORY . md5(mt_rand()) . '_tmp_' . $pathInfo['basename'];
      // } while (file_exists($path));


      $pathInfo = pathinfo($fileUrl);
      $extension = strtolower($pathInfo['extension']);

      do {
          $filename = 'tmp. ' . md5(mt_rand());
          $path = BX_TEMPORARY_FILES_DIRECTORY . DIRECTORY_SEPARATOR . $filename;

          if ($extension) {
              $path .= '.' . $extension;
          }
      } while (file_exists($path));













      $response = file_get_contents($fileUrl, false, stream_context_create([
        'http' => [
          'ignore_errors' => true,
        ],
        'ssl' => [
          'verify_peer' => false,
          'verify_peer_name' => false,
        ],
      ]));


      if (!$response) {
        return false;
      }

      file_put_contents($path, $response);

      static::$cacheFiles[] = $path;

      return CFile::MakeFileArray($path);
    }
    catch (\Throwable $th) {
      return false;
    }
  }
  static function cleanCachedFiles() {
    foreach (static::$cacheFiles as $filePath) {
      if (!file_exists($filePath)) {
        continue;
      }

      unlink($filePath);
    }
    static::$cacheFiles = [];
  }

}
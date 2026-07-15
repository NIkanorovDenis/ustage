<?php


class CacheManager {


    protected static $cachedImages = [];

    static function MakeFileArray($image)
    {
        if (empty($image)) {
            return false;
        }





        $pathInfo = pathinfo($image);
        $extension = strtolower($pathInfo['extension']);
        

        // return $image;

        do {
            $filename = 'tmp. ' . md5(mt_rand());
            $cachedImagePath = BX_TEMPORARY_FILES_DIRECTORY . DIRECTORY_SEPARATOR . $filename;
            
            if ($extension) {
                $cachedImagePath .= '.' . $extension;
            }


            
        } while (file_exists($cachedImagePath));


        return $cachedImagePath;

        
        $response = file_get_contents($image, false, stream_context_create([
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

        file_put_contents($cachedImagePath, $response);

        self::$cachedImages[] = $cachedImagePath;

        return CFile::MakeFileArray($cachedImagePath);
    }
    static function cleanCachedImages()
    {
        foreach (self::$cachedImages as $imagePath) {
            if (!file_exists($imagePath)) {
                continue;
            }

            unlink($imagePath);
        }

        self::$cachedImages = [];
    }

}
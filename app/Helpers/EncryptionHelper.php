<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class EncryptionHelper
{
    private static function getKey()
    {
        $key = env('APP_AES_KEY');
        if (!$key) {
            throw new Exception("APP_AES_KEY is not set in .env");
        }
        return base64_decode($key);
    }

    public static function encrypt($value)
    {
        $key = self::getKey();
        return openssl_encrypt($value, 'AES-256-CBC', $key, 0, substr($key, 0, 16));
    }

    public static function decrypt($value)
    {
        $key = self::getKey();
        return openssl_decrypt($value, 'AES-256-CBC', $key, 0, substr($key, 0, 16));
    }

    public static function encryptFile($filePath)
    {
        $fileContent = Storage::get($filePath);
        $encryptedContent = Crypt::encrypt($fileContent); 
        $encryptedFilePath = $filePath . '.enc';
        Storage::put($encryptedFilePath, $encryptedContent);

        Storage::delete($filePath);

        return $encryptedFilePath; 
    }

    public static function decryptFile($encryptedFilePath)
    {
        $encryptedContent = Storage::get($encryptedFilePath); 
        $decryptedContent = Crypt::decrypt($encryptedContent); 

        return $decryptedContent;
    }
}

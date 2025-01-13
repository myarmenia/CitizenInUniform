<?php

namespace App\Helpers;

use App\Models\User;
use Auth;

class MyHelper
{

    public static function getAuthUserGoverningBodyId()
    {
        $user = Auth::user();

        $governingBodyId = $user && $user->governing_body_user ? $user->governing_body_user->governing_body_id : null;

        return $governingBodyId;
    }

    public static function getGetUserName($id)
    {
        $user = User::find($id);

        $user_name = $user ? $user->name . ' ' . $user->surname : null;

        return $user_name;
    }

    public static function addActionPermission($data)
    {

        $governingBodyId = self::getAuthUserGoverningBodyId();
        $data['governing_body_id'] = $governingBodyId;

        return $data;
    }


    public static function encryptData($data)
    {
        $key = env('ENCRYPTION_KEY');
        $iv = substr($key, 0, 16); // Первые 16 символов ключа для IV
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
        return bin2hex($encrypted);
    }


    public static function decryptData($encryptedText)
    {
        $key = env('ENCRYPTION_KEY');
        $iv = substr($key, 0, 16); // Первые 16 символов ключа для IV
        $encryptedText = hex2bin($encryptedText);
        $decrypted = openssl_decrypt($encryptedText, 'aes-256-cbc', $key, 0, $iv);
        return $decrypted;
    }


}

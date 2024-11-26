<?php

namespace App\Helpers;

use App\Models\User;
use Auth;

class MyHelper
{
    public static function binaryToDecimal($binaryString)
    {
        $substring = substr($binaryString, 9, 16); // Индексы начинаются с 0, поэтому берем с 9 символа и длиной 16

        // Преобразуем бинарную подстроку в десятичное число
        $decimal = bindec($substring);

        return $decimal;
    }

    public static function getGoverningBodyIdFromOperator()
    {
        $user = Auth::user();

        $governingBodyId = $user->governing_body_user ? $user->governing_body_user->governing_body_id : null;

        return $governingBodyId;
    }

    public static function getGetUserName($id)
    {
        $user = User::find($id);

        $user_name = $user ? $user->name . ' ' . $user->surname : null;

        return $user_name;
    }


}

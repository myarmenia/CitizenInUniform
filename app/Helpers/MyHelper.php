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


}

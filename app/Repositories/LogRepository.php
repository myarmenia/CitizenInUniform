<?php

namespace App\Repositories;

use App\Helpers\MyHelper;
use App\Interfaces\LogInterface;
use App\Models\Log;


class LogRepository implements LogInterface
{

    public function all()
    {
        $governing_body_id = MyHelper::getAuthUserGoverningBodyId();

        $request = request();
        $request = array_filter($request->all(), fn($value) => $value !== null);

        $query = Log::whereJsonDoesntContain('roles', 'super_admin');

        if($governing_body_id){
            $request['governing_body_id'] = $governing_body_id;
        }

        $query = $query->filter($request)->orderBy('id', 'desc')->get();

        return $query;
    }





}

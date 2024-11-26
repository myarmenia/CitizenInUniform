<?php

namespace App\Repositories;

use App\Interfaces\LogInterface;
use App\Models\Log;


class LogRepository implements LogInterface
{

    public function all()
    {
        $request = request();
        $request = array_filter($request->all(), fn($value) => $value !== null);

        $query = Log::filter($request)->orderBy('id', 'desc')->get();
        
        return $query;
    }





}

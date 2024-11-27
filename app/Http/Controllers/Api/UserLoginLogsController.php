<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserLoginLog;
use Illuminate\Http\Request;

class UserLoginLogsController extends Controller
{
    public function __invoke(){

        return UserLoginLog::where('email',auth()->user()->email)
                             ->orderBy('date','desc')
                             ->get()->take(5);

    }
}

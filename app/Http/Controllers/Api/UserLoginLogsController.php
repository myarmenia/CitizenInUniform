<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserLoginLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserLoginLogsController extends Controller
{
    public function __invoke(){

        return UserLoginLog::where('email',auth()->user()->email)
                             ->orderBy('date','desc')
                             ->get()->take(5)
                             ->map(function ($log) {
                                // Format the date in 'd/m/Y H:i:s' (day/month/year hour:minute:second)
                                $log->date = Carbon::parse($log->date)->format('d/m/Y H:i:s');
                                return $log;
                            });

    }
}

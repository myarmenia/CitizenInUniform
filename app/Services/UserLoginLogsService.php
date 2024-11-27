<?php
namespace App\Services;

use App\Models\UserLoginLog;
use Carbon\Carbon;

class UserLoginLogsService {
    public function getdata (){

        return UserLoginLog::where('email',auth()->user()->email)
                             ->orderBy('date','desc')
                             ->get()
                             ->take(5)
                            ;

    }

}



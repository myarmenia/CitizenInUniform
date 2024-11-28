<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserLoginLogsResource;
use App\Models\UserLoginLog;
use App\Services\UserLoginLogsService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserLoginLogsController extends BaseController
{

    public function __construct(protected UserLoginLogsService $service){}
    public function __invoke(){

        $data = $this->service->getdata();
        return $data != null ? $this->sendResponse(UserLoginLogsResource::collection($data), 'success') : $this->sendError('error');

    }
}

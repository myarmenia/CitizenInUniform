<?php

namespace App\Http\Controllers\Api\Mobile;

use App\DTO\PhoneCallDto;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\PhoneCallRequest;
use App\Services\PhoneCallService;
use Illuminate\Http\Request;

class PhoneCallController extends BaseController
{
    public function __construct(protected PhoneCallService $service)
    {

    }
    public function store(PhoneCallRequest $request){

        $data = $this->service->store(PhoneCallDto::fromPhoneCallDto($request));

        return $data != null ? $this->sendResponse([], 'success') : $this->sendError('error');
    }
}

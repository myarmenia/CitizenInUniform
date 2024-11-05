<?php

namespace App\Http\Controllers\Api\Mobile;

use App\DTO\UserDeviceDto;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\UserDeviceRequest;
use App\Services\MobileUserService;
use Illuminate\Http\Request;

class MobileUserController extends BaseController
{
    public function __construct(protected MobileUserService $service)
    {

    }
    public function mobileUserDeviceStore(UserDeviceRequest $request){

        $data = $this->service->store(UserDeviceDto::fromUserDeviceDto($request));

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');
    }
}

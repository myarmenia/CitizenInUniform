<?php

namespace App\Http\Controllers\Api\Mobile;

use App\DTO\UserDeviceDto;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\MobileUserSettingsRequest;
use App\Http\Requests\Mobile\UpdateFcmTokenRequest;
use App\Http\Requests\Mobile\UserDeviceRequest;
use App\Http\Resources\Mobile\MUserSettingsResource;
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

    public function updateFcmToken(UpdateFcmTokenRequest $request)
    {

        $data = $this->service->updateFcmToken($request->all());

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');

    }

    public function getSettings($mobile_user_id){

        $data = $this->service->getMobileUser($mobile_user_id);

        $data = $data ? new MUserSettingsResource($data) : null;

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');
    }

    public function updateSettings(MobileUserSettingsRequest $request){
        $data = $this->service->updateSettings($request->all());

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');
    }

    public function deleteAccount(){
        return $this->sendResponse([], 'success');  /// writne only for googlePlay
    }
}

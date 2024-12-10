<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Mobile\UserNotificationRequest;
use App\Http\Resources\Mobile\MUserNotificationResource;
use App\Services\MobileNotificationService;
use Illuminate\Http\Request;

class UserNotificationController extends BaseController
{

    public function __construct(protected MobileNotificationService $service)
    {

    }
    public function getUserNotifications(UserNotificationRequest $request){

        $data = $this->service->allNotifications($request->mobile_user_id);

        $data = MUserNotificationResource::collection($data);

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');

    }

    public function readNotification(Request $request){

        $data = $this->service->readNotification($request->id);

        return $data != null ? $this->sendResponse([], 'success') : $this->sendError('error');
    }

    public function destroyAll(UserNotificationRequest $request)
    {

        $data = $this->service->destroyAll($request->mobile_user_id);

        return $data != null ? $this->sendResponse([], 'success') : $this->sendError('error');

    }

}

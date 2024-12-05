<?php

namespace App\Http\Controllers\Api\Mobile;

use App\DTO\FcmNotificationDto;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\FcmNotificationRequest;
use App\Http\Requests\Mobile\UserNotificationRequest;
use App\Http\Resources\Mobile\MUserNotificationResource;
use App\Models\MobileUser;
use App\Notifications\PushNotification;
use App\Services\FcmNotificationService;
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

}

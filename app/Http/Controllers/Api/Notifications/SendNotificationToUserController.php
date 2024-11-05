<?php

namespace App\Http\Controllers\Api\Notifications;

use App\DTO\FcmNotificationDto;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\FcmNotificationRequest;
use App\Models\MobileUser;
use App\Notifications\PushNotification;
use App\Services\FcmNotificationService;
use Illuminate\Http\Request;

class SendNotificationToUserController extends BaseController
{
    public function __construct(protected FcmNotificationService $service)
    {

    }

    public function __invoke(FcmNotificationRequest $request){

        $data = $this->service->store(FcmNotificationDto::fromFcmNotificationDto($request));

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');

    }

}

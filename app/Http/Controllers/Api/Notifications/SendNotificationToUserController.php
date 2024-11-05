<?php

namespace App\Http\Controllers\Api\Notifications;

use App\Http\Controllers\Controller;
use App\Models\MobileUser;
use App\Notifications\PushNotification;
use Illuminate\Http\Request;

class SendNotificationToUserController extends Controller
{
    public function __construct(protected FcmNotificationService $service)
    {

    }

    public function __invoke(FcmNotificationRequest $request){
        
        $data = $this->service->store(FcmNotificationDto::fromFcmNotificationDto($request));

        return $data != null ? $this->sendResponse($data, 'success') : $this->sendError('error');
        $mobileUsers = MobileUser::all();
        // Отправляем уведомление каждому пользователю
        foreach ($mobileUsers as $user) {
            // $user->notify(new PushNotification($mobile_user_id, $title, $content));
            try {
                $user->notify(new PushNotification( $title, $content));
            } catch (\Exception $e) {
                dump('Notification error: ' . $e->getMessage());
            }
        }

        
    }

}

<?php

namespace App\Http\Controllers\Api\Notifications;

use App\Http\Controllers\Controller;
use App\Models\MobileUser;
use App\Notifications\PushNotification;
use Illuminate\Http\Request;

class SendNotificationToUserController extends Controller
{

    public function __invoke(Request $request){
        $title = $request->input('title');
        $content = $request->input('content');
        $mobile_user_id = $request->input('mobile_user_id');

        // Находим всех мобильных пользователей
        // $mobileUsers = MobileUser::all();
        $mobileUsers = MobileUser::find(1);


        // Отправляем уведомление каждому пользователю
        // foreach ($mobileUsers as $user) {
            // $user->notify(new PushNotification($mobile_user_id, $title, $content));
            try {
                $mobileUsers->notify(new PushNotification($mobile_user_id, $title, $content));
            } catch (\Exception $e) {
                dd('Notification error: ' . $e->getMessage());
            }
        // }

        return response()->json(['status' => 'success', 'message' => 'Уведомления отправлены всем мобильным пользователям']);
    }

}

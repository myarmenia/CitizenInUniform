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

        // Находим всех мобильных пользователей
        $mobileUsers = MobileUser::all();

        // Отправляем уведомление каждому пользователю
        foreach ($mobileUsers as $user) {
            $user->notify(new PushNotification($title, $content));
        }

        return response()->json(['status' => 'success', 'message' => 'Уведомления отправлены всем мобильным пользователям']);
    }

}

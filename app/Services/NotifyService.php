<?php
namespace App\Services;

// use Kreait\Firebase\Messaging\CloudMessage;
// use Kreait\Firebase\Messaging\RegistrationToken;
// use Kreait\Firebase\Messaging\Notification;
// use Kreait\Firebase\Exception\Messaging\SendException;
// use Log;
// use Kreait\Firebase\Factory;

use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Log;
class NotifyService
{


    public static function sendNotification()
    {

        $deviceToken = 'f9QOSx3lSwOv2XpxwW0iTo:APA91bE4Lg66byiaA-SP6CQYIcdB9vnuJJuS-kR-FL1GyNoR78kQY5WDwLNY8eexNQm6xh0GI191TDqnP4AhhD8PMbgyvXyUi-LQc2Uj6TFpePmoSLWwtfI';  // Токен устройства получателя

        $notification = Notification::create('Заголовок уведомления', 'Текст уведомления');
        $message = CloudMessage::withTarget('token', $deviceToken)
            ->withNotification($notification);

        try {

            Firebase::messaging()->send($message);
            Log::info("FCM message created: " . print_r($message, true));

        } catch (\Exception $e) {
          
            return response()->json(['error' => $e->getMessage()]);
        }
    }

}

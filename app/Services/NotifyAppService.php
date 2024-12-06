<?php

namespace App\Services;


use App\Interfaces\FcmNotificationInterface;
use App\Interfaces\MobileUserInterface;
use App\Models\MobileUser;
use App\Models\Notification;
use App\Notifications\PushNotification;
use Illuminate\Http\Request;
use Str;

// ============================================
use Kreait\Firebase\Factory;

class NotifyAppService
{




    public function store()
    {

        $mobileUsers = MobileUser::all();


        foreach ($mobileUsers as $user) {

            try {

                if (!$user->fcm_token) {
                    throw new \Exception('FCM token is missing');
                }


                // ==============================================
                $factory = (new Factory())->withServiceAccount(env('FIREBASE_CREDENTIALS'));
                $messaging = $factory->createMessaging();

                $message = [
                    'token' => $user->fcm_token,
                    'notification' => [
                        'title' => 'Title',
                        'body' => 'Message body',
                        'sound' => '', // Указываем звук
                    ],
                    'data' => [
                        'key' => 'value',
                    ],
                ];

                $messaging->send($message);

            } catch (\Exception $e) {
                \Log::channel('notify')->error('Notification error for user ' . $user->id . ': ' . $e->getMessage());
            }
        }

        return true;

    }

    function getKey()
    {
        $currentMilliseconds = time();

        $randomFiveDigits = rand(10000, 99999);

        $key = $currentMilliseconds . $randomFiveDigits;

        return $key;
    }

}

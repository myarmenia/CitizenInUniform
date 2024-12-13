<?php

namespace App\Services;


use App\Interfaces\FcmNotificationInterface;
use App\Interfaces\MobileUserInterface;
// use App\Models\Notification;
use App\Notifications\PushNotification;

use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Log;

class FcmNotificationService
{
    public function __construct(
        protected FcmNotificationInterface $fcmNotificationRepository,
        protected MobileUserInterface $mobileUserRepository

    ) {
    }

    public function index()
    {
        return $this->fcmNotificationRepository->index();
    }

    public function store($data)
    {

        $mobileUsers = $this->mobileUserRepository->getAllMobileUsersWithActiveSettings();
        $key = $this->getKey();

        foreach ($mobileUsers as $user) {

            try {

                if (!$user->fcm_token) {
                    throw new \Exception('FCM token is missing');
                }

                $data->mobile_user_id = $user->id;
                $data->key = $key;

                $this->fcmNotificationRepository->store($data->toArray());

                $user_notify_sound = $user->mobile_user_active_setting->sound;
                $data->sound = $user_notify_sound ? 'default' : '';

                $notify = $user->notify(new PushNotification( $data));

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


    public function sendNotification($data)
    {
        $mobileUsers = $this->mobileUserRepository->getAllMobileUsersWithActiveSettings();
        $key = $this->getKey();

        foreach ($mobileUsers as $user) {

            try {

                if (!$user->fcm_token) {
                    throw new \Exception('FCM token is missing');
                }

                $deviceToken = $user->fcm_token;
                $data->mobile_user_id = $user->id;
                $data->key = $key;

                $this->fcmNotificationRepository->store($data->toArray());

                $user_notify_sound = $user->mobile_user_active_setting->sound;
                // $data->sound = $user_notify_sound ? 'default' : '';

                $notification = Notification::create($data->title, $data->content);
                $message = CloudMessage::withTarget('token', $deviceToken)
                    ->withNotification($notification)
                    ->withData([
                        'title' => $data->title, // Дополнительные данные, если нужны
                        'content' => $data->content
                    ])
                    ->withAndroidConfig([

                        'notification' => [
                            'sound' => '', // Отключаем звук на Android
                            'channelId' => $user_notify_sound ? 'default' : 'silent'
                        ]
                    ])
                    ->withApnsConfig([
                        'payload' => [
                            'aps' => [
                                'sound' => '', // Отключаем звук на iOS
                                'channelId' => $user_notify_sound ? 'default' : ''

                            ]
                        ]
                    ]);

                Firebase::messaging()->send($message);



            } catch (\Exception $e) {
                Log::channel('notify')->error('Notification error for user ' . $user->id . ': ' . $e->getMessage());
            }
        }

        return true;

    }
}

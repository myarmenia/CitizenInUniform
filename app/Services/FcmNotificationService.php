<?php

namespace App\Services;


use App\Interfaces\FcmNotificationInterface;
use App\Interfaces\MobileUserInterface;
use App\Models\MobileUser;
use App\Models\Notification;
use App\Notifications\PushNotification;
use Illuminate\Http\Request;
use Str;

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

}

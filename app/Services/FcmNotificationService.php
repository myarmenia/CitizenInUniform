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
        $user = MobileUser::find(13);
        // foreach ($mobileUsers as $user) {

            try {

                $data->mobile_user_id = $user->id;
                $data->key = $key;

                $this->fcmNotificationRepository->store($data->toArray());

                $notify = $user->notify(new PushNotification( $data));

            } catch (\Exception $e) {
                dd(888);
                dump('Notification error: ' . $e->getMessage());
            }
        // }

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

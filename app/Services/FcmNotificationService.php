<?php

namespace App\Services;


use App\Interfaces\FcmNotificationInterface;
use App\Interfaces\MobileUserInterface;
use App\Notifications\PushNotification;
use Illuminate\Http\Request;

class FcmNotificationService
{
    public function __construct(
        protected FcmNotificationInterface $fcmNotificationRepository,
        protected MobileUserInterface $mobileUserRepository

    ) {
    }

    public function store($data)
    {

        $mobileUsers = $this->mobileUserRepository->getAll();

        foreach ($mobileUsers as $user) {

            try {

                $data->mobile_user_id = $user->id;

                $this->fcmNotificationRepository->store($data->toArray());

                $user->notify(new PushNotification( $data));

            } catch (\Exception $e) {
                dump('Notification error: ' . $e->getMessage());
            }
        }

        return true;

    }


}

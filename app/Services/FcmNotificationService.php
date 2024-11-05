<?php

namespace App\Services;


use App\Interfaces\CategoryInterface;
use App\Interfaces\FcmNotificationInterface;
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

                $this->fcmNotificationRepository->store($data->toArray());

                $user->notify(new PushNotification( $data));

            } catch (\Exception $e) {
                dump('Notification error: ' . $e->getMessage());
            }
        }

        return true;

        // return $this->fcmNotificationRepository->store($data->toArray());
    }

  
}

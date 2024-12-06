<?php
namespace App\Services;

use App\Interfaces\MobileUserNotificationInterface;

class MobileNotificationService
{
    public function __construct(protected MobileUserNotificationInterface $mobileUserNotificationRepository ){
    }

    public function allNotifications($mobile_user_id)
    {

        return $this->mobileUserNotificationRepository->getUnreadNotifications($mobile_user_id);
    }

    public function readNotification($id){
        return $this->mobileUserNotificationRepository->readNotification($id);
    }

    public function destroyAll($mobile_user_id)
    {
        return $this->mobileUserNotificationRepository->destroyAll($mobile_user_id);

    }

}

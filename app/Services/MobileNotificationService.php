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

}

<?php

namespace App\Interfaces;

interface MobileUserNotificationInterface
{
    public function getUnreadNotifications($mobile_user_id);
    public function readNotification($mobile_user_id);
    public function deleteAll($mobile_user_id);


}

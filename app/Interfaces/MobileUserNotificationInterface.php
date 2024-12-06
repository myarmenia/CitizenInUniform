<?php

namespace App\Interfaces;

interface MobileUserNotificationInterface
{
    public function getMobileUser($mobile_user_id);
    public function getUnreadNotifications($mobile_user_id);
    public function readNotification($mobile_user_id);
    public function destroyAll($mobile_user_id);


}

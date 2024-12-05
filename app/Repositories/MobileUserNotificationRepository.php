<?php

namespace App\Repositories;

use App\Interfaces\MobileUserNotificationInterface;
use App\Models\Notification;

class MobileUserNotificationRepository implements MobileUserNotificationInterface
{
    public function getUnreadNotifications($mobile_user_id)
    {
        return Notification::where('mobile_user_id', $mobile_user_id)->whereNull('read_at')->get();

    }
    public function readNotification($id): Notification
    {
        $notification = Notification::find($id);
        return $notification->update(['read_at' => now()]);
    }

    public function deleteAll($mobile_user_id): Notification
    {
        $notifications = $this->getUnreadNotifications($mobile_user_id);
        return $notifications->delete();
    }

}

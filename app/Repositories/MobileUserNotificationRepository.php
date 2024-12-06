<?php

namespace App\Repositories;

use App\Interfaces\MobileUserNotificationInterface;
use App\Models\MobileUser;
use App\Models\Notification;

class MobileUserNotificationRepository implements MobileUserNotificationInterface
{
    public function getMobileUser($mobile_user_id): MobileUser|null
    {
        $user = MobileUser::find($mobile_user_id);

        return $user;
    }

    public function getUnreadNotifications($mobile_user_id)
    {
        $user = MobileUser::find($mobile_user_id);
        
        return $user ? $user->notifications->whereNull('read_at') : false;

    }
    public function readNotification($id): bool
    {
        $notification = Notification::find($id);

        return $notification ? $notification->update(['read_at' => now()]) : false;
    }

    public function destroyAll($mobile_user_id): bool
    {
        $user = $this->getMobileUser($mobile_user_id);

        return $user ? $user->notifications()->delete() : false;
    }

}

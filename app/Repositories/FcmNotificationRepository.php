<?php

namespace App\Repositories;

use App\Interfaces\FcmNotificationInterface;
use App\Models\Notification;

class FcmNotificationRepository implements FcmNotificationInterface
{
    public function store($data): Notification
    {
        return Notification::create($data);
    }

}

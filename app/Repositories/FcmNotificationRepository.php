<?php

namespace App\Repositories;

use App\Interfaces\FcmNotificationInterface;
use App\Models\Notification;

class FcmNotificationRepository implements FcmNotificationInterface
{
    public function index()
    {
        return Notification::all()->unique('key')->sortByDesc('id')->values();

    }
    public function store($data): Notification
    {
        return Notification::create($data);
    }

}

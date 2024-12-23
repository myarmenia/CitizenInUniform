<?php

namespace App\Repositories;

use App\Helpers\MyHelper;
use App\Interfaces\FcmNotificationInterface;
use App\Models\Notification;

class FcmNotificationRepository implements FcmNotificationInterface
{
    public function index()
    {
        return Notification::where('setting_id', '!=', 4)->get()->unique('key')->sortByDesc('id')->values();

    }
    public function store($data): Notification
    {
        $governing_bory_id = MyHelper::getAuthUserGoverningBodyId();

        $data['governing_body_id'] = $governing_bory_id;

        return Notification::create($data);
    }

}

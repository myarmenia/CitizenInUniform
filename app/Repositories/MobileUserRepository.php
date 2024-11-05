<?php

namespace App\Repositories;

use App\Interfaces\MobileUserInterface;
use App\Models\MobileUser;


class MobileUserRepository implements MobileUserInterface
{
    public function getAll()
    {
        return MobileUser::all();
    }


    public function store($data): MobileUser
    {
        return MobileUser::create($data);
    }

    public function getAllMobileUsersWithActiveSettings()
    {
        return MobileUser::whereHas('mobile_user_active_settings')->get();
    }
}

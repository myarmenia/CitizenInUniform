<?php

namespace App\Repositories;

use App\Interfaces\MobileUserInterface;
use App\Models\MobileUser;


class MobileUserRepository implements MobileUserInterface
{
    public function getAll(): MobileUser
    {
        return MobileUser::all();
    }


    public function store($data): MobileUser
    {
        return MobileUser::create($data);
    }
}

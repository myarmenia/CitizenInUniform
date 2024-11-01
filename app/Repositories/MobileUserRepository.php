<?php

namespace App\Repositories;

use App\Interfaces\MobileUserInterface;
use App\Models\MobileUser;


class MobileUserRepository implements MobileUserInterface
{

    public function store($data): MobileUser
    {
        return MobileUser::create($data);
    }
}

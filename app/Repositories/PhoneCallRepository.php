<?php

namespace App\Repositories;

use App\Interfaces\PhoneCallInterface;
use App\Models\PhoneCall;


class PhoneCallRepository implements PhoneCallInterface
{
    public function store($data): PhoneCall
    {
        return PhoneCall::create($data);
    }

}

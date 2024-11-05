<?php

namespace App\Repositories;

use App\Interfaces\FcmNotificationInterface;
use App\Models\Category;


class FcmNotificationRepository implements FcmNotificationInterface
{

    
    public function store($data): Category
    {
        return Category::create($data);
    }

}

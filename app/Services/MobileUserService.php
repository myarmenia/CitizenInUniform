<?php

namespace App\Services;


use App\Interfaces\MobileUserInterface;
use Illuminate\Http\Request;

class MobileUserService
{
    public function __construct(
        protected MobileUserInterface $mobileUserRepository
    ) {
    }


    public function store($data)
    {
       
        return $this->mobileUserRepository->store($data->toArray());
    }


}

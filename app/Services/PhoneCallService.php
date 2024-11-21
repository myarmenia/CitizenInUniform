<?php

namespace App\Services;


use App\Interfaces\PhoneCallInterface;

class PhoneCallService
{
    public function __construct(
        protected PhoneCallInterface $phoneCallRepository
    ) {
    }

    // public function index()
    // {
    //     return $this->categorryRepository->index();
    // }

    public function store($data)
    {
       return $this->phoneCallRepository->store($data->toArray());
    }



}

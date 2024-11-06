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
        $monile_user = $this->mobileUserRepository->getSingle($data->device_id);

        if($mobile_user){
            $this->mobileUserRepository->delete($data->device_id);
        }

        return $this->mobileUserRepository->store($data->toArray());
    }


}

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
        $mobile_user = $this->mobileUserRepository->getSingle($data->device_id);

        if($mobile_user){
            $this->mobileUserRepository->destroy($data->device_id);
        }

        return $this->mobileUserRepository->store($data->toArray());
    }

    public function updateFcmToken($data)
    {
        return $this->mobileUserRepository->updateFcmToken($data);
    }

    public function getMobileUser($mobile_user_id)
    {
        return $this->mobileUserRepository->getMobileUser($mobile_user_id);
    }

    public function updateSettings($data)
    {
        return $this->mobileUserRepository->updateSettings($data);
    }


}

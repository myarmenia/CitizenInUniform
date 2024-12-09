<?php

namespace App\Repositories;

use App\Interfaces\MobileUserInterface;
use App\Models\MobileUser;


class MobileUserRepository implements MobileUserInterface
{

    public function getMobileUser($mobile_user_id)
    {
        $user = MobileUser::find($mobile_user_id);

        return $user;
    }

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
        return MobileUser::whereHas('mobile_user_active_setting')->get();
    }

    public function getSingle($device_id)
    {
        return MobileUser::where('device_id', $device_id)->first();
    }

    public function destroy($device_id)
    {

        return MobileUser::where('device_id', $device_id)->first()->delete();
    }


    public function updateFcmToken($data)
    {
        $user = $this->getMobileUser($data['user_id']);

        return $user ? $user->update(['fcm_token' => $data['fcm_token']]) : false;
    }

    public function updateSettings($data)
    {
        $user = $this->getMobileUser($data['mobile_user_id']);

        return $user ? $user->mobile_user_setting->update($data) : false;

    }
}

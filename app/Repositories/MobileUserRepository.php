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

        $user = MobileUser::find($data['user_id']);

        return $user ? $user->update(['fcm_token' => $data['fcm_token']]) : false;
    }
}

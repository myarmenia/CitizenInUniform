<?php

namespace App\Interfaces;

interface MobileUserInterface
{
    public function getMobileUser($mobile_user_id);
    public function getAll();
    public function store($data);
    public function getAllMobileUsersWithActiveSettings();
    public function getSingle($id);
    public function destroy($id);
    public function updateFcmToken($data);
    public function updateSettings($data);



}

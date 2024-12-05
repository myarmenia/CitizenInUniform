<?php

namespace App\Repositories;

use App\Interfaces\SettingInterface;
use App\Models\Setting;


class SettingRepository implements SettingInterface
{
    public function get(){
        return Setting::where('id', '!=', 4)->get();
    }



}

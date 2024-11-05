<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class MobileUser extends Model
{
    use SoftDeletes, Notifiable;
    protected $guarded = [];

    public function routeNotificationForFcm()
    {
        return $this->device_id; // Убедитесь, что у вас есть поле fcm_token
    }

    public function mobile_user_settings(): HasMany
    {
        return $this->hasMany(MobileUserSetting::class);
    }

    public function mobile_user_active_settings(): HasMany
    {
        return $this->hasMany(MobileUserSetting::class)->where('status', 1);
    }
}

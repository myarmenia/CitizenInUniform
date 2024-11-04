<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class MobileUser extends Model
{
    use SoftDeletes, Notifiable;
    protected $guarded = [];

    // public function routeNotificationForFcm()
    // {
    //     return $this->mobile_user_id; // Убедитесь, что у вас есть поле fcm_token
    // }

}

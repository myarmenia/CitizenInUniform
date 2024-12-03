<?php

namespace App\Models;

use App\Traits\FilterTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class MobileUser extends Model
{
    use SoftDeletes, Notifiable, FilterTrait;
    protected $guarded = [];
    protected $defaultFillableFields = ['type'];

    public function routeNotificationForFcm()
    {
        // return $this->device_id; // Убедитесь, что у вас есть поле fcm_token
        $token = 'eWPj6UzmQvOVj6pPZBpKUu:APA91bEBWYExqdcD3nrxoNMDXcOIMGvalqD2f1RYd8zoCSJpdIxQr7fLiKmtrNgjL4TmoxbRIjycdgqtRvKFT_HhCCE_1MviGhOW40plOtWyf5AQuR2xSd0';
        return $token;
    }

    public function mobile_user_setting(): HasOne
    {
        return $this->HasOne(MobileUserSetting::class);
    }

    public function mobile_user_active_setting(): HasOne
    {
        return $this->HasOne(MobileUserSetting::class)->where('status', 1);
    }


    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($m_user) {
            $m_user->mobile_user_setting()->delete();
        });

        static::created(function ($m_user) {

            $m_user->mobile_user_setting()->create();
        });


    }
}

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
        return $this->fcm_token;
    }

    public function mobile_user_setting(): HasOne
    {
        return $this->HasOne(MobileUserSetting::class);
    }

    public function mobile_user_active_setting(): HasOne
    {
        return $this->HasOne(MobileUserSetting::class)->where('status', 1);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
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

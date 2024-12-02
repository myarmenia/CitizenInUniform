<?php

namespace App\Models;

use App\Observers\BaseModelObserver;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['confirmPassword'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function governing_body_user(): HasOne
    {
        return $this->hasOne(GoverningBodyUser::class);
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class, 'operator_id');
    }

    public function canAccessGoverningId($governingId): bool
    {
        return ($this->governing_body_user && $governingId == $this->governing_body_user->governing_body_id) ? true : false;
    }

    public function canAccessRoomId($roomId): bool
    {
        $roomIds = $this->rooms->pluck('id')->toArray();
    
        return $this->rooms && in_array($roomId, $roomIds) ? true : false;
    }

    protected static function boot()
    {
        parent::boot();

        static::observe(BaseModelObserver::class);
    }


}

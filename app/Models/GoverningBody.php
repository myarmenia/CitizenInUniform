<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoverningBody extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    public function governing_body_infos(): HasMany
    {
        return $this->hasMany(GoverningBodyInfo::class);
    }

    public function governing_body_email(): HasOne
    {
        return $this->hasOne(GoverningBodyInfo::class)->where('type', 'email');
    }

    public function governing_body_phone_numbers(): HasMany
    {
        return $this->hasMany(GoverningBodyInfo::class)->where('type', 'phone');
    }
}

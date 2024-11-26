<?php

namespace App\Models;

use App\Observers\BaseModelObserver;
use Illuminate\Database\Eloquent\Model;

class GoverningBodyUser extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::observe(BaseModelObserver::class);

    }

}

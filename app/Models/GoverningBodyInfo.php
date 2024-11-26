<?php

namespace App\Models;

use App\Observers\BaseModelObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoverningBodyInfo extends Model
{
    use SoftDeletes;
    protected $guarded = ['data'];
    protected static function boot()
    {
        parent::boot();

        static::observe(BaseModelObserver::class);

    }

}

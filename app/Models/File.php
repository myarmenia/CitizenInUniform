<?php

namespace App\Models;

use App\Observers\BaseModelObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;
    protected $guarded = [];


    protected static function boot()
    {
        parent::boot();

        static::observe(BaseModelObserver::class);

    }
}

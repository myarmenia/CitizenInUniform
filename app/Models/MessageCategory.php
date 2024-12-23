<?php

namespace App\Models;

use App\Observers\BaseModelObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessageCategory extends Model
{
    use SoftDeletes;
    protected $guarded = [];



    public function email_messages(): HasMany
    {
        return $this->hasMany(EmailMessages::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::observe(BaseModelObserver::class);
    }

}

<?php

namespace App\Models;

use App\Observers\BaseModelObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::observe(BaseModelObserver::class);

    }

}

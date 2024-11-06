<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Notification extends Model
{
    use SoftDeletes, Notifiable;
    protected $guarded = [];

    public function setting(): BelongsTo
    {
        return $this->belongsTo(Setting::class);
    }

}

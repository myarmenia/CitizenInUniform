<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MobileUserSetting extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    // public function mobile_user(): BelongsTo
    // {
    //     return $this->belongsTo(MobileUser::class);
    // }

}

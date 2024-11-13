<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailMessages extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function message_category(): BelongsTo
    {
        return $this->belongsTo(MessageCategory::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(EmailMessageAnswer::class, 'email_message_id');
    }

}

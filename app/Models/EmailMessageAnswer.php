<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmailMessageAnswer extends Model
{
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function email_message(): BelongsTo
    {
        return $this->belongsTo(EmailMessages::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($answer) {

            $answer->email_message->update(['has_answer' => 1]);
        });


    }

}

<?php

namespace App\Models;

use App\Observers\BaseModelObserver;
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

    public function user_withTrashed(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
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


        static::observe(BaseModelObserver::class);



    }

}

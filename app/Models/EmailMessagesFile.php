<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class EmailMessagesFile extends Model
{
    protected $guarded=[];

    public function email_messages(): BelongsTo
    {
        return $this->belongsTo(EmailMessages::class,'email_message_id');
    }
}

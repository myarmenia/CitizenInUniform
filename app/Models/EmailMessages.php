<?php

namespace App\Models;

use App\Traits\FilterTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailMessages extends Model
{
    use SoftDeletes, FilterTrait;
    protected $guarded = [];
    protected $defaultFillableFields = ['message_category_id', 'governing_body_id'];
    protected $boolFilterFields = ['has_answer'];
    protected $multiLikeFilterFields = ['email', 'content']; // mek dashtov search-i field-er
    protected $multiLikeField = ['searchText']; // mek dashtov search

    public function message_category(): BelongsTo
    {
        return $this->belongsTo(MessageCategory::class);
    }

    public function message_category_withTrashed(): BelongsTo
    {
        return $this->belongsTo(MessageCategory::class, 'message_category_id')->withTrashed();
    }

    public function governing_body(): BelongsTo
    {
        return $this->belongsTo(GoverningBody::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(EmailMessageAnswer::class, 'email_message_id');
    }
    public function email_messages_files(): HasMany

    {
        return $this->hasMany(EmailMessagesFile::class);
    }


}

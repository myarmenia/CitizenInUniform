<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EntryCode extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function entry_codes(): BelongsTo{

        return $this->belongsTo(Client::class,'client_id');
    }
}

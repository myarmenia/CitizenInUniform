<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Turnstile extends Model
{
    use HasFactory;

    protected $guarded =[];

    public function client(): BelongsTo{

        return $this->belongsTo(Client::class,foreignKey: 'client_id');
    }
}

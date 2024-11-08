<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoverningBody extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    public function governing_body_infos(): HasMany
    {
        return $this->hasMany(GoverningBodyInfo::class);
    }
}

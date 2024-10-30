<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($subCategory) {

            $subCategory->files()->delete();


        });
    }
}

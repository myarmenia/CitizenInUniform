<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function sub_categories(): HasMany
    {
        return $this->hasMany(SubCategory::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($category) {
            $category->sub_categories()->each(function ($subCategory) {
                $subCategory->delete(); // Soft delete related subcategories
            });
        });
    }

}

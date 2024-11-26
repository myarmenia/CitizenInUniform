<?php

namespace App\Models;

use App\Observers\BaseModelObserver;
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

    public function acyive_sub_categories(): HasMany
    {
        return $this->hasMany(SubCategory::class)->where('status', 1);
    }


    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($category) {
            $category->sub_categories()->each(function ($subCategory) {
                $subCategory->delete(); // Soft delete related subcategories
            });
        });

        static::updated(function ($category) {
            $newStatus = $category->status;

            if($newStatus == 0){
                $category->sub_categories()->update(['status' => $newStatus]);

            }
        });

        static::observe(BaseModelObserver::class);
    }

}

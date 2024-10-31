<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


class FAQCategory extends Model
{
    use   SoftDeletes;
    protected $guarded = [];

    public function f_a_q_sub_categories(): HasMany
    {

        return $this->hasMany(FAQSubCategory::class);
    }

    protected static function booted()
    {
        static::deleting(function ($f_a_q_categories) {


            $f_a_q_categories->f_a_q_sub_categories()->each(function ($subCategory) {
                $subCategory->delete(); // This will soft delete the subcategory
            });

        });
    }


}




<?php

namespace App\Models;

use App\Observers\BaseModelObserver;
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

        static::updated(function ($f_a_q_category) {
            $newStatus = $f_a_q_category->status;

            if ($newStatus == 0) {
                $f_a_q_category->f_a_q_sub_categories()->update(['status' => $newStatus]);

            }
        });

        static::observe(BaseModelObserver::class);

    }

    public function active_f_a_q_sub_categories(){
        return $this->hasMany(FAQSubCategory::class)->where('status',1);

    }


}




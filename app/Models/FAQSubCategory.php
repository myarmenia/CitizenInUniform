<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FAQSubCategory extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function f_a_q_category(): BelongsTo{
        return $this->belongsTo(FAQCategory::class,'f_a_q_category_id');
    }

}

<?php

namespace App\Models;

use App\Traits\FilterTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes, FilterTrait;
    protected $guarded = [];
    protected $defaultFillableFields = ['message_category_id', 'governing_body_id'];

}

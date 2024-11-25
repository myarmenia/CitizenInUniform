<?php

namespace App\Models;

use App\Traits\FilterTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhoneCall extends Model
{
    use SoftDeletes, FilterTrait;
    protected $guarded = [];
    protected $defaultFillableFields = ['governing_body_id'];

}

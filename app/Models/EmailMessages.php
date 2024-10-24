<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailMessages extends Model
{
    use SoftDeletes;
    protected $guarded = [];

}

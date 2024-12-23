<?php

namespace App\Models;

use App\Traits\FilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory, FilterTrait;
    protected $guarded = [];
    protected $defaultFillableFields = ['tb_name', 'action', 'governing_body_id'];
    protected $jsonFields = ['roles'];


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceSheet extends Model
{
    use HasFactory;

    protected $guarded =[];

    public function people(): BelongsTo{

        return $this->belongsTo(Person::class,'people_id');
    }

}

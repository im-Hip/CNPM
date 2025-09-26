<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'id',
        'name',
        'subject_id',
        'number_of_periods'
    ];
}

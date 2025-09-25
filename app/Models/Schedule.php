<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'teacher_id', 'class_id', 'room_id', 'day_of_week', 'start_time', 'end_time', 'note', 
    ];
}

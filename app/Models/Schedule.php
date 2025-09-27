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

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function classes(){
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function room(){
        return $this->belongsTo(Room::class, 'room_id');
    }
}

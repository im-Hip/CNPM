<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $table = 'classes';
    protected $fillable = ['id', 'name', 'grade', 'number_of_students'];

    public function room(){
        return $this->belongsTo(Room::class, 'room_id');
    }
}

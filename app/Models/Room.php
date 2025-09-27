<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['id', 'name', 'capacity'];

    public function classes(){
        return $this->hasOne(Classes::class, 'room_id');
    }
}

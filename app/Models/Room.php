<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['block', 'floor', 'room_no'];

    public static function boot(){
        parent::boot();

        static::creating(function ($room) {
            
        });

        static::updating(function ($room) {
            
        });
    }
}

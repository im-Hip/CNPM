<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = ['title', 'content', 'due_date', 'class_id'];

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
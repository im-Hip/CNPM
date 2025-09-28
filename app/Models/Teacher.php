<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'teacher_id', 'subject_id', 'level'];

    public function user(){
        return $this->belongsTo(User::class, 'id');
    }

    public function subject(){
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}

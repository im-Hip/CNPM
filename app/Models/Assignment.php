<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = ['teacherassignment_id', 'title', 'content', 'due_date', 'class_id'];

    public function teacherAssignment()
    {
        return $this->belongsTo(TeacherAssignment::class, 'teacherassignment_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
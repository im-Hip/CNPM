<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model {

    protected $table = 'teachers';  // Nếu có
    protected $fillable = ['id', 'subject_id'];

    public function user() {
        return $this->belongsTo(User::class, 'id');  // Hoặc 'user_id' nếu column khác
    }

    public function assignments() {
        return $this->hasMany(TeacherAssignment::class, 'teacher_id');
    }

    public function classes() {
        return $this->belongsToMany(ClassModel::class, 'teacher_assignments', 'teacher_id', 'class_id');
    }

    public function schedules() {
        return $this->hasMany(Schedule::class, 'teacher_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}

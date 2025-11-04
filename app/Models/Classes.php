<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $table = 'classes';

    protected $fillable = ['name', 'grade', 'number_of_students'];

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_assignments', 'class_id', 'teacher_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id'); // Giả sử có model Student
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'class_id');
    }

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'recipient');
    }

    public function teacherAssignments()
    {
        return $this->hasMany(TeacherAssignment::class, 'class_id');
    }
}

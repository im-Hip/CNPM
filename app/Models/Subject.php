<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subjects';
    protected $fillable = [
        'name',
        'subject_id',
        'number_of_periods'
    ];  // Thêm nếu cần

    // FIX: Relationship với assignments (phân công GV cho môn)
    public function assignments()
    {
        return $this->hasMany(TeacherAssignment::class, 'subject_id');
    }

    // Relationship với schedules (lịch học môn)
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'subject_id');
    }

    // Relationship với teachers
    public function teachers()
    {
        return $this->hasManyThrough(
        Teacher::class, 
        TeacherAssignment::class, 
        'subject_id', // Foreign key trên teacher_assignments
        'id',          // Local key trên teachers  
        'id',          // Local key trên teacher_assignments
        'teacher_id'   // Foreign key trên teacher_assignments
    );
    }

    // Relationship với teacher_assignments
    public function teacher_assignments()
    {
        return $this->hasMany(TeacherAssignment::class, 'subject_id');
    }
}
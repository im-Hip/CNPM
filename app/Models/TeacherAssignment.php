<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherAssignment extends Model
{
    protected $table = 'teacher_assignments';
    protected $fillable = ['teacher_id', 'class_id', 'subject_id', 'note'];  // Thêm subject_id, note tùy chọn

    public function teacher() {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function class() {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function subject() {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    // Query GV cho class + subject (1 GV only)
    public static function getTeacherForClassSubject($classId, $subjectId) {
        return self::where('class_id', $classId)
            ->where('subject_id', $subjectId)
            ->with('teacher.user')
            ->first()?->teacher;
    }
}
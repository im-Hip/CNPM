<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model {
    protected $table = 'schedules';
    protected $fillable = ['class_id', 'subject_id', 'teacher_id', 'room_id', 'day_of_week', 'class_period', 'note'];

    public function class() {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function subject() {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function teacher() {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function room() {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public static function availableTeachers($classId) {
        return Teacher::whereHas('assignments', function($q) use ($classId) {
            $q->where('class_id', $classId);
        })->with('user')->get();
    }
}
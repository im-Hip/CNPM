<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;

    protected $table = 'students';
    protected $primaryKey = 'id';  // id vừa là PK vừa FK
    public $incrementing = false;  // vì id lấy từ users.id nên không auto-increment
    protected $keyType = 'int';

    protected $fillable = [
        'id',
        'student_id',
        'day_of_birth',
        'gender',
        'class_id'
    ];

    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    // Quan hệ với Class
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}

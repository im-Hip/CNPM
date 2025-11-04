<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomResetPassword;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'recipient');
    }
    public function sentNotifications()
    {
        return $this->hasMany(Notification::class, 'sender_id');
    }

    // Trong class User
    public function teacher() {
        return $this->hasOne(Teacher::class, 'id');
    }
    
    public function student() {
        return $this->hasOne(Student::class, 'id');
    }
    
    public function schedules() {  // Cho teacher
        return $this->hasManyThrough(Schedule::class, Teacher::class, 'id', 'teacher_id');
    }

    public function classes() {
        return $this->belongsToMany(Classes::class, 'teacher_assignments', 'teacher_id', 'class_id', 'id', 'id')
            ->using(Teacher::class);
    }
}

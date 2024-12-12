<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'course_id',
        'student_id',
        'enrollment_date',
        'completion_date',
        'progress',
    ];
    
    // العلاقة مع الطالب
    
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function completions()
    {
        return $this->hasMany(LessonProgress::class);
    }
    public function lessons()
{
    return $this->belongsToMany(Lesson::class, 'lesson_progress');
}

}


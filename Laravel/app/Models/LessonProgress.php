<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class LessonProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrollment_id',
        'lesson_id',
        'completed_at',
    ];
    protected $casts = [
        'completed_at' => 'datetime',  // تأكد من أن `completed_at` يتم تحويله إلى كائن Carbon
    ];
    
    protected $table = 'lesson_progress';  // تحديد اسم الجدول هنا
// في نموذج LessonProgress
public function user()
{
    return $this->hasOneThrough(User::class, Enrollment::class, 'id', 'id', 'enrollment_id', 'student_id');
}

    // العلاقة مع نموذج Enrollment
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    // العلاقة مع نموذج Lesson
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}

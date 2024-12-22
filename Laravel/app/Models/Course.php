<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_name',
        'description',
        'level',
        'category_id',
        'price',
        'is_free',
        'start_date',
        'end_date',
        'instructor_id',
        'language', // إضافة لغة الكورس
        'requirements', // إضافة متطلبات الكورس
        'learning_outcomes', // إضافة نتائج التعلم
        'image'
    ];

    public function category()
    {
        return $this->belongsTo(CourseCategory::class);
    }

    
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
    
    // علاقة الدورة بالمعلم
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    // علاقة الدورة بالطلاب
    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'student_id')
                    ->withPivot('id','enrollment_date', 'completion_date', 'progress')
                    ->withTimestamps();
    }
 

  
    // علاقة مع المدفوعات
    public function payments()
    {
        return $this->hasManyThrough(Payment::class, CourseUser::class);
    }

    // علاقة مع التسجيلات
    public function courseUsers()
    {
        return $this->hasMany(CourseUser::class);
    }
    public function enrollments()
{
    return $this->hasMany(Enrollment::class);
}
  // العلاقات مع المراجعات
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function updateAverageRating()
    {
        $this->average_rating = $this->reviews()->avg('course_rating') ?? 0;
        $this->save();
    }
    
}

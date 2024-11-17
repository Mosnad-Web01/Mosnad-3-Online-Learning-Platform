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

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}

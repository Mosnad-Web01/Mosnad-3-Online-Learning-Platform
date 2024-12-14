<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    /**
     * الجدول المرتبط بهذا الموديل.
     */
    protected $table = 'reviews';

    /**
     * الحقول القابلة للتعبئة بشكل جماعي.
     */
    protected $fillable = [
        'course_id',
        'instructor_id',
        'student_id',
        'course_rating',
        'instructor_rating',
        'review_text',
    ];

    /**
     * العلاقات (Relationships).
     */

    // العلاقة مع الدورة التدريبية
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // العلاقة مع المدرس
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    // العلاقة مع الطالب
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * القيم الافتراضية للحقل عند الإنشاء.
     */
    protected $attributes = [
        'course_rating' => 1,
        'instructor_rating' => 1,
    ];
    
}

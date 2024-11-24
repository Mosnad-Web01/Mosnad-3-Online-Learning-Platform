<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseUser extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'course_id'];

    // علاقة مع المستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // علاقة مع الدورة
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // علاقة مع المدفوعات
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}

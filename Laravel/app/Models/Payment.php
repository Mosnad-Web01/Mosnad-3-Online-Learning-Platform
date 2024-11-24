<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'course_user_id', 'amount', 'status', 'payment_date'];

    // علاقة مع المستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // علاقة مع الدورة المربوطة بالطالب
    public function courseUser()
    {
        return $this->belongsTo(CourseUser::class);
    }
}

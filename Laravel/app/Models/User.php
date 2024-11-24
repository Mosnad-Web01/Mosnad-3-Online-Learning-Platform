<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',  // إضافة الدور إلى الحقول القابلة للتعبئة
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // تعيين الدور الافتراضي كـ "مُدرس" عند إنشاء المستخدم
    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->role)) {
                $user->role = 'instructor'; // تعيين الدور الافتراضي
            }
        });
    }

    // العلاقة مع المدفوعات
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // العلاقة مع التسجيلات في الدورات
    public function courseUsers()
    {
        return $this->hasMany(CourseUser::class);
    }
}

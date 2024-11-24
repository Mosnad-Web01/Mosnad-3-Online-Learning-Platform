<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // إضافة الدور إلى الحقول القابلة للتعبئة
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Boot method to handle model events.
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->role)) {
                $user->role = 'instructor'; // تعيين الدور الافتراضي
            }
        });
    }

    /**
     * Define the relationship with the Role model.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    /**
     * Define the relationship with the UserProfile model.
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Define the relationship with the Payment model.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Define the relationship with the CourseUser model.
     */
    public function courseUsers()
    {
        return $this->hasMany(CourseUser::class);
    }
}

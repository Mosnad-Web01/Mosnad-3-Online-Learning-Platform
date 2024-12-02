<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

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
        'role',
        'is_suspended',
        'suspension_reason',
        'suspension_start_date',
        'suspension_end_date',
        'suspended_by',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_suspended' => 'boolean',
        'suspension_start_date' => 'datetime',
        'suspension_end_date' => 'datetime',
    ];

    /**
     * Boot method to handle model events.
     */
    public static function boot()
    {
        parent::boot();

        // Adding a default role if not set
        static::creating(function ($user) {
            if (empty($user->role)) {
                $user->role = 'instructor'; // Default role
            }
        });
    }

    /**
     * Constants for available roles
     */
    const ROLES = ['student', 'instructor', 'admin'];

    /**
     * Role accessor for convenience.
     */
    public function getRoleAttribute($value)
    {
        return ucfirst($value);  // Ensure role is capitalized
    }

    /**
     * Relationship with the Role model.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    /**
     * Check if the user has a specific role.
     */
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    /**
     * Relationship with the UserProfile model.
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Relationship with the Payment model.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Relationship with the CourseUser model.
     */
    public function courseUsers()
    {
        return $this->hasMany(CourseUser::class);
    }

    /**
     * Relationship with the Course model.
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    /**
     * Relationship with the suspending user.
     */
    public function suspender()
    {
        return $this->belongsTo(User::class, 'suspended_by');
    }

    /**
     * Check if the user is currently suspended.
     */
    public function isCurrentlySuspended()
    {
        if (!$this->is_suspended) {
            return false;
        }

        $now = now();

        return !$this->suspension_end_date || $this->suspension_end_date->greaterThan($now);
    }
}

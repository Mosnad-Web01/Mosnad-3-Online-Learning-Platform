<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'date_of_birth',
        'address',
        'phone_number',
        'profile_picture',
        'bio'
    ];

    // العلاقة مع جدول users
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

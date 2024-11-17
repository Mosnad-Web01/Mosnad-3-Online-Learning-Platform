<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    // الحقول المسموح بتعبئتها
    protected $fillable = ['title', 'description', 'instructor_id', 'start_date', 'end_date'];
    
    // ربط الدورة بالمعلم
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }
}


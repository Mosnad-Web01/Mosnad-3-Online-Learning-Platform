<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'content',
        'video',
        'video_path',
        'images',
        'files',
        'order'
    ];

    protected $casts = [
        'images' => 'array', // لتفسير حقل الصور كصفيف
        'files' => 'array', // لتفسير حقل الملفات كصفيف
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}

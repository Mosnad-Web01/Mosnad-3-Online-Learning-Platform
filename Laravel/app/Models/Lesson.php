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

    // إضافة خصائص محسوبة للوصول إلى الروابط الأمامية
    protected $appends = ['video_url', 'images_urls', 'files_urls'];

    public function getVideoUrlAttribute()
    {
        return $this->video_path ? url('storage/' . $this->video_path) : null;
    }

    
    public function getImagesUrlsAttribute()
{
    if (!$this->images || !is_array($this->images)) {
        return [];
    }

    return array_map(function ($image) {
        // يمكنك تعديل المنطق إذا كنت بحاجة إلى معالجة إضافية
        return url('storage/' . $image);
    }, $this->images);
}

public function getFilesUrlsAttribute()
{
    if (!$this->files || !is_array($this->files)) {
        return [];
    }

    return array_map(function ($file) {
        return url('storage/' . $file);
    }, $this->files);
}
}

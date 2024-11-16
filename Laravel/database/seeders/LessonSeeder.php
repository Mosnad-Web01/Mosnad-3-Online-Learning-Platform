<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $course = Course::first(); // الحصول على أول دورة

        Lesson::create([
            'course_id' => $course->id,
            'title' => 'Introduction to Python',
            'content' => 'Learn the basics of Python programming.',
            'video_url' => 'lessons/video1.mp4', // إضافة مسار الفيديو
        ]);

        Lesson::create([
            'course_id' => $course->id,
            'title' => 'Advanced Python Programming',
            'content' => 'Dive deep into Python concepts and libraries.',
            'video_url' => 'lessons/video2.mp4',
        ]);
    }
}

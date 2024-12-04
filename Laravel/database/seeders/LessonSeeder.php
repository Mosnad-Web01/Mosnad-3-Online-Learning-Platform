<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Course;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // التأكد من وجود الدورات
        $courses = Course::all();

        // إضافة دروس لكل كورس
        foreach ($courses as $course) {
            // إضافة دروس لكل كورس (تخصيص الدروس بحسب الدورة)
            $lessons = [
                [
                    'title' => 'Introduction to ' . $course->course_name,
                    'content' => 'This is the introduction to the course ' . $course->course_name,
                    'video_path' => 'videos/intro.mp4',
                    'images' => ['https://via.placeholder.com/150?text=Intro'],
                    'files' => ['https://www.example.com/file1.pdf'],
                    'order' => 1,
                ],
                [
                    'title' => 'Lesson 1: Basics of ' . $course->course_name,
                    'content' => 'In this lesson, we will cover the basics of ' . $course->course_name,
                    'video_path' => 'videos/lesson1.mp4',
                    'images' => ['https://via.placeholder.com/150?text=Lesson+1'],
                    'files' => ['https://www.example.com/file2.pdf'],
                    'order' => 2,
                ],
                [
                    'title' => 'Lesson 2: Advanced Topics in ' . $course->course_name,
                    'content' => 'In this lesson, we will dive into advanced topics of ' . $course->course_name,
                    'video_path' => 'videos/lesson2.mp4',
                    'images' => ['https://via.placeholder.com/150?text=Lesson+2'],
                    'files' => ['https://www.example.com/file3.pdf'],
                    'order' => 3,
                ],
                [
                    'title' => 'Conclusion and Next Steps',
                    'content' => 'This lesson will wrap up the course and discuss the next steps.',
                    'video_path' => 'videos/conclusion.mp4',
                    'images' => ['https://via.placeholder.com/150?text=Conclusion'],
                    'files' => ['https://www.example.com/file4.pdf'],
                    'order' => 4,
                ]
            ];

            // إضافة الدروس إلى كل كورس
            foreach ($lessons as $lesson) {
                Lesson::create([
                    'course_id' => $course->id,
                    'title' => $lesson['title'],
                    'content' => $lesson['content'],
                    'video_path' => $lesson['video_path'],
                    'images' => $lesson['images'],
                    'files' => $lesson['files'],
                    'order' => $lesson['order'],
                ]);
            }
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\User;
use App\Models\CourseCategory;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // التأكد من وجود المستخدمين
        $instructor1 = User::where('email', 'instructor1@example.com')->first();
        $instructor2 = User::where('email', 'instructor2@example.com')->first();
        $instructor3 = User::where('email', 'instructor3@example.com')->first();

        // التأكد من وجود الفئات
        $category1 = CourseCategory::first(); // أول فئة
        $category2 = CourseCategory::skip(1)->first(); // ثاني فئة
        $category3 = CourseCategory::skip(2)->first(); // ثالث فئة

        // إضافة الدورات
        Course::create([
            'course_name' => 'Complete Web Development Bootcamp',
            'description' => 'Learn front-end and back-end web development from scratch.',
            'level' => 'Beginner',
            'category_id' => $category1->id,
            'price' => 99.99,
            'start_date' => '2024-01-01',
            'end_date' => '2024-06-01',
            'instructor_id' => $instructor1->id,
            'language' => 'English', // إضافة اللغة
            'requirements' => 'Basic understanding of computers and the internet.', // إضافة المتطلبات
            'learning_outcomes' => 'Build fully responsive websites and web applications.', // إضافة نتائج التعلم
        ]);

        Course::create([
            'course_name' => 'Mastering Data Science with Python',
            'description' => 'Learn how to use Python for Data Science and Machine Learning.',
            'level' => 'Intermediate',
            'category_id' => $category2->id,
            'price' => 149.99,
            'start_date' => '2024-02-01',
            'end_date' => '2024-07-01',
            'instructor_id' => $instructor2->id,
            'language' => 'English', // إضافة اللغة
            'requirements' => 'Basic knowledge of Python programming and statistics.', // إضافة المتطلبات
            'learning_outcomes' => 'Analyze data, build machine learning models using Python.', // إضافة نتائج التعلم
        ]);

        Course::create([
            'course_name' => 'Machine Learning with TensorFlow',
            'description' => 'Understand the fundamentals of Machine Learning with TensorFlow.',
            'level' => 'Advanced',
            'category_id' => $category3->id,
            'price' => 199.99,
            'start_date' => '2024-03-01',
            'end_date' => '2024-08-01',
            'instructor_id' => $instructor3->id,
            'language' => 'English', // إضافة اللغة
            'requirements' => 'Strong knowledge of Python and machine learning concepts.', // إضافة المتطلبات
            'learning_outcomes' => 'Implement advanced machine learning models using TensorFlow.', // إضافة نتائج التعلم
        ]);
    }
}

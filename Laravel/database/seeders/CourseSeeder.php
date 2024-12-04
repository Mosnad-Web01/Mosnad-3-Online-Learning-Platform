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
        $categories = CourseCategory::all();

        // إضافة الدورات
        // 10 دورات مجانية
        foreach ($categories as $index => $category) {
            Course::create([
                'course_name' => "Free Course " . $category->name,
                'description' => "This is a free course about " . $category->name,
                'level' => 'Beginner',
                'category_id' => $category->id,
                'price' => 0.00,
                'start_date' => now(),
                'end_date' => now()->addMonths(3),
                'instructor_id' => $instructor1->id,
                'language' => 'Arabic',
                'requirements' => 'No specific requirements.',
                'learning_outcomes' => 'Basic understanding of the topic.',
                'is_free' => true,
                'image' => 'https://via.placeholder.com/150?text=Free+' . urlencode($category->name),
            ]);
        }

        // 10 دورات مدفوعة
        foreach ($categories as $index => $category) {
            Course::create([
                'course_name' => "Premium Course " . $category->name,
                'description' => "This is a premium course about " . $category->name,
                'level' => 'Intermediate',
                'category_id' => $category->id,
                'price' => rand(50, 200), // عشوائيًا بين 50 و 200 دولار
                'start_date' => now(),
                'end_date' => now()->addMonths(6),
                'instructor_id' => $instructor2->id,
                'language' => 'Arabic',
                'requirements' => 'Basic knowledge in the field.',
                'learning_outcomes' => 'In-depth knowledge and advanced techniques.',
                'is_free' => false,
                'image' => 'https://via.placeholder.com/150?text=Premium+' . urlencode($category->name),
            ]);
        }
    }
}

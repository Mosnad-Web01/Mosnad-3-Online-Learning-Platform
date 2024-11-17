<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CourseCategory;

class CourseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CourseCategory::create([
            'name' => 'Web Development',
        ]);
        CourseCategory::create([
            'name' => 'Data Science',
        ]);
        CourseCategory::create([
            'name' => 'Machine Learning',
        ]);
        CourseCategory::create([
            'name' => 'Design',
        ]);
        CourseCategory::create([
            'name' => 'Business',
        ]);
    }
}

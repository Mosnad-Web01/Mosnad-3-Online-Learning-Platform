<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
 
class DatabaseSeeder extends Seeder
{  public function run()
    {
        // إضافة الأدوار
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'instructor']);
        Role::create(['name' => 'student']);
   
        $this->call([
            UserSeeder::class,
            CourseCategorySeeder::class,
            CourseSeeder::class,
            LessonSeeder::class,
        ]);
    }
}

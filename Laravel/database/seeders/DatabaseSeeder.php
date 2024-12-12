<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // إضافة الأدوار
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'instructor']);
        Role::create(['name' => 'student']);

        // استدعاء seeders الأخرى
        $this->call([
            UserSeeder::class,
            CourseCategorySeeder::class,
            CourseSeeder::class,
            LessonSeeder::class,
                    
        ]);
       
    
    }
}

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
    }
    /**
     * Seed the application's database.
     *
     * @return void
     */
<<<<<<< HEAD
    // public function run(): void
    // {
        
    //     // \App\Models\User::factory(10)->create();

    //     // \App\Models\User::factory()->create([
    //     //     'name' => 'Test User',
    //     //     'email' => 'test@example.com',
    //     // ]);
    // }
=======
    public function run()
    {
        $this->call([
            UserSeeder::class,
            CourseCategorySeeder::class,
            CourseSeeder::class,
            LessonSeeder::class,
        ]);
    }
>>>>>>> develop
}

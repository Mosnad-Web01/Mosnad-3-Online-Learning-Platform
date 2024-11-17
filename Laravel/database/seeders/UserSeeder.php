<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // إنشاء 3 مستخدمين من نوع instructor
        User::create([
            'name' => 'Instructor One',
            'email' => 'instructor1@example.com',
            'password' => bcrypt('password'), // تأكد من تشفير كلمة المرور
            'role' => 'instructor',
        ]);

        User::create([
            'name' => 'Instructor Two',
            'email' => 'instructor2@example.com',
            'password' => bcrypt('password'),
            'role' => 'instructor',
        ]);

        User::create([
            'name' => 'Instructor Three',
            'email' => 'instructor3@example.com',
            'password' => bcrypt('password'),
            'role' => 'instructor',
        ]);
    }
}

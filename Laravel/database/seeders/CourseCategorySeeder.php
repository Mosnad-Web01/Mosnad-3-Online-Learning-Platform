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
            'description' => 'Learn how to build websites and web applications.',
            'image' => 'https://via.placeholder.com/150?text=Web+Development',
        ]);
        CourseCategory::create([
            'name' => 'Data Science',
            'description' => 'Explore the world of data analysis, statistics, and machine learning.',
            'image' => 'https://via.placeholder.com/150?text=Data+Science',
        ]);
        CourseCategory::create([
            'name' => 'Machine Learning',
            'description' => 'Dive into the algorithms and techniques used to create intelligent systems.',
            'image' => 'https://via.placeholder.com/150?text=Machine+Learning',
        ]);
        CourseCategory::create([
            'name' => 'Design',
            'description' => 'Master graphic design, UI/UX, and creative software tools.',
            'image' => 'https://via.placeholder.com/150?text=Design',
        ]);
        CourseCategory::create([
            'name' => 'Business',
            'description' => 'Learn business strategies, marketing, and entrepreneurship.',
            'image' => 'https://via.placeholder.com/150?text=Business',
        ]);
        CourseCategory::create([
            'name' => 'Marketing',
            'description' => 'Explore digital marketing, SEO, and social media strategies.',
            'image' => 'https://via.placeholder.com/150?text=Marketing',
        ]);
        CourseCategory::create([
            'name' => 'Cybersecurity',
            'description' => 'Understand how to protect systems and networks from cyber threats.',
            'image' => 'https://via.placeholder.com/150?text=Cybersecurity',
        ]);
        CourseCategory::create([
            'name' => 'Photography',
            'description' => 'Learn the art of capturing moments and editing photos.',
            'image' => 'https://via.placeholder.com/150?text=Photography',
        ]);
        CourseCategory::create([
            'name' => 'Music',
            'description' => 'Understand music theory, composition, and production techniques.',
            'image' => 'https://via.placeholder.com/150?text=Music',
        ]);
        CourseCategory::create([
            'name' => 'Writing',
            'description' => 'Improve your writing skills for content creation and storytelling.',
            'image' => 'https://via.placeholder.com/150?text=Writing',
        ]);
        CourseCategory::create([
            'name' => 'Health & Fitness',
            'description' => 'Learn about physical health, fitness routines, and healthy living.',
            'image' => 'https://via.placeholder.com/150?text=Health+%26+Fitness',
        ]);
        CourseCategory::create([
            'name' => 'Cooking',
            'description' => 'Explore culinary techniques, recipes, and kitchen skills.',
            'image' => 'https://via.placeholder.com/150?text=Cooking',
        ]);
        CourseCategory::create([
            'name' => 'Finance',
            'description' => 'Learn how to manage personal finance, investments, and business finance.',
            'image' => 'https://via.placeholder.com/150?text=Finance',
        ]);
        CourseCategory::create([
            'name' => 'Law',
            'description' => 'Understand the basics of law, legal systems, and contracts.',
            'image' => 'https://via.placeholder.com/150?text=Law',
        ]);
        CourseCategory::create([
            'name' => 'Language Learning',
            'description' => 'Learn new languages and improve your communication skills.',
            'image' => 'https://via.placeholder.com/150?text=Language+Learning',
        ]);
        CourseCategory::create([
            'name' => 'Artificial Intelligence',
            'description' => 'Discover the cutting-edge field of AI and its applications.',
            'image' => 'https://via.placeholder.com/150?text=Artificial+Intelligence',
        ]);
        CourseCategory::create([
            'name' => 'Blockchain',
            'description' => 'Understand blockchain technology and its use cases in various industries.',
            'image' => 'https://via.placeholder.com/150?text=Blockchain',
        ]);
        CourseCategory::create([
            'name' => 'Project Management',
            'description' => 'Learn about project planning, execution, and management techniques.',
            'image' => 'https://via.placeholder.com/150?text=Project+Management',
        ]);
        CourseCategory::create([
            'name' => 'Game Development',
            'description' => 'Learn how to design, develop, and program video games.',
            'image' => 'https://via.placeholder.com/150?text=Game+Development',
        ]);
        CourseCategory::create([
            'name' => 'Entrepreneurship',
            'description' => 'Learn how to start, manage, and grow your own business.',
            'image' => 'https://via.placeholder.com/150?text=Entrepreneurship',
        ]);
    }
}

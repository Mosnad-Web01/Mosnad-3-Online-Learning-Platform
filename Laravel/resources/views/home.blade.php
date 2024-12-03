<x-layout>
    <div class="flex">


        <!-- المحتوى الرئيسي -->
        <main class="flex-1  ml-72">
            <div class="bg-white min-h-screen">
                <!-- Hero Section -->
                <section class="text-center py-20 bg-blue-500 text-white">
                    <h1 class="text-4xl font-bold mb-4">Welcome to Our Online Course Dashboard</h1>
                    <p class="text-lg mb-6">Start learning and growing today. Access thousands of courses designed for all levels.</p>
                    <a href="#courses" class="bg-white text-blue-500 px-6 py-2 rounded-full text-xl font-semibold hover:bg-gray-200 transition">Browse Courses</a>
                </section>

                <!-- Courses Section -->
                <section id="courses" class="py-20 bg-white">
                    <div class="container mx-auto px-4">
                        <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">Popular Courses</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                            @forelse($courses as $course)
                                <div class="bg-gray-200 rounded-lg shadow-md overflow-hidden">
                                    <img src="{{ $course->image ? asset('storage/' . $course->image) : 'https://via.placeholder.com/400x250' }}" alt="{{ $course->course_name }}" class="w-full h-56 object-cover">
                                    <div class="p-6">
                                        <h3 class="text-xl font-semibold text-gray-800">{{ $course->course_name }}</h3>
                                        <p class="text-gray-600 mt-4">{{ Str::limit($course->description, 100) }}</p>
                                        <a href="{{ route('courses.show.details', $course->id) }}" class="text-blue-500 mt-4 inline-block">Learn More</a>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-gray-500 col-span-3">No courses available at the moment.</p>
                            @endforelse
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>
</x-layout>

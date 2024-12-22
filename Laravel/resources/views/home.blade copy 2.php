
<x-layout>
    <main class="bg-white dark:bg-gray-900 text-black dark:text-white min-h-screen w-full">

        <!-- المحتوى الرئيسي -->


            <div class="bg-white dark:bg-gray-900 min-h-[calc(100vh-theme(space.4)*2)] sm:min-h-[calc(100vh-theme(space.6)*2)]">



                <!-- Hero Section -->
                <section class="text-center py-20 bg-gradient-to-r from-blue-500 to-indigo-600 dark:from-gray-800 dark:to-gray-900 text-white">
                    <h1 class="text-4xl font-extrabold mb-4 tracking-wide">Welcome to Our Online Course Dashboard</h1>
                    <p class="text-lg mb-6">Start learning and growing today. Access thousands of courses designed for all levels.</p>
                    <a href="#courses" class="bg-white text-blue-600 px-6 py-3 rounded-full text-xl font-semibold hover:bg-gray-200 transition shadow-lg">
                        Browse Courses
                    </a>
                </section>


             <!-- Courses Section -->
             <section id="courses" class="py-20 lg:col-start-2 col-end-3 overflow-y-auto p-4">
                <div class="container mx-auto px-4">
                    <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-8">Popular Courses</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @forelse($courses as $course)
                            <div class="bg-gray-200 dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                                @if ($course->image)
                                    <img
                                        src="{{ Storage::url('courses/' . $course->image) }}"
                                        alt="{{ $course->course_name }}"
                                        class="w-full h-48 object-cover rounded-lg mt-4"
                                    >
                                @else
                                    <img
                                        src="{{ asset('images/cover.jpg') }}"
                                        alt="Default Cover"
                                        class="w-full h-48 object-cover rounded-lg mt-4"
                                    >
                                @endif

                                <div class="p-4">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white truncate">
                                        {{ $course->course_name }}
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-300 text-sm mt-2">
                                        {{ Str::limit($course->description, 80) }}
                                    </p>
                                    <a href="{{ route('courses.show', $course->id) }}" class="text-blue-500 dark:text-blue-300 text-sm mt-4 inline-block">
                                        Learn More
                                    </a>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 col-span-full">No courses available at the moment.</p>
                        @endforelse
                    </div>
                </div>
            </section>

                </section>

            
               
            </div>
       
    </main>
</x-layout>

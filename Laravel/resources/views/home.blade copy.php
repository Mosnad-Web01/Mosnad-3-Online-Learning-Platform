<x-homelayout>
    <div class="flex flex-col min-h-screen">
        <!-- المحتوى الرئيسي -->
        <main class="flex-grow bg-white dark:bg-gray-900 text-gray-900 dark:text-white w-full overflow-x-hidden">
            <div class="bg-white dark:bg-gray-900 min-h-screen">
                <!-- Hero Section -->
                <section class="text-center py-20 bg-gradient-to-r from-blue-500 to-indigo-600 dark:from-gray-800 dark:to-gray-900 text-white">
                    <h1 class="text-4xl font-extrabold mb-4 tracking-wide">Welcome to Our Online Course Dashboard</h1>
                    <p class="text-lg mb-6">Start learning and growing today. Access thousands of courses designed for all levels.</p>
                    <a href="#courses" class="bg-white text-blue-600 px-6 py-3 rounded-full text-xl font-semibold hover:bg-gray-200 transition shadow-lg">
                        Browse Courses
                    </a>
                </section>

                <!-- Top Courses Section -->
                <section id="courses" class="py-20 px-4 bg-gray-50 dark:bg-gray-800">
                    <div class="container mx-auto">
                        <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-8">Top 10 Courses</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach($topCourses as $course)
                                <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                                    <img 
                                        src="{{ $course->image ? asset('storage/' . $course->image) : 'https://via.placeholder.com/300x200' }}" 
                                        alt="{{ $course->course_name }}" 
                                        class="w-full h-40 object-cover"
                                    >
                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white truncate">
                                            {{ $course->course_name }}
                                        </h3>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-2">
                                            {{ Str::limit($course->description, 80) }}
                                        </p>
                                        <a href="{{ route('courses.show', $course->id) }}" class="text-blue-600 dark:text-blue-400 text-sm mt-4 inline-block font-medium">
                                            Learn More
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-8">
                            <a href="{{ route('courses.index') }}" class="bg-blue-600 text-white px-6 py-3 rounded-full text-lg font-semibold hover:bg-blue-500 transition shadow-md">
                                View All Courses
                            </a>
                        </div>
                    </div>
                </section>

                <!-- Top Instructors Section -->
                <section id="instructors" class="py-20 px-4 bg-gray-100 dark:bg-gray-700">
                    <div class="container mx-auto">
                        <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-8">Top 10 Instructors</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach($topInstructors as $instructor)
                                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 text-center hover:shadow-xl transition">
                                    <img 
                                        src="{{ $instructor->profile_picture ?? 'https://via.placeholder.com/100' }}" 
                                        alt="{{ $instructor->name }}" 
                                        class="w-20 h-20 mb-4 object-cover object-center rounded-full inline-block border-2 border-gray-200 bg-gray-100"
                                    >
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">{{ $instructor->name }}</h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm mt-2">Avg. Rating: {{ number_format($instructor->reviews_avg_instructor_rating, 1) }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>

                <!-- Top Reviews Section -->
                <section id="reviews" class="py-20 px-4">
                    <div class="container mx-auto">
                        <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-8">Top 10 Reviews</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach($topReviews as $review)
                                <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-4 hover:shadow-xl transition">
                                    <p class="leading-relaxed text-gray-700 dark:text-gray-300">{{ $review->review_text }}</p>
                                    <span class="inline-block h-1 w-10 rounded bg-indigo-500 mt-6 mb-4"></span>
                                    <h3 class="text-gray-900 font-medium title-font tracking-wider text-sm">{{ $review->student->name ?? 'Anonymous' }}</h3>
                                    <p class="text-gray-500">{{ $review->student->job_title ?? 'No Title' }}</p>
                                    <p class="text-gray-600 dark:text-gray-300 text-sm mt-2">Course Rating: {{ $review->course_rating }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>

               
            </div>
        </main>
    </div>
</x-homelayout>

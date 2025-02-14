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
                <!-- Top Reviews Section -->
<section id="reviews" class="py-20 px-4">
    <div class="container mx-auto">
        <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-8">
            <div class="text-4xl font-bold text-center">
                Testimonials
            </div>
            Discover the full collection of success stories and feedback from our learners, powered by TutorNet. Real experiences from students who excelled with the support of cutting-edge resources and dedicated guidance.
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($topReviews as $review)
                <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-4 hover:shadow-xl transition">
                    <p class="leading-relaxed text-gray-700 dark:text-gray-300">{{ $review->review_text }}</p>
                    <span class="inline-block h-1 w-10 rounded bg-indigo-500 mt-6 mb-4"></span>
                    <h3 class="text-gray-900 font-medium title-font tracking-wider text-sm">{{ $review->student->name ?? 'Anonymous' }}</h3>
                    <p class="text-gray-500">{{ $review->student->job_title ?? 'No Title' }}</p>
                    <div class="flex items-center mt-2">
                        @for ($i = 0; $i < 5; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="{{ $i < $review->course_rating ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 17.75l-6.56 3.46 1.25-7.26-5.27-5.15 7.26-1.07L12 2l3.32 6.67 7.26 1.07-5.27 5.15 1.25 7.26L12 17.75z"/>
                            </svg>
                        @endfor
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- About Section -->
<section class="py-16 px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-800 text-black dark:text-white">
    <div class="text-center">
        <h2 class="text-4xl font-extrabold font-serif mb-4">
            About TutorNet
        </h2>
        <div class="w-full border-b border-gray-300 dark:border-gray-700 mb-6"></div>
        <p class="text-lg max-w-6xl mx-auto">
            Welcome to TutorNet – the online learning platform that connects students with expert instructors, empowering them to learn and grow across a variety of fields.

            At TutorNet, we’re committed to enhancing the learning experience by providing an innovative, user-friendly environment. Teachers can effortlessly design and manage courses, while students enjoy exploring, enrolling, and completing their educational journeys with ease. Whether you’re interested in programming, design, or business, TutorNet offers a comprehensive range of courses tailored to meet diverse interests and skill levels.

            Our platform provides detailed course catalogs, progress tracking, and personalized recommendations, allowing students to access rich learning resources and interact with experienced instructors. Join TutorNet to be part of a unique educational experience, where you can expand your knowledge or share your expertise in an accessible and effective way.
        </p>
    </div>
</section>

<!-- Contact Section -->
<section class="py-16 px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-800 text-black dark:text-white">
    <div class="text-center mb-12">
        <h2 class="text-4xl font-extrabold text-gray-800 dark:text-white">
            Get in touch with us
        </h2>
    </div>

    <div class="max-w-3xl mx-auto text-center">
        <p class="text-lg text-gray-700 dark:text-gray-300 mb-8">
            We&#39;re here to help! Whether you have questions, feedback, or just want to say hello, feel free to reach out to us using the details below.
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12 text-lg text-gray-700 dark:text-gray-300">
            <div class="flex flex-col items-center">
                <p class="font-semibold text-xl mb-2">Email</p>
                <p class="text-lg">support@tutornet.com</p>
            </div>
            <div class="flex flex-col items-center">
                <p class="font-semibold text-xl mb-2">Phone</p>
                <p class="text-lg">+967 77 123 4567</p>
            </div>
            <div class="flex flex-col items-center">
                <p class="font-semibold text-xl mb-2">Address</p>
                <p class="text-lg text-center">Sana’a, Yemen</p>
            </div>
        </div>

        <div class="mt-8">
            <p class="text-lg text-gray-700 dark:text-gray-300">
                Feel free to reach out to us anytime. We&#39;re always happy to hear from you!
            </p>
        </div>
    </div>
</section>

            </div>
        </main>
    </div>
</x-homelayout>

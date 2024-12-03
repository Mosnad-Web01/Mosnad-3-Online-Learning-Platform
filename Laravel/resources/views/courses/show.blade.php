<x-layout>
    <div class="flex">
        <!-- المحتوى الرئيسي -->
        <main class="flex-1 ml-72 mt-8"> <!-- إضافة هامش يسار -->
            <div class="bg-white dark:bg-gray-800 text-black dark:text-white min-h-screen py-8 px-4">
                <div class="w-full px-0 py-0">
                    <!-- قسم تفاصيل الدورة مع حركة -->
                    <section class="bg-gray-100 dark:bg-gray-900 p-8 mt-0 rounded-lg shadow-lg">
                        <div class="flex flex-col lg:flex-row">
                            <div class="w-full lg:w-1/4 mb-8 lg:mb-0">
                                <img
                                    src="{{ $course->image_url ?? 'https://via.placeholder.com/300x450' }}"
                                    alt="{{ $course->course_name }}"
                                    class="rounded-lg shadow-lg w-full"
                                />
                            </div>
                            <div class="w-full lg:w-3/4 lg:ml-8">
                                <h1 class="text-3xl md:text-4xl font-bold mb-2">{{ $course->course_name }}</h1>
                                <p class="text-md md:text-lg mb-4">Instructor: {{ $course->instructor->name }}</p>
                                <p class="text-md md:text-lg mb-4">Start Date: {{ $course->start_date }}</p>
                                <p class="text-md md:text-lg mb-4">End Date: {{ $course->end_date }}</p>
                                <p class="text-md md:text-lg mb-4">Language: {{ $course->language }}</p>
                                <p class="text-md md:text-lg mb-4">Price: ${{ $course->price }}</p>
                                <div class="flex items-center mt-4">
                                    <!-- عرض النجوم للتقييم -->
                                    <div class="flex items-center text-yellow-500">
                                        @for ($i = 0; $i < 5; $i++)
                                            <span class="material-icons">
                                                {{ $i < floor($course->rating) ? 'star' : 'star_border' }}
                                            </span>
                                        @endfor
                                    </div>
                                    <span class="ml-2 text-sm">
                                        ({{ number_format($course->rating, 1) }})
                                    </span>
                                </div>
                                <!-- زر الالتحاق -->
                                <button class="mt-4 py-2 px-6 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                                    {{ $course->price == 0 || $course->is_enrolled ? 'Go to Lessons' : 'Enroll Now' }}
                                </button>
                            </div>
                        </div>
                    </section>

                    <hr class="my-8 border-t border-gray-300 dark:border-gray-700" />

                    <!-- قسم المتطلبات -->
                    <section class="my-6 p-4 bg-white dark:bg-gray-800 text-black dark:text-white">
                        <h2 class="text-2xl font-semibold">Requirements</h2>
                        <ul class="list-disc ml-6">
                            @if (!empty($course->requirements))
                                <li class="text-sm mt-2">{{ $course->requirements }}</li>
                            @else
                                <li class="text-sm mt-2">No data available</li>
                            @endif
                        </ul>
                    </section>

                    <hr class="my-8 border-t border-gray-300 dark:border-gray-700" />

                    <!-- قسم نتائج التعلم -->
                    <section class="my-6 p-4 bg-white dark:bg-gray-800 text-black dark:text-white">
                        <h2 class="text-2xl font-semibold">Learning Outcomes</h2>
                        <ul class="list-disc ml-6">
                            @if (!empty($course->learning_outcomes))
                                <li class="text-sm mt-2">{{ $course->learning_outcomes }}</li>
                            @else
                                <li class="text-sm mt-2">No data available</li>
                            @endif
                        </ul>
                    </section>

                    <hr class="my-8 border-t border-gray-300 dark:border-gray-700" />

                    <!-- قسم محتوى الدورة -->
                    <section class="my-6 p-4 bg-white dark:bg-gray-800 text-black dark:text-white">
                        <h2 class="text-2xl font-semibold">Course Content</h2>
                        <p class="text-sm mt-2">{{ $course->description }}</p>
                    </section>

                    <hr class="my-8 border-t border-gray-300 dark:border-gray-700" />

                    <!-- قسم الدروس -->
                    @if ($course->is_enrolled && !empty($course->lessons))
                        <section class="my-6 p-4 bg-white dark:bg-gray-800 text-black dark:text-white">
                            <h2 class="text-2xl font-semibold">Lessons</h2>
                            <div class="mt-4">
                                <a href="{{ route('course.lessons', ['id' => $course->id]) }}"
                                   class="text-blue-500 hover:text-blue-700 flex items-center">
                                    <span>Go to Lessons</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20"
                                         fill="currentColor">
                                        <path fill-rule="evenodd"
                                              d="M10 18a8 8 0 100-16 8 8 0 000 16zm1.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 001.414 1.414L9 11.414V7a1 1 0 112 0v4.414l1.293-1.293z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </a>
                            </div>
                        </section>
                    @else
                        <section class="my-6 p-4 bg-white dark:bg-gray-800 text-black dark:text-white">
                            <h2 class="text-2xl font-semibold">Lessons</h2>
                            <p class="text-sm mt-2">
                                {{ $course->is_enrolled ? 'Start learning now!' : 'Enroll to access content.' }}
                            </p>
                        </section>
                    @endif
                </div>
            </div>
        </main>
    </div>
</x-layout>

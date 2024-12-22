<x-homelayout>

    <main class="bg-white dark:bg-gray-900 text-black dark:text-white min-h-screen w-full">
        <div class="flex flex-col min-h-screen mt-4">
            <div class="container mx-auto px-4 flex-grow">
                <!-- المحتوى الرئيسي -->
                <main class="flex-1 mt-8">
                    <div class="bg-white dark:bg-gray-900 py-8 px-6 rounded-lg ">
                        <!-- قسم معلومات الدورة -->
                        <section class="mb-12">
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                                <!-- صورة الدورة -->
                                <div>
                                    <img
                                        src="{{ asset('storage/courses/' . $course->image_url) ?? 'https://via.placeholder.com/300x450' }}"
                                        alt="{{ $course->course_name }}"
                                        class="rounded-lg shadow-lg w-full"
                                    />


                                </div>
                                <!-- تفاصيل الدورة -->
                                <div class="col-span-2">
                                    <h1 class="text-3xl md:text-4xl font-bold mb-4">{{ $course->course_name }}</h1>
                                    <p class="mb-2"><strong>Instructor:</strong> {{ $course->instructor->name }}</p>
                                    <p class="mb-2"><strong>Start Date:</strong> {{ $course->start_date }}</p>
                                    <p class="mb-2"><strong>End Date:</strong> {{ $course->end_date }}</p>
                                    <p class="mb-2"><strong>Language:</strong> {{ $course->language }}</p>
                                    <p class="mb-4"><strong>Price:</strong> ${{ $course->price }}</p>
                                    <!-- زر التقييم -->
                                    <div class="flex items-center mt-4">
                                        @for ($i = 0; $i < 5; $i++)
                                            <span class="material-icons text-yellow-500">
                                                {{ $i < floor($course->rating) ? 'star' : 'star_border' }}
                                            </span>
                                        @endfor
                                        <span class="ml-2 text-sm">({{ number_format($course->rating, 1) }})</span>
                                    </div>
                                    <!-- زر الالتحاق -->
                                    <a href="{{ route('enroll.course', ['courseId' => $course->id]) }}"
                                       class="mt-6 py-3 px-8 inline-block bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                                       {{ $course->price == 0 || $course->is_enrolled ? 'Go to Lessons' : 'Enroll Now' }}
                                    </a>
                                </div>
                            </div>
                        </section>

                        <hr class="my-8 border-t border-gray-300 dark:border-gray-700" />

                        <!-- قسم تفاصيل الدورة -->
                        <section>
                            <h2 class="text-2xl font-semibold mb-4">Course Details</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow">
                                    <p class="text-sm font-medium">Duration</p>
                                    <p class="text-lg">{{ $course->duration }} hours</p>
                                </div>
                                <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow">
                                    <p class="text-sm font-medium">Language</p>
                                    <p class="text-lg">{{ $course->language }}</p>
                                </div>
                                <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow">
                                    <p class="text-sm font-medium">Price</p>
                                    <p class="text-lg">${{ $course->price }}</p>
                                </div>
                                <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow">
                                    <p class="text-sm font-medium">Rating</p>
                                    <p class="text-lg">{{ number_format($course->rating, 1) }} / 5</p>
                                </div>
                            </div>
                        </section>

                        <hr class="my-8 border-t border-gray-300 dark:border-gray-700" />

                        <!-- قسم المتطلبات -->
                        <section class="my-6 p-4 bg-white dark:bg-gray-900 text-black dark:text-white">
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
                        <section class="my-6 p-4 bg-white dark:bg-gray-900 text-black dark:text-white">
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
                        <section class="my-6 p-4 bg-white dark:bg-gray-900 text-black dark:text-white">
                            <h2 class="text-2xl font-semibold">Course Content</h2>
                            <p class="text-sm mt-2">{{ $course->description }}</p>
                        </section>

                        <hr class="my-8 border-t border-gray-300 dark:border-gray-700" />

                        <!-- قسم الدروس -->
                        @if ($course->is_enrolled && !empty($course->lessons))
                            <section class="my-6 p-4 bg-white dark:bg-gray-900 text-black dark:text-white">
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
                            <section class="my-6 p-4 bg-white dark:bg-gray-900 text-black dark:text-white">
                                <h2 class="text-2xl font-semibold">Lessons</h2>
                                <p class="text-sm mt-2">
                                    {{ $course->is_enrolled ? 'Start learning now!' : 'Enroll to access content.' }}
                                </p>
                            </section>
                        @endif
                    </div>
                </main>
            </div>
        </div>
    </main>
</x-homelayout>


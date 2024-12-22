<x-homelayout>


                <!-- Courses Section -->
                <section id="courses" class="py-20 px-4 bg-gray-50 dark:bg-gray-800">
                    <div class="container mx-auto">
                        <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-8">Our Courses</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach($courses as $course)
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
                       
                    </div>
                </section>
            </div>
        </main>
    </div>
</x-homelayout>

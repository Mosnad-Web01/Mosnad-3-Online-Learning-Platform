<x-layout>
    <section class="bg-white dark:bg-gray-900 antialiased">
        <div class="max-w-screen-xl px-4 py-8 mx-auto lg:px-6 sm:py-16 lg:py-24">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-4xl font-extrabold leading-tight tracking-tight text-gray-900 dark:text-white">
                    Manage Your Courses
                </h2>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">
                    Edit, delete, or add new courses to your portfolio.
                </p>
            </div>

            <!-- List of Courses -->
            <div class="mt-8">
                <a href="{{ route('instructor.courses.create') }}" class="inline-block mb-4 text-primary-600 dark:text-primary-500 hover:underline">
                    Add New Course
                </a>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($courses as $course)
                    <div class="bg-gray-100 p-6 rounded-lg shadow-md hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $course->course_name }}</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $course->description }}</p>
                        <a href="{{ route('instructor.courses.edit', $course->id) }}" class="mt-4 inline-block text-primary-600 dark:text-primary-500 hover:underline">
                            Edit Course
                        </a>
                        <form action="{{ route('instructor.courses.destroy', $course->id) }}" method="POST" class="mt-4">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">
                                Delete Course
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</x-layout>

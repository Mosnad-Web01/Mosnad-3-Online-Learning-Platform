<x-layoutInstructor>
    <section class="bg-white dark:bg-gray-900 antialiased">
        <div class="max-w-screen-xl px-4 py-8 mx-auto lg:px-6 sm:py-16 lg:py-24">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-4xl font-extrabold leading-tight tracking-tight text-gray-900 dark:text-white">
                    Edit Course: {{ $course->course_name }}
                </h2>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">
                    Edit the details of your course below.
                </p>
            </div>

            <div class="mt-8 max-w-3xl mx-auto">
                <form action="{{ route('instructor.courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Course Name -->
                    <div class="mb-4">
                        <label for="course_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Course Name</label>
                        <input type="text" id="course_name" name="course_name" class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500" value="{{ old('course_name', $course->course_name) }}" required>
                    </div>

                    <!-- Course Description -->
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                        <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500" rows="4" required>{{ old('description', $course->description) }}</textarea>
                    </div>

                    <!-- Course Level -->
                    <div class="mb-4">
                        <label for="level" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Level</label>
                        <select id="level" name="level" class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500" required>
                            <option value="Beginner" @if($course->level == 'Beginner') selected @endif>Beginner</option>
                            <option value="Intermediate" @if($course->level == 'Intermediate') selected @endif>Intermediate</option>
                            <option value="Advanced" @if($course->level == 'Advanced') selected @endif>Advanced</option>
                        </select>
                    </div>

                    <!-- Course Image -->
                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Image</label>
                        <input type="file" id="image" name="image" class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-300 dark:bg-gray-800 dark:border-gray-700" accept="image/*">
                    </div>

                    <!-- Submit Button -->
                    <div class="mb-4">
                        <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-md py-2 px-4">
                            Update Course
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-layoutInstructor>

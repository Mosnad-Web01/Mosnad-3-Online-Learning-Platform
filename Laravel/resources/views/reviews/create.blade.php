<x-layout>
    <section class="bg-gray-50 dark:bg-gray-900 py-10 px-4 sm:px-6 lg:px-8 mt-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 text-center">Add a Review</h1>

            {{-- Success or Error Message --}}
            @if(session('success'))
                <div class="mb-4 text-green-500 text-sm">{{ session('success') }}</div>
            @elseif(session('error'))
                <div class="mb-4 text-red-500 text-sm">{{ session('error') }}</div>
            @endif

            <form action="{{ route('reviews.store') }}" method="POST" class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8 space-y-6">
                @csrf

                {{-- Course --}}
                <div class="mb-4">
                    <label for="course_id" class="block text-gray-700 dark:text-gray-300 font-medium">Course</label>
                    <select name="course_id" id="course_id" required
                            class="mt-2 block w-full border-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none py-2 px-4">
                        <option value="">Select a course</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                        @endforeach
                    </select>
                    @error('course_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Instructor --}}
                <div class="mb-4">
                    <label for="instructor_id" class="block text-gray-700 dark:text-gray-300 font-medium">Instructor</label>
                    <select name="instructor_id" id="instructor_id" required
                            class="mt-2 block w-full border-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none py-2 px-4">
                        <option value="">Select an instructor</option>
                        @foreach ($instructors as $instructor)
                            <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
                        @endforeach
                    </select>
                    @error('instructor_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Course Rating --}}
                <div class="mb-4">
                    <label for="course_rating" class="block text-gray-700 dark:text-gray-300 font-medium">Course Rating (1-5)</label>
                    <input type="number" name="course_rating" id="course_rating" min="1" max="5" required
                           class="mt-2 block w-full border-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none py-2 px-4">
                    @error('course_rating') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Instructor Rating --}}
                <div class="mb-4">
                    <label for="instructor_rating" class="block text-gray-700 dark:text-gray-300 font-medium">Instructor Rating (1-5)</label>
                    <input type="number" name="instructor_rating" id="instructor_rating" min="1" max="5" required
                           class="mt-2 block w-full border-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none py-2 px-4">
                    @error('instructor_rating') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Review Text --}}
                <div class="mb-4">
                    <label for="review_text" class="block text-gray-700 dark:text-gray-300 font-medium">Review</label>
                    <textarea name="review_text" id="review_text" rows="4"
                              class="mt-2 block w-full border-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none py-2 px-4"></textarea>
                    @error('review_text') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="w-full bg-blue-500 text-white py-3 rounded-lg text-lg font-semibold hover:bg-blue-600 transition duration-300">
                    Submit Review
                </button>
            </form>
        </div>
    </section>
</x-layout>

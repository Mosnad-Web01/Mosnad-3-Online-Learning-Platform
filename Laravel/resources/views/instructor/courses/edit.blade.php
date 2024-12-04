<x-layout>
    <section class="bg-gray-50 dark:bg-gray-900 py-10 px-4 sm:px-6 lg:px-8 mt-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 text-center">Edit Course</h1>

            {{-- Success or Error Message --}}
            @if(session('success'))
                <div class="mb-4 text-green-500 text-sm">{{ session('success') }}</div>
            @elseif(session('error'))
                <div class="mb-4 text-red-500 text-sm">{{ session('error') }}</div>
            @endif

            <form action="{{ route('instructor.courses.update', $course->id) }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8 space-y-6">
                @csrf
                @method('PUT')

                {{-- Course Name --}}
                <div class="mb-4">
                    <label for="course_name" class="block text-gray-700 dark:text-gray-300 font-medium">Course Name</label>
                    <input type="text" name="course_name" id="course_name" value="{{ old('course_name', $course->course_name) }}" required
                           class="mt-2 block w-full border-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none py-2 px-4">
                    @error('course_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Description --}}
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 dark:text-gray-300 font-medium">Description</label>
                    <textarea name="description" id="description" rows="4" required
                              class="mt-2 block w-full border-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none py-2 px-4">{{ old('description', $course->description) }}</textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Level --}}
                <div class="mb-4">
                    <label for="level" class="block text-gray-700 dark:text-gray-300 font-medium">Level</label>
                    <select name="level" id="level" required
                            class="mt-2 block w-full border-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none py-2 px-4">
                        <option value="Beginner" {{ old('level', $course->level) === 'Beginner' ? 'selected' : '' }}>Beginner</option>
                        <option value="Intermediate" {{ old('level', $course->level) === 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                        <option value="Advanced" {{ old('level', $course->level) === 'Advanced' ? 'selected' : '' }}>Advanced</option>
                    </select>
                    @error('level') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Category --}}
                <div class="mb-4">
                    <label for="category_id" class="block text-gray-700 dark:text-gray-300 font-medium">Category</label>
                    <select name="category_id" id="category_id" required
                            class="mt-2 block w-full border-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none py-2 px-4">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $course->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Price --}}
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-medium">Is the Course Free?</label>
                    <div class="flex items-center">
                        <input type="radio" id="is_free" name="is_free" value="1" {{ old('is_free', $course->is_free) == 1 ? 'checked' : '' }} onclick="togglePriceField(true)">
                        <label for="is_free" class="ml-2 text-gray-700 dark:text-gray-300">Yes</label>
                        <input type="radio" id="is_paid" name="is_free" value="0" {{ old('is_free', $course->is_free) == 0 ? 'checked' : '' }} onclick="togglePriceField(false)">
                        <label for="is_paid" class="ml-2 text-gray-700 dark:text-gray-300">No</label>
                    </div>
                    @error('is_free') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Price Field --}}
                <div class="mb-4">
                    <label for="price" class="block text-gray-700 dark:text-gray-300 font-medium">Price</label>
                    <input type="number" name="price" id="price" value="{{ old('price', $course->price) }}" required step="0.01"
                        class="mt-2 block w-full border-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none py-2 px-4" {{ old('is_free', $course->is_free) == 1 ? 'readonly' : '' }}>
                    @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Dates --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="mb-4">
                        <label for="start_date" class="block text-gray-700 dark:text-gray-300 font-medium">Start Date</label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $course->start_date) }}" required
                               class="mt-2 block w-full border-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none py-2 px-4">
                        @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="end_date" class="block text-gray-700 dark:text-gray-300 font-medium">End Date</label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $course->end_date) }}" required
                               class="mt-2 block w-full border-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none py-2 px-4">
                        @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Language --}}
                <div class="mb-4">
                    <label for="language" class="block text-gray-700 dark:text-gray-300 font-medium">Language</label>
                    <input type="text" name="language" id="language" value="{{ old('language', $course->language) }}"
                           class="mt-2 block w-full border-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none py-2 px-4">
                    @error('language') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Requirements --}}
                <div class="mb-4">
                    <label for="requirements" class="block text-gray-700 dark:text-gray-300 font-medium">Requirements</label>
                    <textarea name="requirements" id="requirements" rows="3"
                              class="mt-2 block w-full border-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none py-2 px-4">{{ old('requirements', $course->requirements) }}</textarea>
                    @error('requirements') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Learning Outcomes --}}
                <div class="mb-4">
                    <label for="learning_outcomes" class="block text-gray-700 dark:text-gray-300 font-medium">Learning Outcomes</label>
                    <textarea name="learning_outcomes" id="learning_outcomes" rows="3"
                              class="mt-2 block w-full border-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none py-2 px-4">{{ old('learning_outcomes', $course->learning_outcomes) }}</textarea>
                    @error('learning_outcomes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Image --}}
                <div class="mb-4">
                    <label for="image" class="block text-gray-700 dark:text-gray-300 font-medium">Course Image</label>
                    <input type="file" name="image" id="image"
                           class="mt-2 block w-full border-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none py-2 px-4">
                    @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Submit --}}
                <div class="flex justify-center">
                    <button type="submit"
                            class="px-6 py-2 text-white bg-blue-500 hover:bg-blue-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </section>
    <script>
        // Toggle the price field based on the radio selection
        function togglePriceField(isFree) {
            const priceInput = document.getElementById('price');
            priceInput.readOnly = isFree;
            if (isFree) {
                priceInput.value = 0;  // Set the price to 0 if it's free
            }
        }
    </script>
</x-layout>

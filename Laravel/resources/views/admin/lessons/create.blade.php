<x-layout>
    <section class="bg-gray-50 dark:bg-gray-900 py-10 px-4 sm:px-6 lg:px-8 mt-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 text-center">
                Add a New Lesson to "{{ $course->name }}"
            </h1>

            {{-- Success or Error Message --}}
            @if(session('success'))
                <div class="mb-4 text-green-500 text-sm">{{ session('success') }}</div>
            @elseif(session('error'))
                <div class="mb-4 text-red-500 text-sm">{{ session('error') }}</div>
            @endif

            <form action="{{ route('instructor.lessons.store', $course->id) }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8 space-y-6">
                @csrf

                {{-- Lesson Title --}}
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 dark:text-gray-300 font-medium">Lesson Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                        class="mt-2 block w-full border-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none py-2 px-4">
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Lesson Content --}}
                <div class="mb-4">
                    <label for="content" class="block text-gray-700 dark:text-gray-300 font-medium">Lesson Content</label>
                    <textarea name="content" id="content" rows="4"
                        class="mt-2 block w-full border-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none py-2 px-4">{{ old('content') }}</textarea>
                    @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Video --}}
                <div class="mb-4">
                    <label for="video" class="block text-gray-700 dark:text-gray-300 font-medium">Upload Video</label>
                    <input type="file" name="video" id="video" accept="video/*"
                        class="mt-2 block w-full border-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none py-2 px-4">
                    @error('video') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Images --}}
                <div class="mb-4">
                    <label for="images" class="block text-gray-700 dark:text-gray-300 font-medium">Upload Images (Multiple)</label>
                    <input type="file" name="images[]" id="images" accept="image/*" multiple
                        class="mt-2 block w-full border-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none py-2 px-4">
                    @error('images.*') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Files --}}
                <div class="mb-4">
                    <label for="files" class="block text-gray-700 dark:text-gray-300 font-medium">Upload Files (Multiple)</label>
                    <input type="file" name="files[]" id="files" accept=".pdf,.docx,.txt" multiple
                        class="mt-2 block w-full border-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none py-2 px-4">
                    @error('files.*') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Order --}}
                <div class="mb-4">
                    <label for="order" class="block text-gray-700 dark:text-gray-300 font-medium">Lesson Order</label>
                    <input type="number" name="order" id="order" value="{{ old('order', 0) }}"
                        class="mt-2 block w-full border-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none py-2 px-4">
                    @error('order') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="w-full bg-blue-500 text-white py-3 rounded-lg text-lg font-semibold hover:bg-blue-600 transition duration-300">
                    Add Lesson
                </button>
            </form>
        </div>
    </section>
</x-layout>

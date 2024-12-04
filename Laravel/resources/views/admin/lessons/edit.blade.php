<x-layout>
    <section class="bg-gray-50 dark:bg-gray-900 py-10 px-4 sm:px-6 lg:px-8 mt-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 text-center">
                Edit Lesson "{{ $lesson->title }}" for Course "{{ $course->name }}"
            </h1>

            {{-- Success or Error Message --}}
            @if(session('success'))
                <div class="mb-4 text-green-500 text-sm">{{ session('success') }}</div>
            @elseif(session('error'))
                <div class="mb-4 text-red-500 text-sm">{{ session('error') }}</div>
            @endif

            <form action="{{ route('admin.lessons.update', [$course->id, $lesson->id]) }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8 space-y-6">
                @csrf
                @method('PUT')

                {{-- Lesson Title --}}
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 dark:text-gray-300 font-medium">Lesson Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $lesson->title) }}" required
                        class="mt-2 block w-full border-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none py-2 px-4">
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Lesson Content --}}
                <div class="mb-4">
                    <label for="content" class="block text-gray-700 dark:text-gray-300 font-medium">Lesson Content</label>
                    <textarea name="content" id="content" rows="4"
                        class="mt-2 block w-full border-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none py-2 px-4">{{ old('content', $lesson->content) }}</textarea>
                    @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Video --}}
                <div class="mb-4">
                    <label for="video" class="block text-gray-700 dark:text-gray-300 font-medium">Upload New Video</label>
                    <input type="file" name="video" id="video" accept="video/*"
                        class="mt-2 block w-full border-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none py-2 px-4">
                    @if($lesson->video_path)
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Current Video: <a href="{{ asset('storage/' . $lesson->video_path) }}" target="_blank" class="text-blue-500 underline">View</a>
                        </p>
                    @endif
                    @error('video') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                    @if($lesson->images)
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Current Images:</p>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach($lesson->images as $image)
                            <li>{{ $image }}</li> <!-- Or display the image itself, based on your needs -->
                        @endforeach
                    </ul>
                @endif

                @if($lesson->files)
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Current Files:</p>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach($lesson->files as $file)
                            <li>{{ $file }}</li> <!-- Or display the file details -->
                        @endforeach
                    </ul>
                @endif


                {{-- Order --}}
                <div class="mb-4">
                    <label for="order" class="block text-gray-700 dark:text-gray-300 font-medium">Lesson Order</label>
                    <input type="number" name="order" id="order" value="{{ old('order', $lesson->order) }}"
                        class="mt-2 block w-full border-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none py-2 px-4">
                    @error('order') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="w-full bg-blue-500 text-white py-3 rounded-lg text-lg font-semibold hover:bg-blue-600 transition duration-300">
                    Save Changes
                </button>
            </form>
        </div>
    </section>
</x-layout>

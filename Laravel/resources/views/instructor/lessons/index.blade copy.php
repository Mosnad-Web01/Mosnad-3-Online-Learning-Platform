<x-layout>
    <section class="bg-gray-50 dark:bg-gray-900 py-10 mt-10">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Lessons for {{ $course->course_name }}</h1>
                <a href="{{ route('instructor.lessons.create', $course->id) }}"
                   class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    Add New Lesson
                </a>
            </div>

            @if (session('success'))
                <div class="mb-4 text-green-600 bg-green-100 border border-green-300 p-4 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($lessons as $lesson)
                    <div class="bg-white rounded-lg shadow dark:bg-gray-800">
                        <div class="p-4">
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white">{{ $lesson->title }}</h2>
                            <p class="text-sm text-gray-700 dark:text-gray-300">{{ Str::limit($lesson->content, 100) }}</p>

                            {{-- عرض الفيديو --}}
                            @if ($lesson->video_path)
                                <p class="mt-2">
                                    <button class="text-blue-500 view-video" data-video-url="{{ asset('storage/' . $lesson->video_path) }}">View Video</button>
                                </p>
                            @else
                                <p class="text-sm text-gray-500 dark:text-gray-400">No video uploaded</p>
                            @endif
                            {{-- عرض الصور --}}
                            @if ($lesson->images && is_array(json_decode($lesson->images, true)))
                                <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">Images:</p>
                                @foreach (json_decode($lesson->images, true) as $image)
                                    <a href="{{ asset('storage/' . ($image['path'] ?? '')) }}" target="_blank" class="block mt-1 text-blue-500">
                                        View Image
                                    </a>
                                @endforeach
                            @else
                                <p class="text-sm text-gray-500 dark:text-gray-400">No images uploaded</p>
                            @endif

                            {{-- عرض الملفات --}}
                            @if ($lesson->files && is_array(json_decode($lesson->files, true)))
                                <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">Files:</p>
                                @foreach (json_decode($lesson->files, true) as $file)
                                    <a href="{{ asset('storage/' . ($file['path'] ?? '')) }}" target="_blank" class="block mt-1 text-blue-500">
                                        Download File
                                    </a>
                                @endforeach
                            @else
                                <p class="text-sm text-gray-500 dark:text-gray-400">No files uploaded</p>
                            @endif


                            <div class="flex mt-4">
                                <a href="{{ route('instructor.lessons.edit', [$course->id, $lesson->id]) }}"
                                   class="text-blue-500 hover:text-blue-600 mr-2">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('instructor.lessons.destroy', [$course->id, $lesson->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center">
                        <p class="text-gray-500 dark:text-gray-400">No lessons found. Add a new lesson to get started!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.view-video').forEach(button => {
            button.addEventListener('click', function () {
                const videoUrl = button.getAttribute('data-video-url');
                Swal.fire({
                    title: 'Lesson Video',
                    html: `<video controls style="width: 100%;"><source src="${videoUrl}" type="video/mp4">Your browser does not support the video tag.</video>`,
                    width: '80%',
                    heightAuto: true,
                    showCloseButton: true,
                    showConfirmButton: false
                });
            });
        });
    </script>
</x-layout>

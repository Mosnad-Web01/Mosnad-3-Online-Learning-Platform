<x-layout>
    <section class="bg-gray-50 dark:bg-gray-900 py-10 ml-72 mt-10">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Lessons for {{ $course->course_name }}</h1>
                <a href="{{ route('instructor.lessons.create', $course->id) }}"
                   class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    Add New Lesson
                </a>
            </div>

            {{-- Success message after creating or updating lesson --}}
            @if (session('success'))
                <div class="mb-4 text-green-600 bg-green-100 border border-green-300 p-4 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error or Success message when deleting a lesson --}}
            @if (session('delete_success'))
                <div class="mb-4 text-red-600 bg-red-100 border border-red-300 p-4 rounded-lg">
                    {{ session('delete_success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($lessons as $lesson)
                    <div class="bg-white rounded-lg shadow dark:bg-gray-800">
                        <div class="p-4">
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white">{{ $lesson->title }}</h2>
                            <p class="text-sm text-gray-700 dark:text-gray-300">{{ Str::limit($lesson->content, 100) }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Video:
                                @if ($lesson->video_url)
                                    <button class="text-blue-500 view-video" data-video-url="{{ asset('storage/' . $lesson->video_url) }}">View Video</button>
                                @else
                                    No video uploaded
                                @endif
                            </p>

                            <div class="flex mt-4">
                                <!-- Edit button with SweetAlert confirmation -->
                                <a href="#" class="text-blue-500 hover:text-blue-600 mr-2 edit-button" data-url="{{ route('instructor.lessons.edit', [$course->id, $lesson->id]) }}">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Delete button with SweetAlert confirmation -->
                                <form action="{{ route('instructor.lessons.destroy', [$course->id, $lesson->id]) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600 delete-button">
                                        <i class="fas fa-trash-alt"></i>
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

    <!-- JavaScript to open SweetAlert2 popup on video view and edit/delete confirmation -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Video view functionality
        document.querySelectorAll('.view-video').forEach(button => {
            button.addEventListener('click', function () {
                const videoUrl = button.getAttribute('data-video-url');
                Swal.fire({
                    title: 'Lesson Video',
                    html: `<video controls style="width: 100%;"><source src="${videoUrl}" type="video/mp4">Your browser does not support the video tag.</video>`,
                    width: '80%',
                    heightAuto: true,
                    padding: '2em',
                    showCloseButton: true,
                    showConfirmButton: false
                });
            });
        });

        // Edit button confirmation using SweetAlert2
        document.querySelectorAll('.edit-button').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault(); // Prevent immediate redirection
                const editUrl = button.getAttribute('data-url');
                Swal.fire({
                    title: 'Are you sure you want to edit this lesson?',
                    text: 'You will be redirected to the edit page.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, edit it!',
                    cancelButtonText: 'No, cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = editUrl; // Redirect to the edit page if confirmed
                    }
                });
            });
        });

        // Delete button confirmation using SweetAlert2
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault(); // Prevent immediate form submission
                const form = button.closest('form');
                Swal.fire({
                    title: 'Are you sure you want to delete this lesson?',
                    text: 'This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit the form if confirmed
                    }
                });
            });
        });
    </script>
</x-layout>

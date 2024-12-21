<x-layout>
    <section class="ml-40 bg-gray-50 dark:bg-gray-900 py-10 mt-10">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">All Courses</h1>
                <a href="{{ route('admin.courses.create') }}"
                   class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    Add New Course
                </a>
            </div>

            @if (session('success'))
                <div class="mb-4 text-green-600 bg-green-100 border border-green-300 p-4 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($courses as $course)
                    <div class="bg-white rounded-lg shadow dark:bg-gray-800">
                        @if ($course->image)
                            <img class="rounded-t-lg w-full h-40 object-cover" src="{{ Storage::url($course->image) }}" alt="{{ $course->course_name }}">
                        @else
                            <div class="bg-gray-300 rounded-t-lg w-full h-40 flex items-center justify-center">
                                <span class="text-gray-500">No Image</span>
                            </div>
                        @endif
                        <div class="p-4">
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white">{{ $course->course_name }}</h2>
                            <p class="text-sm text-gray-700 dark:text-gray-300">{{ $course->description }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Level: {{ $course->level }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Price: ${{ $course->price }}</p>
                            <div class="flex mt-4">
                                <!-- Edit button with blue pen icon -->
                                <a href="{{ route('admin.courses.edit', $course->id) }}"
                                   class="text-blue-500 hover:text-blue-600 mr-2">
                                    <i class="fas fa-edit"></i> <!-- Blue pen icon -->
                                </a>

                                <!-- Delete button with red trash icon -->
                                <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600">
                                        <i class="fas fa-trash-alt"></i> <!-- Red trash icon -->
                                    </button>
                                </form>

                                <!-- Manage lessons button -->
                                <a href="{{ route('admin.lessons.index', $course->id) }}" class="text-green-500 hover:text-green-600">
                                    <i class="fas fa-book"></i> Manage Lessons
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center">
                        <p class="text-gray-500 dark:text-gray-400">No courses found. Start by adding a new course!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Add JavaScript code to implement SweetAlert2 for delete confirmation -->
    <script>
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault(); // Prevent form submission directly

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you really want to delete this course?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit the form if confirmed
                    }
                });
            });
        });
    </script>
</x-layout>

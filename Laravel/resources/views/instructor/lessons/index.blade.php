@php
    // إعداد الكائن الديناميكي باستخدام البيانات القادمة من الكنترولر
    $table = (object) [
        'columns' => [
            ['label' => 'Lesson Title', 'key' => 'title'],
            ['label' => 'Description', 'key' => 'content'],
            ['label' => 'Video', 'key' => 'video_path'], // إضافة عمود الفيديو
            ['label' => 'Images', 'key' => 'images'], // إضافة عمود الصور
            ['label' => 'Files', 'key' => 'files'], // إضافة عمود الملفات
        ],
        'data' => $lessons, // البيانات القادمة من الكنترولر
        'routes' => [
            'edit' => 'instructor.lessons.edit',
            'destroy' => 'instructor.lessons.destroy',
        ],
    ];
@endphp

<x-layout>
    <div class="mt-16 lg:mt-0 flex-grow w-full bg-gray-100 dark:bg-gray-900">
        
    <section class="bg-gray-50 dark:bg-gray-900 py-10 mt-10 lg:ml-[6rem] md:ml-44 sm:ml-10 flex items-center justify-start rtl:justify-end">
    <div class="flex items-center justify-start rtl:justify-end">
                <div class="min-h-screen flex flex-col">
                    <div class="container flex-grow mx-auto px-4">
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

                        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-lg">
                            <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-300">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        @foreach ($table->columns as $column)
                                            <th class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                                {{ $column['label'] }}
                                            </th>
                                        @endforeach
                                        <th class="px-4 py-3 font-medium text-gray-900 dark:text-white text-center">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($table->data as $lesson)
                                        <tr class="border-b dark:border-gray-700">
                                            @foreach ($table->columns as $column)
                                                <td class="px-4 py-3">
                                                    @if ($column['key'] === 'video_path' && $lesson->video_path)
                                                      
                          
                          @if ($lesson->video_path)
                              <a href="{{ Storage::url($lesson->video_path) }}" target="_blank" class="text-blue-500">Watch Video</a>
                          @else
                              <a href="{{ route('lessons.addVideo', $lesson->id) }}" class="text-blue-500">Add Video</a>
                          @endif
                                                        @endif
                                                </td>
                                            @endforeach
                                            <td class="px-4 py-3 flex items-center justify-start space-x-4">
                                                <!-- زر التعديل -->
                                                <a href="javascript:void(0)"
                                                   onclick="confirmEdit('{{ route($table->routes['edit'], ['courseId' => $course->id, 'lessonId' => $lesson->id]) }}')"
                                                   class="text-blue-500 hover:text-blue-600">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <!-- زر الحذف -->
                                                <form action="{{ route($table->routes['destroy'], ['courseId' => $course->id, 'lessonId' => $lesson->id]) }}" method="POST" class="delete-form inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-600">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="{{ count($table->columns) + 1 }}" class="text-center text-gray-500 dark:text-gray-400 py-4">
                                                No lessons found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SweetAlert2 for Delete Confirmation -->
        <script>
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'Do you really want to delete this lesson?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'No, cancel!',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            function confirmEdit(url) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to edit this lesson?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, edit it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            }
        </script>
    </div>
</x-layout>

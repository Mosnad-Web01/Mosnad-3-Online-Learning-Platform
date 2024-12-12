<x-layout>
    <div class="lg:ml-[4rem] mt-16 lg:mt-0 flex-grow w-full bg-gray-100 dark:bg-gray-900">
        <section class="bg-gray-50 dark:bg-gray-900 py-10 mt-10 ml-[6rem] flex items-center justify-start rtl:justify-end">
            <div class="container flex-grow mx-auto px-4">
                <!-- عنوان الصفحة -->
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Manage Students for Instructor: {{ $instructor->name }}</h1>

                @foreach ($instructor->courses as $course)
                    <!-- معلومات الدورة -->
                    <div class="mt-8 bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300">
                            Course: {{ $course->course_name }}
                        </h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $course->description }}
                        </p>

                        <!-- جدول الطلاب -->
                        <div class="overflow-x-auto mt-4">
                            <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-300">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-3 font-medium text-gray-900 dark:text-white">Name</th>
                                        <th class="px-4 py-3 font-medium text-gray-900 dark:text-white">Email</th>
                                        <th class="px-4 py-3 font-medium text-gray-900 dark:text-white">Enrollment Date</th>
                                        <th class="px-4 py-3 font-medium text-gray-900 dark:text-white">Progress</th>
                                        <th class="px-4 py-3 font-medium text-gray-900 dark:text-white text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($course->students as $student)
                                        <tr class="border-b dark:border-gray-700">
                                            <td class="px-4 py-3">{{ $student->name }}</td>
                                            <td class="px-4 py-3">{{ $student->email }}</td>
                                            <td class="px-4 py-3">{{ $student->pivot->enrollment_date }}</td>
                                            <td class="px-4 py-3">{{ $student->pivot->progress }}%</td>
                                            <td class="px-4 py-3 flex items-center justify-start space-x-4">
                                                <!-- زر تحديث التقدم -->
                                                <form action="{{ route('instructor.students.edit', [$course->id, $student->id]) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="number" name="progress" value="{{ $student->pivot->progress }}" min="0" max="100" class="w-16 p-1 text-center border rounded-md">
                                                    <button type="submit" class="ml-2 bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                                        Update
                                                    </button>
                                                </form>

                                              
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-gray-500 dark:text-gray-400 py-4">
                                                No students enrolled in this course.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>

    <!-- SweetAlert2 for Delete Confirmation -->
    <script>
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to remove this student?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, remove!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
</x-layout>

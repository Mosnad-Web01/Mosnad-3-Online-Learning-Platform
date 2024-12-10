
<x-layout>
<div class="lg:ml-[4rem] mt-16 lg:mt-0 flex-grow w-full bg-gray-100 dark:bg-gray-900">

    <section class="bg-gray-50 dark:bg-gray-900 py-10 mt-10 ml-[6rem] flex items-center justify-start rtl:justify-end">
    <div class="flex items-center justify-start rtl:justify-end">
    <div class="min-h-screen flex flex-col">

        <div class="container flex-grow mx-auto px-4">
            <div class="flex justify-between items-center mb-6">
            <x-title :title="'My Courses'" :createRoute="route('instructor.courses.create')" />

            </div>

            @if (session('success'))
                <div class="mb-4 text-green-600 bg-green-100 border border-green-300 p-4 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- جدول عرض الكورسات -->
            <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-lg">
                            <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-300">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-3 font-medium text-gray-900 dark:text-white">Course Name</th>
                                        <th class="px-4 py-3 font-medium text-gray-900 dark:text-white">Description</th>
                                        <th class="px-4 py-3 font-medium text-gray-900 dark:text-white">Level</th>
                                        <th class="px-4 py-3 font-medium text-gray-900 dark:text-white">Price</th>
                                        <th class="px-4 py-3 font-medium text-gray-900 dark:text-white">Actions</th>
                                    </tr>
                                </thead>
                    <tbody>
                        @forelse ($courses as $course)
                        <tr class="border-b dark:border-gray-700">
    <x-clickable-cell :route="route('courses.show', $course->id)">
        {{ $course->course_name }}
    </x-clickable-cell>
    <x-clickable-cell :route="route('courses.show', $course->id)">
        {{ $course->description }}
    </x-clickable-cell>
    <x-clickable-cell :route="route('courses.show', $course->id)">
        {{ $course->level }}
    </x-clickable-cell>
    <x-clickable-cell :route="route('courses.show', $course->id)">
        ${{ $course->price }}
    </x-clickable-cell>
    <td class="px-4 py-3 flex items-center justify-start space-x-4">
        <!-- زر التعديل -->
        <a href="javascript:void(0)"
           onclick="confirmEdit('{{ route('instructor.courses.edit', $course->id) }}')"
           class="text-blue-500 hover:text-blue-600">
            <i class="fas fa-edit"></i>
        </a>

        <!-- زر الحذف -->
        <form action="{{ route('instructor.courses.destroy', $course->id) }}" method="POST" class="delete-form inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-500 hover:text-red-600">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>

        <!-- زر إدارة الدروس -->
        <a href="{{ route('instructor.lessons.index', $course->id) }}" class="text-green-500 hover:text-green-600">
            <i class="fas fa-book"></i> Manage Lessons
        </a>
    </td>
</tr>

                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-500 dark:text-gray-400 py-4">
                                    No courses found. Start by adding a new course!
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
            form.addEventListener('submit', function (e) {
                e.preventDefault();
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
                        form.submit();
                    }
                });
            });
        });

        function confirmEdit(url) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to edit this course?',
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

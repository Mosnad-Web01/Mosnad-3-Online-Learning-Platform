<x-layout>
    <div class="lg:ml-[4rem] mt-16 lg:mt-0 flex-grow w-full bg-gray-100 dark:bg-gray-900">
        <section class="bg-gray-50 dark:bg-gray-900 py-10 mt-10 ml-[6rem] flex items-center justify-start rtl:justify-end">
            <div class="min-h-screen flex flex-col w-full">
                <div class="container flex-grow mx-auto px-4">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Courses and Reviews</h1>
                    </div>

                    <div class="overflow-hidden bg-white dark:bg-gray-800 shadow rounded-lg w-full">
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-300">
                            <thead class="bg-gray-100 dark:bg-gray-700">
    <tr>
        <th class="px-4 py-3 font-medium text-gray-900 dark:text-white">Course Name</th>
        <th class="px-4 py-3 font-medium text-gray-900 dark:text-white">Total Reviews</th>
        <th class="px-4 py-3 font-medium text-gray-900 dark:text-white">Average Rating</th>
        <th class="px-4 py-3 font-medium text-gray-900 dark:text-white">Actions</th>
    </tr>
</thead>
<tbody>
    @foreach ($courses as $course)
    <tr class="border-b dark:border-gray-700">
        <td class="px-4 py-3">{{ $course->course_name }}</td>
        <td class="px-4 py-3">{{ $course->reviews_count }}</td> <!-- عدد المراجعات -->
        <td class="px-4 py-3">
            {{ $course->reviews->avg('course_rating') ?? 'No Ratings Yet' }} <!-- متوسط التقييم -->
        </td>
        <td class="px-4 py-3 flex items-center justify-start space-x-4">
            <button onclick="toggleReviews({{ $course->id }})" class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600">
                View Reviews
            </button>
        </td>
    </tr>
    <x-reviews :course="$course" />
    @endforeach
</tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        function toggleReviews(courseId) {
            const reviewsRow = document.getElementById('reviews-' + courseId);
            reviewsRow.style.display = reviewsRow.style.display === 'none' ? 'table-row' : 'none';
        }
    </script>
</x-layout>

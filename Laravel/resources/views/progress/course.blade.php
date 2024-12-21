<x-layout>
    <main class="bg-white dark:bg-gray-900 text-black dark:text-white min-h-screen w-full">
        <section class="bg-gray-50 dark:bg-gray-900 py-10 mt-10 ml-[6rem] flex items-center justify-start rtl:justify-end">
            <div class="flex items-center justify-start rtl:justify-end">
                <div class="min-h-screen flex flex-col">
                    <div class="container flex-grow mx-auto px-4">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Course Progress Statistics</h2>
                        @if($lessonProgress->isNotEmpty())
                            <h3 class="mt-4 text-xl font-medium text-gray-700 dark:text-gray-300">
                                Instructor: {{ $lessonProgress->first()->lesson->course->instructor->name }} |
                                Course: {{ $lessonProgress->first()->lesson->course->course_name }}
                            </h3>

                            <h3 class="mt-4 text-xl font-medium text-gray-700 dark:text-gray-300">Progress Details:</h3>

                            <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-lg mt-6">
                                <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-300">
                                    <thead class="bg-gray-100 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-4 py-3 font-medium text-gray-900 dark:text-white">Student Name</th>
                                            <th class="px-4 py-3 font-medium text-gray-900 dark:text-white">Completed Lessons</th>
                                            <th class="px-4 py-3 font-medium text-gray-900 dark:text-white">Total Time Spent (Minutes)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($lessonProgress as $progress)
                                            <tr class="border-b dark:border-gray-700">
                                                @if($progress->user && $progress->lesson) <!-- تحقق من وجود user و lesson -->
                                                    <td class="px-4 py-3">{{ $progress->user->name }}</td> <!-- اسم الطالب -->
                                                    <td class="px-4 py-3">{{ $progress->lesson->title }}</td> <!-- عنوان الدرس -->
                                                    <td class="px-4 py-3">
                                                        {{ secondsToHumanReadable($progress->total_duration_seconds ?? 0) }}</td> <!-- الوقت المستغرق -->
                                                @else
                                                    <td class="px-4 py-3" colspan="3">No data available for {{ $progress->user->name }}</td> <!-- عرض اسم الطالب في حالة عدم وجود بيانات -->
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination Links -->
                            <div class="mt-4">
                                {{ $lessonProgress->links() }}
                            </div>
                        @else
                            <p class="text-gray-700 dark:text-gray-300">No progress data available for this student.</p>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-layout>

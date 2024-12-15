<x-layout>
    <div class="lg:ml-[4rem] mt-16 lg:mt-0 flex-grow w-full bg-gray-100 dark:bg-gray-900">
        <section class="bg-gray-50 dark:bg-gray-900 py-10 mt-10 ml-[6rem] flex items-center justify-start rtl:justify-end">
            <div class="container flex-grow mx-auto px-4">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">Manage All Instructors and Their Students</h1>

                @if(isset($instructor))
                    <!-- عرض بيانات المعلم الحالي مع الدورات والطلاب -->
                    <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300">
                        Instructor: {{ $instructor->name }}
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $instructor->email }}</p>
                @endif

                @foreach ($instructors as $instructor)
                    <div class="mt-8 bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300">
                            Instructor: {{ $instructor->name }}
                        </h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $instructor->email }}</p>

                        @foreach ($instructor->courses as $course)
                            <div class="mt-6 bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow">
                                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">
                                    Course: {{ $course->course_name }}
                                </h3>

                                <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-300 mt-4">
                                    <thead class="bg-gray-200 dark:bg-gray-600">
                                        <tr>
                                            <th class="px-4 py-2">Student Name</th>
                                            <th class="px-4 py-2">Email</th>
                                            <th class="px-4 py-2">Enrollment Date</th>
                                            <th class="px-4 py-2">Progress</th>
                                            <th class="px-4 py-3 font-medium text-gray-900 dark:text-white">Action</th> <!-- إضافة عمود لـ Action -->

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($course->students as $student)
                                            <tr class="border-b dark:border-gray-600">
                                                <td class="px-4 py-2">{{ $student->name }}</td>
                                                <td class="px-4 py-2">{{ $student->email }}</td>
                                                <td class="px-4 py-2">{{ $student->pivot->enrollment_date }}</td>
                                                <td class="px-4 py-2">{{ $student->pivot->progress }}%</td>
                                                <td class="px-4 py-3">
                                                <!-- زر للانتقال إلى صفحة تفاصيل الدورة -->
                                                <a href="{{ route('progress.course', ['courseId' => $course->id, 'studentId' => $student->id]) }}" 
                                                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">View Details</a>
                                            </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </section>
    </div>
</x-layout>

@php
    // إعداد الكائن الديناميكي باستخدام البيانات القادمة من الكنترولر
    $table = (object) [
        'columns' => [
            ['label' => 'Course Name', 'key' => 'course_name'],
            ['label' => 'Description', 'key' => 'description'],
            ['label' => 'Level', 'key' => 'level'],
            ['label' => 'Progress', 'key' => 'progress'],
            ['label' => 'Actions', 'key' => 'actions'],
        ],
        'data' => $enrollments, // استخدام البيانات القادمة من الكنترولر
    ];
@endphp

<x-layout>
    <div class="lg:ml-[4rem] mt-16 lg:mt-0 flex-grow w-full bg-gray-100 dark:bg-gray-900">

        <section class="bg-gray-50 dark:bg-gray-900 py-10 mt-10 ml-[6rem] flex items-center justify-start rtl:justify-end">
            <div class="flex items-center justify-start rtl:justify-end">
                <div class="min-h-screen flex flex-col">

                    <div class="container flex-grow mx-auto px-4">
                        <div class="flex justify-between items-center mb-6">
                            <x-title :title="'My Enrolled Courses'" />

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
            </tr>
        </thead>
        <tbody>
            @forelse ($table->data as $row)
                <tr class="border-b dark:border-gray-700">
                    @foreach ($table->columns as $column)
                        @if ($column['key'] === 'actions')
                            <td class="px-4 py-3 text-center flex items-center justify-start space-x-4">
                                <a href="{{ route('student.course.lessons', $row->course_id) }}" class="text-green-500 hover:text-green-600">
                                    <i class="fas fa-book"></i> View Lessons
                                </a>
                                <a href="{{ route('student.course.progress', $row->course_id) }}" class="text-blue-500 hover:text-blue-600">
                                    <i class="fas fa-chart-line"></i> View Progress
                                </a>
                            </td>
                        @else
                            <td class="px-4 py-3">
                                @if ($column['key'] === 'progress')
                                    {!! $row->progress . '%' !!}
                                @else
                                    {!! $row->{$column['key']} ?? '-' !!}
                                @endif
                            </td>
                        @endif
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($table->columns) }}" class="text-center text-gray-500 dark:text-gray-400 py-4">
                        No enrolled courses found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</x-layout>

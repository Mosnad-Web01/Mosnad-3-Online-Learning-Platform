<div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-lg">
    <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-300">
        <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
                @foreach ($columns as $column)
                    <th class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                        {{ $column['label'] }}
                    </th>
                @endforeach
                <!-- إضافة عمود للأزرار -->
                <th class="px-4 py-3 font-medium text-gray-900 dark:text-white text-center">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $row)
                <tr class="border-b dark:border-gray-700">
                    @foreach ($columns as $column)
                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                        <x-clickable-cell :route="route('courses.show', $course->id)">

                            {!! $row[$column['key']] ?? '-' !!}

</x-clickable-cell>
                        </td>
                    @endforeach
                    <!-- إضافة الأزرار -->
                    <td class="px-4 py-3 flex items-center justify-start space-x-4">
                        <!-- زر التعديل -->
                        <a href="javascript:void(0)"
                            onclick="confirmEdit('{{ route($routes['edit'], $row['id']) }}')"
                            class="text-blue-500 hover:text-blue-600">
                            <i class="fas fa-edit"></i>
                        </a>

                        <!-- زر الحذف -->
                        <form action="{{ route($routes['destroy'], $row['id']) }}" method="POST" class="delete-form inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-600">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>

                        <!-- زر إدارة الدروس -->
                        <a href="{{ route($routes['lessons'], $row['id']) }}" class="text-green-500 hover:text-green-600">
                            <i class="fas fa-book"></i> Manage Lessons
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($columns) + 1 }}" class="text-center text-gray-500 dark:text-gray-400 py-4">
                        No data found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

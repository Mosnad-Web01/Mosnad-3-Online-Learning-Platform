@props(['course'])

<tr id="reviews-{{ $course->id }}" style="display: none;">
    <td colspan="3" class="bg-gray-50 dark:bg-gray-800 px-4 py-3">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-300">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 font-medium text-gray-900 dark:text-white">Student</th>
                        <th class="px-4 py-3 font-medium text-gray-900 dark:text-white">Course Rating</th>
                        <th class="px-4 py-3 font-medium text-gray-900 dark:text-white">Instructor Rating</th>
                        <th class="px-4 py-3 font-medium text-gray-900 dark:text-white">Review</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($course->reviews as $review)
                    <tr class="border-b dark:border-gray-700">
                        <td class="px-4 py-3">{{ $review->student->name ?? 'Unknown Student' }}</td>
                        <td class="px-4 py-3">
                            <div class="flex text-yellow-400">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $review->course_rating)
                                        <span>&#9733;</span> <!-- نجمة ممتلئة -->
                                    @else
                                        <span class="text-gray-400">&#9734;</span> <!-- نجمة فارغة -->
                                    @endif
                                @endfor
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex text-yellow-400">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $review->instructor_rating)
                                        <span>&#9733;</span>
                                    @else
                                        <span class="text-gray-400">&#9734;</span>
                                    @endif
                                @endfor
                            </div>
                        </td>
                        <td class="px-4 py-3">{{ $review->review_text ?? 'No review text available' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </td>
</tr>
